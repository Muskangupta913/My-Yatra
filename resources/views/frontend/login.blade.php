// Initial activeFilters declaration
let activeFilters = {
    priceRange: null,  // Changed back to null initially
    starRating: [],
    propertyType: [],
    amenities: [],
    sortBy: 'price-low'
};

function initializeFilters() {
    // Initialize price range
    const prices = allHotels.map(hotel => hotel.Price?.PublishedPrice || 0);
    const maxPrice = Math.max(...prices);
    const priceRange = document.getElementById('priceRange');
    priceRange.max = maxPrice;
    priceRange.value = maxPrice;
    activeFilters.priceRange = maxPrice;  // Set initial value to maxPrice
    document.getElementById('maxPrice').textContent = `₹${maxPrice.toLocaleString()}`;

    // Add event listener for price range
    priceRange.addEventListener('input', function() {
        const value = parseInt(this.value);
        document.getElementById('maxPrice').textContent = `₹${value.toLocaleString()}`;
        activeFilters.priceRange = value;
        applyFilters();
    });

    // Rest of your initialization code remains the same...
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

function clearAllFilters() {
    const priceRange = document.getElementById('priceRange');
    const maxPrice = parseInt(priceRange.max);
    
    activeFilters = {
        priceRange: maxPrice,  // Set to max price
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