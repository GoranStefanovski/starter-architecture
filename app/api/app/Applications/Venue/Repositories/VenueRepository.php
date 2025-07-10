<?php

namespace App\Applications\Venue\Repositories;

use App\Applications\User\Model\User;
use App\Applications\Venue\DTO\VenueDTO;
use App\Applications\Pagination\StarterPaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\UploadedFile;
use App\Applications\Venue\Model\Venue;
use Illuminate\Support\Facades\DB;
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
        return $this->venue::with('media')->findOrFail($id);
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
        $query = $this->venue->query()
            ->select(['id', 'user_id', 'collaborator_id', 'name', 'address', 'is_active', 'is_boosted']);

        if (!empty($data['collaborator_id'])) {
            $query->where('collaborator_id', $data['collaborator_id']);
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

        $venues = $query->paginate($data['length']);

        $media = Media::whereIn('model_id', $venues->pluck('id'))
            ->where('model_type', Venue::class)
            ->where('collection_name', 'venue_logo')
            ->get()
            ->groupBy('model_id');

        $venues->getCollection()->transform(function ($venue) use ($media) {
            $venue->logo = optional(optional($media->get($venue->id))->first());
            return $venue;
        });

        return $venues;
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

    public function uploadVenueImage($venueId, UploadedFile $file, $imageType): Venue
    {
        $venue = $this->get($venueId);
        $venue->addMedia($file)->toMediaCollection($imageType);
        return $venue;
    }

    public function deleteVenueImage(int $venueId, int $imageId): Venue
    {
        $venue = $this->get($venueId);

        $media = $venue->media()->where('id', $imageId)->first();

        if ($media) {
            $media->delete();
        } else {
            abort(404, 'Image not found.');
        }

        return $venue->fresh();
    }


    //TODO: smart to cache these in redis after they've been fetched once, no reason for multiple fetches, they wont be changed,
    //TODO: unless a new venue is added(look into this)
    public function getVenuesAvailableForEvent(User $user): Collection
    {
        if ($user->can('getAllVenuesForEvent', $user)){
            return Venue::select('id', 'name')->get();
        }

        if ($user->can('getOwnVenuesForEvent', $user)) {
            return $user->venues()->select('id', 'name')->get();
        }

        return new Collection();
    }

    public function getAllVenuesFromCityOrOwner(string $city, ?int $venue_owner_id = null): array
    {
        $query = DB::table('venues')
            ->select('venues.id', 'venues.name', 'venues.address', 'venues.city', 'venues.country', 'venues.lat', 'venues.lng');

        if ($venue_owner_id !== null) {
            // Collaborator: fetch only their venues, ignore city
            $query->where('venues.collaborator_id', $venue_owner_id);
        } else {
            // Admin/Org/Artist: fetch all venues from the specified city
            $query->where('venues.city', $city);
        }

        return $query->get()->toArray();
    }


}
