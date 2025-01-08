@extends('frontend.layouts.master')
@section('title', 'Bus Booking')
@section('content')
<div id="loadingSpinner" style="
    display: none; 
    position: fixed; 
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%; 
    background-color: rgba(255, 255, 255, 0.8); 
    z-index: 9999; 
    display: flex; 
    align-items: center; 
    justify-content: center;">
    <img src="{{ asset('assets/loading.gif') }}" alt="Loading..." style="width: 10vw; height: 10vw; max-width: 150px; max-height: 150px;" />
</div>
<!-- Add the CSRF meta tag in the header -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container mt-4" id="busBookingContainer">
<div class="section-container mb-4" id="seatLayoutContainer">
    <h3 class="text-center">Select Seats</h3>
    <div id="seatLayout" class="bus-seats"></div>
</div>

<!-- Right Section: Pickup and Dropping Points -->
<div class="section-container" id="pickupDroppingContainer">
    <h3 class="text-center">Select Pickup & Dropping Points</h3>
    <div class="d-flex justify-content-between flex-wrap">
        <!-- Pickup Points -->
        <div id="pickupPointSection" class="pickup-point">
            <h6 class="text-center">Pickup Point</h6>
            <div id="pickupPointsContainer" class="pickup-points text-center">
                <p>Loading pickup points...</p>
            </div>
        </div>

        <!-- Dropping Points -->
        <div id="droppingPointSection" class="dropping-point">
            <h6 class="text-center">Dropping Point</h6>
            <div id="droppingPointsContainer" class="dropping-points text-center">
                <p>Loading dropping points...</p>
            </div>
        </div>
    </div>
</div>

            <!-- Selected Seat Info Section -->
            <div id="selectedSeatInfo" class="mt-2 d-none">
                <h4>Selected Seat</h4>
                <p id="selectedSeatDetails"></p>
            </div>

           
<!-- Continue Button Section -->
<div class="mt-2 text-center" id="continueButtonContainer">
  <button class="btn btn-success" id="continueButton">Continue</button>
  <a href="#" class="btn btn-success mt-2 d-none" id="review">Review Details</a>
</div>
        </div>
      </div>
    </div>
  </div>
 
        <!-- Passenger Information Section -->
        <!-- Trigger Modal Button (Hidden Initially) -->
<button type="button" id="openPassengerDetailsModal" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#passengerDetailsModal"></button>

<!-- Passenger Details Modal -->
<div class="modal fade" id="passengerDetailsModal" tabindex="-1" aria-labelledby="passengerDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="passengerDetailsModalLabel">👤 Enter Passenger Details 👤</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="passengerDetailsForm">
          <div class="form-group">
            <label for="title">Title</label>
            <select class="form-control" id="title" name="Title" required>
              <option value="">Select</option>
              <option value="Mr">Mr</option>
              <option value="Mrs">Mrs</option>
              <option value="Ms">Ms</option>
              <option value="Dr">Dr</option>
            </select>
          </div>
          <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" id="firstName" name="FirstName" required>
          </div>
          <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="LastName" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="Email" required>
          </div>
          <div class="form-group">
            <label for="phoneNumber">Phone Number</label>
            <input type="text" class="form-control" id="phoneNumber" name="Phoneno" required>
          </div>
          <div class="form-group">
            <label for="gender">Gender</label>
            <select class="form-control" id="gender" name="Gender" required>
              <option value="1">Male</option>
              <option value="2">Female</option>
            </select>
          </div>
          <div class="form-group">
            <label for="age">Age</label>
            <input type="number" class="form-control" id="age" name="Age" required>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <textarea class="form-control" id="address" name="Address" rows="3" required></textarea>
          </div>
          <button type="submit" id="blockSeatButton" class="btn btn-success w-100 mt-4">Block Seat</button>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<!-- Include Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
  document.getElementById('loadingSpinner').classList.remove('d-none');

  document.addEventListener('DOMContentLoaded', () => {
    showLoadingSpinner();
    setTimeout(() => {
        hideLoadingSpinner();
    }, 4000); // Spinner should hide after 4 seconds
});
// Helper to show the spinner
function showLoadingSpinner() {
    document.getElementById('loadingSpinner').classList.remove('d-none');
}

