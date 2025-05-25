<?php

namespace App\Applications\Venue\DTO;

use App\Applications\Venue\Model\Venue;
use Illuminate\Http\Request;

class VenueDTO
{
    public string $name;
    public string $address;
    public int $owner_id;
    public int $venue_type_id;
    public int $id;

    private ?Venue $model = null;

    public function __construct(
        string $name,
        string $address,
        int $owner_id,
        int $venue_type_id,
        int $id = 0,
        ?Venue $model = null
    ) {
        $this->name = $name;
        $this->address = $address;
        $this->owner_id = $owner_id;
        $this->venue_type_id = $venue_type_id;
        $this->id = $id;
        $this->model = $model;
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('address'),
            $request->input('owner_id'),
            $request->input('venue_type_id', 1),
            $request->input('id', 0),
        );
    }

    public static function fromRequestForCreate(Request $request): self
    {
        return new self(
            $request->input('name'),
            $request->input('address'),
            1,
            1,
        );
    }

    public static function fromModel(Venue $venue): self
    {
        return new self(
            $venue->name,
            $venue->address,
            $venue->owner_id,
            $venue->venue_type_id,
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
            'owner_id' => $this->owner_id,
            'venue_type_id' => $this->venue_type_id,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public static function fromCollection(iterable $venues): array
    {
        return array_map(function (Venue $venue) {
            return self::fromModel($venue);
        }, $venues->all());
    }
}
