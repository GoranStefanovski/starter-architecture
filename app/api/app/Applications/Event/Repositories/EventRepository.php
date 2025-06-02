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
        return $this->event::findOrFail($id);
    }

    public function create(EventDTO $eventDTO): Event
    {
        $attributes = $eventDTO->toArray();

        $event = new Event($attributes);
        $event->save();

        return $event;
    }

    public function update(int $eventId, EventDTO $eventData): Event
    {
        $event = $this->event->findOrFail($eventId);
        $attributes = $eventData->toArray();
        unset($attributes['tickets']);
        $event->update($attributes);

        $existingTicketIds = [];
        foreach ($eventData->tickets as $ticketDTO) {
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
        // TODO: Implement delete() method.
    }

    public function draw(array $data): StarterPaginator
    {
        $query = $this->event->query();

        if (!empty($data['user_only'])) {
            $query->where('user_id', $data['user_only']);
        }

        if (array_key_exists($data['column'], self::COLUMNS_MAP)) {
            $query->orderBy(self::COLUMNS_MAP[$data['column']], $data['dir']);
        }

        $search = $data['search'];
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('events.name', 'like', '%' . $search . '%');
                $subquery->orWhere('events.address', 'like', '%' . $search . '%');
            });
        }

//        $query->whereNull('deleted_at');
        return $query->paginate($data['length']);
    }

    public function clearVenueAvatars(Event $event): void
    {
        // TODO: Implement clearVenueAvatars() method.
    }

    public function uploadAvatar(Event $event, \Illuminate\Http\UploadedFile $file): Media
    {
        // TODO: Implement uploadAvatar() method.
    }
}
