<?php

namespace App\Applications\LeaveRequest\DTO;

use App\Applications\LeaveRequest\Model\LeaveRequest;
use Date;
use Illuminate\Http\Request;

class LeaveRequestDTO
{
    public int $user_id;
    public int $leave_type_id;
    public Date $start_date;
    public ?Date $end_date;
    public string $status;
    public ?string $reason;
    public int $request_to;
    public ?int $approved_by;
    public int $id;

    public function __construct(
        int $user_id = 0,
        int $leave_type_id = 0,
        Date $start_date,
        ?Date $end_date,
        string $status,
        ?string $reason,
        int $request_to,
        int $approved_by,
        int $id = 0
    ) {
        $this->user_id = $user_id;
        $this->leave_type_id = $leave_type_id;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->status = $status;
        $this->reason = $reason;
        $this->request_to = $request_to;
        $this->approved_by = $approved_by;
        $this->id = $id;
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('user_id'),
            $request->input('leave_type_id'),
            $request->input('start_date'),
            $request->input('end_date'),
            $request->input('status'),
            $request->input('reqson'),
            $request->input('request_to'),
            $request->input('approved_by'),
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
            $request->input('status'),
            $request->input('reason'),
            $request->input('request_to'),
            $request->input('approved_by'),
            id: 0,
        );
    }

    public static function fromModel(LeaveRequest $leaveRequest): self
    {
        return new self(
            $leaveRequest->id,
            $leaveRequest->leave_type_id,
            $leaveRequest->start_date,
            $leaveRequest->end_date,
            $leaveRequest->status,
            $leaveRequest->reason,
            $leaveRequest->request_to,
            $leaveRequest->leaveRequest,

        );
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'leave_type_id' => $this->leave_type_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'reason' => $this->reason,
            'request_to' => $this->request_to,
            'approved_by' => $this->approved_by,
        ];
    }

    public static function fromCollection(iterable $leaveRequests): array
    {
        return array_map(function (LeaveRequest $leaveRequest) {
            return self::fromModel($leaveRequest);
        }, $leaveRequests->all());
    }
}
