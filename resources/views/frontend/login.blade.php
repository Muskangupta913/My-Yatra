// Update the addNewPassengerForm function
function addNewPassengerForm() {
    const formData = new FormData(document.getElementById('passenger-form'));
    
    // Create passenger data object
    const passengerData = {
        title: formData.get('Title'),
        firstName: formData.get('FirstName'),
        lastName: formData.get('LastName'),
        email: formData.get('Email'),
        phone: formData.get('Phoneno'),
        paxType: formData.get('PaxType'),
        pan: formData.get('PAN'),
        leadPassenger: formData.get('LeadPassenger') === 'on',
        childCount: parseInt(formData.get('ChildCount') || '0')  // Fix: Properly get childCount
    };

    // Validate required fields
    if (!passengerData.title || !passengerData.firstName || !passengerData.lastName || 
        !passengerData.email || !passengerData.phone || !passengerData.paxType) {
        alert('Please fill in all required fields');
        return;
    }

    // Validate email format
    if (!isValidEmail(passengerData.email)) {
        alert('Please enter a valid email address');
        return;
    }

    // Initialize passengerDetails array if it doesn't exist
    if (!window.passengerDetails) {
        window.passengerDetails = [];
    }

    // Add to global array
    window.passengerDetails.push(passengerData);

    // Update display
    updatePassengersDisplay();

    // Reset form
    document.getElementById('passenger-form').reset();

    // Show success message
    alert('Passenger added successfully!');
}

// Update the updatePassengersDisplay function
function updatePassengersDisplay() {
    const container = document.getElementById('passengers-container');
    
    // Create or get the passengers list section
    let passengersListSection = document.getElementById('passengers-list');
    if (!passengersListSection) {
        passengersListSection = document.createElement('div');
        passengersListSection.id = 'passengers-list';
        passengersListSection.style.marginTop = '20px';
        container.appendChild(passengersListSection);
    }
    
    // Update the display
    if (window.passengerDetails && window.passengerDetails.length > 0) {
        passengersListSection.innerHTML = '<h3>Added Passengers:</h3>' + 
            window.passengerDetails.map((passenger, index) => `
                <div style="border: 1px solid #ddd; padding: 10px; margin: 10px 0; border-radius: 4px;">
                    <div>
                        <strong>${passenger.title} ${passenger.firstName} ${passenger.lastName}</strong>
                        ${passenger.leadPassenger ? ' (Lead Passenger)' : ''}
                    </div>
                    <div>Type: ${passenger.paxType}</div>
                    <div>Email: ${passenger.email}</div>
                    <div>Phone: ${passenger.phone}</div>
                    ${passenger.pan ? `<div>PAN: ${passenger.pan}</div>` : ''}
                    ${passenger.childCount > 0 ? `<div>Children: ${passenger.childCount}</div>` : ''}
                    <button onclick="removePassenger(${index})" 
                            style="background-color: #ff4444; color: white; border: none; 
                                   padding: 5px 10px; margin-top: 10px; border-radius: 4px; 
                                   cursor: pointer;">
                        Remove
                    </button>
                </div>
            `).join('');
    } else {
        passengersListSection.innerHTML = '';
    }
}

// Update the checkBalance function
async function checkBalance() {
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'loading-overlay';
    loadingOverlay.innerHTML = '<div class="loading-spinner">Checking balance...</div>';
    document.body.appendChild(loadingOverlay);

    try {
        const requestData = {
            EndUserIp: '1.1.1.1',
            ClientId: '180133',
            UserName: 'MakeMy91',
            Password: 'MakeMy@910'
        };

        const response = await fetch('/balance', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(requestData)
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Network response was not ok');
        }

        if (data.status === 'success') {
            const formattedBalance = new Intl.NumberFormat('en-IN', {
                style: 'currency',
                currency: 'INR'
            }).format(data.balance);

            if (confirm(`Available Balance: ${formattedBalance}\nDo you want to proceed with the booking?`)) {
                const bookingDetails = fetchBookingDetails();
                const passengerDetails = window.passengerDetails || [];

                // Get room details with passenger information
                const roomDetailsWithPassengers = {
                    ...bookingDetails.roomDetails,
                    passengers: passengerDetails
                };

                const paymentParams = new URLSearchParams({
                    traceId: bookingDetails.traceId,
                    resultIndex: bookingDetails.resultIndex,
                    hotelCode: bookingDetails.hotelCode,
                    hotelName: bookingDetails.hotelName,
                    roomDetails: JSON.stringify(roomDetailsWithPassengers),
                    passengerDetails: JSON.stringify(passengerDetails)
                });

                window.location.href = `/payment?${paymentParams}`;
            }
        } else {
            throw new Error(data.message || 'Failed to fetch balance');
        }
    } catch (error) {
        console.error('Balance check failed:', error);
        alert('Unable to check balance: ' + error.message);
    } finally {
        document.body.removeChild(loadingOverlay);
    }
}