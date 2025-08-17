<?php

namespace App\Applications\Post\Model;

use App\Applications\Ticket\Model\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'venue_id',
        'is_boosted',
        'is_active',
        'post_slot'
    ];

    protected $casts = [
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('post_image')
            ->singleFile();
    }

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

    /**
     * The venue this post is held at (nullable).
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(\App\Applications\Venue\Model\Venue::class);
    }

    /**
     * ======================================BLANK FOR NOW======================================
     * TODO: rethink logic here, if for ex. we want the user to be able to search posts by Music,
     *  or something else like a Presentation, Art Exhibition etc.
     * Type of the post.
     * Ex. Club Night, Festival, Open Air, Showcase, Workshop, Private Party
     */
    public function type()
    {
//        return $this->belongsTo(\App\Applications\Common\Model\PostType::class, 'post_type_id');
        return;
    }

}