// Helper to hide the spinner
function hideLoadingSpinner() {
    document.getElementById('loadingSpinner').classList.add('d-none');
}
  // Helper function to format date into a readable format (Date)
function formatDate(dateTimeString) {
    const date = new Date(dateTimeString);
    return date.toLocaleDateString();  // This will format it based on the locale, e.g. "MM/DD/YYYY"
}
  // Helper function to format time into a readable format
function formatTime(dateTimeString) {
    const date = new Date(dateTimeString);
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
}
document.addEventListener('DOMContentLoaded', function () {
    fetchSeatLayout();
    fetchBoardingDetails();
});

let selectedSeat = null;
let selectedSeatDetails = null;
let selectedBoardingPointId = null;
let selectedDroppingPointId = null;

function fetchSeatLayout() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('TraceId');
    const resultIndex = urlParams.get('ResultIndex');

    if (!traceId || !resultIndex) {
        showError("TraceId and ResultIndex are required.");
        return;
    }
    document.getElementById('seatLayout').innerHTML ='<div class="alert alert-info">Loading seat layout...</div>';

    fetch('/getSeatLayout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            TraceId: traceId,
            ResultIndex: resultIndex
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === true) {
                // Convert both formats to a consistent array format
                const seatData = {
            lower: data.data.lower,
            upper: data.data.upper
        };
        renderSeatLayout(seatData);
            } else {
                throw new Error(data.message || 'Failed to load seat layout');
            }
        })
        .catch(error => {
            showError(error.message);
        });
}
 // Pass the correct image URLs from Laravel to JavaScript
 const availableSeatImage = "{{ asset('assets/seat.png') }}";
 const bookedSeatImage = "{{ asset('assets/seat.png') }}";

 function normalizeLayoutData(data) {
    const result = { Upper: [], Lower: [] };

    if (data.Upper) {
        result.Upper = Array.isArray(data.Upper) ? data.Upper : normalizeLayoutRows(data.Upper);
    }

    if (data.Lower) {
        result.Lower = Array.isArray(data.Lower) ? data.Lower : normalizeLayoutRows(data.Lower);
    }

    return result;
}
function normalizeLayoutData(data) {
    const normalized = {
        lower: [],
        upper: []
    };

    // Handle lower deck seats
    if (data.lower) {
        // Check if it's an array (seater bus) or object (sleeper bus)
        if (Array.isArray(data.lower)) {
            normalized.lower = data.lower;
        } else {
            // Convert object format to array format
            Object.keys(data.lower).forEach(rowKey => {
                const rowData = [];
                Object.keys(data.lower[rowKey]).forEach(seatKey => {
                    rowData.push(data.lower[rowKey][seatKey]);
                });
                if (rowData.length > 0) {
                    normalized.lower.push(rowData);
                }
            });
        }
    }

    // Handle upper deck seats
    if (data.upper) {
        Object.keys(data.upper).forEach(rowKey => {
            const rowData = [];
            Object.keys(data.upper[rowKey]).forEach(seatKey => {
                rowData.push(data.upper[rowKey][seatKey]);
            });
            if (rowData.length > 0) {
                normalized.upper.push(rowData);
            }
        });
    }

    return normalized;
}

function renderSeatLayout(seatDetails) {
    const seatLayoutContainer = document.getElementById('seatLayout');
    const normalizedData = normalizeLayoutData(seatDetails);
    
    let layoutHTML = '<div class="bus-layout">';

    // Render Lower Deck
    if (normalizedData.lower.length > 0) {
        layoutHTML += '<div class="deck lower-deck">';
        layoutHTML += '<h4>Lower Deck</h4>';
        layoutHTML += renderDeck(normalizedData.lower, false);
        layoutHTML += '</div>';
    }

    // Render Upper Deck
    if (normalizedData.upper.length > 0) {
        layoutHTML += '<div class="deck upper-deck">';
        layoutHTML += '<h4>Upper Deck</h4>';
        layoutHTML += renderDeck(normalizedData.upper, true);
        layoutHTML += '</div>';
    }

    layoutHTML += '</div>';
    seatLayoutContainer.innerHTML = layoutHTML;
}

