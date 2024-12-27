@extends('frontend.layouts.master')
@section('title', 'Booking Confirmation')
@section('content')

<!-- Add the CSRF meta tag in the header -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Add Font Awesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<div class="container mt-5" id="bookingContainer" style="max-width: 1200px; padding: 30px; background: linear-gradient(135deg, #f0f4f8, #ffffff); border-radius: 15px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1); font-family: 'Arial', sans-serif; color: #333;">
    <div id="bookingDetails">
        <h2 class="text-center" style="font-size: 36px; font-weight: 700; color: #1fb86b; margin-bottom: 30px; text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.1);">
            <i class="fas fa-check-circle" style="color: #28a745; margin-right: 10px;"></i>Booking Confirmation
        </h2>

        <div class="row" style="display: flex; justify-content: space-between; gap: 20px;">
    <!-- Left Sidebar: Passenger Details -->
    <div id="passengerDetails" class="card" style="flex: 0 1 20%; max-width: 20%; background-color: #ffffff; padding: 20px; border: none ; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column;">
        <h4 style="font-size: 22px; color: #555; margin-bottom: 20px;">
            <i class="fas fa-user" style="color: #007bff; margin-right: 10px;"></i>Passenger Details
        </h4>
        <div id="passengerContent" style="flex-grow: 1;">
            <p style="font-size: 16px; color: #555;">Loading passenger details...</p>
        </div>
    </div>

    <!-- Center: Booking Details (Flexible and larger) -->
    <div id="bookingContent" class="card" style="flex: 1 1 50%; max-width: 50%; background-color: #ffffff; padding: 20px; border: 2px solid #28a745; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column;">
        <h4 style="font-size: 22px; color: #555; margin-bottom: 20px;">
            <i class="fas fa-ticket-alt" style="color: #ffc107; margin-right: 10px;"></i>Booking Details
        </h4>
        <div id="bookingContentText" style="flex-grow: 1;">
            <p style="font-size: 16px; color: #555;">Loading booking details...</p>
        </div>
        <div style="text-align: center; margin-top: 20px;">
       
    </div>
    </div>

    <!-- Right Sidebar: Pickup & Dropping Details -->
    <div id="pickupDropDetails" class="card" style="flex: 0 1 20%; max-width: 20%; background-color: #ffffff; padding: 20px; border: none; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column;">
        <h4 style="font-size: 22px; color: #555; margin-bottom: 20px;">
            <i class="fas fa-map-marker-alt" style="color: #ff5733; margin-right: 10px;"></i>Pickup & Drop
        </h4>
        <!-- Pickup and Dropping Information in Flex layout -->
        <div class="row" style="display: flex; gap: 20px;">
            <!-- Pickup Point -->
            <div class="pickupSection" style="flex: 1; background-color: #f9f9f9; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                <h5 style="font-size: 18px; color: #555; margin-bottom: 10px;">
                    <i class="fas fa-arrow-alt-circle-right" style="color: #28a745; margin-right: 10px;"></i>Pickup Points:
                </h5>
                <p style="font-size: 16px; color: #555;" id="pickupPoint"></p>
            </div>

            <!-- Dropping Point -->
            <div class="dropSection" style="flex: 1; background-color: #f9f9f9; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                <h5 style="font-size: 18px; color: #555; margin-bottom: 10px;">
                    <i class="fas fa-arrow-alt-circle-left" style="color: #ff5733; margin-right: 10px;"></i>Dropping Points:
                </h5>
                <p style="font-size: 16px; color: #555;" id="droppingPoint"></p>
            </div>
        </div>
    </div>
    
    <button id="cancelBookingButton" class="btn btn-danger mt-4">Cancel Booking</button>
    <!-- Pay Now Button -->
    <a href="#" id="payNowButton" class="btn btn-success mt-4">Pay Now</a>
</div>

    </div>
</div>

