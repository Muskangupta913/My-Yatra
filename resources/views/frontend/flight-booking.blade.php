<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    .meal-options-container {
        display: grid;
        gap: 1rem;
    }

    .meal-option {
        background: #fff;
        transition: all 0.3s ease;
    }

    .meal-option:hover {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .plane {
        margin: auto;
        max-width: 300px;
        background: #f0f0f0;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
    }

    .cockpit {
        padding: 10px 0;
        background: #333;
        color: white;
        font-weight: bold;
    }

    .cabin {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .row {
        display: flex;
        justify-content: center;
        margin: 5px 0;
    }

    .seat {
        width: 40px;
        height: 40px;
        background: #4caf50;
        margin: 5px;
        line-height: 40px;
        text-align: center;
        border-radius: 5px;
        color: white;
        cursor: pointer;
    }

    .seat.selected {
        background: #ff5722;
    }
</style>
@extends('frontend.layouts.master')

@section('content')
    <!-- Booking Form Modal -->
    <div class="modal fade show" id="bookingFormModal" tabindex="-1" aria-labelledby="bookingFormModalLabel" aria-hidden="true" style="display: block;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingFormModalLabel">Booking Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bookingForm">
                        <!-- Personal Details Section -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Personal Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Title -->
                                    <div class="col-md-3 mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <select class="form-select" id="title" name="Title" required>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Ms">Ms</option>
                                        </select>
                                    </div>
                                    <!-- First Name -->
                                    <div class="col-md-3 mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="FirstName" required>
                                    </div>
                                    <!-- Last Name -->
                                    <div class="col-md-3 mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="LastName" required>
                                    </div>
                                    <!-- Gender -->
                                    <div class="col-md-3 mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-select" id="gender" name="Gender" required>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                    </div>
                                    <!-- Email -->
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="Email" required>
                                    </div>
                                    <!-- Contact Number -->
                                    <div class="col-md-6 mb-3">
                                        <label for="contactNo" class="form-label">Contact Number</label>
                                        <input type="tel" class="form-control" id="contactNo" name="ContactNo" required>
                                    </div>
                                    <!-- Address -->
                                    <div class="col-md-12 mb-3">
                                        <label for="addressLine1" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="addressLine1" name="AddressLine1" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Passport Details Section -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Passport Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Passport Number -->
                                    <div class="col-md-4 mb-3">
                                        <label for="passportNo" class="form-label">Passport Number</label>
                                        <input type="text" class="form-control" id="passportNo" name="PassportNo">
                                    </div>
                                    <!-- Passport Expiry -->
                                    <div class="col-md-4 mb-3">
                                        <label for="passportExpiry" class="form-label">Passport Expiry</label>
                                        <input type="date" class="form-control" id="passportExpiry" name="PassportExpiry">
                                    </div>
                                    <!-- Passport Issue Date -->
                                    <div class="col-md-4 mb-3">
                                        <label for="passportIssueDate" class="form-label">Passport Issue Date</label>
                                        <input type="date" class="form-control" id="passportIssueDate" name="PassportIssueDate">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dynamic Sections -->
                        <div id="dynamicSections"></div>

                        <!-- Options -->
                        <div class="option-selection">
                            <button type="button" class="btn btn-primary" id="baggage-btn">Baggage Options</button>
                            <button type="button" class="btn btn-secondary" id="meal-btn">Meal Options</button>
                        </div>
                        <div id="options-container">
                            <p>Please select an option to view details.</p>
                        </div>

                        <!-- Seat Selection -->
                        <div class="seat-selection-section mb-3">
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
                        <button type="submit" class="btn btn-primary">Submit Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const traceId = sessionStorage.getItem('flightTraceId');
    const results = JSON.parse(sessionStorage.getItem('flightSearchResults')) || [];
    console.log('TraceId:', traceId);
console.log('Flight Search Results:', results);
const urlParams = new URLSearchParams(window.location.search);
   
    const resultIndex = urlParams.get('resultIndex');
console.log('Fligh Results INDEX:', resultIndex);

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
                        console.log('SRDV INDEX', srdvIndex)
                    }
                });
            }
        });
    });

