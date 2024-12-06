<!DOCTYPE html>
<html lang="en">

<head>
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

</style>


     <!-- Add Font Awesome for Icons -->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <form>
            <div id="credit-card-alert" class="alert">
                Credit card payments are temporarily unavailable. Please try another method.
            </div>

            <h3 style="text-align: center; margin-bottom: 20px;">Select Payment Method</h3>
            <div class="payment-methods">
                <input type="radio" id="card" name="payment-method" value="card" checked onclick="togglePaymentOption('card')">
                <label for="card">Credit Card</label>

                <input type="radio" id="qr" name="payment-method" value="qr" onclick="togglePaymentOption('qr')">
                <label for="qr">QR Code</label>

                <input type="radio" id="upi" name="payment-method" value="upi" onclick="togglePaymentOption('upi')">
                <label for="upi">UPI</label>
            </div>

            <div class="payment-option card-option active" id="card-option">
                <div class="input-group">
                    <label>Name on Card:</label>
                    <input type="text" placeholder="MMBY" required>
                </div>
                <div class="input-group">
                    <label>Credit Card Number:</label>
                    <input type="text" placeholder="1111-2222-3333-4444" required>
                </div>
                <div class="input-group">
                    <label>Expiration Date:</label>
                    <div style="display: flex; gap: 10px;">
                        <input type="text" placeholder="MM" style="flex: 1;" required>
                        <input type="text" placeholder="YYYY" style="flex: 1;" required>
                    </div>
                </div>
                <div class="input-group">
                    <label>CVV:</label>
                    <input type="text" placeholder="123" required>
                </div>
                <div class="submit-btn-container">
                <button type="submit" class="submit-btn">Checkout</button>
            </div>
            
            </div>

            <div class="payment-option qr-option" id="qr-option">
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
    <script>
       function togglePaymentOption(option) {
    // Show or hide the credit card alert
    document.getElementById("credit-card-alert").style.display = option === 'card' ? "block" : "none";

    // Hide all payment options
    document.querySelectorAll('.payment-option').forEach((element) => {
        element.classList.remove('active');
    });

    // Show the selected payment option
    const selectedOption = document.getElementById(`${option}-option`); // Fixed template literal usage
    if (selectedOption) {
        selectedOption.classList.add('active');
    }
}
    </script>
</body>
</html>