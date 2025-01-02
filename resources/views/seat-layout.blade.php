@extends('frontend.layouts.master')
@section('title', 'Bus Booking')
@section('content')

<!-- Add the CSRF meta tag in the header -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4" id="busBookingContainer">

<div class="d-flex flex-wrap">
    <!-- Left Section: Seat Layout -->
    <div class="col-12 col-md-8" id="seatLayoutContainer">
        <div class="section-container">
            <h5>Select Seats</h5>
            <div id="seatLayout" data-trace-id="" data-result-index=""></div>
        </div>
    </div>

    <!-- Right Section: Pickup and Dropping Points -->
    <div class="col-12 col-md-4" id="pickupDroppingContainer">
    <div class="section-container">
        <h5>Select Pickup & Dropping Point</h5>
        <div class="d-flex flex-column flex-sm-row justify-content-between">
            <!-- Pickup Points -->
            <div id="pickupPointSection" class="pickup-point mb-3 mb-sm-0">
                <h6>Pickup Point</h6>
                <div id="pickupPointsContainer" class="pickup-points text-center">
                    <p>Loading pickup points...</p>
                </div>
            </div>

            <!-- Dropping Points -->
            <div id="droppingPointSection" class="dropping-point">
                <h6>Dropping Point</h6>
                <div id="droppingPointsContainer" class="dropping-points text-center">
                    <p>Loading dropping points...</p>
                </div>
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
            <div class="mt-2">
                <button class="btn btn-success w-100" id="continueButton">Continue</button>
                <a href="#" class="btn btn-success w-100 mt-2 d-none" id="review">Review Details</a>
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
  // Helper function to format date into a readable format (Date)
function formatDate(dateTimeString) {
    const date = new Date(dateTimeString);
    return date.toLocaleDateString();  // This will format it based on the locale, e.g. "MM/DD/YYYY"
}

// Helper function to format time into a readable format (Time)
function formatTime(dateTimeString) {
    const date = new Date(dateTimeString);
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
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

    document.getElementById('seatLayout').innerHTML = '<div class="alert alert-info">Loading seat layout...</div>';

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
            if (data.status === true && Array.isArray(data.data)) {
                renderSeatLayout(data.data);
            } else {
                throw new Error(data.message || 'Failed to load seat layout');
            }
        })
        .catch(error => {
            showError(error.message);
        });
}

const availableSeatImage = "{{ asset('assets/seat.png') }}";
const bookedSeatImage = "{{ asset('assets/seat.png') }}";

function renderSeatLayout(seatDetails) {
    const seatLayoutContainer = document.getElementById('seatLayout');
    if (!seatDetails || !Array.isArray(seatDetails) || seatDetails.length === 0) {
        showError('No seat layout data available.');
        return;
    }

    let layoutHTML = '<div class="bus-seats">';
    seatDetails.forEach(row => {
        if (Array.isArray(row)) {
            layoutHTML += '<div class="row">';
            row.forEach(seat => {
                if (seat && typeof seat === 'object') {
                    const seatClass = seat.SeatStatus ? 'seat-available' : 'seat-booked';
                    const seatName = seat.SeatName || 'N/A';
                    const seatPrice = seat.Price?.PublishedPriceRoundedOff || 0;
                    const seatStatusText = seat.SeatStatus ? 'Available' : 'Booked';
                    const ladiesSeatClass = seat.IsLadiesSeat ? 'ladies-seat' : '';

                    layoutHTML += `
                        <div class="seat-container">
                            <div 
                                class="seat ${seatClass} ${ladiesSeatClass}"
                                data-seat-index="${seat.SeatIndex}"
                                onclick="selectSeat(this, ${JSON.stringify(seat).replace(/"/g, '&quot;')})">
                                <span class="seat-number">${seatName}</span>
                            </div>
                            <small class="seat-status">${seatStatusText}</small>
                            <small class="seat-price">₹${seatPrice}</small>
                        </div>
                    `;
                }
            });
            layoutHTML += '</div>';
        }
    });
    layoutHTML += '</div>';
    seatLayoutContainer.innerHTML = layoutHTML;
}

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

    document.getElementById('continueButton').classList.remove('d-none');
}

