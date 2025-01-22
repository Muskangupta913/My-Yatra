<!-- Include jQuery from CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Include Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@extends('frontend.layouts.master')

@section('content')
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        header,
        footer {
            padding: 0;
            background-color: #f8f9fa;
            margin-bottom: 20px;
        }

        .container {
            margin-top: 20px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            margin-bottom: 10px;
        }

        .sidebar {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .sidebar h4 {
            margin-bottom: 15px;
        }

        .sidebar .card {
            margin-bottom: 15px;
        }

        .card:hover {
            transform: scale(1.02);
            transition: transform 0.2s ease-in-out;
        }

        .airline-logo {
            width: 30px;
            margin-right: 20px;
            vertical-align: middle;
        }

        @media (max-width: 768px) {

            .form-label,
            .btn {
                font-size: 14px;
            }

            .sidebar {
                margin-top: 20px;
            }
        }

        @media (max-width: 576px) {
            .sidebar h4 {
                font-size: 18px;
            }
        }

        #flightFromCityList,
        #flightToCityList {
            display: none;
            position: absolute;
            width: 100%;
            max-height: 150px;
            overflow-y: auto;
            z-index: 1000;
        }

        .flight-path {
            padding: 10px 0;
        }

        .flight-path .border-top {
            position: absolute;
            width: 100%;
            top: 50%;
            border-top: 1px dashed #ccc;
            z-index: 1;
        }

        .flight-path i {
            position: relative;
            z-index: 2;
            background: white;
            padding: 0 10px;
            color: #0d6efd;
        }

        .airline-logo {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .card:hover {
            cursor: pointer;
        }

        .price {
            color: #0d6efd;
        }

        @media (max-width: 768px) {
            .flight-times {
                flex-direction: column;
                align-items: flex-start;
            }

            .price {
                text-align: left;
                margin-top: 1rem;
            }
        }

        .flight-details {
            font-size: 0.9rem;
            color: #666;
            margin-left: 10px;
        }

        .flight-details div {
            margin-bottom: 5px;
        }

        .baggage-icons i {
            margin-right: 15px;
            color: #0d6efd;
        }

        .fa-arrow-right {
            color: #0d6efd;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            background-color: #fff;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .card-body {
            padding: 20px;
            position: relative;
        }

        .card-title {
            font-size: 1.25rem;
            color: #333;
            margin-bottom: 10px;
            text-transform: capitalize;
        }

        .price {
            color: #007bff;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .flight-details {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 8px;
        }

        .baggage-info-container {
            position: absolute;
            top: 0;
            left: 0;
            padding: 10px;
        }

        .baggage-icons i {
            margin-left: 95%;
            margin-top: 10px;
        }

        .class-info {
            margin-top: 5px;
        }

        button {
            padding: 10px 15px;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        .alert {
            margin: 20px 0;
            padding: 15px;
            font-size: 1rem;
            border-radius: 5px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeIn 0.6s ease;
        }

        .card-body {
            animation: fadeIn 0.4s ease;
        }

        .flight-details,
        .baggage-icons,
        .price {
            animation: fadeIn 0.8s ease;
        }

        button {
            animation: fadeIn 1s ease;
        }

        /* Form Styling */
        .trip-type .btn {
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
        }

        .btn-check:checked+.btn-outline-light {
            background-color: #ffc107;
            color: #000;
            border-color: #ffc107;
        }

        .form-floating {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-floating>.form-control,
        .form-floating>.form-select {
            height: 60px;
            padding: 1rem 0.75rem;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .form-floating>.form-select {
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }

        .form-floating>label {
            padding: 1rem 0.75rem;
            color: #666;
        }

        .search-btn {
            height: 60px;
            font-size: 1.2rem;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease;
            background: linear-gradient(45deg, #ffc107, #ffab00);
            border: none;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.2);
        }

        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.3);
            background: linear-gradient(45deg, #ffab00, #ff9100);
        }

        .search-btn:active {
            transform: translateY(0);
        }

        .dropdown-menu {
            max-height: 200px;
            overflow-y: auto;
            background-color: rgba(255, 255, 255, 0.95);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
            animation: fadeIn 0.3s ease;
        }

        /* Dark theme adjustments */
        .bg-dark {
            background: linear-gradient(135deg, #1a1a1a, #2d2d2d) !important;
        }

        .searchline {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 1.5rem 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {

            .form-floating>.form-control,
            .form-floating>.form-select,
            .search-btn {
                height: 50px;
            }

            .trip-type .btn {
                padding: 0.5rem 1.5rem;
            }
        }

        /* calendar Fare */
        .fare-tag {
            display: block;
            margin-top: 5px;
        }
    </style>


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Flight Search -->
    <div class="container bg-dark text-white p-4 rounded">
        <h4 class="mb-4">Book Flights</h4>
        <hr class="searchline">
        <form id="flightSearchForm">
            <!-- Trip Type Selection -->
            <div class="trip-type mb-4">
                <div class="btn-group" role="group" aria-label="Trip Type">
                    <input type="radio" class="btn-check" name="tripType" id="oneway" value="oneway" checked>
                    <label class="btn btn-outline-light rounded-start" for="oneway">One Way</label>
                    <input type="radio" class="btn-check" name="tripType" id="roundtrip" value="roundtrip">
                    <label class="btn btn-outline-light rounded-end" for="roundtrip">Round Trip</label>
                </div>
            </div>

            <!-- Flight Details -->
            <div class="row g-3 mb-4">
                <!-- From City -->
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="fromCity" id="flightFromCity" placeholder="From"
                            required>
                        <label for="flightFromCity">From</label>
                        <div id="flightFromCityList" class="dropdown-menu w-100"></div>
                    </div>
                </div>

                <!-- To City -->
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" name="toCity" id="flightToCity" placeholder="To"
                            required>
                        <label for="flightToCity">To</label>
                        <div id="flightToCityList" class="dropdown-menu w-100"></div>
                    </div>
                </div>

                <!-- Departure Date -->
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control datepicker" name="departure_date" id="flightDepartureDate"
                            placeholder="Departure Date" required>
                        <label for="flightDepartureDate">Departure Date</label>
                    </div>
                </div>

                <!-- Return Date -->
                <div class="col-md-3">
                    <div class="form-floating return-date">
                        <input type="text" class="form-control datepicker" name="return_date" id="flightReturnDate"
                            placeholder="Return Date">
                        <label for="flightReturnDate">Return Date</label>
                    </div>
                </div>
            </div>

            <!-- Passengers and Class -->
            <div class="row g-3 mb-4">
                <!-- Adults -->
                <div class="col-md-2">
                    <div class="form-floating">
                        <select class="form-select" name="adults" id="adults">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                        <label for="adults">Adult(s)</label>
                    </div>
                </div>

                <!-- Children -->
                <div class="col-md-2">
                    <div class="form-floating">
                        <select class="form-select" name="children" id="children">
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                        <label for="children">Child(ren)</label>
                    </div>
                </div>

                <!-- Infants -->
                <div class="col-md-2">
                    <div class="form-floating">
                        <select class="form-select" name="infants" id="infants">
                            <option value="0">0</option>
                            <option value="1">1</option>
                        </select>
                        <label for="infants">Infant(s)</label>
                    </div>
                </div>

                <!-- Class -->
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" name="class" id="class">
                            <option value="1">Economy</option>
                            <option value="2">Premium Economy</option>
                            <option value="3">Business</option>
                            <option value="4">First Class</option>
                        </select>
                        <label for="class">Class</label>
                    </div>
                </div>

                <!-- Fare Type -->
                <div class="col-md-3">
                    <div class="form-floating">
                        <select class="form-select" name="fareType" id="fareType">
                            <option value="1">Regular</option>
                            <option value="2">Student</option>
                            <option value="3">Armed Forces</option>
                            <option value="4">Senior Citizen</option>
                        </select>
                        <label for="fareType">Fare Type</label>
                    </div>
                </div>
            </div>

            <!-- Search Button -->
            <div class="row">
                <div class="col-12">
                    <button type="button" id="searchFlightsBtn" class="btn btn-warning w-30 search-btn">
                        <i class="fas fa-search me-2"></i>Search Flights
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- side bar -->
    <div class="container mt-4">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="sidebar">
                    <h4>Filter Flights</h4>
                    <!-- Airlines Section -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Airlines</h5>
                        </div>
                        <div class="card-body">
                            <label class="form-label">Select Airlines:</label>
                            <div class="list-group">
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="checkbox"> Air India
                                    <img src="{{ asset('assets/images/air.png') }}" class="airline-logo">
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="checkbox" id="airline2">
                                    Indigo
                                    <img src="{{ asset('assets/images/air india.png') }}" class="airline-logo me-2">
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="checkbox" id="airline3">
                                    Air India Express
                                    <img src="{{ asset('assets/images/airindia express.jfif') }}"
                                        class="airline-logo me-2">
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="checkbox" id="airline3">
                                    Spice Jet
                                    <img src="{{ asset('assets/images/spicejet.jpg') }}" class="airline-logo me-2">
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="checkbox" id="airline3">
                                    Akasa Air
                                    <img src="{{ asset('assets/images/akasa air.png') }}" class="airline-logo me-2">
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="checkbox" id="airline3">
                                    GO FIRST
                                    <img src="{{ asset('assets/images/go first.png') }}" class="airline-logo me-2">
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input me-2" type="checkbox" id="airline3">
                                    Vistara
                                    <img src="{{ asset('assets/images/vistara.png') }}" class="airline-logo me-2">
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Price Range Section -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Price Range</h5>
                        </div>
                        <div class="card-body">
                            <label for="priceRange" class="form-label">Select Price Range:</label>
                            <div class="d-flex justify-content-between">
                                <span>₹2000</span>
                                <span>₹10000</span>
                            </div>
                            <input type="range" class="form-range" min="2000" max="10000" step="50"
                                id="priceRange">
                            <p id="priceValue" class="mt-3 text-muted">Selected: <strong>₹2000</strong></p>
                        </div>
                    </div>

                    <!-- Timing Section -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Timing</h5>
                        </div>
                        <div class="card-body">
                            <label class="form-label"><strong>Choose a Timing:</strong></label>
                            <!-- Morning -->
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-sun me-2" style="font-size: 1.5rem; color: #f9c74f;"></i>
                                <label class="form-check-label">
                                    <input class="form-check-input me-2" type="radio" name="timing"
                                        value="morning">Morning(6AM-12PM)
                                </label>
                            </div>

                            <!-- Afternoon -->
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-cloud-sun me-2" style="font-size: 1.5rem; color: #f9844a;"></i>
                                <label class="form-check-label">
                                    <input class="form-check-input me-2" type="radio" name="timing"
                                        value="afternoon">Afternoon(12PM-6PM)
                                </label>
                            </div>

                            <!-- Night -->
                            <div class="d-flex align-items-center">
                                <i class="fas fa-moon me-2" style="font-size: 1.5rem; color: #577590;"></i>
                                <label class="form-check-label">
                                    <input class="form-check-input me-2" type="radio" name="timing"
                                        value="night">Night(6PM-12AM)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- side bar close -->

            <!-- Main Content -->
            <div class="col-lg-9 col-md-8">
                <div class="flight-results">
                    <!-- Flight results will be inserted here dynamically -->
                </div>
            </div>

            <script>
                // form
                document.addEventListener('DOMContentLoaded', function() {
                    // Trip type toggle functionality
                    const tripTypeRadios = document.querySelectorAll('input[name="tripType"]');
                    const returnDateInput = document.querySelector('.return-date');

                    tripTypeRadios.forEach(radio => {
                        radio.addEventListener('change', function() {
                            if (this.value === 'oneway') {
                                returnDateInput.style.display = 'none';
                                document.getElementById('flightReturnDate').removeAttribute('required');
                            } else {
                                returnDateInput.style.display = 'block';
                                document.getElementById('flightReturnDate').setAttribute('required',
                                    'required');
                            }
                        });
                    });

                    // Initialize with oneway selected
                    if (document.getElementById('oneway').checked) {
                        returnDateInput.style.display = 'none';
                    }

                    // Initialize flatpickr for date inputs if available
                    // Initialize calendar fares map
                let calendarFares = new Map();

// Helper function to format price
function formatPrice(price) {
    return '₹' + Math.round(price).toLocaleString('en-IN');
}

// Fetch calendar fares from API
async function fetchCalendarFares(origin, destination, date) {
    const payload = {
        EndUserIp: "1.1.1.1",
        ClientId: "180133",
        UserName: "MakeMy91",
        Password: "MakeMy@910",
        JourneyType: "1",
        Sources: null,
        FareType: 2,
        Segments: [{
            Origin: origin,
            Destination: destination,
            FlightCabinClass: "1",
            PreferredDepartureTime: date + "T00:00:00",
            PreferredArrivalTime: date + "T00:00:00"
        }]
    };

    try {
        const response = await fetch("https://flight.srdvtest.com/v8/rest/GetCalendarFare", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "API-Token": "MakeMy@910@23"
            },
            body: JSON.stringify(payload)
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        return processCalendarData(data);
    } catch (error) {
        console.error("Error fetching calendar fares:", error);
        return null;
    }
}

// Process calendar data
function processCalendarData(data) {
    if (!data || !data.Results) return new Map();

    const fareMap = new Map();
    data.Results.forEach(flight => {
        const date = new Date(flight.DepartureDate).toISOString().split('T')[0];
        const currentFare = fareMap.get(date);
        if (!currentFare || flight.Fare < currentFare) {
            fareMap.set(date, flight.Fare);
        }
    });
    return fareMap;
}

// Initialize flatpickr with calendar fares
function initializeCalendarWithFares() {
    const departureInput = document.getElementById('flightDepartureDate');
    const returnInput = document.getElementById('flightReturnDate');

    // Common flatpickr config
    const flatpickrConfig = {
        dateFormat: "d-m-Y",
        minDate: "today",
        defaultDate: 'today',
        onMonthChange: async function(selectedDates, dateStr, instance) {
            const month = instance.currentMonth;
            const year = instance.currentYear;
            await updateCalendarFares(instance, month, year);
        },
        onYearChange: async function(selectedDates, dateStr, instance) {
            const month = instance.currentMonth;
            const year = instance.currentYear;
            await updateCalendarFares(instance, month, year);
        },
        onDayCreate: function(dObj, dStr, fp, dayElem) {
            const dateStr = dayElem.dateObj.toISOString().split('T')[0];
            const fare = calendarFares.get(dateStr);

            if (fare) {
                const fareDiv = document.createElement('div');
                fareDiv.className = 'calendar-fare';
                fareDiv.innerHTML = formatPrice(fare);
                dayElem.appendChild(fareDiv);
            }
        }
    };

    // Initialize departure datepicker
    if (departureInput) {
        flatpickr(departureInput, {
            ...flatpickrConfig,
            onChange: function(selectedDates) {
                if (returnInput) {
                    returnFlatpickr.set('minDate', selectedDates[0]);
                }
            }
        });
    }

    // Initialize return datepicker if exists
    let returnFlatpickr;
    if (returnInput) {
        returnFlatpickr = flatpickr(returnInput, {
            ...flatpickrConfig,
            minDate: departureInput.value ? new Date(departureInput.value) : "today"
        });
    }
}

// Update calendar fares for a specific month
async function updateCalendarFares(instance, month, year) {
    const firstDay = new Date(year, month, 1);
    const origin = document.querySelector('[name="origin"]').value || 'DEL';
    const destination = document.querySelector('[name="destination"]').value || 'BOM';

    const fares = await fetchCalendarFares(origin, destination, firstDay.toISOString().split('T')[0]);
    if (fares) {
        calendarFares = fares;
        instance.redraw();
    }
}

// Add custom styles for calendar fares
const styleSheet = document.createElement('style');
styleSheet.textContent = `
.calendar-fare {
font-size: 10px;
color: #0066cc;
text-align: center;
margin-top: 2px;
}
.flatpickr-day {
height: auto !important;
padding-bottom: 5px !important;
}
`;
document.head.appendChild(styleSheet);

// Initialize when document is ready
document.addEventListener('DOMContentLoaded', initializeCalendarWithFares);

                });
               
                // form close 
                $(document).ready(function() {
                    function fetchAirports(inputId, listId) {
                        $(inputId).on('keyup', function() {
                            let query = $(this).val();
                            if (query.length > 1) {
                                $.ajax({
                                    url: '{{ route('fetch.airports') }}',
                                    method: 'GET',
                                    data: {
                                        query: query
                                    },
                                    success: function(response) {
                                        let suggestions = '';
                                        response.forEach(function(airport) {
                                            suggestions += `
                                    <a href="#" class="dropdown-item airport-option"
                                       data-value="${airport.airport_city_name} (${airport.airport_name}) (${airport.airport_code})"
                                       data-target="${inputId}">
                                       ${airport.airport_city_name} (${airport.airport_name}) (${airport.airport_code})
                                    </a>`;
                                        });
                                        $(listId).html(suggestions).fadeIn().show();
                                    },
                                    error: function() {
                                        console.error('Error fetching airports.');
                                    }
                                });
                            } else {
                                $(listId).fadeOut().empty();
                            }
                        });
                        $(document).on('click', '.airport-option', function(e) {
                            e.preventDefault();
                            let selectedValue = $(this).data('value');
                            let targetInput = $(this).data('target');
                            $(targetInput).val(selectedValue);
                            $(listId).fadeOut().empty();
                        });

                        $(document).click(function(e) {
                            if (!$(e.target).closest(inputId).length && !$(e.target).closest(listId).length) {
                                $(listId).fadeOut().empty();
                            }
                        });
                    }

                    fetchAirports('#flightFromCity', '#flightFromCityList');
                    fetchAirports('#flightFromCityCode', '#flightFromCityListCode');
                    fetchAirports('#flightToCity', '#flightToCityList');
                    fetchAirports('#flightToCityCode', '#flightToCityListCode');
                    const adultCount = document.getElementById("adults").value;
                    const childCount = document.getElementById("children").value;
                    const infantCount = document.getElementById("infants").value;
                    const flightClass = document.getElementById("class").value; // Flight cabin class
                    const fareType = document.getElementById("fareType").value;

                    document.querySelectorAll('input[name="tripType"]').forEach(radio => {
                        radio.addEventListener('change', handleTripTypeChange);
                    });

                    function handleTripTypeChange(event) {
                        const journeyType = event.target.value === 'oneway' ? "1" : "2";
                        createPayload(journeyType);
                    }

                    function createPayload(journeyType) {
                        const fromCityInput = $('#flightFromCity').val();
                        const toCityInput = $('#flightToCity').val();
                        const fromCityCode = fromCityInput.match(/\(([^)]+)\)$/)?.[1] || '';
                        const toCityCode = toCityInput.match(/\(([^)]+)\)$/)?.[1] || '';
                        const fromCityName = fromCityInput.split('(')[0].trim();
                        const toCityName = toCityInput.split('(')[0].trim();

                        const departureDate = $('#flightDepartureDate').val();
                        const returnDate = $('#flightReturnDate').val();

                        const formattedDepartureDate = departureDate ?
                            departureDate.split('-').reverse().join('-') + 'T00:00:00' :
                            '2025-03-08T00:00:00';

                        const formattedReturnDate = returnDate ?
                            returnDate.split('-').reverse().join('-') + 'T00:00:00' :
                            formattedDepartureDate;

                        const payload = journeyType === "1" ? {
                            ClientId: "180133",
                            UserName: "MakeMy91",
                            Password: "MakeMy@910",
                            AdultCount: adultCount,
                            ChildCount: childCount,
                            InfantCount: infantCount,
                            JourneyType: journeyType,
                            FareType: fareType,
                            Segments: [{
                                Origin: fromCityCode,
                                Destination: toCityCode,
                                FromCityName: fromCityName,
                                ToCityName: toCityName,
                                FlightCabinClass: flightClass,
                                PreferredDepartureTime: formattedDepartureDate,
                                PreferredArrivalTime: formattedDepartureDate
                            }]
                        } : {
                            EndUserIp: "1.1.1.1",
                            ClientId: "180133",
                            UserName: "MakeMy91",
                            Password: "MakeMy@910",
                            AdultCount: adultCount,
                            ChildCount: childCount,
                            InfantCount: infantCount,
                            JourneyType: journeyType,
                            Segments: [{
                                    Origin: fromCityCode,
                                    Destination: toCityCode,
                                    FromCityName: fromCityName,
                                    ToCityName: toCityName,
                                    FlightCabinClass: flightClass,
                                    PreferredDepartureTime: formattedDepartureDate,
                                    PreferredArrivalTime: formattedDepartureDate
                                },
                                {
                                    Origin: toCityCode,
                                    Destination: fromCityCode,
                                    FromCityName: toCityName,
                                    ToCityName: fromCityName,
                                    FlightCabinClass: flightClass,
                                    PreferredDepartureTime: formattedReturnDate,
                                    PreferredArrivalTime: formattedReturnDate
                                }
                            ]
                        };

                        console.log('Payload created:', payload);
                        return payload;
                    }

                    // Initialize default trip type
                    document.addEventListener('DOMContentLoaded', () => {
                        const defaultTripType = document.querySelector('input[name="tripType"]:checked').value;
                        const defaultJourneyType = defaultTripType === 'oneway' ? "1" : "2";
                        createPayload(defaultJourneyType);
                    });

                    // Modify the search button click handler to use the new payload creation
                    $('#searchFlightsBtn').on('click', function(e) {
                        e.preventDefault();
                        const tripType = document.querySelector('input[name="tripType"]:checked').value;
                        const journeyType = tripType === 'oneway' ? "1" : "2";
                        const payload = createPayload(journeyType);

                        fetch('/flights/search', {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                    "Accept": "application/json",
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify(payload)
                            })
                            .then(response => response.json())
                            .then(data => {
                                // ... (keeping existing response handling code)
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                $('.flight-results').html(
                                    '<div class="alert alert-danger">Something went wrong. Please try again later.</div>'
                                );
                            });
                    });

                    // calendar fare
                    async function fetchCalendarFare() {
                        try {
                            const response = await fetch('https://flight.srdvtest.com/v8/rest/GetCalendarFare', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    EndUserIp: "1.1.1.1",
                                    ClientId: "180133",
                                    UserName: "MakeMy91",
                                    Password: "MakeMy@910",
                                    JourneyType: "1",
                                    Sources: null,
                                    FareType: fareType,
                                    Segments: [{
                                        Origin: fromCityCode,
                                        Destination: toCityCode,
                                        FromCityName: fromCityName,
                                        ToCityName: toCityName,
                                        FlightCabinClass: flightClass,
                                        PreferredDepartureTime: formattedDepartureDate,
                                        PreferredArrivalTime: formattedDepartureDate
                                    }]
                                })
                            });

                            if (!response.ok) {
                                throw new Error('Failed to fetch calendar fare data');
                            }

                            const data = await response.json();
                            if (data.Error.ErrorCode !== 0) {
                                console.error('API Error:', data.Error.ErrorMessage);
                                return [];
                            }

                            // Map fares to dates
                            return data.Results.map(result => ({
                                date: result.DepartureDate.split('T')[0], // Format as YYYY-MM-DD
                                fare: result.Fare
                            }));
                        } catch (error) {
                            console.error('Error fetching calendar fare:', error);
                            return [];
                        }
                    }

                    // Initialize Flatpickr with fare overlay
                    async function initializeFlatpickr() {
                        const fares = await fetchCalendarFare();

                        flatpickr('.datepicker', {
                            dateFormat: 'd-m-Y',
                            minDate: "today",
                            defaultDate: 'today',
                            onReady(selectedDates, dateStr, instance) {
                                overlayFares(instance, fares);
                            },
                            onChange(selectedDates, dateStr, instance) {
                                overlayFares(instance, fares);
                            }
                        });
                    }

                    // Function to overlay fares on the calendar
                    function overlayFares(instance, fares) {
                        const calendarDays = instance.calendarContainer.querySelectorAll('.flatpickr-day');
                        calendarDays.forEach(day => {
                            const date = day.dateObj.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                            const fare = fares.find(f => f.date === date)?.fare;
                            if (fare) {
                                const fareTag = document.createElement('span');
                                fareTag.className = 'fare-tag';
                                fareTag.style.fontSize = '12px';
                                fareTag.style.color = '#ff5722';
                                fareTag.textContent = `₹${fare.toFixed(2)}`;
                                day.appendChild(fareTag);
                            }
                        });
                    }

                    // Initialize the date pickers
                    initializeFlatpickr();
                    // calendar fare close
                    // Handle the flight search button click
                    $('#searchFlightsBtn').on('click', function(e) {
                        e.preventDefault();
                        // Get the city codes from the input values
                        const fromCityInput = $('#flightFromCity').val();
                        const toCityInput = $('#flightToCity').val();
                        // Extract airport codes from the inputs (assuming format "City (Airport) (CODE)")
                        const fromCityCode = fromCityInput.match(/\(([^)]+)\)$/)?.[1] || '';
                        const toCityCode = toCityInput.match(/\(([^)]+)\)$/)?.[1] || '';
                        // Extract city names (everything before the first parenthesis)
                        const fromCityName = fromCityInput.split('(')[0].trim();
                        const toCityName = toCityInput.split('(')[0].trim();
                        const departureDate = $('#flightDepartureDate').val();
                        const formattedDepartureDate = departureDate ?
                            departureDate.split('-').reverse().join('-') + 'T00:00:00' :
                            '2025-03-08T00:00:00';

                        // Store formatted dates in variables to use in display
                        const departureDateForDisplay = new Date(formattedDepartureDate).toLocaleDateString(
                            'en-IN', {
                                day: '2-digit',
                                month: 'short',
                                year: 'numeric'
                            });

                        const payload = {
                            ClientId: "180133",
                            UserName: "MakeMy91",
                            Password: "MakeMy@910",
                            AdultCount: adultCount,
                            ChildCount: childCount,
                            InfantCount: infantCount,
                            JourneyType: "1",
                            FareType: fareType,
                            Segments: [{
                                Origin: fromCityCode,
                                Destination: toCityCode,
                                FromCityName: fromCityName,
                                ToCityName: toCityName,
                                FlightCabinClass: flightClass,
                                PreferredDepartureTime: formattedDepartureDate,
                                PreferredArrivalTime: formattedDepartureDate
                            }]
                        };

                        console.log('Sending payload:', payload);

                        fetch('/flights/search', {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                                    "Accept": "application/json",
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify(payload)
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    $('#successMessage').show();
                                    $('.flight-results').empty();
                                    data.flights.forEach(flightGroup => {
                                        flightGroup.FareDataMultiple.forEach(flight => {
                                            // Then in the display section:
                                            const segments = flight.FareSegments.map(segment => `
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-2">
                       <strong>${segment.FromCityName || fromCityName}</strong>
                <i class="fas fa-arrow-right mx-3"></i>
                <strong>${segment.ToCityName || toCityName} </strong>
                    </div>
                    <div class="flight-details">
                         <div>Flight: ${segment.AirlineCode} ${segment.AirlineName}</div>
                  <div>Departure: ${segment.DepTime}</div>
                    <div>Arrival: ${segment.ArrTime}</div>
                    </div>
                <div class="baggage-icons">
                    <i class="fas fa-suitcase" title="Baggage: ${segment.Baggage}"></i>
                    <i class="fas fa-briefcase" title="Cabin Baggage: ${segment.CabinBaggage}"></i>
                </div>
                <div>Class: ${segment.CabinClass || "Economy"}</div>
            </div>
                </div>
            `).join("");
                                            const cardHtml = `
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <h5 class="card-title">${flight.AirlineRemark} </h5>
                                                <p class="price fw-bold">Price: ₹${flight.OfferedFare}</p>
                                              <div class="flight-segments">
                                           
                                ${segments}
                               <div class="fare-rule mt-3">
    <button 
    class="btn btn-link text-primary fare-rule-btn" 
    type="button" 
    data-bs-toggle="collapse" 
    data-bs-target="#fareRule${flight.Id}" 
    aria-expanded="false" 
    aria-controls="fareRule${flight.Id}" 
    data-trace-id="${flight.TraceId}" 
    data-result-index="${flight.ResultIndex}">
    <i class="fas fa-info-circle"></i> Fare Rule
</button>
<div class="collapse mt-2" id="fareRule${flight.Id}">
    <div class="card card-body fare-rule-content">
        <!-- Fare Rule content will be loaded here -->
        Loading fare rule details...
    </div>
</div>

                               <a href="/flight-booking" class="btn btn-primary mt-3" id="bookNowButton">Book Now</a>
                            </div>
                                               
                                            </div>
                                        </div>`;
                                            $('.flight-results').append(cardHtml);
                                        });
                                    });
                                } else {
                                    $('#successMessage').hide();
                                    $('.flight-results').html(
                                        '<div class="alert alert-danger">No flights found.</div>');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                $('.flight-results').html(
                                    '<div class="alert alert-danger">Something went wrong. Please try again later.</div>'
                                );
                            });
                    });
                });
            </script>
            <!-- fare rule  -->
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Handle fare rule button clicks
                    document.addEventListener("click", function(e) {
                        if (e.target.closest(".fare-rule-btn")) {
                            const button = e.target.closest(".fare-rule-btn");
                            handleFareRuleClick(button);
                        }
                    });
                });

                async function handleFareRuleClick(button) {
                    const traceId = button.dataset.traceId;
                    const resultIndex = button.dataset.resultIndex;
                    const fareRuleContent = button.nextElementSibling.querySelector(".fare-rule-content");

                    // Don't reload if already loaded
                    if (fareRuleContent.dataset.loaded === "true") return;

                    try {
                        // Show loading state
                        fareRuleContent.innerHTML = '<div class="spinner-border text-primary" role="status">' +
                            '<span class="visually-hidden">Loading...</span></div>';

                        const response = await fetchFareRule(traceId, resultIndex);

                        if (response.Error && response.Error.ErrorCode !== 0) {
                            throw new Error(response.Error.ErrorMessage || 'Failed to fetch fare rule');
                        }

                        if (response.SpecialRule) {
                            fareRuleContent.innerHTML = sanitizeHTML(response.SpecialRule);
                            fareRuleContent.dataset.loaded = "true";
                        } else {
                            fareRuleContent.innerHTML = "No fare rule details available.";
                        }
                    } catch (error) {
                        console.error("Error fetching fare rule:", error);
                        fareRuleContent.innerHTML =
                            '<div class="alert alert-danger">Error loading fare rule. Please try again later.</div>';
                    }
                }

                async function fetchFareRule(traceId, resultIndex) {
                    const payload = {
                        EndUserIp: "1.1.1.1",
                        ClientId: "180133",
                        UserName: "MakeMy91",
                        Password: "MakeMy@910",
                        SrdvType: "MixAPI",
                        SrdvIndex: "1",
                        TraceId: "173785",
                        ResultIndex: "OB2_0_0"
                    };

                    const response = await fetch("https://flight.srdvtest.com/v8/rest/FareRule", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "API-Token": "MakeMy@910@23"
                        },
                        body: JSON.stringify(payload)
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    return await response.json();
                }

                // Simple HTML sanitizer to prevent XSS
                function sanitizeHTML(html) {
                    const div = document.createElement('div');
                    div.textContent = html;
                    return div.innerHTML;
                }

                // HTML Structure Example:
                /*
                <div class="fare-rule mt-3">
                    <button 
                        class="btn btn-link text-primary fare-rule-btn" 
                        type="button" 
                        data-bs-toggle="collapse" 
                        data-bs-target="#fareRule1" 
                        aria-expanded="false" 
                        aria-controls="fareRule1" 
                        data-trace-id="173785" 
                        data-result-index="OB2_0_0">
                        <i class="fas fa-info-circle"></i> Fare Rule
                    </button>
                    <div class="collapse mt-2" id="fareRule1">
                        <div class="card card-body fare-rule-content">
                            Loading fare rule details...
                        </div>
                    </div>
                </div>
                */
            </script>
            <script>
               // Add this script at the bottom of your flight.blade.php file
