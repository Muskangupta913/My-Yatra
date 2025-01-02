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
        alert("Missing required parameters!");
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
        'ClientId' => config('api.client_id'), // Fetch from config
        'UserName' => config('api.username'), // Fetch from config
        'Password' => config('api.password'), // Fetch from config
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
    </script>
</body>
</html>