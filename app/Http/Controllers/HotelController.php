<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use \Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use App\Models\RazorpayPayment;
use Exception;





class HotelController extends Controller
{

    protected $ClientId;
    protected $UserName;
    protected $Password;
    protected $ApiToken;

    public function __construct()
    {
         $this->ClientId = env('HOTEL_API_CLIENT_ID' , '180133');
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
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
            "EndUserIp" => "1.1.1.1",
            "BookingMode" => "5",
            "CheckInDate" => $request->input('CheckInDate'),
            "NoOfNights" => (string)$request->input('NoOfNights'),
            "CityId" => $request->input('CityId'),
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

        ini_set('max_execution_time', '300'); // 5 minutes
        ini_set('default_socket_timeout', '300');
        set_time_limit(300);
        
        // Then modify your HTTP request:
        $response = Http::timeout(300)
            ->connectTimeout(300)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23',
            ])
            ->withOptions([
                'curl' => [
                    CURLOPT_TIMEOUT => 300,
                    CURLOPT_CONNECTTIMEOUT => 300
                ]
            ])
            ->retry(3, 100)
            ->post('https://hotel.srdvtest.com/v8/rest/Search', $payload);

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
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
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
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
            "EndUserIp" => "1.1.1.1",
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
            "EndUserIp" => "1.1.1.1",
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
        'ClientId' => '180133',
        'UserName' => 'MakeMy91',
        'Password' => 'MakeMy@910',
        "EndUserIp" => "1.1.1.1",
    ];

    try {
        // Make the API call
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
             'Api-Token' => 'MakeMy@910@23'
        ])->post('https://hotel.srdvtest.com/v8/rest/Balance', $payload);

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
    // Validate request data
    $validated = $request->validate([
        'TraceId' => 'required|string',
        'amount' => 'required|numeric'
    ]);

    // Extract validated data
    $traceId = $validated['TraceId'];
    $amount = $validated['amount'];

    // Hotel Balance Log API request data
    $requestData = [
        'ClientId' => '180133',
        'UserName' => 'MakeMy91',
        'Password' => 'MakeMy@910',
        'EndUserIp' => '1.1.1.1',
    ];

    try {
        // Make the API call
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Token' => 'MakeMy@910@23'
        ])->post('https://hotel.srdvtest.com/v8/rest/BalanceLog', $requestData);

        // Parse the API response
        $data = $response->json();

        // Log the API response for debugging
        \Log::info('Hotel Balance API Response:', ['response' => $data]);

        // Check for successful response
        if (isset($data['Error']) && $data['Error']['ErrorCode'] === '0' && isset($data['Result']) && is_array($data['Result'])) {
            
            // Get the first result item (API returns array of results)
            $result = $data['Result'][0];
            
            // Verify we have a valid result with required fields
            if (!isset($result['Balance'])) {
                throw new \Exception('Balance information not found in API response');
            }

            $currentBalance = floatval($result['Balance']);
            $debitAmount = floatval($amount);

            // Debugging log
            \Log::info("Processing Hotel Log: Current Balance: {$currentBalance}, Debit Amount: {$debitAmount}");

            // Calculate updated balance
            $updatedBalance = $currentBalance - $debitAmount;

            // Check for insufficient balance
            if ($updatedBalance < 0) {
                return response()->json([
                    'success' => false,
                    'errorMessage' => 'Insufficient balance.',
                    'currentBalance' => $currentBalance,
                    'requiredAmount' => $debitAmount
                ]);
            }

            // Prepare the processed log entry
            $processedLog = [
                'ID' => $result['ID'],
                'Date' => $result['Date'],
                'ClientID' => $result['ClientID'],
                'ClientName' => $result['ClientName'],
                'Detail' => $result['Detail'],
                'Debit' => $debitAmount,
                'Credit' => floatval($result['Credit'] ?? 0),
                'Balance' => $updatedBalance,
                'Module' => $result['Module'],
                'TraceID' => $traceId,
                'RefID' => $result['RefID'] ?? '',
                'UpdatedBy' => $result['UpdatedBy']
            ];

            return response()->json([
                'success' => true,
                'balanceLog' => $processedLog,
                'currentBalance' => $currentBalance,
                'updatedBalance' => $updatedBalance
            ]);
        }

        // Handle API error response
        $errorMessage = $data['Error']['ErrorMessage'] ?? 'Unknown error occurred';
        throw new \Exception("API Error: {$errorMessage}");

    } catch (\Exception $e) {
        \Log::error('Balance Log Error: ' . $e->getMessage(), [
            'trace_id' => $traceId,
            'amount' => $amount
        ]);

        return response()->json([
            'success' => false,
            'errorMessage' => $e->getMessage()
        ]);
    }
}

