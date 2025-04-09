<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_minutes',
        'is_available',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
