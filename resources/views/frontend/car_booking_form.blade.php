@extends('frontend.layouts.master')

@section('styles')
<style>

:root {
    --primary-color: #4f46e5;
    --primary-light: #eef2ff;
    --secondary-color: #10b981;
    --error-color: #dc2626;
    --border-color: #e5e7eb;
    --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    --radius: 0.5rem;
    --transition: all 0.3s ease;
}

/* Global responsive adjustments */
body {
    font-size: 16px;
    line-height: 1.5;
}

/* Layout containers */
.booking-page {
    max-width: 1200px;
    width: 100%;
    margin: 2rem auto;
    padding: 0 1rem;
}

@media (min-width: 640px) {
    .booking-page {
        padding: 0 1.5rem;
    }
}

/* Header animation */
header h1 {
    font-size: 1.75rem;
    line-height: 1.2;
    position: relative;
    display: inline-block;
}

header h1::after {
    content: '';
    position: absolute;
    width: 50%;
    height: 3px;
    bottom: -8px;
    left: 0;
    background-color: var(--primary-color);
    transition: width 0.3s ease;
}

header h1:hover::after {
    width: 100%;
}

@media (min-width: 768px) {
    header h1 {
        font-size: 2rem;
    }
}

@media (min-width: 1024px) {
    header h1 {
        font-size: 2.25rem;
    }
}

/* Booking grid layout */
.booking-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    margin-top: 1.5rem;
}

@media (min-width: 768px) {
    .booking-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

@media (min-width: 1024px) {
    .booking-grid {
        grid-template-columns: 3fr 2fr;
    }
}

/* Car details section with enhanced styling */
.car-details {
    background: linear-gradient(135deg, #f6f8ff 0%, #ffffff 100%);
    border-radius: var(--radius);
    padding: 1.25rem;
    height: fit-content;
    order: 1;
    box-shadow: var(--shadow);
    border: 1px solid var(--border-color);
    transition: var(--transition);
}

.car-details:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px rgba(79, 70, 229, 0.1);
}

@media (min-width: 768px) {
    .car-details {
        padding: 1.5rem;
    }
}

@media (min-width: 1024px) {
    .car-details {
        position: sticky;
        top: 2rem;
        order: 2;
    }
}

.car-info-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.75rem;
    margin-top: 1rem;
}

@media (min-width: 480px) {
    .car-info-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }
}

/* Car info items with animation */
.car-info-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    padding: 0.75rem;
    border-radius: var(--radius);
    background-color: #ffffff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
    transition: var(--transition);
}

.car-info-item:hover {
    background-color: var(--primary-light);
    transform: translateX(5px);
}

.car-info-item i {
    color: var(--primary-color);
    font-size: 1rem;
    transition: var(--transition);
}

.car-info-item:hover i {
    transform: scale(1.2);
}

@media (min-width: 640px) {
    .car-info-item {
        font-size: 1rem;
    }
}

/* Enhanced Form styles */
.booking-form {
    background: white;
    padding: 1.25rem;
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    order: 2;
    border: 1px solid var(--border-color);
}

@media (min-width: 640px) {
    .booking-form {
        padding: 1.5rem;
    }
}

@media (min-width: 768px) {
    .booking-form {
        padding: 2rem;
    }
}

@media (min-width: 1024px) {
    .booking-form {
        order: 1;
    }
}

/* Form progress indicator */
.form-progress {
    display: flex;
    justify-content: space-between;
    margin-bottom: 2rem;
    position: relative;
}

.form-progress::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background-color: var(--border-color);
    z-index: 1;
}

.progress-step {
    position: relative;
    z-index: 2;
    background-color: white;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--border-color);
    font-weight: bold;
    transition: var(--transition);
}