function renderDeck(deckData, isUpper) {
    let deckHTML = '<div class="deck-seats">';
    
    deckData.forEach((row, rowIndex) => {
        deckHTML += '<div class="seat-row">';
        
        row.forEach((seat) => {
            if (seat && typeof seat === 'object') {
                const seatClass = getSeatClass(seat);
                const seatPrice = seat.Price?.PublishedPriceRoundedOff || 0;
                
                deckHTML += `
                    <div class="seat-wrapper ${seat.IsLadiesSeat ? 'ladies-seat' : ''}" 
                         data-column="${seat.ColumnNo}" 
                         data-row="${seat.RowNo}">
                        <div class="${seatClass}"
                             onclick="selectSeat(this, ${JSON.stringify(seat)})">
                            <div class="seat-info">
                                <span class="seat-number">${seat.SeatName}</span>
                                <span class="seat-price">₹${seatPrice}</span>
                            </div>
                        </div>
                    </div>
                `;
            }
        });
        
        deckHTML += '</div>';
    });
    
    deckHTML += '</div>';
    return deckHTML;
}

function getSeatClass(seat) {
    const classes = ['seat'];
    
    if (seat.SeatStatus) {
        classes.push('seat-available');
    } else {
        classes.push('seat-booked');
    }
    
    if (seat.IsUpper) {
        classes.push('upper-berth');
    } else {
        classes.push('lower-berth');
    }
    
    return classes.join(' ');
}

// Rest of the code remains the same
function selectSeat(element, seatData) {
    if (element.classList.contains('seat-booked')) return;

    document.querySelectorAll('.seat-selected').forEach(seat => seat.classList.remove('seat-selected'));
    element.classList.add('seat-selected');

    selectedSeatDetails = seatData;
    selectedSeat = seatData.SeatName;

    const selectedSeatInfo = document.getElementById('selectedSeatInfo');
    selectedSeatInfo.classList.remove('d-none');
    selectedSeatInfo.querySelector('#selectedSeatDetails').innerText = 
        `Seat: ${seatData.SeatName}, Price: ₹${seatData.Price.PublishedPrice}`;

    // Show the Continue button
    document.getElementById('continueButton').classList.remove('d-none');
}
// Trigger the modal when the Continue button is clicked
document.getElementById('continueButton').addEventListener('click', function() {
    // Trigger the modal to show passenger details
    const modalTriggerButton = document.getElementById('openPassengerDetailsModal');
    modalTriggerButton.click();

// document.getElementById('continueButton')?.addEventListener('click', function() {
//     if (selectedSeatDetails) {
//         // Trigger the passenger details modal
//         document.getElementById('openPassengerDetailsModal').click();
//     } else {
//         showError('Please select a seat first.');
//     }
});


function showError(message) {
    const errorMessage = document.getElementById('errorMessage');
    errorMessage.classList.remove('d-none');
    errorMessage.innerText = message;
}

function fetchBoardingDetails() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('TraceId');
    const resultIndex = urlParams.get('ResultIndex');

    if (!traceId || !resultIndex) {
        showError("TraceId and ResultIndex are required.");
        return;
    }

    const loadingHTML = `
        <div class="d-flex justify-content-center align-items-center p-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>`;

    document.getElementById('pickupPointsContainer').innerHTML = loadingHTML;
    document.getElementById('droppingPointsContainer').innerHTML = loadingHTML;

    fetch('/boarding-points', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            TraceId: traceId,
            ResultIndex: resultIndex
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            renderPickupPoints(data.data.boarding_points);
            renderDroppingPoints(data.data.dropping_points);
        } else {
            throw new Error(data.message || 'Failed to load boarding details');
        }
    })
    .catch(error => {
        showError(error.message);
    });
}

