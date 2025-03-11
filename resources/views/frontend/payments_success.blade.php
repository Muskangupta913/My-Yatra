<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>Payment Successful</title>
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
                        <a href="index.html" class="btn btn-primary">Back to Home</a>
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
    document.addEventListener('DOMContentLoaded', () => {
        console.log("DOM fully loaded - Starting processing...");
        
        // Check what type of booking we're processing
        const urlParams = new URLSearchParams(window.location.search);
        const flightDetailsStr = urlParams.get("details");
        const roomDetailsStr = urlParams.get("roomDetails");
        const traceId = urlParams.get("traceId");
        const busParams = urlParams.get("PassengerData");
        console.log('room details', roomDetailsStr);

         // Parse room details JSON
    
    console.log("Raw room details string:", roomDetailsStr);
    const roomDetails = roomDetailsStr ? JSON.parse(decodeURIComponent(roomDetailsStr)) : null;
    console.log("Room Details:", roomDetails);
    console.log("Room Childcount:", roomDetails.childCount);

    // Parse passenger details JSON with detailed logging
    const passengerDetailsStr = urlParams.get('passengerDetails');
    console.log("Raw passenger details string:", passengerDetailsStr);
        
        // Process the appropriate booking type
        if (flightDetailsStr) {
            console.log("Processing flight booking...");
            const bookingDetails = getBookingDetailsFromURL();
            if (bookingDetails) {
                fetchBalanceLogAndBookLCC();
            } else {
                console.error("Invalid flight booking details");
            }
        } 
        else if (roomDetailsStr) {
            console.log("Processing hotel booking...");
            const bookingData = getUrlParameters();
            console.log("Booking data:", bookingData);
            if (bookingData && bookingData.roomDetails && bookingData.passengerDetails) {
                processHotelBooking(bookingData);
            } else {
                console.error("Missing hotel booking details");
            }
        }
        else if (traceId && urlParams.get("bookingId") && urlParams.get("pnr")) {
            console.log("Processing GDS ticket...");
            fetchBalanceLogAndBookGDS();
        }
        else if (busParams) {
            console.log("Processing bus booking...");
            processBusBooking();
        }
        else {
            console.log("No specific booking details found - displaying payment confirmation only");
        }
    });

    // HOTEL RELATED FUNCTIONS
    function getUrlParameters() {
        const urlParams = new URLSearchParams(window.location.search);

        // Parse room details JSON
        const roomDetailsStr = urlParams.get('roomDetails');
        let roomDetails = null;
        
        try {
            if (roomDetailsStr) {
                roomDetails = JSON.parse(decodeURIComponent(roomDetailsStr));
                console.log("Room Details:", roomDetails);
            }
        } catch (e) {
            console.error("Error parsing room details:", e);
        }

        // Parse passenger details JSON
        const passengerDetailsStr = urlParams.get('passengerDetails');
        let passengerDetails = [];
        
        try {
            if (passengerDetailsStr) {
                const decodedStr = decodeURIComponent(passengerDetailsStr);
                const parsedData = JSON.parse(decodedStr);
                
                if (Array.isArray(parsedData)) {
                    passengerDetails = parsedData;
                } else if (typeof parsedData === 'object' && parsedData !== null) {
                    passengerDetails = [parsedData];
                }
            }
        } catch (error) {
            console.error("Error parsing passenger details:", error);
        }

        return {
            hotelDetails: {
                traceId: urlParams.get('traceId'),
                resultIndex: urlParams.get('resultIndex'),
                hotelCode: urlParams.get('hotelCode'),
                hotelName: urlParams.get('hotelName')
            },
            roomDetails: roomDetails,
            passengerDetails: passengerDetails
        };
    }

    async function processHotelBooking(bookingData) {
        try {
            if (!bookingData || !bookingData.roomDetails || !bookingData.hotelDetails.traceId) {
                throw new Error('Missing required hotel booking data');
            }

            // Prepare balance payload
            const balancePayload = {
                amount: bookingData.roomDetails.OfferedPrice,
                TraceId: bookingData.hotelDetails.traceId
            };
            

            // Call Balance API
            const balanceResponse = await fetch('/balancelog', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(balancePayload),
            });

            const balanceData = await balanceResponse.json();
            
            if (!balanceData.success) {
                throw new Error(balanceData.errorMessage || 'Insufficient balance or payment failed.');
            }

            const hotelPassengers = bookingData.passengerDetails.map(passenger => ({
                Title: passenger.Title,
                FirstName: passenger.FirstName,
                LastName: passenger.LastName,
                Phoneno: passenger.Phoneno || "",
                Email: passenger.Email || "",
                PaxType: passenger.PaxType || "1",
                LeadPassenger: passenger.LeadPassenger || false,
                PAN: passenger.PAN || ""
            }));

            const roomDetail = {
                RoomId: bookingData.roomDetails.RoomId,
                RoomStatus: "Active",
                RoomIndex: bookingData.roomDetails.RoomIndex,
                RoomTypeCode: bookingData.roomDetails.RoomTypeCode,
                RoomTypeName: bookingData.roomDetails.RoomTypeName,
                RatePlanCode: bookingData.roomDetails.RatePlanCode,
                RatePlan: bookingData.roomDetails.RatePlan,
                InfoSource: bookingData.roomDetails.InfoSource || "",
                SequenceNo: bookingData.roomDetails.SequenceNo || "",
                SmokingPreference: "0",
                ChildCount: bookingData.roomDetails.childCount || 0,
                RequireAllPaxDetails: false,
                HotelPassenger: hotelPassengers,
                Currency: bookingData.roomDetails.Currency,
                OfferedPrice: bookingData.roomDetails.OfferedPrice
            };

            const bookingPayload = {
                ResultIndex: bookingData.hotelDetails.resultIndex,
                HotelCode: bookingData.hotelDetails.hotelCode,
                HotelName: bookingData.hotelDetails.hotelName,
                GuestNationality: "IN",
                NoOfRooms: bookingData.roomDetails.NoOfRooms || 1,
                ClientReferenceNo: 0,
                IsVoucherBooking: true,
                HotelRoomsDetails: [roomDetail],
                SrdvType: "MixAPI",
                SrdvIndex: "15",
                TraceId: bookingData.hotelDetails.traceId,
                EndUserIp: "1.1.1.1",
                ClientId: "180133",
                UserName: "MakeMy91",
                Password: "MakeMy@910"
            };
 console.log('payload data', bookingPayload);
            // Call Booking API
            const bookingResponse = await fetch('/book-room', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(bookingPayload),
            });

            const bookingDataResponse = await bookingResponse.json();
            
            if (!bookingDataResponse.success) {
                const errorMessage = bookingDataResponse.errorMessage || 'Booking failed after successful payment.';
            window.location.href = `/payments/failed?message=${encodeURIComponent(errorMessage)}`;
            return;
            }
            console.log("Hotel booking completed successfully:", bookingDataResponse.bookingDetails);
            hideProcessingOverlay();
        } catch (error) {
            console.error('Error during hotel booking:', error);
            window.location.href = `/payments/failed?message=${encodeURIComponent(error.message || "An unexpected error occurred")}`;
        }
    }
   
</script>
</body>
</html>
