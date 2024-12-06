<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $table = 'destination';

    protected $fillable = [
        'destination_name',
        'destination_id',
        'slug',
        'heading',
        'short_description',
        'package_heading',
        'package_subheading',
        'detail_heading',
        'detail_subheading',
        'photo',
        'introduction',
        'experience',
        'weather',
        'hotel',
        'transportation',
        'culture',
        'title',
        'meta_description',
        'status'
    ];

    public function cities()
{
    return $this->hasMany(City::class);
}


   
}

?>