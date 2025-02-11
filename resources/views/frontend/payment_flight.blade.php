<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Payment Form</title>
    <style>
* { margin: 0; padding: 0; box-sizing: border-box; }

.container { 
    display: flex; justify-content: center; align-items: center; min-height: 100vh; 
    padding: 20px; background: url("{{ asset('assets/images/bg.webp') }}") no-repeat center/cover; 
}

form { 
    padding: 30px; 
    max-width: 600px; 
    width: 100%; 
    background: #fff; 
    border-radius: 10px; 
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    position: relative; 
    z-index: 1; 
}

.alert { display: none; padding: 10px; margin-bottom: 10px; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; color: #721c24; font-weight: bold; }

.payment-methods { display: flex; justify-content: center; margin-bottom: 20px; gap: 20px; }
.payment-methods label { flex: 1; text-align: center; padding: 10px 20px; background: #f4f4f4; border: 1px solid #ccc; border-radius: 5px; cursor: pointer; transition: background 0.3s ease; width: 120px; }
.payment-methods label:hover { background: #e9ecef; }
.payment-methods input[type="radio"] { display: none; }
.payment-methods input[type="radio"]:checked + label { background: #27ae60; color: #fff; border: 1px solid #1e8449; }

.payment-option { display: none; margin-top: 20px; }
.payment-option.active { display: block; }

.card-option .input-group { margin-bottom: 15px; }
.card-option .input-group label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
.card-option .input-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; }

.upi-option, .qr-option { text-align: center; }
.upi-option h4, .qr-option h4 { margin-bottom: 10px; }
.upi-option p, .qr-option p { margin-top: 10px; }

.upi-option img, .qr-option img { display: block; margin: 20px auto; width: 50%; height: auto; border: 3px solid #27ae60; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); }

.submit-btn-container { display: flex; justify-content: center; gap: 10px; }
.submit-btn { padding: 12px; font-size: 17px; background: #27ae60; color: #fff; border-radius: 5px; cursor: pointer; text-align: center; border: none; transition: background 0.3s ease; width: 100px; }
.submit-btn:hover { background: #2ecc71; }

@media (max-width: 768px) {
    .payment-methods { flex-direction: column; gap: 10px; }
    .payment-methods label { width: 100%; }
    
    form { max-width: 90%; padding-top: 100px; }  /* Increased padding-top to create space for contact-info */
    
    .contact-info { 
        position: relative;  /* Ensure contact-info is not fixed */
        margin-top: 20px;  /* Add margin to the top */
        padding: 8px 15px; 
        gap: 10px;
        justify-content: center;
        flex-direction: column; /* Stack the contact items vertically */
    }
    .contact-info a { font-size: 14px; text-align: center; }
    .contact-info a i { font-size: 18px; }
}

.contact-info { 
    display: flex; justify-content: center; align-items: center; gap: 20px; 
    position: fixed; 
    top: 10px; /* Fixed at the top for larger screens */
    left: 50%;
    transform: translateX(-50%);
    background-color: #fff; 
    padding: 10px 20px; 
    border-radius: 5px; 
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); 
    z-index: 1000; /* Ensure it stays on top */
}

.contact-info a { 
    text-decoration: none; 
    color: #555; 
    font-size: 16px; 
    display: flex; 
    align-items: center; 
    gap: 8px; 
    font-weight: bold; 
}

.contact-info a:hover { 
    color: #27ae60; 
}

.contact-info a i { 
    font-size: 20px; 
}
 /* Modal styles */
 .modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        /* Modal form fields */
        .modal form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .modal input[type="text"], .modal input[type="email"], .modal input[type="number"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
        }

        .modal button[type="submit"] {
            padding: 12px;
            background: #27ae60;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            border: none;
        }

        .modal button[type="submit"]:hover {
            background: #2ecc71;
        }
</style>

<script>
    const apiConfig = {!! json_encode([
        'client_id' => config('api.client_id'),
        'username' => config('api.username'),
        'password' => config('api.password'),
    ]) !!};
</script>
     <!-- Add Font Awesome for Icons -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <form id="payment-form">
            <!-- Move the alert inside the form -->
            <div id="credit-card-alert" class="alert">
            Credit card payments are temporarily unavailable. Please 
            <button id="showFormButton" class="btn btn-link p-0 m-0" style="text-decoration: underline; border: none; background: none; padding: 0; color: #ff0000; cursor: pointer;">click here</button>
            </div>

            <h3 style="text-align: center; margin-bottom: 20px;">Select Payment Method</h3>
            <div class="payment-methods">
                <input type="radio" id="card" name="payment-method" value="card" onclick="togglePaymentOption('card')">
                <label for="card">Credit Card</label>

                <input type="radio" id="qr" name="payment-method" value="qr" checked onclick="togglePaymentOption('qr')">
                <label for="qr">QR Code</label>

                <input type="radio" id="upi" name="payment-method" value="upi" onclick="togglePaymentOption('upi')">
                <label for="upi">UPI</label>
            </div>

            <div class="payment-option card-option" id="card-option">
                <div class="input-group">
                    <label>Name on Card:</label>
                    <input type="text" id="name-on-card" placeholder="MMBY" required>
                </div>
                <div class="input-group">
                    <label>Credit Card Number:</label>
                    <input type="text" id="card-number" placeholder="1111-2222-3333-4444" required>
                </div>
                <div class="input-group">
                    <label>Expiration Date:</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" id="exp-month" placeholder="MM" style="flex: 1;" required>
                        <input type="text" id="exp-year" placeholder="YYYY" style="flex: 1;" required>
                    </div>
                </div>
                <div class="input-group">
                    <label>CVV:</label>
                    <input type="text" id="cvv" placeholder="123" required>
                </div>
                <div class="submit-btn-container">
                <div id="balanceResult" class="balance-result-container"></div>
    
                <a href="#" id="payNowButton" class="submit-btn">Pay Now</a>
                </div>
                <div class="submit-btn-container">
    <button type="button" id="cancelBookingButton" class="submit-btn">Cancel Booking</button>
</div>
            </div>

            <div class="payment-option qr-option active" id="qr-option">
                <h4 style="text-align: center;">Scan the QR Code</h4>
                <img src="{{ asset('assets/images/qr.jpeg')}}" alt="QR Code">
                <p style="text-align: center;">Use any payment app to scan and pay.</p>
            </div>

            <div class="payment-option upi-option" id="upi-option">
                <h4 style="text-align: center;">Pay via UPI</h4>
                <p style="text-align: center;">Use your UPI app to make the payment.</p>
                <img src="{{ asset('assets/images/upi.jpeg')}}" alt="UPI ID">
            </div>
        </form>
    </div>

    <!-- Contact Information with Icons -->
    <div class="contact-info">
        <a href="mailto:support@example.com">
            <i class="fas fa-envelope"></i> info@makemybharatyatra.com 
        </a>
        <a href="tel:+1234567890">
            <i class="fas fa-phone-alt"></i> +91 1204223100
        </a>
    </div>

    <!-- Modal with form -->
    <div id="payment-modal" class="modal">
        <div class="modal-content">
            <span id="closeModal" class="close">&times;</span>
            <h4>Fill the Details Below</h4>
            <form id="modal-form" method="POST" action="{{ route('cardpay.store') }}">
            @csrf
                <input type="text" id="modal-name" placeholder="Your Name" required>
                <input type="email" id="modal-email" placeholder="Your Email" required>
                <input type="text" id="modal-mobile" placeholder="Your Mobile No." required>
                <input type="number" id="modal-amount" placeholder="Payment Amount" required>
                <button type="submit">Submit</button>
            </form>
        </div>
        <div id="bookingResult"></div>
    </div>

    <script>
        // Function to toggle payment method visibility

        function togglePaymentOption(option) {
            document.getElementById("credit-card-alert").style.display = option === 'card' ? "block" : "none";
            document.querySelectorAll('.payment-option').forEach((element) => {
                element.classList.remove('active');
            });
            const selectedOption = document.getElementById(`${option}-option`);
            if (selectedOption) {
                selectedOption.classList.add('active');
            }
        }

        // Handle modal functionality
        const showFormButton = document.getElementById("showFormButton");
        const modal = document.getElementById("payment-modal");
        const closeModal = document.getElementById("closeModal");

        showFormButton.onclick = function() {
            modal.style.display = "flex";
        }

        closeModal.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }
        document.getElementById("modal-form").addEventListener("submit", function(event) {
    event.preventDefault();  // Prevent the form from submitting normally

    

    // Collect modal form values
    const name = document.getElementById("modal-name").value.trim();
    const email = document.getElementById("modal-email").value.trim();
    const mobile = document.getElementById("modal-mobile").value.trim();
    const amount = document.getElementById("modal-amount").value.trim();

    // Validate fields
    if (!name || !email || !mobile || !amount) {
        alert("Please fill in all the required fields.");
        return;
    }

    // Create FormData to send to server
    const formData = new FormData();
    formData.append('name', name);
    formData.append('email', email);
    formData.append('mobile_no', mobile);
    formData.append('total_amount', amount);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);  // CSRF token

    // Send data via AJAX (using fetch API)
    fetch("{{ route('cardpay.store') }}", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Payment details saved successfully!");
            modal.style.display = "none";  // Close the modal
            // You can also reset the form or do additional actions here
        } else {
            alert("An error occurred. Please try again.");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("There was an error with the submission. Please try again.");
    });
});


document.getElementById("payNowButton").addEventListener("click", function (event) {
    event.preventDefault();

    // Extract URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('TraceId');
    const amount = urlParams.get("amount");
    const passengerDataStr = urlParams.get('PassengerData');
    const resultIndex = urlParams.get('ResultIndex');
    
    if (!traceId || !amount || !passengerDataStr) {
        // alert("Missing required parameters!");
        return;
    }

    // Parse the passenger data
    let passengerData;
    try {
        passengerData = JSON.parse(decodeURIComponent(passengerDataStr));
    } catch (e) {
        console.error("Error parsing passenger data:", e);
        alert("Invalid passenger data format");
        return;
    }

    // First call the balance log API
    fetch(`/balance-log?TraceId=${traceId}&amount=${amount}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const balanceLog = data.balanceLogs[0];
            
            if (balanceLog) {
                // After successful balance log, prepare booking request
                const bookingData = {
                    ResultIndex: resultIndex, // Replace with actual value
                    TraceId: traceId,
                    BoardingPointId: 1, // Replace with actual value
                    DroppingPointId: 1, // Replace with actual value
                    RefID: "1",
                    Passenger: [{
                        LeadPassenger: true,
                        PassengerId: 0,
                        Title: passengerData.Title,
                        FirstName: passengerData.FirstName,
                        LastName: passengerData.LastName,
                        Email: passengerData.Email,
                        Phoneno: passengerData.Phoneno,
                        Gender: passengerData.Gender,
                        IdType: null,
                        IdNumber: null,
                        Address: passengerData.Address,
                        Age: passengerData.Age,
                        Seat: passengerData.SeatDetails || passengerData.Seat
                    }]
                };

                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                // Make the booking API call
                return fetch('/bookbus', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(bookingData)
                });
            } else {
                throw new Error("No balance log found");
            }
        } else {
            throw new Error(data.errorMessage || "Balance log failed");
        }
    })
    .then(response => response.json())
    .then(bookingResult => {
        if (bookingResult.status === 'success') {
            alert(`Booking Successful!\nTicket Number: ${bookingResult.data.TicketNo}\nStatus: ${bookingResult.data.BusBookingStatus}`);
        } else {
            alert(`Booking Failed: ${bookingResult.message}`);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred: " + error.message);
    });
});

  
    // Replace the existing cancel booking event listener with this
document.getElementById("cancelBookingButton").addEventListener("click", function (event) {
    event.preventDefault();

    // Get TraceId and passenger data from URL
    const urlParams = new URLSearchParams(window.location.search);
    const passengerDataStr = urlParams.get('PassengerData');
    
    if (!passengerDataStr) {
        alert("Missing passenger data!");
        return;
    }

    // Parse the passenger data
    let passengerData;
    try {
        passengerData = JSON.parse(decodeURIComponent(passengerDataStr));
    } catch (e) {
        console.error("Error parsing passenger data:", e);
        alert("Invalid passenger data format");
        return;
    }

    // Extract BusId and SeatId from passenger data
    const busId = String(passengerData.Seat?.SeatIndex || passengerData.SeatDetails?.SeatIndex);
    const seatId = passengerData.Seat?.SeatName || passengerData.SeatDetails?.SeatName;
    console.log(typeof busId, busId);

    if (!busId || !seatId) {
        alert("Required booking information not found!");
        return;
    }

    // Show confirmation dialog
    if (!confirm("Are you sure you want to cancel this booking?")) {
        return;
    }

    // Prepare payload for cancel API
    const payload = {
        "EndUserIp": "1.1.1.1", // You might want to get actual IP
        ClientId: apiConfig.client_id, // Use embedded config values
    UserName: apiConfig.username,
    Password: apiConfig.password,
        'BusId': "11836",
        'SeatId': seatId,
        'Remarks': "User requested cancellation"
    };

    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Make the cancel API call
    fetch("/cancelBus", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify(payload)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status === 'success') {
            alert("Booking cancelled successfully!");
            // Optionally redirect to a different page
            // window.location.href = '/booking-history';
        } else {
            alert("Failed to cancel booking: " + (data.message || "Unknown error"));
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An error occurred while canceling the booking. Please try again later.");
    });
});





//HOTEL RELATED FUNCTION 

function getUrlParameters() {
    const urlParams = new URLSearchParams(window.location.search);

    // Parse room details JSON
    const roomDetailsStr = urlParams.get('roomDetails');
    console.log("Raw room details string:", roomDetailsStr);
    const roomDetails = roomDetailsStr ? JSON.parse(decodeURIComponent(roomDetailsStr)) : null;
    console.log("Room Details:", roomDetails);
    console.log("Room Childcount:", roomDetails.childCount);

    // Parse passenger details JSON with detailed logging
    const passengerDetailsStr = urlParams.get('passengerDetails');
    console.log("Raw passenger details string:", passengerDetailsStr);

    let passengerDetails = [];
    
    try {
        // First decode the URI component
        const decodedStr = decodeURIComponent(passengerDetailsStr);
        console.log("Decoded passenger details string:", decodedStr);
        
        // Then parse the JSON
        const parsedData = JSON.parse(decodedStr);
        console.log("Parsed passenger data type:", typeof parsedData);
        console.log("Is Array?", Array.isArray(parsedData));
        
        // Handle both array and single object cases
        if (Array.isArray(parsedData)) {
            passengerDetails = parsedData;
            console.log("Passenger details is already an array:", passengerDetails);
        } else if (typeof parsedData === 'object' && parsedData !== null) {
            passengerDetails = [parsedData];
            console.log("Converted single object to array:", passengerDetails);
        } else {
            console.error("Invalid passenger data format:", parsedData);
            passengerDetails = [];
        }

        // Validate array contents
        console.log("Final passenger details array length:", passengerDetails.length);
        passengerDetails.forEach((passenger, index) => {
            console.log(`Passenger ${index + 1}:`, passenger);
        });

    } catch (error) {
        console.error("Error parsing passenger details:", error);
        console.log("Defaulting to empty array");
        passengerDetails = [];
    }

    // Final validation
    if (!Array.isArray(passengerDetails)) {
        console.error("Final check - Passenger details is not an array!");
        alert("Error: Passenger details are not in the expected format.");
        passengerDetails = [];
    }

    const result = {
        hotelDetails: {
            traceId: urlParams.get('traceId'),
            resultIndex: urlParams.get('resultIndex'),
            hotelCode: urlParams.get('hotelCode'),
            hotelName: urlParams.get('hotelName')
        },
        roomDetails: roomDetails,
        passengerDetails: passengerDetails
    };

    console.log("Final returned object:", result);
    return result;
}
async function processHotelBooking(bookingData) {
    try {
        // Prepare balance payload
        const balancePayload = {
            EndUserIp: "1.1.1.1",
            ClientId: "180133",
            UserName: "MakeMy91",
            Password: "MakeMy@910",
            amount: parseFloat(bookingData.roomDetails.OfferedPrice),
            TraceId: bookingData.hotelDetails.traceId,
            bookingDetails: {
                hotelName: bookingData.hotelDetails.hotelName,
                roomType: bookingData.roomDetails.RoomTypeName
            }
        };

        console.log("Balance Payload:", balancePayload);

        // Call Balance API
        const balanceResponse = await fetch('/balancelog', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(balancePayload),
        });

        const balanceData = await balanceResponse.json();
        console.log("Balance Data:", balanceData);

        if (!balanceData.success) {
            throw new Error(balanceData.errorMessage || 'Insufficient balance or payment failed.');
        }

        const hotelPassengers = bookingData.passengerDetails.map(passenger => ({
            Title: passenger.title,
            ChildCount: passenger.childCount || 0,
            FirstName: passenger.firstName,
            LastName: passenger.lastName,
            Phoneno: passenger.phone,
            Email: passenger.email,
            PaxType: passenger.paxType || "1",
            LeadPassenger: passenger.leadPassenger || false,
            PAN: passenger.pan || ""
        }));

        const roomDetail = {
            RoomId: bookingData.roomDetails.RoomId,
            RoomStatus: "Active",
            RoomIndex: bookingData.roomDetails.RoomIndex,
            RoomTypeCode: bookingData.roomDetails.RoomTypeCode,
            RoomTypeName: bookingData.roomDetails.RoomTypeName,
            RatePlanCode: bookingData.roomDetails.RatePlanCode,
            RatePlan: bookingData.roomDetails.RatePlan,
            InfoSource: bookingData.roomDetails.InfoSource || "",
            SequenceNo: bookingData.roomDetails.SequenceNo || "",
            SmokingPreference: "0",
            ChildCount: bookingData.roomDetails.childCount || 0,
            RequireAllPaxDetails: false,
            HotelPassenger: hotelPassengers,
            Currency: bookingData.roomDetails.Currency,
            OfferedPrice: bookingData.roomDetails.OfferedPrice
        };

        const bookingPayload = {
            ResultIndex: bookingData.hotelDetails.resultIndex,
            HotelCode: bookingData.hotelDetails.hotelCode,
            HotelName: bookingData.hotelDetails.hotelName,
            GuestNationality: "IN",
            NoOfRooms: bookingData.roomDetails.NoOfRooms || 1,
            ClientReferenceNo: 0,
            IsVoucherBooking: true,
            HotelRoomsDetails: [roomDetail],
            SrdvType: "MixAPI",
            SrdvIndex: "15",
            TraceId: bookingData.hotelDetails.traceId,
            EndUserIp: "1.1.1.1",
            ClientId: "180133",
            UserName: "MakeMy91",
            Password: "MakeMy@910"
        };

        console.log("Hotel Booking Payload:", bookingPayload);

        // Call Booking API
        const bookingResponse = await fetch('/book-room', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(bookingPayload),
        });

        const bookingDataResponse = await bookingResponse.json();
        console.log("Booking Data Response:", bookingDataResponse);

        if (!bookingDataResponse.success) {
            throw new Error(bookingDataResponse.errorMessage || 'Booking failed after successful payment.');
        }

        const bookingDetails = bookingDataResponse.bookingDetails;

        // Show final success message
        alert(`Payment and Booking Successful!\n\n` +
              `Payment Details:\n` +
              `Debited Amount: ₹${balanceData.balanceLogs[0].Debit}\n` +
              `Updated Balance: ₹${balanceData.balanceLogs[0].Balance}\n\n` +
              `Booking Details:\n` +
              `Hotel: ${bookingDetails.HotelName || bookingPayload.HotelName}\n` +
              `Booking ID: ${bookingDetails.BookingId}\n` +
              `Confirmation No: ${bookingDetails.ConfirmationNo}\n` +
              `Status: ${bookingDetails.Status}`);
    } catch (error) {
        console.error('Error during hotel booking:', error);
        alert(`Error: ${error.message}`);
    }
}





//FLIGHT RELATED FUNCTION
function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i].trim();
        if (c.indexOf(nameEQ) === 0) {
            return c.substring(nameEQ.length);
        }
    }
    return null;
}

// Get origin and destination from cookies
const origin = getCookie('origin');
const destination = getCookie('destination');

// Log the values
console.log('ORIGIN:', origin);
console.log('DESTINATION:', destination);

      

        function getBookingDetailsFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    const encodedDetails = urlParams.get('details');

    console.log('1. Raw encoded details from URL:', encodedDetails);

    if (!encodedDetails) {
        console.error('❌ No booking details found in URL');
        return null;
    }

    try {
        const bookingDetails = JSON.parse(decodeURIComponent(encodedDetails));
        console.log('2. Decoded booking details:', bookingDetails);

        let extractedFlights = {
            lcc: {
                outbound: null,
                return: null
            },
            nonLcc: []
        };
        const farePax = bookingDetails.lcc.outbound.passengers[0]?.fare?.[0] || {};

        // Process LCC flights
        if (bookingDetails.lcc) {
            // Process outbound LCC flight
            if (bookingDetails.lcc.outbound) {
                extractedFlights.lcc.outbound = {
                    resultIndex: bookingDetails.lcc.outbound.resultIndex,
                    srdvIndex: bookingDetails.lcc.outbound.srdvIndex,
                    traceId: bookingDetails.lcc.outbound.traceId,
                    totalFare: bookingDetails.lcc.outbound.totalFare,
                    baseFare: farePax.baseFare || 0,
            tax: farePax.tax || 0,
            yqTax: farePax.yqTax || 0,
            transactionFee: farePax.transactionFee || '0',
            additionalTxnFeeOfrd: farePax.additionalTxnFeeOfrd || 0,
            additionalTxnFeePub: farePax.additionalTxnFeePub || 0,
            airTransFee: farePax.airTransFee || '0',
                    tax: bookingDetails.lcc.outbound.tax,
                    yqTax: bookingDetails.lcc.outbound.yqTax,
                    transactionFee: bookingDetails.lcc.outbound.transactionFee,
                    additionalTxnFeeOfrd: bookingDetails.lcc.outbound.additionalTxnFeeOfrd,
                    additionalTxnFeePub: bookingDetails.lcc.outbound.additionalTxnFeePub,
                    airTransFee: bookingDetails.lcc.outbound.airTransFee,
                    passengers: bookingDetails.lcc.outbound.passengers.map((pax, index) => ({
                        title: pax.title,
                        firstName: pax.firstName,
                        lastName: pax.lastName,
                        gender: pax.gender,
                        contactNo: pax.contactNo || "",
                        email: pax.email || "",
                        paxType: pax.paxType,
                        addressLine1: origin,
                        city: origin, // Using addressLine1 as city if needed
                        passportNo: pax.passportNo || "",
                        passportExpiry: pax.passportExpiry || "",
                        passportIssueDate: pax.passportIssueDate || "",
                        dateOfBirth: pax.dateOfBirth || "",
                        countryCode: "IN",
                        countryName: "INDIA",
                        selectedServices: {
                            seat: pax.selectedServices?.seat || null,
                            baggage: pax.selectedServices?.baggage || null,
                            meals: pax.selectedServices?.meals || []
                        },
                        totalSSRCost: pax.totalSSRCost || 0,
                        fare: pax.fare || []
                    }))
                };
            }

            // Process return LCC flight
            if (bookingDetails.lcc.return) {
                extractedFlights.lcc.return = {
                    resultIndex: bookingDetails.lcc.return.resultIndex,
                    srdvIndex: bookingDetails.lcc.return.srdvIndex,
                    traceId: bookingDetails.lcc.return.traceId,
                    totalFare: bookingDetails.lcc.return.totalFare,
                      // Add fare details
                      baseFare: farePax.baseFare || 0,
            tax: farePax.tax || 0,
            yqTax: farePax.yqTax || 0,
            transactionFee: farePax.transactionFee || '0',
            additionalTxnFeeOfrd: farePax.additionalTxnFeeOfrd || 0,
            additionalTxnFeePub: farePax.additionalTxnFeePub || 0,
            airTransFee: farePax.airTransFee || '0',
                    tax: bookingDetails.lcc.return.tax,
                    yqTax: bookingDetails.lcc.return.yqTax,
                    transactionFee: bookingDetails.lcc.return.transactionFee,
                    additionalTxnFeeOfrd: bookingDetails.lcc.return.additionalTxnFeeOfrd,
                    additionalTxnFeePub: bookingDetails.lcc.return.additionalTxnFeePub,
                    airTransFee: bookingDetails.lcc.return.airTransFee,
                    passengers: bookingDetails.lcc.return.passengers.map((pax, index) => ({
                        title: pax.title,
                        firstName: pax.firstName,
                        lastName: pax.lastName,
                        gender: pax.gender,
                        contactNo: pax.contactNo || "",
                        email: pax.email || "",
                        paxType: pax.paxType,
                        addressLine1:destination,
                        city: destination, // Using addressLine1 as city if needed
                        passportNo: pax.passportNo || "",
                        passportExpiry: pax.passportExpiry || "",
                        passportIssueDate: pax.passportIssueDate || "",
                        dateOfBirth: pax.dateOfBirth || "",
                        countryCode: "IN",
                        countryName: "INDIA",
                        selectedServices: {
                            seat: pax.selectedServices?.seat || null,
                            baggage: pax.selectedServices?.baggage || null,
                            meals: pax.selectedServices?.meals || []
                        },
                        totalSSRCost: pax.totalSSRCost || 0,
                        fare: pax.fare || []
                    }))
                };
            }
        }

        // Process non-LCC flights if present
        if (bookingDetails.nonLcc && bookingDetails.nonLcc.length > 0) {
            extractedFlights.nonLcc = bookingDetails.nonLcc;
        }

        // Log detailed information
        console.log('3. Extracted LCC Outbound Flight:', extractedFlights.lcc.outbound);
        console.log('4. Extracted LCC Return Flight:', extractedFlights.lcc.return);
        console.log('5. Extracted Non-LCC Flights:', extractedFlights.nonLcc);

        // Log passenger details for each flight
        if (extractedFlights.lcc.outbound) {
            extractedFlights.lcc.outbound.passengers.forEach((pax, index) => {
                console.log(`6. Outbound LCC Passenger ${index + 1}:`, {
                    basic: {
                        name: `${pax.title} ${pax.firstName} ${pax.lastName}`,
                        type: pax.paxType
                    },
                    services: pax.selectedServices,
                    ssrCost: pax.totalSSRCost
                });
            });
        }

        if (extractedFlights.lcc.return) {
            extractedFlights.lcc.return.passengers.forEach((pax, index) => {
                console.log(`7. Return LCC Passenger ${index + 1}:`, {
                    basic: {
                        name: `${pax.title} ${pax.firstName} ${pax.lastName}`,
                        type: pax.paxType
                    },
                    services: pax.selectedServices,
                    ssrCost: pax.totalSSRCost
                });
            });
        }

        return extractedFlights;
    } catch (error) {
        console.error('❌ Error parsing booking details:', error);
        return null;
    }
}
async function bookLCC() {
    const bookingDetails = getBookingDetailsFromURL();

    if (!bookingDetails || !bookingDetails.lcc) {
        console.error("❌ No valid LCC booking details found!");
        return;
    }

    console.log("🚀 Full Booking Details:", bookingDetails);

    // Function to create payload for a single flight
    const createFlightPayload = (flightDetails) => {
        if (!flightDetails || !flightDetails.passengers || !Array.isArray(flightDetails.passengers)) {
            console.error("❌ Invalid flight details!");
            return null;
        }
        const fareDetails = flightDetails.passengers[0]?.fare?.[0] || {};
        // Log fare details for debugging
        // Log fare details for debugging
    console.log("Fare details being processed:", {
        baseFare: fareDetails.baseFare,
        tax: fareDetails.tax,
        yqTax: fareDetails.yqTax,
        transactionFee: fareDetails.transactionFee,
        additionalTxnFeeOfrd: fareDetails.additionalTxnFeeOfrd,
        additionalTxnFeePub: fareDetails.additionalTxnFeePub,
        airTransFee: fareDetails.airTransFee
    });


        return {
            srdvIndex: flightDetails.srdvIndex,
            traceId: flightDetails.traceId,
            resultIndex: flightDetails.resultIndex,
            totalFare: flightDetails.totalFare,
            passenger: flightDetails.passengers.map(pax => ({
                title: pax.title,
                firstName: pax.firstName,
                lastName: pax.lastName,
                gender: pax.gender,
                contactNo: pax.contactNo,
                email: pax.email,
                paxType: pax.paxType,
                dateOfBirth: pax.dateOfBirth,
                passportNo: pax.passportNo,
                passportExpiry: pax.passportExpiry,
                passportIssueDate: pax.passportIssueDate,
                addressLine1: pax.addressLine1,
                city: pax.city,
                countryCode: pax.countryCode,
                countryName: pax.countryName,

                baggage: pax.selectedServices?.baggage ? [{
                    Code: pax.selectedServices.baggage.Code,
                    Weight: pax.selectedServices.baggage.Weight,
                    Price: pax.selectedServices.baggage.Price,
                    Origin: pax.selectedServices.baggage.Origin,
                    Destination: pax.selectedServices.baggage.Destination,
                    WayType: pax.selectedServices.baggage.WayType,
                    Currency: pax.selectedServices.baggage.Currency
                }] : [],

                mealDynamic: pax.selectedServices?.meals ? pax.selectedServices.meals.map(meal => ({
                    Code: meal.Code,
                    AirlineDescription: meal.AirlineDescription,
                    Price: meal.Price,
                    Origin: meal.Origin,
                    Destination: meal.Destination,
                    WayType: meal.WayType,
                    Quantity: meal.Quantity,
                    Currency: meal.Currency
                })) : [],

                seat: pax.selectedServices?.seat ? [{
                    Code: pax.selectedServices.seat.code,
                    SeatNumber: pax.selectedServices.seat.seatNumber,
                    Amount: pax.selectedServices.seat.amount,
                    AirlineName: pax.selectedServices.seat.airlineName,
                    AirlineCode: pax.selectedServices.seat.airlineCode,
                    AirlineNumber: pax.selectedServices.seat.airlineNumber
                }] : []
            })),
            fare: {
            baseFare: fareDetails.baseFare || 0,
            tax: fareDetails.tax || 0,
            yqTax: fareDetails.yqTax || 0,
            transactionFee: fareDetails.transactionFee || '0',
            additionalTxnFeeOfrd: fareDetails.additionalTxnFeeOfrd || 0,
            additionalTxnFeePub: fareDetails.additionalTxnFeePub || 0,
            airTransFee: fareDetails.airTransFee || '0'
        }
        };
    };


    // Book outbound flight
    if (bookingDetails.lcc.outbound) {
        console.log("📤 Processing outbound flight booking...");
        const outboundPayload = createFlightPayload(bookingDetails.lcc.outbound);
        console.log("Outbound Payload:", outboundPayload); // Debug log
        if (outboundPayload) {
            try {
                const outboundResponse = await fetch('/flight/bookLCC', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(outboundPayload)
                });
                const outboundData = await outboundResponse.json();
                
                if (outboundData.status === 'success') {
                    console.log("✅ Outbound booking successful:", outboundData.booking_details);
                } else {
                    console.error("❌ Outbound booking failed:", outboundData.message);
                    alert('Outbound flight booking failed: ' + (outboundData.message || 'Unknown error'));
                    return;
                }
            } catch (error) {
                console.error("❌ Error booking outbound flight:", error);
                alert('Error booking outbound flight');
                return;
            }
        }
    }

    // Book return flight
    if (bookingDetails.lcc.return) {
        console.log("📥 Processing return flight booking...");
        const returnPayload = createFlightPayload(bookingDetails.lcc.return);
        
        if (returnPayload) {
            try {
                const returnResponse = await fetch('/flight/bookLCC', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(returnPayload)
                });
                const returnData = await returnResponse.json();
                
                if (returnData.status === 'success') {
                    console.log("✅ Return booking successful:", returnData.booking_details);
                } else {
                    console.error("❌ Return booking failed:", returnData.message);
                    alert('Return flight booking failed: ' + (returnData.message || 'Unknown error'));
                    return;
                }
            } catch (error) {
                console.error("❌ Error booking return flight:", error);
                alert('Error booking return flight');
                return;
            }
        }
    }

    alert('✅ Flight bookings completed successfully!');
}
function BookGdsTicket() {
    const queryParams = new URLSearchParams(window.location.search);
    const bookingDetails = JSON.parse(sessionStorage.getItem('bookingDetails') ?? '{}'); // Prevent parsing null

    // Destructuring with default values
   console.log('booking detailssss',bookingDetails);
}
// Function to process the GDS Ticket booking
function processGdsTicket() {
    const gdsTicketDetails = BookGdsTicket();

    if (!gdsTicketDetails) {
        console.error("Missing required parameters for GDS ticket booking.");
        return;
    }

    const payload = {
        EndUserIp: "1.1.1.1",
        ClientId: "180133",
        UserName: "MakeMy91",
        Password: "MakeMy@910",
        srdvType: "MixAPI",
        srdvIndex: gdsTicketDetails.srdvIndex,
        traceId: gdsTicketDetails.traceId,
        pnr: gdsTicketDetails.pnr,
        bookingId: gdsTicketDetails.bookingId
    };

    console.log("Sending payload:", payload);

    fetch("/flight/bookGdsTicket", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        console.log("API Response:", data);
        if (data.status === "success") {
            console.log("Booking successful:", {
                bookingId: data.data.bookingId,
                pnr: data.data.pnr,
                ticketStatus: data.data.ticketStatus,
                passengers: data.data.passengers
            });
        } else {
            console.error("Booking failed:", data.message);
        }
    })
    .catch(error => {
        console.error("API Error:", error);
    });
}




// Event listener for the "Pay Now" button
document.getElementById("payNowButton").addEventListener("click", async function (event) {
    event.preventDefault();

    const urlParams = new URLSearchParams(window.location.search);
    
 co
    try {
        // Check for GDS ticket details and process if found
        const gdsTicketDetails = BookGdsTickte();
        if (gdsTicketDetails) {
            console.log("Processing GDS ticket booking...");
            processGdsTicket();
            return; // Exit the function if GDS booking is found
        }

        // Process flight booking if applicable
        if (flightDetailsStr) {
            console.log("Processing flight booking...");
            const bookingDetails = getBookingDetailsFromURL();
            if (bookingDetails) {
                bookLCC(bookingDetails);
            } else {
                throw new Error("Invalid or missing flight booking details.");
            }
        } 
        // If no valid booking details are found
        else {
            throw new Error("Unable to determine booking type. Missing required parameters.");
        }
    } catch (error) {
        console.error("Booking error:", error);
        alert(`Error: ${error.message}`);
    }
});








    </script>
</body>
</html>