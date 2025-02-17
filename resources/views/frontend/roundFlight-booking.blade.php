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

                    <div class="total-price-container">
    <h5>Total Price: <span id="totalPrice">₹0.00</span></h5>
    <div id="priceBreakdown"></div>
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
    const outboundResultIndex = urlParams.get('outboundIndex');
const returnResultIndex = urlParams.get('returnIndex');

// Log for debugging
console.log('Outbound Result Index:', outboundResultIndex);
console.log('Return Result Index:', returnResultIndex);
    const encodedDetails = urlParams.get('details');
    const origin = getCookie('origin') ;
    const destination = getCookie('destination') ;
    // console.log(' ORIGIN Details:', origin);
    // console.log(' DESTINATION Details:',destination);
     
        const outboundFareQuoteData = JSON.parse(sessionStorage.getItem('outboundFareQuoteData'));
        const returnFareQuoteData = JSON.parse(sessionStorage.getItem('returnFareQuoteData'));

        console.log('outbount fetched data ',outboundFareQuoteData);
        console.log('return fetched data ',returnFareQuoteData);
         

        const returnFlights = JSON.parse(sessionStorage.getItem('returnFlights')) || [];
        const outboundFlights = JSON.parse(sessionStorage.getItem('outboundFlights')) || [];


    // Retrieve stored flight search results
    let outboundSrdvIndex = null;
// Find SrdvIndex for return flight
let returnSrdvIndex = null;

