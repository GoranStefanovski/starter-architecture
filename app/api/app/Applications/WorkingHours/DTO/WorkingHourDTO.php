<?php
namespace App\Applications\WorkingHours\DTO;
use App\Applications\WorkingHours\Enum\DayOfWeek;

class WorkingHourDTO
{
    public int $day_of_week;
    public ?string $opens_at; // nullable for closed days
    public ?string $closes_at;
    public bool $is_closed;

    public function __construct(
        int|DayOfWeek $day_of_week,
        ?string $opens_at,
        ?string $closes_at,
        bool $is_closed = false
    ) {
        // Allow passing DayOfWeek enum directly or int
        $this->day_of_week = $day_of_week instanceof DayOfWeek
            ? $day_of_week->value
            : $day_of_week;

        $this->opens_at = $opens_at;
        $this->closes_at = $closes_at;
        $this->is_closed = $is_closed;
    }

    public function toArray(): array
    {
        return [
            'day_of_week' => DayOfWeek::from($this->day_of_week)->label(),
            'opens_at'    => $this->opens_at,
            'closes_at'   => $this->closes_at,
            'is_closed'   => $this->is_closed,
        ];
    }
}