// Helper function to check if all keys exist in an array
function array_key_exists_all(array $keys, array $arr) {
    return !array_diff_key(array_flip($keys), $arr);
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
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
            "EndUserIp" => "1.1.1.1",
        ];

        // Enhanced logging
        \Log::info('Booking API Request:', ['payload' => $bookingRequest]);

        // Make the API request with error handling
        $response = Http::timeout(30)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23'
            ])
            ->post('https://hotel.srdvtest.com/v8/rest/Book', $bookingRequest);

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




//ORDER BASED API CALLS
public function createOrder(Request $request)
{
    try {
        // Validate the request
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'currency' => 'nullable|string|size:3',
            'receipt' => 'nullable|string',
            'hotelCode' => 'nullable|string',
            'hotelName' => 'nullable|string',
            'traceId' => 'nullable|string',
            'customerEmail' => 'nullable|email',
            'customerPhone' => 'nullable|string',
            'bookingId' => 'nullable|string'
        ]);

        // Initialize Razorpay API
        $api = new Api('rzp_test_cvVugPSRGGLWtS', 'xHoRXawt9gYD7vitghKq1l5c');

        
        // Create order
        $orderData = [
            'receipt' => $request->receipt ?? 'receipt_' . time(),
            'amount' => round($request->amount * 100), // Convert to paise
            'currency' => $request->currency ?? 'INR',
            'notes' => [
                'hotelCode' => $request->hotelCode ?? '',
                'hotelName' => $request->hotelName ?? '',
                'traceId' => $request->traceId ?? '',
                'customerEmail' => $request->customerEmail ?? '',
                'customerPhone' => $request->customerPhone ?? '',
                'bookingId' => $request->bookingId ?? 'BKG-' . time() . '-' . rand(100, 999), 
            ]
        ];
        
        $razorpayOrder = $api->order->create($orderData);
        
        // Create a payment record with pending status
        $payment = new RazorpayPayment([
            'razorpay_order_id' => $razorpayOrder->id,
            'razorpay_payment_id' => 'pending_' . uniqid(), // Temporary unique identifier
            'amount' => $request->amount,
            'currency' => $request->currency ?? 'INR',
            'trace_id' => $request->traceId,
            'hotel_code' => $request->hotelCode,
            'hotel_name' => $request->hotelName,
            'customer_email' => $request->customerEmail,
            'customer_phone' => $request->customerPhone,
            'status' => 'pending',
            'booking_id' => $request->bookingId ?? $orderData['notes']['bookingId'],
        ]);
        
        $payment->save();
        
        return response()->json([
            'success' => true,
            'order_id' => $razorpayOrder->id,
            'amount' => $request->amount,
            'currency' => $request->currency ?? 'INR',
            'key_id' => env('rzp_test_cvVugPSRGGLWtS')
        ]);
        
    } catch (Exception $e) {
        Log::error('Failed to create Razorpay order', [
            'error' => $e->getMessage()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to create order: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Verify Razorpay payment
 */
public function verifyPayment(Request $request)
{
    try {
        // Validate the request
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        // Initialize Razorpay API
        $api = new Api('rzp_test_cvVugPSRGGLWtS', 'xHoRXawt9gYD7vitghKq1l5c');

        // Get payment data from request
        $razorpay_payment_id = $request->razorpay_payment_id;
        $razorpay_order_id = $request->razorpay_order_id;
        $razorpay_signature = $request->razorpay_signature;
        
        // Find existing payment record or create a new one
        $payment = RazorpayPayment::where('razorpay_order_id', $razorpay_order_id)->first();
        
        if (!$payment) {
            // Log this unusual situation
            Log::warning('Payment record not found for verification', [
                'order_id' => $razorpay_order_id,
                'payment_id' => $razorpay_payment_id
            ]);
            
            // Fetch order details to get amount
            try {
                $order = $api->order->fetch($razorpay_order_id);
                
                $payment = new RazorpayPayment([
                    'razorpay_order_id' => $razorpay_order_id,
                    'razorpay_payment_id' => $razorpay_payment_id,
                    'razorpay_signature' => $razorpay_signature,
                    'amount' => $order->amount / 100, // Convert from paise
                    'currency' => $order->currency,
                    'status' => 'pending'
                ]);
            } catch (Exception $orderFetchError) {
                Log::error('Failed to fetch order details', [
                    'error' => $orderFetchError->getMessage(),
                    'order_id' => $razorpay_order_id
                ]);
                
                // Create a payment record with basic info
                $payment = new RazorpayPayment([
                    'razorpay_order_id' => $razorpay_order_id,
                    'razorpay_payment_id' => $razorpay_payment_id,
                    'razorpay_signature' => $razorpay_signature,
                    'status' => 'pending'
                ]);
            }
        } else {
            // Update existing record
            $payment->razorpay_payment_id = $razorpay_payment_id;
            $payment->razorpay_signature = $razorpay_signature;
        }
        
        // Save initial record
        $payment->save();
        
        try {
            // Generate signature for verification
            $attributes = [
                'razorpay_payment_id' => $razorpay_payment_id,
                'razorpay_order_id' => $razorpay_order_id
            ];
            
            // Verify signature
            $api->utility->verifyPaymentSignature($attributes + ['razorpay_signature' => $razorpay_signature]);
            
            // If verification passes, fetch payment details
            try {
                $razorpayPayment = $api->payment->fetch($razorpay_payment_id);
                
                // Update payment status to success
                $payment->status = 'success';
                $payment->payment_method = $razorpayPayment->method ?? null;
                
                // Update customer info if available
                if (!$payment->customer_email && isset($razorpayPayment->email)) {
                    $payment->customer_email = $razorpayPayment->email;
                }
                
                if (!$payment->customer_phone && isset($razorpayPayment->contact)) {
                    $payment->customer_phone = $razorpayPayment->contact;
                }
            } catch (Exception $paymentFetchError) {
                // Log error but still consider payment successful if signature verification passed
                Log::warning('Failed to fetch payment details but signature verified', [
                    'error' => $paymentFetchError->getMessage(),
                    'payment_id' => $razorpay_payment_id
                ]);
                
                $payment->status = 'success';
            }
            
            $payment->save();
            
            // Log successful payment
            Log::info('Payment verified successfully', [
                'payment_id' => $razorpay_payment_id,
                'amount' => $payment->amount,
                'currency' => $payment->currency
            ]);
            
            // For API calls, return JSON
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment verified successfully',
                    'payment_id' => $razorpay_payment_id
                ]);
            }
            
            // Collect all booking details to pass to success page
            $successParams = [
                'payment_id' => $razorpay_payment_id,
            ];
            
            // Add additional booking details if provided
            if ($request->has('traceId')) {
                $successParams['traceId'] = $request->traceId;
            }
            if ($request->has('hotelCode')) {
                $successParams['hotelCode'] = $request->hotelCode;
            }
            if ($request->has('hotelName')) {
                $successParams['hotelName'] = $request->hotelName;
            }
            if ($request->has('roomDetails')) {
                $successParams['roomDetails'] = $request->roomDetails;
            }
            if ($request->has('passengerDetails')) {
                $successParams['passengerDetails'] = $request->passengerDetails;
            }
            
            // For web requests, redirect to success page with all parameters
            return redirect()->route('payment.success', $successParams)
                ->with('success', 'Payment processed successfully');
            
        } catch (Exception $verificationError) {
            // Update payment status to failed
            $payment->status = 'failed';
            $payment->error_message = $verificationError->getMessage();
            $payment->save();
            
            // Log verification error
            Log::error('Payment verification failed', [
                'payment_id' => $razorpay_payment_id,
                'error' => $verificationError->getMessage()
            ]);
            
            // For API calls, return JSON
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment verification failed: ' . $verificationError->getMessage()
                ], 400);
            }
            
            // For web requests, redirect to failure page
            return redirect()->route('payment.failed')
                ->with('error', 'Payment verification failed: ' . $verificationError->getMessage());
        }
        
    } catch (Exception $e) {
        // Log general error
        Log::error('Payment processing error', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()  // Add stack trace for better debugging
        ]);
        
        // Check if we have payment data in the request
        if ($request->has('razorpay_payment_id') && $request->has('razorpay_order_id')) {
            // Try to verify payment status directly with Razorpay
            try {
                $api = new Api('rzp_test_cvVugPSRGGLWtS', 'xHoRXawt9gYD7vitghKq1l5c');
                $paymentInfo = $api->payment->fetch($request->razorpay_payment_id);
                
                // If payment is authorized or captured, consider it successful
                if (in_array($paymentInfo->status, ['authorized', 'captured'])) {
                    // Create or update payment record
                    $payment = RazorpayPayment::updateOrCreate(
                        ['razorpay_order_id' => $request->razorpay_order_id],
                        [
                            'razorpay_payment_id' => $request->razorpay_payment_id,
                            'razorpay_signature' => $request->razorpay_signature,
                            'status' => 'success',
                            'amount' => $paymentInfo->amount / 100,
                            'currency' => $paymentInfo->currency
                        ]
                    );
                    
                    // Collect all booking details to pass to success page
                    $successParams = [
                        'payment_id' => $request->razorpay_payment_id,
                    ];
                    
                    // Add additional booking details if provided
                    if ($request->has('traceId')) {
                        $successParams['traceId'] = $request->traceId;
                    }
                    if ($request->has('resultIndex')) {
                        $successParams['resultIndex'] = $request->resultIndex;
                    }

                    if ($request->has('hotelCode')) {
                        $successParams['hotelCode'] = $request->hotelCode;
                    }
                    if ($request->has('hotelName')) {
                        $successParams['hotelName'] = $request->hotelName;
                    }
                    if ($request->has('roomDetails')) {
                        $successParams['roomDetails'] = $request->roomDetails;
                    }
                    if ($request->has('passengerDetails')) {
                        $successParams['passengerDetails'] = $request->passengerDetails;
                    }
                    
                    // Redirect to success page with all parameters
                    return redirect()->route('payment.success', $successParams)
                        ->with('success', 'Payment processed successfully');
                }
            } catch (Exception $razorpayError) {
                Log::error('Failed to verify payment with Razorpay directly', [
                    'error' => $razorpayError->getMessage()
                ]);
            }
        }
        
        // For API calls, return JSON
        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Payment processing error: ' . $e->getMessage()
            ], 500);
        }
        
        // For web requests, redirect to failure page
        return redirect()->route('payment.failed')
            ->with('error', 'Payment processing error: ' . $e->getMessage());
    }
}
/**
 * Show payment success page
 */
