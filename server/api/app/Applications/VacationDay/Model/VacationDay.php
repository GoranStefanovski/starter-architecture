<?php

namespace App\Applications\VacationDay\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Applications\User\Model\User;
use App\Applications\DayType\Model\DayType;

class VacationDay extends Model
{
    use SoftDeletes, HasFactory;
    const SICK_DAY_PAID = 1;
    const SICK_DAY_UNPAID = 2;
    const DAY_OFF_PAID = 3;
    const DAY_OFF_UNPAID = 4;
    const HOLIDAY = 5;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'date_from',
        'date_to',
        'year',
        'day_type_id',
        'handler_id',
        'uuid',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        // Add fields you don't want to expose in API responses
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_from' => 'date',
        'date_to' => 'date',
        'year' => 'integer',
        'uuid' => 'string',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<string>
     */
    protected $appends = [
        // Add any computed properties you want to include
    ];

    /**
     * Relationship with User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship with DayType
     */
    public function dayType()
    {
        return $this->belongsTo(DayType::class, 'day_type_id');
    }
 
}
