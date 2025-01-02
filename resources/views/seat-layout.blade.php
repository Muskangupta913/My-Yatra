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
  <div class="section-container mb-4" id="seatLayoutContainer">
    <h3 class="text-center">Select Seats</h3>
    <div id="seatLayout" class="bus-seats" data-trace-id="" data-result-index=""></div>
  </div>

  <!-- Pickup and Dropping Points Section -->
  <div class="section-container mb-4" id="pickupDroppingContainer">
    <h3 class="text-center"> Select Pickup and Dropping Points</h3>
    <div class="pickup-dropping-container">
      <div id="pickupPointSection" class="pickup-point">
        <h5>Pickup Points</h5>
        <div id="pickupPointsContainer" class="pickup-points">
          <p>Loading pickup points...</p>
        </div>
      </div>

      <div id="droppingPointSection" class="dropping-point">
        <h5>Dropping Points</h5>
        <div id="droppingPointsContainer" class="dropping-points">
          <p>Loading dropping points...</p>
        </div>
      </div>
    </div>
  </div>
 <!-- Selected Seat Info Section -->
 <div id="selectedSeatInfo" class="section-container mb-4">
    <h5 class="text-center">Selected Seat</h5>
    <p id="selectedSeatDetails" class="text-center">No seat selected yet.</p>
  </div>
  <!-- Continue Button Section -->
  <div id="continueButtonContainer" class="section-container text-center">
    <button class="btn btn-success" id="continueButton">Continue</button>
    <a href="#" class="btn btn-success mt-2 d-none" id="review">Review Details</a>
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
          <button type="submit" class="btn btn-success w-100 mt-4">Block Seat</button>
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
 // Pass the correct image URLs from Laravel to JavaScript
 const availableSeatImage = "{{ asset('assets/seat.png') }}";
 const bookedSeatImage = "{{ asset('assets/seat.png') }}";

 function renderSeatLayout(seatDetails) {
    const seatLayoutContainer = document.getElementById('seatLayout');
    if (!seatDetails || !Array.isArray(seatDetails) || seatDetails.length === 0) {
        showError('No seat layout data available.');
        return;
    }

    let layoutHTML = '<div class="bus-seats">';

    seatDetails.forEach((row, rowIndex) => {
        if (Array.isArray(row)) {
            if (rowIndex === 2) {
                // Row 3 (Middle gap with 5 seats: 2 on the left, 2 on the right, 1 in the middle)
                layoutHTML += '<div class="row middle-gap-row">';
                
                // Left Side Seats
                row.slice(0, 2).forEach(seat => {
                    if (seat && typeof seat === 'object') {
                        const seatClass = seat.SeatStatus ? 'seat-available' : 'seat-booked';
                        const seatName = seat.SeatName || 'N/A';
                        const seatPrice = seat.Price?.PublishedPriceRoundedOff || 0;
                        const seatStatusText = seat.SeatStatus ? 'Available' : 'Booked';
                        const seatImage = seat.SeatStatus ? availableSeatImage : bookedSeatImage;

                        layoutHTML += `
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
                });

                // Right Side Seats
                row.slice(2, 4).forEach(seat => {
                    if (seat && typeof seat === 'object') {
                        const seatClass = seat.SeatStatus ? 'seat-available' : 'seat-booked';
                        const seatName = seat.SeatName || 'N/A';
                        const seatPrice = seat.Price?.PublishedPriceRoundedOff || 0;
                        const seatStatusText = seat.SeatStatus ? 'Available' : 'Booked';
                        const seatImage = seat.SeatStatus ? availableSeatImage : bookedSeatImage;

                        layoutHTML += `
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
                });

                // Single Seat in the middle (last position)
                row.slice(4, 5).forEach(seat => {
                    if (seat && typeof seat === 'object') {
                        const seatClass = seat.SeatStatus ? 'seat-available' : 'seat-booked';
                        const seatName = seat.SeatName || 'N/A';
                        const seatPrice = seat.Price?.PublishedPriceRoundedOff || 0;
                        const seatStatusText = seat.SeatStatus ? 'Available' : 'Booked';
                        const seatImage = seat.SeatStatus ? availableSeatImage : bookedSeatImage;

                        layoutHTML += `
                            <div class="seat-container middle-seat">
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
                });

                layoutHTML += '</div>'; // End of middle gap row
            } else if (rowIndex === 0 || rowIndex === 1) {
                // Row 1 and 2 (Left side seats)
                layoutHTML += '<div class="row left-side-row">';
                
                row.forEach(seat => {
                    if (seat && typeof seat === 'object') {
                        const seatClass = seat.SeatStatus ? 'seat-available' : 'seat-booked';
                        const seatName = seat.SeatName || 'N/A';
                        const seatPrice = seat.Price?.PublishedPriceRoundedOff || 0;
                        const seatStatusText = seat.SeatStatus ? 'Available' : 'Booked';
                        const seatImage = seat.SeatStatus ? availableSeatImage : bookedSeatImage;

                        layoutHTML += `
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
                });

                layoutHTML += '</div>'; // End of left side row
            } else if (rowIndex === 3 || rowIndex === 4) {
                // Row 4 and 5 (Right side seats)
                layoutHTML += '<div class="row right-side-row">';
                
                row.forEach(seat => {
                    if (seat && typeof seat === 'object') {
                        const seatClass = seat.SeatStatus ? 'seat-available' : 'seat-booked';
                        const seatName = seat.SeatName || 'N/A';
                        const seatPrice = seat.Price?.PublishedPriceRoundedOff || 0;
                        const seatStatusText = seat.SeatStatus ? 'Available' : 'Booked';
                        const seatImage = seat.SeatStatus ? availableSeatImage : bookedSeatImage;

                        layoutHTML += `
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
                });

                layoutHTML += '</div>'; // End of right side row
            }
        }
    });

    layoutHTML += '</div>'; // End of bus-seats container
    seatLayoutContainer.innerHTML = layoutHTML;
}

function selectSeat(element, seatData) {
    if (element.classList.contains('seat-booked')) return;

    document.querySelectorAll('.seat-selected').forEach(seat => seat.classList.remove('seat-selected'));
    element.classList.add('seat-selected');

    selectedSeatDetails = seatData;
    selectedSeat = seatData.SeatName;

    document.getElementById('selectedSeatInfo').classList.remove('d-none');
    document.getElementById('selectedSeatDetails').innerText = 
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



let selectedBoardingPointName = ''; // Store selected boarding point name
let selectedDroppingPointName = ''; // Store selected dropping point name

// Function to handle the selection of pickup point
function selectPickupPoint(pointId, pointName) {
    // Remove previous selection
    document.querySelectorAll('.pickup-point-item').forEach(item => {
        item.classList.remove('selected');
    });
    
    // Add selection to current point
    const selectedPoint = document.querySelector(`.pickup-point-item[data-point-id="${pointId}"]`);
    if (selectedPoint) {
        selectedPoint.classList.add('selected');
    }
    
    selectedBoardingPointId = pointId;
    selectedBoardingPointName = pointName;
    
    // Show success toast instead of alert
    showToast(`Pickup point selected: ${pointName}`, 'success');
}

function selectDroppingPoint(pointId, pointName) {
    // Remove previous selection
    document.querySelectorAll('.dropping-point-item').forEach(item => {
        item.classList.remove('selected');
    });
    
    // Add selection to current point
    const selectedPoint = document.querySelector(`.dropping-point-item[data-point-id="${pointId}"]`);
    if (selectedPoint) {
        selectedPoint.classList.add('selected');
    }
    
    selectedDroppingPointId = pointId;
    selectedDroppingPointName = pointName;
    
    // Show success toast instead of alert
    showToast(`Dropping point selected: ${pointName}`, 'success');
}

function showToast(message, type = 'info') {
    // You can use any toast library here, or create a simple one
    // Example using Bootstrap toast
    const toastHTML = `
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast align-items-center text-white bg-${type}" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', toastHTML);
    const toastElement = document.querySelector('.toast:last-child');
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
    
    // Remove toast element after it's hidden
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}

//block seat api
function blockSeat(passengerData) {
    if (!selectedBoardingPointId || !selectedDroppingPointId) {
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
#busBookingContainer {
  padding: 20px;
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
  text-transform: none;
  margin: 3px 0; /* Reduced spacing between text */
  font-size: 12px; /* Reduced font size */
  color: #555;
}


/* Seat Image Styling */
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

/* Seat Status Classes (will be applied dynamically) */
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
/* Seat Info (Status and Price) */
.seat-info {
    text-align: center;
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 4px;
}
.middle-seat {
    display: block;
    justify-content: center;
    text-align: center;
}
.middle-gap-row {
  display: flex;
  justify-content: center; /* Center the middle seat in the gap row */
  gap: 10px; /* Space between seats */
}
.row {
    display: flex; /* Seats arranged horizontally */
    justify-content: center;
    gap: 10px; /* Space between seats */
    flex-wrap: nowrap; /* No wrapping within rows */
}
.middle-gap {
    width: 20px;
}
/* Seat Layout Section */
.bus-seats {
    display: flex;
    flex-direction: row; /* Arrange rows horizontally */
    gap: 20px; /* Space between each row */
    justify-content: center; /* Center the rows horizontally */
    flex-wrap: wrap; /* Allow rows to wrap if necessary */
}
/* Individual Seat Rows */
.bus-seats .row {
  display: flex; /* Arrange seats in a row horizontally */
  justify-content: space-between; /* Space out the seats in each row */
  gap: 10px; /* Space between individual seats in the row */
  width: 100%; /* Allow rows to span full width */
}

/* Seat Container (for each seat) */
.seat-container {
    display: flex;
    flex-direction: column; /* Stack seat image and info vertically */
    align-items: center; /* Center seat contents */

    width: 60px; /* Control the width of the seat container */
}
.seat-image-container {
    position: relative; /* Seat image is positioned relative */
    text-align: center; /* Center the seat number */
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
.seat-image {
    width: 40px; /* Adjust size as necessary */
    height: auto;
    display: block;
    margin: 0 auto; /* Center the image */
    transform: rotate(90deg);
}
.middle-gap {
    width: 20px; /* Adjust as per the middle gap requirement */
}
.middle-gap-row {
    justify-content: center;
    margin-top: 15px;
}
.left-side-row, .right-side-row {
    display: flex;
    justify-content: space-between; /* Seats side by side */
}
.seat-status {
    font-size: 0.8rem;
    color: #6c757d;
}
#seatLayoutContainer {
  text-align: center;
}

/* Selected Seat Info Section */
#selectedSeatInfo {
  margin-top: 10px;
  margin-bottom: 10px;
  padding: 15px;
  background-color: #f8f9fa;
  border-radius: 5px;
  text-align: center;
}

#selectedSeatDetails {
  font-weight: bold;
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
}
</style>
@endsection
