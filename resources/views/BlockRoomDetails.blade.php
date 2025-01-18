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
    <div id="passenger-modal" style="display: none; position: fixed; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 1000; overflow: auto;">
    <div style="position: relative; background-color: #fefefe; margin: 15px auto; padding: 20px; width: 90%; max-width: 600px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <button onclick="closeModal()" style="position: absolute; right: 15px; top: 15px; background: none; border: none; font-size: 24px; cursor: pointer; color: #666;">&times;</button>
        
        <h2 style="color: #333; margin-bottom: 20px; font-size: 24px; text-align: center;">Passenger Details</h2>
        
        <div id="passengers-container">
            <form id="passenger-form" style="display: flex; flex-direction: column; gap: 15px;">
                <div style="display: flex; flex-wrap: wrap; gap: 15px;">
                    <select name="Title" required style="flex: 0 0 100px; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background-color: white;">
                        <option value="">Title</option>
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Ms">Ms</option>
                    </select>
                    
                    <input type="text" name="FirstName" placeholder="First Name" required 
                        style="flex: 1; min-width: 200px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                    
                    <input type="text" name="LastName" placeholder="Last Name" required 
                        style="flex: 1; min-width: 200px; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                </div>

                <input type="email" name="Email" placeholder="Email Address" required 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">

                <input type="tel" name="Phoneno" placeholder="Phone Number" required 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">

                <select name="PaxType" required 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background-color: white;">
                    <option value="">Select Passenger Type</option>
                    <option value="Adult">Adult</option>
                    <option value="Child">Child</option>
                </select>
                <div style="width: 100%; padding: 10px 0;">
                    <label for="child-count" style="display: block; margin-bottom: 5px; color: #444; font-size: 14px;">Number of Children:</label>
                    <select id="child-count" name="ChildCount" 
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background-color: white;">
                        <option value="0">No Children</option>
                        <option value="1">1 Child</option>
                        <option value="2">2 Children</option>
                    </select>
                </div>
                <input type="text" name="PAN" placeholder="PAN Number" 
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">

                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="checkbox" name="LeadPassenger" id="lead-passenger" 
                        style="width: 18px; height: 18px;">
                    <label for="lead-passenger" style="color: #444; font-size: 14px;">Lead Passenger</label>
                </div>

                <!-- Buttons container -->
                <div style="display: flex; gap: 15px; margin-top: 10px;">
                    <button type="button" onclick="addNewPassengerForm()" 
                        style="flex: 1; padding: 12px; background-color: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; transition: background-color 0.3s;">
                        Add Passenger
                    </button>

                    <button type="submit" 
                        style="flex: 1; padding: 12px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; transition: background-color 0.3s;">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
    <script>

