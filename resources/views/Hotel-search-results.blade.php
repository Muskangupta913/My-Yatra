@extends('frontend.layouts.master')
@section('title', 'Hotel search')
@section('content')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Search Results</title>
    @section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
* { 
    margin: 0; 
    padding: 0; 
    box-sizing: border-box; 
    font-family: system-ui, -apple-system, sans-serif; 
}

body { 
    background: #f5f5f5; 
}

/* Main Layout Styles */
.main-container {
    max-width: 1800px;
    margin: 20px auto;
    padding: 0 20px;
    display: flex;
    gap: 20px;
    position: relative;
}

/* Filter Sidebar Styles */
#filterSidebar {
    width: 350px;
    min-width: 320px;
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: sticky;
    top: 30px;
    height: calc(100vh - 40px);
    overflow-y: auto;
    align-self: flex-start;
}

/* Filter Sections */
.filter-section {
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid #eee;
}

.filter-section h4 {
    margin-bottom: 12px;
    color: #333;
    font-size: 16px;
}

/* Filter Groups */
.filter-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 200px;
    overflow-y: auto;
    padding-right: 10px;
}

/* Checkbox Styles */
.amenity-checkbox {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #555;
    cursor: pointer;
}

/* Active Filters */
.active-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 25px;
}

.filter-badge {
    background: #e8f0fe;
    color: #1a73e8;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 4px;
}

.filter-clear-btn {
    background: none;
    border: none;
    color: #1a73e8;
    cursor: pointer;
    padding: 0 4px;
}

/* Hotel Grid and Cards */
#hotelGrid {
    display: flex;
    flex-direction: column;
    gap: 20px;
    width: 100%;
}

.hotel-card {
    display: flex;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
    width: 100%;
}

.hotel-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.hotel-image-container {
    flex: 0 0 300px;
    position: relative;
    height: 200px;
}

.hotel-info-container {
    flex: 1;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-width: 0;
}

/* Price Range Slider */
.price-slider {
    width: 100%;
    margin: 10px 0;
}

/* Scrollbar Styles */
#filterSidebar::-webkit-scrollbar {
    width: 6px;
}

#filterSidebar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

#filterSidebar::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}

#filterSidebar::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Search Header Styles */
.search-header {
    position: sticky;
    top: 0;
    z-index: 100;
    background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    padding: 15px 20px;
    color: white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.search-info-item {
    display: flex;
    align-items: center;
    gap: 15px;
}

.search-info-icon {
    font-size: 24px;
    color: #ecf0f1;
}

.search-info-text {
    display: flex;
    flex-direction: column;
}

.search-info-label {
    font-size: 12px;
    color: #bdc3c7;
    margin-bottom: 3px;
}

.search-info-value {
    font-size: 16px;
    font-weight: 600;
}

/* Responsive Design */
/* Desktop and Large Laptop (1440px and above) */
@media (min-width: 1440px) {
    .main-container {
        padding: 0 40px;
        gap: 30px;
    }

    .hotel-card {
        min-height: 280px;
    }

    .hotel-image-container {
        flex: 0 0 350px;
        height: 280px;
    }

    .hotel-info-container {
        padding: 25px;
    }

    .hotel-info-container h3 {
        font-size: 1.75rem;
    }

    .hotel-info-container p {
        font-size: 1rem;
    }

    .filter-section h4 {
        font-size: 1.125rem;
    }
}

/* Regular Laptop and Small Desktop (1024px to 1439px) */
@media (min-width: 1024px) and (max-width: 1439px) {
    .main-container {
        padding: 0 30px;
    }

    .hotel-card {
        min-height: 250px;
    }

    .hotel-image-container {
        flex: 0 0 300px;
        height: 250px;
    }
}

/* Tablet Landscape (900px to 1023px) */
@media (min-width: 900px) and (max-width: 1023px) {
    .main-container {
        padding: 0 25px;
    }

    #filterSidebar {
        width: 280px;
        min-width: 280px;
    }

    .hotel-card {
        min-height: 220px;
    }

    .hotel-image-container {
        flex: 0 0 250px;
        height: 220px;
    }
}

