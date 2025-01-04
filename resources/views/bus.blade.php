@extends('frontend.layouts.master')
@section('title', 'Available Bus')
@section('content')
<div class="container mt-4" id="busResultsContainer">
    <h4 class="text-center mb-4" style="font-size: 2rem; font-weight: bold; color: #2c3e50; text-transform: uppercase; letter-spacing: 1px; padding: 20px; background-color:rgb(196, 198, 218); border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    Buses from 
    <span style="color: #2980b9; font-size: 1.8rem; font-weight: bold;">
        {{ request('source_city') }}
    </span> 
    to 
    <span style="color: #e74c3c; font-size: 1.8rem; font-weight: bold;">
        {{ request('destination_city') }}
    </span>
</h4>
    <p><strong>Departure Date:</strong> {{ request('depart_date') }}</p>

    <!-- Rest of the content (filters and bus listings) -->
</div>
    <div class="row">
        <div class="col-md-3">
            <div class="filter-sidebar p-4 rounded shadow-lg">
                <h4 class="text-center text-primary mb-4">Filter Options</h4>
                <form id="busFilters">
                    <!-- Bus Type Filter -->
                    <div class="mb-3">
                        <label for="busType" class="form-label">Bus Type</label>
                        <select id="busType" class="form-select form-select-lg">
                            <option value="">Select Bus Type</option>
                        </select>
                    </div>

                    <!-- Departure Time Filter -->
                    <!-- <div class="mb-3">
                        <label for="departureTime" class="form-label">Departure Time</label>
                        <input type="datetime-local" id="departureTime" class="form-control form-control-lg">
                    </div> -->

                    <!-- Travel Name Filter -->
                   <div class="mb-3">
                       <label for="travelName" class="form-label">Travel Name</label>
                       <select id="travelName" class="form-select form-select-lg">
                           <option value="">Select Travel Name</option>
                        </select>
                    </div>

                    <!-- Boarding Point Filter -->
                    <div class="mb-3">
                        <label for="boardingPoint" class="form-label">Boarding Point</label>
                        <select id="boardingPoint" class="form-select form-select-lg">
                            <option value="">Select Boarding Point</option>
                        </select>
                    </div>

                    <!-- Dropping Point Filter -->
                    <div class="mb-3">
                        <label for="droppingPoint" class="form-label">Dropping Point</label>
                        <select id="droppingPoint" class="form-select form-select-lg">
                            <option value="">Select Dropping Point</option>
                        </select>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="mb-3">
                        <label for="priceRange" class="form-label">Price</label>
                        <input type="range" class="form-range" id="priceRange" min="0" max="5000" step="100">
                        <span id="priceRangeValue">₹0 - ₹5000</span>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bus Listings -->
        <div class="col-md-9">
            <div id="busListings" class="d-flex flex-wrap justify-content-start">
                <!-- This part will be dynamically populated -->
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
function setSessionData(traceId, resultIndex) {
    sessionStorage.setItem('TraceId', traceId);
    sessionStorage.setItem('ResultIndex', resultIndex);
}

