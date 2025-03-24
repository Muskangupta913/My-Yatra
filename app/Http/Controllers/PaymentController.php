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
            Log::channel('payment')->error('Payment Creation Error', ['error' => $e->getMessage()]);
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
                'trace_id' => 'required|string',
                'srdv_index' => 'required|string'
            ]);

            if ($validator->fails()) {
                return redirect('/failed')->with('error', 'Invalid payment details');
            }

            $attributes = $request->only(['razorpay_order_id', 'razorpay_payment_id', 'razorpay_signature']);
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

            // Store all needed information in session
            $bookingDetails = json_decode($request->input('bookingDetails'), true);
            
            session([
                'trace_id' => $request->input('trace_id'), 
                'srdv_index' => $request->input('srdv_index'),
                'payment_id' => $paymentRecord->id,
                'bookingDetails' => $bookingDetails
            ]);

            return redirect()->route('payment.success')
                ->with('success', 'Payment processed successfully!')
                ->with('payment_id', $paymentRecord->id)
                ->with('bookingDetails', $bookingDetails);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('payment')->error('Payment Verification Error', ['error' => $e->getMessage()]);
            return redirect()->route('payment.failed')->with('error', 'Payment verification failed');
        }
    }

    public function handlePaymentSuccess(Request $request)
    {
        $bookingDetails = session('bookingDetails');
        if (!$bookingDetails) {
            return view('frontend.success')->with('error', 'Booking details not found');
        }
        
        // Get the required data
        $traceId = session('trace_id');
        $srdvIndex = session('srdv_index');
        $baseFare = $bookingDetails['car_info']['base_fare'] ?? 0;
        
        // Log the initial parameters
        Log::channel('payment')->info('Starting automatic API sequence', [
            'trace_id' => $traceId,
            'srdv_index' => $srdvIndex,
            'base_fare' => $baseFare
        ]);
        
        $balanceLogResponse = null;
        $bookingResponse = null;
        
        try {
            // Step 1: Call the BalanceLog API to debit the wallet
            $balanceLogResponse = $this->callBalanceLogApi($traceId, $baseFare);
            session(['balance_log_response' => $balanceLogResponse]);
            
            // Step 2: If BalanceLog was successful, call the Book API
            if ($balanceLogResponse['success'] && isset($balanceLogResponse['result']['RefID'])) {
                $refId = $balanceLogResponse['result']['RefID'];
                
                // Step 3: Call the Book API with the RefID
                $bookingResponse = $this->callCarBookingApi($bookingDetails, $refId);
                session(['booking_response' => $bookingResponse]);
                
                // Step 4: Store the booking details in the database
                if ($bookingResponse['success'] && isset($bookingResponse['result'])) {
                    $this->saveCarBooking($bookingResponse['result'], $bookingDetails, $refId);
                    
                    Log::channel('payment')->info('Booking process completed successfully', [
                        'trace_id' => $traceId,
                        'ref_id' => $refId,
                        'booking_id' => $bookingResponse['result']['BookingID'] ?? 'N/A'
                    ]);
                } else {
                    Log::channel('payment')->error('Book API failed', [
                        'error' => $bookingResponse['error'] ?? 'Unknown error',
                        'trace_id' => $traceId
                    ]);
                }
            } else {
                Log::channel('payment')->error('BalanceLog API failed', [
                    'error' => $balanceLogResponse['error'] ?? 'Unknown error',
                    'trace_id' => $traceId
                ]);
            }
        } catch (\Exception $e) {
            Log::channel('payment')->error('Exception during API sequence', [
                'error' => $e->getMessage(),
                'trace_id' => $traceId
            ]);
        }
        
        return view('frontend.success')
            ->with('success', 'Payment processed successfully!')
            ->with('bookingDetails', $bookingDetails)
            ->with('balance_log_response', $balanceLogResponse)
            ->with('booking_response', $bookingResponse);
    }

    public function processBookingApis(Request $request)
    {
        $type = $request->input('type');
        $traceId = $request->input('trace_id', session('trace_id'));
        $baseFare = $request->input('base_fare', 0);
        $refId = $request->input('ref_id');
        $bookingDetails = session('bookingDetails');
        
        try {
            if ($type === 'balance-log') {
                // Call BalanceLog API
                $response = $this->callBalanceLogApi($traceId, $baseFare);
                session(['balance_log_response' => $response]);
                return response()->json($response);
                
            } elseif ($type === 'car-booking') {
                if (!$bookingDetails) {
                    return response()->json(['success' => false, 'error' => 'Booking details not found'], 400);
                }
                
                // Call the Car Booking API with RefID
                $response = $this->callCarBookingApi($bookingDetails, $refId);
                
                // Save booking in database if successful
                if ($response['success'] && isset($response['result'])) {
                    $this->saveCarBooking($response['result'], $bookingDetails, $refId);
                }
                
                session(['booking_response' => $response]);
                return response()->json($response);
            }

            return response()->json(['success' => false, 'error' => 'Invalid API type requested'], 400);
        } catch (\Exception $e) {
            Log::channel('payment')->error('API Processing Error', [
                'type' => $type, 
                'error' => $e->getMessage(),
                'trace_id' => $traceId
            ]);
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }

    private function saveCarBooking($apiResult, $bookingDetails, $refId = null)
    {
        try {
            // Use refId from parameter if available, otherwise use from apiResult
            $refId = $refId ?: ($apiResult['RefID'] ?? null);
            
            DB::beginTransaction();
            CarBookings::create([
                'payment_id' => session('payment_id'),
                'srdv_type' => $apiResult['SrdvType'] ?? null,
                'srdv_index' => $apiResult['SrdvIndex'] ?? session('srdv_index'),
                'booking_id' => $apiResult['BookingID'] ?? null,
                'ref_id' => $refId,
                'operator_id' => $apiResult['OperatorID'] ?? null,
                'segment_id' => $apiResult['SegmentID'] ?? null,
                'booking_status' => $apiResult['Status'] ?? null,
                'trace_id' => $apiResult['TraceID'] ?? session('trace_id'),
                'customer_name' => $bookingDetails['personal_info']['name'] ?? null,
                'customer_phone' => $bookingDetails['personal_info']['phone'] ?? null,
                'customer_email' => $bookingDetails['personal_info']['email'] ?? null,
                'customer_address' => $bookingDetails['personal_info']['address'] ?? 
                                    ($bookingDetails['trip_info']['pickup_address'] ?? null),
                'pickup_location' => $bookingDetails['trip_info']['pickup_address'] ?? null,
                'dropoff_location' => $bookingDetails['trip_info']['drop_address'] ?? null,
                'pickup_time' => $bookingDetails['trip_info']['pickup_time'] ?? null,
                'dropoff_time' => $bookingDetails['trip_info']['drop_time'] ?? null,
                'booking_date' => $bookingDetails['trip_info']['booking_date'] ?? now()->format('Y-m-d'),
                'car_category' => $bookingDetails['car_info']['category'] ?? null,
                'seating_capacity' => $bookingDetails['car_info']['seating'] ?? null,
                'luggage_capacity' => $bookingDetails['car_info']['luggage'] ?? null,
                'total_price' => $bookingDetails['car_info']['price'] ?? null,
                'base_fare' => $bookingDetails['car_info']['base_fare'] ?? null
            ]);
            DB::commit();
            
            Log::channel('payment')->info('Car Booking saved successfully', [
                'booking_id' => $apiResult['BookingID'] ?? null,
                'ref_id' => $refId,
                'trace_id' => $apiResult['TraceID'] ?? session('trace_id')
            ]);
            
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('payment')->error('Save Car Booking Error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function callBalanceLogApi($traceId = null, $baseFare = 0)
    {
        try {
            Log::channel('payment')->info('Calling Balance Log API', [
                'trace_id' => $traceId,
                'base_fare' => $baseFare
            ]);
            
            // Ensure baseFare is a proper numeric value
            $baseFare = floatval($baseFare);
            
            $payload = [
                'EndUserIp' => '1.1.1.1',
                'ClientId' => $this->config['car_api']['client_id'],
                'UserName' => $this->config['car_api']['username'],
                'Password' => $this->config['car_api']['password'],
                'TraceID' => $traceId,
                'BaseFare' => $baseFare
            ];
            
            // Log the actual payload being sent
            Log::channel('payment')->debug('Balance Log API Request Payload', [
                'payload' => $payload
            ]);

            $response = Http::withHeaders([
                'API-Token' => $this->config['car_api']['token'],
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post($this->config['car_api']['url'] . 'BalanceLog', $payload);

            // Log full request and response for debugging
            Log::channel('payment')->debug('Balance Log API Request/Response', [
                'request' => $payload,
                'response_status' => $response->status(),
                'response_body' => $response->body()
            ]);
            
            // Make sure we have a meaningful response
            if ($response->successful()) {
                $responseData = json_decode($response->body(), true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Invalid JSON response: ' . json_last_error_msg());
                }
                $result = $this->processApiResponse($responseData, 'Balance Log');
                
                Log::channel('payment')->info('Balance Log API Response', [
                    'success' => $result['success'],
                    'trace_id' => $traceId,
                    'response' => $result
                ]);
                
                return $result;
            }

            Log::channel('payment')->error('Balance Log API Failed', [
                'status' => $response->status(),
                'trace_id' => $traceId,
                'base_fare' => $baseFare,
                'response' => $response->body()
            ]);
            
            return [
                'success' => false, 
                'error' => 'Balance log API request failed: ' . $response->status()
            ];
        } catch (\Exception $e) {
            Log::channel('payment')->error('Balance Log API Exception', [
                'error' => $e->getMessage(),
                'trace_id' => $traceId ?? 'N/A',
                'base_fare' => $baseFare ?? 0
            ]);
            return [
                'success' => false,
                'error' => 'An error occurred while calling the Balance Log API: ' . $e->getMessage()
            ];
        }
    }
    
    private function callCarBookingApi($bookingDetails, $refId = null)
    {
        try {
            // Use the RefID from the BalanceLog API response if provided
            $refId = $refId ?: '77894'; // Default value if not provided
            
            Log::channel('payment')->info('Calling Car Booking API', [
                'trace_id' => session('trace_id'),
                'srdv_index' => session('srdv_index'),
                'ref_id' => $refId
            ]);
            
            $payload = [
                'EndUserIp' => '1.1.1.1',
                'ClientId' => $this->config['car_api']['client_id'],
                'UserName' => $this->config['car_api']['username'],
                'Password' => $this->config['car_api']['password'],
                'SrdvIndex' => session('srdv_index'),
                'TraceID' => session('trace_id'),
                'RefID' => $refId,
                'PickUpTime' => $bookingDetails['trip_info']['pickup_time'] ?? '18:00',
                'DropUpTime' => $bookingDetails['trip_info']['drop_time'] ?? '18:00',
                'CustomerName' => $bookingDetails['personal_info']['name'] ?? 'N/A',
                'CustomerPhone' => $bookingDetails['personal_info']['phone'] ?? 'N/A',
                'CustomerEmail' => $bookingDetails['personal_info']['email'] ?? 'N/A',
                'CustomerAddress' => $bookingDetails['trip_info']['pickup_address'] ?? 'N/A',
                'BaseFare' => $bookingDetails['car_info']['base_fare'] ?? 0
            ];
            
            // Log the actual payload being sent
            Log::channel('payment')->debug('Car Booking API Request Payload', [
                'payload' => $payload
            ]);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'API-Token' => $this->config['car_api']['token']
            ])->post($this->config['car_api']['url'] . 'Book', $payload);
            
            // Log full request and response for debugging
            Log::channel('payment')->debug('Car Booking API Request/Response', [
                'request' => $payload,
                'response_status' => $response->status(),
                'response_body' => $response->body()
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                $result = $this->processApiResponse($responseData, 'Car Booking');
                
                Log::channel('payment')->info('Car Booking API Response', [
                    'success' => $result['success'],
                    'trace_id' => $payload['TraceID'],
                    'ref_id' => $refId,
                    'response' => $result
                ]);
                
                return $result;
            }

            Log::channel('payment')->error('Car Booking API Failed', [
                'status' => $response->status(),
                'trace_id' => $payload['TraceID'],
                'ref_id' => $refId,
                'response' => $response->body()
            ]);
            
            return [
                'success' => false, 
                'error' => 'Car booking API request failed: ' . $response->status()
            ];
        } catch (\Exception $e) {
            Log::channel('payment')->error('Car Booking API Exception', [
                'error' => $e->getMessage(),
                'ref_id' => $refId
            ]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function processApiResponse($responseData, $apiName)
    {
        if (isset($responseData['Error']['ErrorCode']) && $responseData['Error']['ErrorCode'] !== '0') {
            return ['success' => false, 'error' => $responseData['Error']['ErrorMessage'] ?? "Unknown {$apiName} error"];
        }

        return ['success' => true, 'result' => $responseData['Result'] ?? null];
    }
}