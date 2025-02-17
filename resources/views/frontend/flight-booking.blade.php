@extends('frontend.layouts.master')
@section('title', 'flight booking')
@section('styles')
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2196f3;
            --secondary-color: #1976d2;
            --accent-color: #64b5f6;
            --background-color: #f8f9fa;
        }

        .container {
            max-width: 1200px;
        }

        .booking-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            border-radius: 10px 10px 0 0;
            margin-bottom: 0;
        }

        .booking-header h4 {
            margin: 0;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .booking-header h4:before {
            content: '✈️';
            font-size: 2rem;
        }

        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-bottom: 2rem;
            background: white;
        }

        .card-header {
            background: white;
            border-bottom: 2px solid #e0e0e0;
            padding: 1.5rem;
        }

        .card-header h6 {
            color: var(--secondary-color);
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #424242;
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.75rem;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
        }

        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #90caf9;
            border: none;
            color: #1565c0;
        }

        .btn-secondary:hover {
            background: #64b5f6;
        }

        .option-selection {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        #options-container {
            background: #f5f5f5;
            border-radius: 8px;
            padding: 1.5rem;
        }

        .meal-options-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .meal-option {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
        }

        .meal-option:hover {
            border-color: var(--accent-color);
            transform: translateY(-2px);
        }

        .plane {
            max-width: 400px;
            background: #f5f5f5;
            border-radius: 10px;
            padding: 1.5rem;
        }

        .cockpit {
            background: linear-gradient(135deg, #1565c0, #0d47a1);
            padding: 1rem;
            border-radius: 10px 10px 0 0;
        }

        .seat {
            width: 45px;
            height: 45px;
            background: var(--primary-color);
            border-radius: 8px;
            margin: 0.5rem;
            font-weight: 600;
        }

        .seat:hover {
            background: var(--secondary-color);
            transform: scale(1.05);
        }

        .seat.selected {
            background: #f44336;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 10px;
            }

            .booking-header {
                padding: 1.5rem;
            }

            .card-body {
                padding: 1rem;
            }

            .option-selection {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        .table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        .table th {
            background: #e3f2fd;
            color: var(--secondary-color);
        }

        #submitButton {
            width: 100%;
            max-width: 300px;
            margin: 2rem auto;
            display: block;
            font-size: 1.2rem;
            padding: 1rem;
        }
        
        .seat-map-modal {
            z-index: 1060;
        }

        .seat-map-popup {
            max-width: 1200px !important;
        }

        .seat-map-content {
            padding: 0;
            max-height: 90vh;
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .seat-map-popup {
                margin: 0.5rem !important;
            }
        }
    </style>
@endsection

{{-- In @section('content') --}}
@section('content')
<div class="container py-4">


<div class="container mt-5">
        <h2 class="text-center mb-4">Flight Segments</h2>
        <div id="segmentsContainer"></div>
    </div>
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Flight Booking Form</h4>
            </div>
            <div class="card-body">
                <form id="bookingForm">
                    <!-- Hidden form elements for API integration -->
                    <div style="display: none;">
                        <div class="col-md-3 mb-3">
                            <label for="title" class="form-label">Title</label>
                            <select class="form-select" id="title" name="Title">
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Ms">Ms</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <input type="hidden" id="firstName" name="FirstName">
                            <input type="hidden" id="lastName" name="LastName">
                            <input type="hidden" id="gender" name="Gender">
                            <input type="hidden" id="dateOfBirth" name="DateOfBirth">
                            <input type="hidden" id="passengerType" name="PassengerType">
                            <input type="hidden" id="email" name="Email">
                            <input type="hidden" id="contactNo" name="ContactNo">
                            <input type="hidden" id="addressLine1" name="AddressLine1">
                            <input type="hidden" id="passportNo" name="PassportNo">
                            <input type="hidden" id="passportExpiry" name="PassportExpiry">
                            <input type="hidden" id="passportIssueDate" name="PassportIssueDate">
                        </div>
                    </div>

                    <!-- Dynamic Sections -->
                    <div id="dynamicSections"></div>

                    <!-- Options -->
                    <div class="option-selection" style="display: none;">
                        <button type="button" class="btn btn-primary" id="baggage-btn">Baggage Options</button>
                        <button type="button" class="btn btn-secondary" id="meal-btn">Meal Options</button>
                    </div>
                    <div id="options-container" style="display: none;">
                        <p>Please select an option to view details.</p>
                    </div>

                    <!-- Seat Selection -->
                    <div class="seat-selection-section mb-3" style="display: none;">
                        <h6>Seat Selection</h6>
                        <button type="button" class="btn btn-secondary" id="selectSeatBtn">Select Seat</button>
                        <span id="seatInfo" class="ms-2" style="font-size: 14px;"></span>
                    </div>
                    <div id="seatMapContainer" class="mt-3" style="display: none;"></div>

                    <!-- Fare Details -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Fare Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="totalFare" class="form-label">Total Fare</label>
                                    <input type="text" class="form-control" id="totalFare" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="button" id="submitButton" class="btn btn-primary">Submit Booking</button>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- In @section('scripts') --}}
