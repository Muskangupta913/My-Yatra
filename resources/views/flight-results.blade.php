<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Results</title>
</head>
<body>
    <div class="header">
        <h1>Flight Results</h1>
    </div>

    <div class="results-container">
        <h2>Search Summary:</h2>
        <p><strong>From:</strong> {{ $flights['from'] }}</p>
        <p><strong>To:</strong> {{ $flights['to'] }}</p>
        <p><strong>Departure Date:</strong> {{ $flights['departure'] }}</p>
        @if ($flights['return'])
        <p><strong>Return Date:</strong> {{ $flights['return'] }}</p>
        @endif
        <p><strong>Passengers:</strong> {{ $flights['passengers'] }}</p>
        <p><strong>Class:</strong> {{ ucfirst($flights['class']) }}</p>
    </div>
</body>
</html>