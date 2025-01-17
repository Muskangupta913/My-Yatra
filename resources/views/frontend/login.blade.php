<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="booking-container"></div>

    <!-- Modal for passenger details -->
<div id="passenger-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Passenger Details</h3>
            <button class="close-button" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <!-- Added Passengers Section -->
            <div id="added-passengers" class="added-passengers-section" style="display: none;">
                <h4>Added Passengers</h4>
                <div id="passengers-list" class="passengers-list"></div>
            </div>

            <form id="passenger-form">
                <!-- Child Count Selection -->
                <div class="form-group">
                    <label for="child-count">Number of Children:</label>
                    <select id="child-count" name="ChildCount" class="form-control">
                        <option value="0">No Children</option>
                        <option value="1">1 Child</option>
                        <option value="2">2 Children</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="title">Title:</label>
                    <select id="title" name="Title" class="form-control" required>
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Miss">Miss</option>
                        <option value="Master">Master</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="first-name">First Name:</label>
                    <input type="text" id="first-name" name="FirstName" required>
                </div>

                <div class="form-group">
                    <label for="last-name">Last Name:</label>
                    <input type="text" id="last-name" name="LastName" required>
                </div>

                <div class="form-group">
                    <label for="phone-no">Phone Number:</label>
                    <input type="text" id="phone-no" name="Phoneno" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="Email" required>
                </div>

                <div class="form-group">
                    <label for="pax-type">Passenger Type:</label>
                    <select id="pax-type" name="PaxType" required>
                        <option value="1">Adult</option>
                        <option value="2">Child</option>
                    </select>
                </div>

                <div class="form-group checkbox-group">
                    <label for="lead-passenger">Lead Passenger:</label>
                    <input type="checkbox" id="lead-passenger" name="LeadPassenger">
                </div>

                <div class="form-group">
                    <label for="pan">PAN:</label>
                    <input type="text" id="pan" name="PAN">
                </div>

                <div class="form-actions">
                    <button type="button" class="add-passenger-btn" onclick="addPassenger()">Add Passenger</button>
                    <button type="submit" class="submit-btn">Submit All</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <script>

window.passengerDetails = [];

function addPassenger() {
    const form = document.getElementById('passenger-form');
    const formData = new FormData(form);
    
    const passengerData = {
        title: formData.get('Title'),
        firstName: formData.get('FirstName'),
        lastName: formData.get('LastName'),
        email: formData.get('Email'),
        phone: formData.get('Phoneno'),
        paxType: formData.get('PaxType'),
        leadPassenger: formData.get('LeadPassenger') === 'on',
        pan: formData.get('PAN'),
        childCount: formData.get('ChildCount')
    };

    // Validate required fields
    if (!passengerData.firstName || !passengerData.lastName || !passengerData.email || !passengerData.phone) {
        alert('Please fill in all required fields');
        return;
    }

    // Add to global array
    window.passengerDetails.push(passengerData);

    // Update the display
    updatePassengersDisplay();

    // Reset form but keep child count
    const childCount = form.querySelector('#child-count').value;
    form.reset();
    form.querySelector('#child-count').value = childCount;

    // Show success message
    alert('Passenger added successfully!');
}

function updatePassengersDisplay() {
    const addedPassengersSection = document.getElementById('added-passengers');
    const passengersList = document.getElementById('passengers-list');
    
    if (window.passengerDetails.length > 0) {
        addedPassengersSection.style.display = 'block';
        
        passengersList.innerHTML = window.passengerDetails.map((passenger, index) => `
            <div class="passenger-card">
                <div class="passenger-info">
                    <strong>${passenger.title} ${passenger.firstName} ${passenger.lastName}</strong>
                    <p>Type: ${passenger.paxType === '2' ? 'Child' : 'Adult'}</p>
                    <p>Email: ${passenger.email}</p>
                    <p>Phone: ${passenger.phone}</p>
                    ${passenger.leadPassenger ? '<p class="lead-badge">Lead Passenger</p>' : ''}
                </div>
                <button onclick="removePassenger(${index})" class="remove-btn">Remove</button>
            </div>
        `).join('');
    } else {
        addedPassengersSection.style.display = 'none';
    }
}

function removePassenger(index) {
    if (confirm('Are you sure you want to remove this passenger?')) {
        window.passengerDetails.splice(index, 1);
        updatePassengersDisplay();
    }
}

