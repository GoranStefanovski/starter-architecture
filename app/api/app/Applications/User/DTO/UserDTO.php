<?php

namespace App\Applications\User\DTO;

use App\Applications\User\Model\User;
use Illuminate\Http\Request;

class UserDTO
{
    public string $first_name;
    public string $last_name;
    public string $phone_number;
    public string $email;
    public ?string $avatar_url;
    public ?string $avatar_thumbnail;
    public ?string $username;
    public ?string $artist_tag;
    public ?string $bio;
    public ?string $city_from;
    public ?string $country_from;
    public ?string $instagram_link;
    public ?string $instagram_video;
    public ?string $facebook_link;
    public ?string $facebook_video;
    public ?string $soundcloud_link;
    public ?string $soundcloud_track;
    public ?string $spotify_link;
    public ?string $spotify_track;
    public ?string $youtube_link;
    public ?string $youtube_video;
    public ?string $contact_phone;
    public ?string $contact_email;
    public int $role;
    public int $id;
    public bool $is_disabled;
    public array $permissions_array;

    private ?User $model = null;

    public function __construct(
        string $first_name,
        string $last_name,
        string $phone_number,
        string $email,
        ?string $avatar_url,
        ?string $avatar_thumbnail,
        ?string $username = null,
        ?string $artist_tag = null,
        ?string $bio = null,
        ?string $city_from = null,
        ?string $country_from = null,
        ?string $instagram_link = null,
        ?string $instagram_video = null,
        ?string $facebook_link = null,
        ?string $facebook_video = null,
        ?string $soundcloud_link = null,
        ?string $soundcloud_track = null,
        ?string $spotify_link = null,
        ?string $spotify_track = null,
        ?string $youtube_link = null,
        ?string $youtube_video = null,
        ?string $contact_phone = null,
        ?string $contact_email = null,
        int $role,
        int $id = 0,
        bool $is_disabled = false,
        array $permissions_array = [],
        ?User $model = null
    ) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->phone_number = $phone_number;
        $this->email = $email;
        $this->avatar_url = $avatar_url;
        $this->avatar_thumbnail = $avatar_thumbnail;
        $this->username = $username;
        $this->artist_tag = $artist_tag;
        $this->bio = $bio;
        $this->city_from = $city_from;
        $this->country_from = $country_from;

        $this->instagram_link = $instagram_link;
        $this->instagram_video = $instagram_video;
        $this->facebook_link = $facebook_link;
        $this->facebook_video = $facebook_video;
        $this->soundcloud_link = $soundcloud_link;
        $this->soundcloud_track = $soundcloud_track;
        $this->spotify_link = $spotify_link;
        $this->spotify_track = $spotify_track;
        $this->youtube_link = $youtube_link;
        $this->youtube_video = $youtube_video;

