<?php

namespace App\Applications\Venue\Repositories;

use App\Applications\Venue\DTO\VenueDTO;
use App\Applications\Pagination\StarterPaginator;
use Illuminate\Http\UploadedFile;
use App\Applications\Venue\Model\Venue;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


/**
 * @property Venue $venue
 */
class VenueRepository implements VenueRepositoryInterface
{
    public function __construct(
        Venue $venue,
    ) {
        $this->venue = $venue;
    }

    private const COLUMNS_MAP = [
        'name' => 'venues.name',
        'address' => 'venues.address',
        'status' => 'venues.is_disabled'
    ];

    public function getAll(): array
    {
        $venues = $this->venue::all();
        return VenueDTO::fromCollection($venues);
    }

    public function get($id): Venue
    {
        return $this->venue::findOrFail($id);
    }

    public function create(VenueDTO $venueDTO): Venue
    {
        $attributes = $venueDTO->toArray();

        $venue = new Venue($attributes);
        $venue->save();

        return $venue;
    }

    public function update(int $venueId, VenueDTO $venueData): Venue
    {
        $venue = $this->venue->findOrFail($venueId);
        $attributes = $venueData->toArray();
        $venue->update($attributes);
        return $venue;
    }

    public function delete(int $id)
    {
        return $this->venue::findOrFail($id)->delete();
    }

    public function draw($data): StarterPaginator
    {
        //        $paginatedVenues = $this->prepareDatatableQuery($data, [Venue::ADMIN, Venue::EDITOR, Venue::COLLABORATOR]);

        $query = $this->venue->query();

        // $query->whereIn('roles.name', $roles);

        if (!empty($data['user_only'])) {
            $query->where('user_id', $data['user_only']);
        }

        if (array_key_exists($data['column'], self::COLUMNS_MAP)) {
            $query->orderBy(self::COLUMNS_MAP[$data['column']], $data['dir']);
        }

        $search = $data['search'];
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('venues.name', 'like', '%' . $search . '%');
                $subquery->orWhere('venues.address', 'like', '%' . $search . '%');
            });
        }

        $query->whereNull('deleted_at');
        return $query->paginate($data['length']);
    }


    /**
     * Clear the avatar collection for a given venue.
     *
     * @param Venue $venue
     * @return void
     */
    public function clearVenueAvatars(Venue $venue): void
    {
        $venue->clearMediaCollection('avatars');
    }

    /**
     * Upload a new avatar for a given venue.
     *
     * @param Venue $venue
     * @param UploadedFile $file
     * @return Media
     */
    public function uploadAvatar(Venue $venue, UploadedFile $file): Media
    {
        return $venue->addMedia($file)->toMediaCollection('avatars');
    }
}
