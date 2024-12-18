<?php

namespace App\Http\Controllers;

use App\Services\BusApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BusController extends Controller
{
    protected $busApiService;

    public function __construct(BusApiService $busApiService)
    {
        $this->busApiService = $busApiService;
    }

    /**
     * Bus search using source and destination city names and codes.
     */
    public function searchBuses(Request $request)
    {
        // Step 1: Validate incoming request
        $request->validate([
            'source_city' => 'required|string',
            'source_code' => 'required|integer',
            'destination_city' => 'required|string',
            'destination_code' => 'required|integer',
            'depart_date' => 'required|date_format:Y-m-d',
        ]);

        // Step 2: Prepare the request payload
        $params = [
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
            'source_city' => trim($request->source_city), // Remove extra spaces
            'source_code' => intval($request->source_code), // Ensure it's an integer
            'destination_city' => trim($request->destination_city),
            'destination_code' => intval($request->destination_code),
            'depart_date' => date('Y-m-d', strtotime($request->depart_date)), // Ensure date is formatted correctly
        ];

        Log::info('Sending API request with payload:', $params); // Log the request payload

        try {
            // Send the request to the bus API using the Http facade
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://bus.srdvtest.com/v5dte56/rest/Search', $params);

            Log::info('API response status: ' . $response->status());
            Log::info('API response body: ', $response->json()); // Log the response body

            // Step 4: Parse the API response
            $data = $response->json();

            // Check if the response contains the expected 'BusResults'
            if (!empty($data['Result']['BusResults'])) {
                return view('bus', ['data' => $data['Result']['BusResults']]);
            } else {
                return view('bus', ['data' => []])->with('message', 'No buses available.');
            }

        } catch (\Exception $e) {
            Log::error('API Request Failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'An error occurred while searching for buses.');
        }
    }
}
