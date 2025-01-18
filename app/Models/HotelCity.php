<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelCity extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'hotel_city_code_v8';

    // Disable timestamps if they aren't following Laravel's convention
    public $timestamps = false;

    // Specify fillable columns to allow mass assignment
    protected $fillable = [
        'Destination',
        'cityid',
        'country',
        'status',
        'countrycode',
        'stateprovince'
    ];
}
