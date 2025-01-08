<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hotel Information</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }

        /* Modal Styles */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background-color: white;
    padding: 2rem;
    border-radius: 8px;
    max-width: 600px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
}

.close {
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.passenger-entry {
    margin-bottom: 2rem;
    padding: 1rem;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.form-group {
    display: grid;
    gap: 1rem;
    margin-bottom: 1rem;
}

.form-group input,
.form-group select {
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
}

button {
    padding: 0.5rem 1rem;
    margin: 0.5rem;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: white;
    cursor: pointer;
}

button:disabled {
    background-color: #ccc;
}

.remove-passenger {
    background-color: #dc3545;
}

        /* Container Styles */
        .hotel-info-container, .room-info-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
        }

        /* Header Section */
        .hotel-header {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .hotel-name {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        /* Image Gallery */
        .hotel-images {
            position: relative;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
        }

        .hotel-images img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .hotel-images img:hover {
            transform: scale(1.05);
        }

        /* Hotel Information */
        .hotel-info {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .info-section {
            margin-bottom: 2rem;
        }

        .info-section h2 {
            color: #2c3e50;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #3498db;
        }

        /* Facilities Grid */
        .facilities-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .facility-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.8rem;
            background: #f8f9fa;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .facility-item:hover {
            background: #e9ecef;
        }

        .facility-item i {
            color: #3498db;
        }
        .room-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            border: 1px solid #eef2f6;
        }

        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0,0,0,0.12);
        }

        .room-image-gallery {
            position: relative;
            display: flex;
            gap: 1rem;
            margin: 1rem 0;
            overflow-x: auto;
            padding: 0.5rem;
            scrollbar-width: thin;
            scrollbar-color: #3498db #f8f9fa;
        }

        .room-image-gallery::-webkit-scrollbar {
            height: 6px;
        }

        .room-image-gallery::-webkit-scrollbar-track {
            background: #f8f9fa;
            border-radius: 10px;
        }

        .room-image-gallery::-webkit-scrollbar-thumb {
            background: #3498db;
            border-radius: 10px;
        }

        .room-image {
            flex: 0 0 auto;
            width: 280px;
            height: 180px;
            object-fit: cover;
            border-radius: 12px;
            transition: transform 0.3s ease;
        }

        .services-status {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin: 1rem 0;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 12px;
        }

        .service-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: white;
            border-radius: 8px;
            font-size: 0.9rem;
            color: #475569;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .book-now-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #eef2f6;
        }

        .book-now-button {
            background: #2563eb;
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .book-now-button:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .price-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.95);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            z-index: 1;
        }

        .room-info-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .room-info-grid {
                grid-template-columns: 1fr;
            }
        }
  


        /* Room Details Section */
        .room-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .room-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .room-name {
            font-size: 1.8rem;
            color: #2c3e50;
        }

        .room-price {
            text-align: right;
        }

        .price-amount {
            font-size: 1.8rem;
            color: #27ae60;
            font-weight: bold;
        }

        .price-original {
            text-decoration: line-through;
            color: #7f8c8d;
        }

        .room-amenities {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
            margin: 1rem 0;
        }

        .amenity-tag {
            background: #e1f5fe;
            color: #0288d1;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        /* Loading States */
        .loading-state {
            text-align: center;
            padding: 2rem;
            color: #7f8c8d;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hotel-name {
                font-size: 2rem;
            }

            .hotel-images {
                grid-template-columns: 1fr;
            }

            .room-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .facilities-list {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="hotel-info-container">
        <div id="hotel-details" class="loading-state">Loading hotel information...</div>
    </div>
    
    <div class="room-info-container">
        <div id="room-details" class="loading-state">Loading room details...</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchHotelInfo();
            fetchRoomDetails();
        });

        function fetchHotelInfo() {
            const urlParams = new URLSearchParams(window.location.search);
            const traceId = urlParams.get('traceId');
            const resultIndex = urlParams.get('resultIndex');
            const hotelCode = urlParams.get('hotelCode');

            if (!resultIndex || !traceId || !hotelCode) {
                document.getElementById('hotel-details').innerHTML = 
                    '<div class="error-state">No hotel information available</div>';
                return;
            }

            const requestBody = {
                resultIndex: resultIndex,
                SrdvIndex: "15",
                SrdvType: "MixAPI",
                hotelCode: hotelCode,
                traceId: traceId,
                ClientId: "180133",
                UserName: "MakeMy@91",
                Password: "MakeMy@910",
            };

            fetch('/hotel-details', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(requestBody)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success' && data.data?.HotelInfoResult?.HotelDetails) {
                    const hotel = data.data.HotelInfoResult.HotelDetails;
                    const hotelDetailsHtml = `
                        <div class="hotel-header">
                            <h1 class="hotel-name">${hotel.HotelName}</h1>
                            <div class="hotel-meta">
                                <p><i class="fas fa-map-marker-alt"></i> ${hotel.Address}, ${hotel.City}, ${hotel.State}, ${hotel.PinCode}</p>
                                <p><i class="fas fa-star"></i> ${hotel.StarRating} Star Rating</p>
                                <p><i class="fas fa-phone"></i> ${hotel.HotelContactNo}</p>
                            </div>
                        </div>

                        ${hotel.Images ? `
                            <div class="hotel-images">
                                ${hotel.Images.map(img => `
                                    <img src="${img}" alt="Hotel Image" onclick="openImageGallery(this.src)">
                                `).join('')}
                            </div>
                        ` : ''}

                        <div class="hotel-info">
                            ${hotel.HotelFacilities ? `
                                <div class="info-section">
                                    <h2>Hotel Facilities</h2>
                                    <div class="facilities-list">
                                        ${hotel.HotelFacilities.map(facility => `
                                            <div class="facility-item">
                                                <i class="${facility.FontAwesome}"></i>
                                                <span>${facility.Name}</span>
                                            </div>
                                        `).join('')}
                                    </div>
                                </div>
                            ` : ''}

                            ${hotel.Description ? `
                                <div class="info-section">
                                    <h2>About the Hotel</h2>
                                    ${hotel.Description.map(desc => `
                                        <div class="description-section">
                                            <h3>${desc.Name}</h3>
                                            <ul>
                                                ${desc.Detail.map(detail => `<li>${detail}</li>`).join('')}
                                            </ul>
                                        </div>
                                    `).join('')}
                                </div>
                            ` : ''}
                        </div>
                    `;
                    document.getElementById('hotel-details').innerHTML = hotelDetailsHtml;
                } else {
                    document.getElementById('hotel-details').innerHTML = 
                        '<div class="error-state">Failed to load hotel details</div>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('hotel-details').innerHTML = 
                    '<div class="error-state">An error occurred while loading hotel details</div>';
            });
        }

        function fetchRoomDetails() {
            const urlParams = new URLSearchParams(window.location.search);
            const traceId = urlParams.get('traceId');
            const resultIndex = urlParams.get('resultIndex');
            const hotelCode = urlParams.get('hotelCode');

            if (!resultIndex || !traceId || !hotelCode) {
                document.getElementById('room-details').innerHTML = 
                    '<div class="error-state">No room information available</div>';
                return;
            }

            const payload = {
                resultIndex: resultIndex,
                srdvIndex: "15",
                srdvType: "MixAPI",
                hotelCode: hotelCode,
                traceId: parseInt(traceId),
            };

            fetch('/hotel-room-details', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(payload),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success' && data.data?.hotelRoomsDetails) {
                let roomDetailsHtml = '';
                const roomCombinations = data.data.roomCombinations;
                
                data.data.hotelRoomsDetails.forEach(category => {
                    roomDetailsHtml += `
                        <div class="room-category">
                            <h2 class="category-name">${category.CategoryName}</h2>
                            
                            ${category.Rooms.map(room => `
                                <div class="room-card">
                                    <div class="room-header">
                                        <h3 class="room-name">${room.RoomTypeName}</h3>
                                        <div class="price-section">
                                            <div class="price-amount">${room.Price.CurrencyCode} ${room.Price.OfferedPrice}</div>
                                            ${room.Price.PublishedPrice !== room.Price.OfferedPrice ? 
                                                `<div class="price-original">${room.Price.CurrencyCode} ${room.Price.PublishedPrice}</div>` : 
                                                ''}
                                        </div>
                                    </div>

                                    <div style="position: relative;">
                                        ${room.RoomImages ? `
                                            <div class="room-image-gallery">
                                                ${room.RoomImages.map(img => `
                                                    <img src="${img.Image}" alt="${room.RoomTypeName}" class="room-image">
                                                `).join('')}
                                            </div>
                                        ` : ''}
                                    </div>

                                    <div class="room-info-grid">
                                        <div class="room-details">
                                            <div class="room-description">
                                                ${room.Description.map(desc => `<p>${desc}</p>`).join('')}
                                            </div>
                                            
                                            <div class="bed-type-info">
                                                <i class="fas fa-bed"></i> ${room.BedTypes}
                                            </div>

                                            <div class="amenities-section">
                                                ${room.Amenities.map(amenity => `
                                                    <span class="amenity-tag">
                                                        <i class="fas ${amenity.FontAwesome}"></i>
                                                        ${amenity.Name}
                                                    </span>
                                                `).join('')}
                                            </div>
                                        </div>

                                        <div class="room-services">
                                            ${room.ServicesStatus ? `
                                                <div class="services-status">
                                                    ${room.ServicesStatus.map(service => `
                                                        <div class="service-item">
                                                            <i class="fas fa-check-circle"></i>
                                                            <span>${service.Name}: ${service.Value}</span>
                                                        </div>
                                                    `).join('')}
                                                </div>
                                            ` : ''}
                                        </div>
                                    </div>

                                    ${room.CancellationPolicies ? `
                                        <div class="cancellation-policy">
                                            <h4><i class="fas fa-info-circle"></i> Cancellation Policy</h4>
                                            ${room.CancellationPolicies.map(policy => `
                                                <div class="policy-item">
                                                    <span>${policy.FromDate.split('T')[0]} to ${policy.ToDate.split('T')[0]}</span>
                                                    <span class="policy-charge">
                                                        ${policy.Charge > 0 ? 
                                                            `Cancellation charge: ${policy.Currency} ${policy.Charge}` : 
                                                            'Free cancellation'}
                                                    </span>
                                                </div>
                                            `).join('')}
                                        </div>
                                    ` : ''}

                                    <div class="book-now-section">
                                        <div class="room-info">
                                            <div class="room-id">Room ID: ${room.RoomId}</div>
                                            ${room.IsPANMandatory ? 
                                                '<div class="pan-notice"><i class="fas fa-exclamation-circle"></i> PAN Card Required</div>' : 
                                                ''}
                                        </div>
                                        <button class="book-now-button" onclick="bookRoom('${room.RoomId}', '${room.RoomIndex}')">
                                            <i class="fas fa-calendar-check"></i>
                                            Book Now
                                        </button>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    `;
                });
                
                document.getElementById('room-details').innerHTML = roomDetailsHtml;
            } else {
                document.getElementById('room-details').innerHTML = 
                    '<div class="error-state">Failed to load room details</div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('room-details').innerHTML = 
                '<div class="error-state">An error occurred while loading room details</div>';
        });
    }




    function bookRoom(roomId, roomIndex) {
    // Show modal with passenger form
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Enter Passenger Details</h2>
            <form id="passengerForm">
                <div class="passenger-container" id="passengerContainer">
                    <div class="passenger-entry">
                        <h3>Lead Passenger</h3>
                        <div class="form-group">
                            <select name="title" required>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Ms">Ms</option>
                            </select>
                            <input type="text" name="firstName" placeholder="First Name" required>
                            <input type="text" name="lastName" placeholder="Last Name" required>
                            <input type="email" name="email" placeholder="Email" required>
                            <input type="tel" name="phone" placeholder="Phone Number" required>
                            <input type="text" name="pan" placeholder="PAN Number (Optional)">
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addPassenger()">Add Another Passenger</button>
                <button type="submit">Block Room</button>
            </form>
        </div>
    `;

    document.body.appendChild(modal);

    // Close modal functionality
    const closeBtn = modal.querySelector('.close');
    closeBtn.onclick = function() {
        modal.remove();
    }

    // Form submission handler
    const form = modal.querySelector('#passengerForm');
    form.onsubmit = function(e) {
        e.preventDefault();
        blockRoom(roomId, roomIndex, form);
    }
}

function addPassenger() {
    const container = document.getElementById('passengerContainer');
    const passengerEntry = document.createElement('div');
    passengerEntry.className = 'passenger-entry';
    passengerEntry.innerHTML = `
        <h3>Additional Passenger</h3>
        <div class="form-group">
            <select name="title" required>
                <option value="Mr">Mr</option>
                <option value="Mrs">Mrs</option>
                <option value="Ms">Ms</option>
            </select>
            <input type="text" name="firstName" placeholder="First Name" required>
            <input type="text" name="lastName" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <input type="text" name="pan" placeholder="PAN Number (Optional)">
        </div>
        <button type="button" class="remove-passenger" onclick="this.parentElement.remove()">Remove</button>
    `;
    container.appendChild(passengerEntry);
}

function blockRoom(roomId, roomIndex, form) {
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('traceId');
    const hotelCode = urlParams.get('hotelCode');
    const hotelName = document.querySelector('.hotel-name').textContent;

    // Collect all passenger entries
    const passengers = [];
    const passengerEntries = form.querySelectorAll('.passenger-entry');
    
    passengerEntries.forEach((entry, index) => {
        passengers.push({
            Title: entry.querySelector('select[name="title"]').value,
            FirstName: entry.querySelector('input[name="firstName"]').value,
            MiddleName: null,
            LastName: entry.querySelector('input[name="lastName"]').value,
            Phoneno: entry.querySelector('input[name="phone"]').value,
            Email: entry.querySelector('input[name="email"]').value,
            PaxType: "1",
            LeadPassenger: index === 0,
            PAN: entry.querySelector('input[name="pan"]').value || ""
        });
    });

    const requestBody = {
        ResultIndex: hotelCode,
        HotelCode: hotelCode,
        HotelName: hotelName,
        GuestNationality: "IN",
        NoOfRooms: "1",
        ClientReferenceNo: 0,
        IsVoucherBooking: true,
        HotelRoomsDetails: [{
            RoomId: roomId,
            RoomIndex: roomIndex,
            HotelPassenger: passengers
            // Add other required room details from your existing data
        }],
        SrdvType: "MixAPI",
        SrdvIndex: "15",
        TraceId: parseInt(traceId),
        EndUserIp: "1.1.1.1"
    };

    // Show loading state
    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.textContent = 'Blocking Room...';

    fetch('/block-room', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(requestBody)
    })
    .then(response => response.json())
    .then(data => {
        if (data.BookResult && data.BookResult.Status === 'Confirmed') {
            alert(`Booking Confirmed!\nBooking Reference: ${data.BookResult.BookingRefNo}`);
            // Close modal and refresh page or redirect to booking confirmation page
            form.closest('.modal').remove();
            // Optionally redirect to booking confirmation page
            // window.location.href = `/booking-confirmation/${data.BookResult.BookingRefNo}`;
        } else {
            alert('Booking failed: ' + (data.BookResult?.Error?.ErrorMessage || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing your booking. Please try again.');
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.textContent = 'Block Room';
    });
}
    </script>
</body>
</html>