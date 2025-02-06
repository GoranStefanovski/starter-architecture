<?php

namespace App\Applications\LeaveRequest\Repositories;

use App\Applications\User\Model\User;
use App\Applications\LeaveRequest\DTO\LeaveRequestDTO;
use App\Applications\LeaveRequest\Mail\{
    LeaveRequestNotification,
    LeaveRequestNotificationUpdate,
    LeaveRequestConfirmation,
    LeaveRequestDeclining
};
use App\Applications\Pagination\StarterPaginator;
use App\Applications\LeaveRequest\Model\LeaveRequest;
use App\Applications\NationalHoliday\Model\NationalHoliday;
use Illuminate\Support\Facades\{Mail, Auth};
use DateTime, DateInterval, DatePeriod;

/**
 * @property LeaveRequest $leaveRequest
 * @property User $user
 */
class LeaveRequestRepository implements LeaveRequestRepositoryInterface
{
    public function __construct(
        LeaveRequest $leaveRequest,
        User $user
    ) {
        $this->leaveRequest = $leaveRequest;
        $this->user = $user;
    }

    private const COLUMNS_MAP = [
        'leave_type_id' => 'leave_requests.leave_type_id',
        'request_to' => 'leave_requests.request_to',
        'status' => 'leave_requests.is_confirmed',
        'start_date' => 'leave_requests.start_date',
        'end_date' => 'leave_requests.end_date'
    ];

    // Get all leaveRequests
    public function getAll(): array
    {
        return LeaveRequestDTO::fromCollection($this->leaveRequest::all());
    }

    public function getApproved(): array
    {
        $query = $this->leaveRequest->with(['user', 'leaveType']);
        
        $query->where('is_confirmed', '=', 2);

        return $query->whereNull('deleted_at')->get()->toArray();
    }

    public function getPending(): array
    {
        $query = $this->leaveRequest->with(['user', 'leaveType']);
        
        $user = Auth::user();
        $query->where('request_to', '=', $user->id);

        $query->where('is_confirmed', '=', 0);

        return $query->whereNull('deleted_at')->get()->toArray();
    }
    // Get Leave Request by Id
    public function get($id): LeaveRequest
    {
        return $this->leaveRequest::findOrFail($id);
    }

    // Create a new request
    public function create(LeaveRequestDTO $leaveRequestDTO): LeaveRequest
    {
        $leaveRequest = $this->leaveRequest->create($leaveRequestDTO->toArray());
        if ($leaveRequest->leave_type_id == 6) {
            $this->confirm($leaveRequest->id, $leaveRequestDTO, 2);
        } else {
            $this->sendRequestEmail($leaveRequest, false);
        }

        return $leaveRequest;
    }
    // Edit a request
    public function update(int $leaveRequestId, LeaveRequestDTO $leaveRequestData): LeaveRequest
    {
        $leaveRequest = $this->get($leaveRequestId);
        $leaveRequestData->is_confirmed = 0;
        $leaveRequest->update($leaveRequestData->toArray());
        $this->sendRequestEmail($leaveRequest, true);
        return $leaveRequest;
    }
    // Confirm or deny a request
    public function confirm(int $leaveRequestId, LeaveRequestDTO $leaveRequestData, int $isConfirmed): LeaveRequest
    {
        $leaveRequest = $this->get($leaveRequestId);
        $leaveRequest->update([
            ...$leaveRequestData->toArray(),
            'is_confirmed' => $isConfirmed
        ]);

        if ($isConfirmed == 2 && $leaveRequest->user && $leaveRequestData->leave_type_id == 3) {
            $this->deductPaidLeaves($leaveRequest->user, $leaveRequestData);
        }

        $this->sendRequestConfirmationEmail($leaveRequest);
        return $leaveRequest;
    }

    public function delete(int $id)
    {
        return $this->get($id)->delete();
    }

    public function draw($data): StarterPaginator
    {
        $user = Auth::user();
        $query = $this->leaveRequest->with(['user', 'leaveType']);

        if (isset(self::COLUMNS_MAP[$data['column']])) {
            $query->orderBy(self::COLUMNS_MAP[$data['column']], $data['dir']);
        }
        // Search by keyword regardless on user first name last name or email and leave type
        if ($search = $data['search']) {
            $query->where(function ($q) use ($search) {
                $q->where('leave_requests.reason', 'like', "%$search%")
                    ->orWhereHas('user', fn($q) => $q->where('first_name', 'like', "%$search%")
                        ->orWhere('last_name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%"))
                    ->orWhereHas('leaveType', fn($q) => $q->where('name', 'like', "%$search%"));
            });
        }

        $this->applyUserRoleFilter($query, $user, $data['userId'] ?? null);

        return $query->whereNull('deleted_at')->paginate($data['length']);
    }

    private function applyUserRoleFilter($query, $user, $calendarUserId)
    {
        $roleId = $user->getRoleAttribute();

        if ($calendarUserId) {
            $query->where('leave_requests.user_id', $calendarUserId)
                  ->where('leave_requests.is_confirmed', 2);
        } else {
            $query->where('leave_requests.user_id', $user->id);
        }
    }

    private function sendRequestEmail(LeaveRequest $leaveRequest, bool $isUpdate)
    {
        $recipients = $this->getRecipients($leaveRequest);

        $mailClass = $isUpdate ? LeaveRequestNotificationUpdate::class : LeaveRequestNotification::class;
        Mail::to($recipients)->send(new $mailClass($leaveRequest));
    }

    private function sendRequestConfirmationEmail(LeaveRequest $leaveRequest)
    {
        $recipients = $this->getRecipients($leaveRequest);

        $mailClass = match ($leaveRequest->is_confirmed) {
            1 => LeaveRequestDeclining::class,
            2 => LeaveRequestConfirmation::class,
            default => null,
        };

        if ($mailClass) {
            Mail::to($recipients)->send(new $mailClass($leaveRequest));
        }
    }

    private function getRecipients(LeaveRequest $leaveRequest)
    {
        $manager = $this->user->find($leaveRequest->request_to);
        $requestedUser = $leaveRequest->user;

        if ($leaveRequest->is_confirmed == 2) {
            return array_filter([
                $requestedUser?->email,
                ...User::role(User::MANAGER)->pluck('email')->toArray(),
                ...User::role(User::ADMIN)->pluck('email')->toArray()
            ]);
        } else if ($leaveRequest->is_confirmed == 1) {
            return $requestedUser->email;
        } else if ($leaveRequest->is_confirmed == 0) {
            return $manager->email;
        }

        
    }

    private function deductPaidLeaves(User $user, LeaveRequestDTO $leaveRequestData): void
    {
        $startDate = new DateTime($leaveRequestData->start_date);
        $endDate = $leaveRequestData->end_date ? new DateTime($leaveRequestData->end_date) : $startDate;

        $nationalHolidays = NationalHoliday::whereYear('date', $startDate->format('Y'))
            ->where('country', $user->country == 1 ? 'Macedonia' : 'Bulgaria')
            ->pluck('date')
            ->toArray();

        $leaveDays = iterator_count(
            new DatePeriod($startDate, new DateInterval('P1D'), $endDate->modify('+1 day'))
        );

        $leaveDays -= count(array_filter(
            iterator_to_array(new DatePeriod($startDate, new DateInterval('P1D'), $endDate->modify('+1 day'))),
            fn($date) => in_array($date->format('N'), [6, 7]) || in_array($date->format('Y-m-d'), $nationalHolidays)
        ));

        $user->update(['paid_leaves_left' => max(0, $user->paid_leaves_left - $leaveDays)]);
    }
}
