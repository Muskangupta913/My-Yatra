@extends('frontend.layouts.master')
@section('title', 'flight search')
@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Flight Search Results</title>
@section('styles')
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
 @endsection 
 <div class="container mx-auto px-4 py-8">
    {{-- Search Summary Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-purple-700 to-pink-600 rounded-xl p-4 md:p-6 mb-6 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="bg-white bg-opacity-20 p-3 rounded-full">
                    <i class="fas fa-plane text-2xl md:text-3xl text-white"></i>
                </div>
                <div id="flight-header" class="text-white"></div>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        {{-- Filters Sidebar --}}
        <div class="md:col-span-1 bg-white shadow-md rounded-lg p-4">
                <h3 class="font-bold text-lg mb-4">Advanced Filters</h3>
                <div id="filters-container" class="space-y-4">
                    <!-- Dynamically populated filters will go here -->
                </div>
            </div>

        {{-- Flight Results --}}
        <div class="md:col-span-3">
            {{-- Sorting and Results Count --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0">
                <div class="flex items-center space-x-2">
                    <span class="font-medium">Sort by:</span>
                    <select id="sort-options" class="border rounded p-2">
                        <option value="price-low-high">Price: Low to High</option>
                        <option value="price-high-low">Price: High to Low</option>
                        <option value="departure-early">Departure: Early</option>
                        <option value="departure-late">Departure: Late</option>
                    </select>
                </div>
                <div id="results-count" class="text-gray-600"></div>
            </div>

            {{-- Flight Results Container --}}
            <div id="results-container" class="space-y-4"></div>
        </div>
    </div>

    {{-- Fare Rules Modal --}}
    <div id="fareRulesModal" 
         class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg p-6 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Fare Rules</h2>
                <button onclick="closeFareRulesModal()" 
                        class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="fareRulesDetails"></div>
        </div>
    </div>
</div>
@endsection
    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    const results = JSON.parse(sessionStorage.getItem('flightSearchResults')) || [];
    const resultsContainer = document.getElementById('results-container');
    const filtersContainer = document.getElementById('filters-container');
    const resultsCountDisplay = document.getElementById('results-count');
    const sortOptions = document.getElementById('sort-options');

    // Advanced filter extraction
    function extractAdvancedFilters(results) {
        const filters = {
            airlines: new Set(),
            stops: new Set(),
            priceRange: { min: Infinity, max: -Infinity },
            departureTime: { early: [], late: [] },
            cabinClasses: new Set(),
            baggageOptions: new Set(),
            flightDurations: []
        };

        results.forEach(resultGroup => {
            resultGroup.forEach(result => {
                if (result.FareDataMultiple) {
                    result.FareDataMultiple.forEach(fareData => {
                        const segment = result.Segments[0][0];
                        const fareSegment = fareData.FareSegments[0];

                        // Airlines
                        filters.airlines.add(fareSegment.AirlineName || 'Unknown');

                        // Stops
                        const stops = result.Segments[0].length === 1 ? 'Non-stop' : `${result.Segments[0].length - 1} Stop`;
                        filters.stops.add(stops);

                        // Price Range
                        const fare = fareData.Fare.OfferedFare;
                        filters.priceRange.min = Math.min(filters.priceRange.min, fare);
                        filters.priceRange.max = Math.max(filters.priceRange.max, fare);

                        // Departure Times
                        const departureTime = new Date(segment.DepTime);
                        const hours = departureTime.getHours();
                        filters.departureTime.early.push(hours < 12 ? 'Morning (Before 12 PM)' : '');
                        filters.departureTime.late.push(hours >= 12 ? 'Evening (After 12 PM)' : '');

                        // Cabin Classes
                        filters.cabinClasses.add(fareSegment.CabinClassName || 'Unknown');

                        // Baggage Options
                        filters.baggageOptions.add(fareSegment.Baggage || 'Unknown');

                        // Flight Durations
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
        });

        // Clean up and unique filter sets
        filters.departureTime.early = [...new Set(filters.departureTime.early)].filter(Boolean);
        filters.departureTime.late = [...new Set(filters.departureTime.late)].filter(Boolean);
        filters.flightDurations = [...new Set(filters.flightDurations)];

        return filters;
    }

    // Dynamically create filter sections
    function createFilterSections(filters) {
        filtersContainer.innerHTML = `
            ${createFilterSection('Airlines', 'airlines', filters.airlines)}
            ${createFilterSection('Stops', 'stops', filters.stops)}
            ${createPriceRangeFilter(filters.priceRange)}
            ${createFilterSection('Departure Time', 'departure-time', 
                [...filters.departureTime.early, ...filters.departureTime.late])}
            ${createFilterSection('Cabin Class', 'cabin-class', filters.cabinClasses)}
            ${createFilterSection('Baggage', 'baggage', filters.baggageOptions)}
            ${createFilterSection('Flight Duration', 'flight-duration', filters.flightDurations)}
        `;

        // Add event listeners to new filter inputs
        document.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(input => {
            input.addEventListener('change', applyFilters);
        });
    }

    // Create filter section HTML
    function createFilterSection(title, name, options) {
        const optionsHTML = Array.from(options).map(option => `
            <label class="flex items-center mb-2">
                <input type="checkbox" name="${name}" value="${option}" class="mr-2">
                ${option}
            </label>
        `).join('');

        return `
            <div class="mb-4">
                <h4 class="font-semibold mb-2">${title}</h4>
                <div class="space-y-2">${optionsHTML}</div>
            </div>
        `;
    }

    // Create price range filter
    function createPriceRangeFilter(priceRange) {
        return `
            <div class="mb-4">
                <h4 class="font-semibold mb-2">Price Range</h4>
                <div class="flex space-x-2 mb-2">
                    <input type="number" id="min-price" placeholder="Min" 
                           min="${Math.floor(priceRange.min)}" 
                           max="${Math.ceil(priceRange.max)}" 
                           value="${Math.floor(priceRange.min)}" 
                           class="w-1/2 p-2 border rounded">
                    <input type="number" id="max-price" placeholder="Max" 
                           min="${Math.floor(priceRange.min)}" 
                           max="${Math.ceil(priceRange.max)}" 
                           value="${Math.ceil(priceRange.max)}" 
                           class="w-1/2 p-2 border rounded">
                </div>
                <button id="apply-price-filter" class="w-full bg-blue-500 text-white py-2 rounded">
                    Apply Price Filter
                </button>
            </div>
        `;
    }

    // Apply filters
    function applyFilters() {
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

    const filteredResults = results.map(resultGroup => 
        resultGroup.filter(result => {
            // Check if ANY of the fare data entries match the filters
            return result.FareDataMultiple.some(fareData => {
                const segment = result.Segments[0][0];
                const fareSegment = fareData.FareSegments[0];
                const departureTime = new Date(segment.DepTime);
                const duration = segment.Duration;

                const airlineMatch = selectedFilters.airlines.length === 0 || 
                    selectedFilters.airlines.includes(fareSegment.AirlineName);

                const priceMatch = fareData.Fare.OfferedFare >= selectedFilters.minPrice && 
                    fareData.Fare.OfferedFare <= selectedFilters.maxPrice;

                const stopMatch = selectedFilters.stops.length === 0 || 
                    selectedFilters.stops.some(stop => 
                        (stop === 'Non-stop' && result.Segments[0].length === 1) ||
                        (stop !== 'Non-stop' && result.Segments[0].length > 1)
                    );

                const departureTimeMatch = selectedFilters.departureTime.length === 0 || 
                    (departureTime.getHours() < 12 && selectedFilters.departureTime.includes('Morning (Before 12 PM)')) ||
                    (departureTime.getHours() >= 12 && selectedFilters.departureTime.includes('Evening (After 12 PM)'));

                const cabinClassMatch = selectedFilters.cabinClass.length === 0 || 
                    selectedFilters.cabinClass.includes(fareSegment.CabinClassName);

                const baggageMatch = selectedFilters.baggage.length === 0 || 
                    selectedFilters.baggage.includes(fareSegment.Baggage);

                const durationMatch = selectedFilters.flightDuration.length === 0 || 
                    selectedFilters.flightDuration.includes(
                        duration <= 60 ? 'Short (≤ 1 hour)' :
                        duration <= 120 ? 'Medium (1-2 hours)' :
                        'Long (> 2 hours)'
                    );

                return airlineMatch && priceMatch && stopMatch && 
                       departureTimeMatch && cabinClassMatch && 
                       baggageMatch && durationMatch;
            });
        })
    );

    renderFilteredResults(filteredResults);
}

    // Helper to get selected filter values
    function getSelectedValues(name) {
        return Array.from(
            document.querySelectorAll(`input[name="${name}"]:checked`)
        ).map(input => input.value);
    }

    // Render results (existing implementation)
    function renderFilteredResults(filteredResults) {
        resultsContainer.innerHTML = '';
        
        if (filteredResults.length === 0) {
            resultsContainer.innerHTML = `
                <div class="text-center py-10">
                    <p class="text-gray-600">No flight results found matching your filters.</p>
                </div>`;
            resultsCountDisplay.textContent = '0 results';
            return;
        }

        filteredResults.forEach(resultGroup => {
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

        resultsCountDisplay.textContent = `${filteredResults.length} results`;
    
    }

    // Sorting functionality (existing implementation)
    function sortResults(option) {
        const sortedResults = JSON.parse(JSON.stringify(results)); // Deep clone to avoid mutating original

    sortedResults.forEach(resultGroup => {
    resultGroup.sort((a, b) => {
        const fareA = a.FareDataMultiple[0].Fare.OfferedFare;
        const fareB = b.FareDataMultiple[0].Fare.OfferedFare;
        const depTimeA = new Date(a.Segments[0][0].DepTime);
        const depTimeB = new Date(b.Segments[0][0].DepTime);

        switch(option) {
            case 'price-low-high':
                return fareA - fareB;
            case 'price-high-low':
                return fareB - fareA;
            case 'departure-early':
                return depTimeA - depTimeB;
            case 'departure-late':
                return depTimeB - depTimeA;
        }
    });
});

renderFilteredResults(sortedResults);
    }

    // Initialize
    const filters = extractAdvancedFilters(results);
    createFilterSections(filters);
    renderFilteredResults(results);

    // Event Listeners for sorting
    sortOptions.addEventListener('change', (e) => {
        sortResults(e.target.value);
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
            window.location.href = '/flight/fareQutesResult';

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
      
                    
//     document.addEventListener('DOMContentLoaded', function() {
//     const urlParams = new URLSearchParams(window.location.search);
//     const from = urlParams.get('from').split('(')[0].trim();
//     const to = urlParams.get('to').split('(')[0].trim();
//     const fromCode = urlParams.get('fromCode');
//     const toCode = urlParams.get('toCode');
//     const departureDate = urlParams.get('departureDate');
//     const adults = urlParams.get('adults');
//     const cabinClass = urlParams.get('cabinClass');

//     // Function to fetch calendar fares
//     function fetchCalendarFares() {
//         const payload = {
//             EndUserIp: '1.1.1.1', // Replace with actual IP
//             ClientId: '180133',
//             UserName: 'MakeMy91',
//             Password: 'MakeMy@910',
//             JourneyType: '1', // One-way
//             FareType: 'All',
//             Segments: [{
//                 Origin: fromCode,
//                 Destination: toCode,
//                 FlightCabinClass: cabinClass,
//                 PreferredDepartureTime: departureDate,
//                 PreferredArrivalTime: departureDate
//             }]
//         };

//         fetch('/flight/calendarFares', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//             },
//             body: JSON.stringify(payload)
//         })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success && data.results) {
//                 displayCalendarFares(data.results);
//             }
//         })
//         .catch(error => {
//             console.error('Error fetching calendar fares:', error);
//         });
//     }

//     // Function to display calendar fares in the header
//     function displayCalendarFares(results) {
//         const calendarFareContainer = document.createElement('div');
//         calendarFareContainer.classList.add('mt-2', 'bg-white', 'bg-opacity-10', 'p-3', 'rounded-lg');
        
//         const lowestFare = results.reduce((min, result) => 
//             result.Fare < min ? result.Fare : min, Infinity
//         );

//         const lowestFareDate = results.find(result => result.Fare === lowestFare);

//         calendarFareContainer.innerHTML = `
//             <div class="flex items-center text-white space-x-2">
//                 <i class="fas fa-calendar-alt"></i>
//                 <span class="font-medium">Lowest Fare:</span>
//                 <span class="font-bold">₹${lowestFare.toLocaleString()}</span>
//                 <span class="text-sm">(${new Date(lowestFareDate.DepartureDate).toLocaleDateString()})</span>
//             </div>
//         `;

//         // Append to flight header
//         const flightHeader = document.getElementById('flight-header');
//         flightHeader.appendChild(calendarFareContainer);
//     }

//     // Call fetch calendar fares
//     fetchCalendarFares();
// });
               
    </script>
 @endsection