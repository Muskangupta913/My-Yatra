<?php
// app/Models/Payment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusPayment extends Model
{
    use HasFactory;
    protected $table = 'buspayments';
   

    protected $fillable = [
        'order_id',
        'payment_id',
        'trace_id',
        'amount',
        'passenger_data',
        'boarding_point',
        'dropping_point',
        'seat_number',
        'status',
        'payment_response'
    ];

    protected $casts = [
        'passenger_data' => 'array',
        'payment_response' => 'array'
    ];
}