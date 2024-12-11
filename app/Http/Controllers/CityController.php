<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\BusApiService;
use App\Models\City;

class CityController extends Controller
{
   //service provider 
    protected $busApiService;

    public function __construct(BusApiService $busApiService)
    {
        $this->busApiService = $busApiService;
    }

    
    //fetch all cities
    // Fetch all cities
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
    //searchcitiesss
    public function searchCities(Request $request)
    {
        $request->validate([
            'state_id' => 'required|integer',
        ]);
                 
    
        $stateId = $request->input('state_id');
        $cities = City::where('state_id', $stateId)->get();
    
        // If no cities found, call the third-party API
        if ($cities->isEmpty()) {
            $apiResponse = $this->busApiService->fetchCityList(); // Call the method from BusApiService
    
            // Check if the API response is successful
            if (isset($apiResponse['Error']) && $apiResponse['Error']['ErrorCode'] === 1) {
                return response()->json(['message' => 'No cities found'], 404);
            }
    
            // Check if the API response structure is as expected
            if (!isset($apiResponse['Result']['CityList'])) {
                return response()->json(['message' => 'Unexpected API response structure'], 500);
            }
    
            // Process the API response and return it
            return response()->json($apiResponse['Result']['CityList']);
        }
    
        return response()->json($cities);
    }

    

    public function autocomplete(Request $request)
    {
        // Validate the request input
        $request->validate([
            'query' => 'required|string|min:2'
        ]);

        // Get the query from the request
        $searchQuery = $request->input('query');

        // Query the database for matching cities (customize as needed)
        $cities = City::where('city_name', 'LIKE', '%' . $searchQuery . '%')
                    ->limit(10) // Limit the results
                    ->get(['id', 'city_name', 'code']); // Return only the necessary columns

        // Return the JSON response
        return response()->json($cities);
    }
    





    public function delhi()
    {
        return view('delhi');
    }

    public function goaTour()
    {
        return view('goaTour');
    }

    public function manali()
    {
        return view('manali');
    }

    public function kerala(Request $request)
    {
        return view('kerala');
    }

    public function coimbatore()
    {
        return view('coimbatore');
    }

    public function mussoorie()
    {
        return view('mussoorie');
    }
}
