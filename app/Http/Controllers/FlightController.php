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
                'EndUserIp' => 'required',
                'ClientId' => 'required',
                'UserName' => 'required',
                'Password' => 'required',
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
            'passenger' => 'required|array|min:1',
            'passenger.*.title' => 'required|string',
            'passenger.*.firstName' => 'required|string',
            'passenger.*.lastName' => 'required|string',
            'passenger.*.gender' => 'required|integer',
            'passenger.*.contactNo' => 'required|string',
            'passenger.*.email' => 'required|email',
            'passenger.*.paxType' => 'required|integer',
            'passenger.*.dateOfBirth' => 'nullable|string',
            'passenger.*.passportNo' => 'nullable|string',
            'passenger.*.passportExpiry' => 'nullable|string',
            'passenger.*.passportIssueDate' => 'nullable|string',
            'passenger.*.countryCode' => 'nullable|string',
            'passenger.*.addressLine1' => 'nullable|string',
            'passenger.*.city' => 'nullable|string',
            'passenger.*.countryName' => 'nullable|string',
            'passenger.*.nationality' => 'nullable|string',
            'passenger.*.baggage' => 'nullable|array',
            'passenger.*.mealDynamic' => 'nullable|array',
            'passenger.*.seat' => 'nullable|array',
            'passenger.*.ssr' => 'nullable|array',
            'fare' => 'required|array',
            'fare.baseFare' => 'required|numeric',
            'fare.tax' => 'required|numeric',
            'fare.yqTax' => 'nullable|numeric',
            'fare.transactionFee' => 'nullable|numeric',
            'fare.additionalTxnFeeOfrd' => 'nullable|numeric',
            'fare.additionalTxnFeePub' => 'nullable|numeric',
            'fare.airTransFee' => 'nullable|numeric',
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
                    'Gender' => (string)$pax['gender'],
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
                    'FFAirlineCode' => $pax['ffAirlineCode'] ?? '',
                    'Baggage' => $pax['baggage'] ?? [],
                    'MealDynamic' => $pax['mealDynamic'] ?? [],
                    'Seat' => $pax['seat'] ?? [],
                    'Ssr' => $pax['ssr'] ?? [],
                    'SegmentAdditionalInfo' => [],
                    'Fare' => [
                        'Currency' => 'INR',
                        'BaseFare' => $pax['fare']['baseFare'] ?? 0,
                        'Tax' => $pax['fare']['tax'] ?? 0,
                        'YQTax' => $pax['fare']['yqTax'] ?? 0,
                        'AdditionalTxnFeeOfrd' => (string)($pax['fare']['additionalTxnFeeOfrd'] ?? '0'),
                        'AdditionalTxnFeePub' => (string)($pax['fare']['additionalTxnFeePub'] ?? '0'),
                        'ServiceFee' => '0',
                        'TotalBaggageCharges' => '0',
                        'TotalMealCharges' => '0',
                        'TotalSeatCharges' => '0',
                        'TotalSpecialServiceCharges' => '0'
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
                            'ssr' => $passenger['Ssr'] ?? [],
                            'segment_additional_info' => $passenger['SegmentAdditionalInfo'] ?? []
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
        'EndUserIp' => '1.1.1.1',
                'ClientId' => '180133',
                'UserName' => 'MakeMy91',
                'Password' => 'MakeMy@910',
    ];

    // Make the API call
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Api-Token' => 'MakeMy@910@23'
    ])->post('https://flight.srdvtest.com/v8/rest/BalanceLog', $requestData);

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


}



