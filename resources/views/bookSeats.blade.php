@extends('frontend.layouts.master')

@section('title', 'Booking Confirmation')

@section('content')

<!-- Add the CSRF meta tag in the header -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4" id="bookingContainer">
   
    <div id="bookingDetails" class="text-center">
        <p>Loading booking details...</p>
    </div>
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
        <p><strong>Pickup Location:</strong> ${boardingPoint}</p> <!-- Display pickup location -->
        <p><strong>Dropping Location:</strong> ${droppingPoint}</p> <!-- Display dropping location -->
    `;
</script>

<style>
    .container { max-width: 800px; }
    h2 { margin-bottom: 20px; }
    p { font-size: 18px; }
</style>

@endsection