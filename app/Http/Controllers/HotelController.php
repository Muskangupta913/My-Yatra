<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use \Illuminate\Support\Facades\DB;




class HotelController extends Controller
{

    protected $ClientId;
    protected $UserName;
    protected $Password;
    protected $ApiToken;

    public function __construct()
    {
         $this->ClientId = env('HOTEL_API_CLIENT_ID' , '180189');
        $this->UserName = env('HOTEL_API_USERNAME', 'MakeMy91');
        $this->Password = env('HOTEL_API_PASSWORD', 'MakeMy@910');
        $this->ApiToken = env('HOTEL_API_TOKEN', 'MakeMy@910@23');
    }





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

public function roomDetail(){
    return view ('BlockRoomDetails');
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
            'ClientId' => $this->ClientId,
            'UserName' => $this->UserName,
            'Password' => $this->Password,
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
                    "ChildAge" => $guest['ChildAge'] ?? [15],
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
        ])->post('https://hotel.srdvapi.com/v8/rest/Search', $payload);

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
           'ClientId' => $this->ClientId,
            'UserName' => $this->UserName,
            'Password' => $this->Password,
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
            ])->post('https://hotel.srdvapi.com/v8/rest/GetHotelInfo', $payload);
    
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
           'ClientId' => $this->ClientId,
            'UserName' => $this->UserName,
            'Password' => $this->Password,
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23'
            ])->post('https://hotel.srdvapi.com/v8/rest/GetHotelRoom', $payload);

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
           'ClientId' => $this->ClientId,
            'UserName' => $this->UserName,
            'Password' => $this->Password,
            'EndUserIp' => '1.1.1.1',
            'SrdvIndex' => '15',
            'SrdvType' => 'MixAPI',
        ]);

        // Make the API call
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Token' => 'MakeMy@910@23'
        ])->post('https://hotel.srdvapi.com/v8/rest/BlockRoom', $payload);

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


public function handleBalance(Request $request)
{

    $request->validate([
        'EndUserIp' => 'required|string',
        'ClientId' => 'required|string',
        'UserName' => 'required|string',
        'Password' => 'required|string'
    ]);
    // Prepare API request payload
    $payload = [
       'ClientId' => $this->ClientId,
            'UserName' => $this->UserName,
            'Password' => $this->Password,
            "EndUserIp" => "1.1.1.1",
    ];

    try {
        // Make the API call
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
             'Api-Token' => 'MakeMy@910@23'
        ])->post('https://hotel.srdvapi.com/v8/rest/Balance', $payload);

        // Handle the response
        $balanceData = $response->json();

        // Check for API success
        if ($response->successful() && isset($balanceData['Error'])) {
            if ($balanceData['Error']['ErrorCode'] === "0") {
                return response()->json([
                    'status' => 'success',
                    'balance' => $balanceData['Balance'],
                    'creditLimit' => $balanceData['CreditLimit']
                ]);
            } else {
                // API returned an error
                return response()->json([
                    'status' => 'error',
                    'message' => $balanceData['Error']['ErrorMessage'] ?? 'API Error'
                ], 400);
            }
        }

        // Log unexpected response format
        \Log::error('Balance API Unexpected Response:', ['response' => $balanceData]);
        
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid response from balance service'
        ], 400);

    } catch (\Exception $e) {
        \Log::error('Balance API Exception:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while fetching balance details'
        ], 500);
    }
}


