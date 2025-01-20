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
    <select id="child-count" name="ChildCount" required
        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; background-color: white;">
        <option value="0" selected>No Children</option>
        <option value="1">1 Child</option>
        <option value="2">2 Children</option>
    </select>
</div>
<input type="text" name="PAN" id="pan" placeholder="PAN Number" required 
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
    const form = document.getElementById('passenger-form');
    const formData = new FormData(form);
    
    // Validate all fields
    const validation = validateFormFields(formData);
    if (!validation.isValid) {
        alert(validation.message);
        return false;
    }
    
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

    // Add to global array
    window.passengerDetails = window.passengerDetails || [];
    window.passengerDetails.push(passengerData);

    // Update display
    updatePassengersDisplay();
    
    // Save child count before reset
    const childCount = form.querySelector('#child-count').value;
    form.reset();
    form.querySelector('#child-count').value = childCount;

    alert('Passenger added successfully!');
    return true;
}

// PAN input event listener for real-time validation
document.getElementById('pan').addEventListener('input', function(e) {
    const panInput = e.target;
    let value = panInput.value.toUpperCase();
    
    // Remove any non-alphanumeric characters
    value = value.replace(/[^A-Z0-9]/g, '');
    
    // Limit to 10 characters
    value = value.substring(0, 10);
    
    // Update input value
    panInput.value = value;
    
    // Real-time validation feedback
    const validation = validatePANFormat(value);
    panInput.setCustomValidity(validation.message);
    panInput.reportValidity();
});

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
function validatePANFormat(pan) {
    if (!pan || pan.trim() === '') {
        return { 
            isValid: false, 
            message: 'PAN number is required' 
        };
    }
    
    pan = pan.trim().toUpperCase();
    
    if (pan.length !== 10) {
        return { 
            isValid: false, 
            message: 'PAN number must be exactly 10 characters long' 
        };
    }

    const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
    if (!panRegex.test(pan)) {
        return { 
            isValid: false, 
            message: 'Invalid PAN format. Format should be: AAAPL1234A (5 letters, 4 numbers, 1 letter)' 
        };
    }

    return { isValid: true, message: '' };
}

// Function to validate all form fields
function validateFormFields(formData) {
    // Validate required fields
    const requiredFields = ['Title', 'FirstName', 'LastName', 'Email', 'Phoneno', 'PaxType', 'PAN'];
    for (const field of requiredFields) {
        const value = formData.get(field);
        if (!value || value.trim() === '') {
            return {
                isValid: false,
                message: `${field.replace(/([A-Z])/g, ' $1').trim()} is required`
            };
        }
    }

    // Validate PAN
    const panValidation = validatePANFormat(formData.get('PAN'));
    if (!panValidation.isValid) {
        return panValidation;
    }

    // Validate email
    const email = formData.get('Email');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        return {
            isValid: false,
            message: 'Please enter a valid email address'
        };
    }

    // Validate phone (Indian format)
    const phone = formData.get('Phoneno');
    if (!/^[6-9]\d{9}$/.test(phone)) {
        return {
            isValid: false,
            message: 'Please enter a valid 10-digit phone number'
        };
    }

    return { isValid: true, message: '' };
}
//submit button handler
document.getElementById('passenger-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    
    // Only proceed if addNewPassengerForm validation passes
    if (addNewPassengerForm()) {
        closeModal();
        try {
            await checkBalance();
        } catch (error) {
            console.error('Error checking balance:', error);
            // Remove the last added passenger if balance check fails
            if (window.passengerDetails && window.passengerDetails.length > 0) {
                window.passengerDetails.pop();
                updatePassengersDisplay();
            }
        }
    }
});

// Add this to handle real-time PAN input formatting
document.getElementById('pan').addEventListener('input', function(e) {
    const panInput = e.target;
    panInput.value = panInput.value.toUpperCase();
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

 
</body>
</html>
