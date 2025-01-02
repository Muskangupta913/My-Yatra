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
    <h3 class="text-center"> Seclect Pickup and Dropping Points</h3>
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
        if (data.status === true) {
            renderSeatLayout(data.data.SeatLayout.SeatLayoutDetails.Layout.seatDetails);
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
    if (!seatDetails || seatDetails.length === 0) {
        showError('Seat layout data is missing or unavailable.');
        return;
    }

    let layoutHTML = '<div class="bus-seats">';
    seatDetails.forEach((row) => {
        layoutHTML += '<div class="row">'; // Start a new row

        row.forEach(seat => {
            const seatClass = seat.SeatStatus ? 'seat-available' : 'seat-booked';
            const seatName = seat.SeatName || 'N/A';
            const seatPrice = seat.Price?.PublishedPrice || 0;
            const seatStatusText = seat.SeatStatus ? 'Available' : 'Booked';
            const seatImage = seat.SeatStatus ? availableSeatImage : bookedSeatImage; // Replace with your actual image URLs

            layoutHTML += `
                <div class="seat-container">
                    <div 
                        class="seat ${seatClass}" 
                        onclick='selectSeat(this, ${JSON.stringify(seat)})'
                        data-seat='${JSON.stringify(seat)}'>
                          <div class="seat-image-container">
                <span class="seat-number">${seatName}</span>  <!-- Seat Number -->
                <img src="${seatImage}" alt="Seat Image" class="seat-image">  <!-- Seat Image -->
            </div>
                    </div>

                    <!-- Seat status and price -->
                    <div class="seat-info">
                        <small class="seat-status">${seatStatusText}</small>
                        <small class="seat-price">₹${seatPrice}</small>
                    </div>
                </div>
            `;
        });

        layoutHTML += '</div>'; // Close row
    });
    layoutHTML += '</div>'; // Close bus-seats container
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
        Seat: ${seatData.SeatName}, Price: ₹${seatData.Price.PublishedPrice};

    // Show the Continue button
    document.getElementById('continueButton').classList.remove('d-none');
}

// Trigger the modal when the Continue button is clicked
document.getElementById('continueButton').addEventListener('click', function() {
    // Trigger the modal to show passenger details
    const modalTriggerButton = document.getElementById('openPassengerDetailsModal');
    modalTriggerButton.click();
    
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

    document.getElementById('pickupPointsContainer').innerHTML = 
        '<div class="alert alert-info">Loading pickup points...</div>';
    document.getElementById('droppingPointsContainer').innerHTML = 
        '<div class="alert alert-info">Loading dropping points...</div>';

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
            const result = data.GetBusRouteDetailResult.GetBusRouteDetailResult;

            if (result && result.BoardingPointsDetails && result.BoardingPointsDetails.length > 0) {
                renderPickupPoints(result.BoardingPointsDetails);
            } else {
                document.getElementById('pickupPointsContainer').innerHTML = 
                    '<div class="alert alert-warning">No pickup points available</div>';
            }

            if (result && result.DroppingPointsDetails && result.DroppingPointsDetails.length > 0) {
                renderDroppingPoints(result.DroppingPointsDetails);
            } else {
                document.getElementById('droppingPointsContainer').innerHTML = 
                    '<div class="alert alert-warning">No dropping points available</div>';
            }
        } else {
            throw new Error(data.message || 'Failed to load boarding details');
        }
    })
    .catch(error => {
        showError(error.message);
    });
}

function renderPickupPoints(pickupPoints) {
    const container = document.getElementById('pickupPointsContainer');
    // Clear the container to avoid nesting issues
    container.innerHTML = '';

    // Render each pickup point as a separate div
    pickupPoints.forEach(point => {
      const formattedDate = formatDate(point.CityPointTime);
      const formattedTime = formatTime(point.CityPointTime);  // Format the time
        container.innerHTML += `
             <div class="pickup-point-item p-3 mb-2 d-flex flex-column" data-point-id="${point.CityPointIndex}" style="position: relative;">
             <!-- Time in the top right corner -->
        <p class="pickup-time" style="position: absolute; top: 5px; right: 10px; font-size: 12px; color: black; margin-top: 5px;">&#x1F552; ${formatTime(point.CityPointTime)}</p> <!-- Time 🕒 with margin-top for space -->
        <h6 style="margin-top: 20px;margin-bottom: 10px;">${point.CityPointName}</h6> <!-- Added margin-bottom to create space -->
        <!-- Pickup details in a flex layout -->
        <div class="d-flex justify-content-between align-items-start" style="flex-wrap: wrap;">
            <p><strong>&#x1F4CD;Location:</strong> ${point.CityPointLocation}</p> <!-- Location 📍 -->
            <p><strong>&#x1F3E0;Address:</strong> ${point.CityPointAddress}</p> <!-- Address 🏠 -->
            <p><strong>&#x1F3DB;Landmark:</strong> ${point.CityPointLandmark}</p> <!-- Landmark 🏛️ -->
            <p><strong>&#x1F4DE;Contact:</strong> ${point.CityPointContactNumber || 'N/A'}</p> <!-- Contact 📞 -->
            <!-- Select Button -->
            <button class="btn btn-success btn-sm mt-2" 
                onclick="selectPickupPoint(${point.CityPointIndex}, '${point.CityPointName}')">
                ✅ Select
            </button>
        </div>
    </div>`;
    });
}

