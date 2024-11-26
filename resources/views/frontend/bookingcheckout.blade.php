<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Booking Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Booking ID: {{ $booking->id }}</h5>
                <p><strong>Package Name:</strong> {{ $booking->package ? $booking->package->package_name : 'Not available' }}</p>
                <p><strong>Full Name:</strong> {{ $booking->full_name }}</p>
                <p><strong>Phone:</strong> {{ $booking->phone }}</p>
                <p><strong>Email:</strong> {{ $booking->email }}</p>
                <p><strong>Adults:</strong> {{ $booking->adults }}</p>
                <p><strong>Children:</strong> {{ $booking->children }}</p>
                <p><strong>Travel Date:</strong> {{ $booking->travel_date }}</p>
            </div>
        </div>
    </div>
</body>
</html>