function renderPickupPoints(points) {
    const container = document.getElementById('pickupPointsContainer');

    if (!points || points.length === 0) {
        container.innerHTML = '<div class="alert alert-warning">No pickup points available</div>';
        return;
    }

    container.innerHTML = points.map(point => `
        <div class="pickup-point-item" data-point-index="${point.index}">
            <div class="position-relative p-3">
                <!-- Time Badge -->
                <span class="pickup-time position-absolute top-0 end-0 m-2">
                    🕒 ${formatTime(point.time)}
                </span>
                
                <!-- Point Name -->
               <h5>  ${point.location}</h5>
                
                <!-- Details Grid -->
                <div class="point-details">
                    <p><i class="fas fa-building"></i> ${point.address}</p>
                    <p><i class="fas fa-landmark"></i> ${point.landmark}</p>
                    <p><i class="fas fa-phone"></i> ${point.contact_number}</p>
                </div>
                
                <!-- Select Button -->
             <button class="btn btn-outline-success btn-sm mt-3 select-btn" 
    onclick="selectPickupPoint(${point.index}, '${point.name.replace(/'/g, "\\'")}')">
    <i class="fas fa-check-circle"></i> Select Point
</button>
            </div>
        </div>
    `).join('');
}

function renderDroppingPoints(points) {
    const container = document.getElementById('droppingPointsContainer');

    if (!points || points.length === 0) {
        container.innerHTML = '<div class="alert alert-warning">No dropping points available</div>';
        return;
    }

    container.innerHTML = points.map(point => `
        <div class="dropping-point-item" data-point-index="${point.index}">
            <div class="position-relative p-3">
                <!-- Time Badge -->
                <span class="pickup-time position-absolute top-0 end-0 m-2">
                    🕒 ${formatTime(point.time)}
                </span>
                
                <!-- Point Name and Location -->
                <h5 class="mb-3">${point.name}</h5>
                <p><i class="fas fa-map-marker-alt"></i> ${point.location}</p>
                
                <!-- Select Button -->
               <button class="btn btn-outline-success btn-sm mt-3 select-btn" 
    onclick="selectDroppingPoint(${point.index}, '${point.name.replace(/'/g, "\\'")}')">
    <i class="fas fa-check-circle"></i> Select Point
</button>
            </div>
        </div>
    `).join('');
}

document.getElementById('passengerDetailsForm').addEventListener('submit', function(e) {
    e.preventDefault();

    if (!selectedSeatDetails) {
        alert('Please select a seat before submitting passenger details.');
        return;
    }

    const passengerData = {
        LeadPassenger: true,
        PassengerId: 0,
        Title: document.getElementById('title').value,
        FirstName: document.getElementById('firstName').value,
        LastName: document.getElementById('lastName').value,
        Email: document.getElementById('email').value,
        Mobile: document.getElementById('phoneNumber').value, // Changed from Phoneno to Mobile
        Gender: document.getElementById('gender').value,
        IdType: null,
        IdNumber: null,
        Age: document.getElementById('age').value,
        Address: document.getElementById('address').value,
        SeatIndex: selectedSeatDetails.SeatIndex // Changed to just send SeatIndex
    };

    blockSeat(passengerData);
});

// Pickup and Dropping point functions remain the same
function selectPickupPoint(index, name) {
    selectedBoardingPointId = index;
    selectedBoardingPointName = name;

    // Remove 'selected' class from all pickup point buttons first
    document.querySelectorAll('.pickup-point-item .select-btn').forEach(button => {
        button.classList.remove('btn-success');
        button.classList.add('btn-outline-success');
    });

    // Add 'selected' class to the selected pickup point button
    const selectedButton = document.querySelector(`.pickup-point-item[data-point-index="${index}"] .select-btn`);
    selectedButton.classList.add('btn-success');
    selectedButton.classList.remove('btn-outline-success');

    // Add 'selected' class to the pickup point item
    document.querySelectorAll('.pickup-point-item').forEach(point => point.classList.remove('selected'));
    document.querySelector(`.pickup-point-item[data-point-index="${index}"]`).classList.add('selected');
}

function selectDroppingPoint(index, name) {
    selectedDroppingPointId = index;
    selectedDroppingPointName = name;

    // Remove 'selected' class from all dropping point buttons first
    document.querySelectorAll('.dropping-point-item .select-btn').forEach(button => {
        button.classList.remove('btn-success');
        button.classList.add('btn-outline-success');
    });

    // Add 'selected' class to the selected dropping point button
    const selectedButton = document.querySelector(`.dropping-point-item[data-point-index="${index}"] .select-btn`);
    selectedButton.classList.add('btn-success');
    selectedButton.classList.remove('btn-outline-success');

    // Add 'selected' class to the dropping point item
    document.querySelectorAll('.dropping-point-item').forEach(point => point.classList.remove('selected'));
    document.querySelector(`.dropping-point-item[data-point-index="${index}"]`).classList.add('selected');
}



