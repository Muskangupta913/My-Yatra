@extends('frontend.layouts.master')

<style>
    .process-btn {
        margin-top: 5%;
        font-size: 16px;
        padding: 12px 30px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: bold;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .process-btn:hover {
        background-color: #0069d9;
        transform: scale(1.05);
    }

    .process-btn:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    }

    .process-btn:active {
        background-color: #0056b3;
        transform: scale(1);
    }
</style>

@section('content')

    <!-- Modal for Car Booking -->
    <div class="modal fade show" id="carBookingModal" tabindex="-1" aria-labelledby="carBookingModalLabel" aria-hidden="true" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="carBookingModalLabel">Car Booking Form</h5>
                    <button type="button" class="close" aria-label="Close"
                        onclick="window.location.href='{{ route('cars') }}'">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="container mt-4">
                    <!-- Display selected car details -->
                    <div id="selected-car-details">
                        <h5>Car: <span id="car-category"></span></h5>
                        <p><strong>Total Amount:</strong> ₹<span id="car-total-amount"></span></p>
                    </div>
                </div>

                <div class="modal-body">
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Booking Form -->
    <form id="paymentForm" action="{{ route('car.book') }}" method="POST">
        @csrf

        <!-- Customer Information Fields -->
        <div class="form-group">
            <label for="CustomerName">Customer Name</label>
            <input type="text" name="CustomerName" id="CustomerName" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="CustomerPhone">Customer Phone</label>
            <input type="text" name="CustomerPhone" id="CustomerPhone" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="CustomerEmail">Customer Email</label>
            <input type="email" name="CustomerEmail" id="CustomerEmail" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="CustomerAddress">Customer Address</label>
            <input type="text" name="CustomerAddress" id="CustomerAddress" class="form-control" required>
        </div>

        <input type="hidden" name="EndUserIp" value="1.1.1.1">
        <input type="hidden" name="ClientId" value="180133">
        <input type="hidden" name="UserName" value="MakeMy91">
        <input type="hidden" name="Password" value="MakeMy@910">
        <input type="hidden" name="SrdvIndex" value="SRDV-2">
        <input type="hidden" name="TraceID" value="1">
        <input type="hidden" name="PickUpTime" value="18:00">
        <input type="hidden" name="DropUpTime" value="18:00">
        <input type="hidden" name="RefID" value="77894">

        <input type="hidden" name="amount" value="{{ $totalAmount ?? 0 }}">
        <button type="button" id="checkWalletBtn" class="btn btn-primary process-btn">Process To Pay</button>
    </form>
</div>

        </div>
    </div>
    <div id="paymentResponse"></div>
    <!-- <div class="container mt-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <h1>Car Booking Successful</h1>
        <p>Thank you for your booking. Your payment was processed successfully.</p>
        <a href="{{ route('cars') }}" class="btn btn-primary">Back to Car Listings</a>
    </div> -->
    <!-- Scripts -->
    <!-- <script>
    document.getElementById('processPaymentBtn').addEventListener('click', function () {
    const formData = {
        EndUserIp: '1.1.1.1',
        ClientId: '180189',
        UserName: 'MakeMy91',
        Password: 'MakeMy@910',
        SrdvIndex: 'SRDV-2',
        TraceID: '1',
        PickUpTime: '18:00',
        DropUpTime: '18:00',
        RefID: '77894',
        CustomerName: document.querySelector('[name="CustomerName"]').value,
        CustomerPhone: document.querySelector('[name="CustomerPhone"]').value,
        CustomerEmail: document.querySelector('[name="CustomerEmail"]').value,
        CustomerAddress: document.querySelector('[name="CustomerAddress"]').value
    };

    fetch('{{ route("car.book") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            alert('Payment Successful!');
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script> -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const carCategory = sessionStorage.getItem('selectedCategory');
            const carTotalAmount = sessionStorage.getItem('selectedTotalAmount');
            if (carCategory && carTotalAmount) {
                document.getElementById('car-category').textContent = carCategory;
                document.getElementById('car-total-amount').textContent = carTotalAmount;
            }
        });

        $(document).ready(function () {
            $('#carBookingModal').modal('show');
        });

        // optional
        $(document).ready(function () {
    $('#booking-form').on('submit', function () {
        setTimeout(() => {
            window.location.href = "{{ route('car.bookingSuccess') }}";
        }, 3000);
    });
});
    </script>

<script>
    document.getElementById('checkWalletBtn').addEventListener('click', function () {
        const amount = document.querySelector('input[name="amount"]').value;

        fetch("{{ route('car.checkWallet') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ amount: amount })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect to payment page
                window.location.href = "{{ route('payment') }}";
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to check wallet balance. Please try again.');
        });
    });

    // get the data 
    document.getElementById('checkWalletBtn').addEventListener('click', function () {
        // Collect form data
        const customerName = document.getElementById('CustomerName').value;
        const customerPhone = document.getElementById('CustomerPhone').value;
        const customerEmail = document.getElementById('CustomerEmail').value;
        const customerAddress = document.getElementById('CustomerAddress').value;
        const carCategory = document.getElementById('car-category').innerText;
        const carTotalAmount = document.getElementById('car-total-amount').innerText;

        // Store data in localStorage
        localStorage.setItem('carBookingData', JSON.stringify({
            customerName,
            customerPhone,
            customerEmail,
            customerAddress,
            carCategory,
            carTotalAmount
        }));

        // Redirect to payment page
        window.location.href = "{{ route('payment') }}";
    });

</script>

@endsection
