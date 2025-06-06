<?php

namespace App\Applications\Event\DTO;

use App\Applications\Event\Model\Event;
use App\Applications\Ticket\DTO\TicketDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventDTO
{
    //TODO: might have to be null
    public int $id;
    public int $user_id;
    public int|null $venue_id;
    public string $name;
    public string $description;
    public string $country;
    public string $city;
    public string|null $address;
    public float $lng;
    public float $lat;
    public string $slug;
    public string $event_start;
    public ?string $event_end;
    /** @var TicketDTO[] */
    public array $tickets = [];
    /** @var int[] */
    public array $genreIds = [];
    private ?Event $model = null;

    public function __construct(
        int $user_id,
        int|null $venue_id,
        string $name,
        string $description,
        string $country,
        string $city,
        string|null $address,
        float $lng,
        float $lat,
        string $slug,
        string $event_start,
        ?string $event_end = null,
        array $tickets = [],
        array $genreIds = [],
        ?Event $model = null,
        int $id = 0, // event_id
    ) {
        $this->user_id = $user_id;
        $this->venue_id = $venue_id;
        $this->name = $name;
        $this->description = $description;
        $this->country = $country;
        $this->city = $city;
        $this->address = $address;
        $this->lng = $lng;
        $this->lat = $lat;
        $this->slug = $slug;
        $this->event_start = $event_start;
        $this->event_end = $event_end;
        $this->tickets = $tickets;
        $this->genreIds = $genreIds;
        $this->model = $model;
        $this->id = $id;
    }

    public static function fromRequest(Request $request): self
    {
//        dd($request->all());
        $name = $request->input('name');
        $slug = Str::slug($name);

        $tickets = collect($request->input('tickets', []))
            ->map(fn($ticket) => TicketDTO::fromArray($ticket))
            ->all();

        $genreIds = $request->input('genreIds', []);

        return new self(
            $request->integer('user_id'),
            $request->integer('venue_id', null),
            $name,
            $request->input('description'),
            $request->input('country'),
            $request->input('city'),
            $request->input('address'),
            $request->float('lng'),
            $request->float('lat'),
            $slug,
            $request->input('event_start'),
            $request->input('event_end'),
            $tickets,
            $genreIds,
            null,
            $request->integer('id', 0), // event_id
        );
    }

    public static function fromModel(Event $event): self
    {
        $tickets = $event->tickets->map(fn($ticket) => TicketDTO::fromModel($ticket))->all();
        $genreIds = $event->musicGenres->pluck('id')->toArray();

        return new self(
            $event->user_id,
            $event->venue_id,
            $event->name,
            $event->description,
            $event->country,
            $event->city,
            $event->address,
            $event->lng,
            $event->lat,
            $event->slug,
            $event->event_start,
            $event->event_end,
            $tickets,
            $genreIds,
            $event,
            $event->id, // event_id
        );
    }

    public function model(): Event
    {
        if (!$this->model) {
            throw new \LogicException('No Event model instance is set on this DTO.');
        }

        return $this->model;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'venue_id' => $this->venue_id,
            'name' => $this->name,
            'description' => $this->description,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'lng' => $this->lng,
            'lat' => $this->lat,
            'slug' => $this->slug,
            'event_start' => $this->event_start,
            'event_end' => $this->event_end,
            'tickets' => array_map(fn(TicketDTO $ticket) => $ticket->toArray(), $this->tickets),
            'genreIds' => $this->genreIds,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public static function fromCollection(iterable $events): array
    {
        return array_map(
            fn(Event $event) => self::fromModel($event),
            $events instanceof \Illuminate\Support\Collection ? $events->all() : iterator_to_array($events)
        );
    }

    public static function generateSlug(string $name, ?int $id = null): string
    {
        $slug = Str::slug($name);
        return $id ? "$slug-$id" : $slug;
    }
}
