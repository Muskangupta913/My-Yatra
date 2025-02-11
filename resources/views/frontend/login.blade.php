<<<<<<< HEAD
// STEP 1: At the top of your script, right after the DOMContentLoaded event listener starts,
// add these state variables:
=======
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
>>>>>>> b23c208d0accd97c9550cae8b5093bad4e5e7476

document.addEventListener('DOMContentLoaded', function () {
    // Add these lines right here
    let selectedOutboundIndex = null;
    let selectedReturnIndex = null;

    const outboundFlights = JSON.parse(sessionStorage.getItem('outboundFlights')) || [];
    // ... rest of your existing variables


// STEP 2: In your renderFilteredResults function, find the section where you create the radio 
// container for outbound flights. Replace this section:

                const radioContainer = document.createElement('div');
                radioContainer.classList.add(
                    'absolute', 'top-4', 'right-4',
                    'w-6', 'h-6'
                );
                radioContainer.innerHTML = `
                    <input type="radio" 
                           name="outbound-flight" 
                           class="w-6 h-6 cursor-pointer "
                           value="${outboundFareData.ResultIndex}">
                `;

// With this updated version:

                const radioContainer = document.createElement('div');
                radioContainer.classList.add(
                    'absolute', 'top-4', 'right-4',
                    'w-6', 'h-6'
                );
                const isSelected = outboundFareData.ResultIndex === selectedOutboundIndex;
                radioContainer.innerHTML = `
                    <input type="radio" 
                           name="outbound-flight" 
                           class="w-6 h-6 cursor-pointer"
                           value="${outboundFareData.ResultIndex}"
                           ${isSelected ? 'checked' : ''}>
                `;

// STEP 3: Find the event listener for outbound flight selection and replace it with:

                flightCard.querySelector('input[type="radio"]').addEventListener('change', (e) => {
                    if (e.target.checked) {
                        selectedOutboundIndex = outboundFareData.ResultIndex;
                        selectedOutbound = {
                            resultIndex: outboundFareData.ResultIndex,
                            airline: outboundFareData.FareSegments[0]?.AirlineName,
                            flightNumber: outboundFareData.FareSegments[0]?.FlightNumber,
                            price: outboundFareData.Fare?.OfferedFare
                        };
                        updateSelectionDiv();
                    }
                });

// STEP 4: Similarly for return flights, replace the radio container creation with:

                const radioContainer = document.createElement('div');
                radioContainer.classList.add(
                    'absolute', 'top-4', 'right-4',
                    'w-6', 'h-6'
                );
                const isSelected = returnFareData.ResultIndex === selectedReturnIndex;
                radioContainer.innerHTML = `
                    <input type="radio" 
                           name="return-flight" 
                           class="w-6 h-6 cursor-pointer"
                           value="${returnFareData.ResultIndex}"
                           ${isSelected ? 'checked' : ''}>
                `;

// STEP 5: Update the return flight event listener:

                flightCard.querySelector('input[type="radio"]').addEventListener('change', (e) => {
                    if (e.target.checked) {
                        selectedReturnIndex = returnFareData.ResultIndex;
                        selectedReturn = {
                            resultIndex: returnFareData.ResultIndex,
                            airline: returnFareData.FareSegments[0]?.AirlineName,
                            flightNumber: returnFareData.FareSegments[0]?.FlightNumber,
                            price: returnFareData.Fare?.OfferedFare
                        };
                        updateSelectionDiv();
                    }
                });

// STEP 6: In your applyFilters function, update the round-trip handling section:

    if (journeyType === "2") {
        // Get the original flights from sessionStorage
        const originalOutboundFlights = JSON.parse(sessionStorage.getItem('outboundFlights')) || [];
        const originalReturnFlights = JSON.parse(sessionStorage.getItem('returnFlights')) || [];

        // Apply filters to both outbound and return flights
        const filteredOutbound = originalOutboundFlights.filter(filterFlight);
        const filteredReturn = originalReturnFlights.filter(filterFlight);

        // Check if selected flights still exist in filtered results
        const outboundExists = filteredOutbound.some(flight => 
            flight.FareDataMultiple?.some(fare => fare.ResultIndex === selectedOutboundIndex)
        );
        const returnExists = filteredReturn.some(flight => 
            flight.FareDataMultiple?.some(fare => fare.ResultIndex === selectedReturnIndex)
        );
        
        // Clear selections if flights no longer exist in filtered results
        if (!outboundExists) selectedOutboundIndex = null;
        if (!returnExists) selectedReturnIndex = null;

        // Clear the existing results container
        const resultsContainer = document.getElementById('results-container');
        resultsContainer.innerHTML = '';

        // Render the filtered results
        renderFilteredResults([filteredOutbound, filteredReturn], "2");

        // Update the results count
        const totalResults = filteredOutbound.length + filteredReturn.length;
        const resultsCountDisplay = document.getElementById('results-count');
        if (resultsCountDisplay) {
            resultsCountDisplay.textContent = `${totalResults} results`;
        }
<<<<<<< HEAD
    }
=======
    });

    // Clean up filter sets
    filters.departureTime.early = [...new Set(filters.departureTime.early)].filter(Boolean);
    filters.departureTime.late = [...new Set(filters.departureTime.late)].filter(Boolean);
    filters.flightDurations = [...new Set(filters.flightDurations)];

    return filters;
>>>>>>> 1d47f4474ecf268a4552d1625173d9d5aaee2e7a
}
>>>>>>> b23c208d0accd97c9550cae8b5093bad4e5e7476
