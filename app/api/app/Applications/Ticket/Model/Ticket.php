<?php

namespace App\Applications\Ticket\Model;

use App\Applications\Event\Model\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $fillable = [
        'type',
        'price',
        'quantity',
        'sale_start',
        'sale_end',
        'event_id',
    ];

    protected $casts = [
        'price' => 'float',
        'sale_start' => 'datetime',
        'sale_end' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class,'event_id');
    }
}
