<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>Payment Successfull</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
      /* Processing overlay styles */
      .processing-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7); /* Darker background for better hiding */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999; /* High z-index to ensure it's on top */
        backdrop-filter: blur(3px); /* Adding blur effect for better hiding */
    }
    
    .processing-content {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        text-align: center;
        max-width: 500px;
        width: 90%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    
    .spinner {
        margin: 20px auto;
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
</head>
<body>
<!-- ADDED: Processing overlay -->
<div id="processingOverlay" class="processing-overlay">
    <div class="processing-content">
        <h3>Please wait...</h3>
        <div class="spinner"></div>
        <p id="processingMessage">Please wait while we process your booking...

Don't close this window</p>
        <p id="processingStatus">Processing...</p>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header bg-success text-white">Booking Successful</div>

                <div class="card-body text-center">
                    <i class="fa fa-check-circle fa-5x text-success mb-3"></i>
                    <h2>Thank You!</h2>
                    <p class="lead">Your booking has been confirmed.</p>
                    
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    function hideProcessingOverlay() {
    document.getElementById('processingOverlay').style.display = 'none';
}
// Retrieve boarding and dropping points from sessionStorage
const boardingPoint = JSON.parse(sessionStorage.getItem("BoardingPoint"));
const droppingPoint = JSON.parse(sessionStorage.getItem("DroppingPoint"));

console.log(boardingPoint); // { Id: value, Name: "value" }
console.log(droppingPoint); // { Id: value, Name: "value" }

const boardingPointId = boardingPoint ? boardingPoint.Id : null;
const droppingPointId = droppingPoint ? droppingPoint.Id : null;

const urlParams = new URLSearchParams(window.location.search);

// Logging raw URL parameters for debugging
console.log("Full URL Params:", Object.fromEntries(urlParams));

// Parse each parameter
const paymentId = urlParams.get('payment_id');
const traceId = urlParams.get('trace_id');
const amount = urlParams.get('amount');
const resultIndex = urlParams.get('result_index');

// Parse passenger data (URL-encoded)
const passengerDataEntries = Array.from(urlParams.entries())
    .filter(([key]) => key.startsWith('passenger_data'));

const passengerData = passengerDataEntries.reduce((acc, [key, value]) => {
    const parts = key.match(/passenger_data\[(\d+)\]\[([^\]]+)\](?:\[([^\]]+)\])?(?:\[([^\]]+)\])?/);
    
    if (parts) {
        const [, index, firstLevel, secondLevel, thirdLevel] = parts;
        
        // Initialize nested structure if not exists
        acc[index] = acc[index] || {};
        
        if (!secondLevel) {
            // Simple first-level property
            acc[index][firstLevel] = value;
        } else if (!thirdLevel) {
            // Nested object (like SeatDetails)
            acc[index][firstLevel] = acc[index][firstLevel] || {};
            acc[index][firstLevel][secondLevel] = value;
        } else {
            // Deeper nested structure if needed
            acc[index][firstLevel] = acc[index][firstLevel] || {};
            acc[index][firstLevel][secondLevel] = acc[index][firstLevel][secondLevel] || {};
            acc[index][firstLevel][secondLevel][thirdLevel] = value;
        }
    }
    
    return acc;
}, {});

console.log("Parsed Passenger Data:", JSON.stringify(passengerData, null, 2));

console.log("Payment ID:", paymentId);
console.log("Trace ID:", traceId);
console.log("Amount:", amount);
console.log("Result Index:", resultIndex);
console.log("Passenger Data Seat Number:", passengerData[0].SeatDetails.SeatNumber);

const storedPassengerDetails = JSON.parse(sessionStorage.getItem("passengerDetails")) || [];
console.log('block api response', storedPassengerDetails);

