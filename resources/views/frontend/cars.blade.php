@extends('frontend.layouts.master')

@section('styles')
    <style>
/* Base responsive adjustments for all screens */
.container {
    width: 100%;
    padding-right: 1rem;
    padding-left: 1rem;
}

/* Enhanced search summary box */
.search-summary {
    background: #ffffff;
    border-radius: 10px;
    padding: 15px 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease-in-out;
    max-width: 600px;
    margin: 20px auto;
}

.search-summary:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
}

.search-summary p {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 10px;
    margin: 0;
    text-align: center;
}

.search-summary strong {
    color: #007bff;
}

/* Mobile search summary adjustments */
@media (max-width: 768px) {
    .search-summary {
        max-width: 100%;
        padding: 10px;
    }

    .search-summary p {
        font-size: 14px;
        flex-direction: column;
        gap: 5px;
    }
}

/* Car results section - this fixes the layout for larger screens */
#carResults {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
}

/* Core card layout */
.car-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(129, 87, 228, 0.69);
    transition: transform 0.3s ease;
    position: relative;
    overflow: hidden;
    width: 100%;
    margin-bottom: 20px;
}

/* Card grid system for larger screens */
@media (min-width: 768px) {
    .car-card {
        width: calc(50% - 10px);
        margin-bottom: 20px;
    }
}

@media (min-width: 1024px) {
    .container {
        padding-right: 2rem;
        padding-left: 2rem;
    }
    
    .car-card {
        width: calc(50% - 10px);
    }
}

/* Card appearance and animations */
.car-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
}

/* Fix for car image wrapper */
.car-image-wrapper {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    display: block;
    width: 100%;
}

/* Car image styling */
.car-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
    transition: transform 0.5s ease;
    border-radius: 8px 8px 0 0;
}

.car-card:hover .car-image {
    transform: scale(1.05);
}

/* Car title positioning */
.car-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #333;
    display: block;
    width: 100%;
    /* Critical fix for text positioning */
    position: relative;
    z-index: 2;
}

/* Updated price tag design */
.price-tag {
    position: absolute;
    top: 1rem;
    right: 0;
    background: #1d4ed8;
    color: white;
    padding: 0rem 1rem;
    font-weight: bold;
    clip-path: polygon(0 0, 100% 0, 95% 100%, 0% 100%);
    z-index: 4;
}

/* Book Now button styling */
.book-now-btn {
    width: 100%;
    background-color: #1d4ed8;
    color: white !important;
    font-weight: 600;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    border: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    margin-top: 1rem;
    text-align: center;
    position: relative;
    z-index: 2;
}

.book-now-btn:hover {
    background-color: #1e40af;
    transform: translateY(-2px);
}

/* Badge styling */
.badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
}

.badge-ac {
    background-color: #e0f2fe;
    color: #0369a1;
}

.badge-refundable {
    background-color: #dcfce7;
    color: #15803d;
}

.badge-non-refundable {
    background-color: #fee2e2;
    color: #b91c1c;
}

/* Responsive grid layout for car details */
.grid-cols-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

/* ==================== */
/* CRITICAL FIX FOR TEXT POSITIONING ON LARGER SCREENS */
/* ==================== */
.car-image-wrapper .flex-col {
    position: relative !important;
    top: auto !important;
    left: auto !important;
    margin-top: 0.5rem !important;
    padding: 0 0.5rem !important;
    width: 100% !important;
}

.car-details.space-y-3 {
    position: relative !important;
    width: 100% !important;
    margin-bottom: 1rem !important;
}

.car-details-container {
    position: static !important;
    width: 100% !important;
}

/* End of critical fix */
/* ==================== */

