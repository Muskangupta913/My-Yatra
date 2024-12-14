<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;

class BusApiService
{
    protected $baseUrl;
    protected $clientId;
    protected $username;
    protected $password;
    protected $apiToken;

    public function __construct()
    {
        // Updated the base URL to use v8
        $this->baseUrl = config('services.bus_api.url', 'https://bus.srdvtest.com/v5/rest/');
        $this->clientId = config('services.bus_api.client_id');
        $this->username = config('services.bus_api.username');
        $this->password = config('services.bus_api.password');
        $this->apiToken = config('services.bus_api.api_token');
    }

    /**
     * Fetch city list from third-party API with retry mechanism
     */
    public function fetchCityList()
    {
        $maxRetries = 3;
        $attempt = 1;

        while ($attempt <= $maxRetries) {
            try {
                // API request without 'Api-Token' if not required
                $response = Http::timeout(30)
                    ->retry(2, 100)
                    ->withHeaders([
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ])
                    ->post($this->baseUrl . 'GetBusCityList', [
                        'ClientId' => $this->clientId,
                        'UserName' => $this->username,
                        'Password' => $this->password
                    ]);

                // Log the request details for debugging
                Log::info('API Request Details', [
                    'url' => $this->baseUrl . 'GetBusCityList',
                    'headers' => [
                        'Api-Token' => substr($this->apiToken, 0, 5) . '***', // Log partial token for security
                    ],
                    'body' => [
                        'ClientId' => $this->clientId,
                        'UserName' => $this->username,
                        'Password' => '***' // Don't log the actual password
                    ]
                ]);

                // Log the response for debugging
                Log::info('API Response', [
                    'status' => $response->status(),
                    'body' => $response->json()
                ]);

                if ($response->failed()) {
                    Log::error('API Request failed', ['response' => $response->json(), 'status' => $response->status()]);
                    throw new RequestException($response);
                }

                $data = $response->json();

                // Check if error exists in the response and its error code
                if (isset($data['Error']['ErrorCode']) && $data['Error']['ErrorCode'] > 0) {
                    Log::error('City API Error', [
                        'error_code' => $data['Error']['ErrorCode'],
                        'error_message' => $data['Error']['ErrorMessage'] ?? 'Unknown error'
                    ]);
                    throw new \Exception("API Error: " . ($data['Error']['ErrorMessage'] ?? 'Unknown error'));
                }

                return $data['Result']['CityList'] ?? [];

            } catch (\Exception $e) {
                Log::error('City Fetch Attempt ' . $attempt, [
                    'message' => $e->getMessage(),
                    'attempt' => $attempt
                ]);

                if ($attempt == $maxRetries) {
                    throw $e;
                }

                $attempt++;
                sleep(1); // Wait 1 second before retrying
            }
        }

        return [];
    }
}
