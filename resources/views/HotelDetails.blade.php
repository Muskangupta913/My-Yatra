<!DOCTYPE html>
<html lang="en">
<head>
    <div id="loadingSpinner" style="
    display: none; 
    position: fixed; 
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%; 
    background-color: rgba(255, 255, 255, 0.8); 
    z-index: 9999; 
    display: flex; 
    align-items: center; 
    justify-content: center;">
    <img src="{{ asset('assets/loading.gif') }}" alt="Loading..." style="width: 10vw; height: 10vw; max-width: 150px; max-height: 150px;" />
</div>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hotel Details</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
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

/* Container and Card Styles */
.hotel-info-container, .room-info-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 20px;
}

.hotel-header, .hotel-info {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

/* Image Gallery */
.image-gallery {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
    background: white;
    padding: 1rem;
}

.gallery-container {
    position: relative;
    width: 100%;
    height: 400px;
    overflow: hidden;
    border-radius: 8px;
}

.hotel-images {
    display: flex;
    transition: transform 0.3s ease;
    height: 100%;
}

.hotel-images img {
    width: 100%;
    min-width: 100%;
    height: 100%;
    object-fit: cover;
    flex-shrink: 0;
}

/* Image Counter */
.image-counter {
    position: absolute;
    bottom: 1rem;
    right: 1rem;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    z-index: 20;
}

/* Gallery Navigation Buttons */
.gallery-nav-button {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.5);
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    transition: background-color 0.3s;
    border: none;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
}

.gallery-nav-button:hover {
    background: rgba(0, 0, 0, 0.7);
}

.gallery-nav-button.prev {
    left: 1rem;
}

.gallery-nav-button.next {
    right: 1rem;
}

/* Thumbnails Container */
.thumbnails-container {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
    overflow-x: auto;
    padding: 0.5rem;
    scrollbar-width: thin;
    scrollbar-color: #3498db #f8f9fa;
}

.thumbnail {
    width: 80px;
    height: 60px;
    border-radius: 4px;
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.3s ease;
    flex-shrink: 0;
}

.thumbnail.active {
    opacity: 1;
    border: 2px solid #3498db;
}

.thumbnails-container::-webkit-scrollbar {
    height: 6px;
}

.thumbnails-container::-webkit-scrollbar-track {
    background: #f8f9fa;
    border-radius: 10px;
}

.thumbnails-container::-webkit-scrollbar-thumb {
    background: #3498db;
    border-radius: 10px;
}

/* Room Card */
.room-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
    border: 1px solid #eef2f6;
    display: flex;
    gap: 1.5rem;
}

.room-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 25px rgba(0,0,0,0.12);
}

/* Room Image Gallery */
.room-image-gallery {
    flex: 0 0 300px;
    position: relative;
}

.room-main-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}

.room-thumbnails {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
    overflow-x: auto;
}

.room-thumbnail {
    width: 60px;
    height: 60px;
    border-radius: 4px;
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.3s;
}

.room-thumbnail.active {
    opacity: 1;
    border: 2px solid #3498db;
}

