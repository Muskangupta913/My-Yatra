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
    <!-- Include Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <style>
/* Core layout and reset */
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

/* Loading Spinner */
#loadingSpinner {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
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

/* Book Now Button */
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
    
    .room-image-gallery {
        flex: none;
    }
}
</style>
</head>
<body >
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

        <!-- Main Content Area -->
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Left Side - Image Gallery -->
            <div class="md:w-2/3">
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="relative aspect-video rounded-lg overflow-hidden">
                        <img src="" alt="Main Hotel Image" class="main-image w-full h-full object-cover">
                        <button class="gallery-nav-button prev absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="gallery-nav-button next absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="flex gap-2 mt-2 overflow-x-auto pb-2 thumbnails-container">
                        <!-- Thumbnails will be populated here -->
                    </div>
                </div>

                <!-- Hotel Description Below Gallery -->
                <div class="mt-6 bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4">About the Hotel</h2>
                    <div class="space-y-4 hotel-description">
                        <!-- Description will be populated here -->
                    </div>
                </div>
            </div>

            <!-- Right Side - Hotel Details Sidebar -->
            <div class="md:w-1/3">
                <div class="bg-white rounded-lg shadow p-6 space-y-6 sticky top-4">
                    <h2 class="text-xl font-semibold border-b pb-2">Hotel Information</h2>
                    
                    <!-- Location Details -->
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-map-marked-alt text-blue-500 mt-1"></i>
                            <div>
                                <h3 class="font-semibold text-gray-700">Address</h3>
                                <p class="text-gray-600 hotel-full-address"></p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <i class="fas fa-globe-asia text-blue-500 mt-1"></i>
                            <div>
                                <h3 class="font-semibold text-gray-700">Location</h3>
                                <p class="text-gray-600">
                                    <span class="hotel-city"></span>,
                                    <span class="hotel-state"></span>
                                </p>
                                <p class="text-gray-600">
                                    <span class="hotel-country"></span>
                                    <span class="hotel-pincode"></span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <i class="fas fa-location-crosshairs text-blue-500 mt-1"></i>
                            <div>
                                <h3 class="font-semibold text-gray-700">Coordinates</h3>
                                <p class="text-gray-600">
                                    <span class="hotel-latitude"></span>, 
                                    <span class="hotel-longitude"></span>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <i class="fas fa-phone-alt text-blue-500 mt-1"></i>
                            <div>
                                <h3 class="font-semibold text-gray-700">Contact</h3>
                                <p class="text-gray-600 hotel-phone"></p>
                                <p class="text-gray-600 hotel-email"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Facilities Section -->
                    <div class="border-t pt-4">
                        <h3 class="font-semibold text-gray-700 mb-3">Hotel Facilities</h3>
                        <div class="grid grid-cols-1 gap-2 facilities-list">
                            <!-- Facilities will be populated here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

    <div class="room-info-container">
        <div id="room-details" class="loading-state">Loading room details...</div>
    </div>
    <!-- Include Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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
}function renderHotelDetails(hotel) {
    const template = document.getElementById('hotel-template');
    const content = template.content.cloneNode(true);
    const container = document.getElementById('hotel-details');
    
    // Clear existing content
    container.innerHTML = '';
    
    // Enhanced header section with styling
    const headerHtml = `
        <div style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); border: 1px solid #e2e8f0; padding: 2rem; margin-bottom: 2rem;">
            <h1 style="font-size: 2rem; font-weight: 700; color: #1e40af; margin-bottom: 1.5rem; border-bottom: 2px solid #93c5fd; padding-bottom: 0.75rem;">
                ${hotel.HotelName}
            </h1>
            
            <div style="display: flex; flex-wrap: wrap; gap: 2rem; margin-top: 1rem;">
                <!-- Location Info -->
                <div style="display: flex; align-items: center; gap: 0.75rem; background: #f0f9ff; padding: 0.75rem 1.25rem; border-radius: 0.75rem; border: 1px solid #bfdbfe;">
                    <div style="background: #2563eb; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-map-marker-alt" style="color: white; font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.25rem;">Location</div>
                        <div style="color: #1e40af; font-weight: 500;">${hotel.Address}</div>
                    </div>
                </div>

                <!-- Rating Info -->
                <div style="display: flex; align-items: center; gap: 0.75rem; background: #fffbeb; padding: 0.75rem 1.25rem; border-radius: 0.75rem; border: 1px solid #fcd34d;">
                    <div style="background: #f59e0b; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-star" style="color: white; font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.25rem;">Rating</div>
                        <div style="color: #b45309; font-weight: 500;">${hotel.StarRating} Star Rating</div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div style="display: flex; align-items: center; gap: 0.75rem; background: #f0fdf4; padding: 0.75rem 1.25rem; border-radius: 0.75rem; border: 1px solid #86efac;">
                    <div style="background: #16a34a; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-phone" style="color: white; font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 0.25rem;">Contact</div>
                        <div style="color: #166534; font-weight: 500;">${hotel.HotelContactNo}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Left Side - Image Gallery -->
            <div class="md:w-2/3">
                <div style="background: white; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #e2e8f0; padding: 1.5rem;">
                    <div style="position: relative; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                        <img src="${hotel.Images?.[0] || ''}" alt="Main Hotel Image" class="main-image" style="width: 100%; height: 400px; object-fit: cover;">
                        <button class="gallery-nav-button prev" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); background: rgba(0, 0, 0, 0.6); color: white; width: 40px; height: 40px; border-radius: 50%; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.3s;">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="gallery-nav-button next" style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); background: rgba(0, 0, 0, 0.6); color: white; width: 40px; height: 40px; border-radius: 50%; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.3s;">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="thumbnails-container" style="display: flex; gap: 0.5rem; margin-top: 1rem; overflow-x: auto; padding: 0.5rem;"></div>
                </div>

                <!-- Hotel Description Below Gallery -->
                <div style="margin-top: 2rem; background: white; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #e2e8f0; padding: 1.5rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e40af; margin-bottom: 1rem; border-bottom: 2px solid #93c5fd; padding-bottom: 0.5rem;">About the Hotel</h2>
                    <div class="hotel-description" style="color: #475569;"></div>
                </div>
            </div>

            <!-- Right Side - Hotel Details Sidebar -->
            <div class="md:w-1/3">
                <div style="background: white; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #e2e8f0; padding: 1.5rem; position: sticky; top: 1rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 600; color: #1e40af; margin-bottom: 1rem; border-bottom: 2px solid #93c5fd; padding-bottom: 0.5rem;">Hotel Information</h2>
                    
                    <!-- Location Details -->
                    <div style="space-y-4">
                        <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                            <i class="fas fa-map-marked-alt" style="color: #2563eb; margin-top: 0.25rem;"></i>
                            <div>
                                <h3 style="font-weight: 600; color: #1e40af; margin-bottom: 0.25rem;">Address</h3>
                                <p style="color: #475569;">${hotel.Address}</p>
                            </div>
                        </div>

                        <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                            <i class="fas fa-globe-asia" style="color: #2563eb; margin-top: 0.25rem;"></i>
                            <div>
                                <h3 style="font-weight: 600; color: #1e40af; margin-bottom: 0.25rem;">Location</h3>
                                <p style="color: #475569;">
                                    ${hotel.City}, ${hotel.State}<br>
                                    ${hotel.CountryName} ${hotel.PinCode}
                                </p>
                            </div>
                        </div>

                        <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                            <i class="fas fa-phone-alt" style="color: #2563eb; margin-top: 0.25rem;"></i>
                            <div>
                                <h3 style="font-weight: 600; color: #1e40af; margin-bottom: 0.25rem;">Contact</h3>
                                <p style="color: #475569;">
                                    ${hotel.HotelContactNo}<br>
                                    ${hotel.Email || 'Not Available'}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Facilities Section -->
                    <div style="border-top: 1px solid #e2e8f0; margin-top: 1.5rem; padding-top: 1.5rem;">
                        <h3 style="font-weight: 600; color: #1e40af; margin-bottom: 1rem;">Hotel Facilities</h3>
                        <div class="facilities-list" style="display: grid; gap: 0.5rem;"></div>
                    </div>
                </div>
            </div>
        </div>
    `;

    container.innerHTML = headerHtml;

    // Setup image gallery
    let currentImageIndex = 0;
    const mainImage = container.querySelector('.main-image');
    const thumbnailsContainer = container.querySelector('.thumbnails-container');
    
    if (hotel.Images && hotel.Images.length > 0) {
        mainImage.src = hotel.Images[0];
        
        // Create thumbnails
        hotel.Images.forEach((img, index) => {
            const thumbnail = document.createElement('button');
            thumbnail.style = `flex: 0 0 auto; width: 80px; height: 60px; border-radius: 0.5rem; overflow: hidden; border: 2px solid ${index === 0 ? '#2563eb' : 'transparent'}; transition: all 0.3s ease;`;
            thumbnail.innerHTML = `<img src="${img}" alt="Thumbnail ${index + 1}" style="width: 100%; height: 100%; object-fit: cover;">`;
            thumbnail.onclick = () => {
                currentImageIndex = index;
                updateMainImage();
            };
            thumbnailsContainer.appendChild(thumbnail);
        });

        // Setup navigation buttons
        const prevButton = container.querySelector('.gallery-nav-button.prev');
        const nextButton = container.querySelector('.gallery-nav-button.next');
        
        prevButton.onclick = () => {
            currentImageIndex = (currentImageIndex - 1 + hotel.Images.length) % hotel.Images.length;
            updateMainImage();
        };
        
        nextButton.onclick = () => {
            currentImageIndex = (currentImageIndex + 1) % hotel.Images.length;
            updateMainImage();
        };

        function updateMainImage() {
            mainImage.src = hotel.Images[currentImageIndex];
            thumbnailsContainer.querySelectorAll('button').forEach((thumb, index) => {
                thumb.style.border = `2px solid ${index === currentImageIndex ? '#2563eb' : 'transparent'}`;
            });
        }
    }

    // Render facilities
    const facilitiesList = container.querySelector('.facilities-list');
    if (hotel.HotelFacilities) {
        hotel.HotelFacilities.forEach(facility => {
            const facilityDiv = document.createElement('div');
            facilityDiv.style = 'display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f8fafc; border-radius: 0.5rem; border: 1px solid #e2e8f0; transition: all 0.3s ease;';
            facilityDiv.innerHTML = `
                <i class="fas ${facility.FontAwesome}" style="color: #2563eb;"></i>
                <span style="color: #475569;">${facility.Name}</span>
            `;
            facilitiesList.appendChild(facilityDiv);
        });
    }

    // Render hotel description
    const descriptionContainer = container.querySelector('.hotel-description');
    if (hotel.Description) {
        hotel.Description.forEach(section => {
            const sectionDiv = document.createElement('div');
            sectionDiv.style = 'margin-bottom: 1.5rem;';
            sectionDiv.innerHTML = `
                <h3 style="font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">${section.Name}</h3>
                <ul style="list-style-type: disc; padding-left: 1.5rem; color: #475569;">
                    ${section.Detail.map(detail => `
                        <li style="margin-bottom: 0.5rem;">${detail}</li>
                    `).join('')}
                </ul>
            `;
            descriptionContainer.appendChild(sectionDiv);
        });
    }
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
                                        Cancellation Policies:-
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
                                            Select Room
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
    // Validate required parameters first
    const roomCard = document.querySelector(`[data-room-id="${roomId}"]`);
    if (!roomCard) {
        showToast('error', 'Room information not found');
        return;
    }

    const urlParams = new URLSearchParams(window.location.search);
    const requiredParams = {
        traceId: urlParams.get('traceId'),
        resultIndex: urlParams.get('resultIndex'),
        hotelCode: urlParams.get('hotelCode')
    };

    // Validate all required URL parameters
    for (const [key, value] of Object.entries(requiredParams)) {
        if (!value) {
            showToast('error', `Missing required parameter: ${key}`);
            return;
        }
    }

    const hotelName = document.querySelector('.hotel-name')?.textContent || 
                      document.querySelector('h1')?.textContent || 
                      'Unknown Hotel';

    // Get room details and validate required fields
    const roomDetails = {
        RoomId: roomId,
        RoomIndex: roomCard.getAttribute('data-room-index'),
        RoomTypeCode: roomCard.getAttribute('data-room-type-code'),
        RoomTypeName: roomCard.getAttribute('data-room-type-name'),
        RatePlan: roomCard.getAttribute('data-rate-plan'),
        RatePlanCode: roomCard.getAttribute('data-rate-plan-code'),
        RoomImages: safeParseJSON(roomCard.getAttribute('data-room-images'), []),
        BedTypes: roomCard.getAttribute('data-bed-types'),
        Amenities: safeParseJSON(roomCard.getAttribute('data-amenities'), []),
        CancellationPolicies: safeParseJSON(roomCard.getAttribute('data-cancellation-policies'), []),
        OfferedPrice: roomCard.getAttribute('data-price-offered'),
        PublishedPrice: roomCard.getAttribute('data-price-published'),
        Currency: roomCard.getAttribute('data-price-currency')
    };

    // Validate required room details
    const requiredRoomFields = ['RoomTypeCode', 'RoomTypeName', 'OfferedPrice', 'Currency'];
    for (const field of requiredRoomFields) {
        if (!roomDetails[field]) {
            showToast('error', `Missing required room information: ${field}`);
            return;
        }
    }

    // Update button state
    const submitButton = document.querySelector(`button[onclick*="blockRoom('${roomId}')"]`);
    if (submitButton) {
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner"></span> Processing...';
    }

    const requestBody = {
        ResultIndex: requiredParams.resultIndex,
        HotelCode: requiredParams.hotelCode,
        HotelName: hotelName,
        GuestNationality: "IN",
        NoOfRooms: "1",
        HotelRoomsDetails: [roomDetails],
        SrdvType: "MixAPI",
        SrdvIndex: "15",
        TraceId: parseInt(requiredParams.traceId),
        IsVoucherBooking: true,
        ClientReferenceNo: 0
    };

    // Show processing toast
    const processingToastId = showToast('info', 'Processing your request...', false);

    fetch('/block-room', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
        },
        body: JSON.stringify(requestBody)
    })
    .then(response => response.json())
    .then(data => {
        // Remove processing toast
        removeToast(processingToastId);

        // Prepare redirect URL params
        const redirectParams = new URLSearchParams({
            traceId: requiredParams.traceId,
            resultIndex: requiredParams.resultIndex,
            hotelCode: requiredParams.hotelCode,
            hotelName: hotelName,
            roomDetails: JSON.stringify(roomDetails)
        });

        // Check if BlockRoomResult exists in the response
        if (data.data?.BlockRoomResult) {
            const blockRoomResult = data.data.BlockRoomResult;
            
            showToast('success', 'Room blocked successfully!');
            
            // Redirect after a short delay to allow toast to be seen
            setTimeout(() => {
                window.location.href = `/room-detail?${redirectParams.toString()}`;
            }, 1500);
        } else if (data.status === 'success') {
            // Handle case where status is success but no BlockRoomResult
            showToast('success', data.message || 'Room blocked successfully!');
            
            setTimeout(() => {
                window.location.href = `/room-detail?${redirectParams.toString()}`;
            }, 1500);
        } else {
            // Show error message if neither condition is met
            showToast('error', data.message || 'Failed to block room');
            
            setTimeout(() => {
                window.location.href = `/room-detail?${redirectParams.toString()}`;
            }, 2000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        removeToast(processingToastId);
        showToast('error', 'An error occurred while blocking the room');
        
        // Redirect to room detail page after error
        const redirectParams = new URLSearchParams({
            traceId: requiredParams.traceId,
            resultIndex: requiredParams.resultIndex,
            hotelCode: requiredParams.hotelCode,
            hotelName: hotelName,
            roomDetails: JSON.stringify(roomDetails)
        });
        
        setTimeout(() => {
            window.location.href = `/room-detail?${redirectParams.toString()}`;
        }, 2000);
    })
    .finally(() => {
        // Reset button state
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.textContent = 'Block Room';
        }
    });
}