public function showSuccessPage(Request $request)
{
    $payment = null;
    $paymentId = $request->payment_id;
    $bookingDetails = [
        'traceId' => $request->traceId,
        'resultIndex' => $request->resultIndex,
        'hotelCode' => $request->hotelCode,
        'hotelName' => $request->hotelName,
        'roomDetails' => $request->roomDetails,
        'passengerDetails' => $request->passengerDetails,
        'payment_id' => $paymentId
    ];
    
    
    if ($paymentId) {
        $payment = RazorpayPayment::where('razorpay_payment_id', $paymentId)->first();
    }
    
    return view('frontend.payments_success', [
        'payment' => $payment,
        'bookingDetails' => $bookingDetails
    ]);
}

/**
 * Show payment failed page
 */
public function showFailedPage()
{
    return view('frontend.payments_failed');
}

/**
 * Update booking details for a payment
 */
public function updateBookingDetails(Request $request)
{
    try {
        // Validate the request
        $request->validate([
            'payment_id' => 'required|string',
            'booking_id' => 'required|string',
            'booking_details' => 'nullable|array'
        ]);
        
        $payment = RazorpayPayment::where('razorpay_payment_id', $request->payment_id)->first();
        
        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Payment record not found'
            ], 404);
        }
        
        $payment->booking_id = $request->booking_id;
        
        if ($request->has('booking_details')) {
            $payment->booking_details = $request->booking_details;
        }
        
        $payment->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Payment updated with booking details'
        ]);
        
    } catch (Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error updating payment: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Get payment details by ID
 */
public function getPaymentDetails($paymentId)
{
    $payment = RazorpayPayment::where('razorpay_payment_id', $paymentId)->first();
    
    if (!$payment) {
        return response()->json([
            'success' => false,
            'message' => 'Payment not found'
        ], 404);
    }
    
    return response()->json([
        'success' => true,
        'payment' => $payment
    ]);
}

/**
 * Get payment history for a particular contact (email or phone)
 */
public function getPaymentHistory(Request $request)
{
    $request->validate([
        'email' => 'nullable|email',
        'phone' => 'nullable|string'
    ]);
    
    $query = RazorpayPayment::query();
    
    if ($request->has('email')) {
        $query->where('customer_email', $request->email);
    }
    
    if ($request->has('phone')) {
        $query->where('customer_phone', $request->phone);
    }
    
    if (!$request->has('email') && !$request->has('phone')) {
        return response()->json([
            'success' => false,
            'message' => 'Either email or phone is required'
        ], 400);
    }
    
    $payments = $query->orderBy('created_at', 'desc')->get();
        
    return response()->json([
        'success' => true,
        'payments' => $payments
    ]);
}



}