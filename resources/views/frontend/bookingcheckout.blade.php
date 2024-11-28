<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacation Booking Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: rgba(0, 0, 0, 0.6); /* Dark overlay */
            background-size: cover;
            background-blend-mode: overlay;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
        }

        .checkout-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-top: 2rem;
            padding: 1rem;
        }

        .details-card, .summary-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .summary-card {
            max-width: 450px;
            margin: 0 auto;
        }

        .checkout-button {
            background-color: #f39c12;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-size: 1.125rem;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .checkout-button:hover {
            background-color: #d35400;
            transform: scale(1.05);
        }

        .destination-item {
            display: flex;
            flex-direction: row;
            align-items: center;
            border: 1px solid #e0e0e0;
            padding: 1rem;
            border-radius: 0.75rem;
            background-color: #f8f9fa;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            width: 100%;
            position: relative;
        }

        .destination-item img {
            width: 250px; /* Increased size */
            height: auto;
            border-radius: 0.75rem;
            object-fit: cover;
            margin-right: 1.5rem;
        }

        .destination-item .destination-details {
            flex: 1;
        }

        .destination-item i {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            cursor: pointer;
            color: #e74c3c;
            font-size: 1.25rem;
            transition: color 0.3s ease;
        }

        .destination-item i:hover {
            color: #c0392b;
        }

        .total-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2c3e50;
        }

        .summary-label {
            font-size: 0.875rem;
            color: #000000;
        }

        .details-card hr, .summary-card hr {
            margin: 1rem 0;
            border-color: #ddd;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            /* For tablets and smaller screens */
            .checkout-container {
                flex-direction: column; /* Stack sections vertically on smaller screens */
                gap: 2rem;
            }

            .destination-item {
                flex-direction: column; /* Stack image and details vertically on smaller screens */
            }

            .destination-item img {
                width: 100%; /* Full width on smaller screens */
                height: auto;
                margin-right: 0;
                margin-bottom: 1rem;
            }

            .summary-card {
                width: 100%; /* Take full width on smaller screens */
            }
        }

        @media (max-width: 640px) {
            /* For mobile screens */
            .checkout-container {
                padding: 1rem;
            }

            .destination-item img {
                width: 100%; /* Full width on mobile */
                height: auto;
            }

            .destination-item {
                flex-direction: column; /* Stack image and details vertically */
            }

            .summary-card {
                width: 100%; /* Full width on mobile */
            }

            .checkout-button {
                font-size: 1rem; /* Adjust button size for mobile */
                padding: 1rem;
            }

            .total-price {
                font-size: 1.25rem; /* Adjust total price font for mobile */
            }
        }
    </style>
</head>
<body>
    <div class="max-w-7xl mx-auto checkout-container">
        <!-- Left Section (Booking Details) -->
        <div class="details-card flex-1">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Booking Details</h2>
            <div id="destination-list"></div>
            <hr>
            <div class="flex justify-between items-center mt-2">
                <p class="summary-label">Total Price for All Destinations:</p>
                <p id="all-destinations-total" class="details-value">₹0</p>
            </div>
        </div>

        <!-- Right Section (Price Summary) -->
        <div class="summary-card">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Price Summary</h3>
            <div id="price-summary"></div>
            <hr>
            <div class="flex justify-between items-center mt-4">
                <p class="summary-label">Subtotal:</p>
                <p id="subtotal" class="details-value">₹0</p>
            </div>
            <div class="flex justify-between items-center mt-2">
                <p class="summary-label">Tax (18%):</p>
                <p id="tax" class="details-value">₹0</p>
            </div>
            <div class="flex justify-between items-center mt-2">
                <p class="summary-label">Travel Charge:</p>
                <p id="travel-charge" class="details-value">₹500</p>
            </div>
            <div class="flex justify-between items-center mt-4 border-t-2 border-gray-200 pt-2">
                <p class="total-price">Total Price:</p>
                <p id="total-price" class="total-price">₹0</p>
            </div>
            <button type="button" class="checkout-button w-full py-3 text-white rounded-lg mt-4" onclick="window.location.href='{{ route('payment') }}'">
                <i class="fas fa-check-circle mr-2"></i> Proceed to Pay
            </button>
        </div>
    </div>

    <script>
        // Fetching the booking data from the Laravel controller (as passed to the view)
        let booking = @json($booking); // The single booking object

        // A function to calculate and update the price summary
        function updatePriceSummary() {
            let subtotal = booking.package.price * (booking.adults + booking.children);
            let tax = subtotal * 0.18; // 18% tax
            let travelCharge = 500;
            let totalPrice = subtotal + tax + travelCharge;

            document.getElementById('subtotal').textContent = `₹${subtotal}`;
            document.getElementById('tax').textContent = `₹${tax}`;
            document.getElementById('total-price').textContent = `₹${totalPrice}`;

            const totalAllDestinations = subtotal;
            document.getElementById('all-destinations-total').textContent = `₹${totalAllDestinations}`;
        }

        // Function to render the booking details on the page
        function renderBookingDetails() {
            const destinationList = document.getElementById('destination-list');
            destinationList.innerHTML = ''; // Clear previous content

            const bookingTotal = (booking.package.price * booking.adults) + (booking.package.price * booking.children);

            const div = document.createElement('div');
            div.classList.add('destination-item');
            div.innerHTML = `
                <img src="{{ asset("assets/images/goa-about-img.jpg") }}" style="width: 250px; height: auto; object-fit: cover; border-radius: 0.75rem;" alt="${booking.package.package_name}">
                <div class="destination-details">
                    <h4 class="text-lg font-semibold">${booking.package.package_name}</h4>
                    <p class="text-sm text-gray-600"><b>Name:</b> ${booking.full_name}</p>
                    <p class="text-sm text-gray-600"><b>Phone no.:</b> ${booking.phone}</p>
                    <p class="text-sm text-gray-600"><b>E-mail:</b> ${booking.email}</p>
                    <p class="text-sm text-gray-600"><b>Adults:</b> ${booking.adults}</p>
                    <p class="text-sm text-gray-600"><b>Children:</b> ${booking.children}</p>
                    <p class="text-sm text-gray-600"><b>Travel Date:</b> ${booking.travel_date}</p>
                    <i class="fas fa-trash" onclick="removeBooking()"></i>
                    <div class="mt-4">
                        <p class="font-semibold text-gray-800">Total Price: ₹${bookingTotal}</p>
                    </div>
                </div>
            `;
            destinationList.appendChild(div);
        }
        // Function to remove the booking (can be modified if needed to interact with backend)
        function removeBooking() {
            alert("Booking has been removed.");
            // Here, you would typically send a request to the backend to remove the booking.
        }

        // Initialize the page with booking data
        renderBookingDetails();
        updatePriceSummary();
    </script>
</body>
</html>
