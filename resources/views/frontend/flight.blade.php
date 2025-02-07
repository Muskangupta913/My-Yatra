@extends('frontend.layouts.master')
@section('title', 'flight search')
@section('content')
@section('styles')
     <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> 
    <style>
        .flight-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        
        }
        .flight-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.15);
         
        }
        .gradient-header {
    background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('/assets/images/flight.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
}

.container {
    position: relative;
    z-index: 1;
}

body::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('/assets/images/flight.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    opacity: 0.7;  /* Increased opacity for more visible background */
    z-index: -1;
}

.filter-section {
    background-image: linear-gradient(rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0.75)), url('/assets/images/flight.jpg');
    background-size: cover;
    background-position: center;
    backdrop-filter: blur(3px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.flight-card {
    background-image: linear-gradient(rgba(255, 255, 255, 0.75), rgba(255, 255, 255, 0.75)), url('/assets/images/flight.jpg');
    background-size: cover;
    background-position: center;
    backdrop-filter: blur(3px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.flight-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
}

/* Additional styles to ensure text readability */
.flight-card p, 
.flight-card h2, 
.flight-card span,
.filter-section p,
.filter-section h3,
.filter-section h4 {
    text-shadow: 0 0 1px rgba(255, 255, 255, 0.8);
    position: relative;
}
.filter-section {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
        }
.modal {
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
        }
.filter-section {
    transition: transform 0.3s ease-in-out;
}

@media (max-width: 768px) {
.filter-section {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 85%;
        max-width: 320px;
        z-index: 40;
        overflow-y: auto;
        transform: translateX(-100%);
        padding-top: 60px; /* Space for close button */
    }

.filter-section.show {
        transform: translateX(0);
    }

.filter-overlay {
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 35;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease-in-out;
    }

.filter-overlay.show {
        opacity: 1;
        pointer-events: auto;
    }
}
    </style>
 @endsection 
 @section('content')
<!-- Root wrapper for full width -->
<div class="min-h-screen w-full">
    <!-- Main content container -->
    <div class="max-w-[1440px] mx-auto px-6 py-8">
        <!-- Search Summary Header with gradient -->
        <div class="gradient-header rounded-xl p-6 mb-8 shadow-md bg-gradient-to-r from-blue-600/60 to-blue-800/60">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="flex items-center space-x-6">
                    <div class="p-4 bg-blue-600/20 rounded-full">
                        <i class="fas fa-plane text-3xl md:text-4xl text-white transform rotate-45"></i>
                    </div>
                    <div id="flight-header" class="text-white">
                        <!-- Dynamic flight header content -->
                    </div>
                </div>
            </div>
        </div>
      <!-- Main Content Grid -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Filters Sidebar -->
            <div class="md:col-span-1 filter-section rounded-lg shadow-md p-6">
                <h3 class="font-bold text-2xl mb-6 text-gray-800 border-b pb-4">
                    <i class="fas fa-filter mr-3 text-blue-600"></i>Advanced Filters
                </h3>
                <div id="filters-container" class="space-y-6">
                    <!-- Dynamically populated filters -->
                </div>
            </div>
            <div id="filter-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>
            <!-- Flight Results Section -->
            <div class="md:col-span-3">
                 <div id="calendarfare">
                     <div id="fareResults"></div>
                 </div>
                <!-- Sorting Controls with improved alignment -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-4 bg-white/90 p-1 rounded-lg shadow-sm">
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-900 font-medium">Sort by:</span>
                        <select id="sort-options" class="bg-white border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="price-low-high">Price: Low to High</option>
                            <option value="price-high-low">Price: High to Low</option>
                            <option value="departure-early">Departure: Early</option>
                            <option value="departure-late">Departure: Late</option>
                        </select>
                    </div>
                    <div id="results-count" class="absolute opacity-0 w-0 h-0 overflow-hidden pointer-events-auto"></div>
                </div>

                <!-- Results Container -->
                <div id="results-container" class="space-y-6">
                    <!-- Dynamic flight cards -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal (positioned outside main container for proper stacking) -->
<div id="fareRulesModal" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
    <!-- Semi-transparent backdrop -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <!-- Modal Content -->
    <div class="bg-white rounded-xl w-full max-w-3xl mx-auto relative shadow-2xl">
        <div class="bg-blue-600 p-4 rounded-t-xl">
            <h2 class="text-xl font-bold text-white">Fare Rules</h2>
        </div>
        <div class="p-6 max-h-[70vh] overflow-y-auto">
            <div id="fareRulesDetails" class="text-gray-800 space-y-4">
                <!-- Content will be dynamically inserted here -->
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const outboundFlights = JSON.parse(sessionStorage.getItem('outboundFlights')) || [];
        const returnFlights = JSON.parse(sessionStorage.getItem('returnFlights')) || [];
    const results = JSON.parse(sessionStorage.getItem('flightSearchResults')) || [];
    const resultsContainer = document.getElementById('results-container');
    const filtersContainer = document.getElementById('filters-container');
    const resultsCountDisplay = document.getElementById('results-count');
    const sortOptions = document.getElementById('sort-options');
 const journeyType = sessionStorage.getItem('journeyType') || "1"; // Default to One-Way
    const isRoundTrip = journeyType; // Check if it's round trip

    console.log('journey type is',isRoundTrip);
     


    
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
        if (name === 'airlines') {
        const optionsHTML = Array.from(options).map(airlineName => {
            // Find the airline code from the results data
            let airlineCode = '';
            for (const resultGroup of results) {
                for (const result of resultGroup) {
                    if (result.FareDataMultiple) {
                        for (const fareData of result.FareDataMultiple) {
                            if (fareData.FareSegments[0]?.AirlineName === airlineName) {
                                airlineCode = fareData.FareSegments[0].AirlineCode;
                                break;
                            }
                        }
                    }
                    if (airlineCode) break;
                }
                if (airlineCode) break;
            }
            return `
                <label class="flex items-center mb-3 hover:bg-gray-50 p-2 rounded">
                    <input type="checkbox" name="${name}" value="${airlineName}" class="mr-3">
                    <img src="${getAirlineLogo(airlineCode)}" 
                         alt="${airlineName}" 
                         class="w-8 h-8 mr-3 object-contain"
                         onerror="this.onerror=null; this.src='/assets/images/airlines/airlines/48_48/default-airline.png'; this.classList.add('grayscale', 'opacity-70');">
                    <span class="text-sm">${airlineName}</span>
                </label>
            `;
        }).join('');
        return `
            <div class="mb-6">
                <h4 class="font-semibold mb-3 text-gray-700">${title}</h4>
                <div class="space-y-1">${optionsHTML}</div>
            </div>
        `;
    } else {
        // Original handling for other filter sections
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
<<<<<<< HEAD
    renderFilteredResults(filteredResults);
=======

    renderFilteredResults(filteredResults, journeyType);
>>>>>>> 60d6f4809c6632cd4c59f250c74b5ae005512c4b
}
    // Helper to get selected filter values
    function getSelectedValues(name) {
        return Array.from(
            document.querySelectorAll(`input[name="${name}"]:checked`)
        ).map(input => input.value);
    }

    function getAirlineLogo(airlineCode) {
    // Normalize the airline code (uppercase and trim)
    const normalizedCode = (airlineCode || '').toUpperCase().trim();
    // Define an array of possible image extensions
    const extensions = ['.png', '.jpg', '.jpeg', '.svg', '.webp'];
    // Default fallback logo path
    const defaultLogoPath = '/assets/images/airlines/airlines/48_48/6E.png';
    
    // Try to construct the logo path based on airline code
    const logoPath = `/assets/images/airlines/airlines/48_48/${normalizedCode || '6E'}${extensions[0]}`;
    
    return logoPath || defaultLogoPath;
}
    // Render results (existing implementation)
<<<<<<< HEAD
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
=======
    function renderFilteredResults(filteredResults, journeyType) {
    const resultsContainer = document.getElementById('results-container');
    resultsContainer.innerHTML = '';
    console.log('Rendering Function', journeyType);
>>>>>>> 60d6f4809c6632cd4c59f250c74b5ae005512c4b

    let selectedOutbound = null;
    let selectedReturn = null;

    // Create fixed bottom div for selections
    const selectionDiv = document.createElement('div');
    selectionDiv.id = 'selected-flights';
    selectionDiv.style.display = 'none';
    selectionDiv.classList.add(
        'fixed', 'bottom-0', 'left-0', 'right-0',
        'bg-white', 'shadow-lg', 'border-t',
        'p-4', 'z-50'
    );
    document.body.appendChild(selectionDiv);

    if (filteredResults.length === 0) {
        resultsContainer.innerHTML = `
            <div class="text-center py-10">
                <p class="text-gray-600">No flight results found matching your filters.</p>
            </div>`;
        resultsCountDisplay.textContent = '0 results';
        return;
    }
    // Handle One-way flights (journeyType === "1")
    if (journeyType === "1") {
        console.log('journeytype inside function value', journeyType);
        filteredResults.forEach(resultGroup => {
            resultGroup.forEach(result => {
                if (result.FareDataMultiple && Array.isArray(result.FareDataMultiple)) {
                    result.FareDataMultiple.forEach(fareData => {
                        const segment = result.Segments?.[0]?.[0];
                        
                        const flightCard = document.createElement('div');
                        flightCard.classList.add(
                            'flight-card',
                            'bg-white',
                            'border',
                            'border-gray-200',
                            'rounded-lg',
                            'p-6',
                            'shadow-md',
                            'mb-4'
                        );

                        flightCard.innerHTML = `
                            <div class="flex justify-between items-center mb-6">
                                <div class="flex items-center">
                                    <img src="${getAirlineLogo(fareData.FareSegments[0]?.AirlineCode)}" 
                                         alt="${fareData.FareSegments[0]?.AirlineName || 'Airline'}" 
                                         class="w-12 h-12 mr-4 object-contain"
                                         onerror="this.onerror=null; this.src='/assets/images/airlines/airlines/48_48/default-airline.png'">
                                    <div>
                                        <h2 class="text-xl font-bold text-blue-700">${fareData.FareSegments[0]?.AirlineName || 'Airline'}</h2>
                                        <p class="text-sm text-gray-900">${fareData.FareSegments[0]?.AirlineCode || ''} - ${fareData.FareSegments[0]?.FlightNumber || 'N/A'}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-green-600">₹${fareData.Fare?.OfferedFare?.toLocaleString() || 'N/A'}</p>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <p class="font-semibold">${segment?.DepTime ? new Date(segment.DepTime).toLocaleTimeString() : 'N/A'}</p>
                                    <p class="text-sm text-gray-900">${segment?.Origin?.AirportName || 'N/A'} (${segment?.Origin?.AirportCode || 'N/A'})</p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="text-center">
                                        <div class="flex items-center">
                                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                                            <div class="w-24 h-0.5 bg-gray-300 relative">
                                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xs text-gray-900">
                                                    ${segment?.Duration || 'N/A'} mins
                                                </div>
                                            </div>
                                            <div class="w-3 h-3 bg-blue-500 rounded-full ml-2"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">${segment?.ArrTime ? new Date(segment.ArrTime).toLocaleTimeString() : 'N/A'}</p>
                                    <p class="text-sm text-gray-900">${segment?.Destination?.AirportName || 'N/A'} (${segment?.Destination?.AirportCode || 'N/A'})</p>
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
    }
<<<<<<< HEAD
=======
    // Handle Round-trip flights (journeyType === "2")
    else if (journeyType === "2") {
        const returnFlights = JSON.parse(sessionStorage.getItem('returnFlights')) || [];
        const outboundFlights = JSON.parse(sessionStorage.getItem('outboundFlights')) || [];

        // Function to update selection div
        function updateSelectionDiv() {
            if (selectedOutbound || selectedReturn) {
                selectionDiv.style.display = 'block';
                selectionDiv.innerHTML = `
                    <div class="container mx-auto max-w-6xl">
                        <div class="flex justify-between items-center">
                            <div class="flex gap-4">
                                ${selectedOutbound ? `
                                    <div class="flex items-center">
                                        <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            Outbound: ${selectedOutbound.airline} - ${selectedOutbound.flightNumber}
                                        </div>
                                    </div>
                                ` : ''}
                                ${selectedReturn ? `
                                    <div class="flex items-center">
                                        <div class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                                            Return: ${selectedReturn.airline} - ${selectedReturn.flightNumber}
                                        </div>
                                    </div>
                                ` : ''}
                            </div>
                           ${selectedOutbound && selectedReturn ? `
    <button onclick="handleRoundTripFareQuotes('${selectedOutbound.resultIndex}', '${selectedReturn.resultIndex}')"
            class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
        View Details
    </button>
` : ''}
                            
                        </div>
                    </div>
                `;
            } else {
                selectionDiv.style.display = 'none';
            }
        }

        // Create sections for outbound and return flights
        const outboundSection = document.createElement('div');
        outboundSection.classList.add('mb-8');
        outboundSection.innerHTML = '<h2 class="text-xl font-bold mb-4">Select Outbound Flight</h2>';

        const returnSection = document.createElement('div');
        returnSection.classList.add('mb-8');
        returnSection.innerHTML = '<h2 class="text-xl font-bold mb-4">Select Return Flight</h2>';

        // Render outbound flights
        outboundFlights.forEach(outbound => {
            if (!outbound.FareDataMultiple || !Array.isArray(outbound.FareDataMultiple)) return;

            outbound.FareDataMultiple.forEach(outboundFareData => {
                const outboundSegment = outbound.Segments?.[0]?.[0];
                if (!outboundSegment) return;

                const flightCard = document.createElement('div');
                flightCard.classList.add('mb-4', 'relative');
                
                // Add radio button for selection
                const radioContainer = document.createElement('div');
                radioContainer.classList.add(
                    'absolute', 'top-4', 'right-4',
                    'w-6', 'h-6'
                );
                radioContainer.innerHTML = `
                    <input type="radio" 
                           name="outbound-flight" 
                           class="w-6 h-6 cursor-pointer"
                           value="${outboundFareData.ResultIndex}">
                `;

                flightCard.innerHTML = createFlightCardContent(outboundSegment, outboundFareData);
                flightCard.appendChild(radioContainer);

                // Add click handler for selection
                flightCard.querySelector('input[type="radio"]').addEventListener('change', (e) => {
                    if (e.target.checked) {
                        selectedOutbound = {
                            resultIndex: outboundFareData.ResultIndex,
                            airline: outboundFareData.FareSegments[0]?.AirlineName,
                            flightNumber: outboundFareData.FareSegments[0]?.FlightNumber
                        };
                        updateSelectionDiv();
                    }
                });

                outboundSection.appendChild(flightCard);
            });
        });

        // Render return flights
        returnFlights.forEach(returnFlight => {
            if (!returnFlight.FareDataMultiple || !Array.isArray(returnFlight.FareDataMultiple)) return;

            returnFlight.FareDataMultiple.forEach(returnFareData => {
                const returnSegment = returnFlight.Segments?.[0]?.[0];
                if (!returnSegment) return;

                const flightCard = document.createElement('div');
                flightCard.classList.add('mb-4', 'relative');

                // Add radio button for selection
                const radioContainer = document.createElement('div');
                radioContainer.classList.add(
                    'absolute', 'top-4', 'right-4',
                    'w-6', 'h-6'
                );
                radioContainer.innerHTML = `
                    <input type="radio" 
                           name="return-flight" 
                           class="w-6 h-6 cursor-pointer"
                           value="${returnFareData.ResultIndex}">
                `;

                flightCard.innerHTML = createFlightCardContent(returnSegment, returnFareData);
                flightCard.appendChild(radioContainer);

                // Add click handler for selection
                flightCard.querySelector('input[type="radio"]').addEventListener('change', (e) => {
                    if (e.target.checked) {
                        selectedReturn = {
                            resultIndex: returnFareData.ResultIndex,
                            airline: returnFareData.FareSegments[0]?.AirlineName,
                            flightNumber: returnFareData.FareSegments[0]?.FlightNumber
                        };
                        updateSelectionDiv();
                    }
                });

                returnSection.appendChild(flightCard);
            });
        });

        resultsContainer.appendChild(outboundSection);
        resultsContainer.appendChild(returnSection);
    }

    resultsCountDisplay.textContent = `${filteredResults.length} results`;
}




function createFlightCardContent(segment, fareData) {
    return `
        <div class="flight-card bg-white border border-gray-200 rounded-lg p-6 shadow-md">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center">
                    <img src="${getAirlineLogo(fareData.FareSegments[0]?.AirlineCode)}" 
                         alt="${fareData.FareSegments[0]?.AirlineName || 'Airline'}" 
                         class="w-12 h-12 mr-4 object-contain"
                         onerror="this.onerror=null; this.src='/assets/images/airlines/airlines/48_48/default-airline.png'">
                    <div>
                        <h2 class="text-xl font-bold text-blue-700">${fareData.FareSegments[0]?.AirlineName || 'Airline'}</h2>
                        <p class="text-sm text-gray-900">${fareData.FareSegments[0]?.AirlineCode || ''} - ${fareData.FareSegments[0]?.FlightNumber || 'N/A'}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold text-green-600">₹${fareData.Fare?.OfferedFare?.toLocaleString() || 'N/A'}</p>
                </div>
            </div>

            <div class="flex justify-between items-center mb-4">
                <div>
                    <p class="font-semibold">${segment?.DepTime ? new Date(segment.DepTime).toLocaleTimeString() : 'N/A'}</p>
                    <p class="text-sm text-gray-900">${segment?.Origin?.AirportName || 'N/A'} (${segment?.Origin?.AirportCode || 'N/A'})</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="text-center">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                            <div class="w-24 h-0.5 bg-gray-300 relative">
                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-xs text-gray-900">
                                    ${segment?.Duration || 'N/A'} mins
                                </div>
                            </div>
                            <div class="w-3 h-3 bg-blue-500 rounded-full ml-2"></div>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-semibold">${segment?.ArrTime ? new Date(segment.ArrTime).toLocaleTimeString() : 'N/A'}</p>
                    <p class="text-sm text-gray-900">${segment?.Destination?.AirportName || 'N/A'} (${segment?.Destination?.AirportCode || 'N/A'})</p>
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
                   
                    <button onclick="fetchFareRules('${fareData.ResultIndex}')" 
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        Fare Rules
                    </button>
                </div>
            </div>
        </div>
    `;
}


>>>>>>> 60d6f4809c6632cd4c59f250c74b5ae005512c4b
    // Sorting functionality (existing implementation)
    function sortResults(option) {
        const journeyType = sessionStorage.getItem('journeyType') || "1";
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
    renderFilteredResults(results, journeyType);

    // Event Listeners for sorting
    sortOptions.addEventListener('change', (e) => {
        sortResults(e.target.value);
    });
});


function handleRoundTripFareQuotes(outboundResultIndex, returnResultIndex) {
    const traceId = sessionStorage.getItem('flightTraceId');
    const outboundFlights = JSON.parse(sessionStorage.getItem('outboundFlights')) || [];
const returnFlights = JSON.parse(sessionStorage.getItem('returnFlights')) || [];
    if (!traceId) {
    console.error('TraceId is not found in sessionStorage');
    return;
}

// Find SrdvIndex for outbound flight
let outboundSrdvIndex = null;
// Find SrdvIndex for return flight
let returnSrdvIndex = null;

// Find SrdvIndex from outboundFlights
outboundFlights.forEach(outbound => {
    if (outbound.FareDataMultiple && Array.isArray(outbound.FareDataMultiple)) {
        outbound.FareDataMultiple.forEach(fareData => {
            if (fareData.ResultIndex === outboundResultIndex) {
                outboundSrdvIndex = fareData.SrdvIndex;
            }
        });
    }
});

// Find SrdvIndex from returnFlights
returnFlights.forEach(returnFlight => {
    if (returnFlight.FareDataMultiple && Array.isArray(returnFlight.FareDataMultiple)) {
        returnFlight.FareDataMultiple.forEach(fareData => {
            if (fareData.ResultIndex === returnResultIndex) {
                returnSrdvIndex = fareData.SrdvIndex;
            }
        });
    }
});

// Log the found indices for debugging
console.log('Outbound SrdvIndex:', outboundSrdvIndex);
console.log('Return SrdvIndex:', returnSrdvIndex);
    // Create payloads for both flights
    const outboundPayload = {
        EndUserIp: '1.1.1.1',
        ClientId: '180133',
        UserName: 'MakeMy91',
        Password: 'MakeMy@910',
        SrdvType: 'MixAPI',
        SrdvIndex: outboundSrdvIndex,
        TraceId: traceId,
        ResultIndex: outboundResultIndex
    };

    console.log('outbound payload', outboundPayload);

    const returnPayload = {
        EndUserIp: '1.1.1.1',
        ClientId: '180133',
        UserName: 'MakeMy91',
        Password: 'MakeMy@910',
        SrdvType: 'MixAPI',
        SrdvIndex: returnSrdvIndex,
        TraceId: traceId,
        ResultIndex: returnResultIndex
    };
    console.log('return payload', returnPayload);

    // First fare quote call for outbound flight
    fetch('/flight/fareQutes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(outboundPayload)
    })
    .then(response => response.json())
    .then(outboundData => {
        if (outboundData.success) {
            // Store outbound fare quote data
            sessionStorage.setItem('outboundFareQuoteData', JSON.stringify(outboundData.fareQuote));
            
            // Second fare quote call for return flight
            return fetch('/flight/fareQutes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(returnPayload)
            });
        } else {
            throw new Error('Outbound fare quote failed');
        }
    })
    .then(response => response.json())
    .then(returnData => {
        if (returnData.success) {
            // Store return fare quote data
            sessionStorage.setItem('returnFareQuoteData', JSON.stringify(returnData.fareQuote));

            // Get flight details for both flights
            const selectedFlights = {
                outbound: null,
                return: null
            };

           // Find outbound flight details
outboundFlights.forEach(outbound => {
    if (outbound.FareDataMultiple && Array.isArray(outbound.FareDataMultiple)) {
        outbound.FareDataMultiple.forEach(fareData => {
            if (fareData.ResultIndex === outboundResultIndex) {
                selectedFlights.outbound = {
                    isLCC: fareData.IsLCC,
                    airlineName: fareData.FareSegments[0]?.AirlineName,
                    flightNumber: fareData.FareSegments[0]?.FlightNumber,
                    cabinClass: fareData.FareSegments[0]?.CabinClassName,
                    fare: fareData.Fare?.OfferedFare,
                    origin: outbound.Segments?.[0]?.[0]?.Origin?.AirportCode,
                    destination: outbound.Segments?.[0]?.[0]?.Destination?.AirportCode
                };
            }
        });
    }
});

// Find return flight details
returnFlights.forEach(returnFlight => {
    if (returnFlight.FareDataMultiple && Array.isArray(returnFlight.FareDataMultiple)) {
        returnFlight.FareDataMultiple.forEach(fareData => {
            if (fareData.ResultIndex === returnResultIndex) {
                selectedFlights.return = {
                    isLCC: fareData.IsLCC,
                    airlineName: fareData.FareSegments[0]?.AirlineName,
                    flightNumber: fareData.FareSegments[0]?.FlightNumber,
                    cabinClass: fareData.FareSegments[0]?.CabinClassName,
                    fare: fareData.Fare?.OfferedFare,
                    origin: returnFlight.Segments?.[0]?.[0]?.Origin?.AirportCode,
                    destination: returnFlight.Segments?.[0]?.[0]?.Destination?.AirportCode
                };
            }
        });
    }
});

                // Check if both flight details were found
if (!selectedFlights.outbound || !selectedFlights.return) {
    console.error('Could not find details for one or both flights');
    alert('Error: Could not find complete flight details.');
    return;
}

           
// Store indices
sessionStorage.setItem('selectedOutboundIndex', outboundResultIndex);
sessionStorage.setItem('selectedReturnIndex', returnResultIndex);

// Redirect with both flight details
window.location.href = `/flight-booking?traceId=${traceId}&outboundIndex=${outboundResultIndex}&returnIndex=${returnResultIndex}&details=${encodeURIComponent(JSON.stringify(selectedFlights))}`;
        } else {
            throw new Error('Return fare quote failed');
        }
    })
    .catch(error => {
        console.error('Error in fare quotes:', error);
        alert('An error occurred while processing flight details.');
    });
}



function viewFlightDetails(resultIndex) {
    const traceId = sessionStorage.getItem('flightTraceId');
    const results = JSON.parse(sessionStorage.getItem('flightSearchResults')) || [];

    if (!traceId) {
        console.error('TraceId is not found in sessionStorage');
        return;
    }

    // Find the SrdvIndex and detailed flight information
    let srdvIndex = null;
    let selectedFlight = null;

    results.forEach(resultGroup => {
        resultGroup.forEach(result => {
            if (result.FareDataMultiple) {
                result.FareDataMultiple.forEach(fareData => {
                    if (fareData.ResultIndex === resultIndex) {
                        const segment = result.Segments?.[0]?.[0];
                        
                        selectedFlight = {
                            // Basic flight info
                            airlineName: fareData.FareSegments[0]?.AirlineName,
                            airlineCode: fareData.FareSegments[0]?.AirlineCode,
                            flightNumber: fareData.FareSegments[0]?.FlightNumber,
                            cabinClass: fareData.FareSegments[0]?.CabinClassName,
                            fare: fareData.Fare?.PublishedFare,
                            isLCC: fareData.IsLCC,
                            refundable: fareData.IsRefundable,
                            
                            // Origin details
                            originCode: segment?.Origin?.AirportCode,
                            originName: segment?.Origin?.AirportName,
                            originTerminal: segment?.Origin?.Terminal || '',
                            
                            // Destination details
                            destinationCode: segment?.Destination?.AirportCode,
                            destinationName: segment?.Destination?.AirportName,
                            destinationTerminal: segment?.Destination?.Terminal || '',
                            
                            // Flight timing details
                            departureTime: segment?.DepTime,
                            arrivalTime: segment?.ArrTime,
                            duration: segment?.Duration,
                            
                            // Baggage info
                            baggage: fareData.FareSegments[0]?.Baggage,
                            cabinBaggage: segment?.CabinBaggage
                        };
                        
                        srdvIndex = fareData.SrdvIndex;
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

    // Prepare payload for fareQuote API
    const payload = {
        EndUserIp: '1.1.1.1',
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

            // Create the URL with all flight details
            window.location.href = `/flight-booking?traceId=${traceId}&resultIndex=${resultIndex}&details=${encodeURIComponent(JSON.stringify({
                isLCC: selectedFlight.isLCC,
                refundable:selectedFlight.refundable,
                airlineName: selectedFlight.airlineName,
                airlineCode: selectedFlight.airlineCode,
                flightNumber: selectedFlight.flightNumber,
                cabinClass: selectedFlight.cabinClass,
                fare: selectedFlight.fare,
                originCode: selectedFlight.originCode,
                originName: selectedFlight.originName,
                originTerminal: selectedFlight.originTerminal,
                destinationCode: selectedFlight.destinationCode,
                destinationName: selectedFlight.destinationName,
                destinationTerminal: selectedFlight.destinationTerminal,
                departureTime: selectedFlight.departureTime,
                arrivalTime: selectedFlight.arrivalTime,
                duration: selectedFlight.duration,
                baggage: selectedFlight.baggage,
                cabinBaggage: selectedFlight.cabinBaggage
            }))}`;
        } else {
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
                <div class="fare-rules-content">
                    <h2>Fare Rules for Flight</h2>
                    <p><strong>Airline:</strong> ${data.fareRules.Airline}</p>
                    <p><strong>Route:</strong> ${data.fareRules.Origin} to ${data.fareRules.Destination}</p>
                    <p><strong>Fare Basis Code:</strong> ${data.fareRules.FareBasisCode}</p>
                    <div class="fare-rule-details">
                        <h3>Fare Rule Details</h3>
                        <pre>${data.fareRules.FareRuleDetail}</pre>
                    </div>
                </div>
                <div class="modal-actions mt-4">
                    <button onclick="document.getElementById('fareRulesModal').style.display = 'none'" 
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        Close
                    </button>
                </div>
            `;
                } 
                else {
                    fareRulesDetails.innerHTML = `<p>Unable to fetch fare rules: ${data.message || 'Unknown error'}</p>`;
                }
            })
            .catch(error => {
                console.error('Error fetching fare rules:', error);
                fareRulesDetails.innerHTML = `<p>Error fetching fare rules: ${error.message}</p>`;
            });
            fareRulesModal.classList.remove('hidden');
            fareRulesModal.classList.add('flex');
 }
  // Close modal functionality
  document.addEventListener('click', function(event) {
            const fareRulesModal = document.getElementById('fareRulesModal');
            if (event.target === fareRulesModal) {
                fareRulesModal.classList.add('hidden');
                fareRulesModal.classList.remove('flex');
            }
        });
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

                    // calendar fare
                    // calendar fare
    $(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    getCalendarFare();
});

function getCalendarFare() {
    $('#fareResults').html('<div class="text-center p-3"><div class="spinner-border text-primary" role="status"></div><div class="mt-2">Loading calendar fares...</div></div>');
    
    $.ajax({
        url: '{{ route("get.calendar.fare") }}',
        method: 'POST',
        success: function(response) {
            handleCalendarFareResponse(response);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            handleCalendarFareResponse({
                Error: {
                    ErrorCode: 1,
                    ErrorMessage: 'Failed to fetch calendar fares'
                }
            });
        }
    });
}
function handleCalendarFareResponse(response) {
    if (response.Error && response.Error.ErrorCode === 0) {
        if (response.Results && response.Results.length > 0) {
            const fares = response.Results.sort((a, b) => 
                new Date(a.DepartureDate) - new Date(b.DepartureDate));

            let fareDisplay = `
                <div class="bg-white rounded-lg shadow-sm mb-6 relative overflow-hidden">
                    <!-- Scroll Arrows -->
                    <button onclick="scrollFares('left')" 
                            class="absolute left-0 top-0 bottom-0 px-2 bg-gradient-to-r from-white to-transparent z-10 hover:bg-opacity-75 transition-all duration-300 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-800 bg-opacity-20 hover:bg-opacity-30">
                            <i class="fas fa-chevron-left text-white"></i>
                        </div>
                    </button>
                    
                    <button onclick="scrollFares('right')" 
                            class="absolute right-0 top-0 bottom-0 px-2 bg-gradient-to-l from-white to-transparent z-10 hover:bg-opacity-75 transition-all duration-300 flex items-center">
                        <div class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-800 bg-opacity-20 hover:bg-opacity-30">
                            <i class="fas fa-chevron-right text-white"></i>
                        </div>
                    </button>

                    <div id="fareScrollContainer" class="overflow-x-scroll hide-scrollbar">
                        <div class="flex space-x-3 py-3 px-12 min-w-max">
            `;
            
            fares.forEach(fare => {
                const departureDate = new Date(fare.DepartureDate);
                const airlineCode = fare.AirlineCode || '';
                const formattedDate = departureDate.toISOString().split('T')[0]; // Format: YYYY-MM-DD
                
                fareDisplay += `
                    <div class="flex-none w-36 bg-white rounded border border-gray-200 p-2 hover:border-blue-300 transition-colors cursor-pointer"
                         onclick="handleCalendarFareClick('${formattedDate}', ${fare.Fare}, '${airlineCode}', '${fare.AirlineName}')"
                         data-date="${formattedDate}"
                         data-fare="${fare.Fare}"
                         data-airline-code="${airlineCode}"
                         data-airline-name="${fare.AirlineName}">
                        <div class="flex items-center justify-between mb-1">
                            <img src="/assets/images/airlines/airlines/48_48/${airlineCode}.png" 
                                 alt="${fare.AirlineName}"
                                 class="w-6 h-6 object-contain"
                                 onerror="this.onerror=null; this.src='/assets/images/airlines/airlines/48_48/default-airline.png'; this.classList.add('grayscale', 'opacity-70');">
                            <p class="text-base font-bold text-green-600 mt-1">
                                INR-${fare.Fare.toLocaleString()}
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-xs font-medium text-gray-800">
                                ${departureDate.toLocaleDateString('en-US', {
                                    weekday: 'short',
                                    day: 'numeric',
                                    month: 'short'
                                })}
                            </p>
                        </div>
                    </div>
                `;
            });

            fareDisplay += `
                        </div>
                    </div>
                </div>
            `;

            $('#fareResults').html(fareDisplay);
        } else {
            $('#fareResults').html(`
                <div class="bg-white rounded-lg shadow-sm mb-6 p-3">
                    <div class="text-center text-gray-600 text-sm">
                        No available fares found
                    </div>
                </div>
            `);
        }
    } else {
        $('#fareResults').html(`
            <div class="bg-white rounded-lg shadow-sm mb-6 p-3">
                <div class="text-center text-red-600 text-sm">
                    ${response.Error.ErrorMessage || 'An error occurred while fetching fares.'}
                </div>
            </div>
        `);
    }
}
async function handleCalendarFareClick(departureDate, fare, airlineCode, airlineName) {
    try {
        // Show loading overlay
        const loadingOverlay = document.createElement('div');
        loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        loadingOverlay.innerHTML = `
            <div class="bg-white p-6 rounded-lg shadow-xl">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                <p class="text-center mt-4">Searching flights for ${new Date(departureDate).toLocaleDateString()}</p>
            </div>
        `;
        document.body.appendChild(loadingOverlay);

        // Get current URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        
        // Format departure time to required format (using AnyTime)
        const formattedDepartureTime = `${departureDate}T00:00:00`;
        
        // Create search payload
        const searchPayload = {
            EndUserIp: '1.1.1.1',
            ClientId: '180133',
            UserName: 'MakeMy91',
            Password: 'MakeMy@910',
            SrdvType: 'MixAPI',
            FareType: 'PUB',
            Segments: [
                {
                    Origin: urlParams.get('fromCode'),
                    Destination: urlParams.get('toCode'),
                    FlightCabinClass: urlParams.get('cabinClass') || '1',
                    PreferredDepartureTime: formattedDepartureTime,
                    PreferredArrivalTime: formattedDepartureTime
                }
            ],
            From: urlParams.get('fromCode'),
            To: urlParams.get('toCode'),
            PreferredAirlines: airlineCode ? [airlineCode] : [],
            JourneyType: '1',
            DepartureDate: formattedDepartureTime,
            AdultCount: urlParams.get('adults') || '1',
            ChildCount: '0',
            InfantCount: '0',
            CabinClass: urlParams.get('cabinClass') || '1',
            PreferredCurrency: 'INR'
        };

        // Make API call to search flights
        const response = await fetch('/flight/search', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(searchPayload)
        });

        const data = await response.json();

        if (data.success) {
            // Store new search results
            sessionStorage.setItem('flightSearchResults', JSON.stringify(data.results));
            sessionStorage.setItem('flightTraceId', data.traceId);
            
            // Update URL parameters
            urlParams.set('departureDate', departureDate);
            const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
            window.history.pushState({ path: newUrl }, '', newUrl);
            
            // Update page content without reload
            location.reload(); // Reload the page to ensure all components are properly updated
        } else {
            throw new Error(data.message || 'No flights found for the selected date.');
        }
    } catch (error) {
        console.error('Error searching flights:', error);
        alert(error.message || 'An error occurred while searching for flights.');
    } finally {
        // Remove loading overlay
        const overlay = document.querySelector('.fixed.inset-0');
        if (overlay) {
            overlay.remove();
        }
    }
}
// Helper function to update search results without page reload
function updateSearchResults(results, traceId) {
    // Re-initialize filters with new results
    const filters = extractAdvancedFilters(results);
    createFilterSections(filters);
    
    // Re-render results
    renderFilteredResults(results);
}

// Helper function to get updated header HTML
function getUpdatedHeaderHTML(urlParams) {
    const from = urlParams.get('from').split('(')[0].trim();
    const to = urlParams.get('to').split('(')[0].trim();
    const fromCode = urlParams.get('fromCode');
    const toCode = urlParams.get('toCode');
    const departureDate = urlParams.get('departureDate');
    const adults = urlParams.get('adults');
    const cabinClass = urlParams.get('cabinClass');

    const cabinClassMap = {
        '1': 'Economy',
        '2': 'Premium Economy',
        '3': 'Business',
        '4': 'First Class'
    };

    return `
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
}
function scrollFares(direction) {
    const container = document.getElementById('fareScrollContainer');
    if (!container) return;

    const scrollAmount = 300; // Adjust this value to control scroll distance
    const currentScroll = container.scrollLeft;
    
    // Calculate the new scroll position
    const newScroll = direction === 'left' 
        ? Math.max(0, currentScroll - scrollAmount)
        : Math.min(
            container.scrollWidth - container.clientWidth,
            currentScroll + scrollAmount
          );
    
    container.scrollTo({
        left: newScroll,
        behavior: 'smooth'
    });
    
    // Update arrow visibility
    updateArrowVisibility(container);
}
function updateArrowVisibility(container) {
    if (!container) return;
    
    const leftArrow = container.parentElement.querySelector('[onclick="scrollFares(\'left\')"]');
    const rightArrow = container.parentElement.querySelector('[onclick="scrollFares(\'right\')"]');
    
    if (leftArrow) {
        leftArrow.style.opacity = container.scrollLeft <= 0 ? '0.5' : '1';
    }
    
    if (rightArrow) {
        rightArrow.style.opacity = 
            Math.ceil(container.scrollLeft + container.clientWidth) >= container.scrollWidth 
                ? '0.5' 
                : '1';
    }
}
// Add scroll event listener to update arrow visibility during scrolling
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('fareScrollContainer');
    if (container) {
        container.addEventListener('scroll', () => updateArrowVisibility(container));
        // Initial arrow visibility check
        updateArrowVisibility(container);
    }
});
document.addEventListener('DOMContentLoaded', function() {
    // Add mobile filter toggle button to the top of results section
    const resultsSection = document.querySelector('.md\\:col-span-3');
    const filterToggleButton = document.createElement('button');
    filterToggleButton.className = 'md:hidden fixed bottom-4 right-4 bg-blue-600 text-white p-3 rounded-full shadow-lg z-30';
    filterToggleButton.innerHTML = '<i class="fas fa-filter"></i>';
    document.body.appendChild(filterToggleButton);

    // Add close button to filter section
    const filterSection = document.querySelector('.filter-section');
    const closeButton = document.createElement('button');
    closeButton.className = 'absolute top-4 right-4 text-gray-600 md:hidden';
    closeButton.innerHTML = '<i class="fas fa-times text-xl"></i>';
    filterSection.insertBefore(closeButton, filterSection.firstChild);

    // Get overlay element
    const overlay = document.getElementById('filter-overlay');

    // Toggle filter visibility
    function toggleFilter() {
        filterSection.classList.toggle('show');
        overlay.classList.toggle('show');
        document.body.style.overflow = filterSection.classList.contains('show') ? 'hidden' : '';
    }

    // Event listeners
    filterToggleButton.addEventListener('click', toggleFilter);
    closeButton.addEventListener('click', toggleFilter);
    overlay.addEventListener('click', toggleFilter);

    // Close filter on window resize if it goes above mobile breakpoint
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768 && filterSection.classList.contains('show')) {
            filterSection.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }
    });
});
    </script>
    @endsection