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

class CarController extends Controller
{
    protected $carApiService;

    public function __construct(CarApiService $carApiService)
    {
        $this->carApiService = $carApiService;
    }

    public function index(Request $request)
    {
        // Example search parameters, define how to retrieve them based on the request
        $searchParams = [
            // Add logic to set search params based on request data
        ];

        try {
            // Fetch car data from the API
            $response = $this->carApiService->searchCars($searchParams);
    
            // Check for API errors
            if (isset($response['Error']) && $response['Error']['ErrorCode'] != 0) {
                return view('frontend.cars', [
                    'cars' => [], // Pass an empty array if no cars
                    'error' => $response['Error']['ErrorMessage']
                ]);
            }
    
            // Extract car data
            $cars = $response['Result']['TaxiData'] ?? [];
    
            // Return the view with cars
            return view('frontend.cars', [
                'cars' => $cars // Explicitly pass the cars array
            ]);
        } catch (\Exception $e) {
            // Return view with empty cars array in case of exception
            return view('frontend.cars', [
                'cars' => [],
                'error' => 'Unable to fetch car search results'
            ]);
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

    protected function processCars($cars)
    {
        return array_map(function($car) {
            return [
                'Category' => $car['Category'] ?? 'Unknown',
                'Image' => $car['Image'] ?? 'default-car.jpg',
                'SeatingCapacity' => $car['SeatingCapacity'] ?? 0,
                'Availability' => $car['Availability'] ?? 0,
                'TotalAmount' => $car['Fare']['TotalAmount'] ?? 0,
                'CarNos' => $car['CarNos'] ?? [],
            ];
        }, $cars);
    }

    /**
     * Fetch the city code.
     */
    private function getCityCode($cityName)
    {
        $city = CarCity::where('caoncitlst_city_name', $cityName)->first();
        return $city ? $city->caoncitlst_id : null;
    }

    /**
     * Fetch cities based on search query.
     */
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

       public function searchCars(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'FormCity' => 'required|string',
                'ToCity' => 'required|string',
                'PickUpDate' => 'required|date_format:d/m/Y',
                // 'DropDate' => 'nullable|date_format:d/m/Y',
                'Hours' => 'nullable|integer',
                'TripType' => 'required|string'
            ]);

            // Prepare the payload for the API request
            $payload = [
                'EndUserIp' => '1.1.1.1', 
                'ClientId' => '180133',
                'UserName' => 'MakeMy91',
                'Password' => 'MakeMy@910',
                'FormCity' => trim($request->input('FormCity')),
                'ToCity' => trim($request->input('ToCity')),
                'PickUpDate' => trim($request->input('PickUpDate')),
                'DropDate' => trim($request->input('DropDate', '')),
                'Hours' => trim($request->input('Hours', '8')),
                'TripType' => trim($request->input('TripType')),
            ];

            Log::info('Car Search Request', $payload);

            // Send API request
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => 'MakeMy@910@23', // Consider using env for API token
            ])->withBody(json_encode($payload), 'application/json')
            ->post('https://car.srdvtest.com/v5/rest/Search');
            
            // Decode the response
            $data = $response->json();

            Log::info('Car Search Response', $data);

            // Check if the response is successful and handle errors
            if (!$response->successful() || !isset($data['Error']['ErrorCode']) || $data['Error']['ErrorCode'] !== '0') {
                Log::error('Car API Error', ['response' => $data]);
                return response()->json([
                    'status' => false,
                    'message' => $data['Error']['ErrorMessage'] ?? 'Failed to fetch car data'
                ], 400);
            }

            // Format and map the API response
            $formattedResponse = [
                'status' => true,
                'data' => collect($data['Result']['TaxiData'] ?? [])->map(function ($car) use ($data) {
                    return [
                        'SrdvIndex' => $car['SrdvIndex'] ?? null,
                        'Category' => $car['Category'] ?? null,
                        'Image' => $car['Image'] ?? null,
                        'SeatingCapacity' => $car['SeatingCapacity'] ?? null,
                        'LuggageCapacity' => $car['LuggageCapacity'] ?? null,
                        'AirConditioner' => $car['AirConditioner'] ?? null,
                        'CarNumbers' => $car['CarNos'] ?? null,
                        'Fare' => [
                            'TotalAmount' => $car['Fare']['TotalAmount'] ?? null,
                            'AdvanceAmount' => $car['Fare']['AdvanceAmount'] ?? null,
                            'BaseFare' => $car['Fare']['BaseFare'] ?? null,
                            'ServiceTax' => $car['Fare']['TotalServiceTax'] ?? null,
                            'DriverAllowance' => $car['Fare']['OutStationDriverAllowance'] ?? null
                        ],
                        'TraceID' => $data['Result']['TraceID'] ?? null,
                        'RefID' => uniqid('CAR_')
                    ];
                })->all(),
                'cities' => [
                    'pickup' => $data['Result']['RequestData']['CityData'][0]['Name'] ?? '',
                    'dropoff' => $data['Result']['RequestData']['CityData'][1]['Name'] ?? ''
                ],
                'paymentMethods' => $data['Result']['PaymentMethods'] ?? null
            ];

            return response()->json($formattedResponse);

        } catch (\Exception $e) {
            // Log the exception if something goes wrong
            Log::error('Car Search Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => false,
                'message' => 'An error occurred while searching for cars'
            ], 500);
        }
    }
   
    public function showBookingForm(Request $request)
    {
        // If there's a success or error message passed, show the response
        return view('frontend.car_booking', ['response' => $request->session()->get('response')]);
    }

    public function showCars()
    {
        return view('frontend.cars');  
    }
      

    // Balance of the code
    public function checkWalletBalance(Request $request)
    {
        try {
            $carApiService = new CarApiService();
            $walletBalance = $carApiService->getWalletBalance();
    
            $amount = $request->input('amount', 0);
    
            if ($walletBalance >= $amount) {
                return response()->json([
                    'success' => true,
                    'message' => 'Sufficient wallet balance. Proceeding to payment.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient wallet balance. Please recharge your wallet.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to check wallet balance. Please try again later.',
            ], 500);
        }
    }
// Save the data in database 
public function saveCarBooking(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'car' => 'required|string',
            'totalAmount' => 'required|numeric',
            'customerName' => 'required|string',
            'customerPhone' => 'required|string',
            'customerEmail' => 'required|email',
            'customerAddress' => 'required|string',
        ]);

        // Save the data to the database
        try {
            $carBooking = CarBooking::create([
                'customer_name' => $validatedData['customerName'],
                'phone' => $validatedData['customerPhone'],
                'email' => $validatedData['customerEmail'],
                'total_price' => $validatedData['totalAmount'],
                'booking_status' => 'pending', // You can change this as per your requirement
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Car booking saved successfully.',
                'booking_id' => $carBooking->id
            ]);
        } catch (\Exception $e) {
            \Log::error('Booking Save Error', ['message' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while saving the booking.'
            ]);
        }
    }    


