@extends('frontend.layouts.master')
@section('title', 'Bus Booking')
@section('content')
@section('styles')
<!-- Include Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<style>  
#pickupPointSection, #droppingPointSection {
  width: 48%;
  padding: 12px;
  background-color: #f8f9fa;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-bottom: 15px;
}

.pickup-point-item, .dropping-point-item {
  margin-bottom: 10px;
  padding: 12px;
  border: 1px solid #ddd;
  border-radius: 5px;
  background-color: #ffffff;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  text-align: left;
  font-size: 14px;
}

.pickup-point-item h5, .dropping-point-item h5 {
  margin: 0 0 8px;
  font-size: 16px;
  color: #333;
}

.pickup-point-item p, .dropping-point-item p {
  text-transform: none;
  margin: 3px 0;
  font-size: 12px;
  color: #555;
}
.vertical-layout {
    display: flex;
    flex-direction: column; /* Stack rows vertically */
    gap: 10px; /* Add space between rows */
}

.seat-column {
    display: flex;
    flex-direction: row-reverse; /* Reverse the horizontal arrangement */
    gap: 5px; /* Add space between seats */
}

.seat-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 50px; /* Adjust as needed */
    width: 50px; /* Adjust as needed */
    text-align: center;
}
.empty {
    visibility: hidden; /* Hide empty seats */
}


.bus-layout {
    display: flex;
    flex-direction: column;
    gap: 30px;
    padding: 20px;
    max-width: 800px;
    margin: 0 auto;
}
.decks-container {
    display: flex;
    justify-content: space-between; /* Space between the two decks */
    align-items: stretch; /* Align decks to the top */
    gap: 20px; /* Add space between the decks */
    padding: 20px; /* Optional: padding around the container */
    flex-wrap: wrap;
     max-width: 100%;
}

.deck {
    flex: 1;
    max-width: 50%;
    min-height: 400px; /* Added fixed minimum height */
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    box-sizing: border-box;
    display: flex; /* Added display flex */
    flex-direction: column; /* Stack content vertically */
}
.deck-title {
    text-align: center;
    margin-bottom: 10px;
    font-size: 18px;
    font-weight: bold;
    flex-shrink: 0; /* Prevent title from shrinking */
}
.deck-seats {
    display: flex;
    flex-direction: column;
    gap: 5px;
    justify-content: flex-start; /* Changed from center to flex-start */
    align-items: center;
    flex: 1; /* Allow seats container to grow */
}
.deck h4 {
    margin: 0 0 20px 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
    color: #333;
    font-size: 16px;
    flex-shrink: 0; /* Prevent header from shrinking */
}
.seat {
    border: 2px solid #ddd;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 5px;
    position: relative;
    margin-bottom: 25px;
}
/* Adjusting layout for Sleeper seats in a Column layout */
.sleeper-column {
    display: flex;
    flex-direction: column; /* Stack sleepers vertically */
    gap: 40px; /* Add space between sleeper seats */
    justify-content: flex-start; /* Align to the top */
    flex-wrap: wrap; /* Allow seats to wrap when necessary */
    padding: 10px; /* Optional: Add padding around the sleeper seats */
}

/* Specific for Sleeper seats */
.seat.sleeper {
    width: 40px;  /* Sleeper seats are wider */
    height: 80px; /* Sleeper seats are taller */
    background-color: #f7b7d8;
    margin-bottom: 25px;
    position: relative;
    z-index: 1; /* Ensure sleeper seats don't overlap */
}
.seat-wrapper[data-seat-type="sleeper"] {
    height: 40px;
    margin-bottom: 60px; /* Increased bottom margin to prevent overlap */
}
/* Seat shapes */
.seat.seater {
    width: 40px;
    height: 40px;
}

/* Seat states with increased specificity */
.seat.seat-available {
    background-color: transparent !important;
    border-color: #81c784 !important;
}

.seat.seat-booked {
    background-color: #808080 !important;
    border-color: #666666 !important;
    cursor: not-allowed !important;
}

.seat.seat-selected {
    background-color: #4caf50 !important;
    border-color: #2e7d32 !important;
    color: white !important;
}

.ladies-seat {
    border-color: #ff69b4 !important;
}

