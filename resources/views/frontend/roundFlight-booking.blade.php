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
                    <div class="card mb-3" style="display: none;">
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

function validatePassengerForm() {
    // Clear previous errors
    document.querySelectorAll('.validation-error').forEach(el => el.remove());
    
    let isValid = true;
    
    // Process each passenger form
    document.querySelectorAll("#dynamicSections .card").forEach(card => {
        const form = card.querySelector('.card-body');
        const passengerType = card.querySelector('.card-header h6').textContent.match(/(Adult|Child|Infant)/)?.[1] || 'Unknown';
        
        // Define validation rules based on passenger type
        const validators = {
            '[FirstName]': { required: true },
            '[LastName]': { required: true },
            '[DateOfBirth]': { 
                required: true,
                custom: (value) => {
                    const birthDate = new Date(value);
                    const age = calculateAge(birthDate, new Date());
                    
                    if (passengerType === 'Adult' && age < 12)
                        return 'Adult must be 12 years or older';
                    if (passengerType === 'Child' && (age < 2 || age >= 12))
                        return 'Child must be between 2 and 11 years old';
                    if (passengerType === 'Infant' && age >= 2)
                        return 'Infant must be under 2 years old';
                    return null;
                }
            },
            '[ContactNo]': { 
                required: true, 
                pattern: /^\+?[0-9\s\-()]{8,20}$/,
                message: 'Please enter a valid phone number'
            },
            '[Email]': { 
                required: true, 
                pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                message: 'Please enter a valid email address'
            }
        };
        
        // Add passport validators for all passenger types
        if (['Adult', 'Child', 'Infant'].includes(passengerType)) {
            validators['[PassportNo]'] = { 
                required: true, 
                pattern: /^[A-Z][0-9]{7}$/,
                message: 'Please enter a valid Indian passport number (one letter followed by 7 digits)'
            };
            validators['[PassportExpiry]'] = { 
                required: true,
                custom: (value) => {
                    return new Date(value) <= new Date() ? 'Passport has expired' : null;
                }
            };
            validators['[PassportIssueDate]'] = { 
                required: true,
                custom: (value, formData) => {
                    const expiryDate = new Date(formData.find(f => f.name.includes('[PassportExpiry]'))?.value || 0);
                    return new Date(value) >= expiryDate ? 'Issue date cannot be after expiry date' : null;
                }
            };
        }
        
        // Get all form fields
        const formData = Array.from(form.querySelectorAll('input, select'))
            .map(field => ({ field, name: field.getAttribute('name'), value: field.value.trim() }));
        
        // Validate each field
        Object.entries(validators).forEach(([fieldSuffix, rules]) => {
            const fieldData = formData.find(f => f.name && f.name.includes(fieldSuffix));
            if (!fieldData) return;
            
            const { field, value } = fieldData;
            field.classList.remove('is-invalid');
            
            // Required check
            if (rules.required && !value) {
                showError(field, `${fieldSuffix.replace(/[\[\]]/g, '')} is required`);
                isValid = false;
                return;
            }
            
            // Pattern check
            if (rules.pattern && value && !rules.pattern.test(value)) {
                showError(field, rules.message);
                isValid = false;
                return;
            }
            
            // Custom validation
            if (rules.custom && value) {
                const errorMessage = rules.custom(value, formData);
                if (errorMessage) {
                    showError(field, errorMessage);
                    isValid = false;
                }
            }
        });
    });
    
    return isValid;
}

// Helper functions
function calculateAge(birthDate, currentDate) {
    let age = currentDate.getFullYear() - birthDate.getFullYear();
    const monthDiff = currentDate.getMonth() - birthDate.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && currentDate.getDate() < birthDate.getDate())) {
        age--;
    }
    
    return age;
}

function showError(element, message) {
    // Remove existing error
    const existingError = element.nextElementSibling;
    if (existingError && existingError.classList.contains('validation-error')) {
        existingError.remove();
    }
    
    // Create and insert error message
    const errorDiv = document.createElement('div');
    errorDiv.className = 'validation-error text-danger small mt-1';
    errorDiv.textContent = message;
    element.parentNode.insertBefore(errorDiv, element.nextSibling);
    
    // Highlight input
    element.classList.add('is-invalid');
}

