<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarBookings extends Model
{
    protected $table = 'car_bookings';

    protected $fillable = [
        'payment_id', // Link to payment record
        
        // Third-party API response details
        'srdv_type', 
        'srdv_index', 
        'booking_id', 
        'ref_id', 
        'operator_id', 
        'segment_id', 
        'booking_status', 
        'trace_id',
        
        // Booking details
        'customer_name', 
        'customer_phone', 
        'customer_email', 
        'customer_address',
        
        // Trip details
        'pickup_location', 
        'dropoff_location', 
        'pickup_time', 
        'dropoff_time', 
        'booking_date',
        
        // Car details
        'car_category', 
        'seating_capacity', 
        'luggage_capacity', 
        'total_price',
        // New field for full API response
        'full_api_response'
    ];

    // Relationship with Payment model
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}