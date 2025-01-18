<!-- room-details.blade.php -->
<div class="room-info-container mx-auto max-w-7xl px-4 py-8">
    <div id="room-details" class="loading-state">
        <div class="flex justify-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
        </div>
    </div>
</div>

<script>
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
            
            data.data.hotelRoomsDetails.forEach(category => {
                roomDetailsHtml += `
                    <div class="room-category mb-8">
                        <h2 class="text-2xl font-bold mb-6 text-gray-900 border-b pb-2">${category.CategoryName}</h2>
                        <div class="space-y-8">
                            ${category.Rooms.map(room => `
                                <div class="room-card bg-white rounded-xl shadow-lg overflow-hidden"
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
                                    
                                    <div class="flex flex-col md:flex-row">
                                        <!-- Left Side - Image Carousel -->
                                        <div class="relative w-full md:w-2/5 h-[300px] md:h-[400px]">
                                            ${room.RoomImages && room.RoomImages.length ? `
                                                <div class="image-carousel" data-room-id="${room.RoomId}">
                                                    <img src="${room.RoomImages[0].Image}" 
                                                         alt="${room.RoomTypeName}" 
                                                         class="w-full h-full object-cover"
                                                         id="room-image-${room.RoomId}">
                                                    
                                                    <button onclick="changeImage('${room.RoomId}', 'prev')"
                                                            class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-colors">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </button>
                                                    <button onclick="changeImage('${room.RoomId}', 'next')"
                                                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition-colors">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </button>
                                                    
                                                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                                                        ${room.RoomImages.map((_, idx) => `
                                                            <button onclick="setImage('${room.RoomId}', ${idx})"
                                                                    class="w-2 h-2 rounded-full bg-white/50 hover:bg-white/90 transition-colors image-dot"
                                                                    data-index="${idx}"></button>
                                                        `).join('')}
                                                    </div>
                                                </div>
                                            ` : '<div class="w-full h-full bg-gray-100 flex items-center justify-center"><i class="fas fa-image text-4xl text-gray-400"></i></div>'}
                                        </div>

                                        <!-- Right Side - Room Details -->
                                        <div class="flex-1 p-6">
                                            <!-- Room Header -->
                                            <div class="flex justify-between items-start mb-6">
                                                <div>
                                                    <h3 class="text-2xl font-semibold text-gray-900">${room.RoomTypeName}</h3>
                                                    ${room.BedTypes ? `
                                                        <p class="text-gray-600 mt-2 flex items-center gap-2">
                                                            <i class="fas fa-bed"></i> ${room.BedTypes}
                                                        </p>
                                                    ` : ''}
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-3xl font-bold text-blue-600">
                                                        ${room.Price.CurrencyCode} ${room.Price.OfferedPrice}
                                                    </p>
                                                    ${room.Price.PublishedPrice !== room.Price.OfferedPrice ? `
                                                        <p class="text-gray-500 line-through text-sm mt-1">
                                                            ${room.Price.CurrencyCode} ${room.Price.PublishedPrice}
                                                        </p>
                                                    ` : ''}
                                                </div>
                                            </div>

                                            <!-- Room Description -->
                                            ${room.Description ? `
                                                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                                    <p class="text-gray-700">${room.Description}</p>
                                                </div>
                                            ` : ''}

                                            <!-- Amenities -->
                                            ${room.Amenities && room.Amenities.length ? `
                                                <div class="mb-6">
                                                    <h4 class="text-lg font-semibold mb-3">Room Amenities</h4>
                                                    <div class="flex flex-wrap gap-2">
                                                        ${room.Amenities.map(amenity => `
                                                            <span class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm">
                                                                <i class="fas ${amenity.FontAwesome || 'fa-check'}"></i>
                                                                ${amenity.Name}
                                                            </span>
                                                        `).join('')}
                                                    </div>
                                                </div>
                                            ` : ''}

                                            <!-- Services Status -->
                                            ${room.ServicesStatus ? `
                                                <div class="mb-6">
                                                    <h4 class="text-lg font-semibold mb-3">Services</h4>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                        ${room.ServicesStatus.map(service => `
                                                            <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-lg">
                                                                <i class="fas fa-check-circle text-blue-600"></i>
                                                                <span class="text-sm">${service.Name}: ${service.Value}</span>
                                                            </div>
                                                        `).join('')}
                                                    </div>
                                                </div>
                                            ` : ''}

                                            <!-- Cancellation Policy -->
                                            ${room.CancellationPolicies ? `
                                                <div class="mb-6">
                                                    <h4 class="text-lg font-semibold mb-3 flex items-center gap-2">
                                                        <i class="fas fa-info-circle text-blue-600"></i>
                                                        Cancellation Policy
                                                    </h4>
                                                    <div class="space-y-2">
                                                        ${room.CancellationPolicies.map(policy => `
                                                            <div class="text-sm p-3 bg-gray-50 rounded-lg">
                                                                <p class="text-gray-600">
                                                                    ${policy.FromDate.split('T')[0]} to ${policy.ToDate.split('T')[0]}
                                                                </p>
                                                                <p class="font-medium mt-1">
                                                                    ${policy.Charge > 0 
                                                                        ? `Cancellation charge: ${policy.Currency} ${policy.Charge}`
                                                                        : '<span class="text-green-600">Free cancellation</span>'}
                                                                </p>
                                                            </div>
                                                        `).join('')}
                                                    </div>
                                                </div>
                                            ` : ''}

                                            <!-- Booking Section -->
                                            <div class="flex items-center justify-between pt-4 border-t mt-6">
                                                <div>
                                                    ${room.IsPANMandatory ? `
                                                        <p class="text-amber-600 text-sm flex items-center gap-2">
                                                            <i class="fas fa-id-card"></i>
                                                            PAN Card Required
                                                        </p>
                                                    ` : ''}
                                                </div>
                                                <button onclick="blockRoom('${room.RoomId}')"
                                                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                                                    <i class="fas fa-calendar-check"></i>
                                                    Book Now
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            });
            
            document.getElementById('room-details').innerHTML = roomDetailsHtml;
            initializeImageCarousels();
        } else {
            document.getElementById('room-details').innerHTML = 
                '<div class="error-state p-4 text-center text-gray-600">Failed to load room details</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('room-details').innerHTML = 
            '<div class="error-state p-4 text-center text-red-600">An error occurred while loading room details</div>';
    });
}

