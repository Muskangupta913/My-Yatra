@extends('frontend.layouts.master')
@section('title', 'Available Bus')

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
    const searchData = sessionStorage.getItem('busSearchResults'); 

    if (!searchData) {
        window.location.href = "{{ route('home') }}"; 
        return;
    }

    const data = JSON.parse(searchData); 
    const bus = data.buses[0]; 
    const traceId = data.traceId;

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

                <div class="d-flex justify-content-between mb-3">
                    <div><strong>🕒 Departure:</strong> ${new Date(bus.DepartureTime).toLocaleString()}</div>
                    <div><strong>🕒 Arrival:</strong> ${new Date(bus.ArrivalTime).toLocaleString()}</div>
                </div>

                <div class="text-center">
                    <a href="{{ route('bus.seatLayout') }}?TraceId=${traceId}&ResultIndex=${bus.ResultIndex}" 
                       class="btn btn-primary w-100" 
                       onclick="setSessionData('${traceId}', '${bus.ResultIndex}')">
                       Select Seats
                    </a>
                </div>
            </div>
        </div>
    `;

    document.getElementById('busListings').innerHTML = busListingsHTML; 
});

function setSessionData(traceId, resultIndex) {
    sessionStorage.setItem('TraceId', traceId);
    sessionStorage.setItem('ResultIndex', resultIndex);
}
</script>
@endsection
