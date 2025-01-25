<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Flight Search Results</title>
     <!-- Tailwind CSS -->
     <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <style>
        .modal {
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
      <!-- Search Summary Header -->
<div class="bg-gradient-to-r from-indigo-600 via-purple-700 to-pink-600 shadow-2xl rounded-xl p-6 mb-6 relative overflow-hidden">
    <div class="absolute inset-0 bg-white bg-opacity-10 backdrop-blur-sm"></div>
    <div class="relative z-10 flex justify-between items-center">
        <div class="flex items-center space-x-6">
            <div class="bg-white bg-opacity-20 p-4 rounded-full">
                <i class="fas fa-plane text-3xl text-white"></i>
            </div>
            <div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const urlParams = new URLSearchParams(window.location.search);
                        const from = urlParams.get('from').split('(')[0].trim();
                        const to = urlParams.get('to').split('(')[0].trim();
                        const fromCode = urlParams.get('fromCode');
                        const toCode = urlParams.get('toCode');
                        const departureDate = urlParams.get('departureDate');
                        const adults = urlParams.get('adults');
                        const cabinClass = urlParams.get('cabinClass');

                        // Mapping cabin class
                        const cabinClassMap = {
                            '1': 'Economy',
                            '2': 'Premium Economy',
                            '3': 'Business',
                            '4': 'First Class'
                        };

                        document.getElementById('flight-header').innerHTML = `
                            <h1 class="text-3xl font-bold text-white mb-2">
                                ${from} (${fromCode}) <i class="fas fa-arrow-right text-xl mx-3 text-white"></i> ${to} (${toCode})
                            </h1>
                            <div class="text-white text-opacity-90 space-y-1">
                                <p class="flex items-center">
                                    <i class="fas fa-calendar-alt mr-2"></i>
                                    ${new Date(departureDate).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}
                                </p>
                                <div class="flex space-x-4">
                                    <p class="flex items-center">
                                        <i class="fas fa-users mr-2"></i>
                                        ${adults} Passenger${adults > 1 ? 's' : ''}
                                    </p>
                                    <p class="flex items-center">
                                        <i class="fas fa-chair mr-2"></i>
                                        ${cabinClassMap[cabinClass] || 'Economy'} Class
                                    </p>
                                </div>
                            </div>
                        `;
                    });
                </script>
                <div id="flight-header"></div>
            </div>
        </div>
    </div>
</div>
        <div class="flex">
            <!-- Filters Sidebar -->
            <div id="airline-filter" class="mb-4">
    <!-- Airline filters will be dynamically generated here -->
</div>

<div class="mb-4">
    <h3 class="font-medium mb-2">Price Range</h3>
    <div class="flex items-center">
        <input type="number" id="min-price" placeholder="Min" class="w-1/2 mr-2 p-2 border rounded">
        <input type="number" id="max-price" placeholder="Max" class="w-1/2 p-2 border rounded">
    </div>
    <button id="apply-price-filter" class="mt-2 w-full bg-blue-500 text-white py-2 rounded">
        Apply Price Filter
    </button>
