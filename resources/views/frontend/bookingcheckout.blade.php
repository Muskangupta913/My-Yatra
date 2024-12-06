<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacation Booking Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
       /* General Styling */
body {
    background: rgba(0, 0, 0, 0.6); /* Dark overlay */
    background-image: url("{{ asset('assets/images/goa-about-img.jpg') }}");
    background-size: cover;
    background-blend-mode: overlay;
    min-height: 100vh;
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.checkout-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-top: 2rem;
    padding: 1rem;
    justify-content: space-between;
}

.details-card,
.summary-card {
    background-color: #ffffff;
    border: 1px solid #e0e0e0;
    padding: 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    width: 48%; /* Default side-by-side layout */
}

.summary-card {
    max-width: 450px;
}

.checkout-button {
    background-color: #f39c12;
    transition: background-color 0.3s ease, transform 0.3s ease;
    font-size: 1.125rem;
    font-weight: bold;
    padding: 0.75rem 1.5rem;
    color: #ffffff;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.checkout-button:hover {
    background-color: #d35400;
    transform: scale(1.05);
}

/* Destination Item Styling */
.destination-item {
    display: flex;
    align-items: flex-start;
    border: 1px solid #e0e0e0;
    padding: 1.5rem;
    border-radius: 0.75rem;
    background-color: #ffffff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 1rem;
    width: 100%;
    position: relative;
    gap: 1.5rem;
    flex-direction: row-reverse; /* Change to row-reverse to place image on the right */
}

.destination-item img {
    width: 250px; /* Image size for larger screens */
    height: 175px;
    border-radius: 0.75rem;
    object-fit: cover;
}

.destination-item .destination-details {
    flex: 1;
    font-size: 0.95rem;
    line-height: 1.6;
    color: #333333;
}

.destination-item .destination-details p {
    margin: 0.5rem 0;
}

.destination-item i {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    cursor: pointer;
    color: #e74c3c;
    font-size: 1.5rem;
    transition: color 0.3s ease;
    padding: 0.25rem; /* Adds some space around the trash icon */
    background-color: #ffffff; /* Optional background for visibility */
}

.destination-item i:hover {
    color: #c0392b;
}

.destination-item .font-semibold {
    font-size: 1rem;
    font-weight: bold;
    color: #2c3e50;
}

.total-price {
    font-size: 1.5rem;
    font-weight: bold;
    color: #2c3e50;
    margin-top: 0.5rem;
}

.summary-label {
    font-size: 0.875rem;
    color: #000000;
}

.details-card hr,
.summary-card hr {
    margin: 1rem 0;
    border-color: #ddd;
}

/* Responsive Design */

/* Large Desktops */
@media (min-width: 1280px) {
    .checkout-container {
        padding: 2rem;
    }

    .details-card,
    .summary-card {
        width: 48%;
    }

    .destination-item img {
        width: 300px;
        height: 200px;
    }

    .checkout-button {
        font-size: 1.25rem;
    }
}

/* Laptops (1024px to 1279px) */
@media (max-width: 1279px) {
    .checkout-container {
        padding: 1.5rem;
    }

    .details-card,
    .summary-card {
        width: 48%;
    }

    .destination-item img {
        width: 250px;
        height: 175px;
    }
}

/* Tablets (768px to 1023px) */
@media (max-width: 1023px) {
    .checkout-container {
        flex-direction: column; /* Stack sections vertically */
    }

    .details-card,
    .summary-card {
        width: 100%; /* Full width for smaller screens */
    }

    .destination-item {
        flex-direction: column; /* Stack image and details vertically */
    }

    .destination-item img {
        width: 100%; /* Full width image on tablets */
        height: auto;
        margin-bottom: 1rem;
    }
}

/* Mobile Devices (Up to 767px) */
@media (max-width: 767px) {
    .checkout-container {
        padding: 1rem;
    }

    .destination-item img {
        width: 100%; /* Full width image on mobile */
        height: auto;
    }

    .destination-item {
        flex-direction: column;
    }

    .checkout-button {
        font-size: 1rem;
        padding: 1rem;
    }

    .total-price {
        font-size: 1.25rem; /* Adjust font size for mobile */
    }

    .details-card,
    .summary-card {
        width: 100%;
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
        let booking = @json($booking);
        const package = booking.package;  // The single booking object
        console.log('Booking', booking);
        console.log('Package', package);

        // A function to calculate and update the price summary
        function updatePriceSummary() {
            let adultPrice = package.ragular_price * 2 * booking.adults;  // Double the price for each adult
            let childrenPrice = package.ragular_price * 0.5 * booking.children;  // Halve the price for each child
            let subtotal = adultPrice + childrenPrice; // Total price from adults and children

            // Tax and travel charge
            let tax = subtotal * 0.18; // 18% tax
            let travelCharge = 500; // Travel charge
            let totalPrice = subtotal + tax + travelCharge; // Final total price including tax and travel charge

            // Update the HTML with the calculated values
            document.getElementById('subtotal').textContent = `₹${subtotal}`;
            document.getElementById('tax').textContent = `₹${tax}`;
            document.getElementById('total-price').textContent = `₹${totalPrice}`;
            document.getElementById('all-destinations-total').textContent = `₹${subtotal}`;
        }

        // Function to render the booking details on the page
        function renderBookingDetails() {
            const destinationList = document.getElementById('destination-list');
            destinationList.innerHTML = ''; // Clear previous content

            const bookingTotal = package.ragular_price * (booking.adults + booking.children);

            const div = document.createElement('div');
            div.classList.add('destination-item');
            div.innerHTML = `
                <div class="destination-details">
                    <p class="text-sm text-gray-600"><b>Package:</b> ${package.package_name}</p>
                    <p class="text-sm text-gray-600"><b>Duration:</b> ${package.duration}</p>
                    <p class="text-sm text-gray-600"><b>Start Date:</b> ${package.start_date}</p>
                    <p class="text-sm text-gray-600"><b>End Date:</b> ${package.end_date}</p>
                    <p class="text-sm text-gray-600"><b>Name:</b> ${booking.full_name}</p>
                    <p class="text-sm text-gray-600"><b>Phone no.:</b> ${booking.phone}</p>
                    <p class="text-sm text-gray-600"><b>E-mail:</b> ${booking.email}</p>
                    <p class="text-sm text-gray-600"><b>Adults:</b> ${booking.adults}</p>
                    <p class="text-sm text-gray-600"><b>Children:</b> ${booking.children}</p>
                    <p class="text-sm text-gray-600"><b>Travel Date:</b> ${booking.travel_date}</p>
                    <div class="mt-4">
                        <p class="font-semibold text-gray-800">Total Price: ₹${bookingTotal}</p>
                    </div>
                </div>
                 <img src="/uploads/packages/${package.photo}" alt="${package.package_name}">
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
