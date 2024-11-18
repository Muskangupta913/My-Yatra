<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';

    protected $fillable = [
        'package_id',
        'full_name',
        'phone',
        'email',
        'adults',
        'children',
        'travel_date',
        'terms_accepted'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function passengers()
    {
        return $this->hasMany(Passenger::class, 'booking_id');
    }
}