// Helper functions remain the same
function safeParseJSON(str, defaultValue = null) {
    try {
        return str ? JSON.parse(str) : defaultValue;
    } catch (e) {
        console.error('JSON Parse Error:', e);
        return defaultValue;
    }
}

// Toast notification system and CSS remain the same
function showToast(type, message, autoClose = true) {
    const toast = document.createElement('div');
    const toastId = 'toast-' + Date.now();
    toast.id = toastId;
    toast.className = `toast toast-${type}`;
    
    const icons = {
        success: '✓',
        error: '✕',
        info: 'ℹ',
        warning: '⚠'
    };
    
    toast.innerHTML = `
        <div class="toast-content">
            <span class="toast-icon">${icons[type]}</span>
            <span class="toast-message">${message}</span>
            ${autoClose ? '<button class="toast-close" onclick="removeToast(\'' + toastId + '\')">×</button>' : ''}
        </div>
    `;
    
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container';
        document.body.appendChild(toastContainer);
    }
    
    toastContainer.appendChild(toast);
    
    if (autoClose) {
        setTimeout(() => removeToast(toastId), 3000);
    }
    
    return toastId;
}

function removeToast(toastId) {
    const toast = document.getElementById(toastId);
    if (toast) {
        toast.remove();
    }
    
    const container = document.querySelector('.toast-container');
    if (container && !container.hasChildNodes()) {
        container.remove();
    }
}

// Styles remain the same
const style = document.createElement('style');
style.textContent = `
    .toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
    }

    .toast {
        margin-bottom: 10px;
        padding: 15px;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        min-width: 300px;
        max-width: 500px;
        animation: slideIn 0.3s ease-in-out;
    }

    .toast-content {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .toast-success {
        background-color: #4caf50;
        color: white;
    }

    .toast-error {
        background-color: #f44336;
        color: white;
    }

    .toast-info {
        background-color: #2196f3;
        color: white;
    }

    .toast-warning {
        background-color: #ff9800;
        color: white;
    }

    .toast-close {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        margin-left: auto;
    }

    .spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;

document.head.appendChild(style);

    </script>
</body>
</html>