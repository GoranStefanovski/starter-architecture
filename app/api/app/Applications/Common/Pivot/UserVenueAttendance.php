<?php

namespace App\Applications\Common\Pivot;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVenueAttendance extends Model
{
    protected $table = 'user_venue_attendance';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'venue_id',
        'attendance_count',
        'last_attended_at',
    ];

    /**
     * The user who attended the venue.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Applications\User\Model\User::class);
    }

    /**
     * The venue that was attended.
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(\App\Applications\Venue\Model\Venue::class);
    }

    /**
     * Scope to get attendances for a specific user.
     * Ex.
     *
     * //Get all venues a user attended
     * UserVenueAttendance::forUser($userId)->with('venue')->get();
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get attendances for a specific venue.
     * Ex.
     *
     * //Get all users who attended a venue
     * UserVenueAttendance::forVenue($venueId)->with('user')->get();
     */
    public function scopeForVenue($query, int $venueId)
    {
        return $query->where('venue_id', $venueId);
    }
}