@section('scripts')
    <!-- Required JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.js"></script>
    <script>
          document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('traceId');
    const resultIndex = urlParams.get('resultIndex');
    const encodedDetails = urlParams.get('details');
    const origin = getCookie('origin') ;
    console.log(' ORIGIN Details:');
        console.log('ORIGIN:', origin);
        const outboundFareQuoteData = JSON.parse(sessionStorage.getItem('outboundFareQuoteData'));
        const returnFareQuoteData = JSON.parse(sessionStorage.getItem('returnFareQuoteData'));

        console.log('outbount fetched data ',outboundFareQuoteData);
        console.log('return fetched data ',returnFareQuoteData);
         

    function getCookie(name) {
            let nameEQ = name + "=";
            let ca = document.cookie.split(';');
            for(let i = 0; i < ca.length; i++) {
                let c = ca[i].trim();
                if (c.indexOf(nameEQ) === 0) {
                    return c.substring(nameEQ.length);
                }
            }
            return null;
        }

        // Get passenger counts from cookies with default values
        const adultCount = getCookie('adultCount') ;
        const childCount = getCookie('childCount') ;
        const infantCount = getCookie('infantCount') ;

        // Log the values
        console.log('Payment Page - Passenger Details:');
        console.log('Adults:', adultCount);
        console.log('Children:', childCount);
        console.log('Infants:', infantCount);



        function createPassengerForm(passengerType, count, typeValue) {
    for (let i = 1; i <= count; i++) {
        let titleOptions = (typeValue === 1) // Check if passenger is an Adult
            ? `<option value="Mr">Mr</option>
               <option value="Mrs">Mrs</option>
               <option value="Ms">Ms</option>`
            : `<option value="Miss">Miss</option>
               <option value="Master">Mstr</option>`;

        // Create passport details section only for Adult and Child
        let passportSection = (typeValue === 1 || typeValue === 2 ||typeValue === 3 ) ? `
            <div class="passport-details mt-3">
                <h6 class="mb-3">Passport Details</h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Passport Number</label>
                        <input type="text" class="form-control" name="${passengerType}[${i}][PassportNo]" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Passport Expiry</label>
                        <input type="date" class="form-control" name="${passengerType}[${i}][PassportExpiry]" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Passport Issue Date</label>
                        <input type="date" class="form-control" name="${passengerType}[${i}][PassportIssueDate]" required>
                    </div>
                </div>
            </div>` : '';

        let ssrOptions = '';
        
        // Add SSR options based on passenger type
        if (typeValue === 1 || typeValue === 2) { // Adult
            ssrOptions = `
                <div class="ssr-options mt-4">
                    <h6 class="mb-3">Additional Services</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <button type="button" class="btn btn-outline-primary w-100 mb-2" 
                                onclick="fetchSeatMap('seat', ${i}, '${passengerType}')" 
                                id="selectSeatBtn-${passengerType}-${i}">
                                Select Seat
                            </button>
                            <div id="seatInfo-${passengerType}-${i}" class="small text-muted"></div>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-outline-primary w-100 mb-2" 
                                onclick="fetchSSRData('meal', ${i}, '${passengerType}')" 
                                id="meal-btn-${passengerType}-${i}">
                                Select Meal
                            </button>
                            <div id="mealInfo-${passengerType}-${i}" class="small text-muted"></div>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-outline-primary w-100 mb-2" 
                                onclick="fetchSSRData('baggage', ${i}, '${passengerType}')" 
                                id="baggage-btn-${passengerType}-${i}">
                                Select Baggage
                            </button>
                            <div id="baggageInfo-${passengerType}-${i}" class="small text-muted"></div>
                        </div>
                    </div>
                    <div id="options-container-${passengerType}-${i}" class="mt-3"></div>
                </div>`;
        } 

        let passengerForm = `
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">${passengerType} ${i} Details</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Title</label>
                            <select class="form-select" name="${passengerType}[${i}][Title]" required>
                                ${titleOptions}
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" name="${passengerType}[${i}][FirstName]" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="${passengerType}[${i}][LastName]" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Gender</label>
                            <select class="form-select" name="${passengerType}[${i}][Gender]" required>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                            </select>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" name="${passengerType}[${i}][DateOfBirth]" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="text" class="form-control" name="${passengerType}[${i}][ContactNo]" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="${passengerType}[${i}][Email]" required>
                        </div>

                        <input type="hidden" name="${passengerType}[${i}][PassengerType]" value="${typeValue}">
                    </div>
                    ${passportSection}
                    ${ssrOptions}
                </div>
            </div>
        `;
        dynamicSections.insertAdjacentHTML('beforeend', passengerForm);
    }
}

