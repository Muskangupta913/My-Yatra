<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;




class HotelController extends Controller
{
    public function  index()
{
    return view('hotels');
}

public function showSearchResults()
{
    return view('Hotel-search-results');
}

public function hotelinfo(){
    return view('HotelDetails');
}


// Controller: HotelController.php

public function search(Request $request)
{
    // Add logging to debug the incoming request
    \Log::info('Search Request:', $request->all());

    // Validate and format incoming request
    if ($request->has('CheckInDate')) {
        $date = \DateTime::createFromFormat('d/m/Y', $request->input('CheckInDate'));
        if ($date) {
            $request->merge(['CheckInDate' => $date->format('Y-m-d')]);
        }
    }

    try {
        $payload = [
            "ClientId" => "180133",
            "UserName" => "MakeMy91",
            "Password" => "MakeMy@910",
            "EndUserIp" => "1.1.1.1",
            "BookingMode" => "5",
            "CheckInDate" => $request->input('CheckInDate'),
            "NoOfNights" => (string)$request->input('NoOfNights'),
            "CityId" => $request->input('CityId', '699261'),
            "CountryCode" => $request->input('CountryCode', ''),
            "GuestNationality" => $request->input('GuestNationality'),
            "PreferredCurrency" => "INR",
            "NoOfRooms" => (string)$request->input('NoOfRooms'),
            "RoomGuests" => array_map(function ($guest) {
                return [
                    "NoOfAdults" => (string)$guest['NoOfAdults'],
                    "NoOfChild" => (string)$guest['NoOfChild'],
                    "ChildAge" => $guest['ChildAge'] ?? [],
                ];
            }, $request->input('RoomGuests')),
            // Add these optional parameters that were in the example request
            "MinRating" => "0",
            "MaxRating" => "5",
            "IsNearBySearchAllowed" => false
        ];

        // Log the payload being sent to the API
        \Log::info('API Payload:', $payload);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Token' => 'MakeMy@910@23',
        ])->post('https://hotel.srdvtest.com/v8/rest/Search', $payload);

        // Log the raw API response
        \Log::info('API Response:', ['status' => $response->status(), 'body' => $response->body()]);

        // Check if the response is successful and has the expected structure
        if (!$response->successful()) {
            return response()->json([
                'status' => 'error',
                'message' => 'API request failed with status ' . $response->status()
            ], 500);
        }

        $apiResponse = $response->json();

        // Check if we got a valid JSON response
        if (!$apiResponse) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid JSON response from API'
            ], 500);
        }

        // Check for API error response
        if (isset($apiResponse['Error']) && $apiResponse['Error']['ErrorCode'] !== 0) {
            return response()->json([
                'status' => 'error',
                'message' => $apiResponse['Error']['ErrorMessage']
            ], 500);
        }

        // Check if Results exists and is not empty
        if (!isset($apiResponse['Results']) || empty($apiResponse['Results'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'No results found'
            ], 404);  // Changed to 404 for "not found"
        }

        return response()->json([
            'status' => 'success',
            'results' => $apiResponse['Results'],
            'traceId' => $apiResponse['TraceId'] ?? null,
            'checkOutDate' => $apiResponse['CheckOutDate'] ?? null,
        ]);

    } catch (\Exception $e) {
        \Log::error('Search API Error:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch hotel data: ' . $e->getMessage()
        ], 500);
    }
}