/* Mobile Styles */
@media (max-width: 768px) {
    .main-container {
        flex-direction: column;
    }

    #filterSidebar {
        width: 100%;
        min-width: auto;
        position: fixed;
        top: 0;
        left: -100%;
        height: 100vh;
        z-index: 1000;
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }

    #filterSidebar.active {
        left: 0;
        transform: translateX(0);
    }

    .hotel-card {
        flex-direction: column;
    }

    .hotel-image-container {
        flex: 0 0 200px;
        width: 100%;
        height: 200px;
    }

    .search-header {
        flex-direction: column;
        align-items: flex-start;
        padding: 10px;
        gap: 15px;
    }

    #mobileFilterBtn {
        display: block;
    }
    
    .hotel-info-container {
        padding: 15px;
    }
    
    .hotel-info-container h3 {
        font-size: 1.2rem;
    }
}

/* Mobile Filter Button */
#mobileFilterBtn {
    display: none;
    position: fixed;
    bottom: 20px;
    right: 20px;
    padding: 12px 24px;
    background: #1a73e8;
    color: white;
    border: none;
    border-radius: 25px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    z-index: 1000;
}

/* Hotel Card Image */
.hotel-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Hotel Status Badges */
.hotel-status {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0,0,0,0.7);
    color: #ffd700;
    padding: 5px 10px;
    border-radius: 4px;
}

.hotel-category {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
}

/* Results Count Section */
#resultsCount {
    background: white;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