/* Button Styles */
.book-now-button {
    background: #2563eb;
    color: white;
    padding: 0.8rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    text-transform: uppercase;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.book-now-button:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .hotel-images {
        grid-template-columns: 1fr;
    }
    
    .facilities-list {
        grid-template-columns: 1fr;
    }
    
    .room-card {
        flex-direction: column;
    }
    
    .gallery-nav-button {
        width: 32px;
        height: 32px;
    }
    
    .image-counter {
        font-size: 0.8rem;
        padding: 0.3rem 0.8rem;
    }
    
    .room-image-gallery {
        flex: none;
    }
}
</style>
</head>
<body class="bg-gray-100">
    <div id="hotel-details" class="max-w-6xl mx-auto p-4 space-y-6">
        <!-- Content will be populated by JavaScript -->
    </div>
    <template id="hotel-template">
        <div class="space-y-6">
            <!-- Hotel Header -->
            <div class="bg-white rounded-lg shadow p-6">
                <h1 class="text-3xl font-bold hotel-name"></h1>
                <div class="flex flex-wrap gap-4 text-sm text-gray-600 mt-2">
                    <div class="flex items-center gap-1">
                        <i class="fas fa-map-marker-alt"></i>
                        <span class="hotel-address"></span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i class="fas fa-star text-yellow-400"></i>
                        <span class="hotel-rating"></span>
                    </div>
                    <div class="flex items-center gap-1">
                        <i class="fas fa-phone"></i>
                        <span class="hotel-contact"></span>
                    </div>
                </div>
            </div>

            <!-- Image Gallery -->
            <div class="image-gallery bg-white rounded-lg shadow p-4">
                <div class="relative aspect-video rounded-lg overflow-hidden">
                    <img src="" alt="Main Hotel Image" class="main-image w-full h-full object-cover">
                    <button class="gallery-nav-button prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="gallery-nav-button next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="flex gap-2 mt-2 overflow-x-auto pb-2 thumbnails-container">
                    <!-- Thumbnails will be populated here -->
                </div>
            </div>

            <!-- Hotel Info Grid -->
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Facilities -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">Hotel Facilities</h2>
                    <div class="grid grid-cols-2 gap-4 facilities-list">
                        <!-- Facilities will be populated here -->
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">About the Hotel</h2>
                    <div class="space-y-4 hotel-description">
                        <!-- Description will be populated here -->
                    </div>
                </div>
            </div>
        </div>
    </template>

    <div class="room-info-container">
        <div id="room-details" class="loading-state">Loading room details...</div>
    </div>
<script>
      document.getElementById('loadingSpinner').classList.remove('d-none');

document.addEventListener('DOMContentLoaded', () => {
    showLoadingSpinner();
    setTimeout(() => {
        hideLoadingSpinner();
    }, 4000);
});
let hotelDetailsLoaded = false;
let roomDetailsLoaded = false;

// Modified loading spinner functions
function showLoadingSpinner() {
    const spinner = document.getElementById('loadingSpinner');
    if (spinner) {
        spinner.style.display = 'flex';
    }
}

function hideLoadingSpinner() {
    if (hotelDetailsLoaded && roomDetailsLoaded) {
        const spinner = document.getElementById('loadingSpinner');
        if (spinner) {
            spinner.style.display = 'none';
        }
    }
}

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
                    hotelDetailsLoaded = true;
                    hideLoadingSpinner();
                    return;
            }

            const requestBody = {
                resultIndex: resultIndex,
                SrdvIndex: "15",
                SrdvType: "MixAPI",
                hotelCode: hotelCode,
                traceId: traceId,
                ClientId: "180189",
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
                     renderHotelDetails(data.data.HotelInfoResult.HotelDetails);
        } else {
            document.getElementById('hotel-details').innerHTML = 
                '<div class="error-state">Failed to load hotel details</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('hotel-details').innerHTML = 
            '<div class="error-state">An error occurred while loading hotel details</div>';
    })
    .finally(() => {
        hotelDetailsLoaded = true;
        hideLoadingSpinner();
    });
}

