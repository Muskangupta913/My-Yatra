<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FlightApiService
{
    protected $baseUrl;
    protected $clientId;
    protected $userName;
    protected $password;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = env('FLIGHT_API_URL');
        $this->clientId = env('FLIGHT_API_CLIENT_ID');
        $this->userName = env('FLIGHT_API_USER_NAME');
        $this->password = env('FLIGHT_API_PASSWORD');
        $this->token = env('FLIGHT_API_TOKEN');
    }

    public function searchFlights($data)
    {
        // Extract city codes from the city names (fromCity and toCity should have the city code)
        $flightFromCity = $data['flightFromCity']; // For example: Lucknow (Amausi Arpt) (LKO)
        $flightToCity = $data['flightToCity']; // For example: Kuwait (Kuwait Intl) (KWI)
        $flightDepartureDate = $data['flightDepartureDate']; // For example: 14-01-2025
        $flightReturnDate = $data['flightReturnDate']; // For example: 14-01-2025
        $passengers = $data['passengers']; // Number of passengers

        // Extract the city codes from the city names (LKO, KWI)
        $fromCityCode = $this->getCityCodeFromName($flightFromCity); // Function to extract city code
        $toCityCode = $this->getCityCodeFromName($flightToCity); // Function to extract city code

        // Prepare the payload data
        $payload = [
            'EndUserIp' => request()->ip(),
            'ClientId' => $this->clientId,
            'UserName' => $this->userName,
            'Password' => $this->password,
            'AdultCount' => $passengers,
            'ChildCount' => 0,
            'InfantCount' => 0,
            'JourneyType' => 1,
            'FareType' => 1,
            'Segments' => [
                [
                    'Origin' => $fromCityCode,
                    'Destination' => $toCityCode,
                    'FlightCabinClass' => '1',
                    'PreferredDepartureTime' => $this->formatDateForApi($flightDepartureDate),
                    'PreferredArrivalTime' => $this->formatDateForApi($flightReturnDate),
                ],
            ],
        ];

        // Log the payload for debugging
        Log::info('Flight API Request Payload:', ['payload' => $payload]);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => $this->token,
            ])->post("{$this->baseUrl}/Search", $payload);

            // Log the response for debugging
            Log::info('Flight API Response:', ['response' => $response->json()]);

            if (! $response->successful()) {
                throw new RequestException($response);
            }

            $data = $response->json();

            if (isset($data['Error']) && $data['Error']['ErrorCode'] !== 0) {
                throw new \Exception($data['Error']['ErrorMessage'] ?? 'Unknown API error');
            }

            if (isset($data['Result']['FlightData'])) {
                return [
                    'status' => true,
                    'data' => $data['Result']['FlightData'],
                ];
            }

            return [
                'status' => false,
                'message' => 'No flight data available',
            ];
        } catch (\Exception $e) {
            Log::error('Flight Search Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'status' => false,
                'message' => 'An error occurred while searching for flights. Please try again later.',
            ];
        }
    }

    private function getCityCodeFromName($city)
    {
        // Example pattern: "Lucknow (Amausi Arpt) (LKO)"
        preg_match('/\((.*?)\)$/', $city, $matches);

        return $matches[1] ?? ''; // Returns "LKO" if the pattern matches
    }

    private function formatDateForApi($date)
    {
        // Assuming the date format provided is "dd-mm-yyyy", convert it to "yyyy-mm-dd" format
        $dateObj = \DateTime::createFromFormat('d-m-Y', $date);

        return $dateObj ? $dateObj->format('Y-m-d').'T00:00:00' : '';
    }

    public function getCalendarFare($data)
    {
        $fromCityCode = $this->getCityCodeFromName($data['flightFromCity']);
        $toCityCode = $this->getCityCodeFromName($data['flightToCity']);
        $departureDate = $this->formatDateForApi($data['flightDepartureDate']);

        $payload = [
            'EndUserIp' => request()->ip(),
            'ClientId' => $this->clientId,
            'UserName' => $this->userName,
            'Password' => $this->password,
            'JourneyType' => 1,
            'Sources' => null,
            'FareType' => 2,
            'Segments' => [
                [
                    'Origin' => $fromCityCode,
                    'Destination' => $toCityCode,
                    'FlightCabinClass' => '1',
                    'PreferredDepartureTime' => $departureDate,
                    'PreferredArrivalTime' => $departureDate,
                ],
            ],
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Api-Token' => $this->token,
            ])->post("{$this->baseUrl}/GetCalendarFare", $payload);

            Log::info('Calendar Fare API Response:', ['response' => $response->json()]);

            if ($response->successful() && isset($response['FareData'])) {
                return [
                    'status' => true,
                    'data' => $response['FareData'],
                ];
            }

            return [
                'status' => false,
                'message' => $response['Error']['ErrorMessage'] ?? 'Failed to fetch calendar fare.',
            ];
        } catch (\Exception $e) {
            Log::error('Calendar Fare API Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'status' => false,
                'message' => 'An error occurred while fetching calendar fare. Please try again.',
            ];
        }
    }
}
