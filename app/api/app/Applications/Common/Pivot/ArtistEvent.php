<?php

namespace App\Applications\Common\Pivot;

use Illuminate\Database\Eloquent\Model;

class ArtistEvent extends Model
{
    protected $table = 'artist_event';

    public $timestamps = true;

    protected $fillable = [
        'artist_id',
        'event_id',
    ];

    // Optional: Define relationships for convenience
    public function artist()
    {
        return $this->belongsTo(\App\Applications\User\Model\User::class, 'artist_id');
    }

    public function event()
    {
        return $this->belongsTo(\App\Applications\Event\Model\Event::class, 'event_id');
    }
}