// Wait for the document to fully load
document.addEventListener('DOMContentLoaded', function() {
    // Function to handle fare quote API call
    async function handleFareQuote(traceId, resultIndex) {
        const API_URL = 'https://flight.srdvtest.com/v8/rest/FareQuote';
        const API_TOKEN = 'MakeMy@910@23';  // Ensure this is correct
        const requestBody = {
            EndUserIp: '1.1.1.1',
            ClientId: '180133',
            UserName: 'MakeMy91',
            Password: 'MakeMy@910',
            SrdvType: 'MixAPI',
            SrdvIndex: '1',
            TraceId: '173926',
            ResultIndex: 'OB2_0_0'
        };

        try {
            // Make the API POST request
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'API-Token': API_TOKEN
                },
                body: JSON.stringify(requestBody)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            // Check for API errors
            if (data.Error && data.Error.ErrorCode !== 0) {
                throw new Error(data.Error.ErrorMessage || 'API Error occurred');
            }

            return data;
        } catch (error) {
            console.error('Error in fare quote:', error);
            throw error;
        }
    }

    // Add click event listener for all "Book Now" buttons
    document.addEventListener('click', async function(e) {
        if (e.target.classList.contains('book-now-btn')) {
            const button = e.target;
            const traceId = button.dataset.traceId;
            const resultIndex = button.dataset.resultIndex;

            try {
                // Disable button and show loading state
                button.disabled = true;
                const originalText = button.textContent;
                button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';

                // Make the fare quote API call
                const fareQuoteData = await handleFareQuote(traceId, resultIndex);

                // Assuming fareQuoteData contains the fare in the property 'totalFare'
                const totalFare = fareQuoteData.totalFare;

                // Store the fare quote data in session storage for the booking page
                sessionStorage.setItem('fareQuoteData', JSON.stringify(fareQuoteData));

                // Populate the Total Fare input field on the current page
                document.getElementById('totalFare').value = totalFare;

                // Redirect to the booking page
                window.location.href = '/flight-booking';

            } catch (error) {
                // Show error message to user
                alert('Unable to proceed with booking. Please try again.');
                console.error('Booking error:', error);

                // Reset button state
                button.disabled = false;
                button.textContent = originalText;
            }
        }
    });
});

            </script>
        @endsection