function blockSeat(passengerData) {
    if (selectedBoardingPointId === undefined || selectedDroppingPointId === undefined) {
        alert('Please select both boarding and dropping points before proceeding.');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('TraceId');
    const resultIndex = urlParams.get('ResultIndex');

    const payload = {
        ClientId: "180189", // These should match your controller values
        UserName: "MakeMy91",
        Password: "MakeMy@910",
        TraceId: traceId,
        ResultIndex: resultIndex,
        BoardingPointId: selectedBoardingPointId,
        DroppingPointId: selectedDroppingPointId,
        BoardingPointName: selectedBoardingPointName, // Include selected boarding point name in the payload
        DroppingPointName: selectedDroppingPointName, // Include selected dropping point name in the payload
        RefID: "1",
        Passenger: [passengerData] // Send passenger data as an array
    };

    fetch('/block-seats', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(payload)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => {
                throw new Error(err.message || 'Failed to block seat');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.status === true) { // Changed from 'success' to true
            // Close the modal
            const passengerDetailsModal = bootstrap.Modal.getInstance(document.getElementById('passengerDetailsModal'));
            passengerDetailsModal.hide();

            // Create booking page URL with necessary data
            const bookingPageUrl = `/booking?` + new URLSearchParams({
                TraceId: traceId,
                ResultIndex: resultIndex,
                PassengerData: JSON.stringify(data.data.Passengers[0]),
                BoardingPoint: JSON.stringify({
                        Id: data.data.BoardingPointdetails.Id,
                        Name: selectedBoardingPointName // Use the selected name
                    }),
                    DroppingPoint: JSON.stringify({
                        Id: data.data.DroppingPointsDetails.Id,
                        Name: selectedDroppingPointName // Use the selected name
                    }),
                BusDetails: JSON.stringify({
                    DepartureTime: data.data.DepartureTime,
                    ArrivalTime: data.data.ArrivalTime,
                    BusType: data.data.BusType,
                    ServiceName: data.data.ServiceName,
                    TravelName: data.data.TravelName
                }),
                Price: JSON.stringify(data.data.Price),
                CancellationPolicy: JSON.stringify(data.data.CancellationPolicy)
            }).toString();

            // Update UI elements
            document.getElementById('review').setAttribute('href', bookingPageUrl);
            document.getElementById('continueButton').classList.add('d-none'); // Hide continue button
            document.getElementById('review').classList.remove('d-none'); // Show review button


            toastr.success('Seat successfully blocked!', 'Success');
        } else {
            throw new Error(data.message || 'Failed to block seat');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        toastr.error(`Error: ${error.message}`, 'Error');
    });
}

</script>
@endsection
@section('styles')
<!-- Include Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<style>  
#pickupPointSection, #droppingPointSection {
  width: 48%; /* Each section takes 48% of the width */
  padding: 12px;
  background-color: #f8f9fa;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-bottom: 15px; /* Adjusted bottom margin */
}
.pickup-point-item, .dropping-point-item {
  margin-bottom: 10px; /* Reduced margin */
  padding: 12px;
  border: 1px solid #ddd;
  border-radius: 5px;
  background-color: #ffffff;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  text-align: left;
  font-size: 14px; /* Slightly smaller font for readability */
}
.pickup-point-item h5, .dropping-point-item h5 {
  margin: 0 0 8px;
  font-size: 16px;
  color: #333;
}
.pickup-point-item p, .dropping-point-item p {
  text-transform: none;
  margin: 3px 0; /* Reduced spacing between text */
  font-size: 12px; /* Reduced font size */
  color: #555;
}
.seat {
  width: 40px; /* Adjust size as necessary */
  height: 40px;
  background-color: transparent;
  border-radius: 5px;
  display: flex;
  align-items: center;
  justify-content: center;
  background-size: cover;
  background-position: center;
  transition: background-color 0.3s ease;
}
.seat-available {
    background-color: transparent;
}

