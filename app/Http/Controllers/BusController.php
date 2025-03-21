<?php


namespace App\Http\Controllers;

use App\Services\BusApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Razorpay\Api\Api;
use App\Models\BusPayment;

use Exception;

class BusController extends Controller
{
    
    protected $ClientId;
    protected $UserName;
    protected $Password;
    protected $ApiToken;

    public function __construct()
    {
         $this->ClientId = env('BUS_API_CLIENT_ID' , '180133');
        $this->UserName = env('BUS_API_USERNAME', 'MakeMy91');
        $this->Password = env('BUS_API_PASSWORD', 'MakeMy@910');
        $this->ApiToken = env('BUS_API_TOKEN', 'MakeMy@910@23');
    }

    public function index()
    {
        return view('bus');
    }


    public function bookpage (){
        return view('bookSeats');
    }
    public function showSeatLayout(Request $request)
    {
        return view('seat-layout');
    }
    
    public function searchBuses(Request $request)
    {
        // Validate the input
        $request->validate([
            'source_city' => 'required|string',
            'source_code' => 'required|string',
            'destination_city' => 'required|string',
            'destination_code' => 'required|string',
            'depart_date' => 'required|date_format:Y-m-d',
        ]);
    
        // Create the payload
        $payload = json_encode([
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
            'source_city' => trim($request->source_city),
            'source_code' => (int) trim($request->source_code),
            'destination_city' => trim($request->destination_city),
            'destination_code' => (int) trim($request->destination_code),
            'depart_date' => Carbon::createFromFormat('Y-m-d', $request->depart_date)->format('Y-m-d'),
        ], JSON_UNESCAPED_SLASHES);
    
        try {
            // Log the payload
            Log::info('Payload Sent:', json_decode($payload, true));
    
            // Make the API request
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23', // Use the class property
            ])->withBody($payload, 'application/json')
                ->post('https://bus.srdvtest.com/v8/rest/Search');
    
            // Decode the JSON response
            $data = $response->json();
    
            // Log the response for debugging
            Log::info('API Response:', $data);
    
