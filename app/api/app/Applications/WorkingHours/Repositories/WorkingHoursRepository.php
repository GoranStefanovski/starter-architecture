<?php

namespace App\Applications\WorkingHours\Repositories;

use App\Applications\WorkingHours\Model\WorkingHour;
use App\Applications\WorkingHours\DTO\WorkingHourDTO;

class WorkingHoursRepository implements WorkingHoursRepositoryInterface
{
    public function upsertForVenue(int $venueId, array $workingHours): void
    {
        $data = array_map(function ($hour) use ($venueId) {
            return [
                'venue_id' => $venueId,
                'day_of_week' => $hour->day_of_week,
                'opens_at' => $hour->opens_at,
                'closes_at' => $hour->closes_at,
                'is_closed' => $hour->is_closed,
            ];
        }, $workingHours);
        WorkingHour::upsert(
            $data,
            ['venue_id', 'day_of_week'], // unique constraints
            ['opens_at', 'closes_at', 'is_closed'] // fields to update
        );
    }
}