public function balanceLog(Request $request)
{
    // Extract data from the request body instead of query parameters
    $requestBody = $request->json()->all();
    $traceId = $requestBody['TraceId'] ?? null;
    $amount = $requestBody['amount'] ?? null;

    // Validate required parameters
    if (!$traceId || !$amount) {
        return response()->json([
            'success' => false,
            'errorMessage' => 'Missing required parameters (TraceId or amount)',
        ]);
    }

    // Hotel Balance Log API request data
    $requestData = [
        'EndUserIp' => $requestBody['EndUserIp'] ?? '1.1.1.1',
       'ClientId' => $this->ClientId,
            'UserName' => $this->UserName,
            'Password' => $this->Password,
    ];

    // Make the API call
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Api-Token' => 'MakeMy@910@23'
    ])->post('https://hotel.srdvapi.com/v8/rest/BalanceLog', $requestData);

    // Parse the API response
    $data = $response->json();

    // Log the full API response for debugging
    \Log::info('Hotel Balance API Response:', $data);

    // Check for successful response and ensure the `Result` key exists
    if (isset($data['Error']) && $data['Error']['ErrorCode'] === '0' && isset($data['Result'])) {
        $results = $data['Result'];
        $processedLogs = [];

        foreach ($results as $result) {
            $currentBalance = ($result['Balance']);
            $debitAmount = ($amount);

            // Debugging log
            \Log::info("Processing Hotel Log: Current Balance: {$currentBalance}, Debit Amount: {$debitAmount}");

            // Calculate updated balance
            $updatedBalance = $currentBalance - $debitAmount;

            // Check for insufficient balance
            if ($updatedBalance < 0) {
                \Log::warning("Insufficient Balance for Transaction. TraceID: {$traceId}");
                return response()->json([
                    'success' => false,
                    'errorMessage' => 'Insufficient balance.',
                ]);
            }

            // Build the processed log entry
            $processedLogs[] = [
                'ID' => $result['ID'],
                'Date' => $result['Date'],
                'ClientID' => $result['ClientID'],
                'ClientName' => $result['ClientName'],
                'Detail' => $result['Detail'],
                'Debit' => $debitAmount,
                'Credit' => floatval($result['Credit']),
                'Balance' => $updatedBalance,
                'Module' => $result['Module'],
                'TraceID' => $traceId,
                'RefID' => $result['RefID'],
                'UpdatedBy' => $result['UpdatedBy']
            ];
        }

        return response()->json([
            'success' => true,
            'balanceLogs' => $processedLogs,
        ]);
    }

    return response()->json([
        'success' => false,
        'errorMessage' => $data['Error']['ErrorMessage'] ?? 'Unknown error occurred.',
    ]);
}





