<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking Form</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- SweetAlert2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        .meal-options-container {
            display: grid;
            gap: 1rem;
        }

        .meal-option {
            background: #fff;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
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
            border-radius: 5px 5px 0 0;
        }

        .cabin {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
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
            transition: background-color 0.3s;
        }

        .seat:hover {
            background: #45a049;
        }

        .seat.selected {
            background: #ff5722;
        }

        .modal-xl {
            max-width: 1140px;
        }

        .card {
            margin-bottom: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0,0,0,.125);
        }

        .option-selection {
            margin-bottom: 1rem;
        }

        .option-selection button {
            margin-right: 0.5rem;
        }

        #options-container {
            margin-top: 1rem;
            padding: 1rem;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Flight Booking Form</h4>
            </div>
            <div class="card-body">
                <form id="bookingForm">
                    <!-- Personal Details Section -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Personal Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <select class="form-select" id="title" name="Title" required>
                                        <option value="Mr">Mr</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Ms">Ms</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="FirstName" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="LastName" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="Gender" required>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="passengerType" class="form-label">Passenger Type</label>
                                    <select class="form-select" id="passengerType" name="PassengerType" required>
                                        <option value="1">Adult</option>
                                        <option value="2">Child</option>
                                        <option value="3">Infant</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="Email" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contactNo" class="form-label">Contact Number</label>
                                    <input type="tel" class="form-control" id="contactNo" name="ContactNo" required>
                                </div>
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
                                <div class="col-md-4 mb-3">
                                    <label for="passportNo" class="form-label">Passport Number</label>
                                    <input type="text" class="form-control" id="passportNo" name="PassportNo">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="passportExpiry" class="form-label">Passport Expiry</label>
                                    <input type="date" class="form-control" id="passportExpiry" name="PassportExpiry">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="passportIssueDate" class="form-label">Passport Issue Date</label>
                                    <input type="date" class="form-control" id="passportIssueDate" name="PassportIssueDate">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Options Section -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Additional Options</h6>
                        </div>
                        <div class="card-body">
                            <div class="option-selection">
                                <button type="button" class="btn btn-primary" id="baggage-btn">Baggage Options</button>
                                <button type="button" class="btn btn-secondary" id="meal-btn">Meal Options</button>
                            </div>
                            <div id="options-container">
                                <p>Please select an option to view details.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Seat Selection Section -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Seat Selection</h6>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-secondary" id="selectSeatBtn">Select Seat</button>
                            <span id="seatInfo" class="ms-2" style="font-size: 14px;"></span>
                            <div id="seatMapContainer" class="mt-3" style="display: none;"></div>
                        </div>
                    </div>

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

    <!-- Required JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.js"></script>
    <script>
        // Your existing JavaScript code here (unchanged)
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('traceId');
    const resultIndex = urlParams.get('resultIndex');
    const encodedDetails = urlParams.get('details');

   

    const fareQuoteData = JSON.parse(sessionStorage.getItem('fareQuoteData'));

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

    // Add event listeners
    if (srdvIndex) {
        document.getElementById('baggage-btn').addEventListener('click', () => fetchSSRData('baggage'));
        document.getElementById('meal-btn').addEventListener('click', () => fetchSSRData('meal'));
    } else {
        console.error('SrdvIndex not found for ResultIndex:', resultIndex);
    }

    function fetchSSRData(displayType) {
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
                SrdvIndex: srdvIndex, // Ensure this is correctly set
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
                            <input 
                                type="radio" 
                                name="baggage_option" 
                                value="${option.Code}" 
                                data-weight="${option.Weight}" 
                                data-price="${option.Price}"
                                data-description="${option.Description}"
                                data-wayType="${option.WayType}"
                                data-currency="${option.Currency}"
                                data-origin="${option.Origin}"
                                data-destination="${option.Destination}"
                                ${option.Code === 'NoBaggage' ? 'checked' : ''}
                                onchange="updateBaggageSelection(this)"
                            >
                        </td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
}

window.updateBaggageSelection = function(radio) {
    showBaggageAlert(radio);
    window.selectedBaggageOption = {
        Code: radio.value,
        Weight: radio.getAttribute('data-weight'),
        Price: radio.getAttribute('data-price'),
        Origin: radio.getAttribute('data-origin'),
        Destination: radio.getAttribute('data-destination'),
        Description: radio.getAttribute('data-description'),
        WayType: radio.getAttribute('data-wayType'),
        Currency: radio.getAttribute('data-currency')
    };
};

function renderMealOptions(mealData, container) {
    // Similar modification for meal options
    container.innerHTML = `
        <div class="meal-options-container">
            ${mealData.map(meal => `
                <div class="meal-option">
                    <input 
                        type="radio" 
                        name="meal_option" 
                        value="${meal.Code}" 
                        data-wayType="${meal.WayType}"
                        data-descript="${meal.Description || 'No Description'}"
                        data-description="${meal.AirlineDescription || 'No Description'}"
                        data-origin="${meal.Origin}"
                        data-quantity="${meal.Quantity}"
                        data-currency="${meal.Currency}"
                        data-destination="${meal.Destination}"
                        data-price="${meal.Price}"
                        ${meal.Code === 'NoMeal' ? 'checked' : ''}
                        onchange="updateMealSelection(this)"
                    >
                    <label>${meal.AirlineDescription || 'No Meal'}</label>
                </div>
            `).join('')}
        </div>
    `;
}

