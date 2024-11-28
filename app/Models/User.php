<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    // Your existing model properties
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'is_verified', 
    ];

    // Other methods, relationships, etc.
    public function bookings()
{
    return $this->hasMany(Booking::class, 'user_id');
}

}
