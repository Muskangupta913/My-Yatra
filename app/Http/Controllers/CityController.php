<?php

namespace App\Http\Controllers;

use App\Models\Newcity;  // Updated to use Newcity model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class CityController extends Controller
{
    // Show the bus page view
    public function checkCities()
    {
        return view('bus');
    }

    /**
     * Fetch all cities with caching implementation
     */
    public function fetchAllCities()
    {
        try {
            // Try to get cities from cache first
            $cities = Cache::remember('all_cities', 3600, function () {
                return Newcity::all();  // Using Newcity model to fetch cities
            });

            // Check if cities data is empty
            if ($cities->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No cities found',
                    'data' => [],
                    'total_cities' => 0
                ], 404);
            }

            // Return cities data with additional metadata
            return response()->json([
                'status' => 'success',
                'message' => 'Cities fetched successfully',
                'data' => $cities,
                'total_cities' => $cities->count()
            ], 200);

        } catch (\Exception $e) {
            // Log the error
            Log::error('City Fetch Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return error response
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch cities',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search cities by name
     */
    public function searchCity(Request $request)
    {
        $query = $request->input('query');

        // Search for cities by CityName
        $cities = Newcity::where('CityName', 'like', '%' . $query . '%')->get();

        return response()->json([
            'status' => 'success',
            'data' => $cities,
        ], 200);
    }
}


