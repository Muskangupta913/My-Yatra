<!-- Original row structure but with modified classes -->
<div class="row">
    <!-- Filter sidebar with visibility classes -->
    <div class="col-md-3 filter-container">
        <div class="filter-sidebar p-4 rounded shadow-lg" id="filterSidebar">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="text-primary m-0">Filter Options</h4>
                <button id="closeFilterBtn" class="btn btn-sm btn-outline-secondary d-md-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="busFilters">
                <!-- Bus Type Filter -->
                <div class="mb-3">
                    <label for="busType" class="form-label">Bus Type</label>
                    <select id="busType" class="form-select form-select-lg">
                        <option value="">Select Bus Type</option>
                    </select>
                </div>

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

    <!-- Bus Listings with filter toggle button -->
    <div class="col-md-9">
        <button id="filterToggleBtn" class="btn btn-primary d-md-none mb-3">
            <i class="fas fa-filter"></i> Filters
        </button>
        <div id="busListings" class="d-flex flex-wrap justify-content-start">
            <!-- This part will be dynamically populated -->
        </div>
    </div>
</div>

<!-- Add this CSS to your stylesheet -->
<style>
    @media (max-width: 767.98px) {
        .filter-container {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            height: 100%;
            z-index: 1050;
            transition: left 0.3s ease;
            background-color: rgba(255, 255, 255, 0);
        }
        
        .filter-container.show {
            left: 0;
            background-color: rgba(0, 0, 0, 0.2);
            width: 100%;
        }
        
        .filter-sidebar {
            height: 100%;
            overflow-y: auto;
            width: 80%;
            background-color: white;
        }
    }
</style>

<!-- Add this JavaScript for the toggle functionality -->
<script>
    // Wait for the DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        const filterToggleBtn = document.getElementById('filterToggleBtn');
        const closeFilterBtn = document.getElementById('closeFilterBtn');
        const filterContainer = document.querySelector('.filter-container');
        
        // Show filter sidebar when toggle button is clicked
        if (filterToggleBtn) {
            filterToggleBtn.addEventListener('click', function() {
                filterContainer.classList.add('show');
            });
        }
        
        // Hide filter sidebar when close button is clicked
        if (closeFilterBtn) {
            closeFilterBtn.addEventListener('click', function() {
                filterContainer.classList.remove('show');
            });
        }
        
        // Close sidebar when clicking outside of it
        if (filterContainer) {
            filterContainer.addEventListener('click', function(event) {
                // Only close if clicking the overlay, not the sidebar itself
                if (event.target === filterContainer) {
                    filterContainer.classList.remove('show');
                }
            });
        }
        
        // Handle window resize to reset mobile state if screen size changes
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768 && filterContainer) {
                filterContainer.classList.remove('show');
            }
        });
    });
</script>