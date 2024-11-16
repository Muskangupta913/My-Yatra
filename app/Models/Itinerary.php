<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itinerary extends Model
{
    use HasFactory;
    protected $fillable = ['package_id', 'day_number', 'title', 'description', 'image'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