public function bookRoom(Request $request)
{
    try {
        $data = $request->all();
        
        // Add detailed validation
        \Log::info('Incoming request data:', $data);
        
        if (!isset($data['HotelRoomsDetails'][0]['RoomId'])) {
            return response()->json([
                'success' => false,
                'errorMessage' => 'Missing required RoomId'
            ]);
        }
        
        // Check if HotelPassenger is missing
        if (!isset($data['HotelRoomsDetails'][0]['HotelPassenger'])) {
            return response()->json([
                'success' => false,
                'errorMessage' => 'Missing required HotelPassenger details'
            ]);
        }
        if (!isset($data['HotelRoomsDetails'][0]['HotelPassenger'][0]['PaxType'])) {
            return response()->json([
                'success' => false,
                'errorMessage' => 'Missing required PaxType details'
            ]);
        }
        


        
        // Ensure each room detail has all required fields
        $hotelRoomsDetails = array_map(function($room) {
            if (!isset($room['RoomIndex'])) {
                throw new \Exception('RoomIndex is required for each room');
            }
            
            return [

                'RoomId' => $room['RoomId'],
                'RoomStatus' => 'Active',
              'RoomIndex' => $room['RoomIndex'],
                'RoomTypeCode' => $room['RoomTypeCode'],
                'RoomTypeName' => $room['RoomTypeName'],
                'RatePlanCode' => $room['RatePlanCode'],
                'RatePlan' => $room['RatePlan'],
                'InfoSource' => $room['InfoSource'] ?? '',
                'SequenceNo' => $room['SequenceNo'] ?? '',
                'SmokingPreference' => $room['SmokingPreference'] ?? '0',
                'ChildCount' => $room['ChildCount'],
                'RequireAllPaxDetails' => $room['RequireAllPaxDetails'] ?? false,
                'HotelPassenger' => array_map(function($passenger) {
                    return [
                        'Title' => $passenger['Title'],
                        'FirstName' => $passenger['FirstName'],
                        'LastName' => $passenger['LastName'],
                        'Phoneno' => $passenger['Phoneno'],
                        'Email' => $passenger['Email'],
                        'PaxType' => $passenger['PaxType'],
                        'LeadPassenger' => $passenger['LeadPassenger'] ?? false,
                        'PAN' => $passenger['PAN'] ?? ''
                    ];
                }, $room['HotelPassenger'])
            ];
        }, $data['HotelRoomsDetails']);

        $bookingRequest = [
            "ResultIndex" => $data['ResultIndex'],
            "HotelCode" => $data['HotelCode'],
            "HotelName" => $data['HotelName'],
            "GuestNationality" => $data['GuestNationality'] ?? "IN",
            "NoOfRooms" => $data['NoOfRooms'],
            "ClientReferenceNo" => $data['ClientReferenceNo'] ?? 0,
            "IsVoucherBooking" => true,
            "HotelRoomsDetails" => $hotelRoomsDetails,
            "SrdvType" => "MixAPI",
            "SrdvIndex" => $data['SrdvIndex'] ?? "15",
            "TraceId" => $data['TraceId'],
            "EndUserIp" => "1.1.1.1",
           'ClientId' => $this->ClientId,
            'UserName' => $this->UserName,
            'Password' => $this->Password,
        ];

        // Enhanced logging
        \Log::info('Booking API Request:', ['payload' => $bookingRequest]);

        // Make the API request with error handling
        $response = Http::timeout(30)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23'
            ])
            ->post('https://hotel.srdvapi.com/v8/rest/Book', $bookingRequest);

        // Log the raw response
        \Log::info('Raw API Response:', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        $responseData = $response->json();

        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'errorMessage' => 'API request failed: ' . $response->status(),
                'details' => $responseData
            ]);
        }

        if (!isset($responseData['BookResult'])) {
            return response()->json([
                'success' => false,
                'errorMessage' => 'Invalid API response format',
                'response' => $responseData
            ]);
        }

        if (isset($responseData['BookResult']['Error']) && 
            $responseData['BookResult']['Error']['ErrorCode'] !== 0) {
            return response()->json([
                'success' => false,
                'errorMessage' => $responseData['BookResult']['Error']['ErrorMessage'] ?? 'Booking failed',
                'errorDetails' => $responseData['BookResult']['Error']
            ]);
        }

        return response()->json([
            'success' => true,
            'bookingDetails' => [
                'Status' => $responseData['BookResult']['Status'],
                'HotelBookingStatus' => $responseData['BookResult']['HotelBookingStatus'],
                'ConfirmationNo' => $responseData['BookResult']['ConfirmationNo'],
                'BookingRefNo' => $responseData['BookResult']['BookingRefNo'],
                'BookingId' => $responseData['BookResult']['BookingId'],
                'InvoiceNumber' => $responseData['BookResult']['InvoiceNumber']
            ]
        ]);

    } catch (\Exception $e) {
        \Log::error('Booking Error:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'errorMessage' => 'An error occurred while processing your booking',
            'details' => $e->getMessage()
        ]);
    }
}



public function cancelRoom(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'EndUserIp' => 'required|string',
        'ClientId' => 'required|string',
        'UserName' => 'required|string',
        'Password' => 'required|string',
        'BookingId' => 'required|string',
        'RequestType' => 'required|string',
        'BookingMode' => 'required|string',
        'SrdvType' => 'required|string',
        'SrdvIndex' => 'required|string',
        'Remarks' => 'nullable|string'
    ]);

    // Prepare the payload for the API request
    $payload = [
        'EndUserIp' => '1.1.1.1',
        'ClientId' => $this->ClientId,
        'UserName' => $this->UserName,
        'Password' => $this->Password,
        'BookingId' => $request->BookingId,
        'BookingMode' => $request->BookingMode,
        'SrdvType' => $request->SrdvType,
        'SrdvIndex' => $request->SrdvIndex,
        'RequestType' => $request->RequestType,
        'Remarks' => $request->Remarks ?? 'User  requested cancellation'
    ];

    try {
        // Make the API request to cancel the bus booking
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Token' => 'MakeMy@910@23'  // Use the class property
        ])->post('https://hotel.srdvapi.com/v8/rest/SendHotelChangeRequest', $payload);

        $data = $response->json();
        Log::info('Cancel Bus Booking API Response:', ['response' => $data]);

        // Check for errors in the response
        if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
            return response()->json([
                'status' => 'error',
                'message' => $data['Error']['ErrorMessage'] ?? 'Error canceling bus booking'
            ], 400);
        }

        // Return success response
        return response()->json([
            'status' => 'success',
            'data' => $data['Result']
        ]);

    } catch (\Exception $e) {
        Log::error('Error in cancelBus:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while canceling the bus booking',
            'error' => $e->getMessage()
        ], 500);
    }
}


}