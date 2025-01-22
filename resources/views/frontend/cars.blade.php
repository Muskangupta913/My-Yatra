<!-- Include jQuery from CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


<!-- Include Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@extends('frontend.layouts.master')

@section('content')
    <style>
   /* General Card Styling */
.car-result {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    background: linear-gradient(to right,rgb(194, 219, 240),rgb(205, 215, 168));
    margin-bottom: 20px;
}

.car-result:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
}

/* Car Image Container */
.car-result .col-md-4 {
    max-height: 250px; /* Fixed max height for uniformity */
    overflow: hidden;
    border-radius: 12px 0 0 12px;
    position: relative;
}

/* Car Image Styling */
.car-result .car-image {
    width: 100%;
    height: 100%;
    object-fit: contain; /* Ensures the entire car image fits without cropping */
    transition: transform 0.5s ease-in-out, filter 0.3s ease-in-out;
}

/* Image Hover Animation */
.car-result .col-md-4:hover .car-image {
    transform: scale(1.1); /* Slight zoom on hover */
    filter: brightness(1.1) contrast(1.1); /* Slight enhancement */
}

/* Fade-In Animation on Image Load */
.car-result .car-image {
    animation: fadeInZoom 1s ease-in-out;
}

@keyframes fadeInZoom {
    0% {
        opacity: 0;
        transform: scale(0.95);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .car-result .col-md-4 {
        max-height: 200px;
    }

    .car-result .car-image {
        object-fit: cover; /* Slight adjustment for smaller screens */
    }
}

/* Card Body Styling */
.car-result .card-body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.car-result .card-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.car-result .card-title::before {
    content: '\f1b9';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    color: #ff9800;
}

/* Card Text Styling */
.car-result .card-text {
    font-size: 0.95rem;
    color: #555;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.car-result .card-text strong {
    color: #333;
    font-weight: 600;
}

.car-result .card-text::before {
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    color: #666;
}

.car-result .card-text:nth-of-type(1)::before { content: '\f073'; } /* Calendar Icon */
.car-result .card-text:nth-of-type(2)::before { content: '\f0c0'; } /* Users Icon */
.car-result .card-text:nth-of-type(3)::before { content: '\f2cb'; } /* Snowflake Icon */
.car-result .card-text:nth-of-type(4)::before { content: '\f53a'; } /* Money Icon */

/* Price Styling */
.car-result .card-text strong.total-amount {
    font-size: 1.2rem;
    color: #e91e63;
}

/* Book Now Button */
.car-result .btn-warning {
    background: #ff9800;
    color: #fff;
    font-size: 1rem;
    font-weight: 600;
    text-transform: uppercase;
    border: none;
    transition: background 0.3s ease-in-out, transform 0.2s ease-in-out;
    margin-top: auto;
    padding: 10px 10px;
    text-align: center;
    border-radius: 8px;
    align-self: flex-start;
    width: 20%;
}

.car-result .btn-warning:hover {
    background: #e68900;
    transform: scale(1.05);
}

/* Ensure Flex Layout for Proper Alignment */
.car-result .card-body {
    display: flex;
    flex-direction: column;
    gap: 10px;
    justify-content: space-between;
}

/* Animation for Icons */
.car-result .card-text::before,
.car-result .card-title::before {
    animation: fadeInIcon 0.8s ease-in-out;
}

@keyframes fadeInIcon {
    0% {
        opacity: 0;
        transform: translateY(-5px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .car-result .col-md-4 {
        height: 200px;
    }

    .car-result .car-image {
        height: 200px;
    }

    .car-result .card-body {
        padding: 15px;
    }

    .car-result .card-title {
        font-size: 1.2rem;
    }

    .car-result .card-text {
        font-size: 0.85rem;
    }

    .car-result .btn-warning {
        font-size: 0.9rem;
        padding: 8px 12px;
        width: 60%;
    }
}

    </style>
    <!--  left section of the code -->
    <div class="container-fluid mt-3 gx-5">
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                <div class="sidebar">
                    <h4 class="text-black">Filter Car</h4>

                    <!-- Price Section -->
                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Price</h5>
                            <button class="btn btn-link text-white p-0 toggle-icon" type="button" aria-expanded="true">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </div>
                        <div class="collapse show" id="FilterPrice">
                            <div class="card-body">
                                <label class="form-label">Select Price:</label>
                                <div class="list-group">
                                    <label class="list-group-item">
                                        <input class="form-check-input filter-checkbox" type="checkbox" data-filter="price"
                                            value="below-10000">
                                        ₹ 13190.05
                                    </label>
                                    <label class="list-group-item">
                                        <input class="form-check-input filter-checkbox" type="checkbox" data-filter="price"
                                            value="10000-20000">
                                        ₹ 15846.02
                                    </label>
                                    <label class="list-group-item">
                                        <input class="form-check-input filter-checkbox" type="checkbox" data-filter="price"
                                            value="20000-35000">
                                        ₹21,336
                                    </label>
                                    <label class="list-group-item">
                                        <input class="form-check-input filter-checkbox" type="checkbox" data-filter="price"
                                            value="above-35000">
                                        Above ₹35,000
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company Name Section -->
                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Company Name</h5>
                            <button class="btn btn-link text-white p-0 toggle-icon" type="button" aria-expanded="true">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </div>
                        <div class="collapse show" id="FilterCompany">
                            <div class="card-body">
                                <label class="form-label">Select Company Name:</label>
                                <div class="list-group">
                                    <label class="list-group-item">
                                        <input class="form-check-input filter-checkbox" type="checkbox"
                                            data-filter="company" value="ihcl">
                                        Indica
                                    </label>
                                    <label class="list-group-item">
                                        <input class="form-check-input filter-checkbox" type="checkbox"
                                            data-filter="company" value="rosetum">
                                        Indigo
                                    </label>
                                    <label class="list-group-item">
                                        <input class="form-check-input filter-checkbox" type="checkbox"
                                            data-filter="company" value="oberoi">
                                        Innova
                                    </label>
                                    <label class="list-group-item">
                                        <input class="form-check-input filter-checkbox" type="checkbox"
                                            data-filter="company" value="rosetum">
                                        Tempo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Section -->
                    <div class="card mb-3 shadow-sm">
                        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Category</h5>
                            <button class="btn btn-link text-white p-0 toggle-icon" type="button" aria-expanded="true">
                                <i class="bi bi-chevron-down"></i>
                            </button>
                        </div>
                        <div class="collapse show" id="FilterCategory">
                            <div class="card-body">
                                <label class="form-label">Select Category :</label>
                                <div class="list-group">
                                    <label class="list-group-item">
                                        <input class="form-check-input filter-checkbox" type="checkbox"
                                            data-filter="category" value="ac">
                                        AC
                                    </label>
                                    <label class="list-group-item">
                                        <input class="form-check-input filter-checkbox" type="checkbox"
                                            data-filter="category" value="non-ac">
                                        Non AC
                                    </label>
                                    <label class="list-group-item">
                                        <input class="form-check-input filter-checkbox" type="checkbox"
                                            data-filter="category" value="luxury">
                                        Luxury
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  left section of the code end -->

            <!--  right section of the code start -->
            <div class="container col-lg-9 col-md-8 col-sm-12">
                <div class="tab-pane fade mt-2 show active" id="car" role="tabpanel" aria-labelledby="car-tab">
                    <h4 class="mb-3" id="car-title">Book Cars</h4>
                    <form method="POST" action="{{ route('searchCars') }}" id="carSearchForm">
                        @csrf
                        <div class="row align-items-end">
                            <div class="mb-3 col-md-3">
                                <div class="date-caption">Pickup Location</div>
                                <input type="text" class="form-control rounded-0 py-3" name="pickupLocation"
                                    id="carPickupLocation" placeholder="Pickup Location" required>
                                <input type="hidden" name="pickupLocationCode" id="carPickupLocationCode">
                                <div id="carPickupLocationList" class="suggestions-dropdown"></div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <div class="date-caption">Drop-off Location</div>
                                <input type="text" name="dropoffLocation" id="carDropoffLocation"
                                    class="form-control rounded-0 py-3" placeholder="Drop-off Location" required>
                                <input type="hidden" name="dropoffLocationCode" id="carDropoffLocationCode">
                                <div id="carDropoffLocationList" class="suggestions-dropdown"></div>
                            </div>
                            <div class="mb-3 col-md-3">
                                <div class="date-caption">Pickup Date</div>
                                <input type="text" id="carPickupDate" name="pickup_date"
                                    class="form-control rounded-0 py-3 datepicker" placeholder="dd/mm/yyyy" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label>Trip Type</label>
                                <select name="trip_type" id="carTripType" class="form-control rounded-0 py-3">
                                    <option value="0">One Way</option>
                                    <option value="1">Return</option>
                                    <option value="2">Local</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-2">
                                <button type="submit" class="btn btn-warning w-100 rounded-0 py-3 fw-bold">Search Cars</button>
                            </div>
                        </div>
                    </form>

                    <div id="car-results-container"></div>
                    <!-- Booking Form (Initially Hidden) -->
                    <div id="booking-form-container" style="display:none;">
                        <h4>Booking Form</h4>
                        <form id="booking-form">
                            <input type="hidden" id="SrdvIndex">
                            <input type="hidden" id="TraceID">
                            <input type="hidden" id="RefID">
                            <div class="mb-3">
                                <label for="PickUpTime" class="form-label">PickUp Time</label>
                                <input type="time" class="form-control" id="PickUpTime" required>
                            </div>
                            <div class="mb-3">
                                <label for="DropUpTime" class="form-label">DropUp Time</label>
                                <input type="time" class="form-control" id="DropUpTime" required>
                            </div>
                            <div class="mb-3">
                                <label for="CustomerName" class="form-label">Customer Name</label>
                                <input type="text" class="form-control" id="CustomerName" required>
                            </div>
                            <div class="mb-3">
                                <label for="CustomerPhone" class="form-label">Customer Phone</label>
                                <input type="text" class="form-control" id="CustomerPhone" required>
                            </div>
                            <div class="mb-3">
                                <label for="CustomerEmail" class="form-label">Customer Email</label>
                                <input type="email" class="form-control" id="CustomerEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="CustomerAddress" class="form-label">Customer Address</label>
                                <input type="text" class="form-control" id="CustomerAddress" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Booking</button>
                        </form>
                    </div>
                </div>
            </div>
            <script>
               document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#carPickupDate", {
        dateFormat: "d/m/Y",
        minDate: "today",
    });
});


                function fetchCities(inputId, suggestionId) {
                    const query = document.getElementById(inputId).value;

                    if (query.length < 2) {
                        document.getElementById(suggestionId).innerHTML = '';
                        return;
                    }

                    fetch('{{ route('fetchCities') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                query
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            const suggestionList = document.getElementById(suggestionId);
                            suggestionList.innerHTML = '';
                            data.forEach(city => {
                                const option = document.createElement('div');
                                option.className = 'suggestion-item';
                                option.textContent = `${city.caoncitlst_city_name}, ${city.caoncitlst_id}`;
                                option.onclick = () => {
                                    document.getElementById(inputId).value = city.caoncitlst_city_name;
                                    document.getElementById(inputId === 'carPickupLocation' ?
                                            'carPickupLocationCode' : 'carDropoffLocationCode').value = city
                                        .caoncitlst_id;
                                    suggestionList.innerHTML = '';
                                };
                                suggestionList.appendChild(option);
                            });
                        })
                        .catch(error => console.error('Error fetching cities:', error));
                }

                document.getElementById('carPickupLocation').addEventListener('input', () => {
                    fetchCities('carPickupLocation', 'carPickupLocationList');
                });

                document.getElementById('carDropoffLocation').addEventListener('input', () => {
                    fetchCities('carDropoffLocation', 'carDropoffLocationList');
                });

                $('#carSearchForm').on('submit', function(event) {
                    event.preventDefault();

                    const pickupLocationCode = $('#carPickupLocationCode').val();
                    const dropoffLocationCode = $('#carDropoffLocationCode').val();
                    const pickupDate = $('#carPickupDate').val();
                    const tripType = $('#carTripType').val();

                    const payload = {
                        EndUserIp: '1.1.1.1', // Static IP for example
                        ClientId: '180133',
                        UserName: 'MakeMy91',
                        Password: 'MakeMy@910',
                        FormCity: pickupLocationCode,
                        ToCity: dropoffLocationCode,
                        PickUpDate: pickupDate,
                        // DropDate: $('#carDropDate').val() || '',
                        Hours: $('#carHours').val() || '8',
                        TripType: tripType
                    };

                    fetch('{{ route('searchCars') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify(payload),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status) {
                                let carsHTML =
                                    `<h4 class="mb-4">Cars from ${data.cities.pickup} to ${data.cities.dropoff}</h4>`;
                                data.data.forEach(car => {
                                    carsHTML += `
                <div class="car-result card mb-4 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="${car.Image}" alt="${car.Category}" class="img-fluid rounded-start car-image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">${car.Category}</h5>
                                <p class="card-text"><strong>Availability:</strong> ${car.Availability} cars</p>
                                <p class="card-text"><strong>Seats:</strong> ${car.SeatingCapacity} | <strong>Luggage:</strong> ${car.LuggageCapacity}</p>
                                <p class="card-text"><strong>Air Conditioned:</strong> ${car.AirConditioner ? 'Yes' : 'No'}</p>
                                <p class="card-text"><strong>Total Amount:</strong> ₹${car.Fare.TotalAmount}</p>
                                <a href="#" class="btn btn-warning w-40 rounded-0 py-3" onclick="selectCar(${car.CarID}, '${car.Category}', ${car.Fare.TotalAmount})">Book Now</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            `;
                                });
                                document.getElementById('car-results-container').innerHTML = carsHTML;
                            } else {
                                document.getElementById('car-results-container').innerHTML = `<p>${data.message}</p>`;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            document.getElementById('car-results-container').innerHTML =
                                '<p>An error occurred while searching for cars.</p>';
                        });

                });

                // Balance check 
            </script>


            <script>
                document.getElementById('bookingForm').addEventListener('submit', function(event) {
                    event.preventDefault();

                    // Assuming you have a form and you're collecting the necessary data
                    const formData = new FormData(event.target);

                    fetch('/book-car', {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status) {
                                // Booking was successful, redirect or show confirmation
                                alert('Car booked successfully!');
                                window.location.href = '/bookingConfirmation/' + data.bookingId;
                            } else {
                                // Show message if balance is insufficient
                                if (data.message) {
                                    alert(data.message);
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error booking car:', error);
                            alert('An error occurred while booking the car.');
                        });
                });
            </script>
            <script>
                // Your existing code (fetching cars, booking form, etc.)

                // Add the selectCar function below the existing code
                function selectCar(carID, category, totalAmount) {
                    // Store selected car data in the sessionStorage
                    sessionStorage.setItem('selectedCarID', carID);
                    sessionStorage.setItem('selectedCategory', category);
                    sessionStorage.setItem('selectedTotalAmount', totalAmount);

                    // Redirect to the car booking page
                    window.location.href = "{{ route('car.booking') }}";
                }

                // Handle booking form submission
                document.getElementById('booking-form').addEventListener('submit', function(event) {
                    event.preventDefault();

                    const bookingData = {
                        SrdvIndex: document.getElementById('SrdvIndex').value,
                        TraceID: document.getElementById('TraceID').value,
                        RefID: document.getElementById('RefID').value,
                        PickUpTime: document.getElementById('PickUpTime').value,
                        DropUpTime: document.getElementById('DropUpTime').value,
                        CustomerName: document.getElementById('CustomerName').value,
                        CustomerPhone: document.getElementById('CustomerPhone').value,
                        CustomerEmail: document.getElementById('CustomerEmail').value,
                        CustomerAddress: document.getElementById('CustomerAddress').value,
                    };

                    fetch('{{ route('car.processBooking') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(bookingData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status) {
                                alert('Car booked successfully!');
                                window.location.href = '/bookingConfirmation/' + data.bookingId;
                            } else {
                                alert('Booking failed: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error booking car:', error);
                            alert('An error occurred while booking the car.');
                        });
                });
            </script>
        @endsection

        @section('footer')
            <!-- Your footer content -->
        @endsection