if (!srdvIndex) {
    console.error('SrdvIndex not found for the provided ResultIndex:', resultIndex);
} else {
    console.log('Final SrdvIndex:', srdvIndex);
}

    // Add event listeners for baggage and meal buttons
    document.getElementById('baggage-btn').addEventListener('click', function() {
        fetchSSRData('baggage');
    });

    document.getElementById('meal-btn').addEventListener('click', function() {
        fetchSSRData('meal');
    });

    function fetchSSRData(displayType) {
    fetch("{{ route('fetch.ssr.data') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            EndUserIp: '1.1.1.1', // Replace with actual IP
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
        const container = document.getElementById('options-container');
        container.innerHTML = '';

        // Check if SSR data is available
        if (!data.success) {
            container.innerHTML = `<p>This flight does not provide SSR services: ${data.message || 'No details available'}</p>`;
            return;
        }

        // Check if specific SSR type has options
        if (displayType === 'baggage' && data.Baggage && data.Baggage[0] && data.Baggage[0].length > 0) {
            renderBaggageOptions(data.Baggage[0], container);
        } else if (displayType === 'meal' && data.MealDynamic && data.MealDynamic[0] && data.MealDynamic[0].length > 0) {
            renderMealOptions(data.MealDynamic[0], container);
        } else {
            container.innerHTML = `<p>No ${displayType} options available for this flight.</p>`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('options-container').innerHTML =
            '<p>Error fetching SSR data. Please try again.</p>';
    });
}
    function renderBaggageOptions(baggageData, container) {
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
                                <input type="radio" name="baggage_option" value="${option.Code}" 
                                    ${option.Code === 'NoBaggage' ? 'checked' : ''}>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        `;
    }

    function renderMealOptions(mealData, container) {
        if (!mealData.length) {
            container.innerHTML = '<p>No meal options available.</p>';
            return;
        }

        container.innerHTML = `
            <h6 class="mb-4">Meal Options</h6>
            <div class="meal-options-container">
                ${mealData.map(meal => `
                    <div class="meal-option border rounded p-3 mb-3">
                        <div class="description mb-2">
                            ${meal.Code === 'NoMeal' ? 'No Meal' : (meal.AirlineDescription || 'Standard Meal')}
                        </div>
                        <div class="price mb-2">
                            ${meal.Price > 0 ? meal.Price + ' ' + meal.Currency : 'Free'}
                        </div>
                        <div class="route mb-2">
                            ${meal.Origin} → ${meal.Destination}
                        </div>
                        <div class="select">
                            <input type="radio" name="meal_option" value="${meal.Code}"
                                ${meal.Code === 'NoMeal' ? 'checked' : ''}>
                            <label>${meal.Code === 'NoMeal' ? 'Select No Meal' : 'Select This Meal'}</label>
                        </div>
                    </div>
                `).join('')}
            </div>
        `;
    }

    // Seat Selection
    document.getElementById('selectSeatBtn').addEventListener('click', function() {
    const seatMapContainer = document.getElementById('seatMapContainer');
    const button = this;

    button.disabled = true;
    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';

    fetch('{{ route('flight.getSeatMap') }}', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json', // Add this header
        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Add CSRF token
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json' // Change to JSON
    },
    body: JSON.stringify({
        EndUserIp: '1.1.1.1',
        ClientId: '180133',
        UserName: 'MakeMy91',
        Password: 'MakeMy@910',
        SrdvType: "MixAPI",
        SrdvIndex: srdvIndex, // Ensure these are defined
        TraceId: traceId,
        ResultIndex: resultIndex
    })
})
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json(); // Changed from text() to json()
    })
    .then(data => {
        seatMapContainer.innerHTML = data.html; // Assuming controller returns HTML in data.html
        seatMapContainer.style.display = 'block';

        button.disabled = false;
        button.innerHTML = 'Select Seat';

        initializeBootstrapComponents();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to load seat map. Please try again.');

        button.disabled = false;
        button.innerHTML = 'Select Seat';
    });
});
    function initializeBootstrapComponents() {
        // Initialize any Bootstrap components here if needed
    }
});
</script>

@endsection
