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
use Illuminate\Validation\Rule;
use Razorpay\Api\Api;
use App\Models\FlightPayment;
use Exception;

// Your existing code



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
               
                'AdultCount' => 'required',
                'ChildCount' => 'required',
                'InfantCount' => 'required',
                'JourneyType' => 'required|string',
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
                    'success' => false,
                    'message' => 'Please check your input and try again',
                    'errors' => $validator->errors()->toArray(),
                    'error_code' => 'VALIDATION_ERROR'
                ], 422);
            }
    
            // Cast all numeric values to strings
            $payload = [
                'EndUserIp' => '1.1.1.1', // Replace with actual user IP
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
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
    
                if (isset($responseData['Results']) && !empty($responseData['Results'])) {
                    $formattedResponse = [
                        'success' => true,
                        'traceId' => $responseData['TraceId'] ?? '',
                        'srdvType' => $responseData['SrdvType'] ?? '',
                        'origin' => $responseData['Origin'] ?? '',
                        'destination' => $responseData['Destination'] ?? '',
                    ];
    
                    // Handle RoundTrip response
                    if ($data['JourneyType'] === '2' && isset($responseData['Results'][1])) {
                        $formattedResponse['outbound'] = $responseData['Results'][0];
                        $formattedResponse['return'] = $responseData['Results'][1];
                    } 
                    // Handle OneWay response
                    else {
                        $formattedResponse['results'] = $responseData['Results'];
                    }
    
                    return response()->json($formattedResponse, 200);
                } 
                else {
                    return response()->json([
                        'success' => false,
                        'message' => 'No flights found',
                        'debug' => $responseData
                    ], 200);
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
                'EndUserIp' => '1.1.1.1', // Replace with actual user IP
                'ClientId' => '180133',
                'UserName' => 'MakeMy91',
                'Password' => 'MakeMy@910',
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
               'EndUserIp' => '1.1.1.1', // Replace with actual user IP
                'ClientId' => '180133',
                'UserName' => 'MakeMy91',
                'Password' => 'MakeMy@910',
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
            'passenger' => 'required|array|min:1',
            'passenger.*.title' => 'required|string',
            'passenger.*.firstName' => 'required|string',
            'passenger.*.lastName' => 'required|string',
            'passenger.*.gender' => 'required|string',
            'passenger.*.contactNo' => 'required|string',
            'passenger.*.email' => 'required|email',
            'passenger.*.paxType' => 'required|integer',
            'passenger.*.countryCode' => 'nullable|string',
            'passenger.*.addressLine1' => 'nullable',
            'passenger.*.city' => 'nullable',
            'passenger.*.countryName' => 'nullable|string',
            'passenger.*.nationality' => 'nullable|string',
            'passenger.*.baggage' => 'nullable|array',
            'passenger.*.mealDynamic' => 'nullable|array',
            'passenger.*.seat' => 'nullable|array',
            'passenger.*.fare' => 'required|array',
            'passenger.*.fare.baseFare' => 'required|numeric',
            'passenger.*.fare.tax' => 'required|numeric',
            'passenger.*.fare.yqTax' => 'nullable|numeric',
            'passenger.*.fare.transactionFee' => 'nullable|numeric',
            'passenger.*.fare.additionalTxnFeeOfrd' => 'nullable|numeric',
            'passenger.*.fare.additionalTxnFeePub' => 'nullable|numeric',
            'passenger.*.fare.airTransFee' => 'nullable|numeric',
        ]);

        // Log incoming request for debugging
        Log::info('LCC Booking Request', ['request' => $validatedData]);

        // Prepare the payload with enhanced passenger structure
        $payload = [
            'EndUserIp' => request()->ip() ?? '1.1.1.1',
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
            'SrdvType' => 'MixAPI',
            'SrdvIndex' => $validatedData['srdvIndex'],
            'TraceId' => $validatedData['traceId'],
            'ResultIndex' => $validatedData['resultIndex'],
            'Passengers' => array_map(function ($pax) {
                return [
                    'Title' => $pax['title'],
                    'FirstName' => $pax['firstName'],
                    'LastName' => $pax['lastName'],
                    'PaxType' => $pax['paxType'],
                    'Gender' => $pax['gender'],
                    'DateOfBirth' => $pax['dateOfBirth'] ?? '',
                    'ContactNo' => $pax['contactNo'],
                    'Email' => $pax['email'],
                    'PassportNo' => $pax['passportNo'] ?? '',
                    'PassportExpiry' => $pax['passportExpiry'] ?? '',
                    'PassportIssueDate' => $pax['passportIssueDate'] ?? '',
                    'AddressLine1' => $pax['addressLine1'] ?? '',
                    'City' => $pax['city'] ?? '',
                    'CountryCode' => $pax['countryCode'] ?? 'IN',
                    'CountryName' => $pax['countryName'] ?? 'INDIA',
                    'Nationality' => $pax['nationality'] ?? 'IN',
                    'IsLeadPax' => isset($pax['isLeadPax']) ? (bool)$pax['isLeadPax'] : false,
                    'Baggage' => $pax['baggage'] ?? [],
                    'MealDynamic' => $pax['mealDynamic'] ?? [],
                    'Seat' => $pax['seat'] ?? [],
                    'Fare' => [
                        'Currency' => 'INR',
                        'BaseFare' => $pax['fare']['baseFare'],
                        'Tax' => $pax['fare']['tax'],
                        'YQTax' => $pax['fare']['yqTax'] ?? 0,
                        'TransactionFee' => $pax['fare']['transactionFee'] ?? 0,
                        'AdditionalTxnFeeOfrd' => $pax['fare']['additionalTxnFeeOfrd'] ?? 0,
                        'AdditionalTxnFeePub' => $pax['fare']['additionalTxnFeePub'] ?? 0,
                        'AirTransFee' => $pax['fare']['airTransFee'] ?? 0
                    ]
                ];
            }, $validatedData['passenger'])
        ];
        // Log prepared payload
        Log::info('LCC Booking API Payload', ['payload' => $payload]);

        // Make API request
        $response = Http::withHeaders([
            'API-Token' => 'MakeMy@910@23',
            'Content-Type' => 'application/json',
        ])->post('https://flight.srdvtest.com/v8/rest/TicketLCC', $payload);

        // Log raw API response
        Log::info('LCC Booking API Response', ['response' => $response->json()]);

        if (!$response->successful()) {
            Log::error('LCC Booking API Error', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'API request failed',
                'error' => $response->json()['Error']['ErrorMessage'] ?? 'Unknown error',
                'code' => $response->json()['Error']['ErrorCode'] ?? null
            ], $response->status());
        }

        $apiResponse = $response->json();

        // Check for API-level errors
        if (isset($apiResponse['Error']) && $apiResponse['Error']['ErrorCode'] !== '0') {
            return response()->json([
                'status' => 'error',
                'message' => $apiResponse['Error']['ErrorMessage'],
                'code' => $apiResponse['Error']['ErrorCode']
            ], 422);
        }

        // Process and return the response with all possible fields
        return response()->json([
            'status' => 'success',
            'data' => [
                'booking_id' => $apiResponse['Response']['BookingId'] ?? null,
                'pnr' => $apiResponse['Response']['PNR'] ?? null,
                'srdv_index' => $apiResponse['Response']['SrdvIndex'] ?? null,
                'trace_id' => $apiResponse['TraceId'] ?? null,
                'is_price_changed' => $apiResponse['Response']['IsPriceChanged'] ?? false,
                'is_time_changed' => $apiResponse['Response']['IsTimeChanged'] ?? false,
                'ticket_status' => $apiResponse['Response']['TicketStatus'] ?? null,
                'ssr_denied' => $apiResponse['Response']['SSRDenied'] ?? false,
                'ssr_message' => $apiResponse['Response']['SSRMessage'] ?? null,
                'flight_itinerary' => [
                    'fare' => $apiResponse['Response']['FlightItinerary']['Fare'] ?? null,
                    'segments' => $apiResponse['Response']['FlightItinerary']['Segments'] ?? [],
                    'passengers' => array_map(function($passenger) {
                        return [
                            'pax_id' => $passenger['PaxId'] ?? null,
                            'title' => $passenger['Title'] ?? null,
                            'first_name' => $passenger['FirstName'] ?? null,
                            'last_name' => $passenger['LastName'] ?? null,
                            'pax_type' => $passenger['PaxType'] ?? null,
                            'date_of_birth' => $passenger['DateOfBirth'] ?? null,
                            'gender' => $passenger['Gender'] ?? null,
                            'passport_no' => $passenger['PassportNo'] ?? null,
                            'ticket_number' => $passenger['Ticket']['TicketNumber'] ?? null,
                            'status' => $passenger['Ticket']['Status'] ?? null,
                            'baggage' => $passenger['Baggage'] ?? [],
                            'meal_dynamic' => $passenger['MealDynamic'] ?? [],
                            'seat' => $passenger['Seat'] ?? [],
                        ];
                    }, $apiResponse['Response']['FlightItinerary']['Passenger'] ?? []),
                    'is_lcc' => $apiResponse['Response']['FlightItinerary']['IsLCC'] ?? null,
                    'airline_code' => $apiResponse['Response']['FlightItinerary']['AirlineCode'] ?? null,
                    'validating_airline_code' => $apiResponse['Response']['FlightItinerary']['ValidatingAirlineCode'] ?? null,
                    'last_ticket_date' => $apiResponse['Response']['FlightItinerary']['LastTicketDate'] ?? null,
                    'invoice_no' => $apiResponse['Response']['FlightItinerary']['InvoiceNo'] ?? null,
                    'invoice_status' => $apiResponse['Response']['FlightItinerary']['InvoiceStatus'] ?? null,
                    'invoice_created_on' => $apiResponse['Response']['FlightItinerary']['InvoiceCreatedOn'] ?? null,
                ]
            ]
        ], 200);

    } catch (ValidationException $e) {
        Log::error('LCC Booking Validation Error', [
            'errors' => $e->errors(),
            'request' => $request->all()
        ]);
        
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
        
    } catch (\Exception $e) {
        Log::error('LCC Booking System Error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request' => $request->all()
        ]);
        
        return response()->json([
            'status' => 'error',
            'message' => 'An unexpected error occurred',
            'debug' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}


public function bookGdsTicket(Request $request) {
    try {
        // Validate the request
        $validatedData = $request->validate([
            'srdvIndex' => 'required|string',
            'traceId' => 'required|string',
            'pnr' => 'required|string',
            'bookingId' => 'required'
            // Removed duplicate srdvIndex and resultIndex is not needed for this endpoint
        ]);

        // Prepare payload according to API documentation
        $payload = [
            'EndUserIp' => '1.1.1.1', // Replace with actual IP
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
            'SrdvType' => 'MixAPI',
            'SrdvIndex' => $validatedData['srdvIndex'],
            'TraceId' => $validatedData['traceId'],
            'PNR' => $validatedData['pnr'],
            'BookingId' => $validatedData['bookingId']
        ];

        // Add logging for debugging
        Log::info('GDS Ticket Booking Payload', ['payload' => $payload]);

        // Make API request to correct endpoint
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'API-Token' => 'MakeMy@910@23',
        ])->post('https://flight.srdvtest.com/v8/rest/TicketGDS', $payload);

        Log::info('GDS Ticket Booking Response', ['response' => $response->json()]);

        if (!$response->successful()) {
            Log::error('Flight API Error', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'API request failed: ' . ($response->json()['message'] ?? 'Unknown error')
            ], $response->status());
        }

        $apiResponse = $response->json();

        // Check for API-level errors
        if ($apiResponse['Error']['ErrorCode'] !== '0') {
            return response()->json([
                'status' => 'error',
                'message' => $apiResponse['Error']['ErrorMessage']
            ], 422);
        }

        // Return success response with ticket information
        return response()->json([
            'status' => 'success',
            'data' => [
                'bookingId' => $apiResponse['Response']['BookingId'],
                'pnr' => $apiResponse['Response']['PNR'],
                'ticketStatus' => $apiResponse['Response']['TicketStatus'],
                'passengers' => collect($apiResponse['Response']['FlightItinerary']['Passenger'])->map(function($passenger) {
                    return [
                        'name' => $passenger['FirstName'] . ' ' . $passenger['LastName'],
                        'ticketNumber' => $passenger['Ticket']['TicketNumber'],
                        'status' => $passenger['Ticket']['Status']
                    ];
                }),
                'fare' => $apiResponse['Response']['FlightItinerary']['Fare'],
                'segments' => $apiResponse['Response']['FlightItinerary']['Segments']
            ]
        ]);

    } catch (ValidationException $e) {
        Log::error('Validation Error', [
            'errors' => $e->errors(),
            'request' => $request->all()
        ]);
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        Log::error('GDS Ticket Booking Error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Ticket booking failed: ' . $e->getMessage()
        ], 500);
    }
}



