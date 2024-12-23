@extends('frontend.layouts.master')
@section('title', 'Seat Layout')

@section('content')
<div class="container mt-4" id="seatLayoutContainer">
    <h2 class="text-center mb-4">🚌 Seat Layout 🚌</h2>
    <div id="loadingMessage" class="text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p>Loading seat layout...</p>
    </div>
    <div id="errorMessage" class="alert alert-danger d-none"></div>
    <div id="seatLayout"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    let traceId = urlParams.get('TraceId');
    let resultIndex = urlParams.get('ResultIndex');

    if (!traceId) traceId = sessionStorage.getItem('TraceId');
    if (!resultIndex) resultIndex = sessionStorage.getItem('ResultIndex');

    if (!traceId || !resultIndex) {
        showError('Required parameters are missing. Please go back and try again.');
        return;
    }

    fetchSeatLayout(traceId, resultIndex);
});

function showError(message) {
    document.getElementById('loadingMessage').classList.add('d-none');
    const errorDiv = document.getElementById('errorMessage');
    errorDiv.textContent = message;
    errorDiv.classList.remove('d-none');
}

function fetchSeatLayout(traceId, resultIndex) {
    fetch('{{ route("getSeatLayout") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            TraceId: traceId,
            ResultIndex: resultIndex
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status && data.data?.SeatLayout?.SeatLayoutDetails) {
            document.getElementById('loadingMessage').classList.add('d-none');
            renderSeatLayout(data.data.SeatLayout.SeatLayoutDetails.Layout);
        } else {
            showError(data.message || 'Failed to load seat layout');
        }
    })
    .catch(error => {
        showError('An error occurred while loading the seat layout');
    });
}

function renderSeatLayout(layout) {
    const seatLayoutContainer = document.getElementById('seatLayout');
    let layoutHTML = `<div class="seat-layout">`;

    layout.seatDetails.forEach(row => {
        layoutHTML += `<div class="seat-row">`;
        row.forEach(seat => {
            layoutHTML += `<div class="seat">${seat.SeatName}</div>`;
        });
        layoutHTML += `</div>`;
    });

    layoutHTML += `</div>`;
    seatLayoutContainer.innerHTML = layoutHTML;
}
</script>
@endsection
