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
            background-color: #f1f3f6;
        }
        .checkout-container {
            display: flex;
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .details-card, .summary-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 1.5rem;
            border-radius: 0.5rem;
        }
        .summary-card {
            max-width: 450px;
        }
        .checkout-button {
            background-color: #fb641b;
            transition: background-color 0.3s ease, transform 0.3s ease;
            font-size: 1.125rem;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .checkout-button:hover {
            background-color: #d23f07;
            transform: scale(1.05);
        }
        .details-label {
            font-weight: 600;
            color: #212121;
        }
        .details-value {
            color: #757575;
            font-weight: 500;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: flex-end;
        }
        .quantity-control button {
            background-color: #e0e0e0;
            color: #333;
            font-weight: bold;
            width: 2rem;
            height: 2rem;
            border-radius: 0.25rem;
            border: none;
            cursor: pointer;
        }
        .quantity-control input {
            width: 3rem;
            text-align: center;
            border: none;
            font-weight: bold;
        }
        .destination-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 1rem;
            border-bottom: 1px solid #e0e0e0;
        }
        .destination-item i {
            cursor: pointer;
            color: #ff4d4d;
        }
        .destination-details {
            font-size: 0.875rem;
            color: #757575;
        }
        .summary-label {
            font-size: 0.875rem;
        }
        .quantity-wrapper {
            display: flex;
            justify-content: flex-end;
        }
        .summary-card hr {
            margin: 1rem 0;
            border-color: #e0e0e0;
        }
        .total-price {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
        }
        .details-card hr {
            border-color: #e0e0e0;
            margin: 1rem 0;
        }
    </style>
</head>
<body>
    <div class="max-w-6xl mx-auto checkout-container">
        <!-- Left Section (Vacation Details) -->
        <div class="details-card flex-1">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Vacation Details</h2>

            <!-- Destinations Selection -->
            <div id="destination-list">
                <!-- Destination items will be dynamically added here -->
            </div>

            <hr>

            <div class="quantity-wrapper">
                <!-- Example for Adults/Children controls, will be repeated dynamically -->
            </div>
        </div>

        <!-- Right Section (Price Summary) -->
        <div class="summary-card">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Price Summary</h3>

            <!-- Price Breakdown for each destination -->
            <div id="price-summary">
                <!-- Price items will be dynamically added here -->
            </div>
            
            <hr>

            <!-- Subtotal -->
            <div class="flex justify-between items-center mt-4">
                <p class="summary-label">Subtotal:</p>
                <p id="subtotal" class="details-value">₹0</p>
            </div>
            
            <!-- Tax -->
            <div class="flex justify-between items-center mt-2">
                <p class="summary-label">Tax (10%):</p>
                <p id="tax" class="details-value">₹0</p>
            </div>

            <!-- Travel Charge -->
            <div class="flex justify-between items-center mt-2">
                <p class="summary-label">Travel Charge:</p>
                <p id="travel-charge" class="details-value">₹500</p>
            </div>

            <!-- Total Price -->
            <div class="flex justify-between items-center mt-4 border-t-2 border-gray-200 pt-2">
                <p class="total-price">Total Price:</p>
                <p id="total-price" class="total-price">₹0</p>
            </div>

            <!-- Payment Button -->
            <a href="{{ route('payment') }}" class="nav-link">
            <button type="submit" class="checkout-button w-full py-4 text-white rounded-lg mt-4">
                <i class="fas fa-check-circle mr-2"></i> Proceed to Pay
            </button>
    </a>
        </div>
    </div>

    <script>
        let destinations = [
            { name: 'Maldives', price: 2000, adults: 2, children: 2, budget: 2500, duration: '7 Days', theme: 'Beach & Relaxation' },
            { name: 'Hawaii', price: 3000, adults: 2, children: 2, budget: 3000, duration: '10 Days', theme: 'Adventure & Nature' },
            { name: 'Bali', price: 1500, adults: 2, children: 2, budget: 1500, duration: '5 Days', theme: 'Cultural & Heritage' },
        ];

        let selectedDestinations = [];

        function addDestination(index) {
            const destination = destinations[index];
            selectedDestinations.push(destination);
            updatePriceSummary();
            renderDestinationList();
        }

        function removeDestination(index) {
            selectedDestinations.splice(index, 1);
            updatePriceSummary();
            renderDestinationList();
        }

        function updatePriceSummary() {
            let subtotal = selectedDestinations.reduce((sum, dest) => sum + (dest.price * dest.adults) + (dest.price * dest.children), 0);
            let tax = subtotal * 0.1; // 10% tax
            let travelCharge = 500;
            let totalPrice = subtotal + tax + travelCharge;

            document.getElementById('subtotal').textContent = `₹${subtotal}`;
            document.getElementById('tax').textContent = `₹${tax}`;
            document.getElementById('total-price').textContent = `₹${totalPrice}`;
        }

        function renderDestinationList() {
            const destinationList = document.getElementById('destination-list');
            const priceSummary = document.getElementById('price-summary');
            destinationList.innerHTML = '';
            priceSummary.innerHTML = '';

            selectedDestinations.forEach((destination, index) => {
                // Add destination to the list
                const div = document.createElement('div');
                div.classList.add('destination-item');
                div.innerHTML = `
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700">${destination.name}</h4>
                        <div class="destination-details">
                            <p><strong>Budget:</strong> ₹${destination.budget}</p>
                            <p><strong>Duration:</strong> ${destination.duration}</p>
                            <p><strong>Theme:</strong> ${destination.theme}</p>
                            <p><strong>Adults:</strong></p>
                        </div>
                        <div class="quantity-control">
                            <button onclick="decreaseQuantity(${index}, 'adults')">-</button>
                            <input type="text" id="adults-${index}" class="details-value" value="${destination.adults}" readonly>
                            <button onclick="increaseQuantity(${index}, 'adults')">+</button>
                        </div>
                        <p><strong>Children:</strong></p>
                        <div class="quantity-control">
                            <button onclick="decreaseQuantity(${index}, 'children')">-</button>
                            <input type="text" id="children-${index}" class="details-value" value="${destination.children}" readonly>
                            <button onclick="increaseQuantity(${index}, 'children')">+</button>
                        </div>
                    </div>
                    <i class="fas fa-trash" onclick="removeDestination(${index})"></i>
                `;
                destinationList.appendChild(div);

                // Add destination price to the price summary
                const priceDiv = document.createElement('div');
                priceDiv.classList.add('flex', 'justify-between', 'items-center', 'mb-2');
                priceDiv.innerHTML = `
                    <p class="summary-label">${destination.name}:</p>
                    <p class="details-value">₹${destination.price * destination.adults + destination.price * destination.children}</p>
                `;
                priceSummary.appendChild(priceDiv);
            });
        }

        function increaseQuantity(index, type) {
            const input = document.getElementById(`${type}-${index}`);
            input.value = parseInt(input.value) + 1;
            selectedDestinations[index][type] += 1; // Update the destination data
            updatePriceSummary();
        }

        function decreaseQuantity(index, type) {
            const input = document.getElementById(`${type}-${index}`);
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
                selectedDestinations[index][type] -= 1; // Update the destination data
                updatePriceSummary();
            }
        }

        // Example of adding destinations to the list initially
        addDestination(0); // Add Maldives
        addDestination(1); // Add Hawaii
    </script>
</body>
</html>
