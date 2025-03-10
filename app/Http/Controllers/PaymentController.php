<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Payment;
use App\Models\CarBookings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    private $config;

    public function __construct()
    {
        $this->config = [
            'razorpay' => [
                'key' => env('RAZORPAY_KEY'),
                'secret' => env('RAZORPAY_SECRET')
            ],
            'car_api' => [
                'url' => env('CAR_API_URL'),
                'client_id' => env('CAR_API_CLIENT_ID'),
                'username' => env('CAR_API_USER_NAME'),
                'password' => env('CAR_API_PASSWORD'),
                'token' => env('CAR_API_TOKEN')
            ]
        ];
    }

    public function createPayment(Request $request)
    {
        try {
            $api = new Api($this->config['razorpay']['key'], $this->config['razorpay']['secret']);

            $order = $api->order->create([
                'receipt' => 'order_rcptid_' . uniqid(),
                'amount' => $request->input('amount') * 100,
                'currency' => 'INR'
            ]);

            return response()->json([
                'order_id' => $order['id'],
                'amount' => $order['amount'] / 100,
                'currency' => $order['currency']
            ]);
        } catch (\Exception $e) {
            Log::channel('payment')->error('Payment Creation Error', [
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Payment creation failed'], 500);
        }
    }

    public function verifyPayment(Request $request)
    {
        try {
            $api = new Api($this->config['razorpay']['key'], $this->config['razorpay']['secret']);

            $validator = Validator::make($request->all(), [
                'razorpay_order_id' => 'required|string',
                'razorpay_payment_id' => 'required|string',
                'razorpay_signature' => 'required|string',
                'trace_id' => 'required|string', // Add trace_id validation
                'srdv_index' => 'required|string' // Add srdv_index validation
            ]);

            if ($validator->fails()) {
                return redirect('/failed')->with('error', 'Invalid payment details');
            }

            $attributes = [
                'razorpay_order_id' => $request->input('razorpay_order_id'),
                'razorpay_payment_id' => $request->input('razorpay_payment_id'),
                'razorpay_signature' => $request->input('razorpay_signature')
            ];

            $api->utility->verifyPaymentSignature($attributes);

            $payment = $api->payment->fetch($attributes['razorpay_payment_id']);

            DB::beginTransaction();

            $paymentRecord = Payment::create([
                'order_id' => $attributes['razorpay_order_id'],
                'payment_id' => $attributes['razorpay_payment_id'],
                'signature' => $attributes['razorpay_signature'],
                'amount' => $payment->amount / 100, 
                'currency' => $payment->currency,
                'status' => 'success'
            ]);

            DB::commit();

            // Store trace_id and srdv_index in session
            session(['trace_id' => $request->input('trace_id')]);
            session(['srdv_index' => $request->input('srdv_index')]);

            return redirect()->route('payment.success')
                ->with('success', 'Payment processed successfully!')
                ->with('payment_id', $paymentRecord->id)
                ->with('bookingDetails', json_decode($request->input('bookingDetails'), true));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('payment')->error('Payment Verification Error', [
                'error' => $e->getMessage()
            ]);

            return redirect()->route('payment.failed')
                ->with('error', 'Payment verification failed');
        }
    }

    public function handlePaymentSuccess(Request $request)
    {
        $bookingDetails = session('bookingDetails');
        
        if (!$bookingDetails) {
            return view('frontend.success')->with('error', 'Booking details not found');
        }
    
        try {
            // Initialize response variables to track API calls
            $balanceLogResponse = null;
            $bookingApiResponse = null;
            
            // Return the view with minimal information - APIs will be called via AJAX
            return view('frontend.success')
                ->with('success', 'Payment processed successfully!')
                ->with('bookingDetails', $bookingDetails)
                ->with('payment_id', session('payment_id'));
                
        } catch (\Exception $e) {
            Log::channel('payment')->error('Payment Success Handling Error', [
                'error' => $e->getMessage()
            ]);
    
            return view('frontend.success')
                ->with('error', 'An unexpected error occurred: ' . $e->getMessage())
                ->with('bookingDetails', $bookingDetails);
        }
    }

    /**
     * Process booking APIs based on request type
     */
    public function processBookingApis(Request $request)
    {
        $type = $request->input('type');
        $bookingDetails = $request->input('bookingDetails', []);
        
        try {
            if ($type === 'balance-log') {
                $response = $this->callBalanceLogApi();
                return response()->json($response);
            } elseif ($type === 'car-booking') {
                if (empty($bookingDetails)) {
                    $bookingDetails = session('bookingDetails');
                    if (empty($bookingDetails)) {
                        throw new \Exception('Booking details not found');
                    }
                }
                
                // First check the balance log
                $balanceLogResponse = $this->callBalanceLogApi();
                if (!$balanceLogResponse['success']) {
                    throw new \Exception('Balance Log API failed: ' . ($balanceLogResponse['error'] ?? 'Unknown error'));
                }
                
                // Then call the car booking API
                $response = $this->callCarBookingApi($bookingDetails);
                
                // If booking successful, save to database
                if ($response['success'] && isset($response['result'])) {
                    $this->saveCarBooking($response['result'], $bookingDetails);
                }
                
                return response()->json($response);
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid API type requested'
                ], 400);
            }
        } catch (\Exception $e) {
            Log::channel('payment')->error('API Processing Error', [
                'type' => $type,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save car booking details to database
     */
    private function saveCarBooking($apiResult, $bookingDetails)
    {
        try {
            DB::beginTransaction();
            
            $carBooking = CarBookings::create([
                // Payment relationship
                'payment_id' => session('payment_id'),
    
                // Third-party API response details
                'srdv_type' => $apiResult['SrdvType'] ?? null,
                'srdv_index' => $apiResult['SrdvIndex'] ?? null,
                'booking_id' => $apiResult['BookingID'] ?? null,
                'ref_id' => $apiResult['RefID'] ?? null,
                'operator_id' => $apiResult['OperatorID'] ?? null,
                'segment_id' => $apiResult['SegmentID'] ?? null,
                'booking_status' => $apiResult['Status'] ?? null,
                'trace_id' => $apiResult['TraceID'] ?? null,
    
                // Booking details from original booking details
                'customer_name' => $bookingDetails['personal_info']['name'] ?? null,
                'customer_phone' => $bookingDetails['personal_info']['phone'] ?? null,
                'customer_email' => $bookingDetails['personal_info']['email'] ?? null,
                'customer_address' => $bookingDetails['trip_info']['pickup_address'] ?? null,
    
                // Trip details
                'pickup_location' => $bookingDetails['trip_info']['pickup_address'] ?? null,
                'dropoff_location' => $bookingDetails['trip_info']['drop_address'] ?? null,
                'pickup_time' => $bookingDetails['trip_info']['pickup_time'] ?? null,
                'dropoff_time' => $bookingDetails['trip_info']['drop_time'] ?? null,
                'booking_date' => $bookingDetails['trip_info']['booking_date'] ?? null,
    
                // Car details
                'car_category' => $bookingDetails['car_info']['category'] ?? null,
                'seating_capacity' => $bookingDetails['car_info']['seating'] ?? null,
                'luggage_capacity' => $bookingDetails['car_info']['luggage'] ?? null,
                'total_price' => $bookingDetails['car_info']['price'] ?? null,

                // Additional API response details
                'full_api_response' => json_encode($apiResult)
            ]);
            
            DB::commit();
            
            return $carBooking;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('payment')->error('Save Car Booking Error', [
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    private function callBalanceLogApi()
    {
        try {
            $response = Http::withHeaders([
                'API-Token' => $this->config['car_api']['token']
            ])->post($this->config['car_api']['url'] . 'BalanceLog', [
                'EndUserIp' => '1.1.1.1', 
                'ClientId' => $this->config['car_api']['client_id'],
                'UserName' => $this->config['car_api']['username'],
                'Password' => $this->config['car_api']['password']
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                return $this->processApiResponse($responseData, 'Balance Log');
            }

            return [
                'success' => false,
                'error' => 'Balance log API request failed'
            ];

        } catch (\Exception $e) {
            Log::channel('payment')->error('Balance Log API Exception', [
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function callCarBookingApi($bookingDetails)
    {
        try {
            $srdvIndex = session('srdv_index') ?? $bookingDetails['srdv_index'] ?? null;
            $traceId = session('trace_id') ?? $bookingDetails['trace_id'] ?? null;
            $customerName = $bookingDetails['personal_info']['name'] ?? 'N/A'; 
            $customerPhone = $bookingDetails['personal_info']['phone'] ?? 'N/A'; 
            $customerEmail = $bookingDetails['personal_info']['email'] ?? 'N/A'; 
            $customerAddress = $bookingDetails['trip_info']['pickup_address'] ?? 'N/A'; 
    
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'API-Token' => $this->config['car_api']['token']
            ])->post($this->config['car_api']['url'] . 'Book', [
                'EndUserIp' => '1.1.1.1', 
                'ClientId' => $this->config['car_api']['client_id'],
                'UserName' => $this->config['car_api']['username'],
                'Password' => $this->config['car_api']['password'],
                'SrdvIndex' => $srdvIndex, 
                'TraceID' => $traceId, 
                'RefID' => '77894', 
                'PickUpTime' => $bookingDetails['trip_info']['pickup_time'] ?? '18:00',
                'DropUpTime' => $bookingDetails['trip_info']['drop_time'] ?? '18:00',
                'CustomerName' => $customerName, 
                'CustomerPhone' => $customerPhone, 
                'CustomerEmail' => $customerEmail, 
                'CustomerAddress' => $customerAddress 
            ]);
    
            if ($response->successful()) {
                // Check if response is JSON
                $contentType = $response->header('Content-Type');
                if (strpos($contentType, 'application/json') === false) {
                    // Handle non-JSON response
                    Log::channel('payment')->error('Car Booking API returned non-JSON response', [
                        'content_type' => $contentType,
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                    
                    return [
                        'success' => false,
                        // 'error' => 'Car booking API returned invalid response format',
                        'raw_response' => substr($response->body(), 0, 255) // Log part of response for debugging
                    ];
                }
                
                $responseData = $response->json();
                return $this->processApiResponse($responseData, 'Car Booking');
            }
    
            return [
                'success' => false,
                'error' => 'Car booking API request failed with status: ' . $response->status(),
                'raw_response' => substr($response->body(), 0, 255) // Log part of response for debugging
            ];
    
        } catch (\Exception $e) {
            Log::channel('payment')->error('Car Booking API Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
    
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function processApiResponse($responseData, $apiName)
    {
        if (isset($responseData['Error']['ErrorCode']) && $responseData['Error']['ErrorCode'] !== '0') {
            return [
                'success' => false,
                'error' => $responseData['Error']['ErrorMessage'] ?? "Unknown {$apiName} error"
            ];
        }

        return [
            'success' => true,
            'result' => $responseData['Result'] ?? null
        ];
    }
}