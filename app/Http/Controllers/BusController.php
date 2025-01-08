<?php


namespace App\Http\Controllers;

use App\Services\BusApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BusController extends Controller
{
    
    protected $ClientId;
    protected $UserName;
    protected $Password;
    protected $ApiToken;

    public function __construct()
    {
         $this->ClientId = env('BUS_API_CLIENT_ID');
        $this->UserName = env('BUS_API_USERNAME');
        $this->Password = env('BUS_API_PASSWORD');
        $this->ApiToken = env('BUS_API_TOKEN');
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
            'ClientId' => $this->ClientId,
            'UserName' => $this->UserName,
            'Password' => $this->Password,
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
                'Api-Token' => $this->ApiToken, // Use the class property
            ])->withBody($payload, 'application/json')
                ->post('https://bus.srdvapi.com/v8/rest/Search');
    
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
    

    public function getSeatLayout(Request $request)
    {
        $request->validate([
            'TraceId' => 'required|string',
            'ResultIndex' => 'required|string',
        ]);
    
        $payload = json_encode([
            'ClientId' => $this->ClientId,
            'UserName' => $this->UserName,
            'Password' => $this->Password,
            "TraceId" => $request->TraceId,
            "ResultIndex" => $request->ResultIndex,
        ], JSON_UNESCAPED_SLASHES);
    
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => $this->ApiToken,
            ])->withBody($payload, 'application/json')
              ->post('https://bus.srdvapi.com/v8/rest/GetSeatLayOut');
    
            $data = $response->json();
    
            if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
                return response()->json([
                    'status' => false,
                    'message' => $data['Error']['ErrorMessage'] ?? 'Error fetching seat layout',
                ]);
            }
    
            // Add bus type detection
            $busType = isset($data['ResultUpperSeat']) ? 'sleeper' : 'seater';
    
            return response()->json([
                'status' => true,
                'busType' => $busType,
                'data' => [
                    'lower' => $data['Result'] ?? [],
                    'upper' => $data['ResultUpperSeat'] ?? [],
                    'availableSeats' => $data['AvailableSeats'] ?? 0
                ]
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching seat layout.',
            ], 500);
        } 
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
            'ClientId' => $this->ClientId,
            'UserName' => $this->UserName,
            'Password' => $this->Password,
            'TraceId' => $request->TraceId,
            'ResultIndex' => $request->ResultIndex
        ];
    
        try {
            // Log the request payload
            Log::info('Boarding Points API Request:', ['payload' => $payload]);
    
            // Make the API call
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => $this->ApiToken,  // Use the class property
            ])->post('https://bus.srdvapi.com/v8/rest/GetBoardingPointDetails', $payload);
    
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
            'ClientId' => $this->ClientId,
            'UserName' => $this->UserName,
            'Password' => $this->Password,
        ], $request->all());
    
        try {
            // Log request payload for debugging
            Log::info('Block Seats Request Payload:', ['payload' => $payload]);
    
            // Make API request
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => $this->ApiToken,
            ])->post('https://bus.srdvapi.com/v8/rest/Block', $payload);
    
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
            'ClientId' => $this->ClientId,
            'UserName' => $this->UserName,
            'Password' => $this->Password,
        ], $request->all());

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => $this->ApiToken,  // Use the class property
            ])->post('https://bus.srdvapi.com/v8/rest/Book', $payload);

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
            'ClientId' => $this->ClientId,
            'UserName' => $this->UserName,
            'Password' => $this->Password
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
             'Api-Token' => $this->ApiToken,  // Use the class property
        ])->post('https://bus.srdvapi.com/v8/rest/Balance', $payload);

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
        'ClientId' => $this->ClientId,
        'UserName' => $this->UserName,
        'Password' => $this->Password
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
}