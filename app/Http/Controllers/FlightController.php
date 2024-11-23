<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FlightController extends Controller
{
    // Show the flight booking page
    public function index()
    {
        return view('flight-booking');
    }

    // Handle the search form submission
    public function search(Request $request)
    {
        $validated = $request->validate([
            'fromCity' => 'required|string',
            'toCity' => 'required|string',
            'departureDate' => 'required|date',
            'returnDate' => 'nullable|date',
            'passengers' => 'required|integer|min:1',
            'class' => 'required|string',
        ]);

        // Placeholder response (replace with API or database query)
        $flights = [
            'from' => $validated['fromCity'],
            'to' => $validated['toCity'],
            'departure' => $validated['departureDate'],
            'return' => $validated['returnDate'] ?? null,
            'passengers' => $validated['passengers'],
            'class' => $validated['class'],
        ];

        return view('flight-results', compact('flights'));
    }
}