            // Check for errors in the response
            if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
                return response()->json([
                    'status' => false,
                    'message' => $data['Error']['ErrorMessage'] ?? 'An unknown error occurred',
                ]);
            }
    
            // Check if there are bus results
            if (!isset($data['Result']) || empty($data['Result'])) {
                Log::warning('No Result Found Response:', $data);
                return response()->json([
                    'status' => false,
                    'message' => 'No buses found for the selected route and date.',
                ]);
            }
    
            // Return the results
            return response()->json([
                'status' => true,
                'traceId' => $data['TraceId'] ?? null,
                'data' => $data['Result'],
            ]);
    
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Exception in Search Buses:', ['error' => $e->getMessage()]);
    
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while searching for buses: ' . $e->getMessage(),
            ], 500);
        }
    }
    

    public function getSeatLayout(Request $request) {
        $request->validate([
            'TraceId' => 'required|string',
            'ResultIndex' => 'required|string',
        ]);
    
        $payload = json_encode([
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
            "TraceId" => $request->TraceId,
            "ResultIndex" => $request->ResultIndex,
        ], JSON_UNESCAPED_SLASHES);
    
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23',
            ])->withBody($payload, 'application/json')
              ->post('https://bus.srdvtest.com/v8/rest/GetSeatLayOut');
    
            $data = $response->json();
    
            if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
                return response()->json([
                    'status' => false,
                    'message' => $data['Error']['ErrorMessage'] ?? 'Error fetching seat layout',
                ]);
            }
    
            // Determine bus type
            $busType = $this->determineBusType($data);
    
            // Normalize the data based on bus type
            $normalizedData = $this->normalizeLayoutData($data, $busType);
    
            return response()->json([
                'status' => true,
                'busType' => $busType,
                'data' => $normalizedData
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching seat layout.',
            ], 500);
        }
    }
    
    private function determineBusType($data) {
        $hasSleeperSeats = false;
        $hasSeaterSeats = false;
    
        // Check lower deck
        if (isset($data['Result'])) {
            $result = $data['Result'];
            if (is_array($result)) {
                // Seater bus format
                foreach ($result as $row) {
                    if (is_array($row)) {
                        foreach ($row as $seat) {
                            if (isset($seat['SeatType'])) {
                                if ($seat['SeatType'] == 1) $hasSeaterSeats = true;
                                if ($seat['SeatType'] == 2) $hasSleeperSeats = true;
                            }
                        }
                    }
                }
            }
        }
    
        if ($hasSleeperSeats && $hasSeaterSeats) {
            return 'mixed';
        } elseif ($hasSleeperSeats) {
            return 'sleeper';
        } else {
            return 'seater';
        }
    }
    
    private function normalizeLayoutData($data, $busType) {
        $normalized = [
            'lower' => [],
            'upper' => [],
            'availableSeats' => $data['AvailableSeats'] ?? 0
        ];
    
        // Handle lower deck based on bus type
        if (isset($data['Result'])) {
            if ($busType === 'seater') {
                $normalized['lower'] = $data['Result'];
            } else {
                // For sleeper and mixed buses
                $normalized['lower'] = $this->convertObjectToArray($data['Result']);
            }
        }
    
        // Handle upper deck if exists
        if (isset($data['ResultUpperSeat'])) {
            $normalized['upper'] = $this->convertObjectToArray($data['ResultUpperSeat']);
        }
    
        return $normalized;
    }
    
    private function convertObjectToArray($data) {
        $result = [];
        if (is_object($data)) {
            $data = (array) $data;
        }
        foreach ($data as $key => $value) {
            if (is_object($value) || is_array($value)) {
                $result[$key] = $this->convertObjectToArray($value);
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }




    public function getBoardingPoints(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'TraceId' => 'required|string',
            'ResultIndex' => 'required|string'
        ]);
    
        // Full payload with all required parameters
        $payload = [
            'EndUserIp' => '1.1.1.1',
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
            'TraceId' => $request->TraceId,
            'ResultIndex' => $request->ResultIndex
        ];
    
        try {
            // Log the request payload
            Log::info('Boarding Points API Request:', ['payload' => $payload]);
    
            // Make the API call
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23',  // Use the class property
            ])->post('https://bus.srdvtest.com/v8/rest/GetBoardingPointDetails', $payload);
    
            $data = $response->json();
    
            // Log the response
            Log::info('Boarding Points API Response:', ['response' => $data]);
    
            // Check for API-specific errors
            if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => $data['Error']['ErrorMessage'] ?? 'Unknown error occurred.'
                ], 400);
            }
    
            // Format Boarding and Dropping Points
            $boardingPoints = $data['BoardingPoints'] ?? [];
            $droppingPoints = $data['DroppingPoints'] ?? [];
    
            $formattedBoardingPoints = array_map(function ($point) {
                return [
                    'index' => $point['CityPointIndex'] ?? 'N/A',
                    'name' => $point['CityPointName'] ?? 'N/A',
                    'address' => $point['CityPointAddress'] ?? 'N/A',
                    'landmark' => $point['CityPointLandmark'] ?? 'N/A',
                    'contact_number' => $point['CityPointContactNumber'] ?? 'N/A',
                    'location' => $point['CityPointLocation'] ?? 'N/A',
                    'time' => $point['CityPointTime'] ?? 'N/A',
                ];
            }, $boardingPoints);

            $formattedDroppingPoints = array_map(function ($point) {
                return [
                    'index' => $point['CityPointIndex'] ?? 'N/A',
                    'name' => $point['CityPointName'] ?? 'N/A',
                    'location' => $point['CityPointLocation'] ?? 'N/A',
                    'time' => $point['CityPointTime'] ?? 'N/A',
                ];
            }, $droppingPoints);
    
            // Return the formatted response
            return response()->json([
                'status' => 'success',
                'data' => [
                    'boarding_points' => $formattedBoardingPoints,
                    'dropping_points' => $formattedDroppingPoints,
                ]
            ]);
    
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error in getBoardingPoints:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching boarding points',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function blockSeats(Request $request)
    {
        // Validate basic required fields
        $request->validate([
            'ResultIndex' => 'required|string',
            'TraceId' => 'required|string',
            'BoardingPointId' => 'required',
            'DroppingPointId' => 'required',
            'RefID' => 'required',
            'Passenger' => 'required|array',
            'Passenger.*.LeadPassenger' => 'required|boolean',
            'Passenger.*.Title' => 'required|string',
            'Passenger.*.FirstName' => 'required|string',
            'Passenger.*.LastName' => 'required|string',
            'Passenger.*.Email' => 'required|email',
            'Passenger.*.Mobile' => 'required|string',
            'Passenger.*.Gender' => 'required',
            'Passenger.*.Age' => 'required',
            'Passenger.*.Address' => 'required|string',
            'Passenger.*.SeatIndex' => 'required|string',
            // Optional fields
            'Passenger.*.IdType' => 'nullable|string',
            'Passenger.*.IdNumber' => 'nullable|string',
            'Passenger.*.PassengerId' => 'nullable|integer'
        ]);
    
        // Prepare payload with credentials
        $payload = array_merge([
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
        ], $request->all());
    
        try {
            // Log request payload for debugging
            Log::info('Block Seats Request Payload:', ['payload' => $payload]);
    
            // Make API request
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23',
            ])->post('https://bus.srdvtest.com/v8/rest/Block', $payload);
    
            $data = $response->json();
            Log::info('Block Seats API Response:', ['response' => $data]);
    
            // Check for API errors
            if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
                return response()->json([
                    'status' => false,
                    'message' => $data['Error']['ErrorMessage'] ?? 'Error blocking seats'
                ], 400);
            }
    
            // Format successful response
            return response()->json([
                'status' => true,
                'data' => [
                    'TraceId' => $data['TraceId'] ?? null,
                    'DepartureTime' => $data['DepartureTime'] ?? null,
                    'ArrivalTime' => $data['ArrivalTime'] ?? null,
                    'BusType' => $data['BusType'] ?? null,
                    'ServiceName' => $data['ServiceName'] ?? null,
                    'TravelName' => $data['TravelName'] ?? null,
                    'Price' => $data['Price'] ?? null,
                    'BoardingPointdetails' => $data['BoardingPointdetails'] ?? null,
                    'DroppingPointsDetails' => $data['DroppingPointsDetails'] ?? null,
                    'CancellationPolicy' => $data['CancellationPolicy'] ?? [],
                    'Passengers' => array_map(function($passenger) {
                        return [
                            'LeadPassenger' => $passenger['LeadPassenger'] ?? false,
                            'Title' => $passenger['Title'] ?? '',
                            'Address' => $passenger['Address'] ?? '',
                            'Age' => $passenger['Age'] ?? null,
                            'FirstName' => $passenger['FirstName'] ?? '',
                            'Gender' => $passenger['Gender'] ?? null,
                            'IdNumber' => $passenger['IdNumber'] ?? null,
                            'IdType' => $passenger['IdType'] ?? null,
                            'Phoneno' => $passenger['Phoneno'] ?? '',
                            'Seat' => $passenger['Seat'] ?? null
                        ];
                    }, $data['Passengers'] ?? [])
                ]
            ]);
    
        } catch (\Exception $e) {
            Log::error('Error in blockSeats:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while blocking seats',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function bookBus(Request $request)
    {
        $request->validate([
            'ResultIndex' => 'required|string',
            'TraceId' => 'required|string',
            'BoardingPointId' => 'required|integer|min:1', 
            'DroppingPointId' => 'required|integer|min:1', 
            'RefID' => 'required',
            'Passenger' => 'required|array',
            'Passenger.*.LeadPassenger' => 'required|boolean',
            'Passenger.*.Title' => 'required|string',
            'Passenger.*.FirstName' => 'required|string',
            'Passenger.*.LastName' => 'required|string',
            'Passenger.*.Email' => 'required|email',
            'Passenger.*.Phoneno' => 'required',
            'Passenger.*.Gender' => 'required',
            'Passenger.*.Age' => 'required',
            'Passenger.*.Address' => 'required|string',
            'Passenger.*.Seat' => 'required|array'
        ]);

        $payload = array_merge([
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
        ], $request->all());

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23',  // Use the class property
            ])->post('https://bus.srdvtest.com/v8/rest/Book', $payload);

            $data = $response->json();
            Log::info('Book API Response:', ['response' => $data]);

            if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => $data['Error']['ErrorMessage'] ?? 'Error booking bus'
                ], 400);
            }

            return response()->json([
                'status' => 'success',
                'data' => $data['Result']
            ]);

        } catch (\Exception $e) {
            Log::error('Error in bookBus:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while booking the bus',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showBookingConfirmation(Request $request)
    {
        // Get query parameters from the URL
        $traceId = $request->query('TraceId');
        $busBookingStatus = $request->query('BusBookingStatus');
        $invoiceAmount = $request->query('InvoiceAmount');
        $busId = $request->query('BusId');
        $ticketNo = $request->query('TicketNo');
        $travelOperatorPNR = $request->query('TravelOperatorPNR');
        
        // Pass all relevant data to the view
        return view('frontend.payment', compact('traceId', 'busBookingStatus', 'invoiceAmount', 'busId', 'ticketNo', 'travelOperatorPNR'));
    }
    



    
    public function cancelBus(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'EndUserIp' => 'required|string',
            'ClientId' => 'required|string',
            'UserName' => 'required|string',
            'Password' => 'required|string',
            'BusId' => 'required|string',
            'SeatId' => 'required|string',
            'Remarks' => 'nullable|string'
        ]);

        // Prepare the payload for the API request
        $payload = [
            'EndUserIp' => '1.1.1.1',
            'ClientId' => $this->ClientId,
            'UserName' => $this->UserName,
            'Password' => $this->Password,
            'BusId' => $request->BusId,
            'SeatId' => $request->SeatId,
            'Remarks' => $request->Remarks ?? 'User  requested cancellation'
        ];

        try {
            // Make the API request to cancel the bus booking
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                 'Api-Token' => $this->ApiToken,  // Use the class property
            ])->post('https://bus.srdvtest.com/v5/rest/cancelbusbooking', $payload);

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



    public function fetchBalance()
    {
        $payload = [
            'EndUser Ip' => '1.1.1.1',
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
             'Api-Token' => 'MakeMy@910@23',  // Use the class property
        ])->post('https://bus.srdvtest.com/v5/rest/Balance', $payload);

        if ($response->successful()) {
            $data = $response->json();

            if ($data['Error']['ErrorCode'] == '0') {
                return response()->json([
                    'balance' => $data['Balance'],
                    'creditLimit' => $data['CreditLimit']
                ]);
            }

            return response()->json(['error' => $data['Error']['ErrorMessage']], 400);
        }

        return response()->json(['error' => 'Failed to fetch balance'], 500);
    }


   public function balance(Request $request)
{
    $traceId = $request->input('TraceId');
   $invoiceAmount = $request->input('Amount'); // Change 'InvoiceAmount' to 'amount'
   $passengerData = $request->input('PassengerData');


    // Step 1: Fetch balance from third-party API
    $balanceResponse = $this->fetchBalance();
    $balanceData = $balanceResponse->getData(); // Assuming fetchBalance() returns JSON as Laravel Response
    
    if (isset($balanceData->error)) {
        return response()->json([
            'Error' => [
                'ErrorCode' => '1',
                'ErrorMessage' => $balanceData->error
            ]
        ]);
    }

    $balance = $balanceData->balance ?? 0;

    // Step 2: Check if balance is sufficient
    if ($balance >= $invoiceAmount) {
        return response()->json([
            'success' => true,
            'navigateToPayment' => true,
            'url' => "/payment?TraceId={$traceId}&amount={$invoiceAmount}"
        ]);
    }

    // Step 3: Insufficient balance
    return response()->json([
        'success' => false,
        'errorMessage' => 'Your wallet balance is insufficient. You cannot proceed with payment.'
    ]);
}





