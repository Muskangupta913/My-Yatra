<?php

namespace App\Http\Controllers;

use App\Models\Cardpay;
use Illuminate\Http\Request;

class CardpayController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming data
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'mobile_no' => 'required|string|max:20',
                'total_amount' => 'required|numeric',
            ]);
        
            // Create a new record in the cardpay table
            Cardpay::create($validatedData);
        
            return response()->json(['success' => true]);
        
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors
            return response()->json([
                'success' => false,
                'message' => 'Validation error occurred.',
                'errors' => $e->errors()  // This will return detailed validation errors
            ]);
        } catch (\Exception $e) {
            \Log::error('Payment save error:' . $e->getMessage());
        
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving payment details. Please try again.',
                'error' => $e->getMessage()
            ]);
        }
    }
}