/* Screen-specific adjustments */
/* Mobile layout fixes */
@media (max-width: 767px) {
    .car-card {
        width: 100%;
        margin-bottom: 15px;
    }
    
    .car-image {
        height: 150px;
    }
    
    /* Fix badge display on mobile */
    .badge {
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        margin-bottom: 0.35rem;
    }
    
    /* Fix car title display */
    .car-title {
        font-size: 1rem;
        margin-top: 0;
    }
    
    /* Fix grid layout on mobile */
    .grid-cols-2 {
        grid-template-columns: 1fr 1fr;
        gap: 0.25rem;
        text-align: left;
        font-size: 0.85rem;
    }
    
    /* Fix price tag positioning */
    .price-tag {
        top: 0.5rem;
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
    }
    
    /* Fix book now button */
    .book-now-btn {
        padding: 0.5rem;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    /* Fix filter sidebar on mobile */
    aside.md\:col-span-1 {
        padding: 1rem;
        margin-bottom: 1rem;
    }
}

/* Extra small device optimizations */
@media (max-width: 375px) {
    .container {
        padding-right: 0.5rem;
        padding-left: 0.5rem;
    }
    
    .search-summary {
        padding: 10px;
    }
    
    .search-summary p {
        font-size: 12px;
    }
    
    .car-image {
        height: 120px !important;
    }
    
    .car-title {
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
    }
    
    .badge {
        font-size: 0.65rem;
        padding: 0.15rem 0.4rem;
        margin-right: 0.25rem;
        margin-bottom: 0.25rem;
    }
    
    .grid-cols-2 {
        gap: 0.2rem;
    }
    
    .grid-cols-2 > div {
        font-size: 0.75rem;
    }
    
    .book-now-btn {
        font-size: 0.8rem;
        padding: 0.4rem;
    }
}

/* Fix for section layout on mobile */
@media (max-width: 767px) {
    .md\:col-span-3 {
        width: 100%;
    }
    
    .md\:col-span-1 {
        width: 100%;
    }
    
    .grid.md\:grid-cols-4 {
        display: block;
    }
}

/* Animation for cards */
.animate-fade-in {
    animation: fadeIn 0.5s ease-in-out forwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Loading state */
.shimmer {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
}

@keyframes shimmer {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

</style>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        {{-- Error Message --}}
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- Search Summary --}}
        @if (!empty($searchParams))
            <div class="search-summary">
                <p>
                    <strong><i class="fas fa-map-marker-alt"></i> From:</strong>
                    {{ $searchParams['pickupLocation'] ?? 'N/A' }}
                    <strong><i class="fas fa-location-arrow"></i> To:</strong>
                    {{ $searchParams['dropoffLocation'] ?? 'N/A' }}
                    <strong><i class="fas fa-calendar-alt"></i> Date:</strong> {{ $searchParams['pickupDate'] ?? 'N/A' }}
                    <strong><i class="fas fa-exchange-alt"></i> Trip Type:</strong>
                    {{ ['One Way', 'Return', 'Local'][$searchParams['tripType'] ?? 0] }}
                </p>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            {{-- Left Sidebar - Filters --}}
            <aside class="md:col-span-1 bg-white p-4 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold mb-3">Filter Results</h2>
                <div class="grid gap-4">
                    <select id="car-category" class="w-full p-2 border rounded">
                        <option value="">All Categories</option>
                        <option value="sedan">Sedan</option>
                        <option value="suv">SUV</option>
                        <option value="luxury">Luxury</option>
                    </select>

                    <select id="seating-capacity" class="w-full p-2 border rounded">
                        <option value="">Seating Capacity</option>
                        <option value="4">4-seater</option>
                        <option value="6">6-seater</option>
                        <option value="8">8-seater</option>
                    </select>

                    <select id="ac-option" class="w-full p-2 border rounded">
                        <option value="">AC Preference</option>
                        <option value="1">AC</option>
                        <option value="0">Non-AC</option>
                    </select>

                    <button id="filterButton" class="w-full bg-blue-600 text-black py-2 px-4 rounded hover:bg-blue-700">
                        <b>Apply Filters</b>
                    </button>
                </div>
            </aside>

            {{-- Right Side - Car Listings --}}
            <section class="md:col-span-3">
                <h1 class="text-2xl font-bold mb-6 relative inline-block">Available Cars</h1>
                <div id="carResults" class="flex flex-wrap justify-between">
                    @forelse($cars as $car)
                        <div class="car-card p-4 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                            <div class="car-image-wrapper mb-4">
                                <h3 class="car-title text-lg font-semibold mb-3">
                                    {{ ucwords(str_replace('_', ' ', $car['category'])) }}
                                </h3>
                                <img src="{{ $car['image'] ?? asset('images/default-car.jpg') }}"
                                    alt="{{ $car['category'] }} Car" class="car-image w-full h-48 object-cover rounded-lg">
                                <div class="flex flex-col h-full" style="position: absolute; top: 10%; left: 70%;">
                                    <div class="car-details space-y-3 flex-grow">
                                        <div class="flex flex-wrap gap-2">
                                            <span class="badge badge-ac">
                                                <i class="fas fa-snowflake mr-1"></i>
                                                {{ $car['hasAC'] ? 'AC' : 'Non-AC' }}
                                            </span>
                                            <span
                                                class="badge {{ $car['isRefundable'] ? 'badge-refundable' : 'badge-non-refundable' }}">
                                                <i
                                                    class="fas {{ $car['isRefundable'] ? 'fa-check' : 'fa-times' }} mr-1"></i>
                                                {{ $car['isRefundable'] ? 'Refundable' : 'Non-Refundable' }}
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                                            <div>
                                                <i class="fas fa-car mr-2"></i>
                                                {{ $car['carType'] }}
                                            </div>
                                            <div>
                                                <i class="fas fa-users mr-2"></i>
                                                {{ $car['seatingCapacity'] }} Persons
                                            </div>
                                            <div>
                                                <i class="fas fa-suitcase mr-2"></i>
                                                {{ $car['luggageCapacity'] ?? 'Not specified' }}
                                            </div>
                                            <div>
                                                <i class="fas fa-car-side mr-2"></i>
                                                {{ $car['availability'] ?? 0 }} Available
                                            </div>
                                            <div class="car-info-item">
                                                <i class="fas fa-fingerprint"></i>
                                                <span>TraceID: <strong>{{ session('carSearchResults.TraceID') ?? 'N/A' }}</strong></span>
                                            </div>
                                            <div class="car-info-item">
                                                <i class="fas fa-barcode"></i>
                                                <span>SrdvIndex: <strong>{{ $car['id'] ?? 'N/A' }}</strong></span>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="price-tag absolute top-4 right-0 py-2 px-4 text-sm font-bold">
                                        <b>₹{{ number_format($car['totalAmount'], 2) }}</b>
                                    </div>
                                    <button
                class="book-now-btn w-full mt-4 bg-blue-600 text-black py-3 px-4 rounded-lg hover:bg-blue-700 
                transform transition-all duration-300 hover:scale-[1.02] focus:outline-none focus:ring-2 
                focus:ring-blue-500 focus:ring-opacity-50 flex items-center justify-center space-x-2"
                data-car="{{ json_encode([
                    'id' => $car['id'] ?? uniqid(), // Ensure there's always an ID
                    'category' => $car['category'] ?? 'Unknown',
                    'seatingCapacity' => $car['seatingCapacity'] ?? '4',
                    'luggageCapacity' => $car['luggageCapacity'] ?? 'Not Specified',
                    'totalAmount' => $car['totalAmount'] ?? 0,
                    'hasAC' => $car['hasAC'] ?? false,
                    'carType' => $car['carType'] ?? 'Standard',
                    'availability' => $car['availability'] ?? 0,
                    'isRefundable' => $car['isRefundable'] ?? false
                ]) }}">
                <span><b>Book Now</b></span>
                <i class="fas fa-arrow-right transition-transform duration-300 group-hover:translate-x-1"></i>
            </button>
                            </div>
                        </div>
                    @empty
                        <div class="w-full flex flex-col items-center justify-center p-8 text-center">
                            <i class="fas fa-car-slash text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500 text-lg">No cars available matching your criteria.</p>
                            <p class="text-gray-400 text-sm mt-2">Try adjusting your filters or search parameters.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
