@extends('frontend.layouts.master')
@section('title', 'Booking Confirmation')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<div class="container mt-5" id="bookingContainer" style="max-width: 1200px; padding: 30px; background: linear-gradient(135deg, #f0f4f8, #ffffff); border-radius: 15px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);">
    <div id="bookingDetails">
        <h2 class="text-center" style="font-size: 36px; font-weight: 700; color: #1fb86b; margin-bottom: 30px;">
            <i class="fas fa-check-circle" style="color: #28a745; margin-right: 10px;"></i> Booking Confirmation
        </h2>

        <div class="row" style="display: flex; justify-content: space-between; gap: 20px;">
            <!-- Passenger Details -->
            <div id="passengerDetails" class="card" style="flex: 0 1 20%; max-width: 20%; padding: 20px; border-radius: 10px;">
                <h4><i class="fas fa-user"></i> Passenger Details</h4>
                <div id="passengerContent">
                    <p>Loading passenger details...</p>
                </div>
            </div>

            <!-- Pickup & Dropping Details -->
            <div id="pickupDropDetails" class="card" style="flex: 0 1 20%; max-width: 20%; padding: 20px; border-radius: 10px;">
                <h4><i class="fas fa-map-marker-alt"></i> Pickup & Drop</h4>
                <p id="pickupPoint">Pickup point not available.</p>
                <p id="droppingPoint">Dropping point not available.</p>
            </div>
        </div>

        <button id="cancelBookingButton" class="btn btn-danger mt-4">Cancel Booking</button>
        <a href="#" id="payNowButton" class="btn btn-success mt-4">Proceed To Pay</a>
    </div>
</div>

<script>
    // Fetch URL parameters
    const urlParams = new URLSearchParams(window.location.search);
const passengerData = urlParams.get('PassengerData');
const boardingPointName = urlParams.get('BoardingPointName');
const droppingPointName = urlParams.get('DroppingPointName');
let traceId = urlParams.get('TraceId');
const resultIndex = urlParams.get('ResultIndex');
let invoiceAmount = 0;
let encodedPassengerData = ''; // Define this at the top level

// Populate passenger details
let passengerDetailsHTML = '';

if (passengerData) {
    const passenger = JSON.parse(decodeURIComponent(passengerData));
    invoiceAmount = passenger.Seat.Price.PublishedPrice;
    encodedPassengerData = encodeURIComponent(passengerData); // Set the encoded data
    
    passengerDetailsHTML = `
        <p><strong>Name:</strong> ${passenger.FirstName} ${passenger.LastName}</p>
        <p><strong>Phone Number:</strong> ${passenger.Phoneno}</p>
        <p><strong>Seat No:</strong> ${passenger.Seat.SeatName}</p>
        <p><strong>Price:</strong> ₹${invoiceAmount}</p>
        <p><strong>Address:</strong> ${passenger.Address}</p>
    `;
} else {
    passengerDetailsHTML = "<p>No passenger details available.</p>";
}

document.getElementById('passengerContent').innerHTML = passengerDetailsHTML;

// Populate pickup and dropping points
document.getElementById('pickupPoint').textContent = boardingPointName || "Pickup point not available.";
document.getElementById('droppingPoint').textContent = droppingPointName || "Dropping point not available.";

// Set the href for Pay Now button with all necessary parameters
// Set the href for Pay Now button with all necessary parameters
document.getElementById('payNowButton').href = `/payment?TraceId=${traceId}&amount=${invoiceAmount}&PassengerData=${encodeURIComponent(encodedPassengerData)}&ResultIndex=${resultIndex}&BoardingPointName=${encodeURIComponent(boardingPointName)}&DroppingPointName=${encodeURIComponent(droppingPointName)}`;

// Handle payment click event
document.getElementById('payNowButton').addEventListener('click', function (e) {
    e.preventDefault();

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    const payload = {
        TraceId: traceId,
        Amount: invoiceAmount,
        PassengerData: passengerData,
        BoardingPointName: boardingPointName,
        DroppingPointName: droppingPointName,
        SeatNumber: JSON.parse(decodeURIComponent(passengerData)).Seat.SeatName
    };

    // Add console logs for debugging
    console.log('Payload:', payload);

    fetch('/handlepayment', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.navigateToPayment) {
            // Navigate to payment page with all necessary parameters
            window.location.href = `${data.url}&PassengerData=${encodedPassengerData}&ResultIndex=${resultIndex}&BoardingPointName=${encodeURIComponent(boardingPointName)}&DroppingPointName=${encodeURIComponent(droppingPointName)}`;
        } else if (!data.success) {
            alert(data.errorMessage || 'Something went wrong. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    });
});
</script>

@endsection
