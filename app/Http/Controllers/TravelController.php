<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TravelController extends Controller
{
    /**
     * Display the travel page.
     */
    public function index()
    {
        return view('travel-bharat');
    }

    /**
     * Handle travel booking submissions.
     */
    public function book(Request $request)
    {
        // Validate the booking form inputs
        $validated = $request->validate([
            'full_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'terms' => 'accepted',
        ]);

        // Redirect back with success message
        return redirect()->route('travel.bharat')->with('success', 'Your booking has been successfully submitted!');
    }
}