// car details 
document.querySelectorAll(".book-now-btn").forEach(button => {
    button.addEventListener("click", function() {
        const carData = JSON.parse(this.dataset.car);
        // Also store search parameters
        const searchParams = {
            pickupLocation: "{{ $searchParams['pickupLocation'] ?? 'N/A' }}",
            dropoffLocation: "{{ $searchParams['dropoffLocation'] ?? 'N/A' }}",
            pickupDate: "{{ $searchParams['pickupDate'] ?? 'N/A' }}",
            tripType: "{{ ['One Way', 'Return', 'Local'][$searchParams['tripType'] ?? 0] }}"
        };
        localStorage.setItem("selectedCar", JSON.stringify(carData));
        localStorage.setItem("searchParams", JSON.stringify(searchParams));
        window.location.href = "{{ route('car.booking.form') }}";
    });
});
// car details close

        // car select 
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".book-now-btn").forEach(button => {
                try {
                // Parse the car data from the button's data attribute
                const carData = JSON.parse(this.dataset.car);
                
                // Validate required fields
                const requiredFields = ['id', 'category', 'seatingCapacity', 'luggageCapacity', 'totalAmount'];
                const missingFields = requiredFields.filter(field => !carData[field]);
                
                if (missingFields.length > 0) {
                    console.error('Missing required fields:', missingFields);
                    alert('Unable to proceed with booking. Please try again.');
                    return;
                }

                // Store car data and redirect
                localStorage.setItem("selectedCar", JSON.stringify(carData));
                window.location.href = "{{ route('car.booking.form') }}";
            } catch (error) {
                console.error('Error processing car data:', error);
            }
        });
    });

        // car select close
        // animation
        function showLoading() {
            const carResults = document.getElementById('carResults');
            carResults.classList.add('opacity-50', 'pointer-events-none');
            // Add shimmer effect to cards
            document.querySelectorAll('.car-card').forEach(card => {
                card.classList.add('shimmer');
            });
        }

        function hideLoading() {
            const carResults = document.getElementById('carResults');
            carResults.classList.remove('opacity-50', 'pointer-events-none');
            // Remove shimmer effect
            document.querySelectorAll('.car-card').forEach(card => {
                card.classList.remove('shimmer');
            });
        }

        // Intersection Observer for scroll animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.car-card').forEach(card => {
            observer.observe(card);
        });

        // animation clise 
        document.addEventListener("DOMContentLoaded", function() {
            const filterButton = document.getElementById("filterButton");

            filterButton.addEventListener("click", function() {
                const category = document.getElementById("car-category").value;
                const seating = document.getElementById("seating-capacity").value;
                const ac = document.getElementById("ac-option").value;

                fetch(`/search-cars?category=${category}&seating=${seating}&ac=${ac}`)
                    .then(response => response.json())
                    .then(data => {
                        const carResults = document.getElementById("carResults");
                        carResults.innerHTML = "";

                        if (data.length === 0) {
                            carResults.innerHTML =
                                `<p class="text-gray-500 text-center col-span-full">No cars available.</p>`;
                            return;
                        }

                        data.forEach(car => {
                            const carHtml = `
                        <div class="border rounded-lg overflow-hidden shadow-lg p-4 transition transform hover:scale-105">
                            <img src="${car.image || '{{ asset('images/default-car.jpg') }}'}" 
                                 alt="${car.category} Car" 
                                 class="w-full h-40 object-cover">
                            
                            <h3 class="text-lg font-semibold mt-4">
                                ${car.category.replace('_', ' ')}
                            </h3>
                            
                            <div class="space-y-2 mt-3">
                                <p class="text-gray-600">Type: ${car.carType || 'N/A'}</p>
                                <p>Seating: ${car.seatingCapacity} persons</p>
                                <p>Luggage: ${car.luggageCapacity || 'Not specified'}</p>
                                <p>AC: ${car.hasAC ? 'Yes' : 'No'}</p>
                                <p>Available: ${car.availability || 0} cars</p>
                                
                                <div class="mt-4 pt-3 border-t border-gray-200">
                                    <p class="text-lg font-bold text-blue-600">₹${(car.totalAmount || 0).toLocaleString()}</p>
                                    ${car.baseFare ? `<p class="text-sm text-gray-600">Base Fare: ₹${car.baseFare.toLocaleString()}</p>` : ''}
                                    ${car.serviceTax ? `<p class="text-sm text-gray-600">Service Tax: ₹${car.serviceTax.toLocaleString()}</p>` : ''}
                                </div>
                                
                                ${car.isRefundable !== undefined ? `
                                            <div class="mt-3">
                                                <p class="text-sm ${car.isRefundable ? 'text-green-600' : 'text-red-600'}">
                                                    ${car.isRefundable ? 'Refundable' : 'Non-Refundable'}
                                                </p>
                                            </div>
                                        ` : ''}
                                
                                ${car.cancellationPolicy ? `
                                            <div class="mt-3">
                                                <p class="text-sm font-medium">Cancellation Policy:</p>
                                                <p class="text-sm text-gray-600">${car.cancellationPolicy}</p>
                                            </div>
                                        ` : ''}
                                
                                <button onclick="window.location.href='/booking/create/${car.id}'"
                                        class="mt-4 w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    `;
                            carResults.innerHTML += carHtml;
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        const carResults = document.getElementById("carResults");
                        carResults.innerHTML = `
                    <p class="text-red-500 text-center col-span-full">
                        An error occurred while fetching results. Please try again.
                    </p>
                `;
                    });
            });
        });

        // pickup and drop and date 

        document.addEventListener('DOMContentLoaded', function() {
            // Fetch search parameters
            fetch('/get-search-params')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const params = data.data;
                        // Update your UI with the search parameters
                        document.getElementById('pickupLocation').textContent = params.pickupLocation;
                        document.getElementById('dropoffLocation').textContent = params.dropoffLocation;
                        document.getElementById('pickupDate').textContent = params.pickupDate;
                        document.getElementById('tripType').textContent = params.tripType;
                    }
                });

            // Fetch car details (all cars or specific car)
            fetch('/get-car-details') 
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const cars = data.data;
                    }
                });
        });

        document.querySelectorAll(".book-now-btn").forEach(button => {
            button.addEventListener("click", function() {
                const carData = JSON.parse(this.dataset.car);
                const traceId = sessionStorage.getItem('trace_id');
                const srdvIndex = sessionStorage.getItem('srdv_index');
                carData.traceId = traceId;
                carData.srdvIndex = srdvIndex;
                localStorage.setItem("selectedCar", JSON.stringify(carData));
                window.location.href = "{{ route('car.booking.form') }}";
            });
        });

document.querySelectorAll(".book-now-btn").forEach(button => {
    button.addEventListener("click", function() {
        const carData = JSON.parse(this.dataset.car);
        const traceId = "{{ session('carSearchResults.TraceID') }}";
        carData.traceId = traceId;
        carData.srdvIndex = carData.id; // Ensure SrdvIndex is set correctly
        localStorage.setItem("selectedCar", JSON.stringify(carData));
        window.location.href = "{{ route('car.booking.form') }}";
    });
});
    </script>
@endsection
