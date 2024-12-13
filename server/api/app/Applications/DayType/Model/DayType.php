<?php

namespace App\Applications\DayType\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayType extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'is_paid',
    ];
}