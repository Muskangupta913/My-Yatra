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
 <!-- Seat Layout Section -->
 <h3 class="text-center">Select Seats</h3>
<div class="section-container mb-4" id="seatLayoutContainer">
    <div id="seatLayout" class="bus-seats" data-trace-id="" data-result-index=""></div>
</div>

<!-- Right Section: Pickup and Dropping Points -->
<div class="section-container" id="pickupDroppingContainer">
    <h5 class="text-center">Select Pickup & Dropping Points</h5>
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
                const normalizedData = normalizeLayoutData(data.data);
                renderSeatLayout(normalizedData);
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
    // If data is already an array, it's in the second format
    if (Array.isArray(data)) {
        return data;
    }
    
    // If data is an object, convert it to array format
    const rows = [];
    Object.keys(data).forEach(rowKey => {
        const rowData = [];
        Object.keys(data[rowKey]).forEach(seatKey => {
            rowData.push(data[rowKey][seatKey]);
        });
        if (rowData.length > 0) {
            rows.push(rowData);
        }
    });
    return rows;
}

function renderSeatLayout(seatDetails) {
    const seatLayoutContainer = document.getElementById('seatLayout');
    
    if (!seatDetails || !Array.isArray(seatDetails) || seatDetails.length === 0) {
        showError('No seat layout data available.');
        return;
    }

    let layoutHTML = '<div class="bus-seats">';

    // Helper function to render individual seats
    function renderSeat(seat) {
        const seatClass = seat.SeatStatus ? 'seat-available' : 'seat-booked';
        const seatName = seat.SeatName || 'N/A';
        const seatPrice = seat.Price?.PublishedPriceRoundedOff || 0;
        const seatStatusText = seat.SeatStatus ? 'Available' : 'Booked';
        const seatImage = seat.SeatStatus ? availableSeatImage : bookedSeatImage;

        return `
            <div class="seat-container">
                <div 
                    class="seat ${seatClass}" 
                    onclick='selectSeat(this, ${JSON.stringify(seat)})'
                    data-seat='${JSON.stringify(seat)}'>
                    <div class="seat-image-container">
                        <span class="seat-number">${seatName}</span>
                        <img src="${seatImage}" alt="Seat Image" class="seat-image">
                    </div>
                </div>
                <div class="seat-info">
                    <small class="seat-status">${seatStatusText}</small>
                    <small class="seat-price">₹${seatPrice}</small>
                </div>
            </div>
        `;
    }

    // Iterate over each row
    seatDetails.forEach((row, rowIndex) => {
        if (Array.isArray(row)) {
            layoutHTML += '<div class="row">';

            // Special handling for Row 3 (middle gap)
            if (rowIndex === 2) {
                layoutHTML += '<div class="row middle-gap-row">';

                // Left Side Seats (Seats 1 and 2)
                row.slice(0, 2).forEach(seat => {
                    if (seat && typeof seat === 'object') {
                        layoutHTML += renderSeat(seat);
                    }
                });

                // Right Side Seats (Seats 3 to 12)
                row.slice(2, 12).forEach(seat => {
                    if (seat && typeof seat === 'object') {
                        layoutHTML += renderSeat(seat);
                    }
                });

                // Only display 1 seat for the last column (13th seat)
                if (row[12]) {
                    layoutHTML += renderSeat(row[12]);
                }

                layoutHTML += '</div>'; // End of middle gap row
            } else {
                // For Rows 1, 2, 4, and 5: Display seats normally
                row.forEach(seat => {
                    if (seat && typeof seat === 'object') {
                        layoutHTML += renderSeat(seat);
                    }
                });
            }

            layoutHTML += '</div>'; // End of row
        }
    });

    layoutHTML += '</div>'; // End of bus seats
    seatLayoutContainer.innerHTML = layoutHTML; // Render directly into the seat layout container
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

    container.innerHTML = points.map((point, index) => `
        <div class="pickup-point-item" data-point-id="${index}">
            <div class="position-relative p-3">
                <!-- Time Badge -->
                <span class="pickup-time position-absolute top-0 end-0 m-2">
                    🕒 ${formatTime(point.time)}
                </span>
                
                <!-- Point Name -->
                <h6 class="mb-3">${point.name}</h6>
                
                <!-- Details Grid -->
                <div class="point-details">
                    <p><i class="fas fa-map-marker-alt"></i> ${point.location}</p>
                    <p><i class="fas fa-building"></i> ${point.address}</p>
                    <p><i class="fas fa-landmark"></i> ${point.landmark}</p>
                    <p><i class="fas fa-phone"></i> ${point.contact_number}</p>
                </div>
                
               <!-- Select Button -->
<button class="btn btn-success btn-sm mt-3 select-btn" 
    onclick="selectPickupPoint(${index}, '${point.name.replace(/'/g, "\\'")}')">
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

    container.innerHTML = points.map((point, index) => `
        <div class="dropping-point-item" data-point-id="${index}">
            <div class="position-relative p-3">
                <!-- Time Badge -->
                <span class="pickup-time position-absolute top-0 end-0 m-2">
                    🕒 ${formatTime(point.time)}
                </span>
                
                <!-- Point Name and Location -->
                <h6 class="mb-3">${point.name}</h6>
                <p><i class="fas fa-map-marker-alt"></i> ${point.location}</p>
               <!-- Select Button -->
<button class="btn btn-success btn-sm mt-3 select-btn" 
    onclick="selectPickupPoint(${index}, '${point.name.replace(/'/g, "\\'")}')">
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
function selectPickupPoint(pointId, pointName) {
    selectedBoardingPointId = pointId;
    selectedBoardingPointName = pointName;

    document.querySelectorAll('.pickup-point').forEach(point => point.classList.remove('selected'));
    document.querySelector(`.pickup-point[data-point-id="${pointId}"]`).classList.add('selected');
}

function selectDroppingPoint(pointId, pointName) {
    selectedDroppingPointId = pointId;
    selectedDroppingPointName = pointName;

    document.querySelectorAll('.dropping-point').forEach(point => point.classList.remove('selected'));
    document.querySelector(`.dropping-point[data-point-id="${pointId}"]`).classList.add('selected');
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
                BoardingPoint: JSON.stringify(data.data.BoardingPointdetails),
                DroppingPoint: JSON.stringify(data.data.DroppingPointsDetails),
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
            document.getElementById('continueButton').classList.add('d-none');
            document.getElementById('review').classList.remove('d-none');

            alert('Seat successfully blocked!');
        } else {
            throw new Error(data.message || 'Failed to block seat');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(`Error: ${error.message}`);
    });
}
</script>
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
  width: 50px; /* Adjust size as necessary */
  height: 50px;
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