// Generate Passenger Forms with automatic PassengerType
createPassengerForm("Adult", adultCount, 1);
createPassengerForm("Child", childCount, 2);
createPassengerForm("Infant", infantCount, 3);
   

    const fareQuoteData = JSON.parse(sessionStorage.getItem('fareQuoteData'));
    console.log('fareqoutes segment',fareQuoteData?.Segments )

    function renderFareQuoteSegments(fareQuoteData) {
    const segmentsContainer = document.getElementById('segmentsContainer');
    segmentsContainer.innerHTML = '';

    if (!fareQuoteData?.Segments) {
        console.log('Missing Segments data:', fareQuoteData);
        segmentsContainer.innerHTML = `
            <div class="p-4 bg-red-50 text-red-600 rounded">
                No segments data available.
            </div>`;
        return;
    }

    fareQuoteData.Segments.forEach((segmentGroup, groupIndex) => {
    const card = document.createElement('div');
    card.style.cssText = 'background-color: white; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid #E5E7EB; padding: 1.5rem; margin-bottom: 1.5rem; max-width: 800px; width: 100%;';

    let segmentsHtml = `
        <div style="margin-bottom: 1rem; padding-bottom: 0.75rem; border-bottom: 1px solid #E5E7EB; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
            <span style="background-color: #F3F4F6; color: #4B5563; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500;">
                ${groupIndex === 0 ? 'OUTBOUND' : 'RETURN'}
            </span>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <span style="background-color: #EFF6FF; color: #1E40AF; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.875rem;">
                    <span style="font-weight: 500;">Baggage:</span> ${segmentGroup[0].Baggage}
                </span>
                <span style="background-color: #EFF6FF; color: #1E40AF; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.875rem;">
                    <span style="font-weight: 500;">Cabin:</span> ${segmentGroup[0].CabinBaggage}
                </span>
            </div>
        </div>`;

    segmentGroup.forEach((segment, index) => {
        const departureTime = new Date(segment.DepTime);
        const arrivalTime = new Date(segment.ArrTime);
        const duration = segment.Duration;
        const hours = Math.floor(duration / 60);
        const minutes = duration % 60;

        // Format airport and terminal information
        const originAirportInfo = `${segment.Origin.AirportName}${segment.Origin.Terminal ? '-Terminal ' + segment.Origin.Terminal : ''}`;
        const destAirportInfo = `${segment.Destination.AirportName}${segment.Destination.Terminal ? '-Terminal ' + segment.Destination.Terminal : ''}`;

        segmentsHtml += `
            <div style="display: flex; flex-direction: column; ${index < segmentGroup.length - 1 ? 'margin-bottom: 1rem;' : ''}">
                <div style="display: flex; align-items: center; flex-wrap: wrap; gap: 1rem;">
                    <div style="min-width: 120px; flex: 1;">
                        <p style="margin: 0 0 0.25rem 0; font-size: 1.25rem; font-weight: 600; color: #111827;">
                            ${departureTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                        </p>
                        <p style="margin: 0; font-size: 1rem; color: #374151;">
                            ${segment.Origin.CityCode}
                        </p>
                        <p style="margin: 0; font-size: 0.875rem; color: #6B7280;">
                            ${originAirportInfo}
                        </p>
                    </div>

                    <div style="flex: 2; min-width: 200px; padding: 0 1rem; position: relative;">
                        <div style="height: 2px; background-color: #E5E7EB; position: relative;">
                            <div style="position: absolute; width: 100%; text-align: center; top: -20px;">
                                <span style="font-size: 0.875rem; color: #4B5563; display: block;">
                                    ${segment.Airline.AirlineCode}-${segment.Airline.FlightNumber}
                                </span>
                                <span style="font-size: 0.75rem; color: #6B7280; display: block; margin-top: 0.125rem;">
                                    ${segment.Airline.AirlineName || segment.Airline.Name || 'Airline'}
                                </span>
                                <span style="font-size: 0.75rem; color: #6B7280; display: block; margin-top: 0.125rem;">
                                    ${hours}h ${minutes}m 
                                </span>
                            </div>
                        </div>
                    </div>

                    <div style="min-width: 120px; flex: 1; text-align: right;">
                        <p style="margin: 0 0 0.25rem 0; font-size: 1.25rem; font-weight: 600; color: #111827;">
                            ${arrivalTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                        </p>
                        <p style="margin: 0; font-size: 1rem; color: #374151;">
                            ${segment.Destination.CityCode}
                        </p>
                        <p style="margin: 0; font-size: 0.875rem; color: #6B7280;">
                            ${destAirportInfo}
                        </p>
                    </div>
                </div>
            </div>`;

            if (index < segmentGroup.length - 1) {
                const nextSegment = segmentGroup[index + 1];
            const groundTime = parseInt(nextSegment.GroundTime) || 0;
            const groundHours = Math.floor(groundTime / 60);
            const groundMinutes = groundTime % 60;
            
            segmentsHtml += `
                <div style="margin: 1rem 0; padding: 0.75rem; background-color: #FFEDD5; border-radius: 0.375rem; text-align: center; color: #9A3412;">
                    <p style="margin: 0; font-weight: 500;">Change planes at ${segment.Destination.CityCode}</p>
                    <p style="margin: 0.25rem 0 0 0; font-size: 0.875rem;">Layover: ${groundHours}h ${groundMinutes}m</p>
                </div>`;
        }
    });

    card.innerHTML = segmentsHtml;
    segmentsContainer.appendChild(card);
});
}

if (fareQuoteData) {
    renderFareQuoteSegments(fareQuoteData);
}
    // Log fare details for verification
    if (fareQuoteData && fareQuoteData.Fare) {
        console.log('Fare Details Successfully Fetched:', fareQuoteData.Fare);
        
        // Optional: Set total fare in a hidden input for later use
        const totalFareInput = document.getElementById('totalFare');
        if (totalFareInput) {
            totalFareInput.value = fareQuoteData.Fare.OfferedFare || 0;
        }
    } else {
        console.error('Fare Quote Data Not Found in Session Storage');
    }

    // Correctly parse details
    let flightDetails = {};
    if (encodedDetails) {
        try {
            flightDetails = JSON.parse(decodeURIComponent(encodedDetails));
            console.log('Parsed Flight Details:', flightDetails);
            console.log('IsLCC:', flightDetails.isLCC);

            // Use the isLCC directly from parsed details
            const isLCC = flightDetails.isLCC;

            if (isLCC) {
                console.log('This is a Low-Cost Carrier flight');
            } else {
                console.log('This is a Full-Service Carrier flight');
            }
        } catch (error) {
            console.error('Error parsing flight details:', error);
        }
    }


    // Retrieve stored flight search results
    const results = JSON.parse(sessionStorage.getItem('flightSearchResults')) || [];

    // Find SrdvIndex
    let srdvIndex = null;
    results.forEach(resultGroup => {
        resultGroup.forEach(result => {
            if (result.FareDataMultiple) {
                result.FareDataMultiple.forEach(fareData => {
                    if (fareData.ResultIndex === resultIndex) {
                        srdvIndex = fareData.SrdvIndex;
                        console.log('SRDV INDEX', srdvIndex);
                    }
                });
            }
        });
    });

    window.passengerSelections = {
    seats: {},    // Format: {passengerType-index: {seatNumber, code, amount}}
    meals: {},    // Format: {passengerType-index: [{meal details}]}
    baggage: {}   // Format: {passengerType-index: {baggageDetails}}
};
    // Add event listeners
    if (srdvIndex) {
        document.getElementById('baggage-btn').addEventListener('click', () => fetchSSRData('baggage'));
        document.getElementById('meal-btn').addEventListener('click', () => fetchSSRData('meal'));
    } else {
        console.error('SrdvIndex not found for ResultIndex:', resultIndex);
    }

    function fetchSSRData(type, index, passengerType) {

        if (!type || !index || !passengerType) {
        console.error('Missing required parameters:', { type, index, passengerType });
        return;
    }

    const passengerId = `${passengerType}-${index}`;
    const allContainers = document.querySelectorAll('[id^="options-container-"]');
    allContainers.forEach(container => {
        container.style.display = 'none';
    });
    fetch("{{ route('fetch.ssr.data') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            EndUserIp: '1.1.1.1',
            ClientId: '180133',
            UserName: 'MakeMy91',
            Password: 'MakeMy@910',
            SrdvType: "MixAPI",
            SrdvIndex: srdvIndex,
            TraceId: traceId,
            ResultIndex: resultIndex
        })
    })
    .then(response => response.json())
    .then(data => {
        const container = document.getElementById(`options-container-${passengerType}-${index}`);
        if (container) {
            container.style.display = 'block';
        }
        if (!data.success) {
            container.innerHTML = `<p>This flight does not provide SSR services: ${data.message || 'No details available'}</p>`;
            return;
        }

        if (type === 'baggage' && data.Baggage && data.Baggage[0] && data.Baggage[0].length > 0) {
            renderBaggageOptions(data.Baggage[0], container, passengerId);
        } else if (type === 'meal' && data.MealDynamic && data.MealDynamic[0] && data.MealDynamic[0].length > 0) {
            renderMealOptions(data.MealDynamic[0], container, passengerId);
        } else {
            container.innerHTML = `<p>No ${type} options available for this flight.</p>`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: `Failed to load ${type} options. Please try again.`
        });
    });
}

