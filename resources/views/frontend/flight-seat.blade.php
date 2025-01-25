<style>
.seat-map-container {
    max-width: 800px;
    margin: 0 auto;
}
.seat-item .card {
    transition: all 0.2s ease;
}
.seat-item .card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
.seat-features {
    font-size: 0.8rem;
}
.price {
    font-size: 1.1rem;
}
</style>
<div class="seat-map-container">
    @if(isset($flightInfo))
    <div class="flight-info mb-3">
        <h5>{{ $flightInfo['airline'] }}</h5>
        <p class="mb-2">{{ $flightInfo['from'] }} → {{ $flightInfo['to'] }}</p>
    </div>
    @endif

    <div class="seat-map">
        @forelse($availableSeats as $seat)
            <div class="seat-item mb-2">
                <div class="card {{ $seat['IsLegroom'] ? 'border-success' : '' }} {{ $seat['IsAisle'] ? 'border-info' : '' }}">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Seat {{ $seat['SeatNumber'] }}</h6>
                                <div class="seat-features">
                                    @if($seat['IsLegroom'])
                                        <span class="badge bg-success me-1">Extra Legroom</span>
                                    @endif
                                    @if($seat['IsAisle'])
                                        <span class="badge bg-info">Aisle</span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="price mb-2">
                                    <strong>₹{{ number_format($seat['Amount'], 2) }}</strong>
                                </div>
                                <button type="button" 
                                    class="btn btn-primary btn-sm"
                                    onclick="selectSeat(
                                        '{{ $seat['Code'] }}', 
                                        '{{ $seat['SeatNumber'] }}', 
                                        '{{ $seat['Amount'] }}',
                                        '{{ $flightInfo['airlineName'] }}',
                                        '{{ $flightInfo['airlineCode'] }}',
                                        '{{ $flightInfo['airlineNumber'] }}'
                                    )"
                                >
                                    Select
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                No seats are currently available for this flight.
            </div>
        @endforelse
    </div>
</div>


