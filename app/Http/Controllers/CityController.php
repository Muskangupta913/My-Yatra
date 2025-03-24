<?php

namespace App\Http\Controllers;

use App\Models\Newcity;  
use App\Models\HotelCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
    public function fetchAllCities(Request $request)
    {
        $query = $request->input('query');
        $cities = DB::table('cities')  // Using the cities table
            ->where('city_name', 'LIKE', "%{$query}%")
            ->select('id', 'city_name')
            ->get();
    
        return response()->json([
            'status' => 'success',
            'data' => $cities
        ]);
    }


    public function autocomplete(Request $request)
    {
        $query = $request->input('query'); // Get the user's input
        if ($query) {
            // Query to fetch cities where the name starts with the input letter(s)
            $cities = Newcity::where('CityName', 'LIKE', $query . '%')
                        ->select('CityId', 'CityName')
                        ->limit(10) // Limit the number of results
                        ->get();
                        
            return response()->json($cities);
        } else {
            return response()->json([], 400); // Return an empty array if no query is provided
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

    public function fetchCitiesByState(Request $request)
    {
        $state = $request->query('state');
        $stateRecord = DB::table('states')->where('destination_name', $state)->first();
        if ($stateRecord) {
            $cities = DB::table('cities')->where('state_id', $stateRecord->id)->get();
            return response()->json($cities);
        }
        return response()->json([]);
    }

   //HOTEL RELATED CONTROLLER 

    public function hotelFetchAllCities()
    {
        try {
            // Try to get cities from cache first
            $cities = Cache::remember('hotel_cities', 3600, function () {
                return HotelCity::where('status', 'Active') // Only fetch active cities
                   ->select('Destination', 'cityid','country')
                    ->get();
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
     * Autocomplete cities based on user input.
     */
    public function hotelautocomplete(Request $request)
    {
        $query = $request->input('query'); // Get the user's input

        if ($query) {
            try {
                // Query to fetch cities where the name starts with the input letter(s)
                $cities = HotelCity::where('Destination', 'LIKE', $query . '%')
                    ->where('status', 'Active') // Only fetch active cities
                    ->select('cityid', 'Destination', 'country')
                    ->limit(10) // Limit the number of results
                    ->get();

                return response()->json([
                    'status' => 'success',
                    'data' => $cities
                ], 200);

            } catch (\Exception $e) {
                // Log the error
                Log::error('Autocomplete Error', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to fetch autocomplete results',
                    'error' => $e->getMessage()
                ], 500);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Query parameter is missing'
            ], 400); // Return an error if no query is provided
        }
    }
}



