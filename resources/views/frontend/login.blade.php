function renderSeatLayout(seatDetails) {
    const seatLayoutContainer = document.getElementById('seatLayout');
    const normalizedData = normalizeLayoutData(seatDetails);
    
    let layoutHTML = '<div class="bus-layout" style="padding: 1rem;">';
    
    // Render Lower Deck and Upper Deck side-by-side
    if (normalizedData.lower.length > 0 || normalizedData.upper.length > 0) {
        layoutHTML += `
            <div class="decks-container" style="width: 100%;">
                ${normalizedData.lower.length > 0
                    ? `
                    <div class="deck lower-deck" style="margin-bottom: 2rem;">
                        <h4 style="font-size: 1.2rem; margin-bottom: 1rem;">Lower Deck</h4>
                        <div class="deck-seats">
                            ${renderDeckSeats(normalizedData.lower, 'mixed')}
                        </div>
                    </div>`
                    : ''}
                ${normalizedData.upper.length > 0
                    ? `
                    <div class="deck upper-deck">
                        <h4 style="font-size: 1.2rem; margin-bottom: 1rem;">Upper Deck</h4>
                        <div class="deck-seats">
                            ${renderDeckSeats(normalizedData.upper, 'mixed')}
                        </div>
                    </div>`
                    : ''}
            </div>`;
    }
    
    layoutHTML += '</div>';
    seatLayoutContainer.innerHTML = layoutHTML;

    document.getElementById('continueButton')?.addEventListener('click', handleContinue);
}

function renderDeckSeats(deckData, busType) {
    // Handle different bus types
    switch(busType) {
        case 'sleeper':
            return renderSleeperLayout(deckData);
        case 'mixed':
            return renderMixedLayout(deckData);
        default:
            return renderSeaterLayout(deckData);
    }
}

function renderMixedLayout(deckData) {
    let seatsHTML = '<div style="display: flex; gap: 2rem;">';
    
    // Left side (1 seat)
    seatsHTML += '<div style="display: flex; flex-direction: column;">';
    seatsHTML += renderSeatColumn(deckData, 0); // First column
    seatsHTML += '</div>';
    
    // Aisle gap
    seatsHTML += '<div style="width: 2rem;"></div>';
    
    // Right side (2 seats)
    seatsHTML += '<div style="display: flex; gap: 1rem;">';
    seatsHTML += renderSeatColumn(deckData, 1); // Second column
    seatsHTML += renderSeatColumn(deckData, 2); // Third column
    seatsHTML += '</div>';
    
    seatsHTML += '</div>';
    return seatsHTML;
}

function renderSeatColumn(deckData, columnIndex) {
    let columnHTML = '<div style="display: flex; flex-direction: column; gap: 0.5rem;">';
    
    for (let rowIndex = 0; rowIndex < deckData.length; rowIndex++) {
        const seat = deckData[rowIndex][columnIndex];
        
        if (seat && typeof seat === 'object') {
            const isSleeper = seat.SeatType === 2;
            const seatHeight = isSleeper ? '8rem' : '4rem';
            
            const seatClasses = [
                'seat',
                isSleeper ? 'sleeper' : 'seater',
                seat.SeatStatus ? 'seat-available' : 'seat-booked',
                seat.IsLadiesSeat ? 'ladies-seat' : ''
            ].filter(Boolean).join(' ');
            
            const seatPrice = seat.Price?.PublishedPriceRoundedOff || 
                            seat.Price?.FareRoundedOff || 
                            seat.FareRoundedOff || 0;
            
            const statusText = seat.SeatStatus ? 'Available' : 'Booked';
            const genderText = seat.IsLadiesSeat ? 'Female Only' : 'Male/Female';
            const fullStatus = `${statusText} (${genderText})`;
            
            columnHTML += `
                <div class="seat-wrapper" 
                     style="width: 4rem; height: ${seatHeight}; margin: 0.25rem;" 
                     data-row="${rowIndex + 1}" 
                     data-column="${columnIndex + 1}">
                    <div class="${seatClasses}" 
                         style="width: 100%; height: 100%; padding: 0.5rem; 
                                border: 2px solid ${seat.IsLadiesSeat ? '#ff4081' : '#ccc'}; 
                                border-radius: 0.5rem;
                                background-color: ${isSleeper ? '#f0f8ff' : 'white'};
                                cursor: ${seat.SeatStatus ? 'pointer' : 'not-allowed'};"
                         data-seat='${JSON.stringify(seat)}' 
                         onclick="selectSeat(this)">
                        <div class="seat-info" style="font-size: 0.8rem; text-align: center;">
                            <div style="font-weight: bold; margin-bottom: 0.25rem;">
                                ${seat.SeatName || `${rowIndex + 1}-${columnIndex + 1}`}
                            </div>
                            <div style="color: #666;">₹${seatPrice}</div>
                            <div style="font-size: 0.7rem; color: ${seat.SeatStatus ? '#4CAF50' : '#f44336'};">
                                ${fullStatus}
                            </div>
                        </div>
                    </div>
                </div>`;
        } else {
            columnHTML += `<div style="width: 4rem; height: 4rem; visibility: hidden;"></div>`;
        }
    }
    
    columnHTML += '</div>';
    return columnHTML;
}

// Your existing renderSeaterLayout and renderSleeperLayout functions remain unchanged
// Only modify the selectSeat function to handle the new styling

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
            element.classList.remove('seat-selected');
            element.style.backgroundColor = seatData.SeatType === 2 ? '#f0f8ff' : 'white';
            selectedSeats = selectedSeats.filter(seat => seat.SeatName !== seatData.SeatName);
            if (selectedSeatDetails?.SeatName === seatData.SeatName) {
                selectedSeatDetails = null;
            }
        } else {
            // Select new seat
            if (selectedSeats.length >= maxSeatsAllowed) {
                showError(`You can only select up to ${maxSeatsAllowed} seats.`);
                return;
            }
            
            element.classList.add('seat-selected');
            element.style.backgroundColor = '#4CAF50';
            selectedSeats.push(seatData);
            selectedSeatDetails = seatData;
        }

        updateSelectedSeatsDisplay();
        // Store in session storage
        sessionStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
        sessionStorage.setItem('selectedSeatDetails', JSON.stringify(selectedSeatDetails));
    } catch (error) {
        console.error('Error in selectSeat:', error);
        showError('Error selecting seat. Please try again.');
    }
}