/* Sort Select Styles */
#sortSelect {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    color: #333;
}
</style>
 @endsection
    <div class="search-header">
        <div class="search-info-item">
            <i class="fas fa-map-marker-alt search-info-icon"></i>
            <div class="search-info-text">
                <span class="search-info-label">Destination</span>
                <span class="search-info-value">{{ request()->input('city') }}</span>
            </div>
        </div>

        <div class="search-info-item">
            <i class="fas fa-calendar-alt search-info-icon"></i>
            <div class="search-info-text">
                <span class="search-info-label">Check-in-Date</span>
                <span class="search-info-value">{{ request()->input('checkIn') }}</span>
            </div>
        </div>

        <div class="search-info-item">
            <i class="fas fa-users search-info-icon"></i>
            <div class="search-info-text">
                <span class="search-info-label">Guests</span>
                <span class="search-info-value">{{ request()->input('adults') }} Adults, {{ request()->input('children') }} Children</span>
            </div>
        </div>
        
        <div class="search-info-item">
            <i class="fas fa-bed search-info-icon"></i>
            <div class="search-info-text">
                <span class="search-info-label">Rooms</span>
                <span class="search-info-value">{{ request()->input('rooms') }}</span>
            </div>
        </div>
    </div>

    <div class="main-container">
        <!-- Enhanced Filters Sidebar -->
        <aside id="filterSidebar">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-size: 18px; color: #333;">Filters</h3>
                <button onclick="clearAllFilters()" style="color: #1a73e8; border: none; background: none; cursor: pointer; font-size: 14px;">
                    Clear All
                </button>
            </div>

            <!-- Active Filters -->
            <div id="activeFilters" class="active-filters"></div>

            <!-- Price Range Filter -->
            <div class="filter-section">
                <h4>Price Range</h4>
                <input type="range" id="priceRange" class="price-slider" min="0" max="50000" step="100">
                <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 14px; color: #666;">
                    <span id="minPrice">₹0</span>
                    <span id="maxPrice">₹50,000</span>
                </div>
            </div>

            <!-- Star Rating Filter -->
            <div class="filter-section">
                <h4>Star Rating</h4>
                <div id="starRatingFilters" class="filter-group"></div>
            </div>

            <!-- Hotel Type Filter -->
            <div class="filter-section">
                <h4>Property Type</h4>
                <div id="propertyTypeFilters" class="filter-group"></div>
            </div>

            <!-- Amenities Filter -->
            <div class="filter-section">
                <h4>Amenities</h4>
                <div id="amenitiesFilters" class="filter-group"></div>
            </div>

            <!-- Sort Options -->
            <div class="filter-section">
                <h4>Sort By</h4>
                <select id="sortSelect">
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                    <option value="rating-high">Rating: High to Low</option>
                    <option value="name-asc">Hotel Name: A to Z</option>
                </select>
            </div>
        </aside>

        <!-- Results Section -->
        <main style="flex-grow: 1;">
            <div id="resultsCount">
                Loading results...
            </div>
            
            <div id="hotelGrid">
                <!-- Hotels will be inserted here -->
            </div>
        </main>
    </div>

    <!-- Mobile Filter Button -->
    <button id="mobileFilterBtn">
        <i class="fas fa-filter"></i> Filters
    </button>
    @endsection
    @section('scripts')
    <script>
            let allHotels = [];
            let filteredHotels = [];
        let activeFilters = {
            priceRange: null,
            starRating: [],
            propertyType: [],
            amenities: [],
            sortBy: 'price-low'
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Get hotels from sessionStorage
            allHotels = JSON.parse(sessionStorage.getItem('searchResults')) || [];
            filteredHotels = [...allHotels];
            
            initializeFilters();
            setupMobileResponsiveness();
            updateResultsCount();
            renderHotels(filteredHotels);
            setupEventListeners();
        });

        function initializeFilters() {
            // Initialize price range
            const prices = allHotels.map(hotel => hotel.Price?.PublishedPrice || 0);
            const maxPrice = Math.max(...prices);
            const priceRange = document.getElementById('priceRange');
            priceRange.max = maxPrice;
            priceRange.value = maxPrice;
            activeFilters.priceRange = maxPrice;
            document.getElementById('maxPrice').textContent = `₹${maxPrice.toLocaleString()}`;

            // Add event listener for price range
            priceRange.addEventListener('input', function() {
                const value = parseInt(this.value);
                document.getElementById('maxPrice').textContent = `₹${value.toLocaleString()}`;
                activeFilters.priceRange = value;
                applyFilters();
            });

            // Initialize star ratings
            const starRatings = [...new Set(allHotels.map(hotel => Math.floor(parseFloat(hotel.StarRating) || 0)))].sort((a, b) => b - a);
            const starRatingContainer = document.getElementById('starRatingFilters');
            starRatingContainer.innerHTML = starRatings.map(rating => `
                <label class="amenity-checkbox">
                    <input type="checkbox" class="star-filter" value="${rating}">
                    ${rating} ${rating === 1 ? 'Star' : 'Stars'} 
                    ${Array(rating).fill('<i class="fas fa-star" style="color: #ffd700;"></i>').join('')}
                </label>
            `).join('');
            
            // Add event listeners to star rating checkboxes
            document.querySelectorAll('.star-filter').forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    activeFilters.starRating = Array.from(document.querySelectorAll('.star-filter:checked')).map(cb => parseInt(cb.value));
                    applyFilters();
                });
            });

            // Initialize property types
            const propertyTypes = [...new Set(allHotels.map(hotel => hotel.HotelCategory))];
            const propertyTypeContainer = document.getElementById('propertyTypeFilters');
            propertyTypeContainer.innerHTML = propertyTypes.map(type => `
                <label class="amenity-checkbox">
                    <input type="checkbox" class="property-type-filter" value="${type}">
                    ${type}
                </label>
            `).join('');
             // Add event listeners to property type checkboxes
            document.querySelectorAll('.property-type-filter').forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    activeFilters.propertyType = Array.from(document.querySelectorAll('.property-type-filter:checked')).map(cb => cb.value);
                    applyFilters();
                });
            });

            // Initialize amenities
            const amenities = [...new Set(allHotels.flatMap(hotel => 
                hotel.Facilities.flatMap(f => f.FacilitiesNames)
            ))];
            const amenitiesContainer = document.getElementById('amenitiesFilters');
            amenitiesContainer.innerHTML = amenities.map(amenity => `
                <label class="amenity-checkbox">
                    <input type="checkbox" class="amenity-filter" value="${amenity}">
                    ${amenity}
                </label>
            `).join('');
             // Add event listeners to amenity checkboxes
            document.querySelectorAll('.amenity-filter').forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    activeFilters.amenities = Array.from(document.querySelectorAll('.amenity-filter:checked')).map(cb => cb.value);
                    applyFilters();
                });
            });
            // Add event listener for sort select
            document.getElementById('sortSelect').addEventListener('change', function() {
                activeFilters.sortBy = this.value;
                applyFilters();
            });
        }

        function updateActiveFilters() {
            const container = document.getElementById('activeFilters');
            let filterBadges = [];

            if (activeFilters.priceRange) {
                filterBadges.push(`
                    <div class="filter-badge">
                        Up to ₹${activeFilters.priceRange.toLocaleString()}
                        <button class="filter-clear-btn" onclick="clearFilter('priceRange')">×</button>
                    </div>
                `);
            }

            activeFilters.starRating.forEach(rating => {
                filterBadges.push(`
                    <div class="filter-badge">
                        ${rating} Star
                        <button class="filter-clear-btn" onclick="clearFilter('starRating', '${rating}')">×</button>
                    </div>
                `);
            });

            activeFilters.propertyType.forEach(type => {
                filterBadges.push(`
                    <div class="filter-badge">
                        ${type}
                        <button class="filter-clear-btn" onclick="clearFilter('propertyType', '${type}')">×</button>
                    </div>
                `);
            });

            activeFilters.amenities.forEach(amenity => {
                filterBadges.push(`
                    <div class="filter-badge">
                        ${amenity}
                        <button class="filter-clear-btn" onclick="clearFilter('amenities', '${amenity}')">×</button>
                    </div>
                `);
            });

            container.innerHTML = filterBadges.join('');
        }

        function clearFilter(filterType, value) {
            if (filterType === 'priceRange') {
                const priceRange = document.getElementById('priceRange');
                const maxPrice = parseInt(priceRange.max);
                activeFilters.priceRange = maxPrice;
                priceRange.value = maxPrice;
                document.getElementById('maxPrice').textContent = `₹${maxPrice.toLocaleString()}`;
            } else if (value) {
                activeFilters[filterType] = activeFilters[filterType].filter(v => v !== value);
                document.querySelector(`input[value="${value}"]`).checked = false;
            }
            applyFilters();
        }

        function clearAllFilters() {
            const priceRange = document.getElementById('priceRange');
            const maxPrice = parseInt(priceRange.max);
            activeFilters = {
                priceRange: maxPrice,
                starRating: [],
                propertyType: [],
                amenities: [],
                sortBy: 'price-low'
            };
            
            // Reset UI elements
            priceRange.value = maxPrice;
            document.getElementById('maxPrice').textContent = `₹${maxPrice.toLocaleString()}`;
            document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            document.getElementById('sortSelect').value = 'price-low';
            
            applyFilters();
        }
        function applyFilters() {
            // Apply filters
            filteredHotels = allHotels.filter(hotel => {
                const price = hotel.Price?.PublishedPrice || 0;
                const stars = Math.floor(parseFloat(hotel.StarRating) || 0);
                const type = hotel.HotelCategory;
                const hotelAmenities = hotel.Facilities.flatMap(f => f.FacilitiesNames);

                // Price filter condition
                const priceInRange = activeFilters.priceRange === null || price <= activeFilters.priceRange;
                
                // Other filter conditions
                const starMatch = activeFilters.starRating.length === 0 || activeFilters.starRating.includes(stars);
                const typeMatch = activeFilters.propertyType.length === 0 || activeFilters.propertyType.includes(type);
                const amenitiesMatch = activeFilters.amenities.length === 0 || 
                                    activeFilters.amenities.every(a => hotelAmenities.includes(a));

                // Return true only if all conditions are met
                return priceInRange && starMatch && typeMatch && amenitiesMatch;
            });

            // Apply sorting
            switch(activeFilters.sortBy) {
                case 'price-low':
                    filteredHotels.sort((a, b) => (a.Price?.PublishedPrice || 0) - (b.Price?.PublishedPrice || 0));
                    break;
                case 'price-high':
                    filteredHotels.sort((a, b) => (b.Price?.PublishedPrice || 0) - (a.Price?.PublishedPrice || 0));
                    break;
                case 'rating-high':
                    filteredHotels.sort((a, b) => (parseFloat(b.StarRating) || 0) - (parseFloat(a.StarRating) || 0));
                    break;
                case 'name-asc':
                    filteredHotels.sort((a, b) => a.HotelName.localeCompare(b.HotelName));
                    break;
            }

            updateActiveFilters();
            updateResultsCount();
            renderHotels(filteredHotels);
        }
        
        function setupMobileResponsiveness() {
            const sidebar = document.getElementById('filterSidebar');
            const mobileBtn = document.getElementById('mobileFilterBtn');
            const mainContent = document.querySelector('main');
            const mediaQuery = window.matchMedia('(max-width: 768px)');

            function handleScreenChange(e) {
                if (e.matches) { // Mobile view
                    sidebar.style.position = 'fixed';
                    sidebar.style.left = '-100%';
                    sidebar.style.top = '0';
                    sidebar.style.height = '100vh';
                    sidebar.style.zIndex = '1000';
                    sidebar.style.transition = '0.3s';
                    sidebar.style.transform = 'translateX(-100%)';
                    mobileBtn.style.display = 'block';
                } else { // Desktop view
                    // Reset all mobile-specific styles
                    sidebar.style.position = 'sticky';
                    sidebar.style.left = '';
                    sidebar.style.transform = '';
                    sidebar.style.height = 'calc(100vh - 40px)';
                    sidebar.style.zIndex = '';
                    mobileBtn.style.display = 'none';
                }
                
                // Update grid layout based on screen size
                const grid = document.getElementById('hotelGrid');
                grid.style.display = 'flex';
                grid.style.flexDirection = 'column';
            }

            // Initial setup
            handleScreenChange(mediaQuery);

            // Add listener for screen size changes
            mediaQuery.addEventListener('change', handleScreenChange);

            // Toggle sidebar for mobile
            let isOpen = false;
            mobileBtn.addEventListener('click', () => {
                isOpen = !isOpen;
                if (isOpen) {
                    sidebar.style.transform = 'translateX(0)';
                    sidebar.style.left = '0';
                    // Add overlay
                    const overlay = document.createElement('div');
                    overlay.id = 'sidebarOverlay';
                    overlay.style.position = 'fixed';
                    overlay.style.top = '0';
                    overlay.style.left = '0';
                    overlay.style.right = '0';
                    overlay.style.bottom = '0';
                    overlay.style.backgroundColor = 'rgba(0,0,0,0.5)';
                    overlay.style.zIndex = '999';
                    document.body.appendChild(overlay);
                    
                    // Close sidebar when clicking overlay
                    overlay.addEventListener('click', () => {
                        isOpen = false;
                        sidebar.style.transform = 'translateX(-100%)';
                        sidebar.style.left = '-100%';
                        overlay.remove();
                    });
                } else {
                    sidebar.style.transform = 'translateX(-100%)';
                    sidebar.style.left = '-100%';
                    const overlay = document.getElementById('sidebarOverlay');
                    if (overlay) overlay.remove();
                }
            });
        }

        function setupEventListeners() {
            // Set initial grid layout
            const grid = document.getElementById('hotelGrid');
            grid.style.display = 'flex';
            grid.style.flexDirection = 'column';
            
            // Other event listeners can be added here
            window.addEventListener('resize', () => {
                const grid = document.getElementById('hotelGrid');
                grid.style.display = 'flex';
                grid.style.flexDirection = 'column';
            });
        }

        function updateResultsCount() {
            const count = filteredHotels.length;
            document.getElementById('resultsCount').innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span><strong>${count}</strong> hotels found</span>
                    <span style="color: #666;">Showing all results</span>
                </div>
            `;
        }

        function renderHotels(hotels) {
            const grid = document.getElementById('hotelGrid');
            
            if (hotels.length === 0) {
                grid.innerHTML = `
                    <div style="text-align: center; padding: 40px; background: white; border-radius: 8px;">
                        <i class="fas fa-search" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i>
                        <p>No hotels found matching your criteria</p>
                    </div>
                `;
                return;
            }
    // Store scroll position
    const scrollPosition = window.pageYOffset;

    grid.innerHTML = hotels.map(hotel => `
        <div class="hotel-card" 
             onclick="viewHotelDetails('${hotel.ResultIndex}', '${hotel.HotelCode}')">
            <div class="hotel-image-container">
                <img src="${hotel.HotelPicture || '/api/placeholder/400/200'}" 
                     alt="${hotel.HotelName}"
                     style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.7); color: #ffd700; padding: 5px 10px; border-radius: 4px;">
                    <i class="fas fa-star"></i> ${hotel.StarRating}
                </div>
                <div style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.7); color: white; padding: 5px 10px; border-radius: 4px;">
                    ${hotel.HotelCategory}
                </div>
            </div>
            <div class="hotel-info-container">
                <div>
                    <h3 style="margin-bottom: 10px; color: #333; font-size: 1.5rem;">${hotel.HotelName}</h3>
                    <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                        <p style="color: #666; font-size: 14px;">
                            <i class="fas fa-map-marker-alt" style="color: #1a73e8;"></i> 
                            ${hotel.HotelAddress}, ${hotel.City}, ${hotel.State} ${hotel.PinCode}
                        </p>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <p style="font-size: 14px; color: #444;">
                            <i class="fas fa-bed" style="color: #1a73e8;"></i> 
                            ${hotel.Rooms.map(room => room.Cateogry).join(', ')}
                        </p>
                        <p style="font-size: 14px; color: #444;">
                            <i class="fas fa-concierge-bell" style="color: #1a73e8;"></i> 
                            ${hotel.Facilities.map(facility => facility.FacilitiesNames.join(', '))}
                        </p>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                    <div>
                        <span style="font-size: 22px; font-weight: bold; color: #1a73e8;">
                            ₹${(hotel.Price?.PublishedPrice || 0).toLocaleString()}
                        </span>
                        <span style="font-size: 12px; color: #666;"> /night</span>
                        ${hotel.Price?.Discount ? `
                            <div style="font-size: 12px; color: #4CAF50;">
                                <i class="fas fa-tag"></i> Discount: ₹${hotel.Price.Discount}
                            </div>
                        ` : ''}
                    </div>
                    <button style="padding: 8px 16px; background: #1a73e8; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        View Details
                    </button>
                </div>
            </div>
        </div>
    `).join('');

    // Restore scroll position
    window.scrollTo(0, scrollPosition);
}

function viewHotelDetails(resultIndex, hotelCode) {
            const traceId = sessionStorage.getItem('traceId');
            if (!traceId) {
                console.error('TraceId not found');
                return;
            }
            sessionStorage.setItem('selectedHotelResultIndex', resultIndex);
            sessionStorage.setItem('selectedHotelTraceId', traceId);
            sessionStorage.setItem('selectedHotelCode', hotelCode);
            window.location.href = `/hotel-info?traceId=${traceId}&resultIndex=${resultIndex}&hotelCode=${hotelCode}`;
        }

        // Handle window resize
        window.addEventListener('resize', () => {
            const grid = document.getElementById('hotelGrid');
            grid.style.gridTemplateColumns = window.innerWidth > 1200 ? 'repeat(3, 1fr)' : window.innerWidth > 768 ? 'repeat(2, 1fr)' : '1fr';
        });
    </script>
        @endsection
