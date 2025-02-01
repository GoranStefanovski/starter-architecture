<?php

namespace App\Applications\LeaveRequest\Repositories;

use App\Applications\User\Model\User;
use App\Applications\LeaveRequest\DTO\LeaveRequestDTO;
use App\Applications\LeaveRequest\Mail\LeaveRequestNotification;
use App\Applications\LeaveRequest\Mail\LeaveRequestNotificationUpdate;
use App\Applications\LeaveRequest\Mail\LeaveRequestConfirmation;
use App\Applications\LeaveRequest\Mail\LeaveRequestDeclining;
use App\Applications\Pagination\StarterPaginator;
use App\Applications\LeaveRequest\Model\LeaveRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

/**
 * @property LeaveRequest $leaveRequest
 */
class LeaveRequestRepository implements LeaveRequestRepositoryInterface
{
    public function __construct(
        LeaveRequest $leaveRequest,
    ) {
        $this->leaveRequest = $leaveRequest;
    }

    private const COLUMNS_MAP = [
        'first_name' => 'leave_requests.first_name',
        'last_name' => 'leave_requests.last_name',
        'email' => 'leave_requests.email',
        'status' => 'leave_requests.is_disabled'
    ];

    public function getAll(): array
    {
        $leaveRequests = $this->leaveRequest::all();
        return LeaveRequestDTO::fromCollection($leaveRequests);
    }

    public function get($id): LeaveRequest
    {
        return $this->leaveRequest::findOrFail($id);
    }

    public function create(LeaveRequestDTO $leaveRequestDTO): LeaveRequest
    {
        $attributes = $leaveRequestDTO->toArray();
        $leaveRequest = new LeaveRequest($attributes);
        $leaveRequest->save();
        $this->sendRequestEmail($leaveRequest, false);
        return $leaveRequest;
    }

    public function update(int $leaveRequestId, LeaveRequestDTO $leaveRequestData): LeaveRequest
    {
        $leaveRequest = $this->leaveRequest->findOrFail($leaveRequestId);
        $attributes = $leaveRequestData->toArray();
        $leaveRequest->update($attributes);
        $this->sendRequestEmail($leaveRequest, true);
        return $leaveRequest;
    }

    public function confirm(int $leaveRequestId, LeaveRequestDTO $leaveRequestData, int $isConfirmed): LeaveRequest
    {
        
        $leaveRequest = $this->leaveRequest->findOrFail($leaveRequestId);
        $attributes = $leaveRequestData->toArray();
        $attributes['is_confirmed'] = $isConfirmed;
        $leaveRequest->update($attributes);

        $this->sendRequestConfirmationEmail($leaveRequestData);

        return $leaveRequest;
    }

    public function delete(int $id)
    {
        return $this->leaveRequest::findOrFail($id)->delete();
    }

    public function draw($data): StarterPaginator
    {
        $user = Auth::user();
        $query = $this->leaveRequest->query();

        if (array_key_exists($data['column'], self::COLUMNS_MAP)) {
            $query->orderBy(self::COLUMNS_MAP[$data['column']], $data['dir']);
        }

        $search = $data['search'];
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('leave_requests.reason', 'like', '%' . $search . '%');
            });
        }

        $query->whereNull('deleted_at');

        return $query->paginate($data['length']);
    }

    public function sendRequestEmail($leaveRequestData, int $isUpdate) {
        $manager = User::find($leaveRequestData['request_to']);

        $recipients = [];

        if ($manager && $manager->email) {
            $recipients[] = $manager->email;
        }

        $adminUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->pluck('email')->toArray();

        $recipients = array_merge($recipients, $adminUsers);
        if (!$isUpdate) {
            Mail::to($recipients)->send(new LeaveRequestNotification($leaveRequestData));
        } else {
            Mail::to($recipients)->send(new LeaveRequestNotificationUpdate($leaveRequestData));
        }
    }

    public function sendRequestConfirmationEmail($leaveRequestData) {
        $requestedLeaveUser = User::find($leaveRequestData->user_id);

        $manager = User::find($leaveRequestData->request_to);

        $adminUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->pluck('email')->toArray();

        $recipients = [];

        if ($requestedLeaveUser && $requestedLeaveUser->email) {
            $recipients[] = $requestedLeaveUser->email;
        }

        if ($manager && $manager->email) {
            $recipients[] = $manager->email;
        }

        if ($adminUsers) {
            $recipients = array_merge($recipients, $adminUsers);
        }

        $leaveRequest = LeaveRequest::findOrFail($leaveRequestData->id);

        if (!empty($recipients)) {
            if ($leaveRequest->is_confirmed == 1) {
                Mail::to($recipients)->send(new LeaveRequestDeclining($leaveRequest));
            } else if ($leaveRequest->is_confirmed == 2) {
                Mail::to($recipients)->send(new LeaveRequestConfirmation($leaveRequest));
            }
        }
    }
}
