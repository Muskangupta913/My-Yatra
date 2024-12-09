@extends('layouts.app')

@section('content')
    <h1>Available Buses</h1>

    @if($buses && count($buses) > 0)
        <ul>
            @foreach($buses as $bus)
                <li>
                    <strong>Bus Number:</strong> {{ $bus['BusNumber'] }}<br>
                    <strong>Departure Time:</strong> {{ $bus['DepartureTime'] }}<br>
                    <strong>Arrival Time:</strong> {{ $bus['ArrivalTime'] }}<br>
                    <strong>Price:</strong> {{ $bus['Price'] }}<br>
                </li>
            @endforeach
        </ul>
    @else
        <p>No buses found for the selected route and date.</p>
    @endif
@endsection