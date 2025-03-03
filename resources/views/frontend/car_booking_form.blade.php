@extends('frontend.layouts.master')

@section('styles')
<style>

<style>
.search-summary {
    background: #ffffff;
    border-radius: 10px;
    padding: 15px 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
    max-width: 600px;
    margin: 20px auto;
    text-align: center;
}

.search-summary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
}

.search-summary .flex {
    flex-wrap: nowrap; 
    white-space: nowrap; 
}

.search-summary span {
    font-size: 16px;
    font-weight: 500;
}

.search-summary strong {
    color: #007bff;
}

@media (max-width: 768px) {
    .search-summary {
        max-width: 100%;
        padding: 10px;
    }

    .search-summary .flex {
        flex-wrap: wrap; 
        justify-content: center;
        gap: 10px;
    }
}
.search-summary strong {
    color: #007bff;
}

@media (max-width: 768px) {
    .search-summary {
        max-width: 100%;
        padding: 10px;
    }

    .search-summary .flex {
        flex-direction: column;
        gap: 10px;
    }
}

    /* Common styles */
    :root {
        --primary-color: #4f46e5;
        --error-color: #dc2626;
        --border-color: #e5e7eb;
        --shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        --radius: 0.5rem;
    }

    /* Layout containers */
    .booking-page {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1.5rem;
    }

    .booking-grid {
        display: grid;
        grid-template-columns: 3fr 2fr;
        gap: 2rem;
        margin-top: 2rem;
    }

    /* Car details section */
    .car-details {
        background: linear-gradient(135deg, #f6f8ff 0%, #ffffff 100%);
        border-radius: var(--radius);
        padding: 1.5rem;
        position: sticky;
        top: 2rem;
        height: fit-content;
    }

    .car-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-top: 1rem;
    }

    .car-info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Form styles */
    .booking-form {
        background: white;
        padding: 2rem;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #374151;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .error-message {
        color: var(--error-color);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .submit-button {
        width: 100%;
        padding: 1rem;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: var(--radius);
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .submit-button:hover {
        background: #4338ca;
    }

    .submit-button:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .booking-grid {
            grid-template-columns: 1fr;
        }

        .car-details {
            position: static;
            margin-bottom: 2rem;
        }

        .car-info-grid {
            grid-template-columns: 1fr;
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

        // Also update visible car details
        document.getElementById("car-category").textContent = carData.category || "N/A";
        document.getElementById("car-seating").textContent = carData.seatingCapacity || "N/A";
        document.getElementById("car-luggage").textContent = carData.luggageCapacity || "Not Specified";
        document.getElementById("car-price").textContent = "₹" + parseFloat(carData.totalAmount || 0).toFixed(2);
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