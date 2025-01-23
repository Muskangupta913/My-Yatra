<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarCity extends Model
{
    protected $table = 'car_on_city_list'; 
    protected $primaryKey = 'caoncitlst_id'; 

    // Columns that can be mass-assigned
    protected $fillable = [
        'caoncitlst_city_name',
        'caoncitlst_status',
        'caoncitlst_id', 
    ];
}