function renderDroppingPoints(droppingPoints) {
    const container = document.getElementById('droppingPointsContainer');
    // Clear the container to avoid nesting issues
    container.innerHTML = '';

    // Render each dropping point as a separate div
    droppingPoints.forEach(point => {
      const formattedTime = formatTime(point.CityPointTime);  // Format the time
        container.innerHTML += `
            <div class="dropping-point-item p-3 mb-2" data-point-id="${point.CityPointIndex}">
                <h6>${point.CityPointName}</h6>
                <p>🕒 Time: ${formattedTime}</p> <!-- Show the formatted time -->
                <p>📍 Location: ${point.CityPointLocation}</p>
                <button class="btn btn-success btn-sm" 
                    onclick="selectDroppingPoint(${point.CityPointIndex}, '${point.CityPointName}')">
                    ✅ Select
                </button>
            </div>`;
    });
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
            const bookingPageUrl = /booking?TraceId=${bookingDetails.TraceId}&BusBookingStatus=${encodeURIComponent(bookingDetails.BusBookingStatus)}&InvoiceAmount=${bookingDetails.InvoiceAmount}&BusId=${bookingDetails.BusId}&TicketNo=${bookingDetails.TicketNo}&TravelOperatorPNR=${bookingDetails.TravelOperatorPNR}&PassengerData=${encodeURIComponent(JSON.stringify(passengerData))}&BoardingPointName=${encodeURIComponent(selectedBoardingPointName)}&DroppingPointName=${encodeURIComponent(selectedDroppingPointName)};
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
        alert(Error: ${error.message});
    });
}
// document.getElementById('payNowButton').addEventListener('click', function() {
//     const passengerData = {
//         Title: document.getElementById('title').value,
//         FirstName: document.getElementById('firstName').value,
//         LastName: document.getElementById('lastName').value,
//         Email: document.getElementById('email').value,
//         Phoneno: document.getElementById('phoneNumber').value,
//         Gender: parseInt(document.getElementById('gender').value, 10),
//         Age: parseInt(document.getElementById('age').value, 10),
//         Address: document.getElementById('address').value,
//         Seat: {
//             SeatName: selectedSeatDetails.SeatName,
//             ColumnNo: parseInt(selectedSeatDetails.ColumnNo, 10),
//             RowNo: parseInt(selectedSeatDetails.RowNo, 10),
//         },
//         LeadPassenger: true // Assuming this is the first passenger and should be marked as lead
//     };

//     const payload = {
//         ResultIndex: new URLSearchParams(window.location.search).get('ResultIndex'),
//         TraceId: new URLSearchParams(window.location.search).get('TraceId'),
//         BoardingPointId: selectedBoardingPointId,
//         DroppingPointId: selectedDroppingPointId,
//         BoardingPointName: selectedBoardingPointName, // Include selected boarding point name in the payload
//         DroppingPointName: selectedDroppingPointName, // Include selected dropping point name in the payload
//         RefID: '1', // Replace with your reference id
//         Passenger: [passengerData]
//     };

//     fetch('/bookSeats', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json',
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//         },
//         body: JSON.stringify(payload)
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.status === 'success') {
//             alert('Bus booked successfully!');
//             const bookingDetails = data.data;
//             const bookingPageUrl = /booking?TraceId=${bookingDetails.TraceId}&BusBookingStatus=${encodeURIComponent(bookingDetails.BusBookingStatus)}&InvoiceAmount=${bookingDetails.InvoiceAmount}&BusId=${bookingDetails.BusId}&TicketNo=${bookingDetails.TicketNo}&TravelOperatorPNR=${bookingDetails.TravelOperatorPNR}&PassengerData=${encodeURIComponent(JSON.stringify(passengerData))}&BoardingPointName=${encodeURIComponent(selectedBoardingPointName)}&DroppingPointName=${encodeURIComponent(selectedDroppingPointName)};

//             // Redirect to the booking page:
//             window.location.href = bookingPageUrl;
//         } else {
//             alert('Booking failed: ' + data.message);
//         }
//     })
//     .catch(error => {
//         alert('Error: ' + error.message);
//     });
// });
</script>
<style>
  .seat-image {
    width: 50px; /* Adjust as per your requirements */
    height: auto;
    display: block;
    margin: 0 auto; /* Center the image */
}
/* Main Container for Bus Booking */
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
  margin: 3px 0; /* Reduced spacing between text */
  font-size: 12px; /* Reduced font size */
  color: #555;
}


/* Seat Image Styling */
.seat {
    width: 60px; /* Adjust size as necessary */
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    position: relative;
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

/* Seat Info (Status and Price) */
.seat-info {
    text-align: center;
    font-size: 0.8rem;
    color: #6c757d;
    margin-top: 4px;
}

/* Seat Selection Layout */
.bus-seats {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
}
.seat-number {
    position: absolute;
    top: 10px;  /* Position the seat name above the image */
    left: 50%;
    transform: translateX(-50%);  /* Center horizontally */
    font-size: 16px;  /* Adjust font size */
    color: black;  /* Make the seat name text black */
    font-weight: bold;  /* Optional: Make it bold */
    z-index: 1;  /* Ensure the seat name appears above the image */
}
.seat-image-container {
    position: relative;  /* Allow absolute positioning for the seat name */
    text-align: center;  /* Center the content */
}
.seat-container {
    display: flex;
    flex-direction: column;  /* Stack elements vertically */
    align-items: center;     /* Center content horizontally */
}

.seat-status {
    font-size: 0.8rem;
    color: #6c757d;
    display: block;
    margin-top: 4px;
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
  text-align: center; /* Center the text */
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
  border-radius: 30px; /* Rounded corners */
  padding: 20px 40px; /* Increased padding for larger button */
  font-size: 24px; /* Larger text size */
  font-weight: bold; /* Bold text */
  color: white;
  border: none;
  width: 80%; /* Increased width to make it larger */
  max-width: 400px; /* Limit the maximum width for very large screens */
  cursor: pointer;
  transition: background-color 0.3s ease;
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