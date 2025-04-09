<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'duration_minutes', // Alias for compatibility with seeder
    ];

    /**
     * Set the duration_minutes attribute.
     *
     * @param  string  $value
     * @return void
     */
    public function setDurationMinutesAttribute($value)
    {
        $this->attributes['duration'] = $value;
    }

    /**
     * Get the bookings for the service.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
