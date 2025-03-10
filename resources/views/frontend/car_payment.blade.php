<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    .submit-btn {
    background: linear-gradient(135deg, #007BFF, #0056b3);
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 16px;
    font-weight: bold;
    padding: 12px 24px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.submit-btn:hover {
    background: linear-gradient(135deg, #0056b3, #003d80);
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

.submit-btn:active {
    transform: translateY(1px);
    box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.15);
}

.button-container {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
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
        </div>

        <div class="booking-section center-section">
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
                <div class="info-item">
                    <span class="label">TraceID:</span>
                    <span class="value">{{ $bookingDetails['trace_id'] ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">SrdvIndex:</span>
                    <span class="value">{{ $bookingDetails['srdv_index'] ?? 'N/A' }}</span>
                </div>
            </div>
            @endif
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

    <div class="button-container">
        <button id="processToPay" class="submit-btn">Process To Pay</button>
    </div>

    
    <div class="contact-info">
        <a href="mailto:info@makemybharatyatra.com">
            <i class="fas fa-envelope"></i> info@makemybharatyatra.com
        </a>
        <a href="tel:+911204223100">
            <i class="fas fa-phone-alt"></i> +91 1204223100
        </a>
    </div>
   <!-- Loading Overlay -->
   <div id="loadingOverlay" class="loading-overlay">
        <div class="spinner"></div>
        <div>Processing payment...</div>
    </div>
    <script>
    document.getElementById("processToPay").addEventListener("click", function(e) {
        e.preventDefault();
        
        // Get amount from booking details
        const amount = {{ $bookingDetails['car_info']['price'] ?? 0 }};
        
        // Step 1: Create an order via API
        fetch('/create-payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ amount: amount })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert('Error: ' + data.error);
                return;
            }
            
            // Step 2: Initialize Razorpay Payment UI
            var options = {
                "key": "{{ env('RAZORPAY_KEY') }}",
                "amount": data.amount * 100, // Convert to paise
                "currency": data.currency,
                "name": "Make My Bharat Yatra",
                "description": "Car Final Payment",
                "image": "/assets/images/MMBY_logo.jpg",
                "order_id": data.order_id,
                "handler": function (response) {
                    // Step 3: Send Payment Data to Server
                    var form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/verify-payment';
                    
                    // Add CSRF token properly
                    var csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
                    var csrfToken = csrfTokenElement ? csrfTokenElement.getAttribute('content') : '';
                    form.innerHTML = `
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <input type="hidden" name="razorpay_order_id" value="${response.razorpay_order_id}">
                        <input type="hidden" name="razorpay_payment_id" value="${response.razorpay_payment_id}">
                        <input type="hidden" name="razorpay_signature" value="${response.razorpay_signature}">
                        <input type="hidden" name="trace_id" value="{{ $bookingDetails['trace_id'] ?? '' }}"> <!-- Add trace_id -->
                        <input type="hidden" name="srdv_index" value="{{ $bookingDetails['srdv_index'] ?? '' }}"> <!-- Add srdv_index -->
                    `;
                    document.body.appendChild(form);
                    form.submit();
                },
                "prefill": {
                    "name": "{{ $bookingDetails['personal_info']['name'] ?? '' }}",
                    "email": "{{ $bookingDetails['personal_info']['email'] ?? '' }}",
                    "contact": "{{ $bookingDetails['personal_info']['phone'] ?? '' }}"
                },
                "theme": {
                    "color": "#2563eb"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to create payment order. Please try again.');
        });
    });
</script>

</body>
</html>