// Find SrdvIndex from outboundFlights
outboundFlights.forEach(outbound => {
    if (outbound.FareDataMultiple && Array.isArray(outbound.FareDataMultiple)) {
        outbound.FareDataMultiple.forEach(fareData => {
            if (fareData.ResultIndex === outboundResultIndex) {
                outboundSrdvIndex = fareData.SrdvIndex;
                console.log('departure srdvindex ', outboundSrdvIndex);
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
                console.log('return srdvindex ', returnSrdvIndex);
            }
        });
    }
});

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
        if (typeValue === 1 || typeValue === 2) { // Adult or Child
            ssrOptions = `
                <div class="ssr-options mt-4">
                    <h6 class="mb-3">Additional Services</h6>
                    
                    <!-- Outbound Flight Section -->
                    <div class="flight-section mb-4">
                        <h5>Outbound Flight</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-primary w-100 mb-2" 
                                    onclick="fetchSeatMap('seat', '${outboundResultIndex}', '${outboundSrdvIndex}', 'outbound', '${passengerType}', ${i})" 
                                    id="selectSeatBtn-outbound-${passengerType}-${i}">
                                    Select Seat
                                </button>
                                <div id="seatInfo-outbound-${passengerType}-${i}" class="small text-muted"></div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-primary w-100 mb-2" 
                                    onclick="fetchSSRData('meal', '${passengerType}', '${outboundResultIndex}', '${outboundSrdvIndex}', 'outbound', ${i})" 
                                    id="meal-btn-outbound-${passengerType}-${i}">
                                    Select Meal
                                </button>
                                <div id="mealInfo-outbound-${passengerType}-${i}" class="small text-muted"></div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-primary w-100 mb-2" 
                                    onclick="fetchSSRData('baggage', '${passengerType}', '${outboundResultIndex}', '${outboundSrdvIndex}', 'outbound', ${i})" 
                                    id="baggage-btn-outbound-${passengerType}-${i}">
                                    Select Baggage
                                </button>
                                <div id="baggageInfo-outbound-${passengerType}-${i}" class="small text-muted"></div>
                            </div>
                        </div>
                        <div id="options-container-outbound-${passengerType}-${i}" class="mt-3"></div>
                    </div>

                    <!-- Return Flight Section -->
                    <div class="flight-section">
                        <h5>Return Flight</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-primary w-100 mb-2" 
                                    onclick="fetchSeatMap('seat', '${returnResultIndex}', '${returnSrdvIndex}', 'return', '${passengerType}', ${i})" 
                                    id="selectSeatBtn-return-${passengerType}-${i}">
                                    Select Seat
                                </button>
                                <div id="seatInfo-return-${passengerType}-${i}" class="small text-muted"></div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-primary w-100 mb-2" 
                                    onclick="fetchSSRData('meal', '${passengerType}', '${returnResultIndex}', '${returnSrdvIndex}', 'return', ${i})" 
                                    id="meal-btn-return-${passengerType}-${i}">
                                    Select Meal
                                </button>
                                <div id="mealInfo-return-${passengerType}-${i}" class="small text-muted"></div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-primary w-100 mb-2" 
                                    onclick="fetchSSRData('baggage', '${passengerType}', '${returnResultIndex}', '${returnSrdvIndex}', 'return', ${i})" 
                                    id="baggage-btn-return-${passengerType}-${i}">
                                    Select Baggage
                                </button>
                                <div id="baggageInfo-return-${passengerType}-${i}" class="small text-muted"></div>
                            </div>
                        </div>
                        <div id="options-container-return-${passengerType}-${i}" class="mt-3"></div>
                    </div>
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
   

    

function renderFareQuoteSegments(outboundFareQuoteData, returnFareQuoteData) {
    const segmentsContainer = document.getElementById('segmentsContainer');
    segmentsContainer.innerHTML = '';

    function createSegmentCard(title, fareQuoteData) {
        if (!fareQuoteData?.Segments || fareQuoteData.Segments.length === 0) {
            console.warn(`Missing ${title} Segments data:`, fareQuoteData);
            return `
                <div class="p-4 bg-red-50 text-red-600 rounded mb-4">
                    No ${title} segments data available.
                </div>`;
        }

        let segmentCards = `<h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem;">${title}</h3>`;

fareQuoteData.Segments.forEach((segmentGroup, groupIndex) => {
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
            <div style="display: flex; align-items: center; ${index < segmentGroup.length - 1 ? 'margin-bottom: 0.5rem;' : ''}">
                <div style="width: 6rem; text-align: center;">
                    <p style="font-weight: 700; margin: 0;">
                        ${departureTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                    </p>
                    <p style="font-size: 0.875rem; color: #4B5563; margin: 0;">
                        ${segment.Origin.CityCode}
                    </p>
                    <p style="font-size: 0.75rem; color: #6B7280; margin: 0; line-height: 1.2;">
                        ${originAirportInfo}
                    </p>
                </div>
                
                <div style="flex: 1; padding: 0 1rem;">
                    <div style="position: relative; display: flex; align-items: center;">
                        <div style="height: 0.125rem; width: 100%; background-color: #D1D5DB;"></div>
                        <div style="position: absolute; width: 100%; text-align: center;">
                            <span style="font-size: 0.75rem; color: #4B5563; display: block;">
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
                
                <div style="width: 6rem; text-align: center;">
                    <p style="font-weight: 700; margin: 0;">
                        ${arrivalTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                    </p>
                    <p style="font-size: 0.875rem; color: #4B5563; margin: 0;">
                        ${segment.Destination.CityCode}
                    </p>
                    <p style="font-size: 0.75rem; color: #6B7280; margin: 0; line-height: 1.2;">
                        ${destAirportInfo}
                    </p>
                </div>
            </div>`;

            if (index < segmentGroup.length - 1) {
            // ✨ FIXED: Get ground time from the next segment
            const nextSegment = segmentGroup[index + 1];
            const groundTime = parseInt(nextSegment.GroundTime) || 0;
            const groundHours = Math.floor(groundTime / 60);
            const groundMinutes = groundTime % 60;
            
            segmentsHtml += `
                <div style="margin: 0.5rem 0; padding: 0.25rem 0.75rem; background-color: #FFF7ED; border-radius: 0.375rem; font-size: 0.875rem; text-align: center; color: #C2410C;">
                    <p style="margin: 0; font-weight: 500;">Change planes at ${segment.Destination.CityCode}</p>
                    <p style="margin: 0.125rem 0 0 0; font-size: 0.75rem;">Layover: ${groundHours}h ${groundMinutes}m</p>
                </div>`;
        }
    });

    segmentCards += `
        <div style="background-color: white; border-radius: 0.5rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); border: 1px solid #E5E7EB; padding: 1rem; margin-bottom: 1rem;">
            ${segmentsHtml}
        </div>`;
});

return segmentCards;
 }

// Render outbound flight segments
segmentsContainer.innerHTML += createSegmentCard('Outbound Flight', outboundFareQuoteData);

// Render return flight segments
segmentsContainer.innerHTML += createSegmentCard('Return Flight', returnFareQuoteData);
}

// Fetch fare quote data from session storage

// Ensure data exists before rendering
if (outboundFareQuoteData || returnFareQuoteData) {
    renderFareQuoteSegments(outboundFareQuoteData, returnFareQuoteData);

    // Log fare details for verification
    if (outboundFareQuoteData?.Fare || returnFareQuoteData?.Fare) {
        console.log('Outbound Fare Details:', outboundFareQuoteData?.Fare);
        console.log('Return Fare Details:', returnFareQuoteData?.Fare);

        // Update total fare input if it exists
        const totalFareInput = document.getElementById('totalFare');
        if (totalFareInput) {
            const totalFare = (outboundFareQuoteData?.Fare?.OfferedFare || 0) + 
                              (returnFareQuoteData?.Fare?.OfferedFare || 0);
            totalFareInput.value = totalFare;
        }
    } else {
        console.error('Fare Quote Data Not Found in Session Storage');
    }
} else {
    console.error('No Fare Quote Data Available');
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


    


window.passengerSelections = {
    seats: {
        outbound: {},  // Format: {passengerType-index: {seatDetails}}
        return: {}     // Format: {passengerType-index: {seatDetails}}
    },    // Format: {passengerType-index: {seatNumber, code, amount}}
    meals: {
        outbound: {},  // Format: {passengerType-index: [{meal details}]}
        return: {}     // Format: {passengerType-index: [{meal details}]}
    },
    baggage: {
        outbound: {},  // Format: {passengerType-index: {baggageDetails}}
        return: {}     // Format: {passengerType-index: {baggageDetails}}
    }
};
    // Add event listeners
   
    if (outboundSrdvIndex && returnSrdvIndex) {
    document.getElementById('baggage-btn').addEventListener('click', () => {
        // Create containers for both flights
        const containerDiv = document.getElementById('ssr-options-container');
        containerDiv.innerHTML = `
            <div class="flight-section mb-4">
                <h5>Outbound Flight</h5>
                <div id="options-container-outbound"></div>
            </div>
            <div class="flight-section">
                <h5>Return Flight</h5>
                <div id="options-container-return"></div>
            </div>
        `;
        
        // Log the values being passed
        console.log('Outbound baggage fetch:', {
            resultIndex: outboundResultIndex,
            srdvIndex: outboundSrdvIndex
        });
        console.log('Return baggage fetch:', {
            resultIndex: returnResultIndex,
            srdvIndex: returnSrdvIndex
        });

        // Fetch baggage data for both flights
        fetchSSRData('baggage', outboundResultIndex, outboundSrdvIndex, 'outbound');
        fetchSSRData('baggage', returnResultIndex, returnSrdvIndex, 'return');
    });

    // Similar structure for meal button
    document.getElementById('meal-btn').addEventListener('click', () => {
        // Similar container setup...
        const containerDiv = document.getElementById('ssr-options-container');
        containerDiv.innerHTML = `
            <div class="flight-section mb-4">
                <h5>Outbound Flight</h5>
                <div id="options-container-outbound"></div>
            </div>
            <div class="flight-section">
                <h5>Return Flight</h5>
                <div id="options-container-return"></div>
            </div>
        `;

        // Log the values being passed
        console.log('Outbound meal fetch:', {
            resultIndex: outboundResultIndex,
            srdvIndex: outboundSrdvIndex
        });
        console.log('Return meal fetch:', {
            resultIndex: returnResultIndex,
            srdvIndex: returnSrdvIndex
        });

        // Fetch meal data for both flights
        fetchSSRData('meal', outboundResultIndex, outboundSrdvIndex, 'outbound');
        fetchSSRData('meal', returnResultIndex, returnSrdvIndex, 'return');
    });
}



function fetchSSRData(type, passengerType, resultIndex, srdvIndex, direction, passengerIndex) {
            const containerId = `options-container-${direction}-${passengerType}-${passengerIndex}`;
            const container = document.getElementById(containerId);
            
            if (!container) {
                console.error(`Container not found: ${containerId}`);
                return;
            }

            // Show loading state
            container.innerHTML = '<div class="text-center">Loading options...</div>';

            const urlParams = new URLSearchParams(window.location.search);
            const traceId = urlParams.get('traceId');
            const allContainers = document.querySelectorAll('[id^="options-container-"]');
    allContainers.forEach(container => {
        container.style.display = 'none';
    });

            fetch("{{ route('fetch.ssr.data') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
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
                if (container) {
            container.style.display = 'block';
        }
                if (!data.success) {
                    container.innerHTML = `<p class="text-danger">This flight does not provide SSR services: ${data.message || 'No details available'}</p>`;
                    return;
                }

                if (type === 'baggage' && data.Baggage?.[0]?.length > 0) {
                    renderBaggageOptions(data.Baggage[0], container, `${passengerType}-${passengerIndex}-${direction}`);
                } else if (type === 'meal' && data.MealDynamic?.[0]?.length > 0) {
                    renderMealOptions(data.MealDynamic[0], container, `${passengerType}-${passengerIndex}-${direction}`);
                } else {
                    container.innerHTML = `<p>No ${type} options available for this flight.</p>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                container.innerHTML = `<p class="text-danger">Failed to load ${type} options. Please try again.</p>`;
                
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
    if (!baggageData || !baggageData.length) {
        container.innerHTML = '<p>No baggage options available.</p>';
        return;
    }
    const radioButtons = container.querySelectorAll('input[type="radio"]');
    radioButtons.forEach(radio => {
        radio.setAttribute('data-direction', passengerId.split('-')[2]); // Extract direction
    });

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
                                name="baggage_${passengerId}" 
                                value="${option.Code}" 
                                data-weight="${option.Weight}" 
                                data-price="${option.Price}"
                                data-description="${option.Description || ''}"
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
    // Extract direction (outbound/return) from passengerId
    const [type, index, direction] = passengerId.split('-');
    
    if (!window.passengerSelections.baggage[direction]) {
        window.passengerSelections.baggage[direction] = {};
    }
    
    const baggageOption = {
        Code: radio.value,
        Weight: radio.getAttribute('data-weight'),
        Price: parseFloat(radio.getAttribute('data-price')),
        Origin: radio.getAttribute('data-origin'),
        Destination: radio.getAttribute('data-destination'),
        Description: radio.getAttribute('data-description'),
        WayType: radio.getAttribute('data-wayType'),
        Currency: radio.getAttribute('data-currency')
    };
    
    // Store using the passenger type-index as key
    const passengerKey = `${type}-${index}`;
    window.passengerSelections.baggage[direction][passengerKey] = baggageOption;
    
    console.log(`Updated baggage selection for ${direction}:`, window.passengerSelections.baggage[direction]);
    showBaggageAlert(radio);
    const container = document.getElementById(`options-container-${passengerId}`);
    if (container) {
        container.style.display = 'none';
    }
};


function renderMealOptions(mealData, container, passengerId) {
    if (!mealData || !mealData.length) {
        container.innerHTML = '<p>No meal options available.</p>';
        return;
    }

    const checkboxes = container.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.setAttribute('data-direction', passengerId.split('-')[2]); // Extract direction
    });
    container.innerHTML = `
        <div class="meal-options-container">
            <h6 class="mb-4">Meal Options (Select Multiple)</h6>
            <div class="selected-meals-summary mb-3">
                <strong>Selected Meals: </strong>
                <div id="selectedMealsDisplay_${passengerId}" class="mt-2">
                    <em class="text-muted">No meals selected</em>
                </div>
            </div>
            ${mealData.map(meal => `
                <div class="meal-option">
                    <input 
                        type="checkbox" 
                        name="meal_${passengerId}" 
                        value="${meal.Code}" 
                        data-wayType="${meal.WayType}"
                        data-description="${meal.AirlineDescription || 'No Description'}"
                        data-origin="${meal.Origin}"
                        data-quantity="1"
                        data-currency="${meal.Currency}"
                        data-destination="${meal.Destination}"
                        data-price="${meal.Price}"
                        onchange="updateMealSelections(this, '${passengerId}')"
                    >
                    <label>
                        ${meal.AirlineDescription || 'No Meal'} 
                        (₹${meal.Price || 0})
                        <div class="meal-quantity">
                            <button type="button" class="quantity-btn" onclick="adjustQuantity(this, -1, '${passengerId}')" ${meal.Price ? '' : 'disabled'}>-</button>
                            <input type="number" min="1" max="5" value="1" class="quantity-input" 
                                onchange="updateMealQuantity(this, '${passengerId}')" ${meal.Price ? '' : 'disabled'}>
                            <button type="button" class="quantity-btn" onclick="adjustQuantity(this, 1, '${passengerId}')" ${meal.Price ? '' : 'disabled'}>+</button>
                        </div>
                    </label>
                </div>
            `).join('')}
        </div>
    `;


    // Add some styling for the selected meals display
    const style = document.createElement('style');
    style.textContent = `
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

// Fix the meal update function
window.updateMealSelections = function(checkbox, passengerId) {
    // Extract direction (outbound/return) from passengerId
    const [type, index, direction] = passengerId.split('-');
    
    if (!window.passengerSelections.meals[direction]) {
        window.passengerSelections.meals[direction] = {};
    }
    
    const passengerKey = `${type}-${index}`;
    if (!window.passengerSelections.meals[direction][passengerKey]) {
        window.passengerSelections.meals[direction][passengerKey] = [];
    }

    const mealData = {
        Code: checkbox.value,
        AirlineDescription: checkbox.getAttribute('data-description'),
        Origin: checkbox.getAttribute('data-origin'),
        Destination: checkbox.getAttribute('data-destination'),
        Price: parseFloat(checkbox.getAttribute('data-price')) || 0,
        WayType: checkbox.getAttribute('data-wayType'),
        Quantity: parseInt(checkbox.closest('.meal-option').querySelector('.quantity-input').value),
        Currency: checkbox.getAttribute('data-currency')
    };

    if (checkbox.checked) {
        window.passengerSelections.meals[direction][passengerKey].push(mealData);
    } else {
        window.passengerSelections.meals[direction][passengerKey] = 
            window.passengerSelections.meals[direction][passengerKey].filter(meal => meal.Code !== mealData.Code);
    }

    console.log(`Updated meal selection for ${direction}:`, window.passengerSelections.meals[direction]);
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


function fetchSeatMap(type, resultIndex, srdvIndex, direction, passengerType, passengerIndex) {
    const passengerId = `${passengerType}-${passengerIndex}`;
    const buttonId = `selectSeatBtn-${direction}-${passengerId}`;
    const button = document.getElementById(buttonId);
    
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
                title: `Select ${direction.charAt(0).toUpperCase() + direction.slice(1)} Flight Seat for ${passengerType} ${passengerIndex}`,
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
                    // Add current passenger ID and direction to the modal for reference
                    const modal = Swal.getPopup();
                    modal.setAttribute('data-passenger-id', passengerId);
                    modal.setAttribute('data-direction', direction);
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


    
// Keep your original selectSeat function unchanged, just add this line at the end:
function selectSeat(code, seatNumber, amount, airlineName, airlineCode, airlineNumber) {
    const modal = Swal.getPopup();
    const passengerId = modal.getAttribute('data-passenger-id');
    const direction = modal.getAttribute('data-direction');
    
    // Initialize seats object for both directions if it doesn't exist
    if (!window.passengerSelections.seats[direction]) {
        window.passengerSelections.seats[direction] = {};
    }

    // Store seat selection for specific direction and passenger
    window.passengerSelections.seats[direction][passengerId] = {
        code,
        seatNumber,
        amount,
        airlineName,
        airlineCode,
        airlineNumber
    };

    // Update seat info display for the specific passenger and direction
    const seatInfoElement = document.getElementById(`seatInfo-${direction}-${passengerId}`);
    if (seatInfoElement) {
        seatInfoElement.textContent = `Selected Seat: ${seatNumber} (₹${amount})`;
    }

    // Calculate total seat cost for all selections
    let totalSeatCost = 0;
    ['outbound', 'return'].forEach(dir => {
        if (window.passengerSelections.seats[dir]) {
            Object.values(window.passengerSelections.seats[dir]).forEach(seat => {
                totalSeatCost += parseFloat(seat.amount);
            });
        }
    });

    // Update total fare if the element exists
    const totalFareInput = document.getElementById('totalFare');
    if (totalFareInput) {
        const currentFare = parseFloat(totalFareInput.value) || 0;
        totalFareInput.value = currentFare + totalSeatCost;
    }

    // Show confirmation
    Swal.fire({
        icon: 'success',
        title: 'Seat Selected!',
        text: `${direction.charAt(0).toUpperCase() + direction.slice(1)} flight seat ${seatNumber} (₹${amount}) selected for ${passengerId}`,
        showConfirmButton: false,
        timer: 1500
    });
    updateTotalFare();
}

// Make sure selectSeat is available globally



// Make functions available globally
if (typeof window !== 'undefined') {
    window.fetchSSRData = fetchSSRData;
    window.fetchSeatMap = fetchSeatMap;
    window.selectSeat = selectSeat;
    
}
window.outboundFareQuoteData = outboundFareQuoteData;
window.returnFareQuoteData = returnFareQuoteData;


function calculateTotalPrice() {
    let total = 0;

    // Add base fares from both flights
    const outboundBaseFare = window.outboundFareQuoteData?.Fare?.OfferedFare || 0;
    const returnBaseFare = window.returnFareQuoteData?.Fare?.OfferedFare || 0;
    total += parseFloat(outboundBaseFare) + parseFloat(returnBaseFare);
    console.log('total fare and price',total);
    console.log('outbound baseFare',outboundBaseFare);
    console.log('return baseFare',returnBaseFare);


    // Iterate through all passenger selections for both flights
    ['outbound', 'return'].forEach(direction => {
        // Add seat prices
        const seatSelections = window.passengerSelections.seats[direction] || {};
        Object.values(seatSelections).forEach(seat => {
            if (seat && seat.amount) {
                total += parseFloat(seat.amount);
            }
        });

        // Add meal prices
        const mealSelections = window.passengerSelections.meals[direction] || {};
        Object.entries(mealSelections).forEach(([passengerId, meals]) => {
            meals.forEach(meal => {
                if (meal.Price && meal.Quantity) {
                    total += (parseFloat(meal.Price) * parseInt(meal.Quantity));
                }
            });
        });

        // Add baggage prices
        const baggageSelections = window.passengerSelections.baggage[direction] || {};
        Object.values(baggageSelections).forEach(baggage => {
            if (baggage && baggage.Price) {
                total += parseFloat(baggage.Price);
            }
        });
    });

    return total;
}

function getPassengerTypes() {
    // Get all unique passenger IDs from selections
    const passengerIds = new Set();
    ['outbound', 'return'].forEach(direction => {
        Object.keys(window.passengerSelections.seats[direction] || {}).forEach(id => passengerIds.add(id));
        Object.keys(window.passengerSelections.meals[direction] || {}).forEach(id => passengerIds.add(id));
        Object.keys(window.passengerSelections.baggage[direction] || {}).forEach(id => passengerIds.add(id));
    });
    return Array.from(passengerIds);
}

function calculateTotalPriceWithDetails() {
    const outboundFare = outboundFareQuoteData?.Fare || {};
    const returnFare = returnFareQuoteData?.Fare || {};

    // Calculate base components for both flights
    const baseFare = (parseFloat(outboundFare.OfferedFare) || 0) + (parseFloat(returnFare.OfferedFare) || 0);
    const tax = (parseFloat(outboundFare.Tax) || 0) + (parseFloat(returnFare.Tax) || 0);
    const yqTax = (parseFloat(outboundFare.YQTax) || 0) + (parseFloat(returnFare.YQTax) || 0);
    const transactionFee = (parseFloat(outboundFare.TransactionFee) || 0) + (parseFloat(returnFare.TransactionFee) || 0);
    const additionalTxnFeeOfrd = (parseFloat(outboundFare.AdditionalTxnFeeOfrd) || 0) + (parseFloat(returnFare.AdditionalTxnFeeOfrd) || 0);
    const additionalTxnFeePub = (parseFloat(outboundFare.AdditionalTxnFeePub) || 0) + (parseFloat(returnFare.AdditionalTxnFeePub) || 0);
    const airTransFee = (parseFloat(outboundFare.AirTransFee) || 0) + (parseFloat(returnFare.AirTransFee) || 0);

    // Calculate SSR costs by passenger
    const passengerCosts = {};
    const passengerIds = getPassengerTypes();

    passengerIds.forEach(passengerId => {
        passengerCosts[passengerId] = {
            outbound: { seats: 0, meals: 0, baggage: 0 },
            return: { seats: 0, meals: 0, baggage: 0 }
        };

        ['outbound', 'return'].forEach(direction => {
            // Add seat costs
            const seat = window.passengerSelections.seats[direction]?.[passengerId];
            if (seat?.amount) {
                passengerCosts[passengerId][direction].seats = parseFloat(seat.amount);
            }

            // Add meal costs
            const meals = window.passengerSelections.meals[direction]?.[passengerId] || [];
            meals.forEach(meal => {
                if (meal.Price && meal.Quantity) {
                    passengerCosts[passengerId][direction].meals += parseFloat(meal.Price) * parseInt(meal.Quantity);
                }
            });

            // Add baggage costs
            const baggage = window.passengerSelections.baggage[direction]?.[passengerId];
            if (baggage?.Price) {
                passengerCosts[passengerId][direction].baggage = parseFloat(baggage.Price);
            }
        });
    });

    // Calculate total SSR cost
    let totalSSRCost = 0;
    Object.values(passengerCosts).forEach(passenger => {
        ['outbound', 'return'].forEach(direction => {
            totalSSRCost += passenger[direction].seats + passenger[direction].meals + passenger[direction].baggage;
        });
    });

    return {
        grandTotal: baseFare + totalSSRCost,
        baseFare,
        tax,
        yqTax,
        transactionFee,
        additionalTxnFeeOfrd,
        additionalTxnFeePub,
        airTransFee,
        outboundBaseFare: outboundFare.BaseFare || 0,
        returnBaseFare: returnFare.BaseFare || 0,
        passengerCosts,
        totalSSRCost
    };
}

function updateTotalFare() {
    const priceDetails = calculateTotalPriceWithDetails();
    
    // Update the total in the UI
    const totalPriceElement = document.getElementById('totalPrice');
    if (totalPriceElement) {
        totalPriceElement.textContent = `₹${priceDetails.grandTotal.toFixed(2)}`;
    }

    // Update the breakdown section
    const breakdownElement = document.getElementById('priceBreakdown');
    if (breakdownElement) {
        let breakdown = `
            <div class="price-breakdown card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Price Breakdown</h5>
                    
                    <!-- Base Fares Section -->
                    <div class="base-fares mb-4">
                        <h6 class="fw-bold">Base Fares</h6>
                        <div class="ms-3">
                            <div>Outbound Flight: ₹${window.outboundFareQuoteData?.Fare?.OfferedFare || 0}</div>
                            <div>Return Flight: ₹${window.returnFareQuoteData?.Fare?.OfferedFare || 0}</div>
                        </div>
                    </div>

                    
                    </div>`;

        // Passenger-wise Breakdown
        breakdown += `<div class="passenger-selections mb-4">
            <h6 class="fw-bold">Passenger Selections</h6>`;

        Object.entries(priceDetails.passengerCosts).forEach(([passengerId, costs]) => {
            breakdown += `
                <div class="passenger-section mb-3">
                    <div class="fw-bold text-primary">${passengerId}</div>
                    
                    <!-- Outbound Flight -->
                    <div class="ms-3 mb-2">
                        <div class="fw-semibold">Outbound Flight:</div>
                        <div class="ms-3">
                            ${costs.outbound.seats > 0 ? `<div>Seat Selection: ₹${costs.outbound.seats.toFixed(2)}</div>` : ''}
                            ${costs.outbound.meals > 0 ? `<div>Meal Selection: ₹${costs.outbound.meals.toFixed(2)}</div>` : ''}
                            ${costs.outbound.baggage > 0 ? `<div>Baggage Selection: ₹${costs.outbound.baggage.toFixed(2)}</div>` : ''}
                        </div>
                    </div>
                    
                    <!-- Return Flight -->
                    <div class="ms-3">
                        <div class="fw-semibold">Return Flight:</div>
                        <div class="ms-3">
                            ${costs.return.seats > 0 ? `<div>Seat Selection: ₹${costs.return.seats.toFixed(2)}</div>` : ''}
                            ${costs.return.meals > 0 ? `<div>Meal Selection: ₹${costs.return.meals.toFixed(2)}</div>` : ''}
                            ${costs.return.baggage > 0 ? `<div>Baggage Selection: ₹${costs.return.baggage.toFixed(2)}</div>` : ''}
                        </div>
                    </div>
                </div>`;
        });

        breakdown += `</div>
                
                <!-- Grand Total -->
                <div class="grand-total mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Grand Total:</h5>
                        <h5 class="mb-0">₹${priceDetails.grandTotal.toFixed(2)}</h5>
                    </div>
                </div>
            </div>
        </div>`;
        
        breakdownElement.innerHTML = breakdown;
    }
}

// Make functions available globally
if (typeof window !== 'undefined') {
    window.calculateTotalPrice = calculateTotalPrice;
    window.calculateTotalPriceWithDetails = calculateTotalPriceWithDetails;
    window.updateTotalFare = updateTotalFare;
}




// Function to check flight balance
function checkFlightBalance() {
    return new Promise((resolve, reject) => {
        const outboundFare = outboundFareQuoteData?.Fare?.OfferedFare || 0;
        const returnFare = returnFareQuoteData?.Fare?.OfferedFare || 0;
        const totalFare = outboundFare + returnFare;
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
        const totalPriceDetails = calculateTotalPriceWithDetails();
        const isLCCoutbound = outboundFareQuoteData?.IsLCC ?? false;
        const isLCCreturn = returnFareQuoteData?.IsLCC ?? false;

        console.log('Is LCC Outbound:', isLCCoutbound);
        console.log('Is LCC Return:', isLCCreturn);

        let bookingPayloads = {
            lcc: {
                outbound: null,
                return: null
            },
            nonLcc: {
                outbound: null,
                return: null
            }
        };

        // Process passengers for both flights
        let passengers = [];
        
        document.querySelectorAll("#dynamicSections .card").forEach((card, index) => {
            // [Previous passenger processing code remains the same]
            const form = card.querySelector('.card-body');
            const headerText = card.querySelector('.card-header h6').textContent;
            const passengerTypeMatch = headerText.match(/(Adult|Child|Infant)/);
            const passengerTypeString = passengerTypeMatch ? passengerTypeMatch[1] : 'Unknown';
            const passengerIndex = (headerText.match(/\d+/) || [1])[0];
            const passengerId = `${passengerTypeString}-${passengerIndex}`;
            
            const typeMapping = {'Adult': 1, 'Child': 2, 'Infant': 3};
            const passengerType = typeMapping[passengerTypeString];


            function convertToISODateTime(dateString) {
                if (!dateString) return ''; // Return empty if no date is provided
                return `${dateString}T00:00:00`;
            }

            function convertToISODate(dateString) {
                if (!dateString) return '';
                return dateString.split('T')[0]; // Remove time part if exists
            }
            // Base passenger details
            let passenger = {
                title: form.querySelector('[name$="[Title]"]').value.trim(),
                firstName: form.querySelector('[name$="[FirstName]"]').value.trim(),
                lastName: form.querySelector('[name$="[LastName]"]').value.trim(),
                gender: (form.querySelector('[name$="[Gender]"]').value),
                contactNo: form.querySelector('[name$="[ContactNo]"]')?.value.trim() || "",
                email: form.querySelector('[name$="[Email]"]')?.value.trim() || "",
                dateOfBirth: convertToISODateTime(form.querySelector('[name$="[DateOfBirth]"]')?.value || ""),
                paxType: passengerType,
                addressLine1: form.querySelector('[name$="[AddressLine1]"]')?.value.trim() || "",
                passportNo: form.querySelector('[name$="[PassportNo]"]')?.value.trim() || "",
                passportExpiry: convertToISODateTime(form.querySelector('[name$="[PassportExpiry]"]')?.value || ""),
                passportIssueDate: form.querySelector('[name$="[PassportIssueDate]"]')?.value || "",
                addressLine1: origin,
                    city: origin,
                    countryCode: "IN",
                    countryName: "INDIA",
                    isLeadPax: index === 0, // First passenger is lead passenger

            };

            // Selected services for both flights
            const services = {
                outbound: {
                    seat: window.passengerSelections.seats.outbound?.[passengerId] || null,
                    baggage: window.passengerSelections.baggage.outbound?.[passengerId] || null,
                    meals: window.passengerSelections.meals.outbound?.[passengerId] || []
                },
                return: {
                    seat: window.passengerSelections.seats.return?.[passengerId] || null,
                    baggage: window.passengerSelections.baggage.return?.[passengerId] || null,
                    meals: window.passengerSelections.meals.return?.[passengerId] || []
                }
            };

            // Passenger processing and service calculations remain the same
            const calculateSSRCost = (services) => {
                let cost = 0;
                if (services.seat) cost += parseFloat(services.seat.amount) || 0;
                if (services.baggage) cost += parseFloat(services.baggage.Price) || 0;
                if (services.meals.length > 0) {
                    services.meals.forEach(meal => {
                        cost += (parseFloat(meal.Price) || 0) * (parseInt(meal.Quantity) || 1);
                    });
                }
                return cost;
            };

            // Process outbound flight
            if (isLCCoutbound) {
                // LCC outbound passenger processing
                const outboundPassenger = {
                    ...passenger,
                    selectedServices: services.outbound,
                    totalSSRCost: calculateSSRCost(services.outbound),
                    fare: [{
                        baseFare: parseFloat(outboundFareQuoteData.Fare.BaseFare),
                        tax: parseFloat(outboundFareQuoteData.Fare.Tax),
                        yqTax: parseFloat(outboundFareQuoteData.Fare.YQTax || 0),
                        transactionFee: (outboundFareQuoteData.Fare.TransactionFee || '0').toString(),
                        additionalTxnFeeOfrd: parseFloat(outboundFareQuoteData.Fare.AdditionalTxnFeeOfrd || 0),
                        additionalTxnFeePub: parseFloat(outboundFareQuoteData.Fare.AdditionalTxnFeePub || 0),
                        airTransFee: (outboundFareQuoteData.Fare.AirTransFee || '0').toString()
                    }],
                    
                };
                if (!bookingPayloads.lcc.outbound) bookingPayloads.lcc.outbound = { passengers: [] };
                bookingPayloads.lcc.outbound.passengers.push(outboundPassenger);
            } else {
                // Non-LCC outbound passenger processing
                if (!bookingPayloads.nonLcc.outbound) bookingPayloads.nonLcc.outbound = { passengers: [] };
                bookingPayloads.nonLcc.outbound.passengers.push(passenger);
            }

            // Process return flight
            if (isLCCreturn) {
                // LCC return passenger processing
                const returnPassenger = {
                    ...passenger,
                    selectedServices: services.return,
                    totalSSRCost: calculateSSRCost(services.return),
                    fare: [{
                        baseFare: parseFloat(returnFareQuoteData.Fare.BaseFare),
                        tax: parseFloat(returnFareQuoteData.Fare.Tax),
                        yqTax: parseFloat(returnFareQuoteData.Fare.YQTax || 0),
                        transactionFee: (returnFareQuoteData.Fare.TransactionFee || '0').toString(),
                        additionalTxnFeeOfrd: parseFloat(returnFareQuoteData.Fare.AdditionalTxnFeeOfrd || 0),
                        additionalTxnFeePub: parseFloat(returnFareQuoteData.Fare.AdditionalTxnFeePub || 0),
                        airTransFee: (returnFareQuoteData.Fare.AirTransFee || '0').toString()
                    }],
                   
                };
                if (!bookingPayloads.lcc.return) bookingPayloads.lcc.return = { passengers: [] };
                bookingPayloads.lcc.return.passengers.push(returnPassenger);
            } else {
                // Non-LCC return passenger processing
                if (!bookingPayloads.nonLcc.return) bookingPayloads.nonLcc.return = { passengers: [] };
                bookingPayloads.nonLcc.return.passengers.push(passenger);
            }
        });

        // First process non-LCC bookings
        let nonLccResults = [];
        let lccBookingDetails = {};
        
        // Handle non-LCC bookings first
        let nonLccBookingDetails = {
            outbound: null,
            return: null
        };

        // Handle non-LCC bookings first
     
        if (!isLCCoutbound && bookingPayloads.nonLcc.outbound) {
            const outboundResult = await processNonLCCBooking({
                srdvIndex: outboundSrdvIndex,
                traceId: traceId,
                resultIndex: outboundResultIndex,
                passengers: bookingPayloads.nonLcc.outbound.passengers.map(pax => ({
                    ...pax,
                    fare: [{
                        baseFare: parseFloat(outboundFareQuoteData.Fare.BaseFare),
                        tax: parseFloat(outboundFareQuoteData.Fare.Tax),
                        yqTax: parseFloat(outboundFareQuoteData.Fare.YQTax || 0),
                        transactionFee: (outboundFareQuoteData.Fare.TransactionFee || '0').toString(),
                        additionalTxnFeeOfrd: parseFloat(outboundFareQuoteData.Fare.AdditionalTxnFeeOfrd || 0),
                        additionalTxnFeePub: parseFloat(outboundFareQuoteData.Fare.AdditionalTxnFeePub || 0),
                        airTransFee: (outboundFareQuoteData.Fare.AirTransFee || '0').toString()
                    }]
                })),
                gst: {
                    companyAddress: document.querySelector('[name="GSTCompanyAddress"]')?.value || '',
                    companyContactNumber: document.querySelector('[name="GSTCompanyContact"]')?.value || '',
                    companyName: document.querySelector('[name="GSTCompanyName"]')?.value || '',
                    number: document.querySelector('[name="GSTNumber"]')?.value || '',
                    companyEmail: document.querySelector('[name="GSTCompanyEmail"]')?.value || ''
                }
            });
            
            nonLccBookingDetails.outbound = {
                resultIndex: outboundResultIndex,
                srdvIndex: outboundSrdvIndex,
                traceId: traceId,
                totalFare: outboundFareQuoteData.Fare.OfferedFare,
                bookingId: outboundResult.bookingId,
                pnr: outboundResult.pnr,
                passengers: outboundResult.passengers,
                gst: outboundResult.gst
            };
        }

        if (!isLCCreturn && bookingPayloads.nonLcc.return) {
            const returnResult = await processNonLCCBooking({
                srdvIndex: returnSrdvIndex,
                traceId: traceId,
                resultIndex: returnResultIndex,
                passengers: bookingPayloads.nonLcc.return.passengers.map(pax => ({
                    ...pax,
                    fare: [{
                        baseFare: parseFloat(returnFareQuoteData.Fare.BaseFare),
                        tax: parseFloat(returnFareQuoteData.Fare.Tax),
                        yqTax: parseFloat(returnFareQuoteData.Fare.YQTax || 0),
                        transactionFee: (returnFareQuoteData.Fare.TransactionFee || '0').toString(),
                        additionalTxnFeeOfrd: parseFloat(returnFareQuoteData.Fare.AdditionalTxnFeeOfrd || 0),
                        additionalTxnFeePub: parseFloat(returnFareQuoteData.Fare.AdditionalTxnFeePub || 0),
                        airTransFee: (returnFareQuoteData.Fare.AirTransFee || '0').toString()
                    }]
                })),
                gst: {
                    companyAddress: document.querySelector('[name="GSTCompanyAddress"]')?.value || '',
                    companyContactNumber: document.querySelector('[name="GSTCompanyContact"]')?.value || '',
                    companyName: document.querySelector('[name="GSTCompanyName"]')?.value || '',
                    number: document.querySelector('[name="GSTNumber"]')?.value || '',
                    companyEmail: document.querySelector('[name="GSTCompanyEmail"]')?.value || ''
                }
            });
            
            nonLccBookingDetails.return = {
                resultIndex: returnResultIndex,
                srdvIndex: returnSrdvIndex,
                traceId: traceId,
                totalFare: returnFareQuoteData.Fare.OfferedFare,
                bookingId: returnResult.bookingId,
                pnr: returnResult.pnr,
                passengers: returnResult.passengers,
                gst: returnResult.gst
            };
        }

        // Then process LCC bookings
        if (isLCCoutbound || isLCCreturn) {
            lccBookingDetails = {
                outbound: isLCCoutbound ? {
                    resultIndex: outboundResultIndex,
                    srdvIndex: outboundSrdvIndex,
                    traceId: traceId,
                    totalFare: outboundFareQuoteData.Fare.OfferedFare || 0,
                    ...bookingPayloads.lcc.outbound
                } : null,
                return: isLCCreturn ? {
                    resultIndex: returnResultIndex,
                    srdvIndex: returnSrdvIndex,
                    traceId: traceId,
                    totalFare: returnFareQuoteData.Fare.OfferedFare || 0,
                    ...bookingPayloads.lcc.return
                } : null
            };
        }


        let decodedUrlDetails;
try {
    const encodedDetails = new URLSearchParams(window.location.search).get('details');
    decodedUrlDetails = encodedDetails ? JSON.parse(decodeURIComponent(encodedDetails)) : null;
} catch (error) {
    console.error('Error parsing URL details:', error);
    decodedUrlDetails = null;
}
        // Combine all booking details for the payment page
        const finalBookingDetails = {
            lcc: Object.keys(lccBookingDetails).length > 0 ? lccBookingDetails : null,
            nonLcc: (nonLccBookingDetails.outbound || nonLccBookingDetails.return) ? nonLccBookingDetails : null,
            urlDetails: decodedUrlDetails,
            grandTotal: totalPriceDetails.grandTotal,
        };

        console.log("Is LCC Outbound:", isLCCoutbound);
console.log("Is LCC Return:", isLCCreturn);

console.log("Non-LCC Outbound Passengers:", bookingPayloads.nonLcc.outbound);
console.log("Non-LCC Return Passengers:", bookingPayloads.nonLcc.return);

console.log("Processing Non-LCC Outbound:", !isLCCoutbound && bookingPayloads.nonLcc.outbound);
console.log("Processing Non-LCC Return:", !isLCCreturn && bookingPayloads.nonLcc.return);




        // Redirect to payment pagegit 
        const encodedDetails = encodeURIComponent(JSON.stringify(finalBookingDetails));
        console.log("Final Booking Details:", JSON.stringify(finalBookingDetails, null, 2));
        console.log('Encoded Details:', decodeURIComponent(new URLSearchParams(window.location.search).get('details')));

        window.location.href = `/flight/payment?details=${encodedDetails}`;

    } catch (error) {
        console.error('Error during booking process:', error);
        if (window.Swal) {
            Swal.fire({
                icon: 'error',
                title: 'Booking Failed',
                text: error.message || 'An error occurred during booking'
            });
        } else {
            alert('Booking failed: ' + (error.message || 'An error occurred'));
        }
    }
});

// Helper function for non-LCC bookings
async function processNonLCCBooking(payload) {
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
        const bookingDetails = {
            bookingId: data.booking_details.booking_id,
            pnr: data.booking_details.pnr,
            srdvIndex: data.booking_details.srdvIndex,
            traceId: data.booking_details.trace_id,
            passengers: payload.passengers,
            gst: payload.gst,
            isOutbound: payload.srdvIndex === outboundSrdvIndex
        };

        // Fix: Ensure we're working with an array
        let existingDetails;
        try {
            existingDetails = JSON.parse(sessionStorage.getItem('bookingDetails'));
            // Check if parsed result is an array, if not, create new array
            if (!Array.isArray(existingDetails)) {
                existingDetails = [];
            }
        } catch (error) {
            // If parsing fails, start with empty array
            existingDetails = [];
        }

        existingDetails.push(bookingDetails);
        sessionStorage.setItem('bookingDetails', JSON.stringify(existingDetails));

        return bookingDetails;
    } else {
        throw new Error(data.message || 'Booking failed');
    }
}

}); 



</script>
@endsection
