<?php

namespace App\Applications\VacationDay\DTO;

use App\Applications\VacationDay\Model\VacationDay;
use Illuminate\Http\Request;

class VacationDayDTO implements \JsonSerializable
{
    public int $id;
    public int $user_id;
    public string $date_from;
    public string $date_to;
    public int $year;
    public int $day_type_id;

    public int $handler_id;
    public ?string $created_at;
    public ?string $updated_at;

    /**
     * Constructor to initialize VacationDayDTO properties.
     */
    public function __construct(
        int $id = 0,
        int $user_id,
        string $date_from,
        string $date_to,
        int $year,
        int $day_type_id,
        int $handler_id,
        ?string $created_at = null,
        ?string $updated_at = null
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->year = $year;
        $this->day_type_id = $day_type_id;
        $this->handler_id = $handler_id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    /**
     * Create a DTO from an HTTP Request.
     */
    public static function fromRequest(array $request): self
    {
        return new self(
             $request['id'],
             $request['user_id'],
             $request['date_from'],
             $request['date_to'],
             $request['year'],
             $request['day_type_id'],
             $request['handler_id'],
        );
    }

    /**
     * Create a DTO for new resource creation.
     */
    public static function fromRequestForCreate(array $request): self
    {
        return new self(
            0,
            $request['user_id'],
            $request['date_from'],
            $request['date_to'],
            $request['year'],
            $request['day_type_id'],
            $request['handler_id'],
        );
    }

    /**
     * Create a DTO from a VacationDay Eloquent model.
     */
    public static function fromModel(VacationDay $vacationDay): self
    {
        return new self(
            id: $vacationDay->id,
            user_id: $vacationDay->user_id,
            date_from: $vacationDay->date_from->toDateString(),
            date_to: $vacationDay->date_to->toDateString(),
            year: $vacationDay->year,
            day_type_id: $vacationDay->day_type_id,
            handler_id: $vacationDay->handler_id,
            created_at: optional($vacationDay->created_at)->toDateTimeString(),
            updated_at: optional($vacationDay->updated_at)->toDateTimeString()
        );
    }

    /**
     * Create an array of DTOs from a collection of VacationDay models.
     */
    public static function fromCollection(iterable $vacationDays): array
    {
        return array_map(function (VacationDay $vacationDay) {
            return self::fromModel($vacationDay);
        }, $vacationDays->all());
    }

    /**
     * Convert DTO to an array.
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'year' => $this->year,
            'day_type_id' => $this->day_type_id,
            'handler_id' => $this->handler_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    /**
     * Implement JsonSerializable for JSON conversion.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
