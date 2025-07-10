<?php

namespace App\Applications\Venue\Repositories;

use App\Applications\Pagination\StarterPaginator;
use App\Applications\User\Model\User;
use App\Applications\Venue\DTO\VenueDTO;
use App\Applications\Venue\Model\Venue;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Http\UploadedFile;

/**
 * Interface VenueRepositoryInterface
 * @package App\Applications\Venue
 */

interface VenueRepositoryInterface
{
    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param integer $id
     * @return Venue
     */
    public function get($id);

    /**
     * @param VenueDTO $venueDTO
     * @return Venue
     */
    public function create(VenueDTO $venueDTO): Venue;

    /**
     * @param int $venueId
     * @param VenueDTO $venueData
     * @return Venue
     */
    public function update(int $venueId, VenueDTO $venueData): Venue;

    /**
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id);

    /**
     * @param array $data
     * @return StarterPaginator
     */
    public function draw(array $data): StarterPaginator;

    /**
     * Clear the avatar collection for a given user.
     *
     * @param Venue $venue
     * @return void
     */
    public function clearVenueAvatars(Venue $venue): void;

    /**
     * Upload a new event_image for a given Event.
     *
     * @param integer $venueId
     * @param UploadedFile $file
     * @param string $imageType
     * @return Venue
     */
    public function uploadVenueImage(int $venueId, UploadedFile $file, string $imageType): Venue;

    /**
     * Upload a new event_image for a given Event.
     *
     * @param integer $venueId
     * @param UploadedFile $file
     * @return Venue
     */
    public function deleteVenueImage(int $venueId, int $imageId): Venue;

    /**
     * Fetch venues for an event based on if the user is an Organizator or Collaborator
     * Organization = all venues
     * Collaborator = only his venues
     *
     * @param User $user
     * @return Collection
     */
    public function getVenuesAvailableForEvent(User $user): Collection;

    /**
     * Fetch venues from the selected city
     * Organization = all venues
     * Collaborator = only his venues
     *
     * @param String $city
     * @param ?int $venue_owner_id
     * @return Collection
     */
    public function getAllVenuesFromCityOrOwner(String $city, ?int $venue_owner_id): array;
}
