@extends('frontend.layouts.master')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel India - Book Your Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card img {
            height: 200px;
            object-fit: cover;
        }
        .cta-button {
            background-color: #007bff;
            color: #fff;
        }
        .alert-custom {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1050;
        }
    </style>
</head>
<body>

<!-- banner Section -->
 
<header 
    class="text-white text-center py-5 d-flex justify-content-center align-items-center fw-bold" 
    style="
        background-image: linear-gradient(rgba(0, 0, 0, 0.37), rgba(0, 0, 0, 0.37)), url('{{ asset('assets/images/travel-banner.jpg') }}'); 
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat; 
        height: 400px;
    ">
    <div class="container">
        <div class="row h-100">
            <div class="col-12 d-flex flex-column justify-content-center align-items-center text-center">
                <h1 class="text-shadow mb-3 fw-bold">It's Time to Travel India - Book Your Ticket Now!</h1>
                <p class="text-shadow mb-4 fw-bold">Explore the best of India - Beaches, Temples, Mountains</p>
            </div>
        </div>
    </div>
</header>




<!-- Destinations Section -->

<section class="container py-5">
    <div class="row text-center g-5"> <!-- 'g-4' adds gap between columns -->
        <div class="col-md-4">
            <h3>Beach Destinations</h3>
            <img src="{{ asset('assets/images/beach.jpg') }}" alt="Beach" class="img-fluid" style="height: 300px; width: 400px; object-fit: cover;">
        </div>
        <div class="col-md-4">
            <h3>Temple Destinations</h3>
            <img src="{{ asset('assets/images/temple.jpg') }}" alt="Temple" class="img-fluid" style="height: 300px; width: 400px; object-fit: cover;">
        </div>
        <div class="col-md-4">
            <h3>Mountain Destinations</h3>
            <img src="{{ asset('assets/images/mountain.jpg') }}" alt="Mountain" class="img-fluid" style="height: 300px; width: 400px; object-fit: cover;">
        </div>
    </div>
</section>


    <div class="container-fluid tourcategory py-5 bg-light px-5">
        <h1 class="text-center mb-4">Book Your Trip</h1>
        <div class="row g-5">

<!-- Honeymoon Package -->
<div class="col-md-4">
    <div class="card h-100">
        <img src="{{ asset('assets/images/honeymoon.jpg') }}" 
             class="card-img-top" 
             alt="Honeymoon" 
             style="height: 300px; width: 100%; object-fit: cover;">
        <div class="card-body">
            <h5 class="card-title">Honeymoon Package</h5>
            <p class="card-text">Experience romantic destinations and create unforgettable memories with our exclusive honeymoon packages.</p>
            
            <!-- Book Now Button -->
            <button class="btn btn-primary mt-3" id="honeymoonBookNow" data-bs-toggle="modal" data-bs-target="#bookingModal">
                Book Now
            </button>
        </div>
    </div>
</div>




<!-- !-- Adventure Package --> 
<div class="col-md-4">
    <div class="card h-100">
        <img src="{{ asset('assets/images/adventure.jpg') }}" 
             class="card-img-top" 
             alt="Adventure" 
             style="height: 300px; width: 100%; object-fit: cover;">
        <div class="card-body">
            <h5 class="card-title">Adventure Package</h5>
            <p class="card-text">Embark on thrilling adventures and explore the wild side with our exciting adventure packages.</p>
            
            <!-- Book Now Button -->
            <button class="btn btn-primary mt-3" id="adventureBookNow" data-bs-toggle="modal" data-bs-target="#bookingModal">
                Book Now
            </button>
        </div>
    </div>
</div>


<!-- Religious Package -->
<div class="col-md-4">
    <div class="card h-100">
        <img src="{{ asset('assets/images/religious.jpg') }}" 
             class="card-img-top" 
             alt="Religious" 
             style="height: 300px; width: 100%; object-fit: cover;">
        <div class="card-body">
            <h5 class="card-title">Religious Package</h5>
            <p class="card-text">Seek blessings and spiritual fulfillment with our carefully curated religious tour packages.</p>
            
            <!-- Book Now Button -->
            <button class="btn btn-primary mt-3" id="religiousBookNow" data-bs-toggle="modal" data-bs-target="#bookingModal">
                Book Now
            </button>
        </div>
    </div>
</div>

        </div>
       
    </div>

          


<!-- Modal for Booking Confirmation -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="bookingModalLabel">Confirm Your Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            action="{{ route('travel.bharat.book') }}"
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="full_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="adults" class="form-label">Number of Adults</label>
                            <input type="number" class="form-control" id="adults" name="adults" min="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="children" class="form-label">Number of Children</label>
                            <input type="number" class="form-control" id="children" name="children" min="0" value="0" required>
                        </div>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">I agree to the terms and conditions.</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>




    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script to Automatically Show Modal -->
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var successModal = new bootstrap.Modal(document.getElementById('bookingSuccessModal'));
            successModal.show();
        });
    </script>
    @endif
</body>
</html>


<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.cta-button').forEach(button => {
        button.addEventListener('click', e => {
            e.preventDefault();
            alert('Feature coming soon!');
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('date').setAttribute('min', today);
    });
</script>



@endsection