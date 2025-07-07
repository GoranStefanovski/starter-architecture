<?php

namespace App\Applications\Venue\Services;

use App\Applications\User\Model\User;
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
        $user = auth()->user();
        // VenuePolicy
        if ($user->cannot('viewAllVenues', User::class)) {
            $data['user_only'] = $user->id;
        }

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

    public function uploadVenueImage(int $venueId, Request $request): VenueDTO
    {
        $imageType = array_key_first($request->file());
        $request->validate([
            $imageType => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $venue = $this->venueRepository->uploadVenueImage($venueId, $request->file($imageType), $imageType);
        return VenueDTO::fromModel($venue);
    }

    public function deleteVenueImage(int $venueId, int $imageId): VenueDTO
    {
        $venue = $this->venueRepository->deleteVenueImage($venueId,$imageId);
        return VenueDTO::fromModel($venue);
    }


    public function getAllVenuesFromCity(String $city): array
    {
       return  $this->venueRepository->getAllVenuesFromCity($city);
    }
}
