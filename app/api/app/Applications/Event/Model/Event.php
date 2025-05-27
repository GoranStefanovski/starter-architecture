<?php

namespace App\Applications\Event\Model;

use App\Applications\Common\Pivot\EventUserStatus;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Event extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected static function newFactory()
    {
        return EventFactory::new();
    }

    protected $fillable = [
        'name',
        'description',
        'address',
        'lng',
        'lat',
        'event_start',
        'event_end',
        'slug',
        'user_id',
        'venue_id',
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('event_images')
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
     * The user who created the event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(\App\Applications\User\Model\User::class, 'user_id');
    }

    /**
     * The venue this event is held at (nullable).
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(\App\Applications\Venue\Model\Venue::class);
    }

    /**
     * Artists performing at this event.
     */
    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(
            \App\Applications\User\Model\User::class,
            'artist_event',
            'event_id',
            'artist_id'
        );
    }

    /**
     * Users who marked this event as interested, going, or attended.
     */
    public function statuses(): HasMany
    {
        return $this->hasMany(EventUserStatus::class);
    }

    /**
     * Genres assigned to this event.
     */
    public function musicGenres(): BelongsToMany
    {
        return $this->belongsToMany(
            \App\Applications\Common\Model\MusicGenre::class,
            'event_music_genre'
        );
    }

    /**
     * ======================================BLANK FOR NOW======================================
     * TODO: rethink logic here, if for ex. we want the user to be able to search events by Music,
     *  or something else like a Presentation, Art Exhibition etc.
     * Type of the event.
     * Ex. Club Night, Festival, Open Air, Showcase, Workshop, Private Party
     */
    public function type()
    {
//        return $this->belongsTo(\App\Applications\Common\Model\EventType::class, 'event_type_id');
        return;
    }
}
