public function bookLCC(Request $request)
{
    try {
        // Validate the request
        $validatedData = $request->validate([
            'srdvIndex' => 'required|string',
            'traceId' => 'required|string',
            'resultIndex' => 'required|string',

            // Validate each passenger in the array
            'passenger' => 'required|array|min:1',
            'passenger.*.title' => 'required|string',
            'passenger.*.firstName' => 'required|string',
            'passenger.*.lastName' => 'required|string',
            'passenger.*.gender' => 'required|integer', // Assuming 1 for male, 2 for female
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
            'passenger.*.baggage' => 'nullable|array',
            'passenger.*.mealDynamic' => 'nullable|array',
            'passenger.*.seat' => 'nullable|array',

            // Fare validation
            'fare.baseFare' => 'required|numeric',
            'fare.tax' => 'required|numeric',
            'fare.yqTax' => 'nullable|numeric',
            'fare.transactionFee' => 'nullable|numeric',
            'fare.additionalTxnFeeOfrd' => 'nullable|numeric',
            'fare.additionalTxnFeePub' => 'nullable|numeric',
            'fare.airTransFee' => 'nullable|numeric',
        ]);
        // Default empty arrays for optional fields if not provided
        $baggage = $validatedData['passenger']['baggage'] ?? [];
        $mealDynamic = $validatedData['passenger']['mealDynamic'] ?? [];
        $seat = $validatedData['passenger']['seat'] ?? [];

        // Prepare the payload for the API request
        $payload = [
            'EndUserIp' => '1.1.1.1', // Replace with actual user IP
            'ClientId' => '180133',
            'UserName' => 'MakeMy91',
            'Password' => 'MakeMy@910',
            'SrdvType' => 'MixAPI',
            'SrdvIndex' => $validatedData['srdvIndex'],
            'TraceId' => $validatedData['traceId'],
            'ResultIndex' => $validatedData['resultIndex'],

            // Map multiple passengers correctly
            'Passengers' => array_map(function ($pax) {
                return [
                    'Title' => $pax['title'],
                    'FirstName' => $pax['firstName'],
                    'LastName' => $pax['lastName'],
                    'PaxType' => $pax['paxType'],
                    'Gender' => $pax['gender'],
                    'ContactNo' => $pax['contactNo'],
                    'Email' => $pax['email'],
                    'DateOfBirth' => $pax['dateOfBirth'] ?? '',
                    'PassportNo' => $pax['passportNo'] ?? '',
                    'PassportExpiry' => $pax['passportExpiry'] ?? '',
                    'PassportIssueDate' => $pax['passportIssueDate'] ?? '',
                    'CountryCode' => $pax['countryCode'] ?? 'IN',
                    'CountryName' => $pax['countryName'] ?? 'INDIA',
                    'AddressLine1' => $pax['addressLine1'],
                    'City' => $pax['city'],

                    // Assign baggage per passenger (if applicable)
                    'Baggage' => $pax['baggage'] ?? [],

                    // Assign meals per passenger (if applicable)
                    'MealDynamic' => $pax['mealDynamic'] ?? [],

                    // Assign seats per passenger (if applicable)
                    'Seat' => $pax['seat'] ?? [],
                ];
            }, $validatedData['passenger']),

            // Fare details
            'Fare' => [
                'BaseFare' => $validatedData['fare']['baseFare'],
                'Tax' => $validatedData['fare']['tax'],
                'YQTax' => $validatedData['fare']['yqTax'] ?? 0,
                'TransactionFee' => $validatedData['fare']['transactionFee'] ?? 0,
                'AdditionalTxnFeeOfrd' => $validatedData['fare']['additionalTxnFeeOfrd'] ?? 0,
                'AdditionalTxnFeePub' => $validatedData['fare']['additionalTxnFeePub'] ?? 0,
                'AirTransFee' => $validatedData['fare']['airTransFee'] ?? 0,
            ],
        ];

        // Send payload to third-party API
        $response = Http::withHeaders([
            'API-Token' => 'MakeMy@910@23',
            'Content-Type' => 'application/json',
        ])->post('https://flight.srdvtest.com/v8/rest/TicketLCC', $payload);

        if ($response->successful()) {
            $apiResponse = $response->json();

            // Extract relevant data for client response
        }else {
            return response()->json([
                'success' => false,
                'message' => $apiResponse['Error']['ErrorMessage'] ?? 'Unknown API error',
                'errorCode' => $apiResponse['Error']['ErrorCode'] ?? null
            ], 400);
        }
    

        // Handle API error responses
        return response()->json([
            'error' => 'Failed to book flight',
            'details' => $response->json(),
        ], $response->status());

    } catch (\Exception $e) {
        // Handle unexpected errors
        return response()->json([
            'error' => 'System error',
            'message' => $e->getMessage()
        ], 500);
    
    }
}