public function bookHold(Request $request) {
    try {
        // Validate the request
        $validatedData = $request->validate([
            'srdvIndex' => 'required|string',
            'traceId' => 'required|string',
            'resultIndex' => 'required|string',
            'passengers' => 'required|array|min:1',
            'passengers.*.title' => ['required', 'string', Rule::in(['Mr', 'Mrs', 'Ms', 'Miss', 'Mstr'])],
            'passengers.*.firstName' => 'required|string|max:32',
            'passengers.*.lastName' => 'required|string|max:32',
            'passengers.*.gender' => ['required', 'string', Rule::in(['1', '2'])],
            'passengers.*.paxType' => ['required', 'integer', Rule::in([1, 2, 3])],
            'passengers.*.dateOfBirth' => 'required|date_format:Y-m-d\TH:i:s',
            'passengers.*.passportNo' => 'required|string|max:20',
            'passengers.*.passportExpiry' => 'required|date_format:Y-m-d\TH:i:s',
            'passengers.*.addressLine1' => 'required|string|max:100',
            'passengers.*.city' => 'nullable|string|max:50',
            'passengers.*.countryCode' => 'required|string|size:2',
            'passengers.*.countryName' => 'required|string|max:50',
            'passengers.*.contactNo' => 'required|string|max:15',
            'passengers.*.email' => 'required|email|max:50',
            'passengers.*.isLeadPax' => 'required|boolean',
            'passengers.*.fare' => 'required|array',
           'passengers.*.fare.*.baseFare' => 'required|numeric|min:0',
'passengers.*.fare.*.tax' => 'required|numeric|min:0',
'passengers.*.fare.*.yqTax' => 'nullable|numeric|min:0',
'passengers.*.fare.*.transactionFee' => 'nullable|string',
'passengers.*.fare.*.additionalTxnFeeOfrd' => 'nullable|numeric|min:0',
'passengers.*.fare.*.additionalTxnFeePub' => 'nullable|numeric|min:0',
'passengers.*.fare.*.airTransFee' => 'nullable|string',
            'passengers.*.gst.companyAddress' => 'nullable|string',
            'passengers.*.gst.companyContactNumber' => 'nullable|string',
            'passengers.*.gst.companyName' => 'nullable|string',
            'passengers.*.gst.number' => 'nullable|string',
            'passengers.*.gst.companyEmail' => 'nullable|email',
        ]);

        // Prepare payload
        $payload = [
            'EndUserIp' => '1.1.1.1', // Replace with actual IP
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
            'SrdvType' => 'MixAPI',
            'SrdvIndex' => $validatedData['srdvIndex'],
            'TraceId' => $validatedData['traceId'],
            'ResultIndex' => $validatedData['resultIndex'],
            'Passengers' => array_map(function ($passenger) {
                return [
                    'Title' => $passenger['title'],
                    'FirstName' => $passenger['firstName'],
                    'LastName' => $passenger['lastName'],
                    'PaxType' => $passenger['paxType'],
                    'DateOfBirth' => $passenger['dateOfBirth'],  // Already in correct format
                    'Gender' => $passenger['gender'],
                    'PassportNo' => $passenger['passportNo'],
                    'PassportExpiry' => $passenger['passportExpiry'],  // Already in correct format
                    'AddressLine1' => $passenger['addressLine1'] ?? 'Noida',
                    'City' => $passenger['city'] ?? 'Noida',
                    'CountryCode' => $passenger['countryCode'],
                    'CountryName' => $passenger['countryName'],
                    'ContactNo' => $passenger['contactNo'],
                    'Email' => $passenger['email'],
                    'IsLeadPax' => (int)$passenger['isLeadPax'],
                    'Fare' => $passenger['fare'],  // Already in correct format as array
                    'GSTCompanyAddress' => $passenger['gst']['companyAddress'] ?? '',
                    'GSTCompanyContactNumber' => $passenger['gst']['companyContactNumber'] ?? '',
                    'GSTCompanyName' => $passenger['gst']['companyName'] ?? '',
                    'GSTNumber' => $passenger['gst']['number'] ?? '',
                    'GSTCompanyEmail' => $passenger['gst']['companyEmail'] ?? '',
                ];
            }, $validatedData['passengers'])
        ];

        // Add logging for debugging
        Log::info('Flight Booking Payload', ['payload' => $payload]);

        // Make API request
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'API-Token' => 'MakeMy@910@23',
        ])->post('https://flight.srdvtest.com/v8/rest/Hold', $payload);

        Log::info('Flight Booking Response', ['response' => $response->json()]);

        if (!$response->successful()) {
            Log::error('Flight API Error', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'API request failed: ' . ($response->json()['message'] ?? 'Unknown error')
            ], $response->status());
        }

        $apiResponse = $response->json();

        // Check for API-level errors
        if ($apiResponse['Error']['ErrorCode'] !== '0') {
            return response()->json([
                'status' => 'error',
                'message' => $apiResponse['Error']['ErrorMessage']
            ], 422);
        }

        // Return success response
        return response()->json([
            'status' => 'success',
            'booking_details' => [
                'booking_id' => $apiResponse['Response']['BookingId'],
                'pnr' => $apiResponse['Response']['PNR'],
                'srdvIndex' => $apiResponse['Response']['SrdvIndex'],
                'trace_id' => $apiResponse['TraceId'],
                'fare' => $apiResponse['Response']['FlightItinerary']['Fare'],
                'is_price_changed' => $apiResponse['Response']['IsPriceChanged'],
                'is_time_changed' => $apiResponse['Response']['IsTimeChanged'],
                'last_ticket_date' => $apiResponse['Response']['FlightItinerary']['LastTicketDate']
            ]
        ]);

    } catch (ValidationException $e) {
        Log::error('Validation Error', [
            'errors' => $e->errors(),
            'request' => $request->all()
        ]);
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        Log::error('Flight Booking Error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Booking failed: ' . $e->getMessage()
        ], 500);
    }
}