// Modified form submit handler
document.getElementById('passenger-form').addEventListener('submit', async function(event) {
    event.preventDefault();

    // if (window.passengerDetails.length === 0) {
    //     alert('Please add at least one passenger');
    //     return;
    // }

    await checkBalance();
});
        function fetchBookingDetails() {
            const urlParams = new URLSearchParams(window.location.search);
            const traceId = urlParams.get('traceId');
            const resultIndex = urlParams.get('resultIndex');
            const hotelCode = urlParams.get('hotelCode');
            const hotelName = decodeURIComponent(urlParams.get('hotelName') || '');
            const roomDetails = JSON.parse(decodeURIComponent(urlParams.get('roomDetails') || '{}'));

            return { traceId, resultIndex, hotelCode, hotelName, roomDetails };
        }

        function populateBookingPage() {
            const bookingDetails = fetchBookingDetails();
            const bookingContainer = document.getElementById('booking-container');

            if (!bookingDetails.roomDetails) {
                bookingContainer.innerHTML = '<div class="error">Room details not found.</div>';
                return;
            }

            const {
                RoomTypeName,
                RoomTypeCode,
                RatePlan,
                RatePlanCode,
                RoomImages,
                BedTypes,
                Amenities,
                CancellationPolicies,
                OfferedPrice,
                PublishedPrice,
                Currency
            } = bookingDetails.roomDetails;

            bookingContainer.innerHTML = `
                <div class="hotel-details">
                    <h2 class="hotel-name">${bookingDetails.hotelName}</h2>
                    <p class="hotel-code">Hotel Code: ${bookingDetails.hotelCode}</p>
                </div>

                <div class="room-details">
                    <h3 class="room-type">${RoomTypeName}</h3>
                    <p class="rate-plan">Rate Plan: ${RatePlan}</p>
                    <p class="price">
                        <strong>Price: ${Currency} ${OfferedPrice}</strong>
                        ${PublishedPrice !== OfferedPrice ? `<span class="original-price">${Currency} ${PublishedPrice}</span>` : ''}
                    </p>
                </div>

                <div class="room-images">
                    <h4>Room Images</h4>
                    <div class="image-gallery">
                        ${RoomImages.map(image => `<img src="${image.Image}" alt="${RoomTypeName}" class="room-image">`).join('')}
                    </div>
                </div>

                <div class="bed-types">
                    <h4>Bed Types</h4>
                    <p>${BedTypes || 'N/A'}</p>
                </div>

                <div class="amenities">
                    <h4>Amenities</h4>
                    <ul>
                        ${Amenities.map(amenity => `<li>${amenity.Name}</li>`).join('')}
                    </ul>
                </div>

                <div class="cancellation-policies">
                    <h4>Cancellation Policies</h4>
                    ${CancellationPolicies.map(policy => `
                        <div class="policy-item">
                            <p><strong>From:</strong> ${policy.FromDate.split('T')[0]}</p>
                            <p><strong>To:</strong> ${policy.ToDate.split('T')[0]}</p>
                            <p><strong>Charge:</strong> ${policy.Charge > 0 ? `${Currency} ${policy.Charge}` : 'Free Cancellation'}</p>
                        </div>
                    `).join('')}
                </div>

                <div class="confirm-booking">
                    <button class="book-now-button" onclick="confirmBooking()">Confirm Booking</button>
                </div>
            `;
        }

        function showPassengerModal() {
            const modal = document.getElementById('passenger-modal');
            modal.style.display = 'block';
        }

        function closeModal() {
            const modal = document.getElementById('passenger-modal');
            modal.style.display = 'none';
        }

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
                        const passengerDetails = Array.isArray(window.passengerDetails) ? 
                        window.passengerDetails : [window.passengerDetails];

                        const childCount = document.getElementById('child-count')?.value || 0;

                        const roomDetailsWithChildCount = {
                    RoomTypeName: bookingDetails.roomDetails.RoomTypeName,
                    RoomId: bookingDetails.roomDetails.RoomId,
                    RoomIndex: bookingDetails.roomDetails.RoomIndex,
                    RoomTypeCode: bookingDetails.roomDetails.RoomTypeCode,
                    RatePlan: bookingDetails.roomDetails.RatePlan,
                    RatePlanCode: bookingDetails.roomDetails.RatePlanCode,
                    OfferedPrice: bookingDetails.roomDetails.OfferedPrice,
                    Currency: bookingDetails.roomDetails.Currency,
                    childCount // Include child count in roomDetails
                };

                const paymentParams = new URLSearchParams({
                    traceId: bookingDetails.traceId,
                    resultIndex: bookingDetails.resultIndex,
                    hotelCode: bookingDetails.hotelCode,
                    hotelName: bookingDetails.hotelName,
                    roomDetails: JSON.stringify(roomDetailsWithChildCount),
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

        document.getElementById('passenger-form').addEventListener('submit', async function(event) {
            event.preventDefault();

            const formData = new FormData(event.target);
            const passengerData = {
                title: formData.get('Title'),
                firstName: formData.get('FirstName'),
                lastName: formData.get('LastName'),
                email: formData.get('Email'),
                phone: formData.get('Phoneno'),
                paxType: formData.get('PaxType'),
                leadPassenger: formData.get('LeadPassenger') === 'on',
                pan: formData.get('PAN')
            };

            window.passengerDetails = window.passengerDetails || [];
            window.passengerDetails.push(passengerData);

            closeModal();

            await checkBalance();
        });

        function confirmBooking() {
            showPassengerModal();
        }

        document.addEventListener('DOMContentLoaded', populateBookingPage);
    </script>

    <style>
        /* Global Styles */
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            color: #333;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
        }

        #booking-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 25px;
            background-color: #fff;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* Header Styles */
        .hotel-name {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .hotel-code {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 15px;
        }

        /* Room Details */
        .room-type {
            font-size: 22px;
            font-weight: bold;
            color: #34495e;
            margin-bottom: 10px;
        }

        .rate-plan {
            font-size: 16px;
            color: #7f8c8d;
            margin-bottom: 20px;
        }

        .price {
            font-size: 20px;
            color: #27ae60;
            margin-bottom: 15px;
        }

        .original-price {
            font-size: 16px;
            color: #e74c3c;
            text-decoration: line-through;
            margin-left: 10px;
        }

        /* Room Images */
        .room-images {
            margin-top: 20px;
        }

        .room-images h4 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .image-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .room-image {
            width: calc(33.33% - 10px);
            height: 120px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .room-image:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Bed Types and Amenities */
        .amenities ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .amenities ul li {
            background-color: #ecf0f1;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 14px;
            color: #2c3e50;
        }

        /* Cancellation Policies */
        .cancellation-policies {
            margin-top: 30px;
        }

        .policy-item {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9fafb;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .policy-item p {
            margin: 5px 0;
        }

        /* Confirm Booking Button */
        .confirm-booking {
            text-align: center;
            margin-top: 30px;
        }

        .book-now-button {
            background-color: #2980b9;
            color: #fff;
            padding: 15px 30px;
            border: none;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .book-now-button:hover {
            background-color: #3498db;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            width: 500px;
            max-width: 100%;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            margin-top: 15px;
        }

        .close-button {
            background: none;
            border: none;
            font-size: 24px;
            color: #333;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: 600;
            display: block;
        }

        .form-group input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .form-actions {
            text-align: center;
            margin-top: 20px;
        }

        .submit-btn {
            background-color: #27ae60;
            color: #fff;
            padding: 12px 25px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modal-content {
    position: relative;
    background-color: #fff;
    margin: 20px auto;
    padding: 20px;
    width: 90%;
    max-width: 600px;
    border-radius: 8px;
    max-height: 90vh;
    overflow-y: auto;
}

.added-passengers-section {
    margin-bottom: 20px;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 8px;
}

.passenger-card {
    background-color: white;
    padding: 15px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 6px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.passenger-info {
    flex-grow: 1;
}

.lead-badge {
    display: inline-block;
    background-color: #28a745;
    color: white;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 12px;
    margin-top: 5px;
}

.remove-btn {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 600;
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 20px;
}

.add-passenger-btn, .submit-btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.add-passenger-btn {
    background-color: #007bff;
    color: white;
}

.submit-btn {
    background-color: #28a745;
    color: white;
}

        .checkbox-group {
            display: flex;
            align-items: center;
        }

        .checkbox-group input {
            margin-left: 10px;
        }
    </style>
</body>
</html>
