<?php

namespace App\Applications\WorkingHours\Services;

interface WorkingHoursServiceInterface
{
    /**
     * Create or update working hours for a venue.
     *
     * @param int $venueId
     * @param array $workingHours
     * @return void
     */
    public function createOrUpdateForVenue(int $venueId, array $workingHours): void;
}