function setupInputListeners() {
    document.querySelectorAll('#dynamicSections input, #dynamicSections select').forEach(element => {
        // Use 'input' for text fields and 'change' for selects/dates
        const eventType = element.tagName === 'SELECT' || element.type === 'date' ? 'change' : 'input';
        element.addEventListener(eventType, () => validateSingleField(element));
    });
}

function validateSingleField(field) {
    // Get field name and value
    const name = field.getAttribute('name');
    const value = field.value.trim();
    
    // Clear previous error
    const nextElement = field.nextElementSibling;
    if (nextElement && nextElement.classList.contains('validation-error')) {
        nextElement.remove();
    }
    
    field.classList.remove('is-invalid');
    
    // Skip if empty (full form validation will catch required fields)
    if (!value) return;
    
    // Validate based on field type
    if (name.includes('[Email]') && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
        showError(field, 'Please enter a valid email address');
    } else if (name.includes('[ContactNo]') && !/^\+?[0-9\s\-()]{8,20}$/.test(value)) {
        showError(field, 'Please enter a valid phone number');
    } else if (name.includes('[PassportNo]') && !/^[A-Z][0-9]{7}$/.test(value)) {
        showError(field, 'Please enter a valid Indian passport number (one letter followed by 7 digits)');
    } else if (name.includes('[PassportExpiry]') && new Date(value) <= new Date()) {
        showError(field, 'Passport has expired');
    }
}
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
                        <label class="form-label">Passport Issue Date</label>
                        <input type="date" class="form-control" name="${passengerType}[${i}][PassportIssueDate]" required>
                    </div>
                       <div class="col-md-4 mb-3">
                        <label class="form-label">Passport Expiry</label>
                        <input type="date" class="form-control" name="${passengerType}[${i}][PassportExpiry]" required>
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
    setupInputListeners();
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
            const totalFare = (outboundFareQuoteData?.Fare?.PublishedFare || 0) + 
                              (returnFareQuoteData?.Fare?.PublishedFare || 0);
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
    
    // Update the total fare immediately after baggage selection
    updateTotalFare();
    
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
                 .btn-close-meal {
        border: none;
        background: none;
        color: #dc3545;
        font-weight: bold;
        cursor: pointer;
        margin-left: 8px;
    }
    `;
    document.head.appendChild(style);
}

// Store selected meals in an array
window.selectedMealOptions = [];

window.updateMealSelections = function(checkbox, passengerId) {
    // Extract direction (outbound/return) from passengerId
    const [type, index, direction] = passengerId.split('-');
    
    // Initialize meals structure if it doesn't exist
    if (!window.passengerSelections.meals[direction]) {
        window.passengerSelections.meals[direction] = {};
    }
    
    // Create a key for this passenger
    const passengerKey = `${type}-${index}`;
    
    // Initialize array for this passenger if it doesn't exist
    if (!window.passengerSelections.meals[direction][passengerKey]) {
        window.passengerSelections.meals[direction][passengerKey] = [];
    }

    const mealData = {
        Code: checkbox.value,
        Name: checkbox.getAttribute('data-description'),
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
        // Add the meal to the array
        window.passengerSelections.meals[direction][passengerKey].push(mealData);
    } else {
        // Remove the meal from the array
        window.passengerSelections.meals[direction][passengerKey] = 
            window.passengerSelections.meals[direction][passengerKey].filter(meal => meal.Code !== mealData.Code);
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
window.updateMealQuantity = function(input, passengerId) {
    // Extract direction (outbound/return) from passengerId
    const [type, index, direction] = passengerId.split('-');
    const passengerKey = `${type}-${index}`;
    
    const checkbox = input.closest('.meal-option').querySelector(`input[name="meal_option_${passengerId}"]`);
    if (checkbox.checked) {
        // Find the meal in the passenger's selections
        if (window.passengerSelections.meals[direction] && 
            window.passengerSelections.meals[direction][passengerKey]) {
            
            const mealIndex = window.passengerSelections.meals[direction][passengerKey]
                .findIndex(meal => meal.Code === checkbox.value);
            
            if (mealIndex !== -1) {
                // Update the quantity
                window.passengerSelections.meals[direction][passengerKey][mealIndex].Quantity = parseInt(input.value);
                updateMealDisplay(passengerId);
                updateTotalFare();
            }
        }
    }
};


function updateMealDisplay(passengerId) {
    const displayElement = document.getElementById(`selectedMealsDisplay_${passengerId}`);
    if (!displayElement) return;

    // Extract direction (outbound/return) from passengerId
    const [type, index, direction] = passengerId.split('-');
    const passengerKey = `${type}-${index}`;
    
    const selectedMeals = window.passengerSelections.meals[direction]?.[passengerKey] || [];
    
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
window.removeMeal = function(mealCode, passengerId) {
    // Extract direction (outbound/return) from passengerId
    const [type, index, direction] = passengerId.split('-');
    const passengerKey = `${type}-${index}`;
    
    // Uncheck the checkbox
    document.getElementById(`meal_${mealCode}_${passengerId}`).checked = false;
    
    // Remove from selections array
    if (window.passengerSelections.meals[direction] && 
        window.passengerSelections.meals[direction][passengerKey]) {
        
        window.passengerSelections.meals[direction][passengerKey] = 
            window.passengerSelections.meals[direction][passengerKey].filter(meal => meal.Code !== mealCode);
    }
    
    // Update displays
    updateMealDisplay(passengerId);
    updateTotalFare();
};
// Update quantity handling to refresh the display
window.updateMealQuantity = function(input, passengerId) {
    // Extract direction (outbound/return) from passengerId
    const [type, index, direction] = passengerId.split('-');
    const passengerKey = `${type}-${index}`;
    
    const checkbox = input.closest('.meal-option').querySelector(`input[name="meal_option_${passengerId}"]`);
    if (checkbox.checked) {
        // Find the meal in the passenger's selections
        if (window.passengerSelections.meals[direction] && 
            window.passengerSelections.meals[direction][passengerKey]) {
            
            const mealIndex = window.passengerSelections.meals[direction][passengerKey]
                .findIndex(meal => meal.Code === checkbox.value);
            
            if (mealIndex !== -1) {
                // Update the quantity
                window.passengerSelections.meals[direction][passengerKey][mealIndex].Quantity = parseInt(input.value);
                updateMealDisplay(passengerId);
                updateTotalFare();
            }
        }
    }
};

window.adjustQuantity = function(button, change, passengerId) {
    const input = button.parentElement.querySelector('.quantity-input');
    const newValue = parseInt(input.value) + change;
    
    // Set limits (1-5)
    if (newValue >= 1 && newValue <= 5) {
        input.value = newValue;
        
        // Call the updateMealQuantity function to update the selection data
        window.updateMealQuantity(input, passengerId);
    }
};

// Function to show meal selection alert
function showMealSelectionAlert(passengerId) {
    // Extract direction (outbound/return) from passengerId
    const [type, index, direction] = passengerId.split('-');
    const passengerKey = `${type}-${index}`;
    
    const selectedMeals = window.passengerSelections.meals[direction]?.[passengerKey] || [];
    
    if (window.Swal && selectedMeals.length > 0) {
        const mealSummary = selectedMeals.map(meal => 
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
    const outboundBaseFare = window.outboundFareQuoteData?.Fare?.PublishedFare || 0;
    const returnBaseFare = window.returnFareQuoteData?.Fare?.PublishedFare || 0;
    total += parseFloat(outboundBaseFare) + parseFloat(returnBaseFare);
    console.log('total fare and price', total);
    console.log('outbound baseFare', outboundBaseFare);
    console.log('return baseFare', returnBaseFare);

    // Iterate through all passenger selections for both flights
    ['outbound', 'return'].forEach(direction => {
        // Add seat prices
        const seatSelections = window.passengerSelections.seats[direction] || {};
        Object.values(seatSelections).forEach(seat => {
            if (seat && seat.amount) {
                total += parseFloat(seat.amount);
            }
        });

        // Add meal prices - FIXED: Properly calculate meal prices with quantity
        const mealSelections = window.passengerSelections.meals[direction]?.[passengerId] || [];
        Object.entries(mealSelections).forEach(([passengerId, meals]) => {
            if (Array.isArray(meals)) {  // ADDED: Check if meals is an array
                meals.forEach(meal => {
                    if (meal && meal.Price && meal.Quantity) {
                        total += (parseFloat(meal.Price) * parseInt(meal.Quantity, 10));
                    }
                });
            }
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

// No changes needed in getPassengerTypes()
function getPassengerTypes() {
    const passengerIds = new Set();
    ['outbound', 'return'].forEach(direction => {
        Object.keys(window.passengerSelections.seats[direction] || {}).forEach(id => passengerIds.add(id));
        Object.keys(window.passengerSelections.meals[direction] || {}).forEach(id => passengerIds.add(id));
        Object.keys(window.passengerSelections.baggage[direction] || {}).forEach(id => passengerIds.add(id));
    });
    return Array.from(passengerIds);
}
function calculateTotalPriceWithDetails() {
    const outboundFare = window.outboundFareQuoteData?.Fare || {};
    const returnFare = window.returnFareQuoteData?.Fare || {};

    // Calculate base components for both flights
    const baseFare = (parseFloat(outboundFare.PublishedFare) || 0) + (parseFloat(returnFare.PublishedFare) || 0);
    const tax = (parseFloat(outboundFare.Tax) || 0) + (parseFloat(returnFare.Tax) || 0);
    const yqTax = (parseFloat(outboundFare.YQTax) || 0) + (parseFloat(returnFare.YQTax) || 0);
    const transactionFee = (parseFloat(outboundFare.TransactionFee) || 0) + (parseFloat(returnFare.TransactionFee) || 0);
    const additionalTxnFeeOfrd = (parseFloat(outboundFare.AdditionalTxnFeeOfrd) || 0) + (parseFloat(returnFare.AdditionalTxnFeeOfrd) || 0);
    const additionalTxnFeePub = (parseFloat(outboundFare.AdditionalTxnFeePub) || 0) + (parseFloat(returnFare.AdditionalTxnFeePub) || 0);
    const airTransFee = (parseFloat(outboundFare.AirTransFee) || 0) + (parseFloat(returnFare.AirTransFee) || 0);

    // Get all passenger IDs from all selection types
    const passengerKeys = new Set();
    ['outbound', 'return'].forEach(direction => {
        // Collect from seats
        if (window.passengerSelections.seats[direction]) {
            Object.keys(window.passengerSelections.seats[direction]).forEach(key => passengerKeys.add(key));
        }
        
        // Collect from meals
        if (window.passengerSelections.meals[direction]) {
            Object.keys(window.passengerSelections.meals[direction]).forEach(key => passengerKeys.add(key));
        }
        
        // Collect from baggage
        if (window.passengerSelections.baggage[direction]) {
            Object.keys(window.passengerSelections.baggage[direction]).forEach(key => passengerKeys.add(key));
        }
    });

    // Calculate SSR costs by passenger
    const passengerCosts = {};
    
    passengerKeys.forEach(passengerId => {
        passengerCosts[passengerId] = {
            outbound: { seats: 0, meals: 0, baggage: 0, seatDetails: '', baggageDetails: '', mealDetails: [] },
            return: { seats: 0, meals: 0, baggage: 0, seatDetails: '', baggageDetails: '', mealDetails: [] }
        };

        ['outbound', 'return'].forEach(direction => {
            // Add seat costs and details
            const seat = window.passengerSelections.seats[direction]?.[passengerId];
            if (seat?.amount) {
                passengerCosts[passengerId][direction].seats = parseFloat(seat.amount);
                passengerCosts[passengerId][direction].seatDetails = seat.seatNumber || '';
            }

            // Add meal costs and details
            const meals = window.passengerSelections.meals[direction]?.[passengerId] || [];
            if (Array.isArray(meals)) {
                meals.forEach(meal => {
                    if (meal?.Price && meal?.Quantity) {
                        const mealCost = parseFloat(meal.Price) * parseInt(meal.Quantity, 10);
                        passengerCosts[passengerId][direction].meals += mealCost;
                        passengerCosts[passengerId][direction].mealDetails.push({
                            name: meal.AirlineDescription || 'Meal',
                            quantity: meal.Quantity,
                            price: mealCost
                        });
                    }
                });
            }

            // Add baggage costs and details
            const baggage = window.passengerSelections.baggage[direction]?.[passengerId];
            if (baggage?.Price) {
                passengerCosts[passengerId][direction].baggage = parseFloat(baggage.Price);
                passengerCosts[passengerId][direction].baggageDetails = baggage.Weight ? baggage.Weight + ' kg' : '';
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
        outboundBaseFare: parseFloat(outboundFare.BaseFare) || 0,
        returnBaseFare: parseFloat(returnFare.BaseFare) || 0,
        passengerCosts,
        totalSSRCost
    };
}

function updateTotalFare() {
    const priceDetails = calculateTotalPriceWithDetails();
    
    // Update the total in the UI
    const totalPriceElement = document.getElementById('totalPrice');
    if (totalPriceElement) {
        totalPriceElement.innerHTML = `
            `;
    }

    // Update the breakdown section
    const breakdownElement = document.getElementById('priceBreakdown');
    if (breakdownElement) {
        let breakdown = `
            <div class="price-breakdown-container">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary bg-gradient text-white py-3">
                        <h4 class="card-title mb-0 text-center">
                            <i class="fas fa-receipt me-2"></i>Detailed Price Breakdown
                        </h4>
                    </div>
                    
                    <div class="card-body p-4">
                        <!-- Base Fares Section -->
                        <div class="base-fares-section mb-4">
                            <div class="section-header bg-light p-3 rounded-top border-start border-4 border-primary">
                                <h5 class="mb-0 text-primary">
                                    <i class="fas fa-plane-departure me-2"></i>Base Fares
                                </h5>
                            </div>
                            <div class="section-content p-3 border rounded-bottom">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="fare-card bg-light p-3 rounded text-center">
                                            <div class="text-primary mb-2"><i class="fas fa-plane-departure fa-2x"></i></div>
                                            <h6>Outbound Flight</h6>
                                            <h5 class="text-success mb-0">₹${window.outboundFareQuoteData?.Fare?.PublishedFare || 0}</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="fare-card bg-light p-3 rounded text-center">
                                            <div class="text-primary mb-2"><i class="fas fa-plane-arrival fa-2x"></i></div>
                                            <h6>Return Flight</h6>
                                            <h5 class="text-success mb-0">₹${window.returnFareQuoteData?.Fare?.PublishedFare || 0}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;

        // Passenger-wise Breakdown
        breakdown += `<div class="passenger-selections">
                    <div class="section-header bg-light p-3 rounded-top border-start border-4 border-primary">
                        <h5 class="mb-0 text-primary">
                            <i class="fas fa-users me-2"></i>Passenger Selections
                        </h5>
                    </div>`;

        Object.entries(priceDetails.passengerCosts).forEach(([passengerId, costs]) => {
            breakdown += `
                <div class="passenger-card mb-4 border rounded-bottom p-3">
                    <div class="passenger-header bg-light p-2 rounded mb-3">
                        <h6 class="mb-0 text-primary">
                            <i class="fas fa-user-circle me-2"></i>${passengerId}
                        </h6>
                    </div>
                    
                    <div class="row g-4">
                        <!-- Outbound Flight Selections -->
                        <div class="col-md-6">
                            <div class="flight-selections p-3 bg-light rounded">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-plane-departure me-2"></i>Outbound Selections
                                </h6>
                                <div class="selection-items">
                                    ${costs.outbound.seats > 0 ? `
                                        <div class="selection-item d-flex align-items-center mb-2">
                                            <div class="icon-wrapper me-2">
                                                <i class="fas fa-chair text-success"></i>
                                            </div>
                                            <div class="flex-grow-1">Seat ${costs.outbound.seatDetails}</div>
                                            <div class="price text-success">₹${costs.outbound.seats.toFixed(2)}</div>
                                        </div>` : ''}
                                    ${costs.outbound.mealDetails.map(meal => `
                                        <div class="selection-item d-flex align-items-center mb-2">
                                            <div class="icon-wrapper me-2">
                                                <i class="fas fa-utensils text-warning"></i>
                                            </div>
                                            <div class="flex-grow-1">${meal.name}(Qty:${meal.quantity})</div>
                                            <div class="price text-success">₹${meal.price.toFixed(2)}</div>
                                        </div>`).join('')}
                                    ${costs.outbound.baggage > 0 ? `
                                        <div class="selection-item d-flex align-items-center">
                                            <div class="icon-wrapper me-2">
                                                <i class="fas fa-suitcase text-info"></i>
                                            </div>
                                            <div class="flex-grow-1">Baggage ${costs.outbound.baggageDetails}</div>
                                            <div class="price text-success">₹${costs.outbound.baggage.toFixed(2)}</div>
                                        </div>` : ''}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Return Flight Selections -->
                        <div class="col-md-6">
                            <div class="flight-selections p-3 bg-light rounded">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-plane-arrival me-2"></i>Return Selections
                                </h6>
                                <div class="selection-items">
                                    ${costs.return.seats > 0 ? `
                                        <div class="selection-item d-flex align-items-center mb-2">
                                            <div class="icon-wrapper me-2">
                                                <i class="fas fa-chair text-success"></i>
                                            </div>
                                            <div class="flex-grow-1">Seat ${costs.return.seatDetails}</div>
                                            <div class="price text-success">₹${costs.return.seats.toFixed(2)}</div>
                                        </div>` : ''}
                                    ${costs.return.mealDetails.map(meal => `
                                        <div class="selection-item d-flex align-items-center mb-2">
                                            <div class="icon-wrapper me-2">
                                                <i class="fas fa-utensils text-warning"></i>
                                            </div>
                                            <div class="flex-grow-1">${meal.name} (Qty:${meal.quantity})</div>
                                            <div class="price text-success">₹${meal.price.toFixed(2)}</div>
                                        </div>`).join('')}
                                    ${costs.return.baggage > 0 ? `
                                        <div class="selection-item d-flex align-items-center">
                                            <div class="icon-wrapper me-2">
                                                <i class="fas fa-suitcase text-info"></i>
                                            </div>
                                            <div class="flex-grow-1">Baggage ${costs.return.baggageDetails}</div>
                                            <div class="price text-success">₹${costs.return.baggage.toFixed(2)}</div>
                                        </div>` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
        });

        breakdown += `</div>
                <!-- Grand Total section remains the same -->
                <div class="grand-total-section mt-4">
                    <div class="card bg-success bg-gradient text-white">
                        <div class="card-body p-4 text-center">
                            <h5 class="mb-2">Grand Total</h5>
                            <h2 class="mb-0">₹${priceDetails.grandTotal.toFixed(2)}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
        
        breakdownElement.innerHTML = breakdown;
    }
}

