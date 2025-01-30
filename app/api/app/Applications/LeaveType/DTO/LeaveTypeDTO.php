<?php

namespace App\Applications\LeaveType\DTO;

use App\Applications\LeaveType\Model\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeDTO
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

    public static function fromModel(LeaveType $leaveType): self
    {
        return new self(
            $leaveType->name,
            $leaveType->slug,
            (bool) $leaveType->is_paid,

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

    public static function fromCollection(iterable $leaveTypes): array
    {
        return array_map(function (LeaveType $leaveType) {
            return self::fromModel($leaveType);
        }, $leaveTypes->all());
    }
}
