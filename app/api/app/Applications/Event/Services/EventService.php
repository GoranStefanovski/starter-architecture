<?php
namespace App\Applications\Event\Services;
use App\Applications\Event\DTO\EventDTO;
use App\Applications\Event\Model\Event;
use App\Applications\Event\Repositories\EventRepositoryInterface;
use App\Applications\Ticket\Model\Ticket;
use App\Applications\User\Model\User;
use Illuminate\Http\Request;

/**
 * @property EventRepositoryInterface $eventRepository
 */
class EventService implements EventServiceInterface{

    public function __construct(
        EventRepositoryInterface $eventRepository
    ) {
        $this->eventRepository = $eventRepository;
    }

    public function getAll(): array
    {
        // TODO: Implement getAll() method.
    }

    public function get(int $id): EventDTO
    {
        return EventDTO::fromModel(
            $this->eventRepository->get($id)
        );
    }

    public function create(EventDTO $eventDTO): EventDTO
    {
        // Create and save the event
        $newEvent = $this->eventRepository->create($eventDTO);

        // Create and save the tickets
        foreach ($eventDTO->tickets as $ticketDTO) {
            $newEvent->tickets()->create($ticketDTO->toArray());
        }
        // Create and save the attached genres
        $newEvent->musicGenres()->sync($eventDTO->genreIds);

        return EventDTO::fromModel($newEvent);
    }

    public function update(int $eventId, EventDTO $eventDTO): EventDTO
    {
        $venue = $this->eventRepository->update($eventId, $eventDTO);
        return EventDTO::fromModel($venue);
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    public function draw(array $data): array
    {
        $user = auth()->user();
        // EventPolicy
        if ($user->cannot('viewAllEvents', User::class)) {
            $data['user_only'] = $user->id;
        }

        $data['columns'] = ['events.name', 'events.address'];
        $data['length'] = $data['length'] ?? 10;
        $data['column'] = $data['column'] ?? 'events.name';
        $data['dir'] = $data['dir'] ?? 'asc';
        $data['search'] = $data['search'] ?? '';
        $data['draw'] = $data['draw'] ?? 1;

        $eventsCollection = $this->eventRepository->draw($data);

        $eventsDTOs = $eventsCollection->getCollection()->map(function ($event) {
            return EventDTO::fromModel($event);
        });

        return [
            'data' => $eventsDTOs,
            'pagination' => $eventsCollection->toArray()['pagination'],
        ];
    }

    public function uploadAvatar(int $eventId, Request $request, Event $event): EventDTO
    {
        // TODO: Implement uploadAvatar() method.
    }
}
