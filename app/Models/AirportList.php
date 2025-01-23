<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirportList extends Model
{
    use HasFactory;

    protected $table = 'airport_list';

    protected $fillable = [
        'airport_id',
        'airport_name',
        'airport_code',
        'airport_city_name',
    ];
}
