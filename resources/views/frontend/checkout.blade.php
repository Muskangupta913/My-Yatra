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

        .details-card,
        .summary-card {
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

        .total-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2c3e50;
        }

        .summary-label {
            font-size: 0.875rem;
            color: #000000;
        }

        @media (min-width: 640px) {
            .checkout-container {
                flex-wrap: nowrap;
            }

            .details-card,
            .summary-card {
                width: calc(50% - 0.75rem);
            }
        }

        @media (min-width: 1024px) {
            .checkout-container {
                max-width: 1200px;
                margin: 2rem auto;
            }

            .details-card {
                flex: 2;
            }

            .summary-card {
                flex: 1;
            }
        }
    </style>
</head>

<body>
    <div id="cart-items" class="checkout-container"></div>
    <div class="summary-card">
        <p>Subtotal: <span id="subtotal">₹0.00</span></p>
        <p>Tax: <span id="tax">₹0.00</span></p>
        <p>Travel Charge: ₹500.00</p>
        <p class="total-price">Total: <span id="total-price">₹0.00</span></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetchCartItems() {
            $.ajax({
                url: '/cart/items',
                method: 'GET',
                success: function (cartItems) {
                    if (cartItems.length === 0) {
                        $('#cart-items').html('<p>Your cart is empty.</p>');
                        updatePriceSummary(0);
                        return;
                    }

                    let itemsHTML = '';
                    let subtotal = 0;

                    $.each(cartItems, function (index, item) {
                        const pkg = item.package; // Access the package object from the response
                        const price = parseFloat(pkg.offer_price || pkg.regular_price); // Use offer price or regular price
                        subtotal += price;

                        itemsHTML += `
                            <div class="destination-item">
                                <div class="flex items-center gap-4">
                                    <img src="/uploads/packages/${pkg.photo}" alt="${pkg.package_name}" class="w-24 h-24 rounded-lg">
                                    <div>
                                        <h4 class="text-lg font-semibold">${pkg.package_name}</h4>
                                        <p class="text-sm text-gray-600">Duration: ${pkg.duration}</p>
                                        <p class="text-sm text-gray-600">Start Date: ${pkg.start_date}</p>
                                        <p class="text-sm text-gray-600">End Date: ${pkg.end_date}</p>
                                        <p class="text-sm text-gray-600 font-bold">Price: ₹${price.toFixed(2)}</p>
                                        
                                        <!-- Number of Adults and Children Input Fields -->
                                        <div class="flex gap-4 mt-2">
                                            <div>
                                                <label for="adults-${item.id}">Adults:</label>
                                                <input type="number" id="adults-${item.id}" value="${item.booking ? item.booking.adults : 1}" min="1">
                                            </div>
                                            <div>
                                                <label for="children-${item.id}">Children:</label>
                                                <input type="number" id="children-${item.id}" value="${item.booking ? item.booking.children : 0}" min="0">
                                            </div>
                                        </div>

                                        <!-- Update Button -->
                                        <button onclick="updateCartItem(${item.id}, ${pkg.id})" class="mt-2 bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                                            Update
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                    <p class="font-semibold text-gray-800">Total: ₹${price.toFixed(2)}</p>
                                    <i class="fas fa-trash text-red-600 cursor-pointer" onclick="removeCartItem(${item.id})"></i>
                                </div>
                            </div>
                            <hr class="my-4">
                        `;
                    });

                    $('#cart-items').html(itemsHTML);
                    updatePriceSummary(subtotal);
                },
                error: function (error) {
                    console.error('Error fetching cart items:', error);
                    alert('Failed to fetch cart items. Please try again.');
                }
            });
        }

        function updatePriceSummary(subtotal) {
            const tax = subtotal * 0.18; // Assuming 18% tax
            const travelCharge = 500;
            const total = subtotal + tax + travelCharge;

            $('#subtotal').text(`₹${subtotal.toFixed(2)}`);
            $('#tax').text(`₹${tax.toFixed(2)}`);
            $('#total-price').text(`₹${total.toFixed(2)}`);
        }

        // Send the updated adults and children values
function updateCartItem(cartId, packageId) {
    const adults = $(`#adults-${cartId}`).val();
    const children = $(`#children-${cartId}`).val();

    $.ajax({
        url: `/cart/update/${cartId}`,
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            adults: adults,
            children: children,
        },
        success: function(response) {
            if (response.success) {
                alert('Booking updated successfully!');
                fetchCartItems();  // Refresh the cart items after update
            } else {
                alert('Failed to update booking: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert('An error occurred while updating the cart item.');
            console.log(error);
        }
    });
}


        function removeCartItem(id) {
            $.ajax({
                url: `/cart/remove/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        fetchCartItems();
                        console.log('Item removed successfully');
                    } else {
                        console.error('Failed to remove cart item:', response.message);
                    }
                },
                error: function(xhr) {
                    console.error('Error removing cart item:', xhr.responseText);
                }
            });
        }

        $(document).ready(function() {
            fetchCartItems(); // Fetch and display cart items on page load
        });
    </script>
</body>

</html>