//     public function checkWalletBalance()
//     {
//     try {
//         $wallet = app(CarApiService::class)->getWalletBalance();

//         if (!$wallet['status'] || $wallet['balance'] <= 0) {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Insufficient wallet balance. Please recharge your wallet.'
//             ]);
//         }

//         return response()->json([
//             'status' => true,
//             'balance' => $wallet['balance']
//         ]);

//     } catch (\Exception $e) {
//         Log::error('Wallet Balance Check Failed:', ['error' => $e->getMessage()]);
//         return response()->json([
//             'status' => false,
//             'message' => 'Failed to check wallet balance. Please try again later.'
//         ]);
//     }
//   }
  public function processPayment(Request $request)
  {
      try {
          $payload = [
              'EndUserIp' => $request->input('EndUserIp'),
              'ClientId' => env('CAR_API_CLIENT_ID'), 
              'UserName' => env('CAR_API_USERNAME'),   
              'Password' => env('CAR_API_PASSWORD'),
              'SrdvIndex' => $request->input('SrdvIndex'),
              'TraceID' => $request->input('TraceID'),
              'PickUpTime' => $request->input('PickUpTime'),
              'DropUpTime' => $request->input('DropUpTime'),
              'RefID' => $request->input('RefID'),
              'CustomerName' => $request->input('CustomerName'),
              'CustomerPhone' => $request->input('CustomerPhone'),
              'CustomerEmail' => $request->input('CustomerEmail'),
              'CustomerAddress' => $request->input('CustomerAddress'),
              'amount' => $request->input('amount') ?? 1000 // Set a default or dynamic amount
          ];
  
          // Pass the API Token in the request header
          $headers = [
              'Api-Token' => 'MakeMy@910@23'
          ];
  
          // Step 1: Debit Wallet and Book Car
          $paymentResponse = $this->carApiService->processPaymentAndBook($payload, $headers);
  
          if ($paymentResponse['status'] === true) {
              return response()->json([
                  'status' => true,
                  'message' => 'Payment and Booking Successful!',
                  'data' => $paymentResponse
              ]);
          } else {
              \Log::error('Payment or Booking Failed: ' . $paymentResponse['message']);
              return response()->json([
                  'status' => false,
                  'message' => $paymentResponse['message']
              ]);
          }
  
      } catch (\Exception $e) {
          \Log::error('Payment Processing Error: ' . $e->getMessage());
          return response()->json([
              'status' => false,
              'message' => 'An error occurred during payment processing.'
          ]);
      }
  }
  
  

  public function bookingSuccess()
{
    return view('frontend.car_booking_success');
}

  
}