.ladies-seat.seat-available {
    background-color: rgba(255, 105, 180, 0.1) !important;
}

.ladies-seat.seat-booked {
    background-color: rgba(255, 105, 180, 0.5) !important;
}
/* Price display */
.seat-price {
    display: block !important;
    position: absolute;
    bottom: -30px;
    left: 50%;
    transform: translateX(-50%);
    color: #666;
    font-size: 12px;
    white-space: nowrap;
    pointer-events: none;
}

/* Seat number */
.seat-number {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 12px;
    font-weight: bold;
    color: black;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
}

/* Hover effect only for available seats */
.seat.seat-available:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Status tooltip */
.seat-status {
    display: none;
    position: absolute;
    background-color: #333;
    color: #fff;
    padding: 8px 12px;
    border-radius: 4px;
    font-size: 12px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 10;
    white-space: nowrap;
    bottom: 110%;
    left: 50%;
    transform: translateX(-50%);
    line-height: 1.2;
}

.seat:hover .seat-status {
    display: block;
}

/* Seat information display */
.seat-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 100%;
    position: relative;
}
.sleeper-bus {
    display: flex;
    gap: 40px;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 12px;
}

.berth-column {
    display: flex;
    flex-direction: column;
    gap: 15px;
    min-width: 120px;
}

.sleeper-wrapper {
    width: 120px;
    height: 200px;
    margin-bottom: 15px;
    position: relative;
    perspective: 1000px;
}