// Make sure selectSeat is available globally
if (typeof window !== 'undefined') {
        window.fetchSSRData = fetchSSRData;
    }

    function renderBaggageOptions(baggageData, container, passengerId) {
    if (!baggageData.length) {
        container.innerHTML = '<p>No baggage options available.</p>';
        return;
    }

    container.innerHTML = `
        <h6 class="mb-4">Baggage Options</h6>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Weight</th>
                    <th>Price (INR)</th>
                    <th>Route</th>
                    <th>Select</th>
                </tr>
            </thead>
            <tbody>
                ${baggageData.map(option => `
                    <tr>
                        <td>${option.Weight > 0 ? option.Weight + ' kg' : 'No Baggage'}</td>
                        <td>${option.Price > 0 ? option.Price + ' INR' : 'Free'}</td>
                        <td>${option.Origin} → ${option.Destination}</td>
                        <td>
                            <input 
                                type="radio" 
                                name="baggage_option_${passengerId}" 
                                value="${option.Code}" 
                                data-weight="${option.Weight}" 
                                data-price="${option.Price}"
                                data-description="${option.Description}"
                                data-wayType="${option.WayType}"
                                data-currency="${option.Currency}"
                                data-origin="${option.Origin}"
                                data-destination="${option.Destination}"
                                ${option.Code === 'NoBaggage' ? 'checked' : ''}
                                onchange="updateBaggageSelection(this, '${passengerId}')"
                            >
                        </td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
}

window.updateBaggageSelection = function(radio, passengerId) {
    const baggageOption = {
        Code: radio.value,
        Weight: radio.getAttribute('data-weight'),
        Price: radio.getAttribute('data-price'),
        Origin: radio.getAttribute('data-origin'),
        Destination: radio.getAttribute('data-destination'),
        Description: radio.getAttribute('data-description'),
        WayType: radio.getAttribute('data-wayType'),
        Currency: radio.getAttribute('data-currency')
    };
    
    window.passengerSelections.baggage[passengerId] = baggageOption;
    showBaggageAlert(radio, passengerId);
    const container = document.getElementById(`options-container-${passengerId}`);
    if (container) {
        container.style.display = 'none';
    }
    
};


function renderMealOptions(mealData, container, passengerId) {
    container.innerHTML = `
        <div class="meal-options-container">
            <div class="selected-meals-summary mb-3">
                <strong>Selected Meals: </strong>
                <div id="selectedMealsDisplay_${passengerId}" class="mt-2">
                    <em class="text-muted">No meals selected</em>
                </div>
            </div>
            <div class="meal-list">
                ${mealData.map(meal => `
                    <div class="meal-option">
                        <div class="meal-selection">
                            <input 
                                type="checkbox" 
                                name="meal_option_${passengerId}" 
                                value="${meal.Code}" 
                                data-wayType="${meal.WayType}"
                                data-descript="${meal.Description || 'No Description'}"
                                data-description="${meal.AirlineDescription || 'No Description'}"
                                data-origin="${meal.Origin}"
                                data-quantity="${meal.Quantity}"
                                data-currency="${meal.Currency}"
                                data-destination="${meal.Destination}"
                                data-price="${meal.Price}"
                                onchange="updateMealSelections(this, '${passengerId}')"
                                id="meal_${meal.Code}_${passengerId}"
                            >
                            <label for="meal_${meal.Code}_${passengerId}" class="meal-label">
                                ${meal.AirlineDescription || 'No Meal'} 
                                <span class="meal-price">₹${meal.Price || 0}</span>
                            </label>
                        </div>
                        <div class="meal-quantity compact">
                            <button type="button" class="quantity-btn" onclick="adjustQuantity(this, -1, '${passengerId}')" ${meal.Price ? '' : 'disabled'}>-</button>
                            <input type="number" min="1" max="5" value="1" class="quantity-input" 
                                onchange="updateMealQuantity(this, '${passengerId}')" ${meal.Price ? '' : 'disabled'}>
                            <button type="button" class="quantity-btn" onclick="adjustQuantity(this, 1, '${passengerId}')" ${meal.Price ? '' : 'disabled'}>+</button>
                        </div>
                    </div>
                `).join('')}
            </div>
        </div>
    `;

    // Add styling for the new compact meal list
    const style = document.createElement('style');
    style.textContent = `
        .meal-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }
        .meal-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            border-bottom: 1px solid #f0f0f0;
        }
        .meal-option:last-child {
            border-bottom: none;
        }
        .meal-option:hover {
            background-color: #f9f9f9;
        }
        .meal-selection {
            display: flex;
            align-items: center;
            flex: 1;
        }
        .meal-label {
            margin-left: 8px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            flex: 1;
            max-width: 70%;
        }
        .meal-price {
            font-weight: bold;
            color: #2c5282;
            margin-left: 8px;
        }
        .meal-quantity.compact {
            display: flex;
            align-items: center;
        }
        .quantity-btn {
            width: 25px;
            height: 25px;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ccc;
            background: #f8f9fa;
            border-radius: 3px;
        }
        .quantity-input {
            width: 35px;
            text-align: center;
            margin: 0 4px;
            padding: 2px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .selected-meals-display-item {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            padding: 4px 8px;
            margin: 2px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .selected-meals-total {
            font-weight: bold;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #dee2e6;
        }
    `;
    document.head.appendChild(style);
}
// Store selected meals in an array
window.selectedMealOptions = [];

