<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\BusApiService;
use Illuminate\Http\Request;

class BusController extends Controller
{
    protected $busApiService;

    public function __construct(BusApiService $busApiService)
    {
        $this->busApiService = $busApiService;
    }

    /**
     * Fetch all cities from the database.
     */
    public function fetchAllCities()
    {
        try {
            $cities = City::all();
            return response()->json($cities);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch cities',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Autocomplete search for cities.
     */
    public function autocomplete(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2'
        ]);

        $searchQuery = $request->input('query');
        $cities = City::where('city_name', 'LIKE', '%' . $searchQuery . '%')
                    ->limit(10)
                    ->get(['id', 'city_name', 'code']); // Fetch city name and city code

        return response()->json($cities);
    }

    /**
     * Bus search using source and destination city names and codes.
     */
    public function searchBuses(Request $request)
    {
        $validatedData = $request->validate([
            'source_city' => 'required|string',
            'source_code' => 'required|integer', // Add validation for source code
            'destination_city' => 'required|string',
            'destination_code' => 'required|integer', // Add validation for destination code
            'depart_date' => 'required|date',
        ]);

        $response = $this->busApiService->searchBuses(
            $validatedData['source_city'], 
            $validatedData['source_code'], 
            $validatedData['destination_city'], 
            $validatedData['destination_code'], 
            $validatedData['depart_date']
        );

        // Check for API errors
        if (isset($response['Error']) && $response['Error']['ErrorCode'] != 0) {
            return back()->withErrors([
                'error' => $response['Error']['ErrorMessage'] ?? 'An unknown error occurred'
            ]);
        }

        // Check if bus results exist
        if (!isset($response['Result']['BusResults']) || empty($response['Result']['BusResults'])) {
            return back()->with('message', 'No buses found for the selected route and date.');
        }

        return view('bus', ['buses' => $response['Result']['BusResults']]);
    }
}


