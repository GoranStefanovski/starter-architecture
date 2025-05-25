<?php

namespace App\Applications\Venue\Services;

use App\Applications\Venue\Model\Venue;
use App\Applications\Venue\DTO\VenueDTO;
use App\Applications\Venue\Repositories\VenueRepositoryInterface;
use Illuminate\Http\Request;

/**
 * @property VenueRepositoryInterface $venueRepository
 */
class VenueService implements VenueServiceInterface
{
    public function __construct(
        VenueRepositoryInterface $venueRepository
    ) {
        $this->venueRepository = $venueRepository;
    }

    public function getAll(): array
    {
        return $this->venueRepository->getAll();
    }

    public function get($id): VenueDTO
    {
        return VenueDTO::fromModel(
            $this->venueRepository->get($id)
        );
    }

    public function create(VenueDTO $venueData): VenueDTO
    {
        $venue = $this->venueRepository->create($venueData);

        return VenueDTO::fromModel($venue);
    }

    public function update(int $venueId, VenueDTO $venueData): VenueDTO
    {
        $venue = $this->venueRepository->update($venueId, $venueData);
        return VenueDTO::fromModel($venue);
    }

    public function delete(int $id)
    {
        return $this->venueRepository->delete($id);
    }

    public function draw(array $data): array
    {
        $data['columns'] = ['venues.name', 'venues.address'];
        $data['length'] = $data['length'] ?? 10;
        $data['column'] = $data['column'] ?? 'venues.name';
        $data['dir'] = $data['dir'] ?? 'asc';
        $data['search'] = $data['search'] ?? '';
        $data['draw'] = $data['draw'] ?? 1;

        $venuesCollection = $this->venueRepository->draw($data);

        $venuesDTOs = $venuesCollection->getCollection()->map(function ($venue) {
            return VenueDTO::fromModel($venue);
        });

        return [
            'data' => $venuesDTOs,
            'pagination' => $venuesCollection->toArray()['pagination'],
        ];
    }

    /**
     * Handle the avatar upload for a venue.
     *
     * @param int $venueId
     * @param Request $request
     * @param Venue $venue
     * @return VenueDTO
     */
    public function uploadAvatar(int $venueId, Request $request, Venue $venue): VenueDTO
    {
        // Validate the uploaded file
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Clear the existing 'avatars' collection and upload the new avatar
        $this->venueRepository->clearVenueAvatars($venue);
        $this->venueRepository->uploadAvatar($venue, $request->file('avatar'));

        // Return the updated VenueDTO
        return VenueDTO::fromModel($venue);
    }
}