public function balanceLog(Request $request)
{
    $traceId = $request->query('TraceId');
    $amount = $request->query('amount');

    // Balance Log API request data
    $requestData = [
        'EndUserIp' => '1.1.1.1',
        'ClientId' => '180133',
        'UserName' => 'MakeMy91',
        'Password' => 'MakeMy@910',
    ];

    // Make API call
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Api-Token' => $this->ApiToken,
    ])->post('https://bus.srdvtest.com/v5/rest/BalanceLog', $requestData);

    // Parse the API response
    $data = $response->json();

    // Log the full API response for debugging
    \Log::info('Balance API Response:', $data);

    // Check for successful response and ensure Result key exists
    if (isset($data['Error']) && $data['Error']['ErrorCode'] === '0' && isset($data['Result'])) {
        $results = $data['Result']; // `Result` is an array of records
        $processedLogs = [];

        // Iterate through the Result array to process balance logs
        foreach ($results as $result) {
            $currentBalance = $result['Balance'];
            $debitAmount = $amount;

            // Debugging log: Check values before calculating
            \Log::info("Processing Log: Current Balance: {$currentBalance}, Debit Amount: {$debitAmount}");

            // Calculate new balance
            $updatedBalance = $currentBalance - $debitAmount;

            // Debugging log: Check values after calculating
            \Log::info("Updated Balance: {$updatedBalance}");

            // Build the processed log entry
            $processedLogs[] = [
                'ID' => $result['ID'],
                'Date' => $result['Date'],
                'ClientID' => $result['ClientID'],
                'ClientName' => $result['ClientName'],
                'Detail' => $result['Detail'],
                'Debit' => $debitAmount,
                'Credit' => $result['Credit'],
                'Balance' => $updatedBalance, // Ensure the balance is updated
                'Module' => $result['Module'],
                'TraceID' => $traceId,
                'RefID' => $result['RefID'],
                'UpdatedBy' => $result['UpdatedBy']
            ];
        }

        return response()->json([
            'success' => true,
            'balanceLogs' => $processedLogs, // Return processed logs as an array
        ]);
    }

    // Handle error or missing Result key
    return response()->json([
        'success' => false,
        'errorMessage' => $data['Error']['ErrorMessage'] ?? 'Unknown error occurred.',
    ]);
}


