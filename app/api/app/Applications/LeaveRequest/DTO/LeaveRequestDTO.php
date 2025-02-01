<?php

namespace App\Applications\LeaveRequest\DTO;

use App\Applications\LeaveRequest\Model\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestDTO
{
    public int $user_id;
    public int $leave_type_id;
    public string $start_date;
    public ?string $end_date;
    public ?string $reason;
    public int $request_to;
    public int $confirmed_by;
    public int $is_confirmed;
    public int $status;
    public int $id;

    public function __construct(
        int $user_id = 0,
        int $leave_type_id = 0,
        string $start_date,
        ?string $end_date,
        ?string $reason = '',
        int $request_to,
        int $confirmed_by,
        int $is_confirmed,
        int $status = 0,
        int $id = 0
    ) {
        $this->user_id = $user_id;
        $this->leave_type_id = $leave_type_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->reason = $reason;
        $this->request_to = $request_to;
        $this->confirmed_by = $confirmed_by;
        $this->is_confirmed = $is_confirmed;
        $this->status = $status;
        $this->id = $id;
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('user_id'),
            $request->input('leave_type_id'),
            $request->input('start_date'),
            $request->input('end_date'),
            $request->input('reason', ''),
            $request->input('request_to'),
            $request->input('confirmed_by', 0),
            $request->input('is_confirmed', 0),
            $request->input('status', 0),
            $request->input('id', 0),
        );
    }

    public static function fromRequestForCreate(Request $request): self
    {
        return new self(
            $request->input('user_id'),
            $request->input('leave_type_id'),
            $request->input('start_date'),
            $request->input('end_date'),
            $request->input('reason'),
            $request->input('request_to'),
            confirmed_by: 0,
            is_confirmed: 0,
            status: 0,
            id: 0,
        );
    }

    public static function fromModel(LeaveRequest $leaveRequest): self
    {
        return new self(
            $leaveRequest->user_id,
            $leaveRequest->leave_type_id,
            $leaveRequest->start_date,
            $leaveRequest->end_date,
            $leaveRequest->reason,
            $leaveRequest->request_to,
            $leaveRequest->confirmed_by,
            $leaveRequest->is_confirmed,
            $leaveRequest->status,
            $leaveRequest->id
        );
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'leave_type_id' => $this->leave_type_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'reason' => $this->reason,
            'request_to' => $this->request_to,
            'confirmed_by' => $this->confirmed_by,
            'is_confirmed' => $this->is_confirmed,
            'status' => $this->status,
            'id' => $this->id,
        ];
    }

    public static function fromCollection(iterable $leaveRequests): array
    {
        return array_map(function (LeaveRequest $leaveRequest) {
            return self::fromModel($leaveRequest);
        }, $leaveRequests->all());
    }
}
