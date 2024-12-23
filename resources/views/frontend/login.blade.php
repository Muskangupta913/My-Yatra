@extends('frontend.layouts.master')

@section('title', 'Bus Booking')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4" id="busBookingContainer">
    <!-- Select Seat Section -->
    <div id="selectSeatSection" class="section col-12">
        <h2 class="text-center mb-4">🚌 Select Your Seat 🚌</h2>
        <div id="seatLayoutContainer" class="text-center">
            <div id="errorMessage" class="alert alert-danger d-none"></div>
            <div id="seatLayout" data-trace-id="" data-result-index=""></div>
        </div>
        <div id="selectedSeatInfo" class="mt-4 d-none">
            <h4>Selected Seat</h4>
            <p id="selectedSeatDetails"></p>
        </div>
    </div>

    <!-- Passenger Information Section -->
    <div id="passengerDetailsSection" class="section col-12 mt-4 d-none">
        <h2 class="text-center mb-4">👤 Enter Passenger Details 👤</h2>
        <form id="passengerDetailsForm">
            <div class="form-group">
                <label for="title">Title</label>
                <select class="form-control" id="title" name="Title" required>
                    <option value="">Select</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                    <option value="Dr">Dr</option>
                </select>
            </div>
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="firstName" name="FirstName" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="LastName" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="Email" required>
            </div>
            <div class="form-group">
                <label for="phoneNumber">Phone Number</label>
                <input type="text" class="form-control" id="phoneNumber" name="Phoneno" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="Gender" required>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="age">Age</label>
                <input type="number" class="form-control" id="age" name="Age" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="Address" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-success w-100 mt-4">Block Seat</button>
        </form>
    </div>

    <div id="payNowSection" class="section col-12 mt-4 d-none">
        <h2 class="text-center mb-4">💳 Pay Now</h2>
        <button class="btn btn-success w-100" id="payNowButton">Proceed to Payment</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    fetchSeatLayout();
});

let selectedSeat = null;
let seatPrice = 0;

function fetchSeatLayout() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('TraceId');
    const resultIndex = urlParams.get('ResultIndex');

    if (!traceId || !resultIndex) {
        showError("TraceId and ResultIndex are required.");
        return;
    }

    document.getElementById('seatLayout').innerHTML = '<div class="alert alert-info">Loading seat layout...</div>';

    fetch('/getSeatLayout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            TraceId: traceId,
            ResultIndex: resultIndex
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === true) {
            renderSeatLayout(data.data.SeatLayout.SeatLayoutDetails.Layout.seatDetails);
        } else {
            showError(data.message || 'Failed to load seat layout');
        }
    })
    .catch(error => {
        showError(error.message);
    });
}

function renderSeatLayout(seatDetails) {
    const seatLayoutContainer = document.getElementById('seatLayout');
    let layoutHTML = '<div class="bus-seats d-flex flex-wrap justify-content-center">';

    seatDetails.forEach(row => {
        row.forEach(seat => {
            const seatClass = seat.SeatStatus ? 'seat-available' : 'seat-booked';
            layoutHTML += `
                <div 
                    class="seat ${seatClass} m-2" 
                    data-seat-name="${seat.SeatName}" 
                    data-price="${seat.Price.PublishedPrice}" 
                    onclick="selectSeat(this, '${seat.SeatName}', ${seat.Price.PublishedPrice})">
                    <span>${seat.SeatName}</span>
                    <br>
                    <small>₹${seat.Price.PublishedPrice}</small>
                </div>
            `;
        });
    });

    layoutHTML += '</div>';
    seatLayoutContainer.innerHTML = layoutHTML;
}

function selectSeat(element, seatName, price) {
    if (element.classList.contains('seat-booked')) return;

    document.querySelectorAll('.seat-selected').forEach(seat => seat.classList.remove('seat-selected'));
    element.classList.add('seat-selected');

    selectedSeat = seatName;
    seatPrice = price;

    document.getElementById('selectedSeatInfo').classList.remove('d-none');
    document.getElementById('selectedSeatDetails').innerText = `Seat: ${seatName}, Price: ₹${price}`;

    document.getElementById('passengerDetailsSection').classList.remove('d-none');
}

function showError(message) {
    const errorMessage = document.getElementById('errorMessage');
    errorMessage.classList.remove('d-none');
    errorMessage.innerText = message;
}

document.getElementById('passengerDetailsForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const passengerDetails = {
        Title: formData.get('Title'),
        FirstName: formData.get('FirstName'),
        LastName: formData.get('LastName'),
        Email: formData.get('Email'),
        Phoneno: formData.get('Phoneno'),
        Gender: formData.get('Gender'),
        Age: formData.get('Age'),
        Address: formData.get('Address'),
        Seat: [selectedSeat], // Ensure it's an array
        LeadPassenger: true // Assuming this is the first passenger and should be marked as lead
    };


    fetch('/bookSeats', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            ResultIndex: new URLSearchParams(window.location.search).get('ResultIndex'),
            TraceId: new URLSearchParams(window.location.search).get('TraceId'),
            BoardingPointId: '1', // Replace with actual selected boarding point id
            DroppingPointId: '1', // Replace with actual selected dropping point id
            RefID: '1', // Replace with your reference id
            Passenger: [passengerDetails]
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Bus booked successfully!');
            // You can redirect to payment or booking confirmation
        } else {
            alert('Booking failed: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
});
</script>



<style>
.container { max-width: 800px; }
.step-navigation { display: block; }
.step { flex: 1; text-align: center; padding: 10px; border: 1px solid #007bff; border-radius: 5px; cursor: pointer; }
.step.active { background-color: #007bff; color: white; }
.bus-seats { display: flex; flex-wrap: wrap; justify-content: center; }
.seat { width: 50px; height: 50px; background-color: #007bff; color: white; display: flex; align-items: center; justify-content: center; border-radius: 5px; cursor: pointer; }
.seat-available { background-color: #007bff; }
.seat-booked { background-color: #6c757d; cursor: not-allowed; }
.seat-selected { background-color: #28a745; }
.pickup-point, .dropping-point { border: 1px solid #ccc; padding: 10px; margin: 10px 0; border-radius: 5px; }
</style>

@endsection