document.addEventListener('DOMContentLoaded', function () {
    const searchData = sessionStorage.getItem('busSearchResults'); 

    if (!searchData) {
        window.location.href = "{{ route('home') }}"; 
        return;
    }

    const data = JSON.parse(searchData); 
    const busResults = data.buses; // Assuming multiple bus results
    const traceId = data.traceId;

    if (!traceId) {
        console.error('TraceId is missing from the response');
        document.getElementById('busListings').innerHTML = '<div class="alert alert-danger">Error: Missing TraceId</div>';
        return;
    }
       // Apply Filters to Bus Data
    function applyFilters() {
        const busType = document.getElementById('busType').value;
        // const departureTime = document.getElementById('departureTime').value;
        const travelName = document.getElementById('travelName').value;
        const boardingPoint = document.getElementById('boardingPoint').value;
        const droppingPoint = document.getElementById('droppingPoint').value;
        const priceRange = document.getElementById('priceRange').value;

        const filteredBuses = busResults.filter(bus => {
            let isValid = true;

            // Filter by Bus Type
            if (busType && bus.BusType !== busType) {
                isValid = false;
            }

            // Filter by Departure Time (if selected)
            // if (departureTime && new Date(bus.DepartureTime) > new Date(departureTime)) {
            //     isValid = false;
            // }

            // Filter by Travel Name
            if (travelName && bus.TravelName !== travelName) {
                isValid = false;
            }

            // Filter by Boarding Point
            if (boardingPoint && !bus.BoardingPoints.some(point => point.CityPointName === boardingPoint)) {
                isValid = false;
            }

            // Filter by Dropping Point
            if (droppingPoint && !bus.DroppingPoints.some(point => point.CityPointName === droppingPoint)) {
                isValid = false;
            }

            // Filter by Price Range
            if (priceRange && (bus.Price.OfferedPrice < 0 || bus.Price.OfferedPrice > priceRange)) {
                isValid = false;
            }

            return isValid;
        });

        // Render filtered buses
        renderBusListings(filteredBuses);
    }

    // Event listeners for filter inputs
    document.getElementById('busType').addEventListener('change', applyFilters);
    // document.getElementById('departureTime').addEventListener('change', applyFilters);
    document.getElementById('travelName').addEventListener('change', applyFilters);
    document.getElementById('boardingPoint').addEventListener('change', applyFilters);
    document.getElementById('droppingPoint').addEventListener('change', applyFilters);
    document.getElementById('priceRange').addEventListener('input', applyFilters);

    // Initial render of bus listings
    renderBusListings(busResults);
      // Function to populate the filter options
      function populateFilters(buses) {
        const busTypes = new Set();
        const boardingPoints = new Set();
        const droppingPoints = new Set();
        const travelNames = new Set();

        buses.forEach(bus => {
            busTypes.add(bus.BusType);
            bus.BoardingPoints.forEach(point => boardingPoints.add(point.CityPointName));
            bus.DroppingPoints.forEach(point => droppingPoints.add(point.CityPointName));
            travelNames.add(bus.TravelName); 
        });

        // Populate Bus Type Dropdown
        const busTypeSelect = document.getElementById('busType');
        busTypes.forEach(type => {
            const option = document.createElement('option');
            option.value = type;
            option.textContent = type;
            busTypeSelect.appendChild(option);
        });

        // Populate Boarding Point Dropdown
        const boardingSelect = document.getElementById('boardingPoint');
        boardingPoints.forEach(point => {
            const option = document.createElement('option');
            option.value = point;
            option.textContent = point;
            boardingSelect.appendChild(option);
        });

        // Populate Dropping Point Dropdown
        const droppingSelect = document.getElementById('droppingPoint');
        droppingPoints.forEach(point => {
            const option = document.createElement('option');
            option.value = point;
            option.textContent = point;
            droppingSelect.appendChild(option);
        });
          // Populate Travel Name Dropdown
    const travelNameSelect = document.getElementById('travelName');
    travelNames.forEach(name => {
        const option = document.createElement('option');
        option.value = name;
        option.textContent = name;
        travelNameSelect.appendChild(option);
    });
    }

    // Update the displayed price range value
    document.getElementById('priceRange').addEventListener('input', function (e) {
        document.getElementById('priceRangeValue').textContent = `₹0 - ₹${e.target.value}`;

    });

    // Populate the filters based on the bus data
    populateFilters(busResults);

    // Function to render bus listings with enhanced card design
    function renderBusListings(buses) {
        let busListingsHTML = '';

        buses.forEach(bus => {
            const price = bus.Price; // Assuming Price is part of each bus objectzz
            busListingsHTML += `
                <div class="card shadow-lg mb-4 w-100 rounded-lg bus-card">
                    <div class="card-body position-relative">
                        <!-- Prices in Top Right Corner -->
                        <div class="position-absolute top-0 end-0 m-3 text-right">
                            <span style="font-size: 1rem; color: #999; text-decoration: line-through;">₹${price.PublishedPrice}</span>
                            <span style="font-size: 1.5rem; font-weight: bold; color:rgb(7, 9, 10);margin-left: 10px;">₹${price.OfferedPrice}</span>
                        </div>
                       <div class="d-flex justify-content-between align-items-center mb-3">
                           <h5 class="card-title text-primary font-weight-bold" style="font-size: 1.5rem;">${bus.TravelName}</h5>
                       </div>
                          <p class="badge badge-pill bus-type-badge" style="background-color: #007bff; color: white; font-size: 1.1rem; padding: 0.5rem 1rem;"> ${bus.BusType}</p>
                         <!-- Icons in Left Corner -->
                           <div style="position: absolute; bottom: 10px; left: 10px; display: flex; gap: 10px; align-items: center;">
                             <i class="fas fa-video" style="font-size: 16px; color: rgba(0, 0, 0, 0.5); cursor: pointer; transition: color 0.3s ease-in-out;" title="CCTV" onmouseover="this.style.color='rgba(0, 0, 0, 0.8)'" onmouseout="this.style.color='rgba(0, 0, 0, 0.5)'"></i> <!-- CCTV Icon -->
                             <i class="fas fa-bolt" style="font-size: 16px; color: rgba(0, 0, 0, 0.5); cursor: pointer; transition: color 0.3s ease-in-out;" title="Charging Point" onmouseover="this.style.color='rgba(0, 0, 0, 0.8)'" onmouseout="this.style.color='rgba(0, 0, 0, 0.5)'"></i> <!-- Charging Point Icon -->
                             <i class="fas fa-ticket-alt" style="font-size: 16px; color: rgba(0, 0, 0, 0.5); cursor: pointer; transition: color 0.3s ease-in-out;" title="M-Ticket" onmouseover="this.style.color='rgba(0, 0, 0, 0.8)'" onmouseout="this.style.color='rgba(0, 0, 0, 0.5)'"></i> <!-- M-Ticket Icon -->
                             <i class="fas fa-map-marker-alt" style="font-size: 16px; color: rgba(0, 0, 0, 0.5); cursor: pointer; transition: color 0.3s ease-in-out;" title="Track" onmouseover="this.style.color='rgba(0, 0, 0, 0.8)'" onmouseout="this.style.color='rgba(0, 0, 0, 0.5)'"></i> <!-- Track Icon -->
                           </div>

                        <div class="d-flex justify-content-between mb-3">
                            <div><strong>🕒 Departure:</strong> ${new Date(bus.DepartureTime).toLocaleString()}</div>
                            <div><strong>🕒 Arrival:</strong> ${new Date(bus.ArrivalTime).toLocaleString()}</div>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <div><strong>Available Seats:</strong> ${bus.AvailableSeats}</div>
                            <div><strong>Max Seats per Ticket:</strong> ${bus.MaxSeatsPerTicket}</div>
                        </div>

                        <!-- Pick-Up & Drop Dropdown -->
                        <div class="d-flex justify-content-start mt-4">
                            <label for="pickupDropDropdown-${bus.ResultIndex}" class="font-weight-bold" 
                                style="cursor: pointer; color: #333; transition: color 0.3s;margin-right: 15px;">
                                🛣️ Pick-Up & Drop
                                <span class="fas fa-chevron-down"></span>
                            </label>
                            <label for="policiesDropdown-${bus.ResultIndex}" class="font-weight-bold" 
                            style="cursor: pointer; color: #333; transition: color 0.3s;">
                            📜 Policies
                            <span class="fas fa-chevron-down"></span>
                            </label>
                            <div id="policiesDropdown-${bus.ResultIndex}" class="policies-details"  
                            style="display: none; padding: 10px; background-color: #f8f9fa; border-radius: 5px; margin-top: 10px; border: 1px solid #ddd;">
                            <div class="row">
                                <!-- Policies Content -->
                            <div class="col-md-12">
                                <div>
                                    ${bus.CancellationPolicies.map(policy => `
                                        <p><strong>Time:</strong> ${policy.PolicyString}</p>
                                        <p><strong>Cancellation Charge:</strong> ₹${policy.CancellationCharge}</p>
                                        <hr>
                                    `).join('')}
                                </div>
                            </div>
                            </div>
                        </div>
                        <div id="pickupDropDropdown-${bus.ResultIndex}" class="pickup-drop-details"  
                            style="display: none; padding: 10px; background-color: #f8f9fa; border-radius: 5px; margin-top: 10px; border: 1px solid #ddd;">
                            <div class="row">
                                <!-- Boarding Points on the left -->
                                <div class="col-md-6">
                                    <div><strong>Boarding Points:</strong></div>
                                    ${bus.BoardingPoints.map(point => `
                                        <p>${point.CityPointName} - ${new Date(point.CityPointTime).toLocaleString()}</p>
                                    `).join('')}
                                </div>
                                <!-- Dropping Points on the right -->
                                <div class="col-md-6">
                                    <div><strong>Dropping Points:</strong></div>
                                    ${bus.DroppingPoints.map(point => `
                                        <p>${point.CityPointName} - ${new Date(point.CityPointTime).toLocaleString()}</p>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Select Seat Button in Bottom Right Corner (Fixed) -->
                    <div class="d-flex justify-content-end mt-3 fixed-seat-btn">
                        <a href="{{ route('bus.seatLayout') }}?TraceId=${traceId}&ResultIndex=${bus.ResultIndex}" 
                            class="btn btn-primary btn-block py-2 rounded" 
                            onclick="setSessionData('${traceId}', '${bus.ResultIndex}')">
                            Select Seats
                        </a>
                    </div>
                </div>
            </div>
        `;});

        document.getElementById('busListings').innerHTML = busListingsHTML;
    }

    renderBusListings(busResults);


    document.addEventListener('click', function (e) {
    // Check if the clicked element is related to a dropdown (either Pick-Up/Drop or Policies)
    if (e.target && (e.target.matches('label[for^="pickupDropDropdown-"]') || e.target.matches('label[for^="policiesDropdown-"]') || e.target.matches('span.fas.fa-chevron-down'))) {
        
        const dropdownId = e.target.closest('label').getAttribute('for');
        const dropdown = document.getElementById(dropdownId);

        // Toggle the display of the dropdown (show or hide)
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';

        // Add highlight effect when clicked (like a link)
        const label = e.target.closest('label');
        label.classList.toggle('highlight');
    }
});


});
</script>
</script>
@endsection
@section('styles')
<style>
/* Global Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html, body {
    width: 100%;
    overflow-x: hidden; /* Prevent horizontal scrolling */
}

/* Container Padding */
.container {
    padding-left: 15px;
    padding-right: 15px;
    margin-left: auto;
    margin-right: auto;
}

/* Add a light blue border around each card */
.bus-card {
    border: 2px solid transparent;
    transition: border-color 0.3s, background-color 0.3s, transform 0.3s ease-in-out;
}

.bus-card:hover {
    border-color: #00bfff; /* Light blue border on hover */
    background-color: #e0f7fa; /* Light blue background color on hover */
    transform: scale(1.05); /* Zoom in slightly on hover */
}

.bus-card:hover .card-title {
    color: #007bff; /* Change card title color on hover */
}

.card-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #0056b3;
}

.card-body {
    padding: 1.5rem;
}

/* Enhanced styling for labels and inputs */
label {
    font-size: 1.1rem;
    font-weight: 500;
    color: #333;
    margin-bottom: 0.5rem;
    display: block; /* Ensure proper alignment with inputs */
}

input, select {
    font-size: 1rem;
    padding: 0.75rem;
    border-radius: 8px;
    border: 1px solid #ced4da;
    width: 100%; /* Ensure inputs and selects align properly */
    margin-bottom: 15px;
}

input[type="number"], input[type="time"] {
    background-color: #f8f9fa;
}

button {
    background-color: #007bff;
    color: white;
    font-size: 1.1rem;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

.highlight {
    color: #007bff;
    font-weight: 600;
}

/* Add attractive styling for filter sidebar */
.filter-sidebar {
    background-color: #f0f8ff;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px; /* Add spacing below the sidebar */
}

.filter-sidebar h4 {
    font-size: 1.5rem;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 15px;
}

select, input[type="datetime-local"], input[type="text"], input[type="range"] {
    font-size: 1rem;
    padding: 0.75rem;
    border-radius: 8px;
    border: 1px solid #ced4da;
    background-color: #fff;
    margin-bottom: 15px;
}

input[type="range"] {
    width: 100%;
}

select:focus, input[type="datetime-local"]:focus, input[type="text"]:focus {
    outline: none;
    border-color: #00bfff;
    box-shadow: 0 0 5px rgba(0, 191, 255, 0.5);
}

.form-label {
    font-weight: 500;
    color: #333;
}

.form-select-lg, .form-control-lg {
    padding: 1rem;
    font-size: 1.1rem;
}

#priceRangeValue {
    font-size: 1rem;
    color: #333;
    font-weight: 600;
}

/* Badge Styling */
.badge {
    max-width: 100%; /* Ensures the badge stays within the parent container */
    white-space: nowrap; /* Prevents text from wrapping to a new line */
    overflow: hidden; /* Hides overflowed text */
    text-overflow: ellipsis; /* Adds ellipsis to overflowed text */
    display: inline-block;
    vertical-align: middle;
}

/* Fixing Margin and Alignment */
.row {
    margin-right: 0;
    margin-left: 0;
}

.col-md-6 {
    padding-right: 15px;
    padding-left: 15px;
}

.card {
    margin-bottom: 20px; /* Space between cards */
}

#busListings {
    margin-top: 20px;
}

.fixed-seat-btn {
    padding-right: 10px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .bus-card {
        margin-bottom: 15px;
    }

    .filter-sidebar {
        margin-bottom: 15px;
    }
}

</style>
@endsection
