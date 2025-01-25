<?php

namespace App\Http\Controllers;

use App\Models\AirportList;
use App\Models\Flight;
use Carbon\Carbon;
use App\Services\FlightApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


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


    public function fareQutesResult(){
        return view('fareRule');

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
        // Detailed request logging
        \Log::info('Raw Request Data:', [
            'all' => $request->all(),
            'content' => $request->getContent(),
            'headers' => $request->headers->all()
        ]);
    
        try {
            // Decode JSON if it's a string
            $data = is_string($request->getContent()) 
                ? json_decode($request->getContent(), true) 
                : $request->all();
    
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid JSON data',
                    'debug' => json_last_error_msg()
                ], 422);
            }
    
            // Basic validation
            $validator = Validator::make($data, [
                'EndUserIp' => 'required',
                'ClientId' => 'required',
                'UserName' => 'required',
                'Password' => 'required',
                'AdultCount' => 'required',
                'ChildCount' => 'required',
                'InfantCount' => 'required',
                'JourneyType' => 'required',
                'FareType' => 'required',
                'Segments' => 'required|array',
                'Segments.*.Origin' => 'required|string|size:3',
                'Segments.*.Destination' => 'required|string|size:3',
                'Segments.*.FlightCabinClass' => 'required',
                'Segments.*.PreferredDepartureTime' => 'required',
                'Segments.*.PreferredArrivalTime' => 'required'
            ]);
    
            if ($validator->fails()) {
                \Log::error('Validation Failed:', [
                    'errors' => $validator->errors()->toArray(),
                    'data' => $data
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->toArray(),
                    'received_data' => $data
                ], 422);
            }
    
            // Cast all numeric values to strings
            $payload = [
                'EndUserIp' => (string) $data['EndUserIp'],
                'ClientId' => (string) $data['ClientId'],
                'UserName' => (string) $data['UserName'],
                'Password' => (string) $data['Password'],
                'AdultCount' => (string) $data['AdultCount'],
                'ChildCount' => (string) $data['ChildCount'],
                'InfantCount' => (string) $data['InfantCount'],
                'JourneyType' => (string) $data['JourneyType'],
                'FareType' => (string) $data['FareType'],
                'Segments' => array_map(function ($segment) {
                    return [
                        'Origin' => strtoupper((string) $segment['Origin']),
                        'Destination' => strtoupper((string) $segment['Destination']),
                        'FlightCabinClass' => (string) $segment['FlightCabinClass'],
                        'PreferredDepartureTime' => $segment['PreferredDepartureTime'],
                        'PreferredArrivalTime' => $segment['PreferredArrivalTime']
                    ];
                }, $data['Segments'])
            ];
    
            \Log::info('Constructed API Payload:', $payload);
    
            $response = Http::timeout(500)
                ->connectTimeout(500)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Api-Token' => 'MakeMy@910@23',
                ])
                ->post('https://flight.srdvtest.com/v8/rest/Search', $payload);
    
            \Log::info('API Response:', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
    
            if ($response->successful()) {
                $responseData = $response->json();
    
                // Check if Results array exists and is not empty
                if (isset($responseData['Results']) && !empty($responseData['Results'])) {
                    return response()->json([
                        'success' => true,
                        'traceId' => $responseData['TraceId'] ?? '',
                        'srdvType' => $responseData['SrdvType'] ?? '',
                        'origin' => $responseData['Origin'] ?? '',
                        'destination' => $responseData['Destination'] ?? '',
                        'results' => $responseData['Results']
                    ], 200);
                } 
                // If Results array is empty or doesn't exist
                else {
                    return response()->json([
                        'success' => false,
                        'message' => 'No flights found',
                        'debug' => $responseData
                    ], 200);  // Still return 200 as this is a valid response
                }
            }
    
            return response()->json([
                'status' => 'error',
                'message' => 'API request failed',
                'debug' => [
                    'status' => $response->status(),
                    'body' => $response->json(),
                ]
            ], $response->status());
        } catch (\Exception $e) {
            \Log::error('Flight Search Exception:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
                'debug' => [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ], 500);
        }
    }
    public function fareRules(Request $request)
    {
        try {
            $data = $request->all();
    
            $validator = Validator::make($data, [
                'EndUserIp' => 'required',
                'ClientId' => 'required',
                'UserName' => 'required',
                'Password' => 'required',
                'SrdvType' => 'required',
                'SrdvIndex' => 'required',
                'TraceId' => 'required',
                'ResultIndex' => 'required'
            ]);
    
            if ($validator->fails()) {
                \Log::error('Fare Rules Validation Failed', [
                    'errors' => $validator->errors()->toArray(),
                    'data' => $data
                ]);
    
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }
    
            $payload = [
                'EndUserIp' => $data['EndUserIp'],
                'ClientId' => $data['ClientId'],
                'UserName' => $data['UserName'],
                'Password' => $data['Password'],
                'SrdvType' => $data['SrdvType'],
                'SrdvIndex' => $data['SrdvIndex'],
                'TraceId' => $data['TraceId'],
                'ResultIndex' => $data['ResultIndex']
            ];
    
            $response = Http::timeout(300)
                ->connectTimeout(300)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Api-Token' => 'MakeMy@910@23',
                ])
                ->post('https://flight.srdvtest.com/v8/rest/FareRule', $payload);
    
            if ($response->successful()) {
                $responseData = $response->json();
    
                // Comprehensive error checking and data processing
                if (isset($responseData['Error']) && $responseData['Error']['ErrorCode'] === 0) {
                    if (!empty($responseData['Results'])) {
                        return response()->json([
                            'success' => true,
                            'fareRules' => $responseData['Results'][0] // Return first fare rule
                        ], 200);
                    } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'No fare rules found',
                            'debug' => $responseData
                        ], 200);
                    }
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $responseData['Error']['ErrorMessage'] ?? 'Unknown API error',
                        'errorCode' => $responseData['Error']['ErrorCode'] ?? null
                    ], 400);
                }
            }
    
            return response()->json([
                'status' => 'error',
                'message' => 'API request failed',
                'debug' => [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]
            ], $response->status());
    
        } catch (\Exception $e) {
            \Log::error('Fare Rules Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred',
                'debug' => [
                    'exception' => get_class($e),
                    'message' => $e->getMessage()
                ]
            ], 500);
        }
    }


    public function fareQutes(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make($data, [
                'EndUserIp' => 'required',
                'ClientId' => 'required',
                'UserName' => 'required',
                'Password' => 'required',
                'SrdvType' => 'required',
                'SrdvIndex' => 'required',
                'TraceId' => 'required',
                'ResultIndex' => 'required'
            ]);

            if ($validator->fails()) {
                Log::error('Fare Quote Validation Failed', [
                    'errors' => $validator->errors()->toArray(),
                    'data' => $data
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()->toArray()
                ], 422);
            }

            $payload = [
                'EndUserIp' => $data['EndUserIp'],
                'ClientId' => $data['ClientId'],
                'UserName' => $data['UserName'],
                'Password' => $data['Password'],
                'SrdvType' => $data['SrdvType'],
                'SrdvIndex' => $data['SrdvIndex'],
                'TraceId' => $data['TraceId'],
                'ResultIndex' => $data['ResultIndex']
            ];

            $response = Http::timeout(300)
                ->connectTimeout(300)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Api-Token' => 'MakeMy@910@23',
                ])
                ->post('https://flight.srdvtest.com/v8/rest/FareQuote', $payload);

            if ($response->successful()) {
                $responseData = $response->json();

                if (isset($responseData['Error']) && $responseData['Error']['ErrorCode'] === "0") {
                    return response()->json([
                        'success' => true,
                        'fareQuote' => $responseData['Results'] ?? null,
                        'traceId' => $responseData['TraceId'] ?? null
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $responseData['Error']['ErrorMessage'] ?? 'Unknown API error',
                        'errorCode' => $responseData['Error']['ErrorCode'] ?? null
                    ], 400);
                }
            }

            return response()->json([
                'status' => 'error',
                'message' => 'API request failed',
                'debug' => [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]
            ], $response->status());

        } catch (\Exception $e) {
            Log::error('Fare Quote Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred',
                'debug' => [
                    'exception' => get_class($e),
                    'message' => $e->getMessage()
                ]
            ], 500);
        }
    }

    public function showFareQuotePage(Request $request)
    {
        // Pass necessary data to the view
        return view('fare-quote', [
            'traceId' => $request->query('traceId'),
            'resultIndex' => $request->query('resultIndex')
        ]);
    }

    public function fetchSSRData(Request $request)
    {
        try {
            // Validate input data
            $validatedData = $request->validate([
                'EndUserIp' => 'required|ip',
                'ClientId' => 'required|string',
                'UserName' => 'required|string',
                'Password' => 'required|string',
                'SrdvType' => 'required|string',
                'SrdvIndex' => 'required',
                'TraceId' => 'required|string',
                'ResultIndex' => 'required'
            ]);
    
            // Prepare payload (using validated data)
            $payload = $validatedData;
    
            // Log outgoing request
            Log::info('SSR Request Payload', $payload);
    
            // Make API call
            $response = Http::withHeaders([
                'API-Token' => 'MakeMy@910@23',
                'Content-Type' => 'application/json'
            ])->post('https://flight.srdvtest.com/v8/rest/SSR', $payload);
    
            // Process API response
            if ($response->successful()) {
                $responseData = $response->json();
                
                // Check for specific error conditions
                if (isset($responseData['Error']) && $responseData['Error']['ErrorCode'] !== "0") {
                    return response()->json([
                        'success' => false,
                        'message' => $responseData['Error']['ErrorMessage'] ?? 'Unknown API error',
                        'errorCode' => $responseData['Error']['ErrorCode']
                    ], 400);
                }
    
                // Normalize response to handle empty or missing data
                return response()->json([
                    'success' => true,
                    'Baggage' => $responseData['Baggage'] ?? [],
                    'MealDynamic' => $responseData['MealDynamic'] ?? [],
                    'TraceId' => $responseData['TraceId'] ?? '',
                ]);
            }
    
            // API call failed
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch SSR data',
                'details' => $response->body()
            ], $response->status());
    
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid request data',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('SSR API Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return response()->json([
                'success' => false,
                'message' => 'Unexpected error occurred',
            ], 500);
        }
    }
    // Seat Map API
    public function getSeatMap(Request $request)
{
    try {
        // API Payload
        $validatedData = $request->validate([
            'EndUserIp' => 'required|ip',
            'ClientId' => 'required|string',
            'UserName' => 'required|string',
            'Password' => 'required|string',
            'SrdvType' => 'required|string',
            'SrdvIndex' => 'required',
            'TraceId' => 'required|string',
            'ResultIndex' => 'required'
        ]);
        $payload = $validatedData;


        $response = Http::withHeaders([
            'API-Token' => 'MakeMy@910@23',
            'Content-Type' => 'application/json'
        ])->post('https://flight.srdvtest.com/v8/rest/SeatMap', $validatedData);

        Log::info('Seat Map API Full Response', [
            'status' => $response->status(),
            'body' => $response->body() // Log full response body
        ]);

        if ($response->successful()) {
            $seatMapData = $response->json();

            // Handle API error response
            if ($seatMapData['Error']['ErrorCode'] !== 0) {
                return response()->json([
                    'error' => $seatMapData['Error']['ErrorMessage'] ?? 'Unknown error'
                ], 400);
            }

            if (isset($seatMapData['Results'][0]['Seats'])) {
                $availableSeats = $this->processSeatsData($seatMapData['Results'][0]['Seats']);

                // Extract required airline data
                $flightInfo = [
                    'airline' => $seatMapData['Results'][0]['AirlineName'] ?? 'Unknown Airline',
    'from' => $seatMapData['Results'][0]['FromCity'] ?? 'Unknown City',
    'to' => $seatMapData['Results'][0]['ToCity'] ?? 'Unknown City',
    'airlineName' => $seatMapData['Results'][0]['AirlineName'] ?? '',
    'airlineCode' => $seatMapData['Results'][0]['AirlineCode'] ?? '',
    'airlineNumber' => $seatMapData['Results'][0]['AirlineNumber'] ?? ''
                ];

                return response()->json([
                    'html' => view('frontend.flight-seat', [
                        'availableSeats' => $availableSeats,
                        'flightInfo' => $flightInfo
                    ])->render(),
                    'flightInfo' => $flightInfo // Add this in case it's needed separately
                ]);
            }
        }

        return response()->json(['error' => 'No seat map data found'], 404);

    } catch (\Exception $e) {
        Log::error('Seat Map Error: ' . $e->getMessage());
        return response()->json([
            'error' => 'System error',
            'message' => $e->getMessage()
        ], 500);
    }
}



