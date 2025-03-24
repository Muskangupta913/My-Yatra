<?php

namespace App\Http\Controllers;

use App\Models\CarCity;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Services\CarApiService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\SearchCarRequest;
use App\Http\Requests\BookCarRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;


class CarController extends Controller
{
    protected $carApiService;

    public function __construct()
    {
        $this->apiConfig = [
            'url' => config('car.api_url'),
            'token' => config('car.api_token'),
            'client_id' => config('car.client_id'),
            'username' => config('car.username'),
            'password' => config('car.password')
        ];
    }


    public function searchCars(Request $request)
    {
        try {
            // Log the incoming request data
            Log::info('Car Search Request:', $request->all());

            // Format the pickup date properly
            $pickupDate = date('d/m/Y', strtotime($request->input('searchParams.pickupDate')));
            // Format the return date if it exists
            $returnDate = $request->input('searchParams.returnDate') 
            ? date('d/m/Y', strtotime($request->input('searchParams.returnDate'))) 
            : "";
            $requestBody = [
                "EndUserIp" => "1.1.1.1",
                "ClientId" => $this->apiConfig['client_id'],
                "UserName" => $this->apiConfig['username'],
                "Password" => $this->apiConfig['password'],
                "FormCity" => $request->input('searchParams.pickupLocationCode'),
                "ToCity" => $request->input('searchParams.dropoffLocationCode'),
                "PickUpDate" => $pickupDate,
               "DropDate" => $returnDate,
                "Hours" => "8",
                "TripType" => $request->input('searchParams.tripType', "0")
            ];


            // Log the API request
            Log::info('API Request:', $requestBody);

            $response = Http::withHeaders([
                'API-Token' => $this->apiConfig['token'],
                'Content-Type' => 'application/json',
            ])->post($this->apiConfig['url'] . 'Search', $requestBody);

             // Log the raw API response
             Log::info('Raw API Response:', ['response' => $response->body()]);

            $responseData = $response->json();
            
           
           // Check for API error response
           if (isset($responseData['Error']) && $responseData['Error']['ErrorCode'] !== "0") {
            throw new \Exception($responseData['Error']['ErrorMessage'] ?? 'API Error occurred');
        }

        // Validate response structure
        if (!isset($responseData['Result']) || !isset($responseData['Result']['TaxiData'])) {
            throw new \Exception('Invalid API response structure');
        }


             // Store search results in session
             session([
                'carSearchResults' => [
                    'TaxiData' => $responseData['Result']['TaxiData'],
                    'PaymentMethods' => $responseData['Result']['PaymentMethods'] ?? [],
                    'RequestData' => $responseData['Result']['RequestData'] ?? [],
                    'TraceID' => $responseData['Result']['TraceID'] ?? null
                ],
                'carSearchParams' => $request->input('searchParams')
            ]);

          
            return response()->json([
                'success' => true,
                'trace_id' => $responseData['Result']['TraceID'] ?? null,
                'srdv_index' => $responseData['Result']['TaxiData'][0]['SrdvIndex'] ?? null,
                'message' => 'Cars found successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Car Search Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        try {
            // Get data from session
            $results = session('carSearchResults');
            $searchParams = session('carSearchParams');
    
            if (!$results) {
                return redirect()->route('home')->with('error', 'Please search for cars first.');
            }
    
            // Process the car data
            $cars = collect($results['TaxiData'])->map(function($car) {
                return [
                    'id' => $car['SrdvIndex'] ?? null,
                    'category' => $car['Category'] ?? 'Unknown',
                    'image' => $car['Image'] ?? asset('images/default-car.jpg'),
                    'seatingCapacity' => $car['SeatingCapacity'] ?? 4,
                    'luggageCapacity' => $car['LuggageCapacity'] ?? 2,
                    'hasAC' => $car['AirConditioner'] ?? false,
                    'availability' => $car['Availability'] ?? 0,
                    'carType' => $car['Category'] ? str_replace('_', ' ', $car['Category']) : 'Standard',
                    'totalAmount' => $car['Fare']['TotalAmount'] ?? 0,
                    'baseFare' => $car['Fare']['BaseFare'] ?? 0,
                    'serviceTax' => $car['Fare']['TotalServiceTax'] ?? 0,
                    'isRefundable' => $car['Fare']['Refundable'] ?? false
                ];
            })->toArray();
    
            // Log the final processed data
            Log::info('Passing to view:', [
                'cars' => $cars,
                'searchParams' => $searchParams
            ]);
    
            return view('frontend.cars', compact('cars', 'searchParams'));
    
        } catch (\Exception $e) {
            Log::error('Error in index method:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('home')->with('error', 'An error occurred while loading cars.');
        }
    }


    public function fetchCityDetails(Request $request)
    {
        $validated = $request->validate([
            'caoncitlst_city_name' => 'required|string|min:2|max:50',
        ]);

        // Get city details using CarApiService
        $cityDetails = $this->carApiService->getCityDetails($validated['caoncitlst_city_name']);

        if ($cityDetails) {
            return response()->json([
                'status' => true,
                'caoncitlst_city_name' => $cityDetails['caoncitlst_city_name'],
                'caoncitlst_id' => $cityDetails['caoncitlst_id'],
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'City not found',
        ], 404);
    }


    private function getCityCode($cityName)
    {
        $city = CarCity::where('caoncitlst_city_name', $cityName)->first();
        return $city ? $city->caoncitlst_id : null;
    }

   
    public function fetchCities(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string|min:2|max:50',
        ]);

        try {
            $cities = CarCity::where('caoncitlst_city_name', 'LIKE', "%{$validated['query']}%")
                ->where('caoncitlst_status', 'active')
                ->select('caoncitlst_city_name', 'caoncitlst_id')
                ->limit(10)
                ->get();

            return response()->json($cities);
        } catch (\Exception $e) {
            Log::error('Cities retrieval failed', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Cities retrieval failed.'], 500);
        }
    }

    public function cars()
    {
        return view('frontend.cars'); 
    }
    public function bookCar(Request $request) {
        $validated = $request->validate([
            'car_id' => 'required',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'booking_date' => 'required|date',
        ]);
    
        Booking::create([
            'car_id' => $request->car_id,
            'user_name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'booking_date' => $request->booking_date,
        ]);
    
        return redirect()->route('booking.success')->with('message', 'Car booked successfully!');
    }
    public function payment(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'name' => 'required|string|min:3',
                'email' => 'required|email',
                'phone' => 'required|string|min:10',
                'pickup_address' => 'required|string',
                'drop_address' => 'required|string',
                'booking_date' => 'required|date',
                'terms' => 'required|accepted'
            ]);

            // Process payment and booking logic here
            
            return response()->json([
                'success' => true,
                'redirectUrl' => route('car.payment'),
                'message' => 'Booking confirmed successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
    
public function checkBalance(Request $request)
{
    try {
        $response = Http::withHeaders([
            'API-Token' => 'MakeMy@910@23',
            'Content-Type' => 'application/json',
        ])->post('https://car.srdvtest.com/v5/rest/Balance', [
            "EndUserIp" => "1.1.1.1",
            "ClientId" => $this->apiConfig['client_id'],
            "UserName" => $this->apiConfig['username'],
            "Password" => $this->apiConfig['password'],
        ]);

        $data = $response->json();
        
                // Log the API response
                Log::info('Balance API Response:', $data);


        if (!isset($data['Error']) || $data['Error']['ErrorCode'] !== "0") {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify wallet balance'
            ], 400);
        }

         // Log successful balance check
         Log::info('Balance check successful:', [
            'balance' => $data['Balance'],
            'credit_limit' => $data['CreditLimit'] ?? 0
        ]);

        return response()->json([
            'success' => true,
            'balance' => $data['Balance']
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to check balance: ' . $e->getMessage()
        ], 500);
    }
}

public function processPayment(Request $request)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'phone' => 'required|string|min:10',
            'pickup_address' => 'required|string',
            'drop_address' => 'required|string',
            'booking_date' => 'required|date',
            'terms' => 'required|accepted',
              // Add validation for car details
              'car_id' => 'required',
              'car_category' => 'required',
              'car_seating' => 'required',
              'car_luggage' => 'required',
              'car_price' => 'required',
              'car_base_fare' => 'required', 
              // Add validation for trip details
              'pickup_location' => 'required',
              'dropoff_location' => 'required',
              'trip_type' => 'required',
              'trace_id' => 'required',
              'srdv_index' => 'required'
        ]);