document.getElementById('continueButton').addEventListener('click', function () {
    document.getElementById('openPassengerDetailsModal').click();
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
                <button class="btn btn-outline-success btn-sm mt-3 select-btn" 
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
                <button class="btn btn-outline-success btn-sm mt-2 select-btn" 
                    onclick="selectDroppingPoint(${index}, '${point.name.replace(/'/g, "\\'")}')">
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
        Title: document.getElementById('title').value,
        FirstName: document.getElementById('firstName').value,
        LastName: document.getElementById('lastName').value,
        Email: document.getElementById('email').value,
        Phoneno: document.getElementById('phoneNumber').value,
        Gender: parseInt(document.getElementById('gender').value, 10),
        Age: parseInt(document.getElementById('age').value, 10),
        Address: document.getElementById('address').value,
        SeatDetails: selectedSeatDetails
    };

    blockSeat(passengerData);
});





// Function to handle the selection of pickup point
let selectedBoardingPointName = ''; // Store selected boarding point name
let selectedDroppingPointName = ''; // Store selected dropping point name

// Function to handle the selection of pickup point
function selectPickupPoint(pointId, pointName) {
    selectedBoardingPointId = pointId; // Store the selected boarding point ID globally
    selectedBoardingPointName = pointName; // Store the selected boarding point name globally

    alert(`Pickup Point Selected: ${pointName}`);
    console.log(`Selected Pickup: ID=${pointId}, Name=${pointName}`);

    // Optional: Highlight the selected pickup point
    document.querySelectorAll('.pickup-point').forEach(point => point.classList.remove('selected'));
    document.querySelector(`.pickup-point[data-point-id="${pointId}"]`).classList.add('selected');
}

// Function to handle the selection of dropping point
function selectDroppingPoint(pointId, pointName) {
    selectedDroppingPointId = pointId; // Store the selected dropping point ID globally
    selectedDroppingPointName = pointName; // Store the selected dropping point name globally

    alert(`Dropping Point Selected: ${pointName}`);
    console.log(`Selected Dropping: ID=${pointId}, Name=${pointName}`);

    // Optional: Highlight the selected dropping point
    document.querySelectorAll('.dropping-point').forEach(point => point.classList.remove('selected'));
    document.querySelector(`.dropping-point[data-point-id="${pointId}"]`).classList.add('selected');
}






