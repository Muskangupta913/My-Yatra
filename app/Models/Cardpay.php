<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cardpay extends Model
{
    use HasFactory;

    // Disable automatic timestamping
    

    // Define the fields that can be mass assigned
    protected $fillable = ['name', 'email', 'mobile_no', 'total_amount'];
}