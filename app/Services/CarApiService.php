<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use App\Models\CarCity;
use Illuminate\Support\Facades\Log;

class CarApiService
{
    protected $baseUrl;
    protected $apiToken;
    protected $clientId;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->baseUrl = config('services.car_api.base_url', 'https://car.srdvtest.com/v5/rest/');
        $this->apiToken = config('services.car_api.token', 'MakeMy@910@23');
        $this->clientId = config('services.car_api.client_id','180133');
        $this->username = config('services.car_api.username','MakeMy91');
        $this->password = config('services.car_api.password','MakeMy@910');
    }

    public function searchCars(array $params)
    {
        try {
            $payload = [
                "EndUserIp" => request()->ip(),
                "ClientId" => $this->clientId,
                "UserName" => $this->username,
                "Password" => $this->password,
                "FormCity" => $params['from_city'],
                "ToCity" => $params['to_city'],
                "PickUpDate" => $params['pickup_date'],
                "DropDate" => $params['drop_date'] ?? '',
                "Hours" => $params['hours'] ?? '8',
                "TripType" => $params['trip_type'] ?? '0',
            ];

            Log::info('Car Search Request:', ['payload' => $payload]);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => $this->apiToken,
            ])->post("{$this->baseUrl}/Search", $payload);

            Log::info('Car Search Response:', ['response' => $response->json()]);

            if (!$response->successful()) {
                throw new RequestException($response);
            }

            $data = $response->json();

            if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
                throw new \Exception($data['Error']['ErrorMessage'] ?? 'Unknown API error');
            }
            $totalAmount = $data['Result']['TaxiData'][0]['TotalAmount'] ?? null;

            return [
                'status' => true,
                'trace_id' => $data['Result']['TraceId'] ?? null,
                'total_amount' => $totalAmount, 
                'data' => $data['Result']['TaxiData'] ?? [],
            ];

        } catch (\Exception $e) {
            Log::error('Car Search Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    // Get city code based on the city name
    private function getCityCode($cityName)
    {
        $city = CarCity::where('caoncitlst_city_name', $cityName)->first();
        return $city ? $city->caoncitlst_id : null;
    }

    /**
     * Fetch wallet balance from the 3rd party API.
     *
     * @return array
     */
    public function getWalletBalance()
    {
        try {
            $payload = [
                "EndUserIp" => request()->ip() ?? '1.1.1.1',
                "ClientId" => $this->clientId,
                "UserName" => $this->username,
                "Password" => $this->password,
            ];

            Log::info('Wallet Balance Request:', ['payload' => $payload]);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => $this->apiToken,
            ])->post("{$this->baseUrl}/Balance", $payload);

            $data = $response->json();

            Log::info('Wallet Balance Response:', ['response' => $data]);

            if (!$response->successful() || ($data['Error']['ErrorCode'] ?? '1') !== '0') {
                throw new \Exception($data['Error']['ErrorMessage'] ?? 'Failed to fetch wallet balance');
            }

            return [
                'status' => true,
                'balance' => $data['Balance'] ?? null,
                'credit_limit' => $data['CreditLimit'] ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('Wallet Balance Fetch Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'status' => false,
                'message' => 'Failed to fetch wallet balance. Please try again later.',
            ];
        }
    } 
    

public function processPaymentAndBook($bookingData)
{
    try {
        // Step 1: Debit Wallet
        $walletResponse = $this->debitWallet($bookingData['amount']);

        if ($walletResponse['status'] === true) {
            // Step 2: Book Car
            $bookingResponse = $this->bookCar($bookingData);

            if ($bookingResponse['status'] === true) {
                return [
                    'status' => true,
                    'message' => 'Wallet debited and car booked successfully.'
                ];
            } else {
                \Log::error('Car Booking Failed', ['response' => $bookingResponse]);
                return [
                    'status' => false,
                    'message' => $bookingResponse['message'] ?? 'Car booking failed unexpectedly.'
                ];
            }
        } else {
            \Log::error('Wallet Debit Failed', ['response' => $walletResponse]);
            return [
                'status' => false,
                'message' => $walletResponse['message'] ?? 'Wallet debit failed unexpectedly.'
            ];
        }
    } catch (\Exception $e) {
        \Log::error('Payment and Booking Exception', ['message' => $e->getMessage()]);
        return [
            'status' => false,
            'message' => 'An unexpected error occurred during payment processing.'
        ];
    }
}

public function bookCar($bookingData)
{
    try {
        // Step 1: Book the car
        $response = Http::withHeaders([
            'API-Token' => env('CAR_API_TOKEN', 'MakeMy@910@23'),
            'Accept' => 'application/json'
        ])->post(env('CAR_API_BASE_URL', 'https://car.srdvtest.com/v5/rest/') . '/Book', [
            'EndUserIp' => $bookingData['EndUserIp'],
            'ClientId' => env('CAR_API_CLIENT_ID', '180133'),
            'UserName' => env('CAR_API_USERNAME', 'MakeMy91'),
            'Password' => env('CAR_API_PASSWORD', 'MakeMy@910'),
            'SrdvIndex' => $bookingData['SrdvIndex'],
            'TraceID' => $bookingData['TraceID'],
            'PickUpTime' => $bookingData['PickUpTime'],
            'DropUpTime' => $bookingData['DropUpTime'],
            'RefID' => $bookingData['RefID'],
            'CustomerName' => $bookingData['CustomerName'],
            'CustomerPhone' => $bookingData['CustomerPhone'],
            'CustomerEmail' => $bookingData['CustomerEmail'],
            'CustomerAddress' => $bookingData['CustomerAddress']
        ]);

        $data = $response->json();

        if (!$response->successful() || ($data['Error']['ErrorCode'] ?? '1') !== '0') {
            \Log::error('Car Booking Failed', ['response' => $data]);
            return [
                'status' => false,
                'message' => $data['Error']['ErrorMessage'] ?? 'Car booking failed'
            ];
        }

        // Step 2: Debit the wallet
        $debitResponse = $this->debitWallet($bookingData['Amount'], $bookingData); // Pass the amount to debit

        if (!$debitResponse['status']) {
            return [
                'status' => false,
                'message' => $debitResponse['message'] ?? 'Wallet debit failed after booking'
            ];
        }

        // Step 3: Return success message with booking ID and other details
        return [
            'status' => true,
            'message' => 'Car booked and wallet debited successfully',
            'booking_id' => $data['Result']['BookingID'],
            'status' => $data['Result']['Status']
        ];
    } catch (\Exception $e) {
        \Log::error('Car Booking and Wallet Debit API Error', ['message' => $e->getMessage()]);
        return [
            'status' => false,
            'message' => 'An error occurred while booking the car and debiting the wallet.'
        ];
    }
}

}
