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
            background-color: #f9fafb;
            font-family: 'Arial', sans-serif;
        }

        .checkout-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin: 2rem auto;
            padding: 1rem;
            max-width: 1200px;
        }

        .details-card,
        .summary-card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            padding: 1.5rem;
            border-radius: 1rem;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .details-card {
            flex: 2;
        }

        .summary-card {
            flex: 1;
            margin-top: 2rem;
        }

        .destination-item {
            border: 1px solid #e5e7eb;
            padding: 1rem;
            border-radius: 0.75rem;
            background-color: #f8fafc;
            margin-bottom: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .destination-item img {
            border-radius: 0.5rem;
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .destination-item .remove-item {
            cursor: pointer;
            color: #e74c3c;
            font-size: 1.25rem;
            transition: color 0.3s ease;
        }

        .destination-item .remove-item:hover {
            color: #c0392b;
        }

        .checkout-button {
            background-color: #f39c12;
            color: white;
            font-size: 1.125rem;
            font-weight: bold;
            padding: 0.75rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .checkout-button:hover {
            background-color: #d35400;
            transform: scale(1.05);
        }

        .summary-label {
            font-size: 1rem;
            font-weight: 500;
        }

        .summary-value {
            font-weight: bold;
            color: #2c3e50;
        }

        .total-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2c3e50;
        }
    </style>
</head>

<body>
    <div class="checkout-container">
        <!-- Cart Items -->
        <div id="cart-items" class="details-card"></div>

        <!-- Summary -->
        <div class="summary-card">
            <p class="summary-label">Subtotal: <span id="subtotal" class="summary-value">₹0.00</span></p>
            <p class="summary-label">Tax (18%): <span id="tax" class="summary-value">₹0.00</span></p>
            <p class="summary-label">Travel Charge: <span class="summary-value">₹500.00</span></p>
            <hr class="my-4">
            <p class="total-price">Total: <span id="total-price">₹0.00</span></p>
            <button type="button" class="checkout-button mt-4" onclick="window.location.href='{{ route('payment') }}'">
                <i class="fas fa-check-circle mr-2"></i> Proceed to Pay
            </button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetchCartItems() {
            $.ajax({
                url: '/cart/items',
                method: 'GET',
                success: function (cartItems) {
                    if (cartItems.length === 0) {
                        $('#cart-items').html('<p class="text-gray-500">Your cart is empty.</p>');
                        updatePriceSummary(0);
                        return;
                    }

                    let itemsHTML = '';
                    let subtotal = 0;

                    $.each(cartItems, function (index, item) {
                        const pkg = item.package; // Access the package object
                        const price = parseFloat(pkg.offer_price || pkg.regular_price);
                        subtotal += price;

                        itemsHTML += `
                            <div class="destination-item flex items-start gap-4">
                                <img src="/uploads/packages/${pkg.photo}" alt="${pkg.package_name}">
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold">${pkg.package_name}</h4>
                                    <p class="text-sm text-gray-600">Duration: ${pkg.duration}</p>
                                    <p class="text-sm text-gray-600">Start Date: ${pkg.start_date}</p>
                                    <p class="text-sm text-gray-600">Price: ₹${price.toFixed(2)}</p>
                                    <div class="flex gap-4 mt-2">
                                        <div>
                                            <label for="adults-${item.id}">Adults:</label>
                                            <input type="number" id="adults-${item.id}" value="${item.booking ? item.booking.adults : 1}" min="1">
                                        </div>
                                        <div>
                                            <label for="children-${item.id}">Children:</label>
                                            <input type="number" id="children-${item.id}" value="${item.booking ? item.booking.children : 0}" min="0">
                                        </div>
                                        <button class="mt-2 bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600" 
                                        onclick="updateCartItem(${item.id}, ${pkg.id})">
                                        Update
                                    </button>
                                    </div>
                                    
                                </div>
                                <i class="fas fa-trash remove-item" onclick="removeCartItem(${item.id})"></i>
                            </div>`;
                    });

                    $('#cart-items').html(itemsHTML);
                    updatePriceSummary(subtotal);
                },
                error: function () {
                    alert('Failed to fetch cart items. Please try again.');
                }
            });
        }

        function updatePriceSummary(subtotal) {
            const tax = subtotal * 0.18;
            const travelCharge = 500;
            const total = subtotal + tax + travelCharge;

            $('#subtotal').text(`₹${subtotal.toFixed(2)}`);
            $('#tax').text(`₹${tax.toFixed(2)}`);
            $('#total-price').text(`₹${total.toFixed(2)}`);
        }

        function updateCartItem(cartId, packageId) {
            const adults = $(`#adults-${cartId}`).val();
            const children = $(`#children-${cartId}`).val();

            $.ajax({
                url: `/cart/update/${cartId}`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    adults: adults,
                    children: children
                },
                success: function (response) {
                    if (response.success) {
                        alert('Booking updated successfully!');
                        fetchCartItems();
                    } else {
                        alert('Failed to update booking: ' + response.message);
                    }
                },
                error: function () {
                    alert('An error occurred while updating the cart item.');
                }
            });
        }

        function removeCartItem(id) {
            $.ajax({
                url: `/cart/remove/${id}`,
                type: 'DELETE',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function (response) {
                    if (response.success) {
                        fetchCartItems();
                    } else {
                        alert('Failed to remove cart item.');
                    }
                },
                error: function () {
                    alert('Error removing cart item.');
                }
            });
        }

        $(document).ready(fetchCartItems);
    </script>
</body>

</html>
