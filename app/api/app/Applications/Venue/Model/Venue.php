<?php

namespace App\Applications\Venue\Model;

use Database\Factories\VenueFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Applications\User\Model\User;
use App\Applications\Common\Model\VenueType;
use App\Applications\Common\Pivot\UserVenueAttendance;
use App\Applications\Common\Pivot\VenueRating;

class Venue extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected static function newFactory()
    {
        return VenueFactory::new();
    }

    protected $fillable = [
        'name',
        'bio',
        'address',
        'lng',
        'lat',
        'slug',
        'venue_type_id',
        'user_id',
    ];

    protected $casts = [
        'lng' => 'float',
        'lat' => 'float',
    ];

    /**
     * The owner of the venue (organization user).
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The venue type (e.g., Club, Bar, etc.).
     */
    public function type()
    {
        return $this->belongsTo(VenueType::class, 'venue_type_id');
    }

    /**
     * Ratings submitted by users for this venue.
     */
    public function ratings()
    {
        return $this->hasMany(VenueRating::class);
    }

    /**
     * Track how many times each user attended this venue.
     */
    public function attendances()
    {
        return $this->hasMany(UserVenueAttendance::class);
    }

    /**
     * Media collections for venue.
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('venue_images')
            ->useDisk('public')
            ->withResponsiveImages();
    }

    /**
     * Media conversions.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->fit(Fit::Contain, 100, 100)
            ->sharpen(10)
            ->nonQueued();
    }
}