        $this->contact_phone = $contact_phone;
        $this->contact_email = $contact_email;
        $this->role = $role;
        $this->id = $id;
        $this->is_disabled = $is_disabled;
        $this->permissions_array = $permissions_array;
        $this->model = $model;
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->input('first_name'),
            $request->input('last_name'),
            $request->input('phone_number'),
            $request->input('email'),
            null,
            null,
            $request->input('username'),
            $request->input('artist_tag'),
            $request->input('bio'),
            $request->input('city_from'),
            $request->input('country_from'),
            $request->input('instagram_link'),
            $request->input('instagram_video'),
            $request->input('facebook_link'),
            $request->input('facebook_video'),
            $request->input('soundcloud_link'),
            $request->input('soundcloud_track'),
            $request->input('spotify_link'),
            $request->input('spotify_track'),
            $request->input('youtube_link'),
            $request->input('youtube_video'),
            $request->input('contact_phone'),
            $request->input('contact_email'),
            $request->input('role'),
            $request->input('id', 0),
            (bool) $request->input('is_disabled', false),
            $request->input('permissions_array', [])
        );
    }

    public static function fromMyProfileRequest(User $user, array $data): self
    {
        $dto = self::fromModel($user);

        $dto->first_name = $data['first_name'];
        $dto->last_name = $data['last_name'];
        $dto->phone_number = $data['phone_number'];
        $dto->username = $data['username'] ?? $dto->username;
        $dto->artist_tag = $data['artist_tag'] ?? $dto->artist_tag;
        $dto->bio = $data['bio'] ?? $dto->bio;
        $dto->city_from = $data['city_from'] ?? $dto->city_from;
        $dto->country_from = $data['country_from'] ?? $dto->country_from;
        $dto->instagram_link = $data['instagram_link'] ?? $dto->instagram_link;
        $dto->instagram_video = $data['instagram_video'] ?? $dto->instagram_video;
        $dto->facebook_link = $data['facebook_link'] ?? $dto->facebook_link;
        $dto->facebook_video = $data['facebook_video'] ?? $dto->facebook_video;
        $dto->soundcloud_link = $data['soundcloud_link'] ?? $dto->soundcloud_link;
        $dto->soundcloud_track = $data['soundcloud_track'] ?? $dto->soundcloud_track;
        $dto->spotify_link = $data['spotify_link'] ?? $dto->spotify_link;
        $dto->spotify_track = $data['spotify_track'] ?? $dto->spotify_track;
        $dto->youtube_link = $data['youtube_link'] ?? $dto->youtube_link;
        $dto->youtube_video = $data['youtube_video'] ?? $dto->youtube_video;
        $dto->contact_phone = $data['contact_phone'] ?? $dto->contact_phone;
        $dto->contact_email = $data['contact_email'] ?? $dto->contact_email;

        return $dto;
    }

    public static function fromRequestForCreate(Request $request): self
    {
        return new self(
            $request->input('first_name'),
            $request->input('last_name'),
            $request->input('phone_number'),
            $request->input('email'),
            null,
            null,
            $request->input('username'),
            $request->input('artist_tag'),
            $request->input('bio'),
            $request->input('city_from'),
            $request->input('country_from'),
            $request->input('instagram_link'),
            $request->input('instagram_video'),
            $request->input('facebook_link'),
            $request->input('facebook_video'),
            $request->input('soundcloud_link'),
            $request->input('soundcloud_track'),
            $request->input('spotify_link'),
            $request->input('spotify_track'),
            $request->input('youtube_link'),
            $request->input('youtube_video'),
            $request->input('contact_phone'),
            $request->input('contact_email'),
            $request->input('role'),
            id: 0,
            is_disabled: false,
            permissions_array: $request->input('permissions_array', [])
        );
    }

    public static function fromModel(User $user): self
    {
        return new self(
            $user->first_name,
            $user->last_name,
            $user->phone_number,
            $user->email,
            $user->avatar_url,
            $user->avatar_thumbnail,
            $user->username,
            $user->artist_tag,
            $user->bio,
            $user->city_from,
            $user->country_from,
            $user->instagram_link,
            $user->instagram_video,
            $user->facebook_link,
            $user->facebook_video,
            $user->soundcloud_link,
            $user->soundcloud_track,
            $user->spotify_link,
            $user->spotify_track,
            $user->youtube_link,
            $user->youtube_video,
            $user->contact_phone,
            $user->contact_email,
            $user->role,
            $user->id,
            (bool) $user->is_disabled,
            $user->permissions_array,
            $user
        );
    }

    public function model(): User
    {
        if (!$this->model) {
            throw new \LogicException('No User model instance is set on this DTO.');
        }

        return $this->model;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'avatar_url' => $this->avatar_url,
            'avatar_thumbnail' => $this->avatar_thumbnail,
            'username' => $this->username,
            'artist_tag' => $this->artist_tag,
            'bio' => $this->bio,
            'city_from' => $this->city_from,
            'country_from' => $this->country_from,

            'instagram_link' => $this->instagram_link,
            'instagram_video' => $this->instagram_video,
            'facebook_link' => $this->facebook_link,
            'facebook_video' => $this->facebook_video,
            'soundcloud_link' => $this->soundcloud_link,
            'soundcloud_track' => $this->soundcloud_track,
            'spotify_link' => $this->spotify_link,
            'spotify_track' => $this->spotify_track,
            'youtube_link' => $this->youtube_link,
            'youtube_video' => $this->youtube_video,

            'contact_phone' => $this->contact_phone,
            'contact_email' => $this->contact_email,
            'role' => $this->role,
            'id' => $this->id,
            'is_disabled' => $this->is_disabled,
            'permissions_array' => $this->permissions_array,
        ];
    }

    public static function fromCollection(iterable $users): array
    {
        return array_map(function (User $user) {
            return self::fromModel($user);
        }, $users->all());
    }
}