</div>
            <!-- Flight Results -->
            <div class="w-3/4">
                <!-- Flight Cards -->
                <div id="results-container"></div>
            </div>
        </div>
    </div>

    <!-- Fare Rules Modal -->
    <div id="fareRulesModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-2xl w-full">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Fare Rules</h2>
                <button onclick="closeFareRulesModal()" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="fareRulesDetails" class="max-h-96 overflow-y-auto">
                <!-- Fare rules content will be dynamically loaded here -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const results = JSON.parse(sessionStorage.getItem('flightSearchResults')) || [];
            const resultsContainer = document.getElementById('results-container');
            const fareRulesModal = document.getElementById('fareRulesModal');
            const fareRulesDetails = document.getElementById('fareRulesDetails');
            const closeFareRules = document.querySelector('.close-fare-rules');

            if (results.length === 0) {
                resultsContainer.innerHTML = `
                    <div class="text-center py-10">
                        <p class="text-gray-600">No flight results found.</p>
                    </div>`;
                return;
            }

            // Iterate over the results and create flight cards
            results.forEach(resultGroup => {
                resultGroup.forEach(result => {
                    if (result.FareDataMultiple && Array.isArray(result.FareDataMultiple)) {
                        result.FareDataMultiple.forEach(fareData => {
                            const segment = result.Segments?.[0]?.[0];
                            
                            const flightCard = document.createElement('div');
                            flightCard.classList.add('bg-white', 'shadow-md', 'rounded-lg', 'p-4', 'mb-4');
                            flightCard.innerHTML = `
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <h2 class="font-semibold">${fareData.FareSegments[0]?.AirlineName || 'Airline'}</h2>
                                        <p class="text-sm text-gray-600">Flight No: ${fareData.FareSegments[0]?.FlightNumber || 'N/A'}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xl font-bold text-blue-600">₹${fareData.Fare?.OfferedFare?.toLocaleString() || 'N/A'}</p>
                                    </div>
                                </div>
                                
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <p class="font-semibold">${segment?.DepTime ? new Date(segment.DepTime).toLocaleTimeString() : 'N/A'}</p>
                                        <p class="text-sm text-gray-600">${segment?.Origin?.AirportName || 'N/A'} (${segment?.Origin?.AirportCode || 'N/A'})</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm text-gray-600">${segment?.Duration || 'N/A'} mins</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold">${segment?.ArrTime ? new Date(segment.ArrTime).toLocaleTimeString() : 'N/A'}</p>
                                        <p class="text-sm text-gray-600">${segment?.Destination?.AirportName || 'N/A'} (${segment?.Destination?.AirportCode || 'N/A'})</p>
                                    </div>
                                </div>
                                
                                <div class="border-t pt-3 flex justify-between items-center">
                                    <div class="flex space-x-2">
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">
                                            ${fareData.FareSegments[0]?.Baggage || 'N/A'} Baggage
                                        </span>
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                            ${fareData.FareSegments[0]?.CabinClassName || 'N/A'}
                                        </span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button onclick="viewFlightDetails('${fareData.ResultIndex}')" 
                                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                            View Details
                                        </button>
                                        <button onclick="fetchFareRules('${fareData.ResultIndex}')" 
                                                class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                                            Fare Rules
                                        </button>
                                    </div>
                                </div>
                            `;

                            resultsContainer.appendChild(flightCard);
                        });
                    }
                });
            });
        });

