<?php
namespace App\Applications\WorkingHours\DTO;
use App\Applications\WorkingHours\Enum\DayOfWeek;

class WorkingHourDTO implements \JsonSerializable
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

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    private function timeToObject(?string $time): ?array
    {
        if (!$time) return null;

        [$hours, $minutes] = array_map('intval', explode(':', $time));
        return ['hours' => $hours, 'minutes' => $minutes];
    }

    public static function objectToTime(?array $timeObj): ?string
    {
        if (!is_array($timeObj) || !isset($timeObj['hours'], $timeObj['minutes'])) {
            return null;
        }

        return sprintf('%02d:%02d:00', $timeObj['hours'], $timeObj['minutes']);
    }

    public function toArray(): array
    {
        return [
            'day_of_week' => DayOfWeek::from($this->day_of_week)->label(),
            'opens_at'    => $this->timeToObject($this->opens_at),
            'closes_at'   => $this->timeToObject($this->closes_at),
            'is_closed'   => $this->is_closed,
        ];
    }

    public static function fromArray(array $data): self
    {
        $dayOfWeek = $data['day_of_week'];

        // Convert string like "Monday" to enum
        if (is_string($dayOfWeek)) {
            $dayOfWeek = DayOfWeek::fromName($dayOfWeek);
        }


        return new self(
            $dayOfWeek,
            self::objectToTime($data['opens_at']) ?? null,
            self::objectToTime($data['closes_at']) ?? null,
            (bool) $data['is_closed']
        );
    }
}

