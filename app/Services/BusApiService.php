<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BusApiService
{
    protected $url;
    protected $clientId;
    protected $username;
    protected $password;

    public function __construct()
    {
        $this->url = config('services.bus_api.url');
        $this->clientId = config('services.bus_api.client_id');
        $this->username = config('services.bus_api.username');
        $this->password = config('services.bus_api.password');
    }
    //ftech cities
    public function fetchCityList()
{
    $response = $this->postRequest('/GetBusCityList', []);
    return response()->json($response);
}

//search api

public function searchBuses($sourceCity, $sourceCode, $destinationCity, $destinationCode, $departDate)
    {
        $searchParams = [
            'ClientId' => $this->clientId,
            'User Name' => $this->username,
            'Password' => $this->password,
            'source_city' => $sourceCity,
            'source_code' => $sourceCode,
            'destination_city' => $destinationCity,
            'destination_code' => $destinationCode,
            'depart_date' => $departDate,
        ];

        $response = $this->postRequest('/Search', $searchParams);
        return $response; // Return the raw response for further processing in the controller
    }

    /**
     * Make a POST request to the Bus API.
     *
     * @param string $endpoint
     * @param array $data
     * @return mixed
     */
    public function postRequest($endpoint, $data = [])
    {
        try {
            $response = Http::post($this->url . $endpoint, array_merge($data, [
                'ClientId' => $this->clientId,
                'UserName' => $this->username,
                'Password' => $this->password,
            ]));

            $result = $response->json();
            
            if (!$response->successful()) {
                Log::error("Bus API Error", [
                    'endpoint' => $endpoint,
                    'response' => $result,
                ]);
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('API Request Failed', [
                'endpoint' => $endpoint,
                'message' => $e->getMessage(),
            ]);
            return ['ResponseStatus' => 2, 'ErrorMessage' => 'API Request Failed'];
        }
    }
}
