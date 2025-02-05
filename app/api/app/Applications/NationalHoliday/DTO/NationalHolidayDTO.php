<?php

namespace App\Applications\NationalHoliday\DTO;

use App\Applications\NationalHoliday\Model\NationalHoliday;
use Illuminate\Http\Request;

class NationalHolidayDTO
{
    public string $date;
    public string $country;
    public int $year;
    public int $leave_type_id;
    public int $id;

    public function __construct(
        string $date,
        string $country,
        int $year,
        int $leave_type_id,
        int $id = 0,
    ) {
        $this->date = $date;
        $this->country = $country;
        $this->year = $year;
        $this->leave_type_id = $leave_type_id;
        $this->id = $id;
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('date'),
            $request->input('country'),
            $request->input('year'),
            $request->input('leave_type_id'),
            $request->input('id', 0),
        );
    }

    public static function fromRequestForCreate(Request $request): self
    {
        return new self(
            $request->input('date'),
            $request->input('country'),
            $request->input('year'),
            leave_type_id: 5,
            id: 0,
        );
    }

    public static function fromModel(NationalHoliday $leaveType): self
    {
        return new self(
            $leaveType->date,
            $leaveType->country,
            $leaveType->year,
            $leaveType->leave_type_id,
            $leaveType->id,

        );
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'name' => $this->date,
            'slug' => $this->country,
            'color' => $this->year,
            'is_paid' => $this->leave_type_id,
            'id' => $this->id,
        ];
    }

    public static function fromCollection(iterable $leaveTypes): array
    {
        return array_map(function (NationalHoliday $leaveType) {
            return self::fromModel($leaveType);
        }, $leaveTypes->all());
    }
}
