@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Available Cars</h2>
    
    <div class="search-summary mb-4">
        <p>
            From: {{ $payload['pickupLocation'] }} | 
            To: {{ $payload['dropoffLocation'] }} | 
            Date: {{ $payload['pickup_date'] }}
            @if($payload['trip_type'] == 1)
                | Return: {{ $payload['drop_date'] }}
            @elseif($payload['trip_type'] == 2)
                | Hours: {{ $payload['hours'] }}
            @endif
        </p>
    </div>

    <div id="cars-list" class="row"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const payload = @json($payload);

    const data = {
        pickupLocation: payload.pickupLocation,
        dropoffLocation: payload.dropoffLocation,
        pickup_date: payload.pickup_date,
        drop_date: payload.drop_date || '',
        hours: payload.hours || 8,
        trip_type: payload.trip_type || 0
    };

    fetch('{{ route("searchCars") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status) {
            const cars = data.data;
            let carsHtml = '';

            cars.forEach(car => {
                carsHtml += `
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="${car.Image || 'default-car.jpg'}" class="card-img-top" alt="Car Image">
                            <div class="card-body">
                                <h5 class="card-title">${car.Category || 'N/A'}</h5>
                                <p class="card-text">
                                    <strong>Capacity:</strong> ${car.SeatingCapacity || 'N/A'} persons<br>
                                    <strong>Air Conditioner:</strong> ${car.AirConditioner ? 'Yes' : 'No'}<br>
                                    <strong>Price:</strong> ₹${car.Fare?.TotalAmount ? car.Fare.TotalAmount.toFixed(2) : '0.00'}
                                </p>
                                <form action="{{ route('bookCar') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="SrdvIndex" value="${car.SrdvIndex}">
                                    <input type="hidden" name="TraceID" value="${data.traceId}">
                                    <input type="hidden" name="RefID" value="{{ $refID }}">
                                    <input type="hidden" name="PickUpDate" value="${payload.pickup_date}">
                                    <input type="hidden" name="DropDate" value="${payload.drop_date}">
                                    <input type="hidden" name="Hours" value="${payload.hours}">
                                    <input type="hidden" name="TripType" value="${payload.trip_type}">
                                    <button type="submit" class="btn btn-primary">Book Now</button>
                                </form>
                            </div>
                        </div>
                    </div>
                `;
            });

            document.getElementById('cars-list').innerHTML = carsHtml;
        } else {
            document.getElementById('cars-list').innerHTML = `
                <div class="col-12">
                    <div class="alert alert-info">
                        No cars available for the selected criteria. Please try different dates or locations.
                    </div>
                </div>
            `;
        }
    })
    .catch(error => {
        console.error('Error fetching cars:', error);
        document.getElementById('cars-list').innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger">
                    Something went wrong. Please try again later.
                </div>
            </div>
        `;
    });
});
</script>
@endsection