window.updateMealSelection = function(radio) {
    showMealAlert(radio);
    window.selectedMealOption = {
        Code: radio.value,
        AirlineDescription: radio.getAttribute('data-description'),
        Origin: radio.getAttribute('data-origin'),
        Destination: radio.getAttribute('data-destination'),
        Price: radio.getAttribute('data-price'),
        Waytype:radio.getAttribute('data-wayType'),
        Quantity:radio.getAttribute('data-quantity'),
        Currency: radio.getAttribute('data-currency'),
        Description: radio.getAttribute('data-descript')
    };
};


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

window.showMealAlert = function(radio) {
    const description = radio.getAttribute('data-description') || 'No Description';
    
    if (window.Swal) {
        window.Swal.fire({
            icon: 'info',
            title: 'Meal Option Selected',
            text: description,
            showConfirmButton: false,
            timer: 1500
        });
    } else {
        alert(`Meal: ${description}`);
    }
};

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

    function selectSeat(code, seatNumber, amount,airlineName,airlineCode,airlineNumber) {
    console.log('Selecting seat:', { code, seatNumber, amount,airlineName,airlineCode , airlineNumber});

    // Remove any previously created seat radio buttons
    const existingRadios = document.querySelectorAll('input[name="seat_option"]');
    existingRadios.forEach(radio => radio.remove());

    // Create new seat radio button
    const seatRadio = document.createElement('input');
    seatRadio.type = 'radio';
    seatRadio.name = 'seat_option';
    seatRadio.value = code;
    seatRadio.setAttribute('data-seat-number', seatNumber);
    seatRadio.setAttribute('data-amount', amount);
    seatRadio.setAttribute('data-airlineName', airlineName);
    seatRadio.setAttribute('data-airlineCode', airlineCode);
    seatRadio.setAttribute('data-airlineNumber', airlineNumber);
    seatRadio.checked = true;
    
    // Append to body or a specific container
    document.body.appendChild(seatRadio);
    
    // Update seat info display
    const seatInfoElement = document.getElementById('seatInfo');
    if (seatInfoElement) {
        seatInfoElement.textContent = `Selected Seat: ${seatNumber} (₹${amount})`;
    } else {
        console.error('Seat info element not found');
    }
    
    // Ensure SweetAlert is properly loaded
    if (window.Swal) {
        window.Swal.fire({
            icon: 'success',
            title: 'Seat Selected!',
            text: `You have selected Seat ${seatNumber} (₹${amount})`,
            showConfirmButton: false,
            timer: 1500
        });
    } else {
        // Fallback alert if SweetAlert is not available
        alert(`Seat ${seatNumber} selected for ₹${amount}`);
        console.warn('SweetAlert not loaded, using standard alert');
    }
}

// Ensure the function is globally accessible
window.selectSeat = selectSeat;



document.getElementById('submitButton').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default action
    
    // Call bookLCC function directly
    bookLCC();
    
    return false; // Prevent form submission
});

    
    // Collect seat data
    function bookLCC() {
    // Collect seat data
    const selectedSeat = document.querySelector('input[name="seat_option"]:checked');
    const seatData = selectedSeat ? [{
        Code: selectedSeat.value,
        SeatNumber: selectedSeat.getAttribute('data-seat-number'),
        Amount: selectedSeat.getAttribute('data-amount'),
        AirlineName: selectedSeat.getAttribute('data-airlineName'),
        AirlineCode: selectedSeat.getAttribute('data-airlineCode'),
        AirlineNumber: selectedSeat.getAttribute('data-airlineNumber')
    }] : [];

    const baggageData = window.selectedBaggageOption ? [window.selectedBaggageOption] : [];
    const mealData = window.selectedMealOption ? [window.selectedMealOption] : [];

    // Prepare payload
    const payload = {
        srdvIndex: srdvIndex,
        traceId: traceId,
        resultIndex: resultIndex,
        passenger: {
            title: document.getElementById('title').value,
            firstName: document.getElementById('firstName').value,
            lastName: document.getElementById('lastName').value,
            gender: document.getElementById('gender').value,
            contactNo: document.getElementById('contactNo').value,
            email: document.getElementById('email').value,
            paxType:document.getElementById('passengerType').value,
            dateOfBirth: "12/01/1998",
            passportNo: "",
            passportExpiry: "",
            passportIssueDate: "",
            countryCode: "IN",
            countryName: "INDIA",
            baggage: baggageData,
            mealDynamic: mealData,
            seat: seatData // Correctly formatted seat data

        },
        fare: {
            baseFare: fareQuoteData.Fare.BaseFare,
            tax: fareQuoteData.Fare.Tax,
            yqTax: fareQuoteData.Fare.YQTax,
            transactionFee: parseFloat(fareQuoteData.Fare.TransactionFee),
            additionalTxnFeeOfrd: fareQuoteData.Fare.AdditionalTxnFeeOfrd,
            additionalTxnFeePub: fareQuoteData.Fare.AdditionalTxnFeePub,
            airTransFee: parseFloat(fareQuoteData.Fare.AirTransFee)
        }
    };

    console.log('Payload:', payload); // For debugging purposes

    // Send booking request
    fetch('/flight/bookLcc', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
        alert('Booking successful! Booking ID: ' + data.booking_details.booking_id);
        // Additional actions with booking details if needed
        console.log(data.booking_details);
    } else {
        alert('Booking failed: ' + (data.message || 'Unknown error'));
    }
})
.catch(error => {
    console.error('Error:', error);
    alert('An error occurred during booking');
});
}
});
    </script>
</body>
</html>
