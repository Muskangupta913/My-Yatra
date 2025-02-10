<<<<<<< HEAD
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
=======
// Update the applyFilters function to handle both journey types
function applyFilters() {
    const journeyType = sessionStorage.getItem('journeyType') || "1";
    const selectedFilters = {
        airlines: getSelectedValues('airlines'),
        stops: getSelectedValues('stops'),
        departureTime: getSelectedValues('departure-time'),
        cabinClass: getSelectedValues('cabin-class'),
        baggage: getSelectedValues('baggage'),
        flightDuration: getSelectedValues('flight-duration'),
        minPrice: parseFloat(document.getElementById('min-price').value) || 0,
        maxPrice: parseFloat(document.getElementById('max-price').value) || Infinity
    };

    if (journeyType === "1") {
        // Single journey filtering (existing logic)
        const filteredResults = results.map(resultGroup => 
            resultGroup.filter(result => filterFlight(result, selectedFilters))
        );
        renderFilteredResults(filteredResults, journeyType);
    } else if (journeyType === "2") {
        // Round trip filtering
        const outboundFlights = JSON.parse(sessionStorage.getItem('outboundFlights')) || [];
        const returnFlights = JSON.parse(sessionStorage.getItem('returnFlights')) || [];

        // Filter outbound flights
        const filteredOutbound = outboundFlights.filter(flight => filterFlight(flight, selectedFilters));
        
        // Filter return flights
        const filteredReturn = returnFlights.filter(flight => filterFlight(flight, selectedFilters));

        // Store filtered results in session storage
        sessionStorage.setItem('filteredOutboundFlights', JSON.stringify(filteredOutbound));
        sessionStorage.setItem('filteredReturnFlights', JSON.stringify(filteredReturn));

        // Render the filtered results
        renderFilteredResults([filteredOutbound, filteredReturn], journeyType);
    }
}

// Separate the flight filtering logic into its own function
function filterFlight(flight, filters) {
    return flight.FareDataMultiple.some(fareData => {
        const segment = flight.Segments[0][0];
        const fareSegment = fareData.FareSegments[0];
        const departureTime = new Date(segment.DepTime);
        const duration = segment.Duration;

        // Airline filter
        const airlineMatch = filters.airlines.length === 0 || 
            filters.airlines.includes(fareSegment.AirlineName);

        // Price filter
        const priceMatch = fareData.Fare.OfferedFare >= filters.minPrice && 
            fareData.Fare.OfferedFare <= filters.maxPrice;

        // Stops filter
        const stopMatch = filters.stops.length === 0 || 
            filters.stops.some(stop => 
                (stop === 'Non-stop' && flight.Segments[0].length === 1) ||
                (stop !== 'Non-stop' && flight.Segments[0].length > 1)
            );

        // Departure time filter
        const departureTimeMatch = filters.departureTime.length === 0 || 
            (departureTime.getHours() < 12 && filters.departureTime.includes('Morning (Before 12 PM)')) ||
            (departureTime.getHours() >= 12 && filters.departureTime.includes('Evening (After 12 PM)'));

        // Cabin class filter
        const cabinClassMatch = filters.cabinClass.length === 0 || 
            filters.cabinClass.includes(fareSegment.CabinClassName);

        // Baggage filter
        const baggageMatch = filters.baggage.length === 0 || 
            filters.baggage.includes(fareSegment.Baggage);

        // Duration filter
        const durationMatch = filters.flightDuration.length === 0 || 
            filters.flightDuration.includes(
                duration <= 60 ? 'Short (≤ 1 hour)' :
                duration <= 120 ? 'Medium (1-2 hours)' :
                'Long (> 2 hours)'
            );

        return airlineMatch && priceMatch && stopMatch && 
               departureTimeMatch && cabinClassMatch && 
               baggageMatch && durationMatch;
    });
}

// Update the extractAdvancedFilters function to handle both journey types
function extractAdvancedFilters(results) {
    const journeyType = sessionStorage.getItem('journeyType') || "1";
    let flightsToFilter = [];

    if (journeyType === "1") {
        flightsToFilter = results.flat();
    } else if (journeyType === "2") {
        const outboundFlights = JSON.parse(sessionStorage.getItem('outboundFlights')) || [];
        const returnFlights = JSON.parse(sessionStorage.getItem('returnFlights')) || [];
        flightsToFilter = [...outboundFlights, ...returnFlights];
    }

    const filters = {
        airlines: new Set(),
        stops: new Set(),
        priceRange: { min: Infinity, max: -Infinity },
        departureTime: { early: [], late: [] },
        cabinClasses: new Set(),
        baggageOptions: new Set(),
        flightDurations: []
    };

    flightsToFilter.forEach(flight => {
        if (flight.FareDataMultiple) {
            flight.FareDataMultiple.forEach(fareData => {
                const segment = flight.Segments[0][0];
                const fareSegment = fareData.FareSegments[0];

                // Extract all filter options (existing logic)
                filters.airlines.add(fareSegment.AirlineName || 'Unknown');
                filters.stops.add(flight.Segments[0].length === 1 ? 'Non-stop' : `${flight.Segments[0].length - 1} Stop`);
                filters.priceRange.min = Math.min(filters.priceRange.min, fareData.Fare.OfferedFare);
                filters.priceRange.max = Math.max(filters.priceRange.max, fareData.Fare.OfferedFare);
                
                const departureTime = new Date(segment.DepTime);
                const hours = departureTime.getHours();
                if (hours < 12) filters.departureTime.early.push('Morning (Before 12 PM)');
                else filters.departureTime.late.push('Evening (After 12 PM)');

                filters.cabinClasses.add(fareSegment.CabinClassName || 'Unknown');
                filters.baggageOptions.add(fareSegment.Baggage || 'Unknown');

                const duration = segment.Duration;
                if (duration) {
                    filters.flightDurations.push(
                        duration <= 60 ? 'Short (≤ 1 hour)' :
                        duration <= 120 ? 'Medium (1-2 hours)' :
                        'Long (> 2 hours)'
                    );
                }
            });
        }
    });

    // Clean up filter sets
    filters.departureTime.early = [...new Set(filters.departureTime.early)].filter(Boolean);
    filters.departureTime.late = [...new Set(filters.departureTime.late)].filter(Boolean);
    filters.flightDurations = [...new Set(filters.flightDurations)];

    return filters;
>>>>>>> 1d47f4474ecf268a4552d1625173d9d5aaee2e7a
}