window.updateMealSelections = function(checkbox, passengerId) {
    if (!window.passengerSelections.meals[passengerId]) {
        window.passengerSelections.meals[passengerId] = [];
    }

    const mealData = {
        Code: checkbox.value,
        AirlineDescription: checkbox.getAttribute('data-description'),
        Origin: checkbox.getAttribute('data-origin'),
        Destination: checkbox.getAttribute('data-destination'),
        Price: parseFloat(checkbox.getAttribute('data-price')) || 0,
        WayType: checkbox.getAttribute('data-wayType'),
        Quantity: parseInt(checkbox.closest('.meal-option').querySelector('.quantity-input').value),
        Currency: checkbox.getAttribute('data-currency'),
        Description: checkbox.getAttribute('data-descript')
    };

    if (checkbox.checked) {
        window.passengerSelections.meals[passengerId].push(mealData);
    } else {
        window.passengerSelections.meals[passengerId] = 
            window.passengerSelections.meals[passengerId].filter(meal => meal.Code !== mealData.Code);
    }

    updateMealDisplay(passengerId);
    updateTotalFare();
    showMealSelectionAlert(passengerId);
};
// Function to adjust quantity
window.adjustQuantity = function(button, change) {
    const input = button.parentElement.querySelector('.quantity-input');
    const newValue = parseInt(input.value) + change;
    if (newValue >= 1 && newValue <= 5) {
        input.value = newValue;
        updateMealQuantity(input);
    }
};

// Function to update meal quantity
window.updateMealQuantity = function(input) {
    const checkbox = input.closest('.meal-option').querySelector('input[type="checkbox"]');
    if (checkbox.checked) {
        const mealIndex = window.selectedMealOptions.findIndex(meal => meal.Code === checkbox.value);
        if (mealIndex !== -1) {
            window.selectedMealOptions[mealIndex].Quantity = parseInt(input.value);
          
            showMealSelectionAlert();
        }
    }
};

function updateMealDisplay(passengerId) {
    const displayElement = document.getElementById(`selectedMealsDisplay_${passengerId}`);
    if (!displayElement) return;

    const selectedMeals = window.passengerSelections.meals[passengerId] || [];
    
    if (selectedMeals.length === 0) {
        displayElement.innerHTML = '<em class="text-muted">No meals selected</em>';
        return;
    }

    let totalPrice = 0;
    let mealsHtml = selectedMeals.map(meal => {
        const mealTotal = meal.Price * meal.Quantity;
        totalPrice += mealTotal;
        return `
            <div class="selected-meals-display-item">
                <span>${meal.AirlineDescription} (Qty: ${meal.Quantity})</span>
                <span>₹${mealTotal.toFixed(2)}</span>
            </div>
        `;
    }).join('');

    // Add total at the bottom
    mealsHtml += `
        <div class="selected-meals-total">
            Total: ₹${totalPrice.toFixed(2)}
        </div>
    `;

    displayElement.innerHTML = mealsHtml;
}

// Update quantity handling to refresh the display
window.updateMealQuantity = function(input, passengerId) {
    const checkbox = input.closest('.meal-option').querySelector(`input[name="meal_option_${passengerId}"]`);
    if (checkbox.checked) {
        const selectedMeals = window.passengerSelections.meals[passengerId] || [];
        const mealIndex = selectedMeals.findIndex(meal => meal.Code === checkbox.value);
        if (mealIndex !== -1) {
            selectedMeals[mealIndex].Quantity = parseInt(input.value);
            updateMealDisplay(passengerId);
            updateTotalFare();
        }
    }
};

window.adjustQuantity = function(button, change, passengerId) {
    const input = button.parentElement.querySelector('.quantity-input');
    const newValue = parseInt(input.value) + change;
    if (newValue >= 1 && newValue <= 5) {
        input.value = newValue;
        updateMealQuantity(input, passengerId);
    }
};

// Function to show meal selection alert
function showMealSelectionAlert() {
    if (window.Swal && window.selectedMealOptions.length > 0) {
        const mealSummary = window.selectedMealOptions.map(meal => 
            `${meal.AirlineDescription} (Qty: ${meal.Quantity}) - ₹${(meal.Price * meal.Quantity).toFixed(2)}`
        ).join('\n');

        window.Swal.fire({
            icon: 'info',
            title: 'Selected Meals',
            text: mealSummary,
            showConfirmButton: false,
            timer: 2000
        });
    }
}

