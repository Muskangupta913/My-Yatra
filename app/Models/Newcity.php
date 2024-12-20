<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newcity extends Model
{
    use HasFactory;
    protected $table = 'newcities';
    protected $fillable = [
        'CityId',
        'CityName',
    ];

    // If you don't need timestamps (created_at, updated_at), set this to false
    public $timestamps = true;
}

