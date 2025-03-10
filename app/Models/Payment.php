<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Explicitly define the table name if it's different
    protected $table = 'payments';

    // Fillable fields for mass assignment
    protected $fillable = [
        'order_id',
        'payment_id',
        'signature',
        'amount',
        'currency',
        'status'
    ];

    // Optional: Add a default status if needed
    protected $attributes = [
        'status' => 'pending'
    ];

    // Optional: Add validation rules
    public static function rules()
    {
        return [
            'order_id' => 'required|string|max:255',
            'payment_id' => 'required|string|max:255',
            'signature' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'currency' => 'required|string|max:3'
        ];
    }
}