// Event listener for real-time updates
function addSelectionListeners() {
    const selectionTypes = ['seats', 'meals', 'baggage'];
    selectionTypes.forEach(type => {
        document.addEventListener(`${type}Selection`, () => {
            updateTotalFare();
        });
    });
}

// Make functions available globally
if (typeof window !== 'undefined') {
    window.calculateTotalPrice = calculateTotalPrice;
    window.calculateTotalPriceWithDetails = calculateTotalPriceWithDetails;
    window.updateTotalFare = updateTotalFare;
    window.addSelectionListeners = addSelectionListeners;
}


// Function to check flight balance
function checkFlightBalance() {
    return new Promise((resolve, reject) => {
        const outboundFare = outboundFareQuoteData?.Fare?.OPublishedFare || 0;
        const returnFare = returnFareQuoteData?.Fare?.PublishedFare || 0;
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
        loadingOverlay.innerHTML = '<div style="background: white; padding: 20px; border-radius: 5px;">Processing...</div>';
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

     // Validate the form first
     if (!validatePassengerForm()) {
        // Scroll to the first error
        const firstError = document.querySelector('.validation-error');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return; // Stop form submission
    }
    
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
                totalFare: outboundFareQuoteData.Fare.PublishedFare,
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
                totalFare: returnFareQuoteData.Fare.PublishedFare,
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
                    totalFare: outboundFareQuoteData.Fare.PublishedFare || 0,
                    ...bookingPayloads.lcc.outbound
                } : null,
                return: isLCCreturn ? {
                    resultIndex: returnResultIndex,
                    srdvIndex: returnSrdvIndex,
                    traceId: traceId,
                    totalFare: returnFareQuoteData.Fare.PublishedFare || 0,
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
    
        const encodedDetails = encodeURIComponent(JSON.stringify(finalBookingDetails));
        sessionStorage.setItem('finalBookingDetails', JSON.stringify(finalBookingDetails));
sessionStorage.setItem('encodedBookingDetails', encodedDetails);

console.log("Final Booking Details stored in session");

        try {
    const orderData = await processRazorpayPayment(finalBookingDetails);
    
    // Initialize Razorpay
    const razorpay = new Razorpay({
        key: orderData.key_id,
        amount: orderData.amount * 100, // Amount in smallest currency unit
        currency: orderData.currency,
        name: "Travel Portal",
        description: "Flight Booking Payment",
        order_id: orderData.order_id,
        prefill: {
            name: orderData.name || '',
            email: orderData.email || '',
            contact: orderData.contact || ''
        },
        notes: {
            payment_id: orderData.payment_id,
            flight_type: finalBookingDetails.lcc && 
                ((finalBookingDetails.lcc.outbound && finalBookingDetails.lcc.return) || 
                (finalBookingDetails.nonLcc && finalBookingDetails.nonLcc.outbound && finalBookingDetails.nonLcc.return)) ? 
                'round_trip' : 'one_way'
        },
        theme: {
            color: "#3399cc"
        },
        modal: {
            ondismiss: function() {
                console.log('Payment dismissed');
                // Handle payment dismissal (e.g., redirect to booking page)
                window.location.href = 'flight/payment/failed';
            }
        },
        handler: function(response) {
            // Handle successful payment
            handlePaymentSuccess(response, orderData.payment_id);
        }
    });
    
    // Open the Razorpay payment dialog
    razorpay.open();
    
} catch (paymentError) {
    console.error("Payment failed:", paymentError);
    if (window.Swal) {
        Swal.fire({
            icon: 'error',
            title: 'Payment Failed',
            text: paymentError.message || 'An error occurred during payment processing'
        });
    } else {
        alert('Payment failed: ' + (paymentError.message || 'An error occurred'));
    }
}

   
        console.log("Is LCC Outbound:", isLCCoutbound);
console.log("Is LCC Return:", isLCCreturn);

console.log("Non-LCC Outbound Passengers:", bookingPayloads.nonLcc.outbound);
console.log("Non-LCC Return Passengers:", bookingPayloads.nonLcc.return);

console.log("Processing Non-LCC Outbound:", !isLCCoutbound && bookingPayloads.nonLcc.outbound);
console.log("Processing Non-LCC Return:", !isLCCreturn && bookingPayloads.nonLcc.return);




     
        // window.location.href = `/flight/payment?details=${encodedDetails}`;

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

        sessionStorage.setItem('bookingDetails', bookingDetails);

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
          

var createOrderRoute = "{{ route('flight.payment.create-order') }}";

async function processRazorpayPayment(bookingDetails) {
    try {
        // Step 1: Ensure Razorpay is loaded
        if (typeof Razorpay === 'undefined') {
            // Load Razorpay script if not already loaded
            await new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = 'https://checkout.razorpay.com/v1/checkout.js';
                script.async = true;
                script.onload = resolve;
                script.onerror = () => reject(new Error('Failed to load Razorpay script'));
                document.body.appendChild(script);
            });
            
            // Double check it loaded properly
            if (typeof Razorpay === 'undefined') {
                throw new Error('Razorpay failed to initialize');
            }
        }

        // Step 2: Create order on the server
        const orderResponse =  await fetch(createOrderRoute, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                booking_details: JSON.stringify(bookingDetails)
            })
        });

        // Check if the response is OK
        if (!orderResponse.ok) {
            const errorText = await orderResponse.text();
            console.error("Server responded with error:", orderResponse.status, errorText);
            throw new Error(`Server error: ${orderResponse.status} ${orderResponse.statusText}`);
        }

        // Try to parse the response as JSON
        let orderData;
        try {
            const responseText = await orderResponse.text();
            console.log("Raw response:", responseText);
            orderData = JSON.parse(responseText);
        } catch (parseError) {
            console.error("Failed to parse response as JSON:", parseError);
            throw new Error("Server returned invalid JSON");
        }

        if (orderData.status !== 'success') {
            throw new Error(orderData.message || 'Failed to create payment order');
        }

        // Step 3: Now initialize Razorpay payment
        const razorpay = new Razorpay({
            key: orderData.key_id,
            amount: orderData.amount, // Amount in smallest currency unit
            currency: orderData.currency,
            name: "Travel Portal",
            description: "Flight Booking Payment",
            order_id: orderData.order_id,
            prefill: {
                name: orderData.name || '',
                email: orderData.email || '',
                contact: orderData.contact || ''
            },
            notes: {
                payment_id: orderData.payment_id,
                flight_type: bookingDetails.lcc && 
                    ((bookingDetails.lcc.outbound && bookingDetails.lcc.return) || 
                    (bookingDetails.nonLcc && bookingDetails.nonLcc.outbound && bookingDetails.nonLcc.return)) ? 
                    'round_trip' : 'one_way'
            },
            theme: {
                color: "#3399cc"
            },
            modal: {
                ondismiss: function() {
                    console.log('Payment dismissed');
                    // Handle payment dismissal (e.g., redirect to booking page)
                    // window.location.href = '/flight/booking';
                }
            },
            handler: function(response) {
                // Handle successful payment
                handlePaymentSuccess(response, orderData.payment_id);
            }
        });
        
        // Open the payment dialog
        razorpay.open();
        return orderData;

    } catch (error) {
        console.error('Payment processing error:', error);
        throw error; // Re-throw to be handled by the caller
    }
}
// Function to handle successful payment
// Function to handle successful payment
async function handlePaymentSuccess(paymentResponse, paymentId) {
    try {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('flight.payment.verify') }}"; // This should match your verify payment route
        
        // Add CSRF token
        const csrfField = document.createElement('input');
        csrfField.type = 'hidden';
        csrfField.name = '_token';
        csrfField.value = document.querySelector('meta[name="csrf-token"]').content;
        form.appendChild(csrfField);
        
        // Create verification data
        const verificationData = {
            razorpay_payment_id: paymentResponse.razorpay_payment_id,
            razorpay_order_id: paymentResponse.razorpay_order_id,
            razorpay_signature: paymentResponse.razorpay_signature,
            payment_id: paymentId,
            payment_method: 'razorpay'
        };

        // Add verification data as hidden form fields
        for (const [name, value] of Object.entries(verificationData)) {
            const field = document.createElement('input');
            field.type = 'hidden';
            field.name = name;
            field.value = value;
            form.appendChild(field);
        }
        
        // Submit the form
        document.body.appendChild(form);
        form.submit();
    } catch (error) {
        console.error('Error handling payment success:', error);
        alert('Payment was successful, but there was an error processing the result. Please contact support.');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Add Razorpay script to the page
    const razorpayScript = document.createElement('script');
    razorpayScript.src = 'https://checkout.razorpay.com/v1/checkout.js';
    razorpayScript.async = true;
    document.body.appendChild(razorpayScript);

    // Setup the form integration once Razorpay is loaded
    razorpayScript.onload = function() {
        integrateRazorpayIntoBookingForm();
    };
});
          });





</script>
@endsection
