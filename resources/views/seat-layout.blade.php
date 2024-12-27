@extends('frontend.layouts.master')

@section('title', 'Bus Booking')

@section('content')

<!-- Add the CSRF meta tag in the header -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-4" id="busBookingContainer">
    <!-- Header Tabs -->
    <div class="row">
        <!-- Select Seat Section -->
        <div id="selectSeatSection" class="section col-12">
            <h2 class="text-center mb-4">🚌 Select Your Seat 🚌</h2>
            <div id="seatLayoutContainer" class="text-center">
                <div id="errorMessage" class="alert alert-danger d-none"></div>
                <div id="seatLayout" data-trace-id="" data-result-index=""></div>
            </div>
            <div id="selectedSeatInfo" class="mt-4 d-none">
                <h4>Selected Seat</h4>
                <p id="selectedSeatDetails"></p>
            </div>
        </div>

        <!-- Passenger Information Section -->
        <div id="passengerDetailsSection" class="section col-12 mt-4 d-none">
            <h2 class="text-center mb-4">👤 Enter Passenger Details 👤</h2>
            <form id="passengerDetailsForm">
                <div class="form-group">
                    <label for="title">Title</label>
                    <select class="form-control" id="title" name="Title" required>
                        <option value="">Select</option>
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Ms">Ms</option>
                        <option value="Dr">Dr</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="FirstName" required>
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="LastName" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="Email" required>
                </div>
                <div class="form-group">
                    <label for="phoneNumber">Phone Number</label>
                    <input type="text" class="form-control" id="phoneNumber" name="Phoneno" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control" id="gender" name="Gender" required>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" id="age" name="Age" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="Address" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-success w-100 mt-4">Block Seat</button>
            </form>
        </div>

        <!-- Pickup Point Section -->
        <div id="pickupPointSection" class="section col-12">
            <h2 class="text-center mb-4">🚏 Select Pickup Point 🚏</h2>
            <div id="pickupPointsContainer" class="pickup-points text-center">
                <p>Loading pickup points...</p>
            </div>
        </div>

        <!-- Dropping Point Section -->
        <div id="droppingPointSection" class="section col-12">
            <h2 class="text-center mb-4">📍 Select Dropping Point 📍</h2>
            <div id="droppingPointsContainer" class="dropping-points text-center">
                <p>Loading dropping points...</p>
            </div>
            <button class="btn btn-success w-100 mt-4 d-none" id="payNowButton">Book Now</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    fetchSeatLayout();
    fetchBoardingDetails();
});

let selectedSeat = null;
let selectedSeatDetails = null;
let selectedBoardingPointId = null;
let selectedDroppingPointId = null;

function fetchSeatLayout() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('TraceId');
    const resultIndex = urlParams.get('ResultIndex');

    if (!traceId || !resultIndex) {
        showError("TraceId and ResultIndex are required.");
        return;
    }

    document.getElementById('seatLayout').innerHTML = '<div class="alert alert-info">Loading seat layout...</div>';

    fetch('/getSeatLayout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            TraceId: traceId,
            ResultIndex: resultIndex
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === true) {
            renderSeatLayout(data.data.SeatLayout.SeatLayoutDetails.Layout.seatDetails);
        } else {
            throw new Error(data.message || 'Failed to load seat layout');
        }
    })
    .catch(error => {
        showError(error.message);
    });
}

function renderSeatLayout(seatDetails) {
    const seatLayoutContainer = document.getElementById('seatLayout');
    let layoutHTML = '<div class="bus-seats d-flex flex-wrap justify-content-center">';

    seatDetails.forEach(row => {
        row.forEach(seat => {
            const seatClass = seat.SeatStatus ? 'seat-available' : 'seat-booked';
            layoutHTML += `
                <div 
                    class="seat ${seatClass} m-2" 
                    onclick='selectSeat(this, ${JSON.stringify(seat)})'
                    data-seat='${JSON.stringify(seat)}'>
                    <span>${seat.SeatName}</span>
                    <br>
                    <small>₹${seat.Price.PublishedPrice}</small>
                </div>
            `;
        });
    });

    layoutHTML += '</div>';
    seatLayoutContainer.innerHTML = layoutHTML;
}

