<?php

namespace App\Applications\WorkingHours\Repositories;

use App\Applications\WorkingHours\DTO\WorkingHourDTO;

interface WorkingHoursRepositoryInterface
{
    /**
     * Create or update working hours for a venue.
     *
     * @param int $venueId
     * @param array<int, WorkingHourDTO> $workingHours
     * @return void
     */
    public function upsertForVenue(int $venueId, array $workingHours): void;
}