// Add these global functions to show alerts
function showBaggageAlert(radio) {
    const weight = radio.getAttribute('data-weight');
    const price = radio.getAttribute('data-price');
    
    if (window.Swal) {
        window.Swal.fire({
            icon: 'info',
            title: 'Baggage Option Selected',
            text: `${weight > 0 ? weight + ' kg' : 'No Baggage'} - ${price > 0 ? '₹' + price : 'Free'}`,
            showConfirmButton: false,
            timer: 1500
        });
    } else {
        alert(`Baggage: ${weight > 0 ? weight + ' kg' : 'No Baggage'} - ${price > 0 ? '₹' + price : 'Free'}`);
    }
}



window.showBaggageAlert = function(radio) {
    const weight = radio.getAttribute('data-weight');
    const price = radio.getAttribute('data-price');
    
    if (window.Swal) {
        window.Swal.fire({
            icon: 'info',
            title: 'Baggage Option Selected',
            text: `${weight > 0 ? weight + ' kg' : 'No Baggage'} - ${price > 0 ? '₹' + price : 'Free'}`,
            showConfirmButton: false,
            timer: 1500
        });
    } else {
        alert(`Baggage: ${weight > 0 ? weight + ' kg' : 'No Baggage'} - ${price > 0 ? '₹' + price : 'Free'}`);
    }
};

    // Seat Selection
// Replace your existing selectSeatBtn click handler with this:


    if (srdvIndex) {
        document.getElementById('selectSeatBtn').addEventListener('click', () => fetchSSRData('baggage'));
     
    } else {
        console.error('SrdvIndex not found for ResultIndex:', resultIndex);
    }

    function fetchSeatMap(type, index, passengerType) {
    const passengerId = `${passengerType}-${index}`;
    const button = document.getElementById(`selectSeatBtn-${passengerId}`);
    
    if (button) {
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
    }

    fetch('{{ route("flight.getSeatMap") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            EndUserIp: '1.1.1.1',
            ClientId: '180133',
            UserName: 'MakeMy91',
            Password: 'MakeMy@910',
            SrdvType: "MixAPI",
            SrdvIndex: srdvIndex,
            TraceId: traceId,
            ResultIndex: resultIndex
        })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.html || data.html.trim() === '' || data.html.includes('No seats available')) {
            Swal.fire({
                icon: 'info',
                title: 'No Seats Available',
                text: 'Unfortunately, no seats are available for selection on this flight.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#2196f3'
            });
        } else {
            Swal.fire({
                title: `Select Seat for ${passengerType} ${index}`,
                html: data.html,
                width: '90%',
                padding: '0',
                background: '#f8f9fa',
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    container: 'seat-map-modal',
                    popup: 'seat-map-popup',
                    content: 'seat-map-content'
                },
                didOpen: () => {
                    // Add current passenger ID to the modal for reference
                    const modal = Swal.getPopup();
                    modal.setAttribute('data-passenger-id', passengerId);
                }
            });
        }
        
        if (button) {
            button.disabled = false;
            button.innerHTML = 'Select Seat';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Failed to load seat map. Please try again.'
        });

        if (button) {
            button.disabled = false;
            button.innerHTML = 'Select Seat';
        }
    });
}

    if (typeof window !== 'undefined') {
        window.fetchSeatMap = fetchSeatMap;
    }
// Keep your original selectSeat function unchanged, just add this line at the end:
function selectSeat(code, seatNumber, amount, airlineName, airlineCode, airlineNumber) {
    const modal = Swal.getPopup();
    const passengerId = modal.getAttribute('data-passenger-id');
    
    window.passengerSelections.seats[passengerId] = {
        code,
        seatNumber,
        amount,
        airlineName,
        airlineCode,
        airlineNumber
    };

    // Update seat info display for the specific passenger
    const seatInfoElement = document.getElementById(`seatInfo-${passengerId}`);
    if (seatInfoElement) {
        seatInfoElement.textContent = `Selected Seat: ${seatNumber} (₹${amount})`;
    }

    // Show confirmation
    Swal.fire({
        icon: 'success',
        title: 'Seat Selected!',
        text: `Seat ${seatNumber} (₹${amount}) selected for ${passengerId}`,
        showConfirmButton: false,
        timer: 1500
    });
}


// Make sure selectSeat is available globally
window.selectSeat = selectSeat;


// Make functions available globally
if (typeof window !== 'undefined') {
    window.fetchSSRData = fetchSSRData;
    window.fetchSeatMap = fetchSeatMap;
    window.selectSeat = selectSeat;
}




// Function to check flight balance
function checkFlightBalance() {
    return new Promise((resolve, reject) => {
        // Create loading overlay
        const loadingOverlay = document.createElement('div');
        loadingOverlay.style.position = 'fixed';
        loadingOverlay.style.top = '0';
        loadingOverlay.style.left = '0';
        loadingOverlay.style.width = '100%';
        loadingOverlay.style.height = '100%';
        loadingOverlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        loadingOverlay.style.display = 'flex';
        loadingOverlay.style.justifyContent = 'center';
        loadingOverlay.style.alignItems = 'center';
        loadingOverlay.style.zIndex = '9999';
        loadingOverlay.innerHTML = '<div style="background: white; padding: 20px; border-radius: 5px;">Checking balance...</div>';
        document.body.appendChild(loadingOverlay);

        // Make API call to check balance
        fetch('/flight/balance', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                EndUserIp: '1.1.1.1',
                ClientId: '180133',
                UserName: 'MakeMy91',
                Password: 'MakeMy@910'
            })
        })
        .then(response => response.json())
        .then(data => {
            // Remove loading overlay
            document.body.removeChild(loadingOverlay);

            if (data.status !== 'success') {
                throw new Error(data.message || 'Failed to check balance');
            }

            const totalFare = fareQuoteData.Fare.OfferedFare || 0;

            // Check if balance is sufficient
            if (data.balance < totalFare) {
                Swal.fire({
                    icon: 'error',
                    title: 'Insufficient Balance',
                    text: `Your balance (₹${data.balance}) is insufficient for this booking (₹${totalFare})`
                });
                reject(new Error('Insufficient balance'));
                return;
            }

            resolve(data);
        })
        .catch(error => {
            // Remove loading overlay
            if (document.body.contains(loadingOverlay)) {
                document.body.removeChild(loadingOverlay);
            }

            Swal.fire({
                icon: 'error',
                title: 'Balance Check Failed',
                text: error.message || 'Failed to check balance'
            });

            reject(error);
        });
    });
}

