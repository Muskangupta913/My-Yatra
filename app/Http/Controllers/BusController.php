<?php

namespace App\Http\Controllers;
use App\Services\BusApiService;
use Illuminate\Http\Request;

class BusController extends Controller
{


    protected $busApiService;

    public function __construct(BusApiService $busApiService)
    {
        $this->busApiService = $busApiService;
    }

    public function searchBuses(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'source_city' => 'required|string',
            'source_code' => 'required|string',
            'destination_city' => 'required|string',
            'destination_code' => 'required|string',
            'depart_date' => 'required|date',
        ]);

        // Extract parameters from the request
        $sourceCity = $request->input('source_city');
        $sourceCode = $request->input('source_code');
        $destinationCity = $request->input('destination_city');
        $destinationCode = $request->input('destination_code');
        $departDate = $request->input('depart_date');

        // Call the Bus API service to search for buses
        $apiResponse = $this->busApiService->searchBuses($sourceCity, $sourceCode, $destinationCity, $destinationCode, $departDate);

        // Check for errors in the API response
        if (isset($apiResponse['Error']) && $apiResponse['Error']['ErrorCode'] !== 0) {
            return response()->json(['message' => $apiResponse['Error']['ErrorMessage']], 400);
        }

        // Return the bus search results
        // 
        return response()->json([
            'status' => 'success',
            'message' => 'Buses found successfully.',
            'buses' => $apiResponse['Result']['BusResults']
        ], 200);
    }

    // public function  index()
    // {
    //     return view('bus');
    // }



}