//PAYMENT REALTED CONTROLLER 

public function initializePayment(Request $request)
{
    // Validate request
    $validatedData = $request->validate([
        'TraceId' => 'required|string',
        'Amount' => 'required|numeric',
        'PassengerData' => 'required',
        'BoardingPointName' => 'required|string',
        'DroppingPointName' => 'required|string',
        'SeatNumber' => 'required|string',
    ]);
    
    try {
        // Initialize Razorpay API with env variables
        $api = new Api('rzp_test_cvVugPSRGGLWtS', 'xHoRXawt9gYD7vitghKq1l5c');
        
        // Convert amount to paise (Razorpay uses paise)
        $amountInPaise = $validatedData['Amount'] * 100;
        
        // Create order
        $order = $api->order->create([
            'receipt' => 'BUS_' . time(),
            'amount' => $amountInPaise,
            'currency' => 'INR',
            'payment_capture' => 1 // Auto capture
        ]);
        
        // Store payment details in database
        $payment = BusPayment::create([
            'order_id' => $order->id,
            'payment_id' => 'pending_' . uniqid(), // Will be updated after payment
            'trace_id' => $validatedData['TraceId'],
            'amount' => $validatedData['Amount'],
            'passenger_data' => $validatedData['PassengerData'],
            'boarding_point' => $validatedData['BoardingPointName'],
            'dropping_point' => $validatedData['DroppingPointName'],
            'seat_number' => $validatedData['SeatNumber'],
            'status' => 'pending',
            'payment_response' => null
        ]);
        
        // Return success response with order details
        return response()->json([
            'success' => true,
            'navigateToPayment' => true,
           'key_id' => 'rzp_test_cvVugPSRGGLWtS',
            'order_id' => $order->id,
            'amount' => $validatedData['Amount'], // Send original amount, not in paise
            'amount_in_paise' => $amountInPaise, // Also send amount in paise for reference
            'currency' => 'INR'
        ]);
    } catch (\Exception $e) {
        \Log::error('Payment Initialization Failed', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'errorMessage' => $e->getMessage()
        ], 500);
    }
}

