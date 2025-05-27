<?php

namespace App\Applications\Common\Pivot;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VenueRating extends Model
{
    protected $table = 'venue_ratings';

    public $timestamps = true;

    //TODO: might be smart to move comment(or make this a base class)
    // to a new class, so maybe events and other things down the road can have ratings/comments by users, and venue_id will be Morphable
    protected $fillable = [
        'user_id',
        'venue_id',
        'rating',
        'comment',
        'created_at',
    ];

    /**
     * The user who submitted the rating.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Applications\User\Model\User::class);
    }

    /**
     * The rated venue.
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(\App\Applications\Venue\Model\Venue::class);
    }

    /**
     * Scope to filter ratings for a specific venue.
     * Ex.
     *
     * //Average rating for a venue
     * VenueRating::forVenue($venueId)->avg('rating');
     */
    public function scopeForVenue($query, int $venueId)
    {
        return $query->where('venue_id', $venueId);
    }

    /**
     * Scope to filter ratings made by a specific user.
     * Ex.
     *
     * //Check if User has rated a venue already
     * VenueRating::forUser($userId)->forVenue($venueId)->exists();
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include venue ratings that have a non-empty comment.
     * This filters out null and whitespace-only comments.
     * Ex.
     *
     * //Get all comments for a venue
     * VenueRating::forVenue($venueId)
     *      ->withComments()
     *      ->with('user') // optional: eager load commenter
     *      ->get();
     */
    public function scopeWithComments($query)
    {
        return $query->whereNotNull('comment')
            ->whereRaw("TRIM(comment) != ''");
    }
}
