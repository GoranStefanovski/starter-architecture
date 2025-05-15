<?php

namespace App\Applications\Venue\Services;

use App\Applications\Venue\DTO\VenueDTO;
use App\Applications\Venue\Model\Venue;
use Illuminate\Http\Request;

/**
 * Interface VenueServiceInterface
 * @package App\Applications\Venue
 */

interface VenueServiceInterface
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param integer $id
     * @return VenueDTO
     */
    public function get(int $id): VenueDTO;

    /**
     * @param VenueDTO $venueData
     * @return VenueDTO
     */
    public function create(VenueDTO $venueData): VenueDTO;

    /**
     * @param int $venueId
     * @param VenueDTO $venueData
     * @return VenueDTO
     */
    public function update(int $venueId, VenueDTO $venueData): VenueDTO;

    /**
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id);

    /**
     * @param array $data
     * @return array
     */
    public function draw(array $data): array;

    /**
     * Handle the avatar upload for a venue.
     *
     * @param int $venueId
     * @param Request $request
     * @param Venue $venue
     * @return VenueDTO
     */
    public function uploadAvatar(int $venueId, Request $request, Venue $venue): VenueDTO;
}
