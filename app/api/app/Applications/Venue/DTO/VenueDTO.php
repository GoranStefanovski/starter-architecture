<?php

namespace App\Applications\Venue\DTO;

use App\Applications\Venue\Model\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VenueDTO
{
    public int $id;
    public string $name;
    public string $address;
    public ?string $bio;
    public float $lng;
    public float $lat;
    public ?string $slug = null;
    public int $venue_type_id;
    public ?string $type_label = null;
    public int $user_id;

    private ?Venue $model = null;

    public function __construct(
        string $name,
        string $address,
        ?string $bio,
        float $lng,
        float $lat,
        int $venue_type_id,
        ?string $type_label,
        ?string $slug,
        int $user_id,
        int $id = 0,
        ?Venue $model = null
    ) {
        $this->name = $name;
        $this->address = $address;
        $this->bio = $bio;
        $this->lng = $lng;
        $this->lat = $lat;
        $this->venue_type_id = $venue_type_id;
        $this->type_label = $type_label;
        $this->slug = $slug;
        $this->user_id = $user_id;
        $this->id = $id;
        $this->model = $model;
    }

    public static function fromRequest(Request $request): self
    {
        $name = $request->input('name');
        $id = $request->integer('id', 0);

        return new self(
            $request->input('name'),
            $request->input('address'),
            $request->input('bio'),
            $request->float('lng'),
            $request->float('lat'),
            $request->integer('venue_type_id'),
            self::generateSlug($name, $id), // type_label
            $request->input('slug'),
            $request->integer('user_id'),
            $request->input('id', 0)
        );
    }

    public static function fromRequestForCreate(Request $request, int $userId): self
    {
        $name = $request->input('name');
        $id = $request->integer('id', 0);

        return new self(
            $request->input('name'),
            $request->input('address'),
            $request->input('bio'),
            $request->float('lng'),
            $request->float('lat'),
            $request->integer('venue_type_id'),
            self::generateSlug($name, $id), // type_label
            $request->input('slug'),
            $userId
        );
    }

    public static function fromModel(Venue $venue): self
    {
        return new self(
            $venue->name,
            $venue->address,
            $venue->bio,
            $venue->lng,
            $venue->lat,
            (int) $venue->venue_type_id,
            $venue->type?->name,
            $venue->slug,
            $venue->user_id,
            $venue->id,
            $venue
        );

    }

    public function model(): Venue
    {
        if (!$this->model) {
            throw new \LogicException('No Venue model instance is set on this DTO.');
        }

        return $this->model;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'bio' => $this->bio,
            'lng' => $this->lng,
            'lat' => $this->lat,
            'slug' => $this->slug,
            'venue_type_id' => $this->venue_type_id,
            'type_label' => $this->type_label,
            'user_id' => $this->user_id,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public static function fromCollection(iterable $venues): array
    {
        return array_map(
            fn(Venue $venue) => self::fromModel($venue),
            $venues instanceof \Illuminate\Support\Collection ? $venues->all() : iterator_to_array($venues)
        );
    }

    public static function generateSlug(string $name, ?int $id = null): string
    {
        $slug = Str::slug($name);
        return $id ? "$slug-$id" : $slug;
    }
}
