<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'pnr',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'amount',
        'currency',
        'status',
        'booking_details',
        'is_round_trip',
        'outbound_details',
        'return_details',
        'payment_method',
        'payment_date',
        'user_name',
        'email',
        'contact'
    ];

    protected $casts = [
        'booking_details' => 'array',
        'outbound_details' => 'array',
        'return_details' => 'array',
        'is_round_trip' => 'boolean',
        'payment_date' => 'datetime',
        'amount' => 'decimal:2'
    ];
    
    public function getIsSuccessfulAttribute()
    {
        return $this->status === 'success';
    }
}