@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    <h2>🎉 Booking Successful!</h2>
    <p>Your car booking has been successfully confirmed, and the payment was processed successfully.</p>
    <p>Thank you for choosing our service. Have a great trip!</p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Go to Home</a>
</div>
@endsection
