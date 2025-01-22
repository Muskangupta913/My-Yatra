
@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-3">Select Your Seat</h1>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="row" id="seatContainer">
        @forelse($availableSeats as $seat)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100 {{ $seat['IsLegroom'] ? 'border-success' : '' }} {{ $seat['IsAisle'] ? 'border-info' : '' }}">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title mb-0">Seat {{ $seat['SeatNumber'] }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="seat-features mb-3">
                            @if($seat['IsLegroom'])
                                <span class="badge bg-success me-2">Extra Legroom</span>
                            @endif
                            @if($seat['IsAisle'])
                                <span class="badge bg-info">Aisle Seat</span>
                            @endif
                        </div>
                        <p class="card-text mb-3">
                            <strong class="d-block mb-2">Price: ${{ number_format($seat['Amount'], 2) }}</strong>
                        </p>
                        <form method="POST" action="{{ route('flight.storeSeat') }}" class="seat-booking-form">
                            @csrf
                            <input type="hidden" name="seat_code" value="{{ $seat['Code'] }}">
                            <input type="hidden" name="price" value="{{ $seat['Amount'] }}">
                            <button type="submit" class="btn btn-primary w-100">
                                Book This Seat
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No seats are currently available. Please try again later.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