// Image carousel functions
function initializeImageCarousels() {
    document.querySelectorAll('.image-carousel').forEach(carousel => {
        const roomId = carousel.dataset.roomId;
        const roomData = getRoomDataFromCard(roomId);
        if (roomData && roomData.RoomImages) {
            setImage(roomId, 0); // Initialize with first image
        }
    });
}

function changeImage(roomId, direction) {
    const roomData = getRoomDataFromCard(roomId);
    if (!roomData || !roomData.RoomImages.length) return;

    const currentImage = document.getElementById(`room-image-${roomId}`).src;
    const currentIndex = roomData.RoomImages.findIndex(img => img.Image === currentImage);
    let newIndex;

    if (direction === 'next') {
        newIndex = currentIndex === roomData.RoomImages.length - 1 ? 0 : currentIndex + 1;
    } else {
        newIndex = currentIndex === 0 ? roomData.RoomImages.length - 1 : currentIndex - 1;
    }

    setImage(roomId, newIndex);
}

function setImage(roomId, index) {
    const roomData = getRoomDataFromCard(roomId);
    if (!roomData || !roomData.RoomImages[index]) return;

    const imageElement = document.getElementById(`room-image-${roomId}`);
    imageElement.src = roomData.RoomImages[index].Image;

    // Update dots
    const carousel = document.querySelector(`.image-carousel[data-room-id="${roomId}"]`);
    carousel.querySelectorAll('.image-dot').forEach((dot, idx) => {
        if (idx === index) {
            dot.classList.remove('bg-white/50');
            dot.classList.add('bg-white');
        } else {
            dot.classList.add('bg-white/50');
            dot.classList.remove('bg-white');
        }
    });
}

// Initialize the page
document.addEventListener('DOMContentLoaded', fetchRoomDetails);
</script>