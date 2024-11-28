<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
    <title>Vacation Booking Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 2rem auto;
            gap: 2rem;
        }

        .left-panel {
            flex: 2;
            background-color: #ffffff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .destination-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 10px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .destination-details {
            flex-grow: 1;
        }

        .destination-item img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            margin-right: 1rem;
            object-fit: cover;
        }

        .checkout-button {
            background-color: #2874f0;
            color: white;
            font-size: 1rem;
            font-weight: bold;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        .checkout-button:hover {
            background-color: #1565c0;
            transform: scale(1.05);
        }

        .right-panel {
            flex: 1;
            background-color: #ffffff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-height: fit-content;
        }

        .summary-card p {
            margin: 0.5rem 0;
            font-size: 0.9rem;
        }

        .total-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            margin-top: 1rem;
        }

        .summary-card button {
            background-color: #f39c12;
            color: white;
            font-size: 1.1rem;
            font-weight: bold;
            padding: 0.75rem;
            border-radius: 5px;
            margin-top: 1rem;
            transition: all 0.3s ease-in-out;
        }

        .summary-card button:hover {
            background-color: #d35400;
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                gap: 1.5rem;
            }

            .left-panel,
            .right-panel {
                width: 20%;
            }

            .destination-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .checkout-button {
                width: 100%;
                margin-top: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Left Panel -->
        <div class="left-panel" id="cart-items">
            <!-- Example Destination Item -->
            <div class="destination-item">
                <div class="destination-details">
                    <img src="https://via.placeholder.com/80" alt="Destination Image">
                    <div>
                        <h4 class="font-semibold">Package Name</h4>
                        <p class="text-gray-600">Duration: 3 days</p>
                        <p class="text-gray-600">Start Date: 2023-12-01</p>
                        <p class="text-gray-600">Price: ₹5000.00</p>
                    </div>
                </div>
                <button class="checkout-button">Proceed to Pay</button>
            </div>
        </div>

        <!-- Right Panel -->
        <div class="right-panel summary-card">
            <p>Subtotal: <span id="subtotal">₹0.00</span></p>
            <p>Tax: <span id="tax">₹0.00</span></p>
            <p>Travel Charge: ₹500.00</p>
            <p class="total-price">Total: <span id="total-price">₹0.00</span></p>
            <button type="button" onclick="window.location.href='{{ route('payment') }}'">
                <i class="fas fa-check-circle mr-2"></i> Proceed to Pay
            </button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Fetch cart items dynamically here
        $(document).ready(function () {
            // Example for demonstration
            $('#cart-items').append(`
                <div class="destination-item">
                    <div class="destination-details">
                        <img src="https://via.placeholder.com/80" alt="Destination Image">
                        <div>
                            <h4 class="font-semibold">Demo Package</h4>
                            <p class="text-gray-600">Duration: 5 days</p>
                            <p class="text-gray-600">Start Date: 2024-01-01</p>
                            <p class="text-gray-600">Price: ₹10000.00</p>
                        </div>
                    </div>
                    <button class="checkout-button">Proceed to Pay</button>
                </div>
            `);
        });
    </script>
</body>

</html>