private function processSeatsData($seatsData)
{
    $availableSeats = [];
    
    foreach ($seatsData as $rowKey => $rowData) {
        $rowNumber = substr($rowKey, 3);
        
        foreach ($rowData as $columnKey => $seat) {
            if (!$seat['IsBooked']) {
                $availableSeats[] = [
                    'SeatNumber' => $seat['SeatNumber'],
                    'Code' => $seat['Code'],
                    'IsLegroom' => $seat['IsLegroom'] ?? false,
                    'IsAisle' => $seat['IsAisle'] ?? false,
                    'Amount' => $seat['Amount'],
                    'Row' => $rowNumber,
                    'Column' => substr($columnKey, 6) 
                ];
            }
        }
    }
    
    return $availableSeats;
}


public function bookLCC(Request $request)
{
    try {
        // Validate the request
        $validatedData = $request->validate([
            'srdvIndex' => 'required|string',
            'traceId' => 'required|string',
            'resultIndex' => 'required|string',
            'passenger.title' => 'required|string',
            'passenger.firstName' => 'required|string',
            'passenger.lastName' => 'required|string',
            'passenger.gender' => 'required|integer', // Assuming 1 for male, 2 for female
            'passenger.contactNo' => 'required|string',
            'passenger.email' => 'required|email',
            'passenger.paxType' => 'required|string',
            'passenger.dateOfBirth' => 'nullable|string',
            'passenger.passportNo' => 'nullable|string',
            'passenger.passportExpiry' => 'nullable|string',
            'passenger.passportIssueDate' => 'nullable|string',
            'passenger.countryCode' => 'nullable|string',
            'passenger.countryName' => 'nullable|string',
            'passenger.baggage' => 'nullable|array',
            'passenger.mealDynamic' => 'nullable|array',
            'passenger.seat' => 'nullable|array',
            'fare.baseFare' => 'required|numeric',
            'fare.tax' => 'required|numeric',
            'fare.yqTax' => 'nullable|numeric',
            'fare.transactionFee' => 'nullable|numeric',
            'fare.additionalTxnFeeOfrd' => 'nullable|numeric',
            'fare.additionalTxnFeePub' => 'nullable|numeric',
            'fare.airTransFee' => 'nullable|numeric',
        ]);

        // Default empty arrays for optional fields if not provided
        $baggage = $validatedData['passenger']['baggage'] ?? [];
        $mealDynamic = $validatedData['passenger']['mealDynamic'] ?? [];
        $seat = $validatedData['passenger']['seat'] ?? [];

        // Prepare the payload for the API request
        $payload = [
            'EndUserIp' => '1.1.1.1', // Replace with actual user IP or dynamic source
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
            'SrdvType' => 'MixAPI',
            'SrdvIndex' => $validatedData['srdvIndex'],
            'TraceId' => $validatedData['traceId'],
            'ResultIndex' => $validatedData['resultIndex'],
            'Passengers' => [
                [
                    'Title' => $validatedData['passenger']['title'],
                    'FirstName' => $validatedData['passenger']['firstName'],
                    'LastName' => $validatedData['passenger']['lastName'],
                    'PaxType' => $validatedData['passenger']['paxType'],
                    'Gender' => $validatedData['passenger']['gender'],
                    'ContactNo' => $validatedData['passenger']['contactNo'],
                    'Email' => $validatedData['passenger']['email'],
                    'DateOfBirth' => $validatedData['passenger']['dateOfBirth'] ?? '12/01/1998',
                    'PassportNo' => $validatedData['passenger']['passportNo'] ?? '',
                    'PassportExpiry' => $validatedData['passenger']['passportExpiry'] ?? '',
                    'PassportIssueDate' => $validatedData['passenger']['passportIssueDate'] ?? '',
                    'CountryCode' => $validatedData['passenger']['countryCode'] ?? 'IN',
                    'CountryName' => $validatedData['passenger']['countryName'] ?? 'INDIA',
                    'Fare' => [
                        'BaseFare' => $validatedData['fare']['baseFare'],
                        'Tax' => $validatedData['fare']['tax'],
                        'YQTax' => $validatedData['fare']['yqTax'] ?? 0,
                        'TransactionFee' => $validatedData['fare']['transactionFee'] ?? 0,
                        'AdditionalTxnFeeOfrd' => $validatedData['fare']['additionalTxnFeeOfrd'] ?? 0,
                        'AdditionalTxnFeePub' => $validatedData['fare']['additionalTxnFeePub'] ?? 0,
                        'AirTransFee' => $validatedData['fare']['airTransFee'] ?? 0,
                    ],
                    'Baggage' => $baggage,
                    'MealDynamic' => $mealDynamic,
                    'Seat' => $seat,
                ]
            ]
        ];

        // Send payload to third-party API
        $response = Http::withHeaders([
            'API-Token' => 'MakeMy@910@23',
            'Content-Type' => 'application/json',
        ])->post('https://flight.srdvtest.com/v8/rest/TicketLCC', $payload);

        if ($response->successful()) {
            $apiResponse = $response->json();

            // Extract relevant data for client response
            $formattedResponse = [
                'TraceId' => $apiResponse['TraceId'] ?? null,
                'PNR' => $apiResponse['Response']['PNR'] ?? null,
                'BookingId' => $apiResponse['Response']['BookingId'] ?? null,
                'TicketStatus' => $apiResponse['Response']['TicketStatus'] ?? null,
                'FareDetails' => $apiResponse['Response']['FlightItinerary']['Fare'] ?? [],
                'Segments' => $apiResponse['Response']['FlightItinerary']['Segments'] ?? [],
            ];

            return response()->json(['success' => true, 'data' => $formattedResponse]);
        }

        // Handle API error responses
        return response()->json([
            'error' => 'Failed to book flight',
            'details' => $response->json(),
        ], $response->status());

    } catch (\Exception $e) {
        // Handle unexpected errors
        return response()->json([
            'error' => 'System error',
            'message' => $e->getMessage()
        ], 500);
    
    }
}


























// **************************************************
// PREVIOUS CONTROLLER
// *************************************************
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
