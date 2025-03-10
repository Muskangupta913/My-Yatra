<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .success-box {
            background-color: #d4edda;
            color: #155724;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .error-box {
            background-color: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .detail-section {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .debug-section {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        h2, h3 {
            color: #333;
        }
        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 4px;
            overflow-x: auto;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 15px;
        }
        button:hover {
            background-color: #45a049;
        }
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 2s linear infinite;
            display: inline-block;
            margin-right: 10px;
            vertical-align: middle;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        .status-success {
            background-color: #28a745;
        }
        .status-error {
            background-color: #dc3545;
        }
        .status-pending {
            background-color: #ffc107;
        }
        .api-status {
            font-weight: bold;
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            flex-direction: column;
        }
        .page-loader .loader {
            margin-bottom: 20px;
        }
        .page-loader h1 {
            font-size: 24px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="page-loader" id="page-loader">
        <div class="loader"></div>
        <h1>Make My Bharat Yatra</h1>
    </div>
    @if(session('success'))
        <div class="success-box">
            <h1>Payment Successful!</h1>
            <p>{{ session('success') }}</p>
            <p>Your booking is being processed...</p>
        </div>
    @elseif(session('error'))
        <div class="error-box">
            <h1>Warning</h1>
            <p>{{ session('error') }}</p>
        </div>
    @else
        <div class="success-box">
            <h1>Payment Successful!</h1>
            <p>Your booking is being processed...</p>
        </div>
    @endif

    <!-- API Debug Information -->
    <button onclick="toggleBookingStatus()" style="display: none;">Toggle Booking Status</button>
    <div class="debug-section" id="booking-status-section" style="display: none;">
        <h2>Booking Status</h2>
        <!-- Balance Log API Response -->
        <div class="detail-section" id="balance-log-section" style="display: none;">
            <div class="api-status" id="balance-log-status">
                <span class="status-indicator status-pending"></span>
                Balance Log API: Checking balance...
            </div>
            <div id="balance-log-response">
                <div class="loader"></div> Processing balance check...
            </div>
        </div>
        <button onclick="toggleBalanceLog()">Toggle Balance Log</button>
        <!-- Car Booking API Response -->
        <div class="detail-section">
            <div class="api-status" id="car-booking-status">
                <span class="status-indicator status-pending"></span>
               
            </div>
            <div id="car-booking-response">
                <p>Waiting for balance check to complete...</p>
            </div>
        </div>
        <!-- Exception Details if any -->
        @if(session('exception_details'))
            <div class="detail-section">
                <h3>Exception Details</h3>
                <pre>{{ json_encode(session('exception_details'), JSON_PRETTY_PRINT) }}</pre>
            </div>
        @endif
    </div>

    <!-- Booking Details -->
    @if(session('bookingDetails'))
        <button onclick="toggleDetails()">Toggle Booking Details</button>
        <div id="details" style="display: none;">
            <div class="detail-section">
                <h3>Booking Information</h3>
                @php $bookingDetails = session('bookingDetails'); @endphp
                
                @if(isset($bookingDetails['personal_info']))
                <h4>Personal Information</h4>
                <p><strong>Name:</strong> {{ $bookingDetails['personal_info']['name'] ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $bookingDetails['personal_info']['email'] ?? 'N/A' }}</p>
                <p><strong>Phone:</strong> {{ $bookingDetails['personal_info']['phone'] ?? 'N/A' }}</p>
                @endif
                
                @if(isset($bookingDetails['trip_info']))
                <h4>Trip Information</h4>
                <p><strong>Pickup:</strong> {{ $bookingDetails['trip_info']['pickup_address'] ?? 'N/A' }}</p>
                <p><strong>Dropoff:</strong> {{ $bookingDetails['trip_info']['drop_address'] ?? 'N/A' }}</p>
                <p><strong>Pickup Time:</strong> {{ $bookingDetails['trip_info']['pickup_time'] ?? 'N/A' }}</p>
                <p><strong>Dropoff Time:</strong> {{ $bookingDetails['trip_info']['drop_time'] ?? 'N/A' }}</p>
                <p><strong>Booking Date:</strong> {{ $bookingDetails['trip_info']['booking_date'] ?? 'N/A' }}</p>
                @endif
                
                @if(isset($bookingDetails['car_info']))
                <h4>Car Information</h4>
                <p><strong>Category:</strong> {{ $bookingDetails['car_info']['category'] ?? 'N/A' }}</p>
                <p><strong>Seating:</strong> {{ $bookingDetails['car_info']['seating'] ?? 'N/A' }}</p>
                <p><strong>Luggage:</strong> {{ $bookingDetails['car_info']['luggage'] ?? 'N/A' }}</p>
                <p><strong>Price:</strong> {{ $bookingDetails['car_info']['price'] ?? 'N/A' }}</p>
                <p><strong>TraceID:</strong> {{ session('trace_id') ?? 'N/A' }}</p> <!-- Display trace_id -->
                <p><strong>SrdvIndex:</strong> {{ session('srdv_index') ?? 'N/A' }}</p> <!-- Display srdv_index -->
                @endif
            </div>
        </div>
    @else
        <p style="display: none;">No booking details available</p>
    @endif

    <script>
        function toggleDetails() {
            var details = document.getElementById('details');
            if (details.style.display === 'none') {
                details.style.display = 'block';
            } else {
                details.style.display = 'none';
            }
        }
        
        function toggleBalanceLog() {
            var balanceLogSection = document.getElementById('balance-log-section');
            if (balanceLogSection.style.display === 'none') {
                balanceLogSection.style.display = 'block';
            } else {
                balanceLogSection.style.display = 'none';
            }
        }

        function toggleBookingStatus() {
            var bookingStatusSection = document.getElementById('booking-status-section');
            if (bookingStatusSection.style.display === 'none') {
                bookingStatusSection.style.display = 'block';
            } else {
                bookingStatusSection.style.display = 'none';
            }
        }
        
        // Update status indicators
        function updateStatus(elementId, status, message) {
            const statusElement = document.getElementById(elementId);
            const indicator = statusElement.querySelector('.status-indicator');
            
            // Remove all status classes
            indicator.classList.remove('status-pending', 'status-success', 'status-error');
            
            // Add appropriate class
            indicator.classList.add('status-' + status);
            
            // Update message
            statusElement.innerHTML = statusElement.innerHTML.replace(/>.*<\/span>/, '>' + message + '</span>');
        }
        
        // Function to make AJAX requests
function callApi(url, data, statusElementId, responseElementId, onSuccess) {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Response is not in JSON format');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            updateStatus(statusElementId, 'success', 'Success');
            document.getElementById(responseElementId).innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
            if (onSuccess && typeof onSuccess === 'function') {
                onSuccess(data);
            }
        } else {
            updateStatus(statusElementId, 'error', 'Error: ' + (data.error || 'Unknown error'));
            document.getElementById(responseElementId).innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
        }
    })
    .catch(error => {
        updateStatus(statusElementId, 'error', 'Error: ' + error.message);
        document.getElementById(responseElementId).innerHTML = `<p>Error: ${error.message}</p>`;
    });
}
        
        // Automatically trigger APIs on page load
        document.addEventListener('DOMContentLoaded', function() {
            const bookingDetails = @json(session('bookingDetails') ?? '{}');
            
            // First call Balance Log API
            callApi('/process-booking', { 
                type: 'balance-log' 
            }, 'balance-log-status', 'balance-log-response', function(data) {
                // After successful balance log, call Car Booking API
                updateStatus('car-booking-status', 'pending', 'Processing car booking...');
                document.getElementById('car-booking-response').innerHTML = '<div class="loader"></div> Processing car booking...';
                
                callApi('/process-booking', { 
                    type: 'car-booking', 
                    bookingDetails: bookingDetails 
                }, 'car-booking-status', 'car-booking-response');
            });

            // Hide the loader after 60 seconds
            setTimeout(function() {
                document.getElementById('page-loader').style.display = 'none';
            }, 60000); // 60 seconds
        });
    </script>
</body>
</html>