.seat-row {
    display: flex;
    gap: 15px;
    justify-content: flex-start;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

/* Hover effects */
.seat:hover:not(.seat-booked) {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.seat:hover:not(.seat-booked) {
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
#selectedSeatInfo {
    background-color: #fff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
/* Stack decks vertically for mobile screens */
@media screen and (max-width: 768px) {
    .decks-container {
        flex-direction: column; /* Stack decks vertically */
        gap: 20px; /* Add smaller gap between decks */
    }

    .deck {
        max-width: 100%;
        min-height: 300px; /* Slightly smaller minimum height for mobile */
    }

  #pickupDroppingContainer {
    flex-direction: column;
    gap: 20px;
  }
  #pickupPointSection, #droppingPointSection {
    width: 100%;
  }
  .pickup-point-item, .dropping-point-item {
    padding: 8px;
  }
  .pickup-point-item h5, .dropping-point-item h5 {
    font-size: 14px;
  }
  .pickup-point-item p, .dropping-point-item p {
    font-size: 12px;
  }
}

/* Extra small screens (mobile phones in portrait mode) */
@media screen and (max-width: 480px) {
    .deck-title {
        font-size: 16px; /* Slightly smaller title font */
    }

    .deck-seats {
        gap: 2px; /* Smaller gap between seats */
    }

    .deck {
        min-height: 250px; /* Even smaller minimum height for very small screens */
        padding: 8px;
    }
    .pickup-point-item h5, .dropping-point-item h5 {
    font-size: 16px;
  }

  .pickup-point-item p, .dropping-point-item p {
    font-size: 12px;
  }
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

<div class="container mt-4">
    <div class="section-container" id="selectedSeatInfo" class="mt-2 d-none">
        <h4>Selected Seats</h4>
        <div id="selectedSeatsContainer"></div>
        <div id="totalAmount" class="mt-2"></div>
    </div>
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
        <div id="passengerFormContainer">
            <!-- Dynamic passenger forms will be inserted here -->
        </div>
        <button type="submit" id="blockSeatButton" class="btn btn-success w-100 mt-4">Block Selected Seats</button>
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


let selectedSeats = [];
const maxSeatsAllowed = 6;
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
            upper: data.data.upper,
            busType: data.data.busType || 'seater', 
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
    const normalized = {
        lower: [],
        upper: [],
        busType: data.busType || 'seater',
    };

    // Handle lower deck
    if (data.lower) {
        // For seater buses (array format)
        if (Array.isArray(data.lower)) {
            normalized.lower = data.lower.map(row => {
                // Ensure each row is an array
                return Array.isArray(row) ? row : Object.values(row);
            });
        } 
        // For sleeper/mixed buses (object format)
        else {
            normalized.lower = Object.values(data.lower).map(row => 
                Array.isArray(row) ? row : Object.values(row)
            );
        }
    }

    // Handle upper deck
    if (data.upper) {
        normalized.upper = Object.values(data.upper).map(row => 
            Array.isArray(row) ? row : Object.values(row)
        );
    }

    return normalized;
}

function renderSeatLayout(seatDetails) {
    const seatLayoutContainer = document.getElementById('seatLayout');
    const normalizedData = normalizeLayoutData(seatDetails);
    
    
    let layoutHTML = '<div class="bus-layout">';
// Render Lower Deck and Upper Deck side-by-side
if (normalizedData.lower.length > 0 || normalizedData.upper.length > 0) {
    layoutHTML += `
        <div class="decks-container">
            ${normalizedData.lower.length > 0
                ? `
                <div class="deck lower-deck">
                    <h4 class="deck-title">Lower Deck</h4>
                    <div class="deck-seats">
                        ${renderDeckSeats(normalizedData.lower)}
                    </div>
                </div>`
                : ''}
            ${normalizedData.upper.length > 0
                ? `
                <div class="deck upper-deck">
                    <h4 class="deck-title">Upper Deck</h4>
                    <div class="deck-seats">
                        ${renderDeckSeats(normalizedData.upper)}
                    </div>
                </div>`
                : ''}
        </div>`;
}

    layoutHTML += '</div>';
    seatLayoutContainer.innerHTML = layoutHTML;

    // Add event listener for continue button
    document.getElementById('continueButton')?.addEventListener('click', handleContinue);
}
function renderDeckSeats(deckData, busType)
 {
    // If it's a sleeper bus, use the sleeper layout
    if (busType === 'sleeper') {
        return renderSleeperLayout(deckData);
    }
    // Otherwise use the original seater layout
    return renderSeaterLayout(deckData);
}

function renderSeaterLayout(deckData) 
{
    // Keep your existing seater bus layout code here
    let seatsHTML = '<div class="vertical-layout">';
 const maxColumns = deckData[0]?.length || 0; // Get the number of columns
    const maxRows = deckData.length; // Get the number of rows

    // Loop column by column (to create vertical stacks)
    for (let columnIndex = 0; columnIndex < maxColumns; columnIndex++) {
        seatsHTML += '<div class="seat-column">'; // Start a new column

        for (let rowIndex = 0; rowIndex < maxRows; rowIndex++) {
            const seat = deckData[rowIndex][columnIndex]; // Get the seat at [row][column]

            if (seat && typeof seat === 'object') {
                // Determine seat properties
                const isSleeper = seat.SeatType === 2;
                const seatTypeClass = isSleeper ? 'sleeper' : 'seater';

                const seatClasses = [
                    'seat',
                    seatTypeClass,
                    seat.SeatStatus ? 'seat-available' : 'seat-booked',
                    seat.IsLadiesSeat ? 'ladies-seat' : '',
                ].filter(Boolean).join(' ');

                const seatPrice = seat.Price?.PublishedPriceRoundedOff || 
                                seat.Price?.FareRoundedOff || 
                                seat.FareRoundedOff || 0;
                const statusText = seat.SeatStatus ? 'Available' : 'Booked';
                const genderText = seat.IsLadiesSeat ? 'Female Only' : 'Male/Female';
                const fullStatus = `${statusText} (${genderText})`;

                // Add seat HTML
                seatsHTML += ` 
                    <div class="seat-wrapper" 
                         data-row="${rowIndex + 1}" 
                         data-column="${columnIndex + 1}"
                         data-seat-type="${seatTypeClass}">
                        <div class="${seatClasses}" 
                             data-seat='${JSON.stringify(seat)}' 
                             onclick="selectSeat(this)">
                            <div class="seat-info">
                                <span class="seat-number">${seat.SeatName || `${rowIndex + 1}-${columnIndex + 1}`}</span>
                                <span class="seat-price">₹${seatPrice}</span>
                                <span class="seat-status">${fullStatus}</span>
                            </div>
                        </div>
                    </div>`;
            } else {
                 // Add empty space for missing seats
                 seatsHTML += '<div class="seat-wrapper empty"></div>';
            }
        }

        seatsHTML += '</div>'; // End the column
    }

    seatsHTML += '</div>'; // Close the container
    return seatsHTML;
}
function renderSleeperLayout(deckData) {
    // Maintain a vertical-layout container for consistency
    let seatsHTML = '<div class="vertical-layout">';

    const maxColumns = deckData[0]?.length || 0; // Number of columns
    const maxRows = deckData.length; // Number of rows

    // Loop column by column (to create vertical stacks)
    for (let columnIndex = 0; columnIndex < maxColumns; columnIndex++) {
        seatsHTML += '<div class="seat-column">'; // Start a new column

        for (let rowIndex = 0; rowIndex < maxRows; rowIndex++) {
            const seat = deckData[rowIndex][columnIndex]; // Get the seat at [row][column]

            if (seat && typeof seat === 'object') {
                // Determine seat properties
                const isSleeper = seat.SeatType === 2;
                const seatTypeClass = isSleeper ? 'sleeper' : 'seater';

                const seatClasses = [
                    'seat',
                    seatTypeClass,
                    seat.SeatStatus ? 'seat-available' : 'seat-booked',
                    seat.IsLadiesSeat ? 'ladies-seat' : '',
                ].filter(Boolean).join(' ');

                const seatPrice = seat.Price?.PublishedPriceRoundedOff || 
                                seat.Price?.FareRoundedOff || 
                                seat.FareRoundedOff || 0;
                const statusText = seat.SeatStatus ? 'Available' : 'Booked';
                const genderText = seat.IsLadiesSeat ? 'Female Only' : 'Male/Female';
                const fullStatus = `${statusText} (${genderText})`;

                // Add seat HTML
                seatsHTML += ` 
                    <div class="seat-wrapper" 
                         data-row="${rowIndex + 1}" 
                         data-column="${columnIndex + 1}"
                         data-seat-type="${seatTypeClass}">
                        <div class="${seatClasses}" 
                             data-seat='${JSON.stringify(seat)}' 
                             onclick="selectSeat(this)">
                            <div class="seat-info">
                                <span class="seat-number">${seat.SeatName || `${rowIndex + 1}-${columnIndex + 1}`}</span>
                                <span class="seat-price">₹${seatPrice}</span>
                                <span class="seat-status">${fullStatus}</span>
                            </div>
                        </div>
                    </div>`;
            } else {
                // Add empty space for missing seats
                seatsHTML += '<div class="seat-wrapper empty"></div>';
            }
        }

        seatsHTML += '</div>'; // End the column
    }

    seatsHTML += '</div>'; // Close the container
    return seatsHTML;
}

function selectSeat(element) {
    try {
        const seatData = JSON.parse(element.dataset.seat);
        if (!seatData.SeatStatus) {
            showError('This seat is already booked.');
            return;
        }

        const isSelected = element.classList.contains('seat-selected');
        
        if (isSelected) {
            // Deselect seat
            removeSeat(seatData.SeatName);
        } else {
            // Select new seat
            if (selectedSeats.length >= maxSeatsAllowed) {
                showError(`You can only select up to ${maxSeatsAllowed} seats.`);
                return;
            }
            
            element.classList.add('seat-selected');
            selectedSeats.push(seatData);
            selectedSeatDetails = seatData;
            
            // Update storage
            sessionStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
            sessionStorage.setItem('selectedSeatDetails', JSON.stringify(selectedSeatDetails));
            
            updateSelectedSeatsDisplay();
        }
    } catch (error) {
        console.error('Error in selectSeat:', error);
        showError('Error selecting seat. Please try again.');
    }
}

function updateSelectedSeatsDisplay() {
    const selectedSeatInfo = document.getElementById('selectedSeatInfo');
    const seatsContainer = document.getElementById('selectedSeatsContainer');
    const totalAmountElement = document.getElementById('totalAmount');
    const continueButton = document.getElementById('continueButton');

    if (selectedSeats.length > 0) {
        selectedSeatInfo.classList.remove('d-none');
        
        const seatsHTML = selectedSeats.map(seat => {
            const seatPrice = seat.Price?.PublishedPriceRoundedOff || 
                            seat.Price?.FareRoundedOff || 
                            seat.FareRoundedOff || 0;
            
            return `
                <div class="selected-seat-item border p-2 mb-2 d-flex justify-content-between align-items-center">
                    <span>Seat ${seat.SeatName}</span>
                    <span>₹${seatPrice}</span>
                    <button onclick="removeSeat('${seat.SeatName}')" class="btn btn-sm btn-danger">×</button>
                </div>
            `;
        }).join('');
        
        seatsContainer.innerHTML = seatsHTML;

        const totalAmount = selectedSeats.reduce((sum, seat) => {
            return sum + (seat.Price?.PublishedPriceRoundedOff || 
                         seat.Price?.FareRoundedOff || 
                         seat.FareRoundedOff || 0);
        }, 0);
        
        totalAmountElement.innerHTML = `<strong>Total Amount: ₹${totalAmount}</strong>`;
        continueButton.classList.remove('d-none');
    } else {
        selectedSeatInfo.classList.add('d-none');
        seatsContainer.innerHTML = '';
        totalAmountElement.innerHTML = '';
        continueButton.classList.add('d-none');
    }
}

function removeSeat(seatName) {
    const allSeats = document.querySelectorAll('.seat');
    for (const seatElement of allSeats) {
        try {
            const seatData = JSON.parse(seatElement.dataset.seat);
            if (seatData.SeatName === seatName) {
                // Remove the selected class
                seatElement.classList.remove('seat-selected');
                break;
            }
        } catch (error) {
            console.error('Error parsing seat data:', error);
        }
    }
    
    selectedSeats = selectedSeats.filter(seat => seat.SeatName !== seatName);
    if (selectedSeatDetails?.SeatName === seatName) {
        selectedSeatDetails = null;
    }
    
    sessionStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
    sessionStorage.setItem('selectedSeatDetails', JSON.stringify(selectedSeatDetails));
    
    updateSelectedSeatsDisplay();
}
function handleContinue() {
    if (!selectedSeats.length) {
        showError('Please select at least one seat to continue.');
        return;
    }

    if (!selectedBoardingPointId || !selectedDroppingPointId) {
        showError('Please select both boarding and dropping points before continuing.');
        return;
    }

    // Update the passenger form container with forms for each selected seat
    const formContainer = document.getElementById('passengerFormContainer');
    formContainer.innerHTML = selectedSeats.map((seat, index) => 
        generatePassengerForm(seat.SeatName, index)
    ).join('');

    // Show the modal
    const modalTriggerButton = document.getElementById('openPassengerDetailsModal');
    if (modalTriggerButton) {
        modalTriggerButton.click();
    }
}
function generatePassengerForm(seatNumber, index) {
    return `
        <div class="passenger-form mb-4 p-3 border rounded" data-seat="${seatNumber}">
            <h6 class="mb-3">Passenger Details for Seat ${seatNumber}</h6>
            <div class="form-group mb-2">
                <label>Title</label>
                <select class="form-control" name="passenger[${index}][Title]" required>
                    <option value="">Select</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                    <option value="Dr">Dr</option>
                </select>
            </div>
            <div class="form-group mb-2">
                <label>First Name</label>
                <input type="text" class="form-control" name="passenger[${index}][FirstName]" required>
            </div>
            <div class="form-group mb-2">
                <label>Last Name</label>
                <input type="text" class="form-control" name="passenger[${index}][LastName]" required>
            </div>
            <div class="form-group mb-2">
                <label>Gender</label>
                <select class="form-control" name="passenger[${index}][Gender]" required>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                </select>
            </div>
            <div class="form-group mb-2">
                <label>Age</label>
                <input type="number" class="form-control" name="passenger[${index}][Age]" required>
            </div>
                <div class="form-group mb-2">
                    <label>Email</label>
                    <input type="email" class="form-control" name="passenger[${index}][Email]" required>
                </div>
                <div class="form-group mb-2">
                    <label>Phone Number</label>
                    <input type="text" class="form-control" name="passenger[${index}][Mobile]" required>
                </div>
                <div class="form-group mb-2">
                    <label>Address</label>
                    <textarea class="form-control" name="passenger[${index}][Address]" rows="2" required></textarea>
                </div>
        </div>
    `;
}
function showError(message) {
    // Create or get error element
    let errorElement = document.getElementById('seatSelectionError');
    if (!errorElement) {
        errorElement = document.createElement('div');
        errorElement.id = 'seatSelectionError';
        errorElement.className = 'error-message';
        document.querySelector('.bus-layout').insertAdjacentElement('afterbegin', errorElement);
    }

    // Show error message
    errorElement.textContent = message;
    errorElement.style.display = 'block';

    // Hide after 3 seconds
    setTimeout(() => {
        errorElement.style.display = 'none';
    }, 3000);
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
                <h5 class="mb-3">${point.location}</h5>
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

    const validationErrors = [];
    const formData = new FormData(e.target);
    const passengers = [];
    
  // Validate lead passenger's contact details first
  const leadPassengerContactFields = [
        { name: 'passenger[0][Email]', label: 'Email' },
        { name: 'passenger[0][Mobile]', label: 'Phone Number' },
        { name: 'passenger[0][Address]', label: 'Address' }
    ];

    // Check lead passenger's contact details
    leadPassengerContactFields.forEach(field => {
        const value = formData.get(field.name);
        if (!value || value.trim() === '') {
            validationErrors.push(`${field.label} is required for lead passenger`);
        }
    });

    // Validate lead passenger's email format
    const leadEmail = formData.get('passenger[0][Email]');
    if (leadEmail) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(leadEmail)) {
            validationErrors.push('Please enter a valid email address for lead passenger');
        }
    }

    // Validate lead passenger's phone number
    const leadPhone = formData.get('passenger[0][Mobile]');
    if (leadPhone) {
        const phoneRegex = /^[6-9]\d{9}$/;
        if (!phoneRegex.test(leadPhone)) {
            validationErrors.push('Please enter a valid 10-digit phone number for lead passenger');
        }
    }

    // Validate all passengers' details
    selectedSeats.forEach((seat, index) => {
        // Required fields for all passengers
        const requiredFields = [
            { name: `passenger[${index}][Title]`, label: `Title for Seat ${seat.SeatName}` },
            { name: `passenger[${index}][FirstName]`, label: `First Name for Seat ${seat.SeatName}` },
            { name: `passenger[${index}][LastName]`, label: `Last Name for Seat ${seat.SeatName}` },
            { name: `passenger[${index}][Gender]`, label: `Gender for Seat ${seat.SeatName}` },
            { name: `passenger[${index}][Age]`, label: `Age for Seat ${seat.SeatName}` }
        ];

        // Add optional contact fields for non-lead passengers
        if (index > 0) {
            const optionalFields = [
                { name: `passenger[${index}][Email]`, label: `Email for Seat ${seat.SeatName}` },
                { name: `passenger[${index}][Mobile]`, label: `Phone Number for Seat ${seat.SeatName}` },
                { name: `passenger[${index}][Address]`, label: `Address for Seat ${seat.SeatName}` }
            ];
            
            // Validate optional email format if provided
            const email = formData.get(`passenger[${index}][Email]`);
            if (email && email.trim() !== '') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    validationErrors.push(`Please enter a valid email address for Seat ${seat.SeatName}`);
                }
            }

            // Validate optional phone number if provided
            const phone = formData.get(`passenger[${index}][Mobile]`);
            if (phone && phone.trim() !== '') {
                const phoneRegex = /^[6-9]\d{9}$/;
                if (!phoneRegex.test(phone)) {
                    validationErrors.push(`Please enter a valid 10-digit phone number for Seat ${seat.SeatName}`);
                }
            }
        }

        // Check required fields
        requiredFields.forEach(field => {
            const value = formData.get(field.name);
            if (!value || value.trim() === '') {
                validationErrors.push(`${field.label} is required`);
            }
        });

        // Validate age
        const age = formData.get(`passenger[${index}][Age]`);
        if (age) {
            const ageNum = parseInt(age);
            if (isNaN(ageNum) || ageNum < 1 || ageNum > 120) {
                validationErrors.push(`Please enter a valid age for Seat ${seat.SeatName}`);
            }
        }

        // Create passenger data object
        const passengerData = {
            LeadPassenger: index === 0,
            PassengerId: index,
            Title: formData.get(`passenger[${index}][Title]`),
            FirstName: formData.get(`passenger[${index}][FirstName]`),
            LastName: formData.get(`passenger[${index}][LastName]`),
            Gender: formData.get(`passenger[${index}][Gender]`),
            Age: parseInt(formData.get(`passenger[${index}][Age]`)),
            SeatIndex: seat.SeatIndex,
            IdType: null,
            IdNumber: null,
            Email: formData.get(`passenger[${index}][Email]`) || null,
            Mobile: formData.get(`passenger[${index}][Mobile]`) || null,
            Address: formData.get(`passenger[${index}][Address]`) || null
        };
        passengers.push(passengerData);
    });

    // If there are validation errors, show them and stop form submission
    if (validationErrors.length > 0) {
        validationErrors.forEach(error => {
            toastr.error(error);
        });
        return;
    }

    // Check if boarding and dropping points are selected
    if (!selectedBoardingPointId || !selectedDroppingPointId) {
        toastr.error('Please select both boarding and dropping points');
        return;
    }

    // If we reach here, all validations passed
    blockMultipleSeats(passengers);
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
function blockMultipleSeats(passengers) {
    if (!selectedBoardingPointId || !selectedDroppingPointId) {
        showError('Please select both boarding and dropping points before proceeding.');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('TraceId');
    const resultIndex = urlParams.get('ResultIndex');

    const payload = {
        ClientId: "180189",
        UserName: "MakeMy91",
        Password: "MakeMy@910",
        TraceId: traceId,
        ResultIndex: resultIndex,
        BoardingPointId: selectedBoardingPointId,
        DroppingPointId: selectedDroppingPointId,
        BoardingPointName: selectedBoardingPointName,
        DroppingPointName: selectedDroppingPointName,
        RefID: "1",
        Passenger: passengers
    };

    showLoadingSpinner();

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
        hideLoadingSpinner();
        if (data.status === true) {
            const passengerDetailsModal = bootstrap.Modal.getInstance(document.getElementById('passengerDetailsModal'));
            passengerDetailsModal.hide();

            // Map passengers to their selected seats using the SeatIndex
            const passengerDetails = passengers.map((passenger, index) => {
                // Get the corresponding seat from selectedSeats array using the passenger's index
                const selectedSeat = selectedSeats[index]; // Match by index since they're in the same order
                
                return {
                    LeadPassenger: passenger.LeadPassenger,
                    PassengerId: passenger.PassengerId,
                    Title: passenger.Title,
                    FirstName: passenger.FirstName,
                    LastName: passenger.LastName,
                    Gender: passenger.Gender,
                    Age: passenger.Age,
                    Email: passenger.Email,
                    Mobile: passenger.Mobile,
                    Address: passenger.Address,
                    SeatDetails: {
                        SeatName: selectedSeat.SeatName,
                        SeatNumber: selectedSeat.SeatNo || selectedSeat.SeatName,
                        SeatType: selectedSeat.SeatType === 2 ? 'Sleeper' : 'Seater',
                        Deck: selectedSeat.IsUpper ? 'Upper' : 'Lower',
                        Price: selectedSeat.Price?.PublishedPriceRoundedOff || 
                              selectedSeat.Price?.FareRoundedOff || 
                              selectedSeat.FareRoundedOff || 0,
                        SeatIndex: selectedSeat.SeatIndex
                    }
                };
            });

            // Create URL parameters with stringified data
            const urlParameters = new URLSearchParams({
                TraceId: traceId,
                ResultIndex: resultIndex,
                PassengerData: JSON.stringify(passengerDetails),
                BoardingPoint: JSON.stringify({
                    Id: selectedBoardingPointId,
                    Name: selectedBoardingPointName
                }),
                DroppingPoint: JSON.stringify({
                    Id: selectedDroppingPointId,
                    Name: selectedDroppingPointName
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
            });

            const bookingPageUrl = `/booking?${urlParameters.toString()}`;

            document.getElementById('review').setAttribute('href', bookingPageUrl);
            document.getElementById('continueButton').classList.add('d-none');
            document.getElementById('review').classList.remove('d-none');

            toastr.success('Seats successfully blocked!', 'Success');
        } else {
            throw new Error(data.message || 'Failed to block seat');
        }
    })
    .catch(error => {
        hideLoadingSpinner();
        console.error('Error:', error);
        toastr.error(`Error: ${error.message}`, 'Error');
    });
}

</script>
@endsection