window.passengerDetails = [];
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
        leadPassenger: formData.get('LeadPassenger') === 'on'
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

    // Add to global array
    window.passengerDetails.push(passengerData);

    // Update display
    updatePassengersDisplay();

    // Reset form
    document.getElementById('passenger-form').reset();

    // Show success message
    alert('Passenger added successfully!');
}

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
    if (window.passengerDetails.length > 0) {
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

function removePassenger(index) {
    if (confirm('Are you sure you want to remove this passenger?')) {
        window.passengerDetails.splice(index, 1);
        updatePassengersDisplay();
    }
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// Update the form submit handler
document.getElementById('passenger-form').addEventListener('submit', function(event) {
    event.preventDefault();
    addNewPassengerForm();
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
        bookingContainer.innerHTML = `
            <div style="background-color: #fff3f3; color: #dc3545; padding: 20px; border-radius: 8px; text-align: center; font-family: Arial, sans-serif; margin: 20px;">
                <i style="font-size: 24px; margin-bottom: 10px;">⚠️</i>
                <div style="font-size: 18px;">Room details not found.</div>
            </div>`;
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

    const discount = PublishedPrice !== OfferedPrice 
        ? Math.round(((PublishedPrice - OfferedPrice) / PublishedPrice) * 100)
        : 0;

    // Add responsive breakpoint checks
    const getResponsiveStyles = () => {
        const width = window.innerWidth;
        return {
            mainGrid: width > 768 ? 'grid-template-columns: 60% 40%' : 'grid-template-columns: 100%',
            padding: width > 768 ? '20px' : '10px',
            fontSize: {
                header: width > 768 ? '28px' : '24px',
                subheader: width > 768 ? '20px' : '18px',
                normal: width > 768 ? '16px' : '14px',
                price: width > 768 ? '32px' : '28px'
            },
            imageHeight: width > 768 ? '400px' : '300px'
        };
    };

    const styles = getResponsiveStyles();

    bookingContainer.innerHTML = `
        <div style="max-width: 1200px; margin: 0 auto; padding: ${styles.padding}; font-family: 'Arial', sans-serif; color: #333; background-color: #fff; box-shadow: 0 0 20px rgba(0,0,0,0.1); border-radius: 12px; width: 100%; box-sizing: border-box;">
            <!-- Header Section -->
            <div style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 20px; border-radius: 10px; color: white; margin-bottom: 20px;">
                <h2 style="margin: 0; font-size: ${styles.fontSize.header}; font-weight: 600; word-wrap: break-word;">${bookingDetails.hotelName}</h2>
            </div>

            <!-- Main Content Grid -->
            <div style="display: grid; ${styles.mainGrid}; gap: 20px;">
                <!-- Left Column -->
                <div>
                    <!-- Room Images Carousel -->
                    <div style="margin-bottom: 20px; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <div style="position: relative; height: ${styles.imageHeight}; overflow: hidden;">
                            ${RoomImages.map((image, index) => `
                                <img src="${image.Image}" 
                                     alt="${RoomTypeName}" 
                                     style="width: 100%; height: ${styles.imageHeight}; object-fit: cover; display: ${index === 0 ? 'block' : 'none'};"
                                     onclick="cycleImages(this)"
                                >
                            `).join('')}
                        </div>
                        
                    </div>

                    <!-- Amenities Section -->
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                        <h4 style="margin: 0 0 15px 0; font-size: ${styles.fontSize.subheader}; color: #1e3c72;">Room Amenities</h4>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px;">
                            ${Amenities.map(amenity => `
                                <div style="display: flex; align-items: center; background: white; padding: 10px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); font-size: ${styles.fontSize.normal};">
                                    <span style="margin-right: 8px;">✓</span>
                                    ${amenity.Name}
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; height: fit-content;">
                    <!-- Price Card -->
                    <div style="background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <h3 style="margin: 0 0 15px 0; font-size: ${styles.fontSize.subheader}; color: #1e3c72;">${RoomTypeName}</h3>
                        <div style="margin-bottom: 20px;">
                            <div style="font-size: ${styles.fontSize.price}; font-weight: bold; color: #1e3c72; margin-bottom: 5px;">
                                ${Currency} ${OfferedPrice.toLocaleString()}
                            </div>
                            ${PublishedPrice !== OfferedPrice ? `
                                <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                    <span style="text-decoration: line-through; color: #666; font-size: ${styles.fontSize.normal};">
                                        ${Currency} ${PublishedPrice.toLocaleString()}
                                    </span>
                                    <span style="background: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: ${styles.fontSize.normal};">
                                        ${discount}% OFF
                                    </span>
                                </div>
                            ` : ''}
                        </div>
                        
                        <!-- Original confirm booking button structure preserved -->
                        <div class="confirm-booking">
                            <button class="book-now-button" onclick="confirmBooking()" 
                                    style="width: 100%; padding: 15px; background: #1e3c72; color: white; border: none; border-radius: 8px; font-size: ${styles.fontSize.normal}; cursor: pointer;">
                                Confirm Booking
                            </button>
                        </div>
                    </div>

                    <!-- Bed Types -->
                    <div style="background: white; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                        <h4 style="margin: 0 0 10px 0; font-size: ${styles.fontSize.subheader}; color: #1e3c72;">Bed Configuration</h4>
                        <p style="margin: 0; color: #666; font-size: ${styles.fontSize.normal};">${BedTypes || 'N/A'}</p>
                    </div>

                    <!-- Cancellation Policies -->
                    <div style="background: white; padding: 15px; border-radius: 10px;">
                        <h4 style="margin: 0 0 15px 0; font-size: ${styles.fontSize.subheader}; color: #1e3c72;">Cancellation Policy</h4>
                        ${CancellationPolicies.map(policy => `
                            <div style="padding: 15px; background: #f8f9fa; border-radius: 8px; margin-bottom: 10px;">
                                <div style="display: flex; flex-wrap: wrap; justify-content: space-between; gap: 10px; margin-bottom: 10px;">
                                    <span style="color: #666; font-size: ${styles.fontSize.normal};">From: ${policy.FromDate.split('T')[0]}</span>
                                    <span style="color: #666; font-size: ${styles.fontSize.normal};">To: ${policy.ToDate.split('T')[0]}</span>
                                </div>
                                <div style="color: ${policy.Charge > 0 ? '#dc3545' : '#28a745'}; font-weight: 600; font-size: ${styles.fontSize.normal};">
                                    ${policy.Charge > 0 ? `Charge: ${Currency} ${policy.Charge}` : 'Free Cancellation'}
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
            </div>
        </div>
    `;
}

// Image carousel functionality
function cycleImages(clickedImage) {
    const images = clickedImage.parentElement.getElementsByTagName('img');
    let nextIndex = 0;
    
    for (let i = 0; i < images.length; i++) {
        if (images[i].style.display === 'block') {
            images[i].style.display = 'none';
            nextIndex = (i + 1) % images.length;
            break;
        }
    }
    
    images[nextIndex].style.display = 'block';
}

// Add window resize listener to update styles
window.addEventListener('resize', () => {
    populateBookingPage();
});


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
