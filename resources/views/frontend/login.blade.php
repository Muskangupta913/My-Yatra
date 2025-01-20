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
                                [Previous image section remains the same...]

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

                                    [Rest of the existing sections remain the same...]
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