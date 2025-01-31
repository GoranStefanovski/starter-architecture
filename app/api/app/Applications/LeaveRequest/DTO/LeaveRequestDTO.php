<?php

namespace App\Applications\LeaveRequest\DTO;

use App\Applications\LeaveRequest\Model\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestDTO
{
    public string $name;
    public string $slug;
    public bool $is_paid;


    public function __construct(
        string $name,
        string $slug,
        bool $is_paid = false,
    ) {
        $this->name = $name;
        $this->slug = $slug;
        $this->is_paid = $is_paid;
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('slug'),
            (bool) $request->input('is_paid', false),
        );
    }

    public static function fromRequestForCreate(Request $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('slug'),
            is_paid: false
        );
    }

    public static function fromModel(LeaveRequest $leaveRequest): self
    {
        return new self(
            $leaveRequest->name,
            $leaveRequest->slug,
            (bool) $leaveRequest->is_paid,

        );
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'is_disabled' => $this->is_paid,
        ];
    }

    public static function fromCollection(iterable $leaveRequests): array
    {
        return array_map(function (LeaveRequest $leaveRequest) {
            return self::fromModel($leaveRequest);
        }, $leaveRequests->all());
    }
}
