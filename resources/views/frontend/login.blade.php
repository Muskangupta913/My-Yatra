<template id="hotel-template">
    <div class="max-w-6xl mx-auto p-4 space-y-6">
        <!-- Main Hotel Info Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div style="display: flex; flex-direction: column; md:flex-direction: row; min-height: 400px;">
                <!-- Left Side - Hotel Image and Gallery -->
                <div style="flex: 0 0 40%; position: relative;">
                    <div style="position: relative; height: 100%; min-height: 300px;">
                        <img src="" alt="Main Hotel Image" class="main-image" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; bottom: 10px; right: 10px; background: white; 
                                    padding: 4px 12px; border-radius: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <span style="display: flex; align-items: center; gap: 4px;">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span class="hotel-rating font-medium"></span>
                            </span>
                        </div>
                        <button class="gallery-nav-button prev" 
                                style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%);
                                       background: rgba(0,0,0,0.5); color: white; width: 40px; height: 40px;
                                       border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="gallery-nav-button next"
                                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
                                       background: rgba(0,0,0,0.5); color: white; width: 40px; height: 40px;
                                       border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="thumbnails-container" 
                         style="position: absolute; bottom: 0; left: 0; right: 0; 
                                display: flex; gap: 4px; padding: 10px; background: rgba(0,0,0,0.5); 
                                overflow-x: auto;">
                    </div>
                </div>

                <!-- Right Side - Hotel Details -->
                <div style="flex: 1; padding: 24px;">
                    <div style="height: 100%; display: flex; flex-direction: column;">
                        <!-- Hotel Name and Basic Info -->
                        <div style="margin-bottom: 20px;">
                            <h1 class="hotel-name" 
                                style="font-size: 24px; font-weight: 700; color: #1F2937; margin-bottom: 10px;"></h1>
                            <div style="display: flex; flex-wrap: wrap; gap: 16px;">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-red-500"></i>
                                    <span class="hotel-address text-gray-600"></span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-phone text-green-500"></i>
                                    <span class="hotel-contact text-gray-600"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Hotel Facilities -->
                        <div style="margin-bottom: 20px;">
                            <h2 style="font-size: 18px; font-weight: 600; color: #1F2937; margin-bottom: 12px;">
                                Hotel Facilities
                            </h2>
                            <div class="facilities-list" 
                                 style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px;">
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="hotel-description" style="margin-bottom: 20px;">
                            <h2 style="font-size: 18px; font-weight: 600; color: #1F2937; margin-bottom: 12px;">
                                About the Hotel
                            </h2>
                        </div>

                        <!-- Map -->
                        <div style="flex-grow: 1; min-height: 200px; border-radius: 8px; overflow: hidden;">
                            <div id="hotel-map" style="width: 100%; height: 100%; min-height: 200px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
function renderHotelDetails(hotel) {
    const template = document.getElementById('hotel-template');
    const content = template.content.cloneNode(true);
    const container = document.getElementById('hotel-details');
    
    // Clear existing content
    container.innerHTML = '';
    
    // Set basic hotel information
    content.querySelector('.hotel-name').textContent = hotel.HotelName;
    content.querySelector('.hotel-rating').textContent = `${hotel.StarRating} Star Rating`;
    content.querySelector('.hotel-address').textContent = 
        `${hotel.Address}, ${hotel.City}, ${hotel.State}, ${hotel.PinCode}`;
    content.querySelector('.hotel-contact').textContent = hotel.HotelContactNo || 'Not Available';

    // Setup image gallery
    let currentImageIndex = 0;
    const mainImage = content.querySelector('.main-image');
    const thumbnailsContainer = content.querySelector('.thumbnails-container');
    
    if (hotel.Images && hotel.Images.length > 0) {
        mainImage.src = hotel.Images[0];
        mainImage.alt = hotel.HotelName;
        
        // Create thumbnails
        hotel.Images.forEach((img, index) => {
            const thumbnail = document.createElement('button');
            thumbnail.className = `flex-none thumbnail ${index === 0 ? 'active' : ''}`;
            thumbnail.style.cssText = `
                width: 60px; 
                height: 40px; 
                border-radius: 4px; 
                overflow: hidden; 
                opacity: ${index === 0 ? '1' : '0.6'};
                transition: opacity 0.3s ease;
            `;
            thumbnail.innerHTML = `<img src="${img}" alt="View ${index + 1}" 
                                      style="width: 100%; height: 100%; object-fit: cover;">`;
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
                thumb.style.opacity = index === currentImageIndex ? '1' : '0.6';
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
                <i class="${facility.FontAwesome} text-blue-500"></i>
                <span class="text-gray-700 text-sm">${facility.Name}</span>
            `;
            facilitiesList.appendChild(facilityDiv);
        });
    }

    // Render description
    const descriptionContainer = content.querySelector('.hotel-description');
    if (hotel.Description) {
        hotel.Description.forEach(section => {
            if (section.Detail && section.Detail.length > 0) {
                const sectionDiv = document.createElement('div');
                sectionDiv.className = 'mb-4';
                sectionDiv.innerHTML = `
                    <h3 class="font-semibold text-gray-800 mb-2">${section.Name}</h3>
                    <div class="text-gray-600 text-sm space-y-1">
                        ${section.Detail.map(detail => `<p>${detail}</p>`).join('')}
                    </div>
                `;
                descriptionContainer.appendChild(sectionDiv);
            }
        });
    }

    // Initialize map if coordinates are available
    const mapContainer = content.querySelector('#hotel-map');
    if (hotel.Latitude && hotel.Longitude) {
        // Initialize Google Maps
        const mapScript = document.createElement('script');
        mapScript.src = `https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY`;
        mapScript.onload = () => {
            const map = new google.maps.Map(mapContainer, {
                center: { lat: parseFloat(hotel.Latitude), lng: parseFloat(hotel.Longitude) },
                zoom: 15
            });
            new google.maps.Marker({
                position: { lat: parseFloat(hotel.Latitude), lng: parseFloat(hotel.Longitude) },
                map: map,
                title: hotel.HotelName
            });
        };
        document.head.appendChild(mapScript);
    }

    container.appendChild(content);
}

.thumbnail.active {
    border: 2px solid #3B82F6;
}

.gallery-nav-button {
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.gallery-nav-button:hover {
    opacity: 1;
}

@media (max-width: 768px) {
    .main-hotel-content {
        flex-direction: column;
    }
    
    .hotel-image-section {
        width: 100%;
        min-height: 250px;
    }
    
    .hotel-details-section {
        width: 100%;
    }
}