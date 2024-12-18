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

    public function searchBuses(Request $request)
    {
        // Step 1: Validate incoming request
        $request->validate([
            'source_city' => 'required|string',
            'source_code' => 'required|string',
            'destination_city' => 'required|string',
            'destination_code' => 'required|string',
            'depart_date' => 'required|date_format:Y-m-d',
        ]);

        // Step 2: Create the exact payload structure as per API documentation
        $payload = json_encode([
            "ClientId" => "180133",
            "UserName" => "MakeMy91",
            "Password" => "MakeMy@910",
            'source_city' => trim($request->source_city),
            'source_code' => intval($request->source_code),
            'destination_city' => trim($request->destination_city),
            'destination_code' => intval($request->destination_code),
            'depart_date' => date('Y-m-d', strtotime($request->depart_date)),
        ], JSON_UNESCAPED_SLASHES);

        try {
            // Step 3: Make the API request with exact headers
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->withBody($payload, 'application/json')
              ->post('https://bus.srdvtest.com/v5/rest/Search');

            // Log for debugging
            Log::info('Bus Search Request Payload', ['payload' => json_decode($payload, true)]);
            Log::info('Bus Search Response', ['response' => $response->json()]);

            $data = $response->json();

            // Check for API-level errors first
            if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
                return response()->json([
                    'status' => false,
                    'message' => $data['Error']['ErrorMessage']
                ]);
            }

            // Check for bus results
            if (!empty($data['Result']['BusResults'])) {
                return response()->json([
                    'status' => true,
                    'data' => $data['Result']['BusResults']
                ]);
            }

            // No buses found
            return response()->json([
                'status' => false,
                'message' => 'No buses found for the selected route and date.'
            ]);

        } catch (\Exception $e) {
            Log::error('Bus Search Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while searching for buses.'
            ], 500);
        }
    }
}