<<<<<<< HEAD
    // Display the booking details on the page
    document.getElementById('bookingDetails').innerHTML = `
        <h2>Booking Confirmation</h2>
        <p><strong>Trace ID:</strong> ${traceId}</p>
        <p><strong>Status:</strong> ${busBookingStatus}</p>
        <p><strong>Invoice Amount:</strong> ₹${invoiceAmount}</p>
        <p><strong>Bus ID:</strong> ${busId}</p>
        <p><strong>Ticket No:</strong> ${ticketNo}</p>
        <p><strong>Travel Operator PNR:</strong> ${travelOperatorPNR}</p>
    `;

    // Set the "Pay Now" button link dynamically
    document.getElementById('payNowButton').href = `/payment?TraceId=${traceId}&InvoiceAmount=${invoiceAmount}`;

    // Cancel booking button click event
    document.getElementById('cancelBookingButton').addEventListener('click', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Prepare the cancellation request payload
        const cancelPayload = {
            'EndUser Ip': '1.1.1.1', // You can dynamically get the user's IP here if needed
            'ClientId': '180133',  // Pass the correct ClientId
            'User Name': 'MakeMy91',  // Pass the correct UserName
            'Password': 'MakeMy@910',
            'BusId': busId,
            'SeatId': ticketNo, // Assuming ticketNo is used as SeatId
            'Remarks': "User requested cancellation" // You can customize this
        };

        // Make the API request to cancel the booking
        fetch('/cancelBus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(cancelPayload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Booking cancelled successfully!');
                // Optionally, you can redirect to another page or show cancellation details
            } else {
                alert('Cancellation failed: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    });






    document.getElementById('payNowButton').addEventListener('click', function (e) {
    e.preventDefault();

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const traceId = urlParams.get('TraceId');
    const invoiceAmount = urlParams.get('InvoiceAmount');

    fetch('/handlebalance', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            TraceId: traceId,
            InvoiceAmount: invoiceAmount
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`Payment successful! 
                   Wallet Payment: ₹${data.walletPayment}, 
                   User Payment: ₹${data.userPayment}`);
        } else {
            alert('Payment failed: ' + data.error);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
});
=======
<!-- Scoped CSS for Booking Confirmation -->
<style>
    /* Pickup & Dropping Styling */
    #pickupDropDetails .pickupSection, 
    #pickupDropDetails .dropSection {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    #pickupDropDetails .pickupSection h5,
    #pickupDropDetails .dropSection h5 {
        font-size: 18px;
        color: #555;
    }

    #pickupDropDetails .pickupSection p,
    #pickupDropDetails .dropSection p {
        font-size: 16px;
        color: #555;
    }

    /* Ensure the Pickup and Drop Sections are next to each other */
    #pickupDropDetails .row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    @media (max-width: 768px) {
        /* Stack Pickup and Drop Sections on smaller screens */
        #pickupDropDetails .row {
            flex-direction: column;
        }
    }
</style>
<script>
<!-- JavaScript to populate data dynamically -->
// Get URL parameters
const urlParams = new URLSearchParams(window.location.search);
const traceId = urlParams.get('TraceId');
const busBookingStatus = urlParams.get('BusBookingStatus');
const invoiceAmount = urlParams.get('InvoiceAmount');
const busId = urlParams.get('BusId');
const ticketNo = urlParams.get('TicketNo');
const travelOperatorPNR = urlParams.get('TravelOperatorPNR');
const boardingPointName = urlParams.get('BoardingPointName');
const droppingPointName = urlParams.get('DroppingPointName');
const passengerData = urlParams.get('PassengerData');

let passengerDetailsHTML = '';
if (passengerData) {
    const passenger = JSON.parse(decodeURIComponent(passengerData));
    passengerDetailsHTML = `
        <p style="font-size: 16px; margin: 10px 0;"><strong>Name:</strong> ${passenger.FirstName} ${passenger.LastName}</p>
        <p style="font-size: 16px; margin: 10px 0;"><strong>Phone Number:</strong> ${passenger.Phoneno}</p>
        <p style="font-size: 16px; margin: 10px 0;"><strong>Seat No:</strong> ${passenger.Seat.SeatName}</p>
        <p style="font-size: 16px; margin: 10px 0;"><strong>Address:</strong> ${passenger.Address}</p>
    `;
} else {
    passengerDetailsHTML = "<p style='font-size: 16px;'>No passenger details available.</p>";
}

const bookingDetailsHTML = `
    <h4 style="font-size: 22px; color: #555; margin-bottom: 20px; flex: 0 1 auto;">
        <i class="fas fa-ticket-alt" style="color: #ffc107; margin-right: 10px;"></i>Booking Details
    </h4>
    <p style="font-size: 16px; margin: 10px 0;"><strong>Trace ID:</strong> ${traceId}</p>
    <p style="font-size: 16px; margin: 10px 0;"><strong>Status:</strong> 
        <span style="color: ${busBookingStatus === 'Confirmed' ? '#28a745' : '#dc3545'}; font-weight: bold;">
            ${busBookingStatus}
        </span>
    </p>
    <p style="font-size: 16px; margin: 10px 0;"><strong>Ticket No:</strong> ${ticketNo}</p>
    <p style="font-size: 16px; margin: 10px 0;"><strong>Travel Operator PNR:</strong> ${travelOperatorPNR}</p>
    <p style="font-size: 16px; margin: 10px 0;"><strong>Invoice Amount:</strong> ₹${invoiceAmount}</p>
    <p style="font-size: 16px; margin: 10px 0;"><strong>Bus ID:</strong> ${busId}</p>
    <button onclick="proceedToPay()" style="background-color: #28a745; color: #ffffff; border: none; padding: 12px 30px; font-size: 16px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">
            Proceed to Pay
        </button>
`;

// Assign Pickup and Dropping Points to HTML dynamically
document.getElementById('pickupPoint').innerHTML = boardingPointName ? boardingPointName : "Pickup point not available.";
document.getElementById('droppingPoint').innerHTML = droppingPointName ? droppingPointName : "Dropping point not available.";

// Populate the booking page dynamically
document.getElementById('passengerContent').innerHTML = passengerDetailsHTML;
document.getElementById('bookingContent').innerHTML = bookingDetailsHTML;
>>>>>>> dc0049519ec35ab7ed7f4ccb1224081277f406b0
</script>


@endsection
