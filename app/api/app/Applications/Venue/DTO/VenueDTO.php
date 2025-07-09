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
    public string $country;
    public string $city;
    public float $lng;
    public float $lat;
    public string $email;
    public string $phone_number;
    public ?string $slug = null;
    public bool $is_active;
    public int $venue_type_id;
    public ?string $type_label = null;
    //TODO: might have to be null
    public int $user_id;
    public array $images = [];
    public ?array $logo = [];
    public array $working_hours;
    private ?Venue $model = null;

    public function __construct(
        string $name,
        string $address,
        ?string $bio,
        string $country,
        string $city,
        float $lng,
        float $lat,
        string $email,
        string $phone_number,
        int $venue_type_id,
        ?string $type_label,
        ?string $slug,
        bool $is_active,
        int $user_id,
        int $id = 0,
        array $working_hours = [],
        ?Venue $model = null
    ) {
        $this->name = $name;
        $this->address = $address;
        $this->bio = $bio;
        $this->country = $country;
        $this->city = $city;
        $this->lng = $lng;
        $this->lat = $lat;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->venue_type_id = $venue_type_id;
        $this->type_label = $type_label;
        $this->slug = $slug;
        $this->is_active = $is_active;
        $this->user_id = $user_id;
        $this->id = $id;
        $this->working_hours = $working_hours;
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
            $request->input('country'),
            $request->input('city'),
            $request->float('lng'),
            $request->float('lat'),
            $request->input('email'),
            $request->input('phone_number'),
            $request->integer('venue_type_id'),
            $request->input('type_label'),
            self::generateSlug($name, $id), // venue_slug
            $request->boolean('is_active'),
            $request->integer('user_id'),
            $request->input('id', 0),
            $request->input('working_hours', self::defaultWorkingHours()),
        );
    }

    public static function fromRequestForCreate(Request $request): self
    {
        $name = $request->input('name');
        $id = $request->integer('id', 0);
        return new self(
            $request->input('name'),
            $request->input('address'),
            $request->input('bio'),
            $request->input('country'),
            $request->input('city'),
            $request->float('lng'),
            $request->float('lat'),
            $request->input('email'),
            $request->input('phone_number'),
            $request->integer('venue_type_id'),
            $request->input('type_label'),
            self::generateSlug($name, $id), // slug
            $request->boolean('is_active'),
            $request->integer('user_id'),
            $id,
            $request->input('working_hours', self::defaultWorkingHours())
        );
    }

    public static function fromModel(Venue $venue): self
    {
        $dto = new self(
            $venue->name,
            $venue->address,
            $venue->bio,
            $venue->country,
            $venue->city,
            $venue->lng,
            $venue->lat,
            $venue->email,
            $venue->phone_number,
            (int) $venue->venue_type_id,
            $venue->type?->name,
            $venue->slug,
            $venue->is_active,
            $venue->user_id,
            $venue->id,
            $venue->working_hours ?? self::defaultWorkingHours(),
            $venue
        );
        if (!$venue->getMedia('venue_image')->isEmpty()) {
            foreach ($venue->getMedia('venue_image') as $media) {
                $dto->images[] = [
                    'id'       => $media->id,
                    'thumbnail' => [
                        'url'     => $media->getUrl('thumbnail'),
                        'srcset'  => $media->getSrcset('thumbnail') ?? null,
                        'webp'    => $media->getResponsiveImageUrls('thumbnail') ?? null,
                    ],
                    'card' => [
                        'url'     => $media->getUrl('card'),
                        'srcset'  => $media->getSrcset('card') ?? null,
                        'webp'    => $media->getResponsiveImageUrls('card') ?? null,
                    ],
                    'banner' => [
                        'url'     => $media->getUrl('banner'),
                        'srcset'  => $media->getSrcset('banner') ?? null,
                        'webp'    => $media->getResponsiveImageUrls('banner') ?? null,
                    ],
                ];
            }
        }
        $logo = $venue->getFirstMedia('venue_logo');
        if($logo){
            $dto->logo = [
                'id' => $logo->id,
                'url'     => $logo->getUrl('logo'),
                'srcset'  => $logo->getSrcset('logo') ?? null,
                'webp'    => $logo->getResponsiveImageUrls('logo') ?? null,
            ];
        }

        return $dto;

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
            'country' => $this->country,
            'city' => $this->city,
            'lng' => $this->lng,
            'lat' => $this->lat,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'slug' => $this->slug,
            'is_active' => $this->is_active,
            'venue_type_id' => $this->venue_type_id,
            'type_label' => $this->type_label,
            'user_id' => $this->user_id,
            'images' => $this->images,
            'working_hours' => $this->working_hours,
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
    
    public static function defaultWorkingHours(): array
    {
        return [
            'monday'    => ['open' => false, 'from' => null, 'to' => null],
            'tuesday'   => ['open' => false, 'from' => null, 'to' => null],
            'wednesday' => ['open' => false, 'from' => null, 'to' => null],
            'thursday'  => ['open' => false, 'from' => null, 'to' => null],
            'friday'    => ['open' => false, 'from' => null, 'to' => null],
            'saturday'  => ['open' => false, 'from' => null, 'to' => null],
            'sunday'    => ['open' => false, 'from' => null, 'to' => null],
        ];
    }
}
