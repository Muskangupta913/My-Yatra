<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;



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

public function hoteldetails(){
    return view('HotelDetails');
}


// Controller: HotelController.php

public function search(Request $request) {
    // Validate incoming request
    if ($request->has('CheckInDate')) {
        $date = \DateTime::createFromFormat('m/d/Y', $request->input('CheckInDate'));
        if ($date) {
            $request->merge(['CheckInDate' => $date->format('d/m/Y')]);
        }
    }

    // Validate incoming request
    $request->validate([
        'CheckInDate' => 'required|date_format:d/m/Y',
        'NoOfNights' => 'required|integer',
        'GuestNationality' => 'required|string',
        'NoOfRooms' => 'required|integer',
        'RoomGuests' => 'required|array',
        'RoomGuests.*.NoOfAdults' => 'required|integer',
        'RoomGuests.*.NoOfChild' => 'required|string',
    ]);
    // Format CheckInDate
    $formattedDate = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('CheckInDate'))->format('d/m/Y');

    // Prepare API request payload matching the exact structure
    $payload = [
        "ClientId" => "180133",
        "UserName" => "MakeMy91",
        "Password" => "MakeMy@910",
        "EndUserIp" => "1.1.1.1",
        "BookingMode" => "5",
        "CheckInDate" => $formattedDate,
        "NoOfNights" => (string)$request->input('NoOfNights'),
        "CityId" => $request->input('CityId', '130443'),
        "CountryCode" => $request->input('CountryCode', 'IN'),
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
       
    ];

    try {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Token' => 'MakeMy@910@23'
        ])->post('https://hotel.srdvtest.com/v5/rest/Search', $payload);

        $apiResponse = $response->json();

        if (isset($apiResponse['Error']) && $apiResponse['Error']['ErrorCode'] !== 0) {
            return response()->json([
                'status' => 'error',
                'message' => $apiResponse['Error']['ErrorMessage']
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'results' => $apiResponse['Results'] ?? [],
            'traceId' => $apiResponse['TraceId'] ?? 12263,
            'checkOutDate' => $apiResponse['CheckOutDate'] ?? null
            
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch hotel data: ' . $e->getMessage()
        ], 500);
    }
}





public function getHotelDetails(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'resultIndex' => 'required|integer', // Required field for fetching hotel details
        ]);

        // Prepare API request payload
        $payload = [
            "ClientId" => "180133",
            "UserName" => "MakeMy91",
            "Password" => "MakeMy@910",
            "EndUserIp" => "1.1.1.1",
            "SrdvIndex" => "15",      // Static data as per API documentation
            "SrdvType" => "MixAPI",   // Static data as per API documentation
            "ResultIndex" => $request->input('resultIndex', 'hsid3359333842-15079424'), // Dynamic value
            "TraceId" => $request->input('traceId',' 12207'),
            "HotelCode" => $request->input('hotelCode', 'hsid3359333842-15079424'), // Hotel code is same as resultIndex
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23'
            ])->post('https://hotel.srdvtest.com/v5/rest/GetHotelInfo', $payload);
    
            // Get the response from the API
            $apiResponse = $response->json();

            // Check if the response is successful
            if (isset($apiResponse['HotelInfoResult']['Error']['ErrorCode']) && $apiResponse['HotelInfoResult']['Error']['ErrorCode'] !== 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => $apiResponse['HotelInfoResult']['Error']['ErrorMessage']
                ], 500);
            }

            // Return the hotel details
            return response()->json([
                'status' => 'success',
                'hotelDetails' => $apiResponse['HotelInfoResult']['HotelDetails'] ?? [],
                'hotelImages' => $apiResponse['HotelInfoResult']['HotelDetails']['Images'] ?? [],
                'hotelLocation' => $apiResponse['HotelInfoResult']['HotelDetails']['Location'] ?? null,
                'hotelPolicies' => $apiResponse['HotelInfoResult']['HotelDetails']['PolicyAndInstruction'] ?? [],
                'hotelContact' => $apiResponse['HotelInfoResult']['HotelDetails']['HotelContactNo'] ?? null,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch hotel details: ' . $e->getMessage()
            ], 500);
        }
    }
}