.progress-step.active {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.progress-step.completed {
    background-color: var(--secondary-color);
    color: white;
    border-color: var(--secondary-color);
}

.progress-step-label {
    position: absolute;
    top: 35px;
    font-size: 0.75rem;
    white-space: nowrap;
    transform: translateX(-50%);
    left: 50%;
}

/* Search summary section with animation */
.search-summary {
    background: #ffffff;
    border-radius: 10px;
    padding: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: var(--transition);
    width: 100%;
    margin: 1rem auto;
    text-align: center;
    border: 1px solid var(--border-color);
}

.search-summary:hover {
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    transform: translateY(-3px);
}

@media (min-width: 640px) {
    .search-summary {
        max-width: 90%;
        padding: 15px;
    }
}

@media (min-width: 768px) {
    .search-summary {
        max-width: 600px;
        padding: 15px 20px;
    }
}

.search-summary .flex {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    align-items: center;
}

@media (min-width: 640px) {
    .search-summary .flex {
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
    }
}

@media (min-width: 1024px) {
    .search-summary .flex {
        flex-wrap: nowrap;
        white-space: nowrap;
    }
}

.search-summary .flex > div {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.search-summary span {
    font-size: 14px;
    font-weight: 500;
}

.search-summary i {
    transition: var(--transition);
}

.search-summary:hover i {
    transform: scale(1.2);
    color: var(--primary-color);
}

@media (min-width: 640px) {
    .search-summary span {
        font-size: 16px;
    }
}

/* Enhanced Form field styling */
.form-group {
    margin-bottom: 1.25rem;
    transition: var(--transition);
}

@media (min-width: 768px) {
    .form-group {
        margin-bottom: 1.5rem;
    }
}

/* Interactive form fields */
.form-control {
    width: 100%;
    padding: 0.625rem;
    border: 1px solid var(--border-color);
    border-radius: var(--radius);
    font-size: 0.875rem;
    transition: var(--transition);
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    outline: none;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    transition: var(--transition);
}

.form-control:focus + .form-label,
.form-control:not(:placeholder-shown) + .form-label {
    color: var(--primary-color);
}

@media (min-width: 640px) {
    .form-control {
        padding: 0.75rem;
        font-size: 1rem;
    }
}

/* Legend in form with animation */
fieldset legend {
    font-size: 1.25rem;
    margin-bottom: 1rem;
    position: relative;
    padding-bottom: 0.5rem;
}

fieldset legend::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background-color: var(--primary-color);
    transition: var(--transition);
}

fieldset:hover legend::after {
    width: 100px;
}

@media (min-width: 768px) {
    fieldset legend {
        font-size: 1.5rem;
        margin-bottom: 1.25rem;
    }
}

/* Enhanced Submit button */
.submit-button {
    width: 100%;
    padding: 0.75rem;
    font-size: 0.875rem;
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: var(--radius);
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}

.submit-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: var(--transition);
}

.submit-button:hover {
    background-color: #4338ca;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.submit-button:hover::before {
    left: 100%;
    transition: 0.7s;
}

@media (min-width: 640px) {
    .submit-button {
        padding: 1rem;
        font-size: 1rem;
    }
}