public function hotelDetails(Request $request)
    {
        // Validate incoming request
        $request->validate([
           'resultIndex' => 'required|string',
            'traceId' => 'required|string',     // Ensure it's a string
            'hotelCode' => 'required|string',   // Ensure it's a string
        ]);

        // Prepare API request payload
        $payload = [
            "ClientId" => "180133",
            "UserName" => "MakeMy91",
            "Password" => "MakeMy@910",
            "EndUserIp" => "1.1.1.1",
            "SrdvIndex" => "15",      // Static data as per API documentation
            "SrdvType" => "MixAPI",   // Static data as per API documentation
            "ResultIndex" => $request->input('resultIndex'), // Dynamic value
            "TraceId" => $request->input('traceId'),
            "HotelCode" => $request->input('hotelCode'), // Hotel code is same as resultIndex
        ];

    try{
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23'
            ])->post('https://hotel.srdvtest.com/v8/rest/GetHotelInfo', $payload);
    
            // Get the response from the API
           
            if ($response->successful()) {
                $hotelInfo = $response->json();
                
                if (isset($hotelInfo['HotelInfoResult']['Error']['ErrorCode']) && 
                    $hotelInfo['HotelInfoResult']['Error']['ErrorCode'] === 0) {
                    return response()->json([
                        'status' => 'success',
                        'data' => $hotelInfo
                    ]);
                }
            }

            // Log the response for debugging
            \Log::error('Hotel API Error Response:', ['response' => $response->body()]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch hotel details'
            ], 400);


        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching hotel details'
            ], 500);
        }

    }

    public function hotelRoomDetails(Request $request)
    {
        $request->validate([
            'resultIndex' => 'required|string',
            'traceId' => 'required|integer',
            'hotelCode' => 'required|string',
            'srdvIndex' => 'required|string',
            'srdvType' => 'required|string',
        ]);

        $payload = [
            "ResultIndex" => $request->input('resultIndex'),
            "SrdvIndex" => "15",
            "SrdvType" =>  "MixAPI",
            "HotelCode" => $request->input('hotelCode'),
            "TraceId" => $request->input('traceId'),
            "EndUserIp" => "1.1.1.1",
            "ClientId" => "180133",
            "UserName" => "MakeMy91",
            "Password" => "MakeMy@910"
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23'
            ])->post('https://hotel.srdvtest.com/v8/rest/GetHotelRoom', $payload);

            if ($response->successful()) {
                $roomDetails = $response->json();

                if (isset($roomDetails['GetHotelRoomResult']['Error']['ErrorCode']) &&
                    $roomDetails['GetHotelRoomResult']['Error']['ErrorCode'] === 0) {

                    return response()->json([
                        'status' => 'success',
                        'data' => [
                            'hotelRoomsDetails' => $roomDetails['GetHotelRoomResult']['HotelRoomsDetails'],
                            'roomCombinations' => $roomDetails['GetHotelRoomResult']['RoomCombinations'],
                            'isPolicyPerStay' => $roomDetails['GetHotelRoomResult']['IsPolicyPerStay'],
                            'isUnderCancellationAllowed' => $roomDetails['GetHotelRoomResult']['IsUnderCancellationAllowed']
                        ],
                    ]);
                }
            }

            Log::error('Hotel API Error Response:', ['response' => $response->body()]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch hotel details'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Hotel API Exception:', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching hotel details'
            ], 500);
        }
    }


    public function blockRoom(Request $request)
{
    try {
        // Validate the request input
        $validated = $request->validate([
            'HotelName' => 'required|string',
            'GuestNationality' => 'required|string',
            'NoOfRooms' => 'required|integer',
            'HotelRoomsDetails' => 'required|array',
            'HotelRoomsDetails.*.RoomId' => 'required|string',
            'HotelRoomsDetails.*.RoomIndex' => 'required|string',
            'HotelRoomsDetails.*.RoomTypeCode' => 'required|string',
            'ResultIndex' => 'required|string',
            'TraceId' => 'required|integer',
            'HotelCode' => 'required|string',
        ]);

        // Prepare the request payload
        $payload = array_merge($validated, [
            'IsVoucherBooking' => true,
            'ClientReferenceNo' => 0,
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
            'EndUserIp' => '1.1.1.1',
            'SrdvIndex' => '15',
            'SrdvType' => 'MixAPI',
        ]);

        // Make the API call
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Token' => 'MakeMy@910@23'
        ])->post('https://hotel.srdvtest.com/v8/rest/BlockRoom', $payload);

        $responseData = $response->json();

        // Check if the API response is successful
        if ($response->successful() && isset($responseData['BlockRoomResult'])) {
            $blockRoomResult = $responseData['BlockRoomResult'];

            if (isset($blockRoomResult['Error']['ErrorCode']) && $blockRoomResult['Error']['ErrorCode'] === 0) {
                // Log successful blocking
                Log::info('Room blocked successfully', [
                    'HotelName' => $blockRoomResult['HotelName'] ?? 'Unknown',
                    'TraceId' => $blockRoomResult['TraceId'] ?? 'Unknown',
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Room blocked successfully',
                    'data' => $blockRoomResult,
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => $blockRoomResult['Error']['ErrorMessage'] ?? 'Failed to block room',
                'error' => $blockRoomResult['Error'],
            ], 400);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to process room blocking request',
            'error' => $responseData,
        ], $response->status());
    } catch (\Exception $e) {
        Log::error('Room Blocking Error: ' . $e->getMessage(), ['exception' => $e]);

        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while processing the room blocking request',
            'error' => $e->getMessage(),
        ], 500);
    }
}
}