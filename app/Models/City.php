<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = [
        'state_id',
        'city_name',
        'code'  
    ]; 

    public function destination()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

  

}

?>