/* Error messages with animation */
.error-message {
    color: var(--error-color);
    font-size: 0.75rem;
    margin-top: 0.25rem;
    display: block;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    0% {
        opacity: 0;
        transform: translateY(-10px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Checkbox animation */
input[type="checkbox"] {
    appearance: none;
    width: 1.2rem;
    height: 1.2rem;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    position: relative;
    cursor: pointer;
    transition: var(--transition);
}

input[type="checkbox"]:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

input[type="checkbox"]:checked::after {
    content: '✓';
    position: absolute;
    color: white;
    font-size: 0.75rem;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

/* Loading animation for submit button */
.submit-button.loading {
    background-color: #6b7280;
    pointer-events: none;
}

.submit-button.loading::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    top: calc(50% - 10px);
    right: 10px;
    border: 2px solid white;
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Add floating label effect */
.input-floating-label {
    position: relative;
    margin-bottom: 1.5rem;
}

.input-floating-label input,
.input-floating-label textarea {
    width: 100%;
    padding: 1rem 0.75rem 0.5rem;
    border: 1px solid var(--border-color);
    border-radius: var(--radius);
    font-size: 1rem;
    transition: var(--transition);
    background-color: white;
}

.input-floating-label label {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    font-size: 1rem;
    color: #6b7280;
    transition: var(--transition);
    pointer-events: none;
    background-color: transparent;
}

.input-floating-label input:focus,
.input-floating-label textarea:focus,
.input-floating-label input:not(:placeholder-shown),
.input-floating-label textarea:not(:placeholder-shown) {
    border-color: var(--primary-color);
    padding-top: 1.25rem;
}

.input-floating-label input:focus ~ label,
.input-floating-label textarea:focus ~ label,
.input-floating-label input:not(:placeholder-shown) ~ label,
.input-floating-label textarea:not(:placeholder-shown) ~ label {
    transform: translateY(-0.75rem) scale(0.8);
    color: var(--primary-color);
    font-weight: 500;
}

/* Touch-friendly form elements for mobile */
@media (max-width: 640px) {
    input, select, textarea, button {
        font-size: 16px; /* Prevents iOS zoom on focus */
    }
    
    .form-control, .submit-button {
        min-height: 44px; /* Minimum touch target size */
    }
    
    input[type="checkbox"] {
        min-width: 20px;
        min-height: 20px;
    }
}
</style>
@endsection

@section('content')

<!-- Search Summary Section -->
<div class="search-summary bg-white p-4 rounded-lg shadow-sm mb-6">
    <h3 class="text-lg font-semibold mb-3 text-center">Trip Details</h3>
    <div class="flex justify-between items-center text-center flex-wrap gap-4 md:gap-6" id="search-summary">
        <div class="flex gap-2">
            <i class="fas fa-map-marker-alt text-blue-600"></i>
            <span>From: <strong id="pickup-location"></strong> | </span>
            <i class="fas fa-location-arrow text-blue-600"></i>
            <span>To: <strong id="dropoff-location"></strong> | </span>
            <i class="fas fa-calendar-alt text-blue-600"></i>
            <span>Date: <strong id="pickup-date"></strong> | </span>
            <i class="fas fa-exchange-alt text-blue-600"></i>
            <span>Trip Type: <strong id="trip-type"></strong></span>
        </div>
    </div>
</div>
<main class="booking-page">
    <header>
        <h1 class="text-3xl font-bold">Book Your Car</h1>
        <p class="text-gray-600 mt-2">Please fill in your details to complete the booking</p>
    </header>

    <div class="booking-grid">
        <!-- Booking Form Section -->
        <section class="booking-form">
        <form action="{{ route('car.payment') }}" method="POST" id="bookingForm">
                @csrf
                <input type="hidden" name="car_id" id="car-id">
                <input type="hidden" name="car_category" id="car-category-input">
                <input type="hidden" name="car_seating" id="car-seating-input">
                <input type="hidden" name="car_luggage" id="car-luggage-input">
                <input type="hidden" name="car_price" id="car-price-input">
                <input type="hidden" name="pickup_location" id="pickup-location-input">
                <input type="hidden" name="dropoff_location" id="dropoff-location-input">
                <input type="hidden" name="trip_type" id="trip-type-input">
                <input type="hidden" name="trace_id" id="trace_id">
                <input type="hidden" name="srdv_index" id="srdv_index">
                
                <!-- Personal Information -->
                <fieldset class="form-group">
                    <legend class="text-xl font-semibold mb-4">Personal Information</legend>
                    
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-control @error('name') border-red-500 @enderror" 
                               required>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-control @error('email') border-red-500 @enderror" 
                               required>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               class="form-control @error('phone') border-red-500 @enderror" 
                               required>
                        @error('phone')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </fieldset>

                <!-- Booking Details -->
                <fieldset class="form-group">
                    <legend class="text-xl font-semibold mb-4">Booking Details</legend>

                    <div class="form-group">
                        <label for="pickup_address" class="form-label">Pickup Address</label>
                        <textarea id="pickup_address" 
                                  name="pickup_address" 
                                  class="form-control @error('pickup_address') border-red-500 @enderror" 
                                  rows="3" 
                                  required></textarea>
                        @error('pickup_address')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="drop_address" class="form-label">Drop Address</label>
                        <textarea id="drop_address" 
                                  name="drop_address" 
                                  class="form-control @error('drop_address') border-red-500 @enderror" 
                                  rows="3" 
                                  required></textarea>
                        @error('drop_address')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="booking_date" class="form-label">Booking Date</label>
                        <input type="date" 
                               id="booking_date" 
                               name="booking_date" 
                               class="form-control @error('booking_date') border-red-500 @enderror" 
                               required>
                        @error('booking_date')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </fieldset>

                <!-- Terms and Conditions -->
                <div class="form-group">
                    <label class="inline-flex items-center">
                        <input type="checkbox" 
                               id="terms" 
                               name="terms" 
                               class="form-checkbox" 
                               required>
                        <span class="ml-2">I agree to the <a href="#" class="text-primary-600">terms and conditions</a></span>
                    </label>
                    @error('terms')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="submit-button">
                    Confirm Booking
                </button>
            </form>
        </section>

        <!-- Car Details Section -->
        <aside class="car-details">
            <h2 class="text-xl font-semibold mb-4">Selected Vehicle</h2>
            
            <div class="car-info-grid">
                <div class="car-info-item">
                    <i class="fas fa-car"></i>
                    <span>Category: <strong id="car-category"></strong></span>
                </div>
                
                <div class="car-info-item">
                    <i class="fas fa-users"></i>
                    <span>Seats: <strong id="car-seating"></strong></span>
                </div>
                
                <div class="car-info-item">
                    <i class="fas fa-suitcase"></i>
                    <span>Luggage: <strong id="car-luggage"></strong></span>
                </div>
                
                <div class="car-info-item">
                    <i class="fas fa-tag"></i>
                    <span>Price: <strong id="car-price"></strong></span>
                </div>
                <div class="car-info-item">
                    <i class="fas fa-fingerprint"></i>
                    <span>TraceID: <strong id="trace-id-display"></strong></span>
                </div>
                <div class="car-info-item">
                    <i class="fas fa-barcode"></i>
                    <span>SrdvIndex: <strong id="srdv-index-display"></strong></span>
                </div>
            </div>
        </aside>
    </div>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Form elements
    const form = document.getElementById('bookingForm');
    const inputs = form.querySelectorAll('input, textarea');
    const submitButton = form.querySelector('button[type="submit"]');

    // Load stored data
    const carData = JSON.parse(localStorage.getItem("selectedCar") || "{}");
    const searchParams = JSON.parse(localStorage.getItem("searchParams") || "{}");

    // Validation rules
    const validators = {
        name: (value) => value.trim().length >= 3 || 'Name must be at least 3 characters',
        email: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) || 'Please enter a valid email',
        phone: (value) => /^[0-9]{10}$/.test(value) || 'Please enter a valid 10-digit phone number',
        pickup_address: (value) => value.trim().length >= 10 || 'Please enter a detailed pickup address',
        drop_address: (value) => value.trim().length >= 10 || 'Please enter a detailed drop address',
        terms: (checked) => checked || 'You must accept the terms and conditions'
    };

    // Check wallet balance
    async function checkBalance() {
        try {
            const response = await fetch('/check-balance', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();
            
            if (!data.success) {
                throw new Error(data.message);
            }

            const carPrice = parseFloat(document.getElementById('car-price').textContent.replace('₹', ''));
            const availableBalance = parseFloat(data.Balance);

            if (availableBalance < carPrice) {
                throw new Error(`Insufficient balance. Available: ₹${availableBalance}, Required: ₹${carPrice}`);
            }

            return true;
        } catch (error) {
            console.error('Balance check error:', error);
            throw error; // Re-throw to handle in form submission
        }
    }

    // Validate single field
    function validateField(input) {
        const validator = validators[input.name];
        if (!validator) return true;

        const errorElement = input.parentNode.querySelector('.error-message');
        const isValid = typeof validator === 'function' 
            ? validator(input.type === 'checkbox' ? input.checked : input.value)
            : true;

        if (isValid === true) {
            input.classList.remove('border-red-500');
            if (errorElement) errorElement.remove();
            return true;
        } else {
            input.classList.add('border-red-500');
            if (!errorElement) {
                const error = document.createElement('span');
                error.className = 'error-message';
                error.textContent = isValid;
                input.parentNode.appendChild(error);
            }
            return false;
        }
    }

    // Populate car details
    if (carData && Object.keys(carData).length > 0) {
        document.getElementById("car-id").value = carData.id || "";
        document.getElementById("car-category-input").value = carData.category || "";
        document.getElementById("car-seating-input").value = carData.seatingCapacity || "";
        document.getElementById("car-luggage-input").value = carData.luggageCapacity || "";
        document.getElementById("car-price-input").value = carData.totalAmount || "";
        document.getElementById("trace_id").value = carData.traceId || "";
        document.getElementById("srdv_index").value = carData.srdvIndex || "";

        // Also update visible car details
        document.getElementById("car-category").textContent = carData.category || "N/A";
        document.getElementById("car-seating").textContent = carData.seatingCapacity || "N/A";
        document.getElementById("car-luggage").textContent = carData.luggageCapacity || "Not Specified";
        document.getElementById("car-price").textContent = "₹" + parseFloat(carData.totalAmount || 0).toFixed(2);
        document.getElementById("trace-id-display").textContent = carData.traceId || "N/A";
        document.getElementById("srdv-index-display").textContent = carData.srdvIndex || "N/A";
    }

    // Populate search parameters
    if (searchParams && Object.keys(searchParams).length > 0) {
        document.getElementById("pickup-location-input").value = searchParams.pickupLocation || "";
        document.getElementById("dropoff-location-input").value = searchParams.dropoffLocation || "";
        document.getElementById("trip-type-input").value = searchParams.tripType || "";
        
       // Also update visible search summary
       document.getElementById("pickup-location").textContent = searchParams.pickupLocation || "";
        document.getElementById("dropoff-location").textContent = searchParams.dropoffLocation || "";
        document.getElementById("pickup-date").textContent = searchParams.pickupDate || "";
        document.getElementById("trip-type").textContent = searchParams.tripType || "";
        
        // Auto-fill the booking form
        document.getElementById("pickup_address").value = searchParams.pickupLocation || "";
        document.getElementById("drop_address").value = searchParams.dropoffLocation || "";
        document.getElementById("booking_date").value = searchParams.pickupDate || "";
    }

    // Add blur validation to all inputs
    inputs.forEach(input => {
        input.addEventListener('blur', () => validateField(input));
    });

    // Form submission handler
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Validate all fields
        const isValid = Array.from(inputs).every(input => validateField(input));
        if (!isValid) return;

        const originalText = submitButton.textContent;
        
        try {
            // Disable submit button and show loading state
            submitButton.textContent = 'Processing...';
            submitButton.disabled = true;

            // Check balance first
            await checkBalance();

            // Prepare form data with car and trip details
            const formData = new FormData(form);
            if (carData) {
                formData.append('car_id', carData.id || '');
                formData.append('car_category', carData.category || '');
                formData.append('car_seating', carData.seatingCapacity || '');
                formData.append('car_luggage', carData.luggageCapacity || '');
                formData.append('car_price', carData.totalAmount || '');
            }
            
            if (searchParams) {
                formData.append('pickup_location', searchParams.pickupLocation || '');
                formData.append('dropoff_location', searchParams.dropoffLocation || '');
                formData.append('trip_type', searchParams.tripType || '');
            }

            // Submit form
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Server error occurred');
            }

            if (data.success && data.redirectUrl) {
                window.location.href = data.redirectUrl;
            } else {
                throw new Error(data.message || 'Unknown error occurred');
            }
        } catch (error) {
            console.error('Submission error:', error);
            alert(error.message || 'An error occurred. Please try again.');
        } finally {
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        }
    });
});
</script>
@endsection