// Fetch balance log and proceed with booking
fetch(`/balance-log?TraceId=${traceId}&amount=${amount}`, {
    method: "GET",
    headers: {
        "Content-Type": "application/json",
    },
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        const balanceLog = data.balanceLogs[0];
        
        if (balanceLog) {
            // Prepare booking request
            const bookingData = {
                ResultIndex: resultIndex,
                TraceId: traceId,
                BoardingPointId: boardingPointId,
                DroppingPointId: droppingPointId,
                RefID: "1",
                Passenger: [{
                    LeadPassenger: true,
                    PassengerId: 0,
                    Title: passengerData[0].Title,
                    FirstName: passengerData[0].FirstName,
                    LastName: passengerData[0].LastName,
                    Email: passengerData[0].Email,
                    Phoneno: passengerData[0].Mobile,
                    Gender: passengerData[0].Gender,
                    IdType: null,
                    IdNumber: null,
                    Address: passengerData[0].Address,
                    Age: passengerData[0].Age,
                    Seat: {
                        ColumnNo: passengerData[0].SeatDetails.SeatNumber,
                        Height: 1,
                        IsLadiesSeat: false,
                        IsMalesSeat: false,
                        IsUpper: passengerData[0].SeatDetails.Deck === 'Upper',
                        RowNo: "000",
                        SeatFare: parseFloat(amount),
                        SeatIndex: parseInt(passengerData[0].SeatDetails.SeatIndex),
                        SeatName: passengerData[0].SeatDetails.SeatName,
                        SeatStatus: true,
                        SeatType: passengerData[0].SeatDetails.SeatType === 'Seater' ? 1 : 0,
                        Width: 1,
                        Price: {
                            CurrencyCode: "INR",
                            BasePrice: parseFloat(amount),
                            Tax: 0,
                            OtherCharges: 0,
                            Discount: 0,
                            PublishedPrice: parseFloat(amount),
                            PublishedPriceRoundedOff: parseFloat(amount),
                            OfferedPrice: parseFloat(amount),
                            OfferedPriceRoundedOff: parseFloat(amount),
                            AgentCommission: 0,
                            AgentMarkUp: 0,
                            TDS: 0,
                            GST: {
                                CGSTAmount: 0,
                                CGSTRate: 0,
                                CessAmount: 0,
                                CessRate: 0,
                                IGSTAmount: 0,
                                IGSTRate: 18,
                                SGSTAmount: 0,
                                SGSTRate: 0,
                                TaxableAmount: 0
                            }
                        }
                    }
                }]
            };

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            // Make the booking API call
            return fetch('/bookbus', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(bookingData)
            });
        } else {
            throw new Error("No balance log found");
        }
    } else {
        throw new Error(data.errorMessage || "Balance log failed");
    }
}) 

.then(response => response.json())
.then(bookingResult => {
    if (bookingResult.status === 'success') {
        hideProcessingOverlay();
        // alert(`Booking Successful!\nTicket Number: ${bookingResult.data.TicketNo}\nStatus: ${bookingResult.data.BusBookingStatus}`);
    } 
    else {
        // Redirect to failed page with error message
        window.location.href = `/payments/failed?message=${encodeURIComponent(bookingResult.message || "Booking failed")}`;
    }
})
.catch(error => {
    console.error("Error:", error);
    alert("An error occurred: " + error.message);
});
  
    // Replace the existing cancel booking event listener with this
// document.getElementById("cancelBookingButton").addEventListener("click", function (event) {
//     event.preventDefault();

//     // Get TraceId and passenger data from URL
//     const urlParams = new URLSearchParams(window.location.search);
//     const passengerDataStr = urlParams.get('PassengerData');
    
//     if (!passengerDataStr) {
//         alert("Missing passenger data!");
//         return;
//     }

//     // Parse the passenger data
//     let passengerData;
//     try {
//         passengerData = JSON.parse(decodeURIComponent(passengerDataStr));
//     } catch (e) {
//         console.error("Error parsing passenger data:", e);
//         alert("Invalid passenger data format");
//         return;
//     }

//     // Extract BusId and SeatId from passenger data
//     const busId = String(passengerData.Seat?.SeatIndex || passengerData.SeatDetails?.SeatIndex);
//     const seatId = passengerData.Seat?.SeatName || passengerData.SeatDetails?.SeatName;
//     console.log(typeof busId, busId);

//     if (!busId || !seatId) {
//         alert("Required booking information not found!");
//         return;
//     }

//     // Show confirmation dialog
//     if (!confirm("Are you sure you want to cancel this booking?")) {
//         return;
//     }

//     // Prepare payload for cancel API
//     const payload = {
//         "EndUserIp": "1.1.1.1", // You might want to get actual IP
//         ClientId: apiConfig.client_id, // Use embedded config values
//     UserName: apiConfig.username,
//     Password: apiConfig.password,
//         'BusId': "11836",
//         'SeatId': seatId,
//         'Remarks': "User requested cancellation"
//     };

//     // Get CSRF token
//     const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

//     // Make the cancel API call
//     fetch("/cancelBus", {
//         method: "POST",
//         headers: {
//             "Content-Type": "application/json",
//             "X-CSRF-TOKEN": csrfToken
//         },
//         body: JSON.stringify(payload)
//     })
//     .then(response => {
//         if (!response.ok) {
//             throw new Error('Network response was not ok');
//         }
//         return response.json();
//     })
//     .then(data => {
//         if (data.status === 'success') {
//             alert("Booking cancelled successfully!");
//             // Optionally redirect to a different page
//             // window.location.href = '/booking-history';
//         } else {
//             alert("Failed to cancel booking: " + (data.message || "Unknown error"));
//         }
//     })
//     .catch(error => {
//         console.error("Error:", error);
//         alert("An error occurred while canceling the booking. Please try again later.");
//     });
// });




    
    

    // Extract URL parameters
  
    </script>
</body>
</html>
 
