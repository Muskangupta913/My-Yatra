// Update the global variables at the top
let selectedSeats = [];
let selectedSeatDetails = null; // This will store the currently selected seat details

function selectSeat(element) {
    const seatData = JSON.parse(element.dataset.seat);
    
    // Don't allow selection of booked seats
    if (!seatData.SeatStatus) {
        showError('This seat is already booked.');
        return;
    }

    const isSelected = element.classList.contains('seat-selected');
    
    if (isSelected) {
        // Deselect seat
        element.classList.remove('seat-selected');
        selectedSeats = selectedSeats.filter(seat => seat.SeatName !== seatData.SeatName);
        if (selectedSeatDetails?.SeatName === seatData.SeatName) {
            selectedSeatDetails = null;
        }
    } else {
        // Check if maximum seats limit reached
        if (selectedSeats.length >= maxSeatsAllowed) {
            showError(`You can only select up to ${maxSeatsAllowed} seats.`);
            return;
        }
        
        // Select seat
        element.classList.add('seat-selected');
        selectedSeats.push(seatData);
        // Store the selected seat details
        selectedSeatDetails = seatData;
    }

    updateSelectedSeatsDisplay();
}

function handleContinue() {
    if (selectedSeats.length === 0 || !selectedSeatDetails) {
        showError('Please select at least one seat to continue.');
        return;
    }

    // Store selected seats in session storage for next step
    sessionStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
    sessionStorage.setItem('selectedSeatDetails', JSON.stringify(selectedSeatDetails));
    
    // Show passenger details modal
    const modalTriggerButton = document.getElementById('openPassengerDetailsModal');
    if (modalTriggerButton) {
        modalTriggerButton.click();
    }
}

// Update the form submission handler
document.getElementById('passengerDetailsForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Retrieve the stored seat details
    const storedSeatDetails = sessionStorage.getItem('selectedSeatDetails');
    selectedSeatDetails = storedSeatDetails ? JSON.parse(storedSeatDetails) : null;

    if (!selectedSeatDetails) {
        showError('Please select a seat before submitting passenger details.');
        return;
    }

    const passengerData = {
        LeadPassenger: true,
        PassengerId: 0,
        Title: document.getElementById('title').value,
        FirstName: document.getElementById('firstName').value,
        LastName: document.getElementById('lastName').value,
        Email: document.getElementById('email').value,
        Mobile: document.getElementById('phoneNumber').value,
        Gender: document.getElementById('gender').value,
        IdType: null,
        IdNumber: null,
        Age: document.getElementById('age').value,
        Address: document.getElementById('address').value,
        SeatIndex: selectedSeatDetails.SeatIndex
    };

    blockSeat(passengerData);
});