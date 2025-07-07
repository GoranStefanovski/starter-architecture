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
        'country',
        'city',
        'address',
        'lng',
        'lat',
        'email',
        'phone_number',
        'slug',
        'is_active',
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


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('venue_image');
    }
    /**
     * Media collections for venue.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumbnail') // map popup or compact card
            ->fit(Fit::Contain, 320, 180)
            ->withResponsiveImages()
            ->nonQueued();

        $this
            ->addMediaConversion('card') // card list or grid
            ->fit(Fit::Crop, 640, 360)
            ->withResponsiveImages()
            ->nonQueued();

        $this
            ->addMediaConversion('banner') // full width display
            ->fit(Fit::Crop, 1280, 720)
            ->withResponsiveImages()
            ->nonQueued();
    }
}
