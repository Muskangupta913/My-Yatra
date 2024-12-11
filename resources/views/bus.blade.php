<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Search Results</title>
</head>
<body>

<h1>Bus Search Results</h1>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<!-- <h2>From: {{ $source_city }} To: {{ $destination_city }} on {{ $depart_date }}</h2> -->

@if(!empty($buses))
    <table border="1">
        <thead>
            <tr>
                <th>Operator</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Duration</th>
                <th>Fare</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buses as $bus)
                <tr>
                    <td>{{ $bus['OperatorName'] }}</td>
                    <td>{{ $bus['DepartureTime'] }}</td>
                    <td>{{ $bus['ArrivalTime'] }}</td>
                    <td>{{ $bus['Duration'] }}</td>
                    <td>{{ $bus['Fare'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No buses found for the selected route.</p>
@endif

</body>
</html>
