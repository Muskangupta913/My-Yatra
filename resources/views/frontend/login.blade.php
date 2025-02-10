@extends('frontend.layouts.master')
@section('title', 'Booking Confirmation')
@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <div class="booking-container">
    <style>
        .booking-container {
            background: #f8f9fa;
            padding: 40px 0;
            min-height: 100vh;
        }

        .booking-header {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }

        .booking-header h2 {
            font-weight: 600;
            margin-bottom: 10px;
        }

        .booking-status {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-block;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .booking-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 0 8px 2px rgba(57, 73, 171, 0.3); /* Adds a dark blue outline */
    margin-bottom: 25px;
    border: 1px solidrgb(31, 32, 35); /* Solid border with dark blue color */
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Adds hover effect */
}

.booking-card:hover {
    transform: translateY(-5px); /* Slight hover effect for elevation */
    box-shadow: 0 0 15px 4px rgba(57, 73, 171, 0.5); /* Enhance outline on hover */
}
.card-header {
    background:rgb(32, 132, 75);
    color: white;
    border-bottom: 1px solid #3949ab;
    padding: 20px;
    border-radius: 15px 15px 0 0;
}

.section-header {
    color: white; /* White text for better contrast */
}

        .section-header i {
            margin-right: 10px;
            color:rgb(26, 26, 27);
        }

        .card-body {
            padding: 25px;
        }

        .detail-row {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .detail-row:last-child {
            margin-bottom: 0;
        }
        .icon-container {
    background: rgba(57, 73, 171, 0.1);
    border: 1px solidrgb(223, 111, 31);
}


        .icon-container i {
            color:rgb(29, 29, 32);
            font-size: 16px;
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 3px;
            text-transform: uppercase;
        }

        .detail-value {
            color: #2c3e50;
            font-weight: 500;
            font-size: 15px;
        }

        .journey-timeline {
            position: relative;
            padding: 20px 0;
        }

        .timeline-point {
            position: relative;
            padding-left: 50px;
            margin-bottom: 20px;
        }

        .timeline-point::before {
            content: '';
            position: absolute;
            left: 17px;
            top: 0;
            bottom: -20px;
            width: 2px;
            background: #e0e0e0;
        }

        .timeline-point:last-child::before {
            display: none;
        }

        .timeline-point .icon-container {
            position: absolute;
            left: 0;
            top: 0;
        }

        .price-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #eef2f7;
        }

        .price-item:last-child {
            border: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .price-label {
            color: #6c757d;
        }

        .price-value {
            font-weight: 600;
            color: #2c3e50;
        }

        .total-price {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .total-price .price-value {
            color: #2e7d32;
            font-size: 18px;
        }

        .action-buttons {
            text-align: center;
            margin-top: 30px;
        }

        .btn-pay {
            background:rgb(220, 150, 20);
            color: white;
            padding: 12px 35px;
            border-radius: 25px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-pay:hover {
            background:rgb(187, 90, 25);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(57, 73, 171, 0.2);
        }

        @media (max-width: 768px) {
            .booking-container {
                padding: 20px 15px;
            }
            
            .card-body {
                padding: 15px;
            }
            
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .icon-container {
                margin-bottom: 10px;
            }
        }
    </style>

    <div class="container">
        <div class="booking-header">
            <h2>Booking Confirmation</h2>
            <span class="booking-status">
                <i class="fas fa-check-circle"></i> Booking Pending Payment
            </span>
        </div>

        <div class="row">
            <!-- Bus Details Section -->
            <div class="col-12">
                <div class="booking-card">
                    <div class="card-header">
                        <h4 class="section-header">
                            <i class="fas fa-bus"></i> Bus Details
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="busDetails"></div>
                    </div>
                </div>
            </div>

            <!-- Journey Details Section -->
            <div class="col-md-6">
                <div class="booking-card">
                    <div class="card-header">
                        <h4 class="section-header">
                            <i class="fas fa-route"></i> Journey Details
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="journey-timeline" id="journeyDetails"></div>
                    </div>
                </div>
            </div>

            <!-- Passenger Details Section -->
            <div class="col-md-6">
                <div class="booking-card">
                    <div class="card-header">
                        <h4 class="section-header">
                            <i class="fas fa-user"></i> Passenger Details
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="passengerDetails"></div>
                    </div>
                </div>
            </div>

            <!-- Seat Details Section -->
            <div class="col-md-6">
                <div class="booking-card">
                    <div class="card-header">
                        <h4 class="section-header">
                            <i class="fas fa-chair"></i> Seat Details
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="seatDetails"></div>
                    </div>
                </div>
            </div>

            <!-- Price Details Section -->
            <div class="col-md-6">
                <div class="booking-card">
                    <div class="card-header">
                        <h4 class="section-header">
                            <i class="fas fa-receipt"></i> Fare Summary
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="priceDetails"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="#" id="payNowButton" class="btn btn-pay">
                <i class="fas fa-lock mr-2"></i> Proceed to Secure Payment
            </a>
        </div>
    </div>
</div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Parse URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            
            // Get and parse all data from URL
            const passengerData = JSON.parse(decodeURIComponent(urlParams.get('PassengerData')));
            const boardingPoint = JSON.parse(decodeURIComponent(urlParams.get('BoardingPoint')));
            const droppingPoint = JSON.parse(decodeURIComponent(urlParams.get('DroppingPoint')));
            const busDetails = JSON.parse(decodeURIComponent(urlParams.get('BusDetails')));
            const price = JSON.parse(decodeURIComponent(urlParams.get('Price')));
            const traceId = urlParams.get('TraceId');
            const resultIndex = urlParams.get('ResultIndex');
            let invoiceAmount= 0;
             let encodedPassengerData = '';
             invoiceAmount = passengerData[0].SeatDetails.Price;
            encodedPassengerData=encodeURIComponent(passengerData);

            // Format date and time
            function formatDateTime(dateTimeStr) {
                const dt = new Date(dateTimeStr);
                return dt.toLocaleString('en-US', {
                    month: 'short',
                    day: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                });
            }

            // Populate Bus Details
            document.getElementById('busDetails').innerHTML = `
            <div class="row">
                <div class="col-md-4">
                    <div class="detail-row">
                        <div class="icon-container">
                            <i class="fas fa-bus"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Service Name</div>
                            <div class="detail-value">${busDetails.ServiceName}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-row">
                        <div class="icon-container">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Travel Agency</div>
                            <div class="detail-value">${busDetails.TravelName}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-row">
                        <div class="icon-container">
                            <i class="fas fa-couch"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Bus Type</div>
                            <div class="detail-value">${busDetails.BusType}</div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Populate Journey Details
        document.getElementById('journeyDetails').innerHTML = `
            <div class="timeline-point">
                <div class="icon-container">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="detail-content">
                    <div class="detail-label">Boarding Point</div>
                    <div class="detail-value">${boardingPoint.Name}</div>
                    <div class="detail-time">${formatDateTime(busDetails.DepartureTime)}</div>
                </div>
            </div>
            <div class="timeline-point">
                <div class="icon-container">
                    <i class="fas fa-map-pin"></i>
                </div>
                <div class="detail-content">
                    <div class="detail-label">Dropping Point</div>
                    <div class="detail-value">${droppingPoint.Name}</div>
                    <div class="detail-time">${formatDateTime(busDetails.ArrivalTime)}</div>
                </div>
            </div>
        `;

        // Populate Passenger Details
        document.getElementById('passengerDetails').innerHTML = `
            <div class="detail-row">
                <div class="icon-container">
                    <i class="fas fa-user"></i>
                </div>
                <div class="detail-content">
                    <div class="detail-label">Passenger Name</div>
                    <div class="detail-value">${passengerData.Title} ${passengerData.FirstName}</div>
                </div>
            </div>
            <div class="detail-row">
                <div class="icon-container">
                    <i class="fas fa-phone"></i>
                </div>
                <div class="detail-content">
                    <div class="detail-label">Contact Number</div>
                    <div class="detail-value">${passengerData.Phoneno}</div>
                </div>
            </div>
            <div class="detail-row">
                <div class="icon-container">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="detail-content">
                    <div class="detail-label">Age & Gender</div>
                    <div class="detail-value">${passengerData.Age} Years | ${passengerData.Gender === 2 ? 'Female' : 'Male'}</div>
                </div>
            </div>
        `;

        // Populate Seat Details
        document.getElementById('seatDetails').innerHTML = `
            <div class="detail-row">
                <div class="icon-container">
                    <i class="fas fa-chair"></i>
                </div>
                <div class="detail-content">
                    <div class="detail-label">Seat Number</div>
                    <div class="detail-value">${passengerData.Seat.SeatName}</div>
                </div>
            </div>
            <div class="detail-row">
                <div class="icon-container">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="detail-content">
                    <div class="detail-label">Deck & Type</div>
                    <div class="detail-value">${passengerData.Seat.IsUpper ? 'Upper' : 'Lower'} Deck | ${passengerData.Seat.SeatType === 1 ? 'Seater' : 'Sleeper'}</div>
                </div>
            </div>
        `;

        // Populate Price Details
        document.getElementById('priceDetails').innerHTML = `
            <div class="price-item">
                <span class="price-label">Base Fare</span>
                <span class="price-value">₹${passengerData.Seat.Price.BasePrice}</span>
            </div>
            <div class="price-item">
                <span class="price-label">GST</span>
                <span class="price-value">₹${passengerData.Seat.Price.GST.IGSTAmount}</span>
            </div>
            <div class="total-price price-item">
                <span class="price-label">Total Amount</span>
                <span class="price-value">₹${passengerData.Seat.Price.PublishedPrice}</span>
            </div>
        `;



// Set the href for Pay Now button with all necessary parameters
// Set the href for Pay Now button with all necessary parameters
document.getElementById('payNowButton').href = /payment?TraceId=${traceId}&amount=${invoiceAmount}&PassengerData=${encodeURIComponent(encodedPassengerData)}&ResultIndex=${resultIndex}&BoardingPointName=${encodeURIComponent(boardingPoint)}&DroppingPointName=${encodeURIComponent(droppingPoint)};

// Handle payment click event
document.getElementById('payNowButton').addEventListener('click', function (e) {
            e.preventDefault();

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const payload = {
                TraceId: traceId,
                Amount: invoiceAmount,
                PassengerData: passengerData,
                BoardingPointName: boardingPoint.Name,
                DroppingPointName: droppingPoint.Name,
                SeatNumber: passengerData.Seat.SeatName
            };

            // Add console logs for debugging
            console.log('Payload:', payload);

            fetch('/busbalance', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.navigateToPayment) {
                    // Navigate to payment page with all necessary parameters
                    window.location.href = ${data.url}&PassengerData=${encodedPassengerData}&ResultIndex=${resultIndex}&BoardingPointName=${encodeURIComponent(boardingPoint)}&DroppingPointName=${encodeURIComponent(droppingPoint)};
                } else if (!data.success) {
                    alert(data.errorMessage || 'Something went wrong. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            });
        });
    });
</script>

@endsection