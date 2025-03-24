<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Failed</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .error-container {
            margin-top: 100px;
        }
        
        .error-icon {
            color: #dc3545;
            margin-bottom: 20px;
        }
        
        .error-details {
            margin-top: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            word-break: break-word;
        }
        
        .action-buttons {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 error-container text-center">
            <i class="fas fa-times-circle fa-5x error-icon"></i>
            <h2>Booking Failed</h2>
            <p class="lead">We encountered an issue while processing your booking.</p>
            
            <div class="error-details">
                <h5>Error Details:</h5>
                <p id="errorMessage">Unknown error</p>
            </div>
            
            <div class="support-info alert alert-info mt-4">
                <h5><i class="fas fa-headset mr-2"></i>Need assistance?</h5>
                <p>Please contact our support team for help with your booking:</p>
                <p class="font-weight-bold">Call: <a href="tel:+911234567890">+91 1204223100 </a></p>
                <p>Email: <a href="mailto:support@example.com">support@makemybharatyatra.com</a></p>
                <p class="small">Available Monday to Saturday, 9:00 AM to 6:00 PM</p>
            </div>
            
            <div class="action-buttons mt-4">
                <a href="/" class="btn btn-primary mr-3">Go to Home</a>
                <a href="/" class="btn btn-success mr-3">Search Again</a>
                <button id="retryBooking" class="btn btn-warning">Retry Booking</button>
            </div>
        </div>
    </div>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get error message and booking details from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const errorMsg = urlParams.get('error');
            const traceId = urlParams.get('trace_id');
            const resultIndex = urlParams.get('result_index');
            
            // Display error message if available
            if (errorMsg) {
                document.getElementById('errorMessage').textContent = decodeURIComponent(errorMsg);
            }
            
            // Setup retry booking button if we have the necessary parameters
            const retryButton = document.getElementById('retryBooking');
            if (traceId && resultIndex) {
                retryButton.addEventListener('click', function() {
                    // Retrieve saved data from sessionStorage
                    const boardingPoint = JSON.parse(sessionStorage.getItem("BoardingPoint"));
                    const droppingPoint = JSON.parse(sessionStorage.getItem("DroppingPoint"));
                    const passengerDetails = JSON.parse(sessionStorage.getItem("passengerDetails"));
                    
                    if (!boardingPoint || !droppingPoint || !passengerDetails) {
                        alert("Required booking information not found. Please search again.");
                        window.location.href = '/search';
                        return;
                    }
                    
                    // Redirect to payment page to retry the booking
                    window.location.href = `/payment?trace_id=${traceId}&result_index=${resultIndex}`;
                });
            } else {
                // Hide the retry button if we don't have the necessary info
                retryButton.style.display = 'none';
            }
        });
    </script>
</body>
</html>