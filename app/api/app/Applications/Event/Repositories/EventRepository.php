<?php
namespace App\Applications\Event\Repositories;

use App\Applications\Event\DTO\EventDTO;
use App\Applications\Pagination\StarterPaginator;
use Illuminate\Http\UploadedFile;
use App\Applications\Event\Model\Event;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @property Event $event
 */
class EventRepository implements EventRepositoryInterface{

    public function __construct(
        Event $event,
    ) {
        $this->event = $event;
    }

    private const COLUMNS_MAP = [
        'name' => 'events.name',
        'address' => 'events.address',
        'status' => 'events.is_disabled'
    ];

    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    public function get($id): Event
    {
        return $this->event::with('musicGenres','media')->findOrFail($id);
    }

    public function create(EventDTO $eventDTO): Event
    {
        $attributes = $eventDTO->toArray();
        //Safe Hydration (tickets and genreIds are not fillable on the Event Eloquent model)
        unset($attributes['tickets'],$attributes['genreIds']);
        $event = new Event($attributes);
        $event->save();
        return $event;
    }

    public function update(int $eventId, EventDTO $eventDTO): Event
    {
        $event = $this->event->findOrFail($eventId);
        $attributes = $eventDTO->toArray();
        unset($attributes['tickets']);
        $event->update($attributes);
        $event->musicGenres()->sync($eventDTO->genreIds);

        $existingTicketIds = [];
        foreach ($eventDTO->tickets as $ticketDTO) {
            if ($ticketDTO->id) {
                // update existing ticket
                $ticket = $event->tickets()->find($ticketDTO->id);
                if ($ticket) {
                    $ticket->update($ticketDTO->toArray());
                    $existingTicketIds[] = $ticket->id;
                }
            } else {
                // create new ticket
                $newTicket = $event->tickets()->create($ticketDTO->toArray());
                $existingTicketIds[] = $newTicket->id;
            }
        }

        //delete tickets not in current payload
        $event->tickets()->whereNotIn('id', $existingTicketIds)->delete();
        return $event;
    }

    public function delete(int $id)
    {
        return $this->event::findOrFail($id)->delete();
    }

    public function draw(array $data): StarterPaginator
    {
        //TODO: maybe pull music genres,city when filtration for those is added in the dashboard
        $query = $this->event
            ->select(['id', 'user_id', 'name', 'address', 'event_start']);

        if (!empty($data['user_only'])) {
            $query->where('user_id', $data['user_only']);
        }

        if (array_key_exists($data['column'], self::COLUMNS_MAP)) {
            $query->orderBy(self::COLUMNS_MAP[$data['column']], $data['dir']);
        }

        if (!empty($data['music_genre'])) {
            $genreIds = is_array($data['music_genre']) ? $data['music_genre'] : [$data['music_genre']];
            $query->whereHas('musicGenres', function ($q) use ($genreIds) {
                $q->whereIn('music_genres.id', $genreIds);
            });
        }

        if (!empty($data['city'])) {
            $query->where('city', $data['city']);
        }

        if (!empty($data['start_date'])) {
            $query->whereDate('event_start', '=', $data['start_date']);
        }

        $search = $data['search'];
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('events.name', 'like', '%' . $search . '%');
                $subquery->orWhere('events.address', 'like', '%' . $search . '%');
            });
        }

        return $query->paginate($data['length']);
    }

    public function clearEventImage($eventId): void
    {
        $this->get($eventId)->clearMediaCollection('event_image');
    }

    public function uploadEventImage($eventId, UploadedFile $file): Event
    {
        $event = $this->get($eventId);
        $event->addMedia($file)->toMediaCollection('event_image');
        return $event;
    }
}
