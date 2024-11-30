<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- custom css file link  -->
    <!-- <link rel="stylesheet" href="./checkout.css"> -->
<style>
    * {
  margin: 0 auto;
  padding: 0;
  box-sizing: border-box;
  outline: none;
  border: none;
  text-transform: capitalize;
  transition: all 0.2s linear;
}

.container {
  display: flex;
  justify-content: center; /* Center horizontally */
  align-items: center;    /* Center vertically */
  padding: 20px;
  min-height: 100vh;
  background-image: url("{{ asset('assets/images/bg.webp') }}");
  background-repeat: no-repeat;
  background-size: cover;
}

.container form {
  padding: 30px;
  max-width: 700px;
  width: 100%;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.container form:hover {
  transform: scale(1.02); /* Slightly enlarges the form on hover */
}
.container form .row {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
}

.container form .row .col {
  flex: 1 1 300px; /* Adjusted for better responsiveness */
}

.container form .row .col .title {
  font-size: 20px;
  color: #333;
  padding-bottom: 5px;
  text-transform: uppercase;
}

.container form .row .col .inputBox {
  margin: 15px 0;
}

.container form .row .col .inputBox span {
  margin-bottom: 10px;
  display: block;
}

.container form .row .col .inputBox input {
  width: 100%;
  border: 1px solid #ccc;
  padding: 10px 15px;
  font-size: 15px;
  text-transform: none;
}
.container form .row .col .inputBox input:hover {
    background-color: rgba(0, 0, 0, 0.1);
}
.container form .row .col .inputBox input:focus {
  border: 1px solid #FF0000; /* Highlights border on focus */
  background-color: #fff; /* Changes background color on focus */
}

.container form .row .col .flex {
  display: flex;
  gap: 15px;
}

.container form .row .col .flex .inputBox {
  margin-top: 5px;
}

.container form .row .col .inputBox img {
  height: 34px;
}
.submit-btn-container {
  align-items: center;
  display: flex;
  justify-content: center;
}
.container form .submit-btn {
  padding: 12px;
  font-size: 17px;
  background: #27ae60;
  color: #fff;
  margin-top: 5px;
  cursor: pointer;
}
.payment-methods label {
    display: block;
    margin: 10px 0;
    cursor: pointer;
}
.payment-methods img {
    max-width: 40%;
    margin-top: 5px;
}
.payment-option {
    display: none;
}

.payment-option img {
    max-width: 100%;
    margin-top: 10px;
}
.payment-option:hover {
    background-color: rgba(0, 0, 0, 0.1);
}

.container form .submit-btn:hover {
  background: #2ecc71;
}

</style>
</head>
<body>
    <div class="container">
        <form action="">
            <!-- Billing Address Section -->
            <div class="row">
                <div class="col">
                    <h3 class="title">Billing Address</h3>
                    <div class="inputBox">
                        <span>Full Name:</span>
                        <input type="text" placeholder="Make My Bharat Yatra" required>
                    </div>
                    <div class="inputBox">
                        <span>Email:</span>
                        <input type="email" placeholder="example@gmail.com" required>
                    </div>
                    <div class="inputBox">
                        <span>Address:</span>
                        <input type="text" placeholder="Room - Street - Locality" required>
                    </div>
                    <div class="inputBox">
                        <span>City:</span>
                        <input type="text" placeholder="Noida" required>
                    </div>
                    <div class="flex">
                        <div class="inputBox">
                            <span>State:</span>
                            <input type="text" placeholder="Uttar Pradesh" required>
                        </div>
                        <div class="inputBox">
                            <span>Zip Code:</span>
                            <input type="text" placeholder="201 301" required>
                        </div>
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="col">
                    <h3 class="title">Payment:</h3>
                    
                    <!-- Payment Methods -->
                    <div class="payment-methods">
                        <label>
                            <input type="radio" name="payment-method" value="card" checked><b> Credit Card</b>
                            <!-- <img src="{{ asset('assets/images/pay.jpg') }}" alt="Payment Image" style="width: 50px; height: 50px;"/> -->

                        </label>
                        <label>
                            <input type="radio" name="payment-method" value="qr"> <b>QR Code</b>
                        </label>
                        <label>
                            <input type="radio" name="payment-method" value="upi"> <b>UPI</b>
                        </label>
                    </div>

                    <!-- Card Payment Section -->
                    <div class="payment-option card-option">
                        <div class="inputBox">
                            <span>Name on Card:</span>
                            <input type="text" placeholder="Make My Bharat Yatra" required>
                        </div>
                        <div class="inputBox">
                            <span>Credit Card Number:</span>
                            <input type="text" placeholder="1111-2222-3333-4444" required>
                        </div>
                        <div class="inputBox">
                            <span>Exp Month:</span>
                            <input type="text" placeholder="January" required>
                        </div>
                        <div class="flex">
                            <div class="inputBox">
                                <span>Exp Year:</span>
                                <input type="number" placeholder="2024" required>
                            </div>
                            <div class="inputBox">
                                <span>CVV:</span>
                                <input type="text" placeholder="123" required>
                            </div>
                        </div>
                    </div>
                    <!-- QR Payment Section -->
                    <div class="payment-option qr-option" style="display:none;">
                        <h4>Scan the QR Code</h4>
                        <div id="qr-code"style="text-align:center;">
                            <img src="{{ asset('assets/images/qr.jpeg')}}" alt="Scan the QR Code" style="width: 200px; height: 200px;"/>
                            <p>Use any payment app to scan and pay.</p>
                        </div>
                    </div>
                    <!-- UPI Payment Section -->
                    <div class="payment-option upi-option" style="display:none;">
                        <h4>Pay via UPI</h4>
                        <div class="inputBox">
                        <img src="{{ asset('assets/images/upi.jpeg')}}" alt="Enter UPI ID:" />
                            <!-- <span>Enter UPI ID:</span>
                            <input type="text" placeholder="example@upi" required> -->
                        </div>
                        <p>Use your UPI app to make the payment to the provided UPI ID.</p>
                    </div>
                </div>
            </div>
            <!-- Submit Button -->
            <div class="submit-btn-container">
                <input type="submit" value="Proceed to Checkout" class="submit-btn">
            </div>
        </form>
    </div>
    <script>
        // JavaScript to handle showing and hiding of payment methods based on user selection
        document.addEventListener("DOMContentLoaded", function () {
            const paymentMethods = document.querySelectorAll('input[name="payment-method"]');
            const cardOption = document.querySelector('.card-option');
            const qrOption = document.querySelector('.qr-option');
            const upiOption = document.querySelector('.upi-option');
            
            // Initially show the card payment option by default
            showPaymentOption('card');

            paymentMethods.forEach(method => {
                method.addEventListener('change', (event) => {
                    showPaymentOption(event.target.value);
                });
            });
            function showPaymentOption(method) {
                // Hide all options first
                cardOption.style.display = 'none';
                qrOption.style.display = 'none';
                upiOption.style.display = 'none';

                // Show the selected payment option
                if (method === 'card') {
                    cardOption.style.display = 'block';
                } else if (method === 'qr') {
                    qrOption.style.display = 'block';
                } else if (method === 'upi') {
                    upiOption.style.display = 'block';
                }
            }
        });

       // for disabling to see source code
    document.addEventListener("contextmenu", (e) => e.preventDefault()); // Disable right-click
    document.addEventListener("keydown", (e) => {
        if (e.ctrlKey && (e.key === 'u' || e.key === 's' || e.key === 'p')) {
            // Disable Ctrl+U (View Source), Ctrl+S (Save Page), and Ctrl+P (Print)
            e.preventDefault();
        }
    });
    </script>
</body>

</html>
