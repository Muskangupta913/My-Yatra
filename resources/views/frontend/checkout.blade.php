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
    background-image: linear-gradient(to right, #6dd5fa, #2980b9);
    min-height: 100vh;
    font-family: 'Arial', sans-serif;
    padding: 0;
    margin: 0;
}

.checkout-container {
    display: flex;
    flex-wrap: wrap; /* Allows stacking on smaller screens */
    gap: 1.5rem;
    margin-top: 2rem;
    justify-content: space-between;
    padding: 0 1rem; /* Padding for smaller screens */
}

.details-card, .summary-card {
    background-color: #ffffff;
    border: 1px solid #e0e0e0;
    padding: 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    flex: 1;
    min-width: 300px; /* Minimum width for smaller screens */
    max-width: 100%; /* Ensures full width on smaller screens */
}

.summary-card {
    max-width: 450px;
    width: 100%;
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
    position: relative;
    border: 1px solid #e0e0e0;
    padding: 1rem;
    border-radius: 0.75rem;
    background-color: #f8f9fa;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 1rem;
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

.quantity-control button {
    background-color: #3498db;
    color: #fff;
    font-weight: bold;
    border: none;
    width: 2rem;
    height: 2rem;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.quantity-control button:hover {
    background-color: #2980b9;
}

.quantity-control input {
    width: 3rem;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 0.25rem;
    font-weight: bold;
    margin: 0 0.5rem;
}

.total-price {
    font-size: 1.5rem;
    font-weight: bold;
    color: #2c3e50;
}

.summary-label {
    font-size: 0.875rem;
    color: #7f8c8d;
}

.details-card hr, .summary-card hr {
    margin: 1rem 0;
    border-color: #ddd;
}

/* Responsive Design */
@media (max-width: 768px) {
    .checkout-container {
        flex-direction: column; /* Stack vertically on smaller screens */
        padding: 0 1rem;
    }

    .details-card, .summary-card {
        max-width: 100%;
        flex: 1;
        margin-bottom: 2rem; /* Add margin between the cards */
    }

    .checkout-button {
        font-size: 1rem; /* Adjust button size on small screens */
    }

    .destination-item {
        padding: 1rem;
    }
}

@media (max-width: 480px) {
    .checkout-container {
        padding: 0 0.5rem; /* Smaller padding on extra small screens */
    }

    .details-card, .summary-card {
        padding: 1rem; /* Reduce padding on small screens */
    }

    .checkout-button {
        font-size: 0.9rem;
        padding: 0.75rem; /* Adjust button size for small screens */
    }

    .destination-item {
        padding: 0.75rem; /* Adjust destination item padding */
    }

    .quantity-control button {
        width: 1.5rem;
        height: 1.5rem; /* Make buttons smaller */
    }

    .quantity-control input {
        width: 2.5rem; /* Adjust input field width */
    }
}
</style>
</head>
<body>
    <div class="max-w-7xl mx-auto checkout-container">
        <!-- Left Section (Vacation Details) -->
        <div class="details-card flex-1">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Vacation Details</h2>
            <div id="destination-list"></div>
            <hr>
            <div class="flex justify-between items-center mt-2">
    <p class="summary-label" ><b>Total Price for All Destinations:</p>
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
                <p class="summary-label">Tax (10%):</p>
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
            <button type="submit" class="checkout-button w-full py-3 text-white rounded-lg mt-4">
                <i class="fas fa-check-circle mr-2"></i> Proceed to Pay
            </button>
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
            selectedDestinations.push(destinations[index]);
            renderDestinationList();
            updatePriceSummary();
        }

        function removeDestination(index) {
            selectedDestinations.splice(index, 1);
            renderDestinationList();
            updatePriceSummary();
        }

        function updatePriceSummary() {
    let subtotal = selectedDestinations.reduce((sum, dest) => sum + (dest.price * dest.adults + dest.price * dest.children), 0);
    let tax = subtotal * 0.1;
    let travelCharge = 500;
    let totalPrice = subtotal + tax + travelCharge;

    // Calculate the total price for all selected destinations
    let allDestinationsTotal = selectedDestinations.reduce((sum, dest) => sum + (dest.price * dest.adults + dest.price * dest.children), 0);

    // Update the individual price summary
    document.getElementById('subtotal').textContent = `₹${subtotal}`;
    document.getElementById('tax').textContent = `₹${tax}`;
    document.getElementById('total-price').textContent = `₹${totalPrice}`;

    // Update the total price for all selected destinations
    document.getElementById('all-destinations-total').textContent = `₹${allDestinationsTotal}`;
}

        function renderDestinationList() {
    const destinationList = document.getElementById('destination-list');
    destinationList.innerHTML = '';

    selectedDestinations.forEach((destination, index) => {
        // Calculate the total price for the current destination
        const destinationTotal = (destination.price * destination.adults) + (destination.price * destination.children);

        const div = document.createElement('div');
        div.classList.add('destination-item');
        div.innerHTML = `
            <div>
                <h4 class="text-lg font-semibold">${destination.name}</h4>
                <p class="text-sm text-gray-600">Budget: ₹${destination.budget} | Duration: ${destination.duration} | Theme: ${destination.theme}</p>
                <div class="flex items-center mt-2">
                    <p>Adults: </p>
                    <div class="quantity-control ml-auto">
                        <button onclick="updateQuantity(${index}, 'adults', -1)">-</button>
                        <input type="text" value="${destination.adults}" readonly>
                        <button onclick="updateQuantity(${index}, 'adults', 1)">+</button>
                    </div>
                </div>
                <div class="flex items-center mt-2">
                    <p>Children: </p>
                    <div class="quantity-control ml-auto">
                        <button onclick="updateQuantity(${index}, 'children', -1)">-</button>
                        <input type="text" value="${destination.children}" readonly>
                        <button onclick="updateQuantity(${index}, 'children', 1)">+</button>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="font-semibold text-gray-800">Total Price: ₹<span id="destination-total-${index}">${destinationTotal}</span></p>
                </div>
            </div>
            <i class="fas fa-trash" onclick="removeDestination(${index})"></i>
            
        `;
        destinationList.appendChild(div);
    });
}



function updateQuantity(index, type, change) {
    selectedDestinations[index][type] += change;
    if (selectedDestinations[index][type] < 0) selectedDestinations[index][type] = 0;

    // Recalculate the destination total and update the DOM
    const destinationTotal = (selectedDestinations[index].price * selectedDestinations[index].adults) + 
                             (selectedDestinations[index].price * selectedDestinations[index].children);
    document.getElementById(`destination-total-${index}`).textContent = destinationTotal;
     // Update the input field for the quantity
     renderDestinationList();

// Update the overall price summary
    updatePriceSummary();
}

        // Initialize
        addDestination(0);
        addDestination(1);
    </script>
</body>
</html>
