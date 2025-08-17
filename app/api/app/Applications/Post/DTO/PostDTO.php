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
    public string $post_slot;
    public bool $is_boosted;
    public bool $is_active;
    public array $images = [];
    
    public function __construct(
        int|null $venue_id,
        string $name,
        string $description,
        string $post_slot,
        bool $is_boosted,
        bool $is_active,
        int $id = 0, // post_id
    ) {
        $this->venue_id = $venue_id;
        $this->name = $name;
        $this->description = $description;
        $this->post_slot = $post_slot;
        $this->is_boosted = $is_boosted;
        $this->is_active = $is_active;
        $this->id = $id;
    }

    public static function fromRequest(Request $request): self
    {
        $name = $request->input('name');
        $request->integer('venue_id') > 0 ? $venueId = $request->integer('venue_id') : $venueId = null;
        return new self(
            $venueId,
            $name,
            $request->input('description'),
            $request->input('post_slot'),
            $request->boolean('is_boosted'),
            $request->boolean('is_active'),
            $request->integer('id', 0), // post_id
        );
    }

    public static function fromModel(Post $post): self
    {
        $dto = new self(
            $post->venue_id,
            $post->name,
            $post->description,
            $post->post_slot,
            $post->is_boosted,
            $post->is_active,
            $post->id,
        );

        $media = $post->getFirstMedia('post_image');
        if(!$post->media->isEmpty()) {
            $dto->images = [
                'thumbnail' => [
                    'url'     => $media->getUrl('thumbnail'),
                    'srcset' => $media->getSrcset('thumbnail') ?? null,
                    'webp'    => $media->getResponsiveImageUrls('thumbnail') ?? null,
                ],
            ];
        }
        return $dto;
    }

    public static function fromModelForTable(Post $post): array
    {
        return [
            'id' => $post->id,
            'name' => $post->name,
            'description' => $post->description,
            'is_boosted' => $post->is_boosted,
            'is_active' => $post->is_active,
            'post_slot' => $post->post_slot,
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
            'post_slot' => $this->post_slot,
            'images' => $this->images,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public static function fromCollection(iterable $posts): array
    {
        return array_map(
            fn(Post $post) => self::fromModel($post),
            $posts instanceof \Illuminate\Support\Collection ? $posts->all() : iterator_to_array($posts)
        );
    }
}