public function getCalendarFare(Request $request)
{
    try {
        $selectedDate = now()->format('Y-m-d'); // Default to current date
        $origin = "LKO";
        $destination = "DEL";

        $formattedDate = date('Y-m-d\T00:00:00', strtotime($selectedDate));

        $payload = [
            "EndUserIp" => "1.1.1.1",
            "ClientId" => "180133",
            "UserName" => "MakeMy91",
            "Password" => "MakeMy@910",
            "JourneyType" => "1",
            "Sources" => null,
            "FareType" => 1,
            "Segments" => [
                [
                    "Origin" => strtoupper($origin),
                    "Destination" => strtoupper($destination),
                    "FlightCabinClass" => "1",
                    "PreferredDepartureTime" => $formattedDate,
                    "PreferredArrivalTime" => $formattedDate
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'API-Token' => 'MakeMy@910@23',
            'Accept' => 'application/json',
        ])->post('https://flight.srdvtest.com/v8/rest/GetCalendarFare', $payload);

        return response()->json($response->json());
    } catch (\Exception $e) {
        return response()->json([
            'Error' => [
                'ErrorCode' => 1,
                'ErrorMessage' => $e->getMessage()
            ]
        ], 500);
    }
}
public function flightBalance(Request $request)
{

    $request->validate([
        'EndUserIp' => 'required|string',
        'ClientId' => 'required|string',
        'UserName' => 'required|string',
        'Password' => 'required|string'
    ]);
    // Prepare API request payload
    $payload = [
                'EndUserIp' => '1.1.1.1',
                'ClientId' => '180133',
                'UserName' => 'MakeMy91',
                'Password' => 'MakeMy@910',
    ];

    try {
        // Make the API call
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
             'Api-Token' => 'MakeMy@910@23'
        ])->post('https://flight.srdvtest.com/v8/rest/Balance', $payload);

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


public function flightBalanceLog(Request $request) {
    // Validate request
    $validated = $request->validate([
        'TraceId' => 'required|string',
        'amount' => 'required|numeric'
    ]);

    // Hotel Balance Log API request data
    $requestData = [
        'EndUserIp' => '1.1.1.1',
        'ClientId' => '180133',
        'UserName' => 'MakeMy91',
        'Password' => 'MakeMy@910',
    ];

    try {
        // Make the API call
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Token' => 'MakeMy@910@23'
        ])->post('https://flight.srdvtest.com/v8/rest/BalanceLog', $requestData);

        $data = $response->json();
        \Log::info('Hotel Balance API Response:', $data);

        if (isset($data['Error']) && $data['Error']['ErrorCode'] === '0' && isset($data['Result'])) {
            $result = $data['Result'][0]; // Get the first result since we're dealing with current balance

            $currentBalance = floatval($result['Balance']);
            $debitAmount = floatval($validated['amount']);
            
            // Validate sufficient balance
            if ($currentBalance < $debitAmount) {
                return response()->json([
                    'success' => false,
                    'errorMessage' => 'Insufficient balance. Current balance: ' . $currentBalance,
                ], 400);
            }

            // Calculate new balance
            $updatedBalance = $currentBalance - $debitAmount;

            // Prepare the response with updated values
            $processedLog = [
                'ID' => $result['ID'],
                'Date' => $result['Date'],
                'ClientID' => $result['ClientID'],
                'ClientName' => $result['ClientName'],
                'Detail' => $result['Detail'],
                'Debit' => $debitAmount,
                'Credit' => 0,
                'PreviousBalance' => $currentBalance,
                'Balance' => $updatedBalance,
                'Module' => 'Flight API',
                'TraceID' => $validated['TraceId'],
                'RefID' => $result['RefID'],
                'UpdatedBy' => $result['UpdatedBy']
            ];

            return response()->json([
                'success' => true,
                'balanceLog' => $processedLog,
            ]);
        }

        return response()->json([
            'success' => false,
            'errorMessage' => $data['Error']['ErrorMessage'] ?? 'Unknown error occurred.',
        ], 400);

    } catch (\Exception $e) {
        \Log::error('Balance Log API Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'errorMessage' => 'Failed to process balance log request.',
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
                'ClientId' => '180189',
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



    //Payment Gateway Integration

    public function createOrder(Request $request)
{
    try {
        // Decode booking details from request
        $bookingDetails = json_decode($request->input('booking_details'), true);
        
        if (!$bookingDetails) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid booking details'
            ], 400);
        }

        $api = new Api('rzp_test_cvVugPSRGGLWtS', 'xHoRXawt9gYD7vitghKq1l5c');

        // Calculate the amount in paise (Razorpay requires amount in smallest currency unit)
        $amount = $bookingDetails['grandTotal'] * 100;
        
        // Determine if this is a round trip - Fixed this section for proper checking
        $isRoundTrip = false;
        if (isset($bookingDetails['lcc'])) {
            $isRoundTrip = isset($bookingDetails['lcc']['return']) && $bookingDetails['lcc']['return'];
        } else if (isset($bookingDetails['nonLcc'])) {
            $isRoundTrip = isset($bookingDetails['nonLcc']['return']);
        }
        
        // Create order
        $orderData = [
            'receipt' => 'flight_booking_' . time(),
            'amount' => $amount,
            'currency' => 'INR',
            'notes' => [
                'flight_type' => $isRoundTrip ? 'round_trip' : 'one_way',
            ]
        ];
        
        $razorpayOrder = $api->order->create($orderData);
        
        // Save payment information
        $payment = new FlightPayment();
        $payment->amount = $bookingDetails['grandTotal'];
        $payment->razorpay_payment_id = 'pending_' . uniqid();
        $payment->razorpay_order_id = $razorpayOrder->id;
        $payment->status = 'pending';
        $payment->booking_details = $bookingDetails;
        $payment->is_round_trip = $isRoundTrip;
        
        // Store booking IDs and PNRs - Fixed this section for proper null checking
        if ($isRoundTrip) {
            // For round trips, store both outbound and return details
            $outboundDetails = [];
            $returnDetails = [];
            
            if (isset($bookingDetails['nonLcc'])) {
                if (isset($bookingDetails['nonLcc']['outbound'])) {
                    $outboundDetails = [
                        'booking_id' => $bookingDetails['nonLcc']['outbound']['bookingId'] ?? null,
                        'pnr' => $bookingDetails['nonLcc']['outbound']['pnr'] ?? null,
                    ];
                    $payment->booking_id = $outboundDetails['booking_id'];
                    $payment->pnr = $outboundDetails['pnr'];
                }
                
                if (isset($bookingDetails['nonLcc']['return'])) {
                    $returnDetails = [
                        'booking_id' => $bookingDetails['nonLcc']['return']['bookingId'] ?? null,
                        'pnr' => $bookingDetails['nonLcc']['return']['pnr'] ?? null,
                    ];
                }
            }
            
            $payment->outbound_details = $outboundDetails;
            $payment->return_details = $returnDetails;
        } else {
            // For one-way flights
            if (isset($bookingDetails['nonLcc']) && isset($bookingDetails['nonLcc']['outbound'])) {
                $payment->booking_id = $bookingDetails['nonLcc']['outbound']['bookingId'] ?? null;
                $payment->pnr = $bookingDetails['nonLcc']['outbound']['pnr'] ?? null;
            } else if (isset($bookingDetails['urlDetails'])) {
                // For legacy code compatibility
                $payment->booking_id = $bookingDetails['urlDetails']['bookingId'] ?? null;
                $payment->pnr = $bookingDetails['urlDetails']['pnr'] ?? null;
            }
        }   
        
        // Get lead passenger details
        $leadPassenger = $this->findLeadPassenger($bookingDetails);
        if ($leadPassenger) {
            $payment->user_name = $leadPassenger['firstName'] . ' ' . $leadPassenger['lastName'];
            $payment->email = $leadPassenger['email'] ?? null;
            $payment->contact = $leadPassenger['contactNo'] ?? null;
        }
        
        $payment->save();
        
        return response()->json([
            'status' => 'success',
            'order_id' => $razorpayOrder->id,
            'payment_id' => $payment->id,
            'amount' => $amount / 100,
            'currency' => 'INR',
            'key_id' => env('rzp_test_cvVugPSRGGLWtS', 'rzp_test_cvVugPSRGGLWtS'),
            'name' => $payment->user_name ?? 'Flight Booking',
            'email' => $payment->email,
            'contact' => $payment->contact
        ]);
        
    } catch (Exception $e) {
        Log::error('Razorpay order creation failed: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
}
    
public function verifyPayment(Request $request)
{
    $input = $request->all();
    
    // Get signature details
    $signature = $request->input('razorpay_signature');
    $razorpay_payment_id = $request->input('razorpay_payment_id');
    $razorpay_order_id = $request->input('razorpay_order_id');

    $api = new Api('rzp_test_cvVugPSRGGLWtS', 'xHoRXawt9gYD7vitghKq1l5c');
    
    try {
        $payment = FlightPayment::where('razorpay_order_id', $razorpay_order_id)->firstOrFail();
        
        // Verify signature
        $generatedSignature = hash_hmac('sha256', $razorpay_order_id . '|' . $razorpay_payment_id, 'xHoRXawt9gYD7vitghKq1l5c');
        
        if ($generatedSignature !== $signature) {
            throw new Exception('Invalid payment signature');
        }
        
        // Update payment details
        $payment->razorpay_payment_id = $razorpay_payment_id;
        $payment->razorpay_signature = $signature;
        $payment->status = 'success';
        $payment->payment_date = now();
        $payment->payment_method = $request->input('payment_method', 'razorpay');
        $payment->save();
        
        // Process booking based on flight type
        $bookingDetails = $payment->booking_details;
        
        if (isset($bookingDetails['lcc'])) {
            // Process LCC booking
            $this->processLCCBooking($payment);
        } else if (isset($bookingDetails['nonLcc'])) {
            // Process non-LCC booking
            $this->processNonLCCBooking($payment);
        }
        
        return redirect()->route('flight.payment.success', ['payment_id' => $payment->id])
            ->with('success', 'Payment successful!');
        
    } catch (Exception $e) {
        Log::error('Payment verification failed: ' . $e->getMessage());
        return redirect()->route('flight.booking.failed')
            ->with('error', 'Payment verification failed: ' . $e->getMessage());
    }
}


    
    protected function processLCCBooking($payment)
    {
        try {
            $bookingDetails = $payment->booking_details;
            
            // For LCC flights, we need to complete the booking
            if (isset($bookingDetails['lcc'])) {
                // Process outbound LCC flight
                if (isset($bookingDetails['lcc']['outbound']) && $bookingDetails['lcc']['outbound']) {
                    // Make API call to complete outbound LCC booking
                    // This is where you would implement the API call to your LCC booking provider
                    // ...
                }
                
                // Process return LCC flight
                if (isset($bookingDetails['lcc']['return']) && $bookingDetails['lcc']['return']) {
                    // Make API call to complete return LCC booking
                    // This is where you would implement the API call to your LCC booking provider
                    // ...
                }
            }
        } catch (Exception $e) {
            Log::error('LCC booking processing failed: ' . $e->getMessage());
            // You might want to handle this error and notify admin
        }
    }
    
    
    public function handleFailedPayment(Request $request)
    {
        $razorpay_order_id = $request->input('razorpay_order_id');
        
        try {
            $payment = FlightPayment::where('razorpay_order_id', $razorpay_order_id)->firstOrFail();
            $payment->status = 'failed';
            $payment->save();
            
            return redirect()->route('flight.booking.failed')
                ->with('error', 'Payment failed. Please try again.');
            
        } catch (Exception $e) {
            Log::error('Failed payment handling error: ' . $e->getMessage());
            return redirect()->route('flight.booking.failed')
                ->with('error', 'An error occurred. Please try again.');
        }
    }



    protected function processNonLCCBooking($payment) {
        try {
            $bookingDetails = $payment->booking_details;
            
            // For non-LCC flights, we need to complete the GDS ticket booking
            if (isset($bookingDetails['nonLcc'])) {
                // Extract necessary booking details
                $traceId = $bookingDetails['nonLcc']['traceId'] ?? null;
                $srdvIndex = $bookingDetails['nonLcc']['srdvIndex'] ?? null;
                $pnr = $bookingDetails['nonLcc']['pnr'] ?? null;
                $bookingId = $bookingDetails['nonLcc']['bookingId'] ?? null;
                
                if (!$traceId || !$srdvIndex || !$pnr || !$bookingId) {
                    throw new Exception('Missing required parameters for GDS ticket booking');
                }
                
                // Create payload for GDS ticket booking API
                $payload = [
                    'EndUserIp' => '1.1.1.1',
                    'ClientId' => '180133',
                    'UserName' => 'MakeMy91',
                    'Password' => 'MakeMy@910',
                    'srdvType' => 'MixAPI',
                    'srdvIndex' => $srdvIndex,
                    'traceId' => $traceId,
                    'pnr' => $pnr,
                    'bookingId' => $bookingId
                ];
                
        
            }
        } catch (Exception $e) {
            Log::error('Non-LCC booking processing failed: ' . $e->getMessage());
            // Handle error and notify admin
        }
    }
    
    public function showSuccess(Request $request)
    {
        $paymentId = $request->input('payment_id');
        $payment = FlightPayment::findOrFail($paymentId);
        
        return view('frontend.flightSuccess', compact('payment'));
    }
    
    public function showFailed()
    {
        return view('flight.booking.failed');
    }
    
    private function findLeadPassenger($bookingDetails)
    {
        // Try to find a lead passenger from booking details
        if (isset($bookingDetails['nonLcc'])) {
            if ($bookingDetails['nonLcc']['outbound'] && !empty($bookingDetails['nonLcc']['outbound']['passengers'])) {
                foreach ($bookingDetails['nonLcc']['outbound']['passengers'] as $passenger) {
                    if (isset($passenger['isLeadPax']) && $passenger['isLeadPax']) {
                        return $passenger;
                    }
                }
                // If no lead passenger is marked, return the first one
                return $bookingDetails['nonLcc']['outbound']['passengers'][0] ?? null;
            }
        }
        
        if (isset($bookingDetails['lcc']) && isset($bookingDetails['lcc']['outbound']) && 
            isset($bookingDetails['lcc']['outbound']['passengers']) && 
            !empty($bookingDetails['lcc']['outbound']['passengers'])) {
            return $bookingDetails['lcc']['outbound']['passengers'][0] ?? null;
        }
        
        // For legacy code compatibility
        if (isset($bookingDetails['passengers']) && !empty($bookingDetails['passengers'])) {
            return $bookingDetails['passengers'][0] ?? null;
        }
        
        return null;
    }

}