/**
 * Handle payment callback
 */
public function paymentCallback(Request $request)
{
    \Log::info('Payment Callback Received', $request->all());

    try {
        // Validate key incoming parameters
        $validatedData = $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
            'trace_id' => 'sometimes|nullable|string',
            'amount' => 'sometimes|nullable|numeric',
            'result_index' => 'sometimes|nullable',
        ]);

        // Initialize Razorpay API with env variables
        $api = new Api('rzp_test_cvVugPSRGGLWtS','xHoRXawt9gYD7vitghKq1l5c');
        
        // Verify payment signature
        $attributes = [
            'razorpay_order_id' => $validatedData['razorpay_order_id'],
            'razorpay_payment_id' => $validatedData['razorpay_payment_id'],
            'razorpay_signature' => $validatedData['razorpay_signature']
        ];
        
        try {
            $api->utility->verifyPaymentSignature($attributes);
        } catch (\Exception $signatureException) {
            \Log::error('Signature Verification Failed', [
                'message' => $signatureException->getMessage(),
                'attributes' => $attributes
            ]);
            
            // Alternative manual verification as fallback
            // Alternative manual verification as fallback
$generatedSignature = hash_hmac(
    'sha256',
    $validatedData['razorpay_order_id'] . '|' . $validatedData['razorpay_payment_id'],
    'xHoRXawt9gYD7vitghKq1l5c'
);

            
            if ($generatedSignature !== $validatedData['razorpay_signature']) {
                throw new \Exception('Payment signature verification failed');
            }
            
            \Log::info('Manual signature verification succeeded');
        }
        
        // Find payment record
        $payment = BusPayment::where('order_id', $validatedData['razorpay_order_id'])->first();
        
        if (!$payment) {
            \Log::error('Payment record not found', [
                'order_id' => $validatedData['razorpay_order_id']
            ]);
            // return redirect()->route('payments.failed')
            //     ->with('error', 'Payment record could not be located');
        }

        // Update payment record with comprehensive details
        $payment->update([
            'payment_id' => $validatedData['razorpay_payment_id'],
            'status' => 'completed',
            'payment_response' => $request->all(),
            'trace_id' => $request->input('trace_id', $payment->trace_id),
            'result_index' => $request->input('result_index')
        ]);

        // Prepare success parameters
        $successParams = [
            'payment_id' => $validatedData['razorpay_payment_id'],
            'trace_id' => $request->input('trace_id', $payment->trace_id),
            'result_index' => $request->input('result_index'),
            'amount' => $payment->amount,
            'passenger_data' => $payment->passenger_data,
            'boarding_point' => $payment->boarding_point,
            'dropping_point' => $payment->dropping_point,
            'processing' => true
        ];

        // Log successful payment
        \Log::info('Payment Successfully Processed', $successParams);

        // Redirect to success page with all necessary parameters
        return redirect()->route('payments.bus', $successParams)
            ->with('success', 'Payment processed successfully');

    } catch (\Exception $e) {
        // Comprehensive error logging
        \Log::error('Payment Verification Failed', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        // return redirect()->route('payments.failed')
        //     ->with('error', 'Payment verification failed: '. $e->getMessage());
    }
}

