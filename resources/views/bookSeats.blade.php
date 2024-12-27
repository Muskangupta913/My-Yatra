@extends('frontend.layouts.master')

@section('title', 'Booking Confirmation')

@section('content')

<!-- Add the CSRF meta tag in the header -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4" id="bookingContainer">
    
    <div id="bookingDetails" class="text-center">
        <p>Loading booking details...</p>
    </div>
    
    <button id="cancelBookingButton" class="btn btn-danger mt-4">Cancel Booking</button>
    <!-- Pay Now Button -->
    <a href="#" id="payNowButton" class="btn btn-success mt-4">Pay Now</a>
</div>

<script>
    // Retrieve query parameters from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('TraceId');
    const busBookingStatus = urlParams.get('BusBookingStatus');
    const invoiceAmount = urlParams.get('InvoiceAmount');
    const busId = urlParams.get('BusId');
    const ticketNo = urlParams.get('TicketNo');
    const travelOperatorPNR = urlParams.get('TravelOperatorPNR');
    const boardingPoint = urlParams.get('BoardingPoint'); // New parameter for boarding point
    const droppingPoint = urlParams.get('DroppingPoint'); // New parameter for dropping point

    // Display the booking details on the page
    document.getElementById('bookingDetails').innerHTML = `
        <h2>Booking Confirmation</h2>
        <p><strong>Trace ID:</strong> ${traceId}</p>
        <p><strong>Status:</strong> ${busBookingStatus}</p>
        <p><strong>Invoice Amount:</strong> ₹${invoiceAmount}</p>
        <p><strong>Bus ID:</strong> ${busId}</p>
        <p><strong>Ticket No:</strong> ${ticketNo}</p>
        <p><strong>Travel Operator PNR:</strong> ${travelOperatorPNR}</p>
    `;

    // Set the "Pay Now" button link dynamically
    document.getElementById('payNowButton').href = `/payment?TraceId=${traceId}&InvoiceAmount=${invoiceAmount}`;

    // Cancel booking button click event
    document.getElementById('cancelBookingButton').addEventListener('click', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Prepare the cancellation request payload
        const cancelPayload = {
            'EndUser Ip': '1.1.1.1', // You can dynamically get the user's IP here if needed
            'ClientId': '180133',  // Pass the correct ClientId
            'User Name': 'MakeMy91',  // Pass the correct UserName
            'Password': 'MakeMy@910',
            'BusId': busId,
            'SeatId': ticketNo, // Assuming ticketNo is used as SeatId
            'Remarks': "User requested cancellation" // You can customize this
        };

        // Make the API request to cancel the booking
        fetch('/cancelBus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(cancelPayload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Booking cancelled successfully!');
                // Optionally, you can redirect to another page or show cancellation details
            } else {
                alert('Cancellation failed: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    });






    document.getElementById('payNowButton').addEventListener('click', function (e) {
    e.preventDefault();

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const traceId = urlParams.get('TraceId');
    const invoiceAmount = urlParams.get('InvoiceAmount');

    fetch('/handlebalance', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            TraceId: traceId,
            InvoiceAmount: invoiceAmount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`Payment successful! 
                   Wallet Payment: ₹${data.walletPayment}, 
                   User Payment: ₹${data.userPayment}`);
        } else {
            alert('Payment failed: ' + data.error);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
});
</script>

<style>
    .container { max-width: 800px; }
    h2 { margin-bottom: 20px; }
    p { font-size: 18px; }
</style>

@endsection
