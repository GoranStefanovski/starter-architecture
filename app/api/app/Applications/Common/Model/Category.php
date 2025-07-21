<?php   

namespace App\Applications\Common\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'user_id',
        'store_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(\App\Applications\User\Model\User::class);
    }

    public function store()
    {
        return $this->belongsTo(\App\Applications\Store\Model\Store::class);
    }
}