function viewFlightDetails(resultIndex) {
    const traceId = sessionStorage.getItem('flightTraceId');
    const results = JSON.parse(sessionStorage.getItem('flightSearchResults')) || [];

    if (!traceId) {
        console.error('TraceId is not found in sessionStorage');
        return;
    }

    // Find the SrdvIndex for the specific resultIndex
    let srdvIndex = null;
    results.forEach(resultGroup => {
        resultGroup.forEach(result => {
            if (result.FareDataMultiple) {
                result.FareDataMultiple.forEach(fareData => {
                    if (fareData.ResultIndex === resultIndex) {
                        srdvIndex = fareData.SrdvIndex;
                    }
                });
            }
        });
    });


     // Find the detailed flight information for the specific resultIndex
     let selectedFlight = null;
    results.forEach(resultGroup => {
        resultGroup.forEach(result => {
            if (result.FareDataMultiple) {
                result.FareDataMultiple.forEach(fareData => {
                    if (fareData.ResultIndex === resultIndex) {
                        selectedFlight = {
                            airlineName: fareData.FareSegments[0]?.AirlineName,
                            flightNumber: fareData.FareSegments[0]?.FlightNumber,
                            cabinClass: fareData.FareSegments[0]?.CabinClassName,
                            fare: fareData.Fare?.OfferedFare,
                            segment: result.Segments?.[0]?.[0],
                            origin: result.Segments?.[0]?.[0]?.Origin?.AirportCode,
                            destination: result.Segments?.[0]?.[0]?.Destination?.AirportCode,
                            isLCC: fareData.IsLCC
                        };
                    }
                });
            }
        });
    });

    if (!selectedFlight) {
        console.error('Unable to find flight details for the selected flight');
        alert('Error: Could not retrieve flight details.');
        return;
    }

    // Ensure we have a valid SrdvIndex before making the API call
    if (!srdvIndex) {
        console.error('Unable to find SrdvIndex for the selected flight');
        alert('Error: Could not retrieve fare details for the selected flight.');
        return;
    }

    // Prepare payload for fareQuote API
    const payload = {
        EndUserIp: '1.1.1.1', // Replace with actual IP
        ClientId: '180133',
        UserName: 'MakeMy91',
        Password: 'MakeMy@910',
        SrdvType: 'MixAPI',
        SrdvIndex: srdvIndex,
        TraceId: traceId,
        ResultIndex: resultIndex
    };

    // Call the FareQuote API
    fetch('/flight/fareQutes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Store fare quote data in sessionStorage
            sessionStorage.setItem('fareQuoteData', JSON.stringify(data.fareQuote));
            sessionStorage.setItem('selectedFlightResultIndex', resultIndex);
            sessionStorage.setItem('selectedFlightTraceId', traceId);

           


         
            window.location.href = `/flight-booking?traceId=${traceId}&resultIndex=${resultIndex}&details=${encodeURIComponent(JSON.stringify({
    airlineName: selectedFlight.airlineName,
    flightNumber: selectedFlight.flightNumber,
    cabinClass: selectedFlight.cabinClass,
    isLCC: selectedFlight.isLCC,
    fare: selectedFlight.fare,
    origin: selectedFlight.origin,
    destination: selectedFlight.destination
}))}`;


            // Redirect to the fare quote result page
            // window.location.href = `/flight-info?traceId=${traceId}&resultIndex=${resultIndex}`;
        } else {
            // Handle API error
            console.error('Fare Quote API Error:', data.message);
            alert(`Error fetching fare details: ${data.message}`);
        }
    })
    .catch(error => {
        console.error('Error fetching fare quote:', error);
        alert('An error occurred while fetching flight details.');
    });
}
     

        function fetchFareRules(resultIndex) {
    const results = JSON.parse(sessionStorage.getItem('flightSearchResults')) || [];
    const traceId = sessionStorage.getItem('flightTraceId');
    const fareRulesModal = document.getElementById('fareRulesModal');
    const fareRulesDetails = document.getElementById('fareRulesDetails');

    // Find the SrdvIndex for the specific resultIndex
    let srdvIndex = null;
    results.forEach(resultGroup => {
        resultGroup.forEach(result => {
            if (result.FareDataMultiple) {
                result.FareDataMultiple.forEach(fareData => {
                    if (fareData.ResultIndex === resultIndex) {
                        srdvIndex = fareData.SrdvIndex;
                    }
                });
            }
        });
    });

    // Show loading state
    fareRulesDetails.innerHTML = '<p>Loading fare rules...</p>';
    fareRulesModal.style.display = 'block';

    // Ensure we have a valid SrdvIndex before making the API call
    if (!srdvIndex) {
        fareRulesDetails.innerHTML = '<p>Unable to find SrdvIndex for the selected flight.</p>';
        return;
    }

    // Prepare payload for fare rules API
    const payload = {
        EndUserIp: '1.1.1.1', // Replace with actual IP
        ClientId: '180133',
        UserName: 'MakeMy91',
        Password: 'MakeMy@910',
        SrdvType: 'MixAPI', // This can also be dynamically extracted if needed
        SrdvIndex: srdvIndex,
        TraceId: traceId,
        ResultIndex: resultIndex
    };


            // Make API call to fetch fare rules
            fetch('flight/farerule', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.fareRules) {
                    // Format and display fare rules
                    fareRulesDetails.innerHTML = `
                        <h2>Fare Rules for Flight</h2>
                        <p><strong>Airline:</strong> ${data.fareRules.Airline}</p>
                        <p><strong>Route:</strong> ${data.fareRules.Origin} to ${data.fareRules.Destination}</p>
                        <p><strong>Fare Basis Code:</strong> ${data.fareRules.FareBasisCode}</p>
                        <div class="fare-rule-details">
                            <h3>Fare Rule Details</h3>
                            <pre>${data.fareRules.FareRuleDetail}</pre>
                        </div>
                    `;
                } else {
                    fareRulesDetails.innerHTML = `<p>Unable to fetch fare rules: ${data.message || 'Unknown error'}</p>`;
                }
            })
            .catch(error => {
                console.error('Error fetching fare rules:', error);
                fareRulesDetails.innerHTML = `<p>Error fetching fare rules: ${error.message}</p>`;
            });
        }
    </script>
</body>
</html>