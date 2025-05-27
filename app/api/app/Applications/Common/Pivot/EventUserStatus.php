<?php

namespace App\Applications\Common\Pivot;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventUserStatus extends Model
{
    protected $table = 'event_user_status';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'event_id',
        'status', // 'interested', 'going', 'attended'
    ];

    /**
     * User who set this status.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Applications\User\Model\User::class);
    }

    /**
     * Event this status belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(\App\Applications\Event\Model\Event::class);
    }

    /**
     * Scope for a specific status (interested, going, attended).
     * Ex.
     *
     * EventUserStatus::withStatus('interested')->get();
     */
    public function scopeWithStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by event.
     * Ex.
     *
     * // All users marked as "going" for a specific event
     * EventUserStatus::forEvent($eventId)->withStatus('going')->get();
     */
    public function scopeForEvent($query, int $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    /**
     * Scope for filtering by user.
     * Ex.
     *
     * // All events a user is interested in
     * EventUserStatus::forUser($userId)->withStatus('interested')->with('event')->get();
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