         // Restructure the data to match the view's expectations
         $bookingDetails = [
            'personal_info' => [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone']
            ],
            'trip_info' => [
                'pickup_location' => $validated['pickup_location'],
                'dropoff_location' => $validated['dropoff_location'],
                'pickup_address' => $validated['pickup_address'],
                'drop_address' => $validated['drop_address'],
                'booking_date' => $validated['booking_date'],
                'trip_type' => $validated['trip_type']
            ],
            'car_info' => [
                'id' => $validated['car_id'],
                'category' => $validated['car_category'],
                'seating' => $validated['car_seating'],
                'luggage' => $validated['car_luggage'],
                'price' => $validated['car_price'],
                'base_fare' => $validated['car_base_fare'] // Add base_fare here
            ],
            'trace_id' => $validated['trace_id'],
            'srdv_index' => $validated['srdv_index']
        ];

        // Store the restructured booking details in session
        Session::put('booking_details', $bookingDetails);

        return response()->json([
            'success' => true,
            'redirectUrl' => route('car.payment'),
            'message' => 'Redirecting to payment page'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 422);
    }
}

public function showPayment()
{
    // Get booking details from session
    $bookingDetails = Session::get('booking_details');
    
    if (!$bookingDetails) {
        return redirect()->route('cars.index')
                        ->with('error', 'Please complete booking form first');
    }

    // Ensure all required arrays exist
    if (!isset($bookingDetails['personal_info']) || 
        !isset($bookingDetails['trip_info']) || 
        !isset($bookingDetails['car_info'])) {
        return redirect()->route('cars.index')
                        ->with('error', 'Invalid booking information');
    }

    return view('frontend.car_payment', compact('bookingDetails'));
}

public function showBookingForm()
{
    return view('frontend.car_booking_form');
}

}

