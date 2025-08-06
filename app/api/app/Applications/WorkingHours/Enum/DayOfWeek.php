<?php
namespace App\Applications\WorkingHours\Enum;


enum DayOfWeek: int
{
    case Monday = 0;
    case Tuesday = 1;
    case Wednesday = 2;
    case Thursday = 3;
    case Friday = 4;
    case Saturday = 5;
    case Sunday = 6;

    public function label(): string
    {
        return match ($this) {
            self::Monday => 'Monday',
            self::Tuesday => 'Tuesday',
            self::Wednesday => 'Wednesday',
            self::Thursday => 'Thursday',
            self::Friday => 'Friday',
            self::Saturday => 'Saturday',
            self::Sunday => 'Sunday',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn ($day) => ['value' => $day->value, 'label' => $day->label()],
            self::cases()
        );
    }

    public static function fromName(string $name): self
    {
        return match (strtolower($name)) {
            'monday' => self::Monday,
            'tuesday' => self::Tuesday,
            'wednesday' => self::Wednesday,
            'thursday' => self::Thursday,
            'friday' => self::Friday,
            'saturday' => self::Saturday,
            'sunday' => self::Sunday,
            default => throw new \InvalidArgumentException("Invalid day name: $name"),
        };
    }
}
