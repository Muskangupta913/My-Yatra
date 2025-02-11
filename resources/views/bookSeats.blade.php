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
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #5c6bc0;
            --success-color: #66bb6a;
            --background-color: #f0f2f5;
            --card-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--background-color);
            color: #2c3e50;
        }

        .booking-container {
            padding: 40px 0;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
            min-height: 100vh;
        }

        .booking-header {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInDown 0.8s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .booking-header h3 {
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .booking-status {
            background: linear-gradient(45deg, #66bb6a, #43a047);
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            display: inline-block;
            font-size: 1rem;
            font-weight: 500;
            box-shadow: 0 4px 8px rgba(102,187,106,0.3);
            transition: transform 0.3s ease;
        }

        .booking-status:hover {
            transform: translateY(-2px);
        }

        .booking-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            border: none;
            transition: transform 0.3s ease;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .booking-card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 20px 20px 0 0 !important;
            padding: 20px;
            border: none;
        }

        .section-header {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .section-header i {
            margin-right: 12px;
            font-size: 1.5rem;
            background: rgba(255,255,255,0.2);
            padding: 8px;
            border-radius: 10px;
        }

        .card-body {
            padding: 25px;
        }

        .detail-row {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .detail-row:hover {
            transform: translateX(5px);
        }

        .icon-container {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            transition: all 0.3s ease;
        }

        .icon-container i {
            color: white;
            font-size: 1.2rem;
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-size: 0.85rem;
            color: #6c757d;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-value {
            color: #2c3e50;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .journey-timeline {
            position: relative;
            padding: 20px 0;
        }

        .timeline-point {
            position: relative;
            padding-left: 60px;
            margin-bottom: 30px;
        }

        .timeline-point::before {
            content: '';
            position: absolute;
            left: 22px;
            top: 0;
            bottom: -30px;
            width: 2px;
            background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
        }

        .price-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        .price-item:hover {
            background-color: #f8f9fa;
        }

        .total-price {
            background: linear-gradient(135deg, #4a90e2, #5c6bc0);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(74,144,226,0.3);
        }

        .total-price .price-label {
            color: rgba(255,255,255,0.9);
        }

        .total-price .price-value {
            color: white;
            font-size: 1.5rem;
        }

        .btn-pay {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(74,144,226,0.3);
            margin-top: 40px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-pay:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(74,144,226,0.4);
            color: white;
        }

        .passenger-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .passenger-card:hover {
            transform: translateY(-3px);
        }

        .passenger-card h5 {
            color: var(--primary-color);
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(74,144,226,0.1);
        }

        @media (max-width: 768px) {
            .booking-container {
                padding: 20px 15px;
            }
            
            .booking-header h2 {
                font-size: 2rem;
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
            <h3>Booking Confirmation</h3>
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
    const passengers = JSON.parse(decodeURIComponent(urlParams.get('PassengerData')));
    const boardingPoint = JSON.parse(decodeURIComponent(urlParams.get('BoardingPoint')));
    const droppingPoint = JSON.parse(decodeURIComponent(urlParams.get('DroppingPoint')));
    const busDetails = JSON.parse(decodeURIComponent(urlParams.get('BusDetails')));
    const price = JSON.parse(decodeURIComponent(urlParams.get('Price')));
    const traceId = urlParams.get('TraceId');
    const resultIndex = urlParams.get('ResultIndex');
    
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

// Populate Seat Details
const seatDetailsHTML = passengers.map((passenger, index) => {
    const seatDetails = passenger.SeatDetails;
    return `
        <div class="passenger-card ${index > 0 ? 'mt-4 pt-4 border-top' : ''}">
            <h5 class="mb-3">Seat Details - ${passenger.Title} ${passenger.FirstName}</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="detail-row">
                        <div class="icon-container">
                            <i class="fas fa-chair"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Seat Number</div>
                            <div class="detail-value">${seatDetails.SeatNumber || 'Not assigned'}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="detail-row">
                        <div class="icon-container">
                            <i class="fas fa-couch"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Seat Type</div>
                            <div class="detail-value">${seatDetails.SeatType}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="detail-row">
                        <div class="icon-container">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Deck</div>
                            <div class="detail-value">${seatDetails.Deck}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}).join('');

document.getElementById('seatDetails').innerHTML = seatDetailsHTML;
    // Populate Passenger Details for multiple passengers
    const passengersHTML = passengers.map((passenger, index) => `
        <div class="passenger-card ${index > 0 ? 'mt-4 pt-4 border-top' : ''}">
            <h5 class="mb-3">Passenger ${index + 1} ${passenger.LeadPassenger ? '' : ''}</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="detail-row">
                        <div class="icon-container">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Passenger Name</div>
                            <div class="detail-value">${passenger.Title} ${passenger.FirstName}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-row">
                        <div class="icon-container">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Age & Gender</div>
                            <div class="detail-value">${passenger.Age} Years | ${passenger.Gender === '1' ? 'Male' : passenger.Gender === '2' ? 'Female' : ''}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-row">
                        <div class="icon-container">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Address</div>
                            <div class="detail-value">${passenger.Address}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `).join('');

    document.getElementById('passengerDetails').innerHTML = passengersHTML;

    // Calculate total amount
    const basePrice = price.BasePrice;
    const totalAmount = basePrice * passengers.length;

    // Populate Price Details
    document.getElementById('priceDetails').innerHTML = `
        <div class="price-item">
            <span class="price-label">Base Fare (per passenger)</span>
            <span class="price-value">₹${basePrice.toFixed(2)}</span>
        </div>
        <div class="price-item">
            <span class="price-label">Number of Passengers</span>
            <span class="price-value">${passengers.length}</span>
        </div>
        <div class="total-price price-item">
            <span class="price-label">Total Amount</span>
            <span class="price-value">₹${totalAmount.toFixed(2)}</span>
        </div>
    `;

// Set the href for Pay Now button with all necessary parameters
// Set the href for Pay Now button with all necessary parameters
document.getElementById('payNowButton').href = `/payment?TraceId=${traceId}&amount=${invoiceAmount}&PassengerData=${encodeURIComponent(encodedPassengerData)}&ResultIndex=${resultIndex}&BoardingPointName=${encodeURIComponent(boardingPoint)}&DroppingPointName=${encodeURIComponent(droppingPoint)}`;

// Handle payment click event
document.getElementById('payNowButton').addEventListener('click', function (e) {
            e.preventDefault();

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            const payload = {
                TraceId: traceId,
                Amount: invoiceAmount,
                PassengerData: passengers,
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
                    window.location.href = `${data.url}&PassengerData=${encodedPassengerData}&ResultIndex=${resultIndex}&BoardingPointName=${encodeURIComponent(boardingPoint)}&DroppingPointName=${encodeURIComponent(droppingPoint)}`;
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