function selectSeat(element, seatData) {
    if (element.classList.contains('seat-booked')) return;

    document.querySelectorAll('.seat-selected').forEach(seat => seat.classList.remove('seat-selected'));
    element.classList.add('seat-selected');

    selectedSeatDetails = seatData;
    selectedSeat = seatData.SeatName;

    document.getElementById('selectedSeatInfo').classList.remove('d-none');
    document.getElementById('selectedSeatDetails').innerText = 
        `Seat: ${seatData.SeatName}, Price: ₹${seatData.Price.PublishedPrice}`;
    
    document.getElementById('passengerDetailsSection').classList.remove('d-none');
}

function showError(message) {
    const errorMessage = document.getElementById('errorMessage');
    errorMessage.classList.remove('d-none');
    errorMessage.innerText = message;
}

function fetchBoardingDetails() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('TraceId');
    const resultIndex = urlParams.get('ResultIndex');

    if (!traceId || !resultIndex) {
        showError("TraceId and ResultIndex are required.");
        return;
    }

    document.getElementById('pickupPointsContainer').innerHTML = 
        '<div class="alert alert-info">Loading pickup points...</div>';
    document.getElementById('droppingPointsContainer').innerHTML = 
        '<div class="alert alert-info">Loading dropping points...</div>';

    fetch('/boarding-points', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            TraceId: traceId,
            ResultIndex: resultIndex
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const result = data.GetBusRouteDetailResult.GetBusRouteDetailResult;

            if (result && result.BoardingPointsDetails && result.BoardingPointsDetails.length > 0) {
                renderPickupPoints(result.BoardingPointsDetails);
            } else {
                document.getElementById('pickupPointsContainer').innerHTML = 
                    '<div class="alert alert-warning">No pickup points available</div>';
            }

            if (result && result.DroppingPointsDetails && result.DroppingPointsDetails.length > 0) {
                renderDroppingPoints(result.DroppingPointsDetails);
            } else {
                document.getElementById('droppingPointsContainer').innerHTML = 
                    '<div class="alert alert-warning">No dropping points available</div>';
            }
        } else {
            throw new Error(data.message || 'Failed to load boarding details');
        }
    })
    .catch(error => {
        showError(error.message);
    });
}

function renderPickupPoints(pickupPoints) {
    const container = document.getElementById('pickupPointsContainer');
    container.innerHTML = pickupPoints.map(point => 
        `<div class="pickup-point border p-3 mb-2" data-point-id="${point.CityPointIndex}">
            <h5>${point.CityPointName}</h5>
            <p>📍 Location: ${point.CityPointLocation}</p>
            <p>📞 Contact: ${point.CityPointContactNumber || 'N/A'}</p>
            <button class="btn btn-primary btn-sm" 
                onclick="selectPickupPoint(${point.CityPointIndex}, '${point.CityPointName}')">
                Select
            </button>
        </div>`).join('');
}

function renderDroppingPoints(droppingPoints) {
    const container = document.getElementById('droppingPointsContainer');
    container.innerHTML = droppingPoints.map(point => 
        `<div class="dropping-point border p-3 mb-2" data-point-id="${point.CityPointIndex}">
            <h5>${point.CityPointName}</h5>
            <p>📍 Location: ${point.CityPointLocation}</p>
            <button class="btn btn-primary btn-sm" 
                onclick="selectDroppingPoint(${point.CityPointIndex}, '${point.CityPointName}')">
                Select
            </button>
        </div>`).join('');
}

document.getElementById('passengerDetailsForm').addEventListener('submit', function(e) {
    e.preventDefault();

    if (!selectedSeatDetails) {
        alert('Please select a seat before submitting passenger details.');
        return;
    }

    const passengerData = {
        LeadPassenger: true,
        Title: document.getElementById('title').value,
        FirstName: document.getElementById('firstName').value,
        LastName: document.getElementById('lastName').value,
        Email: document.getElementById('email').value,
        Phoneno: document.getElementById('phoneNumber').value,
        Gender: parseInt(document.getElementById('gender').value, 10),
        Age: parseInt(document.getElementById('age').value, 10),
        Address: document.getElementById('address').value,
        SeatDetails: selectedSeatDetails
    };

    blockSeat(passengerData);
});



