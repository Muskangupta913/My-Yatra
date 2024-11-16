<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'package';

    protected $fillable = [
        'destination_id',
        'tour_type_id',
        'package_name',
        'slug',
        'duration',
        'ragular_price',
        'offer_price',
        'photo',
        'start_date',
        'end_date',
        'last_booking',
        'map',
        'short_description',
        'description',
        'location',
        'itinerary',
        'policy',
        'terms',
        'title',
        'meta_description',
        'status',
    ];


    public function destination()
{
    return $this->belongsTo(State::class, 'destination_id', 'id');
}


public function city()
{
    return $this->belongsTo(City::class);
}

public function photos()
{
    return $this->hasMany(PackagePhoto::class, 'package_id', 'id');
}

public function tourType()
{
    return $this->belongsTo(TourType::class, 'tour_type_id');
}

}



?>