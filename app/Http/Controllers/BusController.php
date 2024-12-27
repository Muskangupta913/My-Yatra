<?php


namespace App\Http\Controllers;

use App\Services\BusApiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class BusController extends Controller
{
    protected $busApiService;
    protected $ClientId;
    protected $UserName;
    protected $Password;
    protected $ApiToken;

    public function __construct(BusApiService $busApiService)
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
        // Make the API request
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Token' => $this->ApiToken,  // Use the class property // Corrected the header key
        ])->withBody($payload, 'application/json')
          ->post('https://bus.srdvtest.com/v5/rest/Search');

        // Decode the JSON response
        $data = $response->json();

        // Check for errors in the response
        if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
            return response()->json([
                'status' => false,
                'message' => $data['Error']['ErrorMessage'] ?? 'An unknown error occurred'
            ]);
        }

        // Retrieve trace ID and bus results from the response
        $traceId = $data['Result']['TraceId'] ?? $data['TraceId'] ?? null;

        // Check if there are bus results
        if (!empty($data['Result']['BusResults'])) {
            return response()->json([
                'status' => true,
                'traceId' => $traceId,
                'data' => $data['Result']['BusResults'],
            ]);
        }

        // If no buses found
        return response()->json([
            'status' => false,
            'message' => 'No buses found for the selected route and date.'
        ]);

    } catch (\Exception $e) {
        // Return an error response if an exception occurs
        return response()->json([
            'status' => false,
            'message' => 'An error occurred while searching for buses: ' . $e->getMessage()
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
                'Api-Token' => $this->ApiToken,  // Use the class property
            ])->withBody($payload, 'application/json')
              ->post('https://bus.srdvtest.com/v5/rest/GetSeatLayOut');

            $data = $response->json();

            if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
                return response()->json([
                    'status' => false,
                    'message' => $data['Error']['ErrorMessage'] ?? 'Error fetching seat layout',
                ]);
            }

            return response()->json([
                'status' => true,
                'data' => $data['Result'],
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
        ])->post('https://bus.srdvtest.com/v5/rest/GetBoardingPointDetails', $payload);

        $data = $response->json();

        // Log the response
        Log::info('Boarding Points API Response:', ['response' => $data]);

        // Check for API-specific errors
        if (isset($data['Error']) && $data['Error']['ErrorCode'] !== "0") {
            return response()->json([
                'status' => 'error',
                'message' => $data['Error']['ErrorMessage']
            ], 400);
        }

        // If successful, return the formatted response
        return response()->json([
            'status' => 'success',
            'GetBusRouteDetailResult' => $data
        ]);

    } catch (\Exception $e) {
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
    $request->validate([
        'ResultIndex' => 'required|string',
        'TraceId' => 'required|string',
        'BoardingPointId' => 'required',
        'DroppingPointId' => 'required',
        'RefID' => 'required',
        'Passenger' => 'required|array',
        'Passenger.*.FirstName' => 'required|string',
        'Passenger.*.LastName' => 'required|string',
        'Passenger.*.Email' => 'required|email',
        'Passenger.*.Phoneno' => 'required',
        'Passenger.*.Gender' => 'required',
        'Passenger.*.Age' => 'required',
        'Passenger.*.Title' => 'required|string',
        'Passenger.*.Address' => 'required|string',
       'Passenger.*.Seat' => 'required|array',
'Passenger.*.Seat.SeatName' => 'required|string',

'Passenger.*.Seat.ColumnNo' => 'nullable|integer',
'Passenger.*.Seat.RowNo' => 'nullable|integer',
'Passenger.*.Seat.Price' => 'required|array',
    ]);

    $payload = array_merge([
        'ClientId' => $this->ClientId,
        'UserName' => $this->UserName,
        'Password' => $this->Password,
    ], $request->all());

    try {
        Log::info('Block Seats Request Payload:', ['payload' => $payload]);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Token' => $this->ApiToken,  // Use the class property
        ])->post('https://bus.srdvtest.com/v5/rest/Block', $payload);

        $data = $response->json();
        Log::info('Block Seats API Response:', ['response' => $data]);

        if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
            return response()->json([
                'status' => 'error',
                'message' => $data['Error']['ErrorMessage'] ?? 'Error blocking seats'
            ], 400);
        }

        return response()->json([
            'status' => 'success',
            'data' => $data['Result']
        ]);

    } catch (\Exception $e) {
        Log::error('Error in blockSeats:', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => 'error',
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
            ])->post('https://bus.srdvtest.com/v5/rest/Book', $payload);

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
            'EndUser Ip' => 'required|string',
            'ClientId' => 'required|string',
            'User Name' => 'required|string',
            'Password' => 'required|string',
            'BusId' => 'required|string',
            'SeatId' => 'required|string',
            'Remarks' => 'nullable|string'
        ]);

        // Prepare the payload for the API request
        $payload = [
            'EndUser Ip' => '1.1.1.1',
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

    public function handlePayment(Request $request)
    {
        $traceId = $request->input('TraceId');
        $invoiceAmount = $request->input('InvoiceAmount');

        // Step 1: Fetch balance
        $balanceResponse = $this->fetchBalance();
        $balance = $balanceResponse->getData()->balance;

        // Step 2: Determine payment strategy
        if ($balance >= $invoiceAmount) {
            $walletPayment = $invoiceAmount;
            $userPayment = 0;
        } else {
            $walletPayment = $balance;
            $userPayment = $invoiceAmount - $balance;
        }

        // Step 3: Simulate updating balance log
       

        // Step 4: Process remaining payment (if needed)
        if ($userPayment > 0) {
            $paymentStatus = $this->processUserPayment($userPayment); // Implement payment gateway here
            if ($paymentStatus !== 'success') {
                return response()->json(['error' => 'User payment failed'], 400);
            }
        }

        return response()->json([
            'success' => true,
            'walletPayment' => $walletPayment,
            'userPayment' => $userPayment
        ]);
    }


}