function renderHotelDetails(hotel) {
    const template = document.getElementById('hotel-template');
    const content = template.content.cloneNode(true);
    const container = document.getElementById('hotel-details');
    
    // Clear existing content
    container.innerHTML = '';
    
    // Set basic hotel information
    content.querySelector('.hotel-name').textContent = hotel.HotelName;
    content.querySelector('.hotel-address').textContent = 
        `${hotel.Address}, ${hotel.City}, ${hotel.State}, ${hotel.PinCode}`;
    content.querySelector('.hotel-rating').textContent = `${hotel.StarRating} Star Rating`;
    content.querySelector('.hotel-contact').textContent = hotel.HotelContactNo;

    // Setup image gallery
    let currentImageIndex = 0;
    const mainImage = content.querySelector('.main-image');
    const thumbnailsContainer = content.querySelector('.thumbnails-container');
    
    if (hotel.Images && hotel.Images.length > 0) {
        mainImage.src = hotel.Images[0];
        
        // Create thumbnails
        hotel.Images.forEach((img, index) => {
            const thumbnail = document.createElement('button');
            thumbnail.className = `flex-none w-24 h-16 rounded-lg overflow-hidden thumbnail ${index === 0 ? 'active' : ''}`;
            thumbnail.innerHTML = `<img src="${img}" alt="Thumbnail ${index + 1}" class="w-full h-full object-cover">`;
            thumbnail.onclick = () => {
                currentImageIndex = index;
                updateMainImage();
            };
            thumbnailsContainer.appendChild(thumbnail);
        });

        // Setup navigation buttons
        content.querySelector('.gallery-nav-button.prev').onclick = () => {
            currentImageIndex = (currentImageIndex - 1 + hotel.Images.length) % hotel.Images.length;
            updateMainImage();
        };
        
        content.querySelector('.gallery-nav-button.next').onclick = () => {
            currentImageIndex = (currentImageIndex + 1) % hotel.Images.length;
            updateMainImage();
        };

        function updateMainImage() {
            mainImage.src = hotel.Images[currentImageIndex];
            thumbnailsContainer.querySelectorAll('.thumbnail').forEach((thumb, index) => {
                thumb.classList.toggle('active', index === currentImageIndex);
            });
        }
    }

    // Render facilities
    const facilitiesList = content.querySelector('.facilities-list');
    if (hotel.HotelFacilities) {
        hotel.HotelFacilities.forEach(facility => {
            const facilityDiv = document.createElement('div');
            facilityDiv.className = 'flex items-center gap-2 p-2 rounded-lg hover:bg-gray-50';
            facilityDiv.innerHTML = `
                <i class="${facility.FontAwesome}"></i>
                <span>${facility.Name}</span>
            `;
            facilitiesList.appendChild(facilityDiv);
        });
    }

    // Render description
    const descriptionContainer = content.querySelector('.hotel-description');
    if (hotel.Description) {
        hotel.Description.forEach(section => {
            const sectionDiv = document.createElement('div');
            sectionDiv.className = 'mb-4';
            sectionDiv.innerHTML = `
                <h3 class="font-semibold mb-2">${section.Name}</h3>
                <ul class="list-disc list-inside space-y-1">
                    ${section.Detail.map(detail => `
                        <li class="text-gray-600">${detail}</li>
                    `).join('')}
                </ul>
            `;
            descriptionContainer.appendChild(sectionDiv);
        });
    }

    container.appendChild(content);
}

// Initialize the page
document.addEventListener('DOMContentLoaded', fetchHotelInfo);

