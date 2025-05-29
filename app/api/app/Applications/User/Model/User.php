<?php

namespace App\Applications\User\Model;

use App\Applications\Common\Model\MusicGenre;
use App\Applications\Event\Model\Event;
use App\Applications\Common\Pivot\UserVenueAttendance;
use App\Applications\Common\Pivot\VenueRating;
use App\Applications\Venue\Model\Venue;
use Database\Factories\UserFactory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles, SoftDeletes, InteractsWithMedia;

    protected static function newFactory()
    {
        return UserFactory::new();
    }
    const ADMIN = 'admin';
    const COLLABORATOR = 'collaborator';
    const ORGANIZATION = 'organization';
    const ARTIST = 'artist';

    const PUBLIC = 'public';

    protected $fillable = [
        'first_name',
        'last_name',
        'artist_tag',
        'bio',
        'city_from',
        'country_from',
        'email',
        'phone_number',
        'password',
        'role',
        'is_disabled',
    ];

    protected $hidden = [
        'roles',
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    protected $appends = [
        'permissions_array',
        'role',
        'avatar_url',
        'avatar_thumbnail',
    ];

    /**
     * Spatie Media Collections
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatars')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->fit(Fit::Contain, 100, 100)
            ->sharpen(10)
            ->nonQueued();
    }

    /**
     * Get all permissions as an array (Spatie).
     */
    public function getPermissionsArrayAttribute(): array
    {
        return $this->getAllPermissions()->pluck('name')->toArray();
    }

    /**
     * Get the user's primary role (Spatie).
     */
    public function getRoleAttribute(): ?string
    {
        return $this->roles()->first()?->id;
    }

    /**
     * Full-size avatar URL.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('avatars') ?: null;
    }

    /**
     * Thumbnail avatar URL.
     */
    public function getAvatarThumbnailAttribute(): ?string
    {
        return $this->getFirstMediaUrl('avatars', 'thumb') ?: null;
    }

    // =========================================================================
    // Relationships
    // =========================================================================

    /**
     * Venues owned by this user (typically organizations).
     */
    public function venues()
    {
        return $this->hasMany(Venue::class, 'user_id');
    }

    /**
     * Ratings submitted by the user for venues.
     */
    public function venueRatings()
    {
        return $this->hasMany(VenueRating::class);
    }

    /**
     * Attendance records for this user's visits to venues.
     */
    public function venueAttendances()
    {
        return $this->hasMany(UserVenueAttendance::class);
    }

    /**
     * Events this user is organizing.
     */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    /**
     * Events where this user is performing as an artist.
     */
    public function artistEvents()
    {
        return $this->belongsToMany(Event::class, 'artist_event', 'artist_id', 'event_id');
    }

    /**
     * Music genres preferred by this user.
     */
    public function musicGenres()
    {
        return $this->belongsToMany(MusicGenre::class, 'user_music_genre');
    }

    /**
     * Users that this user is following.
     */
    public function followedUsers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_user_id', 'followed_user_id');
    }

    /**
     * Users who are following this user.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_user_id', 'following_user_id');
    }

    /**
     * Check if this user is marked as an artist.
     */
    public function isArtist(): bool
    {
        return $this->role === self::ARTIST;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ADMIN;
    }
}
