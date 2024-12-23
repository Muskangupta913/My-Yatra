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

    public function __construct(BusApiService $busApiService)
    {
        $this->busApiService = $busApiService;
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
        $request->validate([
            'source_city' => 'required|string',
            'source_code' => 'required|string',
            'destination_city' => 'required|string',
            'destination_code' => 'required|string',
            'depart_date' => 'required|date_format:Y-m-d',
        ]);

        $payload = json_encode([
            "ClientId" => "180133",
            "UserName" => "MakeMy91",
            "Password" => "MakeMy@910",
            'source_city' => trim($request->source_city),
            'source_code' => (int) trim($request->source_code),
            'destination_city' => trim($request->destination_city),
            'destination_code' => (int) trim($request->destination_code),
            'depart_date' => Carbon::createFromFormat('Y-m-d', $request->depart_date)->format('Y-m-d'),
        ], JSON_UNESCAPED_SLASHES);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23',
            ])->withBody($payload, 'application/json')
              ->post('https://bus.srdvtest.com/v5/rest/Search');

            $data = $response->json();

            if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
                return response()->json([
                    'status' => false,
                    'message' => $data['Error']['ErrorMessage'] ?? 'An unknown error occurred'
                ]);
            }

            $traceId = $data['Result']['TraceId'] ?? $data['TraceId'] ?? null;

            if (!empty($data['Result']['BusResults'])) {
                return response()->json([
                    'status' => true,
                    'traceId' => $traceId,
                    'data' => $data['Result']['BusResults'],
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'No buses found for the selected route and date.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while searching for buses.'
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
            "ClientId" => "180133",
            "UserName" => "MakeMy91",
            "Password" => "MakeMy@910",
            "TraceId" => $request->TraceId,
            "ResultIndex" => $request->ResultIndex,
        ], JSON_UNESCAPED_SLASHES);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23',
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
            'Api-Token' => 'MakeMy@910@23'
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
        'ClientId' => '180133',
        'UserName' => 'MakeMy91',
        'Password' => 'MakeMy@910',
    ], $request->all());

    try {
        Log::info('Block Seats Request Payload:', ['payload' => $payload]);

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Token' => 'MakeMy@910@23',
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
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
        ], $request->all());

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23',
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


}