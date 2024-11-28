<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id'
    ];

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Package model
    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    // Cart Model
public function booking()
{
    return $this->hasOne(Booking::class, 'package_id', 'package_id')
                ->where('user_id', $this->user_id);  // Ensures it’s the current user's booking
}
}