//block seat api
function blockSeat(passengerData) {
  console.log("Boarding Point ID:", selectedBoardingPointId);
 console.log("Dropping Point ID:", selectedDroppingPointId);


    if (selectedBoardingPointId === undefined || selectedDroppingPointId === undefined) {
        alert('Please select both boarding and dropping points before proceeding.');
        return;
    }


    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('TraceId');
    const resultIndex = urlParams.get('ResultIndex');

    // Ensure the Seat object is populated correctly
    passengerData.Seat = {
        SeatName: selectedSeatDetails.SeatName,
        ColumnNo: parseInt(selectedSeatDetails.ColumnNo, 10), // Convert to integer
        RowNo: parseInt(selectedSeatDetails.RowNo, 10), // Convert to integer
        Height: 1, // Assuming a default value, adjust as necessary
        IsLadiesSeat: false, // Assuming a default value, adjust as necessary
        IsMalesSeat: false, // Assuming a default value, adjust as necessary
        IsUpper: false, // Assuming a default value, adjust as necessary
        SeatFare: selectedSeatDetails.Price.PublishedPrice, // Assuming this is the fare
        SeatIndex: selectedSeatDetails.SeatIndex, // Assuming this is available
        SeatType: 1, // Assuming a default value, adjust as necessary
        Width: 1, // Assuming a default value, adjust as necessary
        Price: {
            CurrencyCode: "INR", // Assuming a default value, adjust as necessary
            BasePrice: selectedSeatDetails.Price.BasePrice,
            Tax: selectedSeatDetails.Price.Tax || 0,
            OtherCharges: selectedSeatDetails.Price.OtherCharges || 0,
            Discount: selectedSeatDetails.Price.Discount || 0,
            PublishedPrice: selectedSeatDetails.Price.PublishedPrice,
            PublishedPriceRoundedOff: selectedSeatDetails.Price.PublishedPriceRoundedOff || selectedSeatDetails.Price.PublishedPrice,
            OfferedPrice: selectedSeatDetails.Price.OfferedPrice || selectedSeatDetails.Price.PublishedPrice,
            OfferedPriceRoundedOff: selectedSeatDetails.Price.OfferedPriceRoundedOff || selectedSeatDetails.Price.PublishedPrice,
            AgentCommission: selectedSeatDetails.Price.AgentCommission || 0,
            AgentMarkUp: selectedSeatDetails.Price.AgentMarkUp || 0,
            TDS: selectedSeatDetails.Price.TDS || 0,
            GST: {
                CGSTAmount: 0,
                CGSTRate: 0,
                CessAmount: 0,
                CessRate: 0,
                IGSTAmount: 0,
                IGSTRate: 18,
                SGSTAmount: 0,
                SGSTRate: 0,
                TaxableAmount: 0
            }
        }
    };

    const payload = {
        ResultIndex: resultIndex,
        TraceId: traceId,
        BoardingPointId: selectedBoardingPointId,
        DroppingPointId: selectedDroppingPointId,
        BoardingPointName: selectedBoardingPointName, // Include selected boarding point name in the payload
        DroppingPointName: selectedDroppingPointName, // Include selected dropping point name in the payload
        RefID: "1",
        Passenger: [passengerData]
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
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
        if (data.status === 'success') {
            alert('Seat successfully blocked!');
             // Close the modal after seat is blocked
             const passengerDetailsModal = bootstrap.Modal.getInstance(document.getElementById('passengerDetailsModal'));
            passengerDetailsModal.hide();  // Close the modal
            const bookingDetails = data.data;

            const bookingPageUrl = `/booking?TraceId=${traceId}&PassengerData=${encodeURIComponent(JSON.stringify(passengerData))}&BoardingPointName=${encodeURIComponent(selectedBoardingPointName)}&DroppingPointName=${encodeURIComponent(selectedDroppingPointName)}&SeatNumber=${encodeURIComponent(selectedSeatDetails.SeatName)}&Price=${encodeURIComponent(selectedSeatDetails.Price.PublishedPrice)}&ResultIndex=${encodeURIComponent(resultIndex)}`;
         // Set the href attribute to the booking page URL
            document.getElementById('review').setAttribute('href', bookingPageUrl);
            document.getElementById('review').classList.remove('d-none');
             // Hide the Continue button and show the Review Details button in its place
             document.getElementById('continueButton').classList.add('d-none');
            document.getElementById('review').classList.remove('d-none');
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
/* Main Container for Bus Booking */
#busBookingContainer {
  display: flex;
  justify-content: space-between;
  gap: 20px;
  padding: 20px;
  flex-wrap: wrap; /* Enables wrapping for smaller screens */
}

/* Container for Pickup and Dropping Points */
.pickup-dropping-container {
  display: flex;
  flex-wrap: wrap; /* Allow sections to stack on smaller screens */
  gap: 10px; /* Reduced spacing between sections */
  margin-top: 15px;
}

/* Pickup and Dropping Sections */
#pickupPointSection, #droppingPointSection {
  width: 48%; /* Each section takes 48% of the width */
  padding: 12px;
  background-color: #f8f9fa;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-bottom: 15px; /* Adjusted bottom margin */
}

/* Individual Pickup and Dropping Point Items */
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

/* Styling for Headers and Details */
.pickup-point-item h5, .dropping-point-item h5 {
  margin: 0 0 8px;
  font-size: 16px;
  color: #333;
}

.pickup-point-item p, .dropping-point-item p {
  margin: 3px 0; /* Reduced spacing between text */
  font-size: 12px; /* Reduced font size */
  color: #555;
}

/* Seat Available and Booked Status */
.seat-available {
    background-color: #28a745; /* Green */
    cursor: pointer;
}

.seat-booked {
    background-color: #dc3545; /* Red */
    cursor: not-allowed;
}

/* Buttons Styling */
button.btn-success {
  font-size: 14px;
  padding: 8px 15px;
  width: 100%; /* Full width for better usability */
  border-radius: 5px;
}

button.btn-success:hover {
  background-color: #218838;
  color: #fff;
}

.seat-status {
    font-size: 0.8rem;
    color: #6c757d;
    display: block;
    margin-top: 4px;
}

/* Seat Selection */
.bus-seats {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 10px;
}

.seat {
  width: 45px;
  height: 45px;
  background-color: #007bff;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.seat-available { background-color: #007bff; }
.seat-booked { background-color: #6c757d; cursor: not-allowed; }
.seat-selected { background-color: #28a745; }

.seat:hover {
  background-color: #0056b3; /* Darker blue on hover */
}

/* Selected Seat Info */
#selectedSeatInfo {
  margin-top: 10px;
  margin-bottom: 10px;
  padding: 15px;
  background-color: #f8f9fa;
  border-radius: 5px;
}

#selectedSeatDetails {
  font-weight: bold;
}

/* Book Now Button */
#payNowButton {
  display: block;
  width: 100%;
  padding: 10px;
  margin-top: 20px;
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
}

#payNowButton:hover {
  background-color: #218838;
}

