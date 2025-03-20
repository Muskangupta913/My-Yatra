container.innerHTML = points.map(point => `
        <div class="pickup-point-item" data-point-index="${point.index}">
            <div class="position-relative p-3">
                   <div class="d-flex justify-content-between align-items-start mb-2">
                    <!-- Point Name -->
                    <h5 class="mb-0 text-break" style="max-width: 75%;">${point.location}</h5>
                    
                    <!-- Time Badge -->
                    <span class="pickup-time badge bg-light text-dark ms-2 text-nowrap">
                        🕒 ${formatTime(point.time)}
                    </span>
                </div>
                
                <!-- Details Grid -->
                <div class="point-details">
                    <p class="text-break"><i class="fas fa-building"></i> ${point.address}</p>
                    <p class="text-break"><i class="fas fa-landmark"></i> ${point.landmark}</p>
                    <p class="text-break"><i class="fas fa-phone"></i> ${point.contact_number}</p>
                </div>
                
                <!-- Select Button -->
             <button class="btn btn-outline-success btn-sm mt-3 select-btn" 
    onclick="selectPickupPoint(${point.index}, '${point.name.replace(/'/g, "\\'")}')">
    <i class="fas fa-check-circle"></i> Select Point
</button>
            </div>
        </div>
    `).join('');
}


function renderDroppingPoints(points) {
    const container = document.getElementById('droppingPointsContainer');

    if (!points || points.length === 0) {
        container.innerHTML = '<div class="alert alert-warning">No dropping points available</div>';
        return;
    }

    container.innerHTML = points.map(point => `
        <div class="dropping-point-item" data-point-index="${point.index}">
            <div class="position-relative p-3">
               <div class="d-flex justify-content-between align-items-start mb-2">
                    <!-- Point Name -->
                    <h5 class="mb-0 text-break" style="max-width: 75%;">${point.location}</h5>
                    
                    <!-- Time Badge -->
                    <span class="pickup-time badge bg-light text-dark ms-2 text-nowrap">
                        🕒 ${formatTime(point.time)}
                    </span>
                </div>
                
                <p><i class="fas fa-map-marker-alt"></i> ${point.location}</p>
                
                <!-- Select Button -->
               <button class="btn btn-outline-success btn-sm mt-3 select-btn" 
    onclick="selectDroppingPoint(${point.index}, '${point.name.replace(/'/g, "\\'")}')">
    <i class="fas fa-check-circle"></i> Select Point
</button>