function fetchRoomDetails() {
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('traceId');
    const resultIndex = urlParams.get('resultIndex');
    const hotelCode = urlParams.get('hotelCode');

    if (!resultIndex || !traceId || !hotelCode) {
        document.getElementById('room-details').innerHTML = 
            '<div style="text-align: center; padding: 2rem; color: #ef4444;">No room information available</div>';
            roomDetailsLoaded = true;
            hideLoadingSpinner();
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
        
            data.data.hotelRoomsDetails.forEach(category => {
                roomDetailsHtml += `
                    <div style="margin-bottom: 2rem;">
                        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e293b; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e2e8f0;">
                            ${category.CategoryName}
                        </h2>
                        ${category.Rooms.map(room => `
                            <div class="room-card" 
                                style="display: flex; background: white; border-radius: 1rem; padding: 1.5rem; margin-bottom: 1.5rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); border: 1px solid #f1f5f9;"
                                data-room-id="${room.RoomId}"
                                data-room-type-name="${room.RoomTypeName}"
                                data-room-type-code="${room.RoomTypeCode}"
                                data-rate-plan="${room.RatePlan}"
                                data-rate-plan-code="${room.RatePlanCode}"
                                data-room-index="${room.RoomIndex}"
                                data-bed-types="${room.BedTypes || ''}"
                                data-amenities='${JSON.stringify(room.Amenities || [])}'
                                data-room-images='${JSON.stringify(room.RoomImages || [])}'
                                data-cancellation-policies='${JSON.stringify(room.CancellationPolicies || [])}'
                                data-price-offered="${room.Price.OfferedPrice}"
                                data-price-published="${room.Price.PublishedPrice}"
                                data-price-currency="${room.Price.CurrencyCode}">
                                
                                <!-- Left Side - Images -->
                                <div style="flex: 0 0 300px; margin-right: 1.5rem;">
                                    <div style="position: relative; width: 100%; height: 200px; border-radius: 0.5rem; overflow: hidden;">
                                        <img src="${room.RoomImages?.[0]?.Image || '/api/placeholder/300/200'}" 
                                             alt="${room.RoomTypeName}"
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    ${room.RoomImages && room.RoomImages.length > 1 ? `
                                        <div style="display: flex; gap: 0.5rem; margin-top: 0.5rem; overflow-x: auto;">
                                            ${room.RoomImages.map((img, idx) => `
                                                <img src="${img.Image}" 
                                                     alt="Room view ${idx + 1}"
                                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 0.25rem; cursor: pointer; opacity: ${idx === 0 ? '1' : '0.6'};"
                                                     onclick="updateMainImage(this)">
                                            `).join('')}
                                        </div>
                                    ` : ''}
                                </div>

                                <!-- Right Side - Room Details -->
                                <div style="flex: 1;">
                                    <!-- Price and Room Type -->
                                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                                        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1e293b;">
                                            ${room.RoomTypeName}
                                        </h3>
                                        <div style="text-align: right;">
                                            <div style="font-size: 1.5rem; font-weight: 700; color: #2563eb;">
                                                ${room.Price.CurrencyCode} ${room.Price.OfferedPrice}
                                            </div>
                                            ${room.Price.PublishedPrice !== room.Price.OfferedPrice ? `
                                                <div style="text-decoration: line-through; color: #64748b; font-size: 0.875rem;">
                                                    ${room.Price.CurrencyCode} ${room.Price.PublishedPrice}
                                                </div>
                                            ` : ''}
                                        </div>
                                    </div>
                                        <!-- Additional Charges Section -->
                                    <div style="margin-bottom: 1rem; padding: 1rem; background: #f8fafc; border-radius: 0.5rem;">
                                        <h4 style="font-size: 1rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">
                                            Additional Charges
                                        </h4>
                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                                            <div style="background: white; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                                                <div style="font-size: 0.875rem; color: #64748b;">Extra Guest Charge</div>
                                                <div style="font-weight: 600; color: #2563eb;">
                                                    ${room.Price.CurrencyCode} ${room.Price.ExtraGuestCharge || 0}
                                                </div>
                                            </div>
                                            <div style="background: white; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                                                <div style="font-size: 0.875rem; color: #64748b;">Child Charge</div>
                                                <div style="font-weight: 600; color: #2563eb;">
                                                    ${room.Price.CurrencyCode} ${room.Price.ChildCharge || 0}
                                                </div>
                                            </div>
                                            <div style="background: white; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                                                <div style="font-size: 0.875rem; color: #64748b;">Service Tax</div>
                                                <div style="font-weight: 600; color: #2563eb;">
                                                    ${room.Price.CurrencyCode} ${room.Price.ServiceTax || 0}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                   <!-- Day Rates Section -->
                                    ${room.DayRates && room.DayRates.length > 0 ? `
                                        <div style="margin-bottom: 1rem; padding: 1rem; background: #f8fafc; border-radius: 0.5rem;">
                                            <h4 style="font-size: 1rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">
                                                Daily Rate Breakdown
                                            </h4>
                                            <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                                                ${room.DayRates.map(rate => `
                                                    <div style="background: white; padding: 0.5rem 1rem; border-radius: 0.25rem; border: 1px solid #e2e8f0;">
                                                        <div style="font-size: 0.875rem; color: #64748b;">
                                                            ${new Date(rate.Date).toLocaleDateString()}
                                                        </div>
                                                        <div style="font-weight: 600; color: #2563eb;">
                                                            ${room.Price.CurrencyCode} ${rate.Amount.toFixed(2)}
                                                        </div>
                                                    </div>
                                                `).join('')}
                                            </div>
                                        </div>
                                    ` : ''}
                                    <!-- Description and Bed Type -->
                                    <div style="color: #475569; margin-bottom: 1rem;">
                                        ${room.Description}
                                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                                            <i class="fas fa-bed"></i>
                                            ${room.BedTypes || 'N/A'}
                                        </div>
                                    </div>

                                    <!-- Amenities -->
                                    <div style="margin-bottom: 1rem;">
                                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                            ${(room.Amenities || []).map(amenity => `
                                                <span style="display: inline-flex; align-items: center; background: #f1f5f9; padding: 0.5rem 1rem; border-radius: 0.25rem; font-size: 0.875rem;">
                                                    <i class="fas ${amenity.FontAwesome || 'fa-check'}" style="margin-right: 0.5rem;"></i>
                                                    ${amenity.Name}
                                                </span>
                                            `).join('')}
                                        </div>
                                    </div>

                                    <!-- Cancellation Policy -->
                                    ${room.CancellationPolicies ? `
                                        <div style="margin-top: 1rem; padding: 1rem; background: #f8fafc; border-radius: 0.5rem;">
                                            ${room.CancellationPolicies.map(policy => `
                                                <div style="padding: 0.5rem 0; display: flex; justify-content: space-between; align-items: center;">
                                                    <span style="font-size: 0.875rem;">
                                                        ${policy.FromDate.split('T')[0]} to ${policy.ToDate.split('T')[0]}
                                                    </span>
                                                    <span style="font-size: 0.875rem; font-weight: 500; color: ${policy.Charge > 0 ? '#ef4444' : '#22c55e'};">
                                                        ${policy.Charge > 0 ? 
                                                            `Charge: ${policy.Currency} ${policy.Charge}` : 
                                                            'Free cancellation'}
                                                    </span>
                                                </div>
                                            `).join('')}
                                        </div>
                                    ` : ''}

                                    <!-- Book Now Section -->
                                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            ${room.IsPANMandatory ? `
                                                <div style="color: #f59e0b;">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                    PAN Card Required
                                                </div>
                                            ` : ''}
                                        </div>
                                        <button onclick="blockRoom('${room.RoomId}')" 
                                                style="background: #2563eb; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; border: none; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                                            <i class="fas fa-calendar-check"></i>
                                            Book Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `;
            });
            
            document.getElementById('room-details').innerHTML = roomDetailsHtml;
        } else {
            document.getElementById('room-details').innerHTML = 
                '<div style="text-align: center; padding: 2rem; color: #ef4444;">Failed to load room details</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('room-details').innerHTML = 
            '<div style="text-align: center; padding: 2rem; color: #ef4444;">An error occurred while loading room details</div>';
    })
    .finally(() => {
        roomDetailsLoaded = true;
        hideLoadingSpinner();
    });
}
// Initialize everything when the page loads
document.addEventListener('DOMContentLoaded', () => {
    showLoadingSpinner();
    fetchHotelInfo();
    fetchRoomDetails();
});

// Helper function for image gallery
function updateMainImage(thumbnail) {
    const roomCard = thumbnail.closest('.room-card');
    const mainImage = roomCard.querySelector('img[style*="height: 100%"]');
    const thumbnails = roomCard.querySelectorAll('img[style*="width: 60px"]');
    
    mainImage.src = thumbnail.src;
    thumbnails.forEach(thumb => thumb.style.opacity = '0.6');
    thumbnail.style.opacity = '1';
}

// Initialize the room details when the page loads
document.addEventListener('DOMContentLoaded', function() {
    fetchRoomDetails();
});

// Image Gallery Functions
function changeImage(roomId, direction) {
    const images = document.querySelectorAll(`.room-image-${roomId}`);
    const counter = document.querySelector(`.image-counter-${roomId}`);
    
    let currentIndex = Array.from(images).findIndex(img => img.style.opacity === '1');
    images[currentIndex].style.opacity = '0';
    
    if (direction === 'next') {
        currentIndex = (currentIndex + 1) % images.length;
    } else {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
    }
    
    images[currentIndex].style.opacity = '1';
    counter.textContent = `${currentIndex + 1}/${images.length}`;
}

// Toggle Section Function
function toggleSection(sectionId) {
    const section = document.getElementById(sectionId);
    const icon = document.querySelector(`.toggle-icon-${sectionId}`);
    
    if (section.style.display === 'none') {
        section.style.display = 'block';
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
    } else {
        section.style.display = 'none';
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    }
}

// Block Room Function (implement according to your needs)
function blockRoom(roomId) {
    // Implement your room booking logic here
    console.log('Blocking room:', roomId);
}

// Call the function when the page loads
document.addEventListener('DOMContentLoaded', function() {
    fetchRoomDetails();
});




function getRoomDataFromCard(roomId) {
    const roomCard = document.querySelector(`[data-room-id="${roomId}"]`);
    if (!roomCard) {
        console.error('Room card not found');
        return null;
    }

    return {
        RoomTypeName: roomCard.getAttribute('data-room-type-name'),
        RoomTypeCode: roomCard.getAttribute('data-room-type-code'),
        RatePlan: roomCard.getAttribute('data-rate-plan'),
        RatePlanCode: roomCard.getAttribute('data-rate-plan-code'),
        RoomImages: JSON.parse(roomCard.getAttribute('data-room-images') || '[]'),
        BedTypes: roomCard.getAttribute('data-bed-types'),
        Amenities: JSON.parse(roomCard.getAttribute('data-amenities') || '[]'),
        CancellationPolicies: JSON.parse(roomCard.getAttribute('data-cancellation-policies') || '[]'),
        OfferedPrice: roomCard.getAttribute('data-price-offered'),
        PublishedPrice: roomCard.getAttribute('data-price-published'),
        Currency: roomCard.getAttribute('data-price-currency'),
    };
}

function blockRoom(roomId) {
    const roomCard = document.querySelector(`[data-room-id="${roomId}"]`);
    if (!roomCard) {
        alert('Room information not found');
        return;
    }

    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('traceId');
    const resultIndex = urlParams.get('resultIndex');
    const hotelCode = urlParams.get('hotelCode');
    const hotelName = document.querySelector('.hotel-name').textContent;

    // Get room details from the data attributes
    const roomDetails = {
        RoomId: roomId,
        RoomIndex: roomCard.getAttribute('data-room-index'),
        RoomTypeCode: roomCard.getAttribute('data-room-type-code'),
        RoomTypeName: roomCard.getAttribute('data-room-type-name'),
        RatePlan: roomCard.getAttribute('data-rate-plan'),
        RatePlanCode: roomCard.getAttribute('data-rate-plan-code'),
        RoomImages: JSON.parse(roomCard.getAttribute('data-room-images') || '[]'),
        BedTypes: roomCard.getAttribute('data-bed-types'),
        Amenities: JSON.parse(roomCard.getAttribute('data-amenities') || '[]'),
        CancellationPolicies: JSON.parse(roomCard.getAttribute('data-cancellation-policies') || '[]'),
        RoomImages: JSON.parse(roomCard.getAttribute('data-room-images') || '[]'),
        OfferedPrice: roomCard.getAttribute('data-price-offered'),
        PublishedPrice: roomCard.getAttribute('data-price-published'),
        Currency: roomCard.getAttribute('data-price-currency')
    };

    // Serialize room details into a query string
    const serializedRoomDetails = encodeURIComponent(JSON.stringify(roomDetails));

    // Show confirmation dialog
    if (!confirm('Are you sure you want to block this room?')) {
        return;
    }

    // Show loading state
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'loading-overlay';
    loadingOverlay.innerHTML = '<div class="loading-spinner">Blocking room...</div>';
    document.body.appendChild(loadingOverlay);

    const requestBody = {
        ResultIndex: resultIndex,
        HotelCode: hotelCode,
        HotelName: hotelName,
        GuestNationality: "IN",
        NoOfRooms: "1",
        HotelRoomsDetails: [roomDetails],
        SrdvType: "MixAPI",
        SrdvIndex: "15",
        TraceId: parseInt(traceId),
        IsVoucherBooking: true,
        ClientReferenceNo: 0
    };

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
        if (data.status === 'success' && data.data?.BlockRoomResult) {
            const blockRoomResult = data.data.BlockRoomResult;
            const roomDetails = blockRoomResult.HotelRoomsDetails[0];
            
            // Show success message with room details
            const message = `
                Room blocked successfully!
                Hotel: ${blockRoomResult.HotelName}
                Room Type: ${roomDetails.RoomTypeName}
                Price: ${roomDetails.Price.CurrencyCode} ${roomDetails.Price.OfferedPriceRoundedOff}
                
                Do you want to proceed with booking?
            `;
            
            if (confirm(data.message)) {
                // Redirect to booking page with serialized room details
                window.location.href = `/room-detail?traceId=${traceId}&resultIndex=${resultIndex}&hotelCode=${hotelCode}&hotelName=${encodeURIComponent(hotelName)}&roomDetails=${serializedRoomDetails}`;
            }
        } else {
            alert('Status: ' + (data.message || 'Unknown error'));
            window.location.href = `/room-detail?traceId=${traceId}&resultIndex=${resultIndex}&hotelCode=${hotelCode}&hotelName=${encodeURIComponent(hotelName)}&roomDetails=${serializedRoomDetails}`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while blocking the room. Please try again.');
    })
    .finally(() => {
        // Remove loading overlay
        document.body.removeChild(loadingOverlay);
    });
}

    </script>
</body>
</html>