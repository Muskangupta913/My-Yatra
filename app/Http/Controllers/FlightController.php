<?php

namespace App\Http\Controllers;

use App\Models\AirportList;
use App\Models\Flight;
use App\Services\FlightApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FlightController extends Controller
{
    protected $flightApiService;

    public function __construct(FlightApiService $flightApiService)
    {
        $this->flightApiService = $flightApiService;
    }

    public function index(Request $request)
    {
        // Fetch flight data based on the form parameters (fromCity, toCity, etc.)
        $flightFromCity = $request->input('flightFromCity');
        $flightToCity = $request->input('flightToCity');
        $flightDepartureDate = $request->input('flightDepartureDate');
        $flightReturnDate = $request->input('flightReturnDate');
        $passengers = $request->input('passengers');

        // Prepare the search data to pass to the API service
        $searchData = [
            'flightFromCity' => $flightFromCity,
            'flightToCity' => $flightToCity,
            'flightDepartureDate' => $flightDepartureDate,
            'flightReturnDate' => $flightReturnDate,
            'passengers' => $passengers,
        ];

        // Use the FlightApiService to fetch flight data
        $flights = $this->flightApiService->searchFlights($searchData);

        // If there are no flights, pass a message
        $message = empty($flights) ? 'No flights available for the selected criteria.' : '';

        return view('frontend.flight', compact('flights', 'message'));
    }

    public function fetchAirports(Request $request)
    {
        $query = $request->get('query');
        $airports = AirportList::where('airport_city_name', 'LIKE', "%{$query}%")
            ->orWhere('airport_name', 'LIKE', "%{$query}%")
            ->orWhere('airport_code', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get(['airport_city_name', 'airport_name', 'airport_code']);

        return response()->json($airports);
    }

    public function searchFlights(Request $request)
    {
        // Validate the incoming request structure
        $validated = $request->validate([
            'ClientId' => 'required',
            'UserName' => 'required',
            'Password' => 'required',
            'AdultCount' => 'required',
            'ChildCount' => 'required',
            'InfantCount' => 'required',
            'JourneyType' => 'required',
            'FareType' => 'required',
            'Segments' => 'required|array',
            'Segments.*.Origin' => 'required|string',
            'Segments.*.Destination' => 'required|string',
            'Segments.*.FlightCabinClass' => 'required',
            'Segments.*.PreferredDepartureTime' => 'required',
            'Segments.*.PreferredArrivalTime' => 'required',
        ]);

        $apiEndpoint = 'https://flight.srdvtest.com/v8/rest/Search';

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23',
            ])->post($apiEndpoint, $request->all());

            if ($response->successful() && isset($response['Results'])) {
                return response()->json([
                    'success' => true,
                    'flights' => $response['Results'][0],
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $response['Error']['ErrorMessage'] ?? 'An error occurred while fetching flights.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function showFlights(Request $request)
    {
        // Fetch flight data (this could be from an API or database)
        $flights = $this->flightApiService->getAvailableFlights($request);

        // Pass the flight data to the view
        return view('frontend.flight-section', compact('flights'));
    }

    public function getCalendarFare(Request $request)
    {
        $validated = $request->validate([
            'flightFromCity' => 'required|string',
            'flightToCity' => 'required|string',
            'flightDepartureDate' => 'required|date_format:d-m-Y',
        ]);

        $result = $this->flightApiService->getCalendarFare($validated);

        return response()->json($result);
    }

    public function showBookingForm()
    {
        // Example baggage options
        $baggage = [
            [
                ['Weight' => 15, 'Price' => 500, 'Origin' => 'DEL', 'Destination' => 'BOM', 'Code' => 'BAG1'],
                ['Weight' => 20, 'Price' => 800, 'Origin' => 'DEL', 'Destination' => 'BOM', 'Code' => 'BAG2'],
            ],
        ];

        // Example meal options
        $mealDynamic = [
            [
                ['AirlineDescription' => 'Vegetarian Meal', 'Price' => 300, 'Origin' => 'DEL', 'Destination' => 'BOM', 'Code' => 'MEAL1'],
                ['AirlineDescription' => 'Non-Vegetarian Meal', 'Price' => 350, 'Origin' => 'DEL', 'Destination' => 'BOM', 'Code' => 'MEAL2'],
            ],
        ];

        // Pass the data to the view
        return view('frontend.flight-booking', compact('baggage', 'mealDynamic'));
    }

    public function getSSRData()
    {
    //Make the POST request with the API-Token in the headers
        $response = Http::withHeaders([
            'API-Token' => 'MakeMy@910@23',  // Correct token header
        ])->post('https://flight.srdvtest.com/v8/rest/SSR', [
            'EndUserIp' => '1.1.1.1',
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
            'SrdvType' => 'MixAPI',
            'SrdvIndex' => '1',
            'TraceId' => '173937',
            'ResultIndex' => 'OB2_0_0',
        ]);

        // Decode the response to get baggage and meal data
        $data = $response->json();

        // Check if the response is successful
        if ($data['Error']['ErrorCode'] == 0) {
            return view('frontend.flight-seat', [
                'baggage' => $data['Baggage'],
                'mealDynamic' => $data['MealDynamic'],
            ]);
        } else {
            // Handle error accordingly
            return redirect()->back()->withErrors('Error fetching SSR data');
        }
    }

    public function selectSeat(Request $request)
    {
        try {
            // API Payload - Modify with actual data if needed
            $payload = [
                'EndUserIp' => '1.1.1.1',
                'ClientId' => '180133',
                'UserName' => 'MakeMy91',
                'Password' => 'MakeMy@910',
                'SrdvType' => 'MixAPI',
                'SrdvIndex' => '1',
                'TraceId' => '173876',
                'ResultIndex' => 'OB2_0_0',
            ];

            // API Headers - Modify as needed based on your API documentation
            $headers = [
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23', // Ensure this token is correct
            ];

            // Log Request Details for Debugging
            Log::info('Seat Map Request:', [
                'payload' => $payload,
                'headers' => $headers,
            ]);

            $apiEndpoint = 'https://flight.srdvtest.com/v8/rest/SeatMap';

            // Make API Request
            $response = Http::withHeaders($headers)
                ->post($apiEndpoint, $payload);

            // Log the Raw Response
            Log::info('Seat Map Response:', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            // Check if the response is successful
            if ($response->successful()) {
                $seatMapData = $response->json();
                // Check if the Results key exists and contains data
                if (isset($seatMapData['Results']) && !empty($seatMapData['Results'])) {
                    $availableSeats = $this->extractAvailableSeats($seatMapData['Results']);
                    // Return or process availableSeats
                } else {
                    Log::error('No seat data found in the API response', ['response' => $seatMapData]);
                    return response()->json([
                        'success' => false,
                        'message' => 'No seat data found in the response.',
                    ], 422);
                }
            } else {
                Log::error('API Request failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'API request failed. Please try again later.',
                ], 422);
            }
            
                    } catch (\Exception $e) {
            // Log and handle any exceptions
            Log::error('Seat map error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            // Return an error message
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while fetching seat map.',
                ], 500);
            }

            return redirect()->back()->with('error', 'An error occurred while fetching seat map.');
        }
    }

    // Method to extract available seats from the API response
    private function extractAvailableSeats(array $results): array
    {
        $availableSeats = [];
    
        foreach ($results as $flight) {
            if (isset($flight['Seats']) && is_array($flight['Seats'])) {
                foreach ($flight['Seats'] as $row => $columns) {
                    foreach ($columns as $column => $seat) {
                        if (!($seat['IsBooked'] ?? true)) { // Check if the seat is not booked
                            $availableSeats[] = [
                                'SeatNumber' => $seat['SeatNumber'] ?? '',
                                'IsLegroom' => $seat['IsLegroom'] ?? false,
                                'IsAisle' => $seat['IsAisle'] ?? false,
                                'Amount' => $seat['Amount'] ?? 0,
                                'Code' => $seat['Code'] ?? '',
                                'Row' => $row,
                                'Column' => $column,
                            ];
                        }
                    }
                }
            }
        }
    
        return $availableSeats;
    }
    
    

    // Method to store the seat booking details
    public function storeSeat(Request $request)
    {
        try {
            $jsonData = $request->json()->all();

            // Validation
            $validator = Validator::make($jsonData, [
                'seat_code' => 'required|string|max:10',
                'price' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Log the seat booking attempt
            Log::info('Seat booking attempt:', [
                'seat_code' => $jsonData['seat_code'],
                'price' => $jsonData['price'],
            ]);

            // Add your seat booking logic here

            return response()->json([
                'success' => true,
                'message' => 'Seat booked successfully!',
            ]);

        } catch (\Illuminate\Http\Exceptions\HttpResponseException $e) {
            Log::error('JSON parsing error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Invalid JSON Format. Please check your request format.',
            ], 400);
        } catch (\Exception $e) {
            Log::error('Seat booking error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again later.',
            ], 500);
        }
    }
    
}
