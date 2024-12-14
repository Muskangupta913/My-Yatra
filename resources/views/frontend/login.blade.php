<button class="btn btn-outline-danger rounded-0 add-to-cart" data-id="${item.id}">Add To Cart</button>
public function loginshow(){
    return view('auth.login');
}

public function login(Request $request){
   
    
    $validateData=$request->validate([
        'email'=>'require|email',
        'password'=>'require|min6,
        ]);
    
        if(Auth::attempt(['email' =>$request ->email, 'password' => $request->password], $request->remember)){
            return redirect()->intended('/dashboard');
        }
        return back()->withErrors([
            'email'=>'The provided crendentials do not match'])->withInput($request ->only('email', 'remember'))
        }
lets discusse the difference between mern stack and laravel , php so lets start from here . mern stack is a combination of react , node js , express js , mongodb 
where as php and laravel is differet language meanwhile the function of both of them is similar only the term and condition make them different is syntax of <code class="so lets disscuss each of lang"></code>

react js - it is used for building client side application ehich helps to make a website single page web application
node js - it is java script run time envirnment l
    
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
    <title>Vacation Booking Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <style>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    
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
                        const basePrice = parseFloat(pkg.offer_price || pkg.regular_price);

                        // Default to 1 adult and 0 children if not defined
                        const adults = item.booking ? item.booking.adults || 1 : 1;
                        const children = item.booking ? item.booking.children || 0 : 0;

                        // Calculate dynamic price based on adults and children
                        const totalPrice = basePrice * (adults * 2 + children * 0.5);
                        subtotal += totalPrice;

                        itemsHTML += `
                            <div class="destination-item flex items-start gap-4">
                                <img src="/uploads/packages/${pkg.photo}" alt="${pkg.package_name}">
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold">${pkg.package_name}</h4>
                                    <p class="text-sm text-gray-600">Duration: ${pkg.duration}</p>
                                    <p class="text-sm text-gray-600">Start Date: ${pkg.start_date}</p>
                                    <p class="text-sm text-gray-600">Base Price: ₹${basePrice.toFixed(2)}</p>
                                    <p class="text-sm text-gray-600 font-bold">Total Price: ₹${totalPrice.toFixed(2)}</p>
                                    <div class="flex gap-4 mt-2">
                                        <div>
                                            <label >Adults:</label>
                                            <input type="number" id="adults-${item.id}" value="${booking.adults || 1}"  min="1" data-base-price="${basePrice}"
                                            onchange="previewPrice(${item.id})">
                                        </div>
                                        <div>
                                            <label >Children:</label>
                                            <input type="number" id="children-${item.id}" value="${booking.children || 0}"  min="0" data-base-price="${basePrice}"
                                            onchange="previewPrice(${item.id})">
                                        </div>

                                        <p class="text-lg font-semibold">
                                        Item Total: <span id="price-${item.id}" class="text-blue-600">
                                            ₹${calculateItemPrice(basePrice, booking.adults || 1, booking.children || 0).toFixed(2)}
                                        </span>
                                    </p>
                                        <button class="mt-2 bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600" 
                                        onclick="updateCartItem(${item.id})">
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

        function recalculateItem(cartId, basePrice) {
            // Recalculate total price for an individual item
            const adults = $(#adults-${cartId}).val();
            const children = $(#children-${cartId}).val();
            const totalPrice = basePrice * (adults * 2 + children * 0.5);

            // Update subtotal
            let subtotal = 0;
            $('.destination-item').each(function () {
                const itemId = $(this).find('input[type="number"]').attr('id').split('-')[1];
                if (itemId == cartId) {
                    $(this).find('.font-bold').text(Total Price: ₹${totalPrice.toFixed(2)});
                }
                subtotal += totalPrice;
            });

            updatePriceSummary(subtotal);
        }

        function updatePriceSummary(subtotal) {
            const tax = subtotal * 0.18;
            const travelCharge = 500;
            const total = subtotal + tax + travelCharge;

            $('#subtotal').text(₹${subtotal.toFixed(2)});
            $('#tax').text(₹${tax.toFixed(2)});
            $('#total-price').text(₹${total.toFixed(2)});
        }

        function updateCartItem(cartId, packageId) {
            const adults = $(#adults-${cartId}).val();
            const children = $(#children-${cartId}).val();

            $.ajax({
                url: /cart/update/${cartId},
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
                }
            });
        }

        function removeCartItem(cartId) {
    $.ajax({
        url: /cart/remove/${cartId},
        method: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                toastr.success('Item removed from cart successfully!'); // Show Toastr notification
                fetchCartItems();
            } else {
                toastr.error('Failed to remove item: ' + response.message);
            }
        },
        error: function () {
            toastr.error('An error occurred while removing the item.');
        }
    });
}

toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-center",
    "preventDuplicates": true,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "1000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};


        // Fetch cart items on page load
        $(document).ready(function () {
            fetchCartItems();
        });
    </script>
</body>

</html>