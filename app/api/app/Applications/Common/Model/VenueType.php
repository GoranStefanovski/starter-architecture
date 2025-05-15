<?php

namespace App\Applications\Common\Model;

use Illuminate\Database\Eloquent\Model;

class VenueType extends Model
{
    protected $fillable = ['name', 'order'];
    public $timestamps = true;
}
