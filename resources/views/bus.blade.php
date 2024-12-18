@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

@if(!empty($data))
    @foreach($data as $bus)
        <div>
            <h4>Bus: {{ $bus['ServiceName'] }}</h4>
            <p>Operator: {{ $bus['TravelName'] }}</p>
            <p>Departure Time: {{ $bus['DepartureTime'] }}</p>
            <p>Arrival Time: {{ $bus['ArrivalTime'] }}</p>
        </div>
    @endforeach
@else
    <p>No buses available for this route.</p>
@endif
