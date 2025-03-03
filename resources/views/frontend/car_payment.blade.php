<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --background-color: #f8fafc;
            --text-color: #1e293b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.5;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
            display: grid;
            grid-template-columns: 1fr 1.2fr 1fr;
            gap: 2rem;
        }

        .booking-section {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            animation: slideIn 0.5s ease-out;
            height: fit-content;
        }

        .info-grid {
            display: grid;
            gap: 1rem;
        }

        .info-item {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 0.5rem;
            align-items: center;
        }

        .left-section { animation-delay: 0.2s; }
        .center-section { animation-delay: 0.4s; }
        .right-section { animation-delay: 0.6s; }

        @keyframes slideIn {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .section-title {
            color: var(--text-color);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
            font-size: 1.25rem;
        }

        .label {
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .value {
            color: #111827;
            font-weight: 500;
        }

        .payment-methods {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .payment-method-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-method-label:hover {
            border-color: var(--primary-color);
            background-color: #f8fafc;
        }

        .payment-method-label.active {
            border-color: var(--primary-color);
            background-color: #eff6ff;
        }

        .payment-option {
            display: none;
            animation: fadeIn 0.3s ease-out;
        }

        .payment-option.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .alert {
            background-color: #fee2e2;
            color: #dc2626;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .qr-code {
            max-width: 200px;
            margin: 1.5rem auto;
            display: block;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgb(0 0 0 / 0.1);
        }

        .submit-btn {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            width: 100%;
            font-weight: 600;
            transition: background-color 0.2s;
            margin-top: 1rem;
        }

        .submit-btn:hover {
            background: var(--secondary-color);
        }
        .contact-info {
            text-align: center;
            margin-top: 2rem;
            padding: 1rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgb(0 0 0 / 0.1);
        }

        .contact-info a {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-color);
            text-decoration: none;
            margin: 0 1rem;
            transition: color 0.2s;
        }

        .contact-info a:hover {
            color: var(--primary-color);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            position: relative;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }

        .modal-content input {
            display: block;
            width: 100%;
            padding: 0.75rem;
            margin: 1rem 0;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            transition: border-color 0.2s;
        }
        .modal-content input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        button {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button:hover {
            background: var(--secondary-color);
        }

        .close {
            position: absolute;
            right: 1.5rem;
            top: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
            color: #64748b;
        }


        @media (max-width: 1024px) {
            .container {
                grid-template-columns: 1fr;
                grid-template-areas: 
                    "center"
                    "left"
                    "right";
                max-width: 800px;
            }

            .left-section { grid-area: left; }
            .center-section { grid-area: center; }
            .right-section { grid-area: right; }
        }

        @media (max-width: 640px) {
            .container {
                margin: 1rem;
                padding: 1rem;
            }

            .booking-section {
                padding: 1rem;
            }

            .info-item {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Section: Trip & Vehicle Details -->
        <div class="booking-section left-section">
            <h2 class="section-title">Trip Details</h2>
            @if(isset($bookingDetails['trip_info']))
            <div class="info-grid">
                <!-- <div class="info-item">
                    <span class="label">From:</span>
                    <span class="value">{{ $bookingDetails['trip_info']['pickup_location'] ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">To:</span>
                    <span class="value">{{ $bookingDetails['trip_info']['dropoff_location'] ?? 'N/A' }}</span>
                </div> -->
                <div class="info-item">
                    <span class="label">Pickup Address:</span>
                    <span class="value">{{ $bookingDetails['trip_info']['pickup_address'] ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Drop Address:</span>
                    <span class="value">{{ $bookingDetails['trip_info']['drop_address'] ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Date:</span>
                    <span class="value">{{ $bookingDetails['trip_info']['booking_date'] ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Trip Type:</span>
                    <span class="value">{{ $bookingDetails['trip_info']['trip_type'] ?? 'N/A' }}</span>
                </div>
            </div>
            @endif

            <h2 class="section-title">Vehicle Details</h2>
            @if(isset($bookingDetails['car_info']))
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Category:</span>
                    <span class="value">{{ $bookingDetails['car_info']['category'] ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Seating Capacity:</span>
                    <span class="value">{{ $bookingDetails['car_info']['seating'] ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Luggage Capacity:</span>
                    <span class="value">{{ $bookingDetails['car_info']['luggage'] ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Total Price:</span>
                    <span class="value">₹{{ $bookingDetails['car_info']['price'] ?? 'N/A' }}</span>
                </div>
            </div>
            @endif
        </div>

        <!-- Center Section: Payment Methods -->
        <div class="booking-section center-section">
            <h2 class="section-title">Payment</h2>
            
            <form id="payment-form">
                <div id="credit-card-alert" class="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    Credit card payments are temporarily unavailable.
                    <button id="showFormButton" type="button" onclick="showModal()">
                        <b>Click Here</b>
                    </button>
                </div>

                <div class="payment-methods">
                    <label class="payment-method-label" onclick="togglePaymentOption('card')">
                        <input type="radio" name="payment-method" value="card">
                        <i class="fas fa-credit-card"></i>
                        Credit Card
                    </label>

                    <label class="payment-method-label active" onclick="togglePaymentOption('qr')">
                        <input type="radio" name="payment-method" value="qr" checked>
                        <i class="fas fa-qrcode"></i>
                        QR Code
                    </label>

                    <label class="payment-method-label" onclick="togglePaymentOption('upi')">
                        <input type="radio" name="payment-method" value="upi">
                        <i class="fas fa-mobile-alt"></i>
                        UPI
                    </label>
                </div>

                <div class="payment-option" id="card-option">
                    <h4>Card Payment</h4>
                    <p>Credit card payments are currently unavailable.</p>
                </div>

                <div class="payment-option active" id="qr-option">
                    <h4>Scan QR Code</h4>
                    <img src="{{ asset('assets/images/qr.jpeg') }}" alt="QR Code" class="qr-code">
                    <p>Use any payment app to scan and pay</p>
                </div>

                <div class="payment-option" id="upi-option">
                    <h4>Pay via UPI</h4>
                    <img src="{{ asset('assets/images/upi.jpeg') }}" alt="UPI QR Code" class="qr-code">
                    <p>Use your UPI app to make the payment</p>
                </div>

                <button id="finalsubmit" type="button" class="submit-btn">
                    <b>Proceed to Pay</b>
                </button>
            </form>
        </div>

        <!-- Right Section: Personal Information -->
        <div class="booking-section right-section">
            <h2 class="section-title">Personal Information</h2>
            @if(isset($bookingDetails['personal_info']))
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Name:</span>
                    <span class="value">{{ $bookingDetails['personal_info']['name'] ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Email:</span>
                    <span class="value">{{ $bookingDetails['personal_info']['email'] ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Phone:</span>
                    <span class="value">{{ $bookingDetails['personal_info']['phone'] ?? 'N/A' }}</span>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="contact-info">
        <a href="mailto:info@makemybharatyatra.com">
            <i class="fas fa-envelope"></i> info@makemybharatyatra.com
        </a>
        <a href="tel:+911204223100">
            <i class="fas fa-phone-alt"></i> +91 1204223100
        </a>
    </div>

    <!-- Modal -->
     <div id="payment-modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModal()">&times;</span>
            <h4>Fill the Details Below</h4>
            <form id="modal-form" method="POST">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="tel" name="mobile" placeholder="Your Mobile No." required>
                <input type="number" name="amount" placeholder="Payment Amount" required>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        function togglePaymentOption(option) {
            document.querySelectorAll('.payment-option').forEach(el => {
                el.classList.remove('active');
            });
            document.getElementById(`${option}-option`).classList.add('active');
        }

        function showModal() {
            document.getElementById('payment-modal').classList.add('active');
        }

        function hideModal() {
            document.getElementById('payment-modal').classList.remove('active');
        }

        document.getElementById('modal-form').addEventListener('submit', function(e) {
            e.preventDefault();
            // Add your form submission logic here
            alert('Form submitted successfully!');
            hideModal();
        });


const API_CONFIG = {
    url: 'https://car.srdvapi.com/v4/rest/Book',
    headers: {
        'API-Token': 'MakeMy@910@23',
        'Content-Type': 'application/json'
    },
    credentials: {
        EndUserIp: "1.1.1.1",
        "ClientId" => $request->input('ClientId'),
        "UserName" => $request->input('UserName'),
        "Password" => $request->input('Password'),
    }
};

const loadingState = {
    start: () => {
        document.getElementById('finalsubmit').disabled = true;
        document.getElementById('finalsubmit').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    },
    end: () => {
        document.getElementById('finalsubmit').disabled = false;
        document.getElementById('finalsubmit').innerHTML = '<b>Submit</b>';
    }
};

const showMessage = (message, isError = false) => {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert ${isError ? 'error' : 'success'}`;
    alertDiv.style.backgroundColor = isError ? '#fee2e2' : '#dcfce7';
    alertDiv.style.color = isError ? '#dc2626' : '#15803d';
    alertDiv.textContent = message;
    
    document.querySelector('.container').insertBefore(alertDiv, document.getElementById('payment-form'));
    
    setTimeout(() => alertDiv.remove(), 5000);
};

// Helper function to make API calls
const makeApiCall = async (url, data) => {
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: API_CONFIG.headers,
            body: JSON.stringify({
                ...API_CONFIG.credentials,
                ...data
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        throw new Error(`API call failed: ${error.message}`);
    }
};

// Function to check wallet balance
const checkWalletBalance = async () => {
    try {
        const response = await makeApiCall(API_CONFIG.walletUrl, {});
        
        if (response.Error && response.Error.ErrorCode !== "0") {
            throw new Error(response.Error.ErrorMessage || "Failed to fetch wallet balance");
        }

        return {
            success: true,
            balance: response.Balance
        };
    } catch (error) {
        return {
            success: false,
            error: error.message
        };
    }
};

// Function to verify transaction
const verifyTransaction = async (bookingId) => {
    try {
        const response = await makeApiCall(API_CONFIG.balanceLogUrl, {
            BookingId: bookingId
        });

        if (response.Error && response.Error.ErrorCode !== "0") {
            showMessage("Transaction verification failed: " + response.Error.ErrorMessage, true);
            return false;
        }
        return true;
    } catch (error) {
        showMessage("Error verifying transaction: " + error.message, true);
        return false;
    }
};

const makeBookingRequest = async () => {
    loadingState.start();

    try {
        // Check wallet balance first
        const walletStatus = await checkWalletBalance();
        if (!walletStatus.success) {
            showMessage(`Wallet check failed: ${walletStatus.error}`, true);
            loadingState.end();
            return;
        }

        const bookingData = {
            EndUserIp: "1.1.1.1",
            SrdvIndex: "SRDV-2",
            TraceID: "1",
            PickUpTime: "18:00",
            DropUpTime: "18:00",
            RefID: "77894",
            CustomerName: "Md Aiyaz",
            CustomerPhone: "9709310868",
            CustomerEmail: "mdaiyaz09@gmail.com",
            CustomerAddress: "Noida",
            PaymentType: "WALLET",
            IsConfirmed: true,
            DeductAmount: true,
            BookingType: "INSTANT"
        };

        const response = await makeApiCall(API_CONFIG.url, bookingData);

        if (response.Error.ErrorCode === "0") {
            const verificationSuccess = await verifyTransaction(response.Result.BookingID);
            if (verificationSuccess) {
                showMessage(`Booking successful! Booking ID: ${response.Result.BookingID}`);
            }
        } else {
            showMessage(response.Error.ErrorMessage || 'Booking failed', true);
        }
    } catch (error) {
        showMessage(error.message, true);
    } finally {
        loadingState.end();
    }
};

// Event listener for submit button
document.getElementById('finalsubmit').addEventListener('click', makeBookingRequest);


</script>
</body>
</html>