/* Responsive Design */

/* Tablet (Medium Screens) */
@media (max-width: 768px) {
  #busBookingContainer {
    flex-direction: column;
    gap: 20px;
    padding: 10px;
  }

  #filterSection {
    width: 100%;
    margin-bottom: 20px;
  }

  .pickup-dropping-container {
    flex-direction: column;
    gap: 15px;
  }

  #pickupPointSection, #droppingPointSection {
    width: 100%;
  }

  /* Compacting pickup and dropping point items on smaller screens */
  .pickup-point-item, .dropping-point-item {
    padding: 8px;
  }

  .pickup-point-item h5, .dropping-point-item h5 {
    font-size: 14px;
  }

  .pickup-point-item p, .dropping-point-item p {
    font-size: 12px;
  }

  button.btn-success {
    font-size: 12px;
    padding: 8px;
  }
}

/* Mobile (Small Screens) */
@media (max-width: 480px) {
  #busBookingContainer {
    padding: 5px;
  }

  .pickup-point-item h5, .dropping-point-item h5 {
    font-size: 16px;
  }

  .pickup-point-item p, .dropping-point-item p {
    font-size: 12px;
  }

  button.btn-success {
    font-size: 12px;
    padding: 8px;
  }

  .seat {
    width: 40px;
    height: 40px;
    font-size: 12px;
  }

  #payNowButton {
    font-size: 14px;
    padding: 10px;
  }

  #continueButton {
    background-color: #28a745; /* Green background color */
    border-radius: 30px; /* Big rounded corners */
    padding: 15px; /* Increase the size of the button */
    font-size: 18px; /* Larger text */
    font-weight: bold; /* Bold text */
    border: none; /* Remove default border */
    color: white; /* White text */
    transition: background-color 0.3s; /* Smooth transition for hover effect */
  }

  /* Hover effect for better visual feedback */
  #continueButton:hover {
    background-color: #218838; /* Darker green on hover */
    color: white; /* Keep the text white on hover */
  }
}
</style>
@endsection
