<?php
namespace App\Applications\WorkingHours\Model;

use App\Applications\Venue\Model\Venue;
use App\Applications\WorkingHours\Enum\DayOfWeek;
use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    protected $fillable = ['venue_id', 'day_of_week', 'opens_at', 'closes_at'];

    protected $casts = [
        'day_of_week' => DayOfWeek::class,
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }
}
