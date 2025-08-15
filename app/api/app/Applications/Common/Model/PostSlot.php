<?php

namespace App\Applications\Common\Model;

use Illuminate\Database\Eloquent\Model;

class PostSlot extends Model
{
    protected $fillable = ['name', 'order', 'is_active'];
    public $timestamps = true;
}