/**
 * Show payment success page
 */
public function success(Request $request)
{
    \Log::info('Success Page Access', [
        'payment_id' => $request->payment_id,
        'trace_id' => $request->trace_id,
        'result_index' => $request->result_index,
        'full_request' => $request->all()
    ]);
    
    try {
        // Find payment record with multiple lookup methods
        $payment = BusPayment::where('payment_id', $request->payment_id)
            ->orWhere('order_id', $request->payment_id)
            ->first();
        
        if (!$payment) {
            \Log::error('No payment found', [
                'payment_id' => $request->payment_id
            ]);
            return redirect()->route('home')
                ->with('error', 'Invalid payment details');
        }

        // Ensure passenger data is properly decoded
        $passengerData = is_string($payment->passenger_data) 
            ? json_decode($payment->passenger_data, true) 
            : $payment->passenger_data;

        // Prepare comprehensive payment details
        $paymentDetails = [
            'payment_id' => $payment->payment_id,
            'order_id' => $payment->order_id,
            'amount' => $payment->amount,
            'status' => $payment->status,
            'trace_id' => $payment->trace_id,
            'result_index' => $request->result_index,
            'boarding_point' => $payment->boarding_point,
            'dropping_point' => $payment->dropping_point,
            'seat_number' => $payment->seat_number,
            'passengers' => $passengerData,
            'processing' => $request->has('processing') ? true : false
        ];

        // Log payment details for verification
        \Log::info('Payment Details for Success Page', $paymentDetails);

        // Return view with comprehensive payment information
        return view('frontend.payment_success', [
            'payment' => $payment,
            'paymentDetails' => $paymentDetails
        ]);

    } catch (\Exception $e) {
        \Log::error('Success Page Error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return redirect()->route('home')
            ->with('error', 'An unexpected error occurred');
    }
}

/**
 * Show payment failed page
 */
public function failed()
{
    return view('frontend.payments_failed');
}
}