document.getElementById('submitButton').addEventListener('click', async function(event) {
    event.preventDefault();
    
    try {
        await checkFlightBalance();
        const isLCC = flightDetails.isLCC;
        console.log('Checking isLCC status:', isLCC);
        
        if (isLCC) {
            console.log('Processing LCC booking...');
            // Prepare payload for LCC booking
            const bookingDetails = {
                resultIndex: resultIndex,
                srdvIndex: srdvIndex,
                traceId: traceId,
                totalFare: fareQuoteData.Fare.OfferedFare || 0
            };

            // Initialize passengers array
            let passengers = [];
            
            // Log current selections for debugging
            console.log('Current passenger selections:', window.passengerSelections);
            
            // Get all passenger forms
            document.querySelectorAll("#dynamicSections .card").forEach((card, index) => {
                const form = card.querySelector('.card-body');
                
                // Extract passenger type from the card header text
                const headerText = card.querySelector('.card-header h6').textContent;
                const passengerTypeMatch = headerText.match(/(Adult|Child|Infant)/);
                const passengerTypeString = passengerTypeMatch ? passengerTypeMatch[1] : 'Unknown';
                const passengerIndex = (headerText.match(/\d+/) || [1])[0];
                const passengerId = `${passengerTypeString}-${passengerIndex}`;

                console.log('Processing passenger:', passengerId);

                // Map passenger type string to numeric value
                const typeMapping = {'Adult': 1, 'Child': 2, 'Infant': 3};
                const passengerType = typeMapping[passengerTypeString];

                // Create passenger object with basic details
                let passenger = {
                    title: form.querySelector('[name$="[Title]"]').value.trim(),
                    firstName: form.querySelector('[name$="[FirstName]"]').value.trim(),
                    lastName: form.querySelector('[name$="[LastName]"]').value.trim(),
                    gender: (form.querySelector('[name$="[Gender]"]').value),
                    contactNo: form.querySelector('[name$="[ContactNo]"]')?.value.trim() || "",
                    email: form.querySelector('[name$="[Email]"]')?.value.trim() || "",
                    dateOfBirth: form.querySelector('[name$="[DateOfBirth]"]').value,
                    paxType: passengerType,
                    addressLine1: form.querySelector('[name$="[AddressLine1]"]')?.value.trim() || "",
                    passportNo: form.querySelector('[name$="[PassportNo]"]')?.value.trim() || "",
                    passportExpiry: form.querySelector('[name$="[PassportExpiry]"]')?.value || "",
                    passportIssueDate: form.querySelector('[name$="[PassportIssueDate]"]')?.value || ""
                };

                // Get selected services for this passenger
                const selectedSeat = window.passengerSelections.seats[passengerId];
                const selectedBaggage = window.passengerSelections.baggage[passengerId];
                const selectedMeals = window.passengerSelections.meals[passengerId];

                console.log(`Selected services for ${passengerId}:`, {
                    seat: selectedSeat,
                    baggage: selectedBaggage,
                    meals: selectedMeals
                });

                // Add selected services
                passenger.selectedServices = {
                    seat: selectedSeat || null,
                    baggage: selectedBaggage || null,
                    meals: selectedMeals || []
                };

                // Calculate total SSR cost for this passenger
                let ssrCost = 0;
                
                // Add seat cost if selected
                if (selectedSeat) {
                    ssrCost += parseFloat(selectedSeat.amount) || 0;
                }
                
                // Add baggage cost if selected
                if (selectedBaggage) {
                    ssrCost += parseFloat(selectedBaggage.Price) || 0;
                }
                
                // Add meals cost if selected
                if (selectedMeals && selectedMeals.length > 0) {
                    selectedMeals.forEach(meal => {
                        ssrCost += (parseFloat(meal.Price) || 0) * (parseInt(meal.Quantity) || 1);
                    });
                }
                
                passenger.totalSSRCost = ssrCost;
                
                // Log the final passenger object
                console.log(`Final passenger object for ${passengerId}:`, passenger);
                
                passengers.push(passenger);
            });

            // Add passengers to booking details
            bookingDetails.passengers = passengers;

            // Add fare details
            bookingDetails.fare = {
                baseFare: fareQuoteData.Fare.BaseFare,
                tax: fareQuoteData.Fare.Tax,
                yqTax: fareQuoteData.Fare.YQTax,
                transactionFee: fareQuoteData.Fare.TransactionFee,
                additionalTxnFeeOfrd: fareQuoteData.Fare.AdditionalTxnFeeOfrd,
                additionalTxnFeePub: fareQuoteData.Fare.AdditionalTxnFeePub,
                airTransFee: fareQuoteData.Fare.AirTransFee
            };

            // Calculate total SSR cost across all passengers
            const totalSSRCost = passengers.reduce((total, passenger) => total + passenger.totalSSRCost, 0);
            bookingDetails.totalSSRCost = totalSSRCost;
            
            // Calculate grand total
            bookingDetails.grandTotal = (parseFloat(bookingDetails.totalFare) || 0) + totalSSRCost;

            // Log final booking details before encoding
            console.log('Final booking details:', bookingDetails);

            // Encode booking details for URL
            const encodedDetails = encodeURIComponent(JSON.stringify(bookingDetails));
            
            // Check URL length and redirect
            const baseUrl = '/payment?details=';
            const finalUrl = baseUrl + encodedDetails;
            
            console.log('Redirecting to:', finalUrl);
            window.location.href = finalUrl;

            console.log('Redirecting with booking details:', bookingDetails);
        } else {
            console.log('Non-LCC flight, redirecting to payment...');
            
            // Helper functions
            function convertToISODateTime(dateString) {
                if (!dateString) return ''; // Return empty if no date is provided
                return `${dateString}T00:00:00`;
            }

            function convertToISODate(dateString) {
                if (!dateString) return '';
                return dateString.split('T')[0]; // Remove time part if exists
            }

            function validateEmail(email) {
                return email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/);
            }

            function validatePassenger(passengerData) {
                const errors = [];
                
                if (!passengerData.firstName.trim()) errors.push('First name is required');
                if (!passengerData.lastName.trim()) errors.push('Last name is required');
                if (!passengerData.passportNo.trim()) errors.push('Passport number is required');
                if (!passengerData.passportExpiry) errors.push('Passport expiry date is required');
                if (!passengerData.dateOfBirth) errors.push('Date of birth is required');
                if (!validateEmail(passengerData.email)) errors.push('Valid email is required');
                if (!passengerData.contactNo.trim()) errors.push('Contact number is required');
                
                return errors;
            }

            let passengers = [];
            
            // Get all passenger forms
            document.querySelectorAll("#dynamicSections .card").forEach((card, index) => {
                const form = card.querySelector('.card-body');
                
                // Extract passenger type from the card header text
                const headerText = card.querySelector('.card-header h6').textContent;
                const passengerTypeMatch = headerText.match(/(Adult|Child|Infant)/);
                const passengerTypeString = passengerTypeMatch ? passengerTypeMatch[1] : 'Unknown';
                
                // Map passenger type string to numeric value
                const typeMapping = {'Adult': 1, 'Child': 2, 'Infant': 3};
                const passengerType = typeMapping[passengerTypeString];

                // Create passenger object with form data
                let passenger = {
                    title: form.querySelector('[name$="[Title]"]').value.trim(),
                    firstName: form.querySelector('[name$="[FirstName]"]').value.trim(),
                    gender: (form.querySelector('[name$="[Gender]"]').value),
                    contactNo: form.querySelector('[name$="[ContactNo]"]')?.value.trim() || "",
                    email: form.querySelector('[name$="[Email]"]')?.value.trim() || "",
                    paxType: passengerType,
                    passportNo: form.querySelector('[name$="[PassportNo]"]')?.value.trim() || "",
                    passportExpiry: convertToISODateTime(form.querySelector('[name$="[PassportExpiry]"]')?.value || ""),
                    passportIssueDate: convertToISODateTime(form.querySelector('[name$="[PassportIssueDate]"]')?.value || ""),
                    dateOfBirth: convertToISODateTime(form.querySelector('[name$="[DateOfBirth]"]')?.value || ""),
                    addressLine1: origin,
                    city: origin,
                    countryCode: "IN",
                    countryName: "INDIA",
                    isLeadPax: index === 0, // First passenger is lead passenger
                    
                    // Add fare details for each passenger
                    fare: [{
                        baseFare: parseFloat(fareQuoteData.Fare.BaseFare),
                        tax: parseFloat(fareQuoteData.Fare.Tax),
                        yqTax: parseFloat(fareQuoteData.Fare.YQTax || 0),
                        transactionFee: (fareQuoteData.Fare.TransactionFee || '0').toString(),
                        additionalTxnFeeOfrd: parseFloat(fareQuoteData.Fare.AdditionalTxnFeeOfrd || 0),
                        additionalTxnFeePub: parseFloat(fareQuoteData.Fare.AdditionalTxnFeePub || 0),
                        airTransFee: (fareQuoteData.Fare.AirTransFee || '0').toString()
                    }],
                    
                    // Add GST details
                    gst: {
                        companyAddress: '',
                        companyContactNumber: '',
                        companyName: '',
                        number: '',
                        companyEmail: ''
                    }
                };

                // Validate passenger data
                const validationErrors = validatePassenger(passenger);
                if (validationErrors.length > 0) {
                    throw new Error(`Validation failed for ${passengerTypeString}: ${validationErrors.join(', ')}`);
                }

                passengers.push(passenger);
            });

            // Create the final payload
            const payload = {
                srdvIndex: srdvIndex,
                traceId: traceId,
                resultIndex: resultIndex,
                passengers: passengers
            };

            console.log('Final payload for bookHold:', payload);

            // Disable submit button to prevent double submission
            const submitButton = event.target;
            submitButton.disabled = true;

            // Make API call for bookHold
            try {
                const response = await fetch('/flight/bookHold', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(payload)
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    console.log('Non-LCC Booking successful!', data.booking_details);
                    // Redirect to payment page with booking details
                    const queryParams = new URLSearchParams({
                        resultIndex: resultIndex,
                        bookingId: data.booking_details.booking_id,
                        pnr: data.booking_details.pnr,
                        srdvIndex: data.booking_details.srdvIndex,
                        traceId: data.booking_details.trace_id
                    });
                    window.location.href = `/payment?${queryParams.toString()}`;
                } else {
                    throw new Error(data.message || 'Booking failed');
                }
            } catch (error) {
                console.error('Error during Non-LCC booking:', error);
                if (window.Swal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Booking Failed',
                        text: error.message || 'An error occurred during booking'
                    });
                } else {
                    alert('Booking failed: ' + (error.message || 'An error occurred'));
                }
            } finally {
                submitButton.disabled = false;
            }
        }
    } catch (error) {
        console.error('Error during booking process:', error);
        // Error is already handled in the checkFlightBalance function
    }
});



// ALL CODE REALTED TO ROUND TRIP FLIGHT BOOKING

















});



</script>
@endsection
