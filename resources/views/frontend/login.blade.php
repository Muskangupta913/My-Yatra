@extends('frontend.layouts.master')
@section('title', 'Available bus')

@section('content')
<div class="container mt-4" id="busResultsContainer">
    <h2 class="text-center mb-4">🚌 Bus Search Results 🚌</h2>

    <!-- Single Horizontal Card -->
    <div id="busListings" class="d-flex justify-content-center">
        <!-- This part will be dynamically populated -->
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchData = sessionStorage.getItem('busSearchResults');  // Get the bus search results from session storage
    
    if (!searchData) {
        window.location.href = "{{ route('home') }}"; // Redirect if no data is found
        return;
    }

    const data = JSON.parse(searchData);  // Parse the data into a JavaScript object

    // Check if data and data.data exist and is an array
    if (!data || !Array.isArray(data.data) || data.data.length === 0) {
        console.error('No bus data available');
        document.getElementById('busListings').innerHTML = '<div class="alert alert-danger">Error: No bus data available</div>';
        return;
    }

    const bus = data.data[0];  // Access the first bus from the data array
    const traceId = data.traceId;  // Get the traceId from the response

    if (!traceId) {
        console.error('TraceId is missing from the response');
        document.getElementById('busListings').innerHTML = '<div class="alert alert-danger">Error: Missing TraceId</div>';
        return;
    }

    const busListingsHTML = `
        <div class="card w-75 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-center mb-3">${bus.TravelName}</h5>
                <p class="text-center text-muted">${bus.BusType}</p>

                <!-- Departure & Arrival Times -->
                <div class="d-flex justify-content-between mb-3">
                    <div><strong>🕒 Departure:</strong> ${new Date(bus.DepartureTime).toLocaleString()}</div>
                    <div><strong>🕒 Arrival:</strong> ${new Date(bus.ArrivalTime).toLocaleString()}</div>
                </div>

                <!-- Available Seats & Max Seats -->
                <div class="d-flex justify-content-between mb-3">
                    <div><strong>💺 Available Seats:</strong> ${bus.AvailableSeats}</div>
                    <div><strong>🛏️ Max Seats Per Ticket:</strong> ${bus.MaxSeatsPerTicket}</div>
                </div>

                <!-- Price Details -->
                <div class="mb-3">
                    <h6><strong>💵 Price Details</strong></h6>
                    <p><strong>Base Price:</strong> ₹${bus.Price.BasePrice}</p>
                    <p><strong>Published Price:</strong> ₹${bus.Price.PublishedPrice}</p>
                    <p><strong>Offered Price:</strong> ₹${bus.Price.OfferedPrice}</p>
                </div>

                <!-- Select Seats Button -->
                <div class="text-center">
                   <a href="{{ route('bus.seatLayout') }}?TraceId=${traceId}&ResultIndex=${bus.ResultIndex}" class="btn btn-primary w-100">
                       Select Seats
                   </a>
                </div>
            </div>
        </div>
    `;

    document.getElementById('busListings').innerHTML = busListingsHTML;  // Add the HTML to the page
});

// Store bus data in sessionStorage to be used later
function setSessionData(traceId, resultIndex) {
    sessionStorage.setItem('TraceId', traceId);
    sessionStorage.setItem('ResultIndex', resultIndex);
}
</script>

<style>
/* Add custom styles for a clean and simple design */
body {
    background-color: #f9f9f9;
}

#busResultsContainer {
    padding: 2rem 0;
}

.card {
    border-radius: 8px;
}

.card-body {
    padding: 1.5rem;
}

.card-title {
    font-size: 1.5rem;
    font-weight: bold;
}

.card p {
    margin: 0.5rem 0;
}

button.btn-primary {
    background-color: #007bff;
    border: none;
}

button.btn-primary:hover {
    background-color: #0056b3;
}

h6 {
    font-weight: bold;
    margin-top: 1rem;
}
</style>

@endsection