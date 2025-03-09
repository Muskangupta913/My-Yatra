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







class FlightController extends Controller
{
    protected $flightApiService;

    public function __construct(FlightApiService $flightApiService)
    {
        $this->flightApiService = $flightApiService;
    }

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
        
        return view('frontend.roundFlight_success', compact('payment'));
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
