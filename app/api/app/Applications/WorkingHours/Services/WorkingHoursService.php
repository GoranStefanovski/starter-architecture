<?php
namespace App\Applications\WorkingHours\Services;

use App\Applications\WorkingHours\DTO\WorkingHourDTO;
use App\Applications\WorkingHours\Repositories\WorkingHoursRepositoryInterface;

class WorkingHoursService implements WorkingHoursServiceInterface
{
    public function __construct(
        protected WorkingHoursRepositoryInterface $repository
    ) {}

    //TODO: Might need to be generalized(change venue appearances with ex. model)if we ever add another model that has a workingHours relation
    //TODO: thats the whole point of making a seperate Service and Repo Layer for them
    public function createOrUpdateForVenue(int $venueId, array $workingHours): void
    {
//        dd($workingHours);
        $hydrated = collect($workingHours)
            ->map(fn ($hour) => WorkingHourDTO::fromArray($hour))
            ->toArray();
        $this->repository->upsertForVenue($venueId, $hydrated);
    }
}