.seat-booked {
    background-color: #6c757d;
}

.seat-selected {
    background-color: #28a745; /* Green for selected */
}

.seat-price {
    font-size: 0.8rem;
    color: #28a745;
    font-weight: bold;
}
.bus-seats {
    display: flex;
    flex-direction: row; /* Arrange rows horizontally */
    gap: 10px; /* Space between each row */
    justify-content: center; /* Center the rows horizontally */
    flex-wrap: wrap; /* Allow rows to wrap if necessary */
    width: 100%;
    overflow: hidden; /* Prevent seats from overflowing */
}
.seat-image-container {
    position: relative; /* Seat image is positioned relative */
    text-align: center; /* Center the seat number */
}
.seat-image {
    width: 40px; /* Adjust size as necessary */
    height: auto;
    display: block;
    margin: 0 auto; /* Center the image */
    transform: rotate(90deg);
}
.bus-layout {
    display: flex;
    flex-direction: column;
    gap: 30px;
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}

.deck {
    border: 2px solid #e0e0e0;
    padding: 20px;
    border-radius: 10px;
    background: #fff;
}

.deck h4 {
    margin: 0 0 20px 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
    color: #333;
    font-size: 16px;
}

.deck-seats {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.seat-row {
    display: flex;
    gap: 15px;
    justify-content: flex-start;
    flex-wrap: wrap;
}

.seat-wrapper {
    position: relative;
}

.seat {
    width: 50px;
    height: 50px;
    border: 2px solid #ddd;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 5px;
}

.seat-available {
    background-color: #e8f5e9;
    border-color: #81c784;
}

.seat-booked {
    background-color: #ffebee;
    border-color: #e57373;
    cursor: not-allowed;
}

.upper-berth {
    background-color: #e3f2fd;
    border-color: #64b5f6;
}

.lower-berth {
    background-color: #f3e5f5;
    border-color: #ba68c8;
}

.seat-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
}

.seat-number {
    font-weight: bold;
    font-size: 12px;
}

.seat-price {
    font-size: 10px;
    color: #666;
    margin-top: 2px;
}

.ladies-seat {
    position: relative;
}

.ladies-seat::after {
    content: '♀';
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ff4081;
    color: white;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.seat:hover:not(.seat-booked) {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.seat-selected {
    background-color: #4caf50 !important;
    border-color: #2e7d32 !important;
    color: white;
}
.seat-container {
    display: flex;
    flex-direction: column; /* Stack seat image and info vertically */
    align-items: center; /* Center seat contents */
    width: 60px; /* Control the width of the seat container */
}
#seatLayoutContainer {
    width: 100%;  /* Make sure seat layout takes up the full width */
    max-width: 100%; /* Ensure it spans the entire container */
    margin: 0 auto;
    padding: 10px;
    border: 2px solid green; /* Green border around the container */
    border-radius: 10px;  /* Optional: Rounded corners */
    background-color: #f9f9f9; /* Optional: Light background color */
    overflow: hidden; /* Prevent overflow of seats outside the container */
}
.seat-number {
  position: absolute;
  top: 50%; /* Vertically center the seat number */
  left: 50%; /* Horizontally center the seat number */
  transform: translate(-50%, -50%); /* Adjust to perfectly center the seat number */
  font-size: 12px; /* Reduced font size to fit inside the seat */
  font-weight: bold;
  color: white; /* Make the seat number color stand out on the seat */
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5); /* Optional: Add a shadow to make the number more readable */
}
.seat-info {
    text-align: center;
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 4px;
}
#selectedSeatInfo {
  margin-top: 10px;
  margin-bottom: 10px;
  padding: 15px;
  background-color: #f8f9fa;
  border-radius: 5px;
  text-align: center;
}
#continueButtonContainer {
  margin-top: 20px;
  text-align: center; /* Center the button horizontally */
}

#continueButton {
  background-color: #28a745;
  border-radius: 30px;
  padding: 20px 40px;
  font-size: 24px;
  font-weight: bold;
  color: white;
  border: none;
  width: 80%;
  max-width: 400px;
  cursor: pointer;
}

#continueButton:hover {
  background-color: #218838; /* Darker green on hover */
}
</style>
@endsection
