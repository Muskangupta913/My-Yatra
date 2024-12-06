<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vacation Booking Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
        /* Previous styles remain the same */
        body {
            background-color: #f9fafb;
            background-image: linear-gradient(rgba(0, 0, 0, 0.533), rgba(0, 0, 0, 0.511)), url('{{ asset("assets/images/goa-about-img.jpg") }}');
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

        .details-card { flex: 2; }
        .summary-card { flex: 1; margin-top: 2rem; }

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

        .price-update {
            animation: highlight 1s ease-in-out;
        }

        @keyframes highlight {
            0% { background-color: #ffd700; }
            100% { background-color: transparent; }
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <div id="cart-items" class="details-card"></div>
        <div class="summary-card">
            <p class="summary-label">Subtotal: <span id="subtotal" class="summary-value">₹0.00</span></p>
            <p class="summary-label">Tax (18%): <span id="tax" class="summary-value">₹0.00</span></p>
            <p class="summary-label">Travel Charge: <span id="travel-charge" class="summary-value">₹500.00</span></p>
            <hr class="my-4">
            <p class="total-price">Total: <span id="total-price">₹0.00</span></p>
            <button type="button" class="checkout-button mt-4" onclick="window.location.href='{{ route('payment') }}'">
                <i class="fas fa-check-circle mr-2"></i> Proceed to Pay
            </button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    
    <script>
        let cartItemsData = [];

        function calculateItemPrice(basePrice, adults, children) {
            const adultPrice = basePrice * 2 * adults;
            const childrenPrice = basePrice * 0.5 * children;
            return adultPrice + childrenPrice;
        }

        function fetchCartItems() {
            $.ajax({
                url: '/cart/items',
                method: 'GET',
                success: function(response) {
                    cartItemsData = response.cartItems;
                    renderCartItems(cartItemsData);
                    calculateAndUpdateTotals();
                },
                error: function() {
                    toastr.error('Failed to fetch cart items');
                }
            });
        }

        function renderCartItems(items) {
            if (items.length === 0) {
                $('#cart-items').html('<p class="text-gray-500">Your cart is empty.</p>');
                return;
            }

            let html = '';
            items.forEach(item => {
                const pkg = item.package;
                const booking = item.booking || { adults: 1, children: 0 };
                const basePrice = parseFloat(pkg.offer_price || pkg.ragular_price);
                
                html += `
                    <div class="destination-item" id="item-${item.id}">
                        <div class="flex items-start gap-4">
                            <img src="/uploads/packages/${pkg.photo}" alt="${pkg.package_name}" class="w-24 h-24 object-cover rounded">
                            <div class="flex-1">
                                <h4 class="text-lg font-semibold">${pkg.package_name}</h4>
                                 <p class="text-sm text-gray-600">Duration: ${pkg.duration}</p>
                        <p class="text-sm text-gray-600">Start Date: ${pkg.start_date}</p>
                                <p class="text-gray-600">Base Price: ₹${basePrice.toFixed(2)}</p>
                                <div class="flex flex-wrap gap-4 mt-3">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700">Adults</label>
                                        <input 
                                            type="number" 
                                            id="adults-${item.id}" 
                                            value="${booking.adults || 1}" 
                                            min="1" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                            data-base-price="${basePrice}"
                                            onchange="previewPrice(${item.id})"
                                        >
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700">Children</label>
                                        <input 
                                            type="number" 
                                            id="children-${item.id}" 
                                            value="${booking.children || 0}" 
                                            min="0" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                                            data-base-price="${basePrice}"
                                            onchange="previewPrice(${item.id})"
                                        >
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p class="text-lg font-semibold">
                                        Item Total: <span id="price-${item.id}" class="text-blue-600">
                                            ₹${calculateItemPrice(basePrice, booking.adults || 1, booking.children || 0).toFixed(2)}
                                        </span>
                                    </p>
                                    <button 
                                        onclick="updateCartItem(${item.id})" 
                                        class="mt-2 px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition"
                                    >
                                        Update Booking
                                    </button>
                                </div>
                                  <i class="fas fa-trash remove-item" onclick="removeCartItem(${item.id})"></i>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#cart-items').html(html);
        }

        function previewPrice(itemId) {
            const adults = parseInt($(`#adults-${itemId}`).val()) || 1;
            const children = parseInt($(`#children-${itemId}`).val()) || 0;
            const basePrice = parseFloat($(`#adults-${itemId}`).data('base-price'));
            
            const newTotal = calculateItemPrice(basePrice, adults, children);
            $(`#price-${itemId}`).text(`₹${newTotal.toFixed(2)}`);
        }

        function removeCartItem(cartId) {
            $.ajax({
                url: `/cart/remove/${cartId}`,
                method: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Item removed from cart ');
                        fetchCartItems(); 
                    } else {
                        toastr.error('Failed to remove item: ' + response.message);
                    }
                },
                error: function() {
                    toastr.error('An error occurred while removing the item.');
                }
            });
        }

        function calculateAndUpdateTotals() {
            let subtotal = 0;
            cartItemsData.forEach(item => {
                const booking = item.booking || { adults: 1, children: 0 };
                const basePrice = parseFloat(item.package.offer_price || item.package.ragular_price);
                subtotal += calculateItemPrice(basePrice, booking.adults, booking.children);
            });

            const tax = subtotal * 0.18; // 18% tax
            const total = subtotal + tax + 500; // Add fixed travel charge of ₹500

            $('#subtotal').text(`₹${subtotal.toFixed(2)}`);
            $('#tax').text(`₹${tax.toFixed(2)}`);
            $('#total-price').text(`₹${total.toFixed(2)}`);
        }
        
        function updateCartItem(itemId) {
            const adults = parseInt($(`#adults-${itemId}`).val());
            const children = parseInt($(`#children-${itemId}`).val());

            if (isNaN(adults) || adults < 1 || isNaN(children) || children < 0) {
                toastr.error('Please enter valid numbers for adults and children');
                return;
            }

            $.ajax({
                url: `/cart/update/${itemId}`,
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    adults: adults,
                    children: children
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Booking updated successfully');
                        // Update the local cart data and recalculate totals
                        const itemIndex = cartItemsData.findIndex(item => item.id === itemId);
                        if (itemIndex !== -1) {
                            cartItemsData[itemIndex].booking = { adults, children };
                            calculateAndUpdateTotals();
                        }
                    } else {
                        toastr.error(response.message || 'Failed to update booking');
                    }
                },
                error: function() {
                    toastr.error('Failed to update booking');
                }
            });
        }


        $(document).ready(function() {
            fetchCartItems();
        });
    </script>
</body>
</html>
