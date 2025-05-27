<?php

namespace App\Applications\Common\Pivot;

use Illuminate\Database\Eloquent\Model;

class EventMusicGenre extends Model
{
    protected $table = 'event_music_genre';

    public $timestamps = true;

    protected $fillable = [
        'event_id',
        'music_genre_id',
    ];

    public function event()
    {
        return $this->belongsTo(\App\Applications\Event\Model\Event::class, 'event_id');
    }

    public function musicGenre()
    {
        return $this->belongsTo(\App\Applications\Common\Model\MusicGenre::class, 'music_genre_id');
    }
}
