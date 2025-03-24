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
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .debug-section {
            margin-top: 30px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        h2,
        h3 {
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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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
    @if (session('success'))
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

    @if (session('bookingDetails'))
        <button onclick="toggleDetails()">Toggle Booking Details</button>
        <div id="details" style="display: none;">
            <div class="detail-section">
                <h3>Booking Information</h3>
                @php $bookingDetails = session('bookingDetails'); @endphp

                @if (isset($bookingDetails['personal_info']))
                    <h4>Personal Information</h4>
                    <p><strong>Name:</strong> {{ $bookingDetails['personal_info']['name'] ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> {{ $bookingDetails['personal_info']['email'] ?? 'N/A' }}</p>
                    <p><strong>Phone:</strong> {{ $bookingDetails['personal_info']['phone'] ?? 'N/A' }}</p>
                @endif

                @if (isset($bookingDetails['trip_info']))
                    <h4>Trip Information</h4>
                    <p><strong>Pickup:</strong> {{ $bookingDetails['trip_info']['pickup_address'] ?? 'N/A' }}</p>
                    <p><strong>Dropoff:</strong> {{ $bookingDetails['trip_info']['drop_address'] ?? 'N/A' }}</p>
                    <p><strong>Pickup Time:</strong> {{ $bookingDetails['trip_info']['pickup_time'] ?? 'N/A' }}</p>
                    <p><strong>Dropoff Time:</strong> {{ $bookingDetails['trip_info']['drop_time'] ?? 'N/A' }}</p>
                    <p><strong>Booking Date:</strong> {{ $bookingDetails['trip_info']['booking_date'] ?? 'N/A' }}</p>
                @endif

                @if (isset($bookingDetails['car_info']))
                    <h4>Car Information</h4>
                    <p><strong>Category:</strong> {{ $bookingDetails['car_info']['category'] ?? 'N/A' }}</p>
                    <p><strong>Seating:</strong> {{ $bookingDetails['car_info']['seating'] ?? 'N/A' }}</p>
                    <p><strong>Luggage:</strong> {{ $bookingDetails['car_info']['luggage'] ?? 'N/A' }}</p>
                    <p><strong>Price:</strong> {{ $bookingDetails['car_info']['price'] ?? 'N/A' }}</p>
                    <p><strong>Base Fare:</strong> {{ $bookingDetails['car_info']['base_fare'] ?? 'N/A' }}</p>
                    <p><strong>TraceID:</strong> {{ session('trace_id') ?? 'N/A' }}</p>
                    <p><strong>SrdvIndex:</strong> {{ session('srdv_index') ?? 'N/A' }}</p>
                @endif
            </div>
        </div>
    @endif
    <div id="api-response" style="display: none;" class="detail-section">
        <!-- This section is hidden and will not be displayed -->
    </div>

    <div id="booking-response" style="display: none;" class="detail-section">
        <!-- This section is hidden and will not be displayed -->
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
    // Hide loader once page is loaded
    document.getElementById('page-loader').style.display = 'none';
    
    // Get the trace ID and base fare from session data
    const traceId = "{{ session('trace_id') }}";
    const baseFare = "{{ session('bookingDetails.car_info.base_fare') ?? 0 }}";
    
    // Check if we have necessary data and automatic processing hasn't happened yet
    // You can add a check for session('balance_log_response') to avoid duplicate calls
    if (traceId && baseFare > 0 && !"{{ session('balance_log_response') ? 'true' : 'false' }}") {
        // Call the sequence of APIs
        callSequentialApis(traceId, baseFare);
    }
});

function toggleDetails() {
    const details = document.getElementById('details');
    if (details.style.display === 'none') {
        details.style.display = 'block';
    } else {
        details.style.display = 'none';
    }
}

function callSequentialApis(traceId, baseFare) {
    console.log('Starting sequential API calls with:', {
        traceId,
        baseFare
    });
    
    // Show loader while processing
    document.getElementById('page-loader').style.display = 'flex';
    
    callBalanceLogApi(traceId, baseFare)
        .then(balanceLogResponse => {
            if (balanceLogResponse.success) {
                console.log('Balance Log API successful, now calling Car Booking API');
                const refId = balanceLogResponse.result?.RefID;
                console.log('Extracted RefID from Balance Log:', refId);
                return callCarBookingApi(refId);
            } else {
                console.error('Balance Log API failed, not proceeding to Car Booking API');
                throw new Error('Balance Log API failed: ' + (balanceLogResponse.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error in API sequence:', error);
        })
        .finally(() => {
            // Hide loader when done
            document.getElementById('page-loader').style.display = 'none';
        });
}

function callBalanceLogApi(traceId, baseFare) {
    return new Promise((resolve, reject) => {
        console.log('Calling Balance Log API with:', {
            traceId,
            baseFare
        });
        const payload = {
            type: 'balance-log',
            trace_id: traceId,
            base_fare: parseFloat(baseFare)
        };
        fetch('/process-booking-apis', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                console.log('Balance Log API Response:', data);
                resolve(data);
            })
            .catch(error => {
                console.error('Error calling Balance Log API:', error);
                reject(error);
            });
    });
}

function callCarBookingApi(refId) {
    return new Promise((resolve, reject) => {
        console.log('Calling Car Booking API with RefID:', refId);
        const payload = {
            type: 'car-booking',
            ref_id: refId || null
        };
        fetch('/process-booking-apis', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                console.log('Car Booking API Response:', data);
                resolve(data);
            })
            .catch(error => {
                console.error('Error calling Car Booking API:', error);
                reject(error);
            });
    });
}
    </script>
</body>

</html>
