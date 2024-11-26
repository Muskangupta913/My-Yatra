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
    background-image: 
        url('{{ asset("assets/images/backg.webp") }}');/* Replace with your image URL */
        /* linear-gradient(to right, #6dd5fa, #2980b9); */
    background-size: cover; /* Ensures the image covers the entire body */
    background-blend-mode: overlay; /* Combines the image and gradient */
    /* filter: blur(5px); /Adjust the blur intensity as needed */
    min-height: 100vh;
    font-family: 'Arial', sans-serif;
}

.checkout-container {
    display: flex;
    flex-wrap: wrap; /* Allow wrapping for smaller screens */
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
    width: 100%; /* Default width for smaller screens */
}

.summary-card {
    max-width: 450px;
    margin: 0 auto; /* Center align summary card on small screens */
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
    color: ##000000;;
}

.details-card hr, .summary-card hr {
    margin: 1rem 0;
    border-color: #ddd;
}

/* Responsive Design */
@media (min-width: 640px) {
    /* Small screens (e.g., phones in landscape mode) */
    .checkout-container {
        flex-wrap: nowrap; /* Single row layout for small screens */
    }
    .details-card, .summary-card {
        width: calc(50% - 0.75rem); /* Equal width for details and summary */
    }
}

@media (min-width: 1024px) {
    /* Large screens (e.g., laptops) */
    .checkout-container {
        max-width: 1200px;
        margin: 2rem auto;
    }
    .details-card {
        flex: 2; /* Larger space for details card */
    }
    .summary-card {
        flex: 1; /* Smaller space for summary card */
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
        let destinations = [
            { name: 'Maldives', price: 2000, adults: 0, children: 0, budget: 2500, duration: '7 Days', theme: 'Beach & Relaxation' },
            { name: 'Hawaii', price: 3000, adults: 0, children: 0, budget: 3000, duration: '10 Days', theme: 'Adventure & Nature' },
            { name: 'Bali', price: 1500, adults: 0, children: 0, budget: 1500, duration: '5 Days', theme: 'Cultural & Heritage' },
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
    let subtotal = selectedDestinations.reduce(
        (sum, dest) => sum + dest.price * (dest.adults + dest.children),
        0
    );
    let tax = subtotal * 0.1;
    let travelCharge = 500;
    let totalPrice = subtotal + tax + travelCharge;

    document.getElementById('subtotal').textContent = `₹${subtotal}`;
    document.getElementById('tax').textContent = `₹${tax}`;
    document.getElementById('total-price').textContent = `₹${totalPrice}`;

    // Calculate the total price of all destinations
    const totalAllDestinations = selectedDestinations.reduce(
        (sum, dest) => sum + dest.price * (dest.adults + dest.children),
        0
    );
    document.getElementById('all-destinations-total').textContent = `₹${totalAllDestinations}`;
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
