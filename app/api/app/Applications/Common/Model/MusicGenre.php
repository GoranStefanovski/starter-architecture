<?php

namespace App\Applications\Common\Model;

use Illuminate\Database\Eloquent\Model;

class MusicGenre extends Model
{
    protected $fillable = ['name', 'order'];
    public $timestamps = true;
}