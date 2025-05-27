<?php

namespace App\Applications\Common\Pivot;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMusicGenre extends Model
{
    protected $table = 'user_music_genre';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'music_genre_id',
    ];

    /**
     * The user who selected the genre.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Applications\User\Model\User::class);
    }

    /**
     * The music genre selected.
     */
    public function musicGenre(): BelongsTo
    {
        return $this->belongsTo(\App\Applications\Common\Model\MusicGenre::class, 'music_genre_id');
    }

    /**
     * Scope to get entries for a specific user.
     * Ex.
     *
     * // Get all genres a user likes
     * UserMusicGenre::forUser($userId)->with('musicGenre')->get();
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get entries for a specific genre.
     * Ex.
     *
     * // Get all users who like a genre
     * UserMusicGenre::forGenre($genreId)->with('user')->get();
     */
    public function scopeForGenre($query, int $genreId)
    {
        return $query->where('music_genre_id', $genreId);
    }
}
