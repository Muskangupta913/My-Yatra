function removeSeat(seatName) {
    // Find the seat element by iterating through all seats and comparing the SeatName
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
    
    // Update the arrays and storage
    selectedSeats = selectedSeats.filter(seat => seat.SeatName !== seatName);
    if (selectedSeatDetails?.SeatName === seatName) {
        selectedSeatDetails = null;
    }
    
    // Update session storage
    sessionStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
    sessionStorage.setItem('selectedSeatDetails', JSON.stringify(selectedSeatDetails));
    
    // Update the display
    updateSelectedSeatsDisplay();
}

// Update the selectSeat function to handle the selection state properly
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