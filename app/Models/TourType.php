<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourType extends Model
{
    use HasFactory;

    protected $table = 'tour_type';

    protected $fillable = [
        'name'
    ];

     // Relationship with packages
     public function packages()
     {
         return $this->hasMany(Package::class, 'tour_type_id');
     }
}

?>