function selectPickupPoint(pointId, pointName) {
    selectedBoardingPointId = pointId; // Store the selected boarding point ID globally
    alert(`Pickup Point Selected: ${pointName}`);
    
    // Optional: Highlight the selected pickup point
    document.querySelectorAll('.pickup-point').forEach(point => point.classList.remove('selected'));
    document.querySelector(`.pickup-point[data-point-id="${pointId}"]`).classList.add('selected');
}

function selectDroppingPoint(pointId, pointName) {
    selectedDroppingPointId = pointId; // Store the selected dropping point ID globally
    alert(`Dropping Point Selected: ${pointName}`);
    
    // Optional: Highlight the selected dropping point
    document.querySelectorAll('.dropping-point').forEach(point => point.classList.remove('selected'));
    document.querySelector(`.dropping-point[data-point-id="${pointId}"]`).classList.add('selected');
}

function blockSeat(passengerData) {
    if (!selectedBoardingPointId || !selectedDroppingPointId) {
        alert('Please select both boarding and dropping points before proceeding.');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('TraceId');
    const resultIndex = urlParams.get('ResultIndex');

    passengerData.Seat = {
        SeatName: selectedSeatDetails.SeatName,
        SeatStatus: selectedSeatDetails.SeatStatus,
        ColumnNo: selectedSeatDetails.ColumnNo, // Ensure this is set correctly
        RowNo: selectedSeatDetails.RowNo, // Ensure this is set correctly
        // Add any other seat-related information if needed
        Price: {
            CurrencyCode: selectedSeatDetails.Price.CurrencyCode,
            BasePrice: selectedSeatDetails.Price.BasePrice,
            Tax: selectedSeatDetails.Price.Tax,
            OtherCharges: selectedSeatDetails.Price.OtherCharges,
            Discount: selectedSeatDetails.Price.Discount,
            PublishedPrice: selectedSeatDetails.Price.PublishedPrice,
            // Add any other price-related information if needed
        }
    };

    const payload = {
        ResultIndex: resultIndex,
        TraceId: traceId,
        BoardingPointId: selectedBoardingPointId,
        DroppingPointId: selectedDroppingPointId,
        RefID: "1",
        Passenger: [passengerData]
    };

    fetch('/block-seats', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify(payload)
})
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok ' + response.statusText);
    }
    return response.json();
})
.then(data => {
    console.log(data);
})
.catch(error => {
    console.error('There was a problem with the fetch operation:', error);
});
}
function blockSeat(passengerData) {
    if (!selectedBoardingPointId || !selectedDroppingPointId) {
        alert('Please select both boarding and dropping points before proceeding.');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('TraceId');
    const resultIndex = urlParams.get('ResultIndex');

    // Ensure the Seat object is populated correctly
    passengerData.Seat = {
        SeatName: selectedSeatDetails.SeatName,
        ColumnNo: parseInt(selectedSeatDetails.ColumnNo, 10), // Convert to integer
        RowNo: parseInt(selectedSeatDetails.RowNo, 10), // Convert to integer
        Height: 1, // Assuming a default value, adjust as necessary
        IsLadiesSeat: false, // Assuming a default value, adjust as necessary
        IsMalesSeat: false, // Assuming a default value, adjust as necessary
        IsUpper: false, // Assuming a default value, adjust as necessary
        SeatFare: selectedSeatDetails.Price.PublishedPrice, // Assuming this is the fare
        SeatIndex: selectedSeatDetails.SeatIndex, // Assuming this is available
        SeatType: 1, // Assuming a default value, adjust as necessary
        Width: 1, // Assuming a default value, adjust as necessary
        Price: {
            CurrencyCode: "INR", // Assuming a default value, adjust as necessary
            BasePrice: selectedSeatDetails.Price.BasePrice,
            Tax: selectedSeatDetails.Price.Tax || 0,
            OtherCharges: selectedSeatDetails.Price.OtherCharges || 0,
            Discount: selectedSeatDetails.Price.Discount || 0,
            PublishedPrice: selectedSeatDetails.Price.PublishedPrice,
            PublishedPriceRoundedOff: selectedSeatDetails.Price.PublishedPriceRoundedOff || selectedSeatDetails.Price.PublishedPrice,
            OfferedPrice: selectedSeatDetails.Price.OfferedPrice || selectedSeatDetails.Price.PublishedPrice,
            OfferedPriceRoundedOff: selectedSeatDetails.Price.OfferedPriceRoundedOff || selectedSeatDetails.Price.PublishedPrice,
            AgentCommission: selectedSeatDetails.Price.AgentCommission || 0,
            AgentMarkUp: selectedSeatDetails.Price.AgentMarkUp || 0,
            TDS: selectedSeatDetails.Price.TDS || 0,
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
    };

    const payload = {
        ResultIndex: resultIndex,
        TraceId: traceId,
        BoardingPointId: selectedBoardingPointId,
        DroppingPointId: selectedDroppingPointId,
        RefID: "1",
        Passenger: [passengerData]
    };

    fetch('/block-seats', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(payload)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        console.log(data);
        if (data.status === 'success') {
            alert('Seat successfully blocked!');
            document.getElementById('payNowButton').classList.remove('d-none');
        } else {
            throw new Error(data.message || 'Failed to block seat');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(`Error: ${error.message}`);
    });
}
document.getElementById('payNowButton').addEventListener('click', function() {
    const passengerData = {
        Title: document.getElementById('title').value,
        FirstName: document.getElementById('firstName').value,
        LastName: document.getElementById('lastName').value,
        Email: document.getElementById('email').value,
        Phoneno: document.getElementById('phoneNumber').value,
        Gender: parseInt(document.getElementById('gender').value, 10),
        Age: parseInt(document.getElementById('age').value, 10),
        Address: document.getElementById('address').value,
        Seat: {
            SeatName: selectedSeatDetails.SeatName,
            ColumnNo: parseInt(selectedSeatDetails.ColumnNo, 10),
            RowNo: parseInt(selectedSeatDetails.RowNo, 10),
            // Add any other seat-related information if needed
        },
        LeadPassenger: true // Assuming this is the first passenger and should be marked as lead
    };

    const payload = {
        ResultIndex: new URLSearchParams(window.location.search).get('ResultIndex'),
        TraceId: new URLSearchParams(window.location.search).get('TraceId'),
        BoardingPointId: selectedBoardingPointId,
        DroppingPointId: selectedDroppingPointId,
        RefID: '1', // Replace with your reference id
        Passenger: [passengerData]
 
    };

    fetch('/bookSeats', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Bus booked successfully!');
            const bookingDetails = data.data;
            const bookingPageUrl = `/booking?TraceId=${bookingDetails.TraceId}&BusBookingStatus=${encodeURIComponent(bookingDetails.BusBookingStatus)}&InvoiceAmount=${bookingDetails.InvoiceAmount}&BusId=${bookingDetails.BusId}&TicketNo=${bookingDetails.TicketNo}&TravelOperatorPNR=${bookingDetails.TravelOperatorPNR}`;

            // Redirect to the booking page:
            window.location.href = bookingPageUrl;
            // You can redirect to payment or booking confirmation
        } else {
            alert('Booking failed: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
});

</script>
<style>
container { max-width: 800px; }
.step-navigation { display: block; }
.step { flex: 1; text-align: center; padding: 10px; border: 1px solid #007bff; border-radius: 5px; cursor: pointer; }
.step.active { background-color: #007bff; color: white; }
.bus-seats { display: flex; flex-wrap: wrap; justify-content: center; }
.seat { width: 50px; height: 50px; background-color: #007bff; color: white; display: flex; align-items: center; justify-content: center; border-radius: 5px; cursor: pointer; }
.seat-available { background-color: #007bff; }
.seat-booked { background-color: #6c757d; cursor: not-allowed; }
.seat-selected { background-color: #28a745; }
.pickup-point, .dropping-point { border: 1px solid #ccc; padding: 10px; margin: 10px 0; border-radius: 5px; }
</style>



@endsection
