document.addEventListener('DOMContentLoaded', function () {
    fetchSeatLayout();
});

let selectedSeat = null;
let selectedSeatDetails = null;

function fetchSeatLayout() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('TraceId');
    const resultIndex = urlParams.get('ResultIndex');

    if (!traceId || !resultIndex) {
        showError("TraceId and ResultIndex are required.");
        return;
    }

    const loadingHtml = `
        <div class="alert alert-info">
            <div class="spinner-border spinner-border-sm me-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            Loading seat layout...
        </div>
    `;
    document.getElementById('seatLayout').innerHTML = loadingHtml;

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

function renderSeatLayout(seatDetails) {
    const seatLayoutContainer = document.getElementById('seatLayout');
    if (!seatDetails || !Array.isArray(seatDetails) || seatDetails.length === 0) {
        showError('No seat layout data available.');
        return;
    }

    let layoutHTML = '<div class="bus-seats">';
    
    // Add a visual representation of the bus front
    layoutHTML += `
        <div class="bus-front mb-4">
            <div class="text-center p-2 bg-secondary text-white rounded">
                <small>Bus Front</small>
            </div>
        </div>
    `;

    seatDetails.forEach((row, rowIndex) => {
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
                                onclick="handleSeatClick(this, ${JSON.stringify(seat).replace(/"/g, '&quot;')})">
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

function handleSeatClick(element, seatData) {
    // Don't allow selecting booked seats
    if (!seatData.SeatStatus) {
        return;
    }

    // Remove previous selection
    const previousSelected = document.querySelector('.seat-selected');
    if (previousSelected) {
        previousSelected.classList.remove('seat-selected');
    }

    // Add selection to clicked seat
    element.classList.add('seat-selected');

    // Update selected seat details
    selectedSeat = seatData.SeatName;
    selectedSeatDetails = seatData;

    // Show selected seat information
    const selectedSeatInfo = document.getElementById('selectedSeatInfo');
    const selectedSeatDetails = document.getElementById('selectedSeatDetails');
    const continueButton = document.getElementById('continueButton');

    selectedSeatInfo.classList.remove('d-none');
    selectedSeatDetails.innerHTML = `
        <div class="mb-2">
            <strong>Seat Number:</strong> ${seatData.SeatName}
        </div>
        <div class="mb-2">
            <strong>Price:</strong> ₹${seatData.Price.PublishedPriceRoundedOff}
        </div>
        <div class="mb-2">
            <strong>Type:</strong> ${seatData.IsLadiesSeat ? 'Ladies Seat' : 'General Seat'}
        </div>
    `;
    continueButton.classList.remove('d-none');
}

function showError(message) {
    const seatLayoutContainer = document.getElementById('seatLayout');
    seatLayoutContainer.innerHTML = `
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            ${message}
        </div>
    `;
}

// Event listener for continue button
document.getElementById('continueButton')?.addEventListener('click', function() {
    if (selectedSeatDetails) {
        // Trigger the passenger details modal
        document.getElementById('openPassengerDetailsModal').click();
    } else {
        showError('Please select a seat first.');
    }
});