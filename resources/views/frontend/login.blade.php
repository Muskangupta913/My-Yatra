function renderHotelDetails(hotel) {
    const template = document.getElementById('hotel-template');
    const content = template.content.cloneNode(true);
    const container = document.getElementById('hotel-details');
    
    // Clear existing content
    container.innerHTML = '';
    
    // Enhanced header section with styling - KEEPING THE HEADER
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
            <!-- Left Side - Image Gallery - KEEPING ONLY THE GALLERY SECTION -->
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
            </div>

            <!-- Right Side - Hotel Details Sidebar - KEEPING ONLY THE BASIC INFO PART -->
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
                    
                    <!-- REMOVING THE FACILITIES SECTION FROM HERE -->
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

    // STORING HOTEL INFORMATION IN GLOBAL VARIABLES TO ACCESS AFTER ROOM RENDERING
    window.hotelDescription = hotel.Description;
    window.hotelFacilities = hotel.HotelFacilities;
}

// Modify fetchRoomDetails to append hotel info after rendering rooms
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
            
            // HIGHLIGHT START: Adding hotel description and facilities AFTER room details
            appendHotelDetailsFooter();
            // HIGHLIGHT END
            
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "An error occured.Kindly Refresh the page!"
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "An error occured.Kindly Refresh the page!"
        });
    })
    .finally(() => {
        roomDetailsLoaded = true;
        hideLoadingSpinner();
    });
}

// HIGHLIGHT START: New function to append hotel details as footer
function appendHotelDetailsFooter() {
    // Only proceed if we have the global variables set
    if (!window.hotelDescription && !window.hotelFacilities) {
        return;
    }
    
    // Create footer container
    const footerContainer = document.createElement('div');
    footerContainer.className = 'hotel-footer-details';
    footerContainer.style = 'margin-top: 3rem; padding-top: 2rem; border-top: 2px solid #e2e8f0;';
    
    // Add the title
    const footerTitle = document.createElement('h2');
    footerTitle.style = 'font-size: 1.75rem; font-weight: 700; color: #1e40af; margin-bottom: 2rem; text-align: center;';
    footerTitle.textContent = 'More About This Hotel';
    footerContainer.appendChild(footerTitle);
    
    // Create a flex container for the two sections
    const flexContainer = document.createElement('div');
    flexContainer.style = 'display: flex; flex-wrap: wrap; gap: 2rem;';
    footerContainer.appendChild(flexContainer);
    
    // About the Hotel Section
    if (window.hotelDescription) {
        const descriptionSection = document.createElement('div');
        descriptionSection.style = 'flex: 1; min-width: 300px; background: white; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #e2e8f0; padding: 1.5rem;';
        
        const descriptionTitle = document.createElement('h3');
        descriptionTitle.style = 'font-size: 1.5rem; font-weight: 600; color: #1e40af; margin-bottom: 1rem; border-bottom: 2px solid #93c5fd; padding-bottom: 0.5rem;';
        descriptionTitle.textContent = 'About the Hotel';
        descriptionSection.appendChild(descriptionTitle);
        
        const descriptionContent = document.createElement('div');
        descriptionContent.className = 'hotel-description';
        descriptionContent.style = 'color: #475569;';
        
        window.hotelDescription.forEach(section => {
            const sectionDiv = document.createElement('div');
            sectionDiv.style = 'margin-bottom: 1.5rem;';
            sectionDiv.innerHTML = `
                <h4 style="font-weight: 600; color: #1e40af; margin-bottom: 0.75rem;">${section.Name}</h4>
                <ul style="list-style-type: disc; padding-left: 1.5rem; color: #475569;">
                    ${section.Detail.map(detail => `
                        <li style="margin-bottom: 0.5rem;">${detail}</li>
                    `).join('')}
                </ul>
            `;
            descriptionContent.appendChild(sectionDiv);
        });
        
        descriptionSection.appendChild(descriptionContent);
        flexContainer.appendChild(descriptionSection);
    }
    
    // Facilities Section
    if (window.hotelFacilities) {
        const facilitiesSection = document.createElement('div');
        facilitiesSection.style = 'flex: 1; min-width: 300px; background: white; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border: 1px solid #e2e8f0; padding: 1.5rem;';
        
        const facilitiesTitle = document.createElement('h3');
        facilitiesTitle.style = 'font-size: 1.5rem; font-weight: 600; color: #1e40af; margin-bottom: 1rem; border-bottom: 2px solid #93c5fd; padding-bottom: 0.5rem;';
        facilitiesTitle.textContent = 'Hotel Facilities';
        facilitiesSection.appendChild(facilitiesTitle);
        
        const facilitiesList = document.createElement('div');
        facilitiesList.className = 'facilities-list';
        facilitiesList.style = 'display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;';
        
        window.hotelFacilities.forEach(facility => {
            const facilityDiv = document.createElement('div');
            facilityDiv.style = 'display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f8fafc; border-radius: 0.5rem; border: 1px solid #e2e8f0; transition: all 0.3s ease;';
            facilityDiv.innerHTML = `
                <i class="fas ${facility.FontAwesome}" style="color: #2563eb;"></i>
                <span style="color: #475569;">${facility.Name}</span>
            `;
            facilitiesList.appendChild(facilityDiv);
        });
        
        facilitiesSection.appendChild(facilitiesList);
        flexContainer.appendChild(facilitiesSection);
    }
    
    // Append the footer to the room details container
    document.getElementById('room-details').appendChild(footerContainer);
}
// HIGHLIGHT END