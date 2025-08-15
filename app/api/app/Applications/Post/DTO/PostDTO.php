<?php

namespace App\Applications\Post\DTO;

use App\Applications\Post\Model\Post;
use App\Applications\Ticket\DTO\TicketDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostDTO
{
    //TODO: might have to be null
    public int $id;
    public int|null $venue_id;
    public string $name;
    public string $description;
    public bool $is_boosted;
    public bool $is_active;

    public function __construct(
        int $user_id,
        int|null $venue_id,
        string $name,
        string $description,
        bool $is_boosted,
        bool $is_active,
        int $id = 0, // post_id
    ) {
        $this->user_id = $user_id;
        $this->venue_id = $venue_id;
        $this->name = $name;
        $this->description = $description;
        $this->is_boosted = $is_boosted;
        $this->is_active = $is_active;
        $this->id = $id;
    }

    public static function fromRequest(Request $request): self
    {
        $name = $request->input('name');
        $request->integer('venue_id') > 0 ? $venueId = $request->integer('venue_id') : $venueId = null;
        return new self(
            $request->integer('user_id'),
            $venueId,
            $name,
            $request->input('description'),
            $request->boolean('is_boosted'),
            $request->boolean('is_active'),
            $request->integer('id', 0), // post_id
        );
    }

    public static function fromModel(Post $event): self
    {
        $dto = new self(
            $event->user_id,
            $event->venue_id,
            $event->name,
            $event->description,
            $event->is_boosted,
            $event->is_active,
            $event->id,
        );

        $media = $event->getFirstMedia('event_image');
        if(!$event->media->isEmpty()) {
            $dto->images = [
                'thumbnail' => [
                    'url'     => $media->getUrl('thumbnail'),
                    'srcset' => $media->getSrcset('thumbnail') ?? null,
                    'webp'    => $media->getResponsiveImageUrls('thumbnail') ?? null,
                ],
                'card' => [
                    'url'     => $media->getUrl('card'),
                    'srcset' => $media->getSrcset('card') ?? null,
                    'webp'    => $media->getResponsiveImageUrls('card') ?? null,
                ],
                'banner' => [
                    'url'     => $media->getUrl('banner'),
                    'srcset' => $media->getSrcset('banner') ?? null,
                    'webp'    => $media->getResponsiveImageUrls('banner') ?? null,
                ],
            ];
        }
        return $dto;
    }

    public static function fromModelForTable(Post $event): array
    {
        return [
            'id' => $event->id,
            'name' => $event->name,
            'description' => $event->description,
        ];
    }

    public function model(): Post
    {
        if (!$this->model) {
            throw new \LogicException('No Post model instance is set on this DTO.');
        }

        return $this->model;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'venue_id' => $this->venue_id,
            'name' => $this->name,
            'description' => $this->description,
            'is_boosted' => $this->is_boosted,
            'is_active' => $this->is_active,
            'images' => $this->images,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public static function fromCollection(iterable $events): array
    {
        return array_map(
            fn(Post $event) => self::fromModel($event),
            $events instanceof \Illuminate\Support\Collection ? $events->all() : iterator_to_array($events)
        );
    }
}
