@extends('frontend.layouts.master')
<style>
.btn-custom {
    background-color: #3a86ff;
    color: white;
    font-weight: 500;
    border: none;
    transition: all 0.3s ease;
    border-radius: 25px;
    padding: 8px 20px;
}

.btn-custom:hover, .btn-custom:focus {
    background-color: #1d57b0;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.btn-custom.active {
    background-color: #1d57b0;
    position: relative;
}

.btn-custom.active::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 30%;
    height: 3px;
    background-color: #1d57b0;
    border-radius: 3px;
}

#welcomeMessage {
    display: none;
    margin-top: 20px;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
}

.tour-card {
    margin-bottom: 30px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
}

.tour-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 20px rgba(0,0,0,0.15);
}

.tour-card .card-img-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.tour-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.tour-card:hover img {
    transform: scale(1.05);
}

.tour-card .card-body {
    padding: 20px;
}

.tour-card .card-title {
    font-weight: 600;
    font-size: 1.2rem;
    margin-bottom: 10px;
    color: #333;
}

.tour-card .card-text {
    color: #666;
    margin-bottom: 15px;
    max-height: 80px;
    overflow: hidden;
}

.tour-card .price {
    color: #1d57b0;
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 15px;
}

.tour-card .card-buttons {
    display: flex;
    justify-content: space-between;
}

.tour-card .btn-cart {
    background-color: #fff;
    color: #3a86ff;
    border: 1px solid #3a86ff;
    transition: all 0.3s ease;
    flex: 1;
    margin-right: 8px;
}

.tour-card .btn-cart:hover {
    background-color: #3a86ff;
    color: white;
}

.tour-card .btn-buy {
    background-color: #3a86ff;
    color: white;
    border: none;
    transition: all 0.3s ease;
    flex: 1;
    margin-left: 8px;
}

.tour-card .btn-buy:hover {
    background-color: #1d57b0;
}

.city-heading {
    text-align: center;
    margin-bottom: 25px;
    color: #1d57b0;
    position: relative;
    padding-bottom: 10px;
    font-weight: bold;
}

.city-heading:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background-color: #3a86ff;
}

.error-message {
    text-align: center;
    padding: 20px;
    background-color: #f8d7da;
    color: #721c24;
    border-radius: 5px;
    margin-top: 20px;
}
</style>

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Cities in {{ $state->destination_name }}</h2>
    <div class="city-selection mb-4">
        <div class="btn-group d-flex flex-wrap justify-content-center" role="group" aria-label="City selection">
            @foreach($cities as $city)
                <button type="button" 
                        class="btn btn-custom m-2 px-4 py-2 rounded-pill shadow-sm"
                        data-city-id="{{ $city->id }}"
                        data-city-name="{{ $city->city_name }}">
                    {{ $city->city_name }}
                </button>
            @endforeach
        </div>
    </div>
    <div id="welcomeMessage"></div>
    <div id="Transfer"></div>
    <div id="accommodation"></div>
    <div id="localTravel"></div>
    <div id="tourGuide"></div>
    <div id="Travels"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cityButtons = document.querySelectorAll('.btn-custom');
    const welcomeMessageDiv = document.getElementById('welcomeMessage');
    const transferDiv = document.getElementById('Transfer');
    const accommodationDiv = document.getElementById('accommodation');
    const localTravelDiv = document.getElementById('localTravel');
    const tourGuideDiv = document.getElementById('tourGuide');
    const travelsDiv = document.getElementById('Travels');
    
    // Function to add item to cart
    function addToCart(itemId, itemType, itemName, itemPrice) {
        console.log(`Added to cart: ${itemName} (ID: ${itemId}, Type: ${itemType}) - Price: ${itemPrice}`);
        alert(`${itemName} has been added to your cart!`);
        
        // Example using localStorage
        let cart = JSON.parse(localStorage.getItem('tourCart')) || [];
        cart.push({
            id: itemId,
            type: itemType,
            name: itemName,
            price: itemPrice,
            quantity: 1
        });
        localStorage.setItem('tourCart', JSON.stringify(cart));
    }
    
    // Function to handle buy now
    function buyNow(itemId, itemType, itemName, itemPrice) {
        console.log(`Buy now: ${itemName} (ID: ${itemId}, Type: ${itemType}) - Price: ${itemPrice}`);
        window.location.href = `/checkout?item_id=${itemId}&item_type=${itemType}`;
    }
    
    // Function to scroll to section
    function scrollToSection(sectionId) {
        const section = document.getElementById(sectionId);
        if (section) {
            section.scrollIntoView({ behavior: 'smooth' });
        }
    }
    
    // Make these functions global so they can be accessed by onclick handlers
    window.addToCart = addToCart;
    window.buyNow = buyNow;
    window.scrollToSection = scrollToSection;
    
    // Function to create card HTML for various items
    function createCardHTML(item, itemType) {
        const formattedPrice = new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR'
        }).format(item.price);
        
        return `
            <div class="col-md-4 mb-4">
                <div class="tour-card">
                    <div class="card-img-container">
                        <img src="${item.photo}" alt="${item.name}" class="card-img-top">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">${item.name}</h5>
                        <p class="card-text">${item.description}</p>
                        <div class="price">${formattedPrice}</div>
                        <div class="card-buttons">
                            <button class="btn btn-cart" 
                                    onclick="addToCart(${item.id}, '${itemType}', '${item.name.replace(/'/g, "\\'")}', ${item.price})">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                            <button class="btn btn-buy"
                                    onclick="buyNow(${item.id}, '${itemType}', '${item.name.replace(/'/g, "\\'")}', ${item.price})">
                                <i class="fas fa-bolt"></i> Buy Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    // NEW: Mock data for transfer options
    function getMockTransferOptions(cityName) {
        return [
            {
                id: 501,
                name: `Flight to ${cityName}`,
                description: "Economy class tickets with complimentary meals and 20kg baggage allowance.",
                price: 7500,
                photo: "/images/transfer/flight.jpg"
            },
            {
                id: 502,
                name: `Bus to ${cityName}`,
                description: "Comfortable AC Volvo bus with reclining seats, USB charging and refreshments.",
                price: 1200,
                photo: "/images/transfer/bus.jpg"
            },
            {
                id: 503,
                name: `Car to ${cityName}`,
                description: "Premium sedan car with experienced driver, flexible timing and route options.",
                price: 4500,
                photo: "/images/transfer/car.jpg"
            },
            {
                id: 504,
                name: `Train to ${cityName}`,
                description: "AC class train tickets with comfortable berths and meal service included.",
                price: 2500,
                photo: "/images/transfer/train.jpg"
            }
        ];
    }
    
    // Mock data for accommodations
    function getMockAccommodations(cityName) {
        return [
            {
                id: 101,
                name: `Luxury Hotel in ${cityName}`,
                description: "5-star amenities with stunning views. Includes breakfast and spa access.",
                price: 12000,
                photo: "/images/accommodations/luxury-hotel.jpg"
            },
            {
                id: 102,
                name: `Budget Homestay in ${cityName}`,
                description: "Comfortable stay with local family. Home-cooked meals included.",
                price: 2500,
                photo: "/images/accommodations/budget-homestay.jpg"
            },
            {
                id: 103,
                name: `${cityName} Resort & Spa`,
                description: "Beachfront property with private pool and excellent dining options.",
                price: 8500,
                photo: "/images/accommodations/resort-spa.jpg"
            }
        ];
    }
    
    // Mock data for local travel
    function getMockLocalTravel(cityName) {
        return [
            {
                id: 201,
                name: `${cityName} Private Cab Service`,
                description: "24-hour private car with driver. Flexible pickup and drop locations.",
                price: 3500,
                photo: "/images/transport/private-cab.jpg"
            },
            {
                id: 202,
                name: "Scooter Rental",
                description: "Explore at your own pace with a convenient scooter rental. Helmets included.",
                price: 800,
                photo: "/images/transport/scooter.jpg"
            },
            {
                id: 203,
                name: `${cityName} Hop-on Hop-off Bus`,
                description: "24-hour pass to the city's main attractions. Audio guide available in 8 languages.",
                price: 1200,
                photo: "/images/transport/hop-on-bus.jpg"
            }
        ];
    }
    
    // Mock data for tour guides
    function getMockTourGuides(cityName) {
        return [
            {
                id: 301,
                name: "Local Expert Guide",
                description: `Full-day guided tour of ${cityName} with a knowledgeable local. Includes pickup from hotel.`,
                price: 4000,
                photo: "/images/guides/local-guide.jpg"
            },
            {
                id: 302,
                name: "Photography Tour Guide",
                description: `Capture the best angles of ${cityName} with a professional photographer guide.`,
                price: 5500,
                photo: "/images/guides/photo-guide.jpg"
            },
            {
                id: 303,
                name: "Historical Tour Guide",
                description: `Learn about the rich history of ${cityName} with our certified historian.`,
                price: 3500,
                photo: "/images/guides/history-guide.jpg"
            }
        ];
    }
    
    // Mock data for travel packages
    function getMockTravelPackages(cityName) {
        return [
            {
                id: 401,
                name: `${cityName} Weekend Getaway`,
                description: "3 days and 2 nights package including hotel, meals, and sightseeing.",
                price: 15000,
                photo: "/images/packages/weekend-getaway.jpg"
            },
            {
                id: 402,
                name: `${cityName} Family Adventure`,
                description: "5-day family package with kid-friendly activities and family suite accommodation.",
                price: 35000,
                photo: "/images/packages/family-adventure.jpg"
            },
            {
                id: 403,
                name: `Romantic ${cityName} Escape`,
                description: "Couple's package with candlelight dinner, spa treatments, and premium stay.",
                price: 25000,
                photo: "/images/packages/romantic-escape.jpg"
            }
        ];
    }
    
    // Function to create navigation buttons (UPDATED)
    function createSectionNavigation() {
        return `
            <div class="section-navigation mb-4">
                <div class="btn-group d-flex flex-wrap justify-content-center" role="group" aria-label="Section navigation">
                    <button type="button" class="btn btn-custom m-2 px-4 py-2 rounded-pill shadow-sm" onclick="scrollToSection('welcomeMessage')">
                        <i class="fas fa-map-marker-alt mr-2"></i> Places
                    </button>
                    <button type="button" class="btn btn-custom m-2 px-4 py-2 rounded-pill shadow-sm" onclick="scrollToSection('Transfer')">
                        <i class="fas fa-shuttle-van mr-2"></i> Transfer
                    </button>
                    <button type="button" class="btn btn-custom m-2 px-4 py-2 rounded-pill shadow-sm" onclick="scrollToSection('accommodation')">
                        <i class="fas fa-hotel mr-2"></i> Accommodation
                    </button>
                    <button type="button" class="btn btn-custom m-2 px-4 py-2 rounded-pill shadow-sm" onclick="scrollToSection('localTravel')">
                        <i class="fas fa-car mr-2"></i> Local Travel
                    </button>
                    <button type="button" class="btn btn-custom m-2 px-4 py-2 rounded-pill shadow-sm" onclick="scrollToSection('tourGuide')">
                        <i class="fas fa-user-tie mr-2"></i> Tour Guides
                    </button>
                    <button type="button" class="btn btn-custom m-2 px-4 py-2 rounded-pill shadow-sm" onclick="scrollToSection('Travels')">
                        <i class="fas fa-suitcase mr-2"></i> Packages
                    </button>
                </div>
            </div>
        `;
    }
    
    // NEW: Function to display transfer options
    function displayTransferOptions(cityName) {
        // Get mock data instead of fetching from API
        const data = getMockTransferOptions(cityName);
        
        let content = `<h3 class="city-heading">Transport to ${cityName}</h3>`;
        
        // Create tabs for different transport types
        content += `
            <div class="transfer-tabs mb-4">
                <ul class="nav nav-tabs justify-content-center" id="transferTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="flight-tab" data-bs-toggle="tab" data-bs-target="#flight" type="button" role="tab" aria-controls="flight" aria-selected="true">
                            <i class="fas fa-plane mr-2"></i> Flight
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="bus-tab" data-bs-toggle="tab" data-bs-target="#bus" type="button" role="tab" aria-controls="bus" aria-selected="false">
                            <i class="fas fa-bus mr-2"></i> Bus
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="car-tab" data-bs-toggle="tab" data-bs-target="#car" type="button" role="tab" aria-controls="car" aria-selected="false">
                            <i class="fas fa-car mr-2"></i> Car
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="train-tab" data-bs-toggle="tab" data-bs-target="#train" type="button" role="tab" aria-controls="train" aria-selected="false">
                            <i class="fas fa-train mr-2"></i> Train
                        </button>
                    </li>
                </ul>
                <div class="tab-content pt-3" id="transferTabsContent">
                    <div class="tab-pane fade show active" id="flight" role="tabpanel" aria-labelledby="flight-tab">
                        <div class="row">
                            ${createCardHTML(data[0], 'transfer')}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="bus" role="tabpanel" aria-labelledby="bus-tab">
                        <div class="row">
                            ${createCardHTML(data[1], 'transfer')}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="car" role="tabpanel" aria-labelledby="car-tab">
                        <div class="row">
                            ${createCardHTML(data[2], 'transfer')}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="train" role="tabpanel" aria-labelledby="train-tab">
                        <div class="row">
                            ${createCardHTML(data[3], 'transfer')}
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Alternative layout: display all cards in a row
        content += '<div class="row">';
        data.forEach(transfer => {
            content += createCardHTML(transfer, 'transfer');
        });
        content += '</div>';
        
        transferDiv.innerHTML = content;
    }
    
    // Function to display accommodation options
    function displayAccommodations(cityName) {
        // Get mock data instead of fetching from API
        const data = getMockAccommodations(cityName);
        
        let content = `<h3 class="city-heading">Accommodation in ${cityName}</h3>`;
        
        content += '<div class="row">';
        data.forEach(accommodation => {
            content += createCardHTML(accommodation, 'accommodation');
        });
        content += '</div>';
        
        accommodationDiv.innerHTML = content;
    }
    
    // Function to display local travel options
    function displayLocalTravel(cityName) {
        // Get mock data instead of fetching from API
        const data = getMockLocalTravel(cityName);
        
        let content = `<h3 class="city-heading">Local Travel Options in ${cityName}</h3>`;
        
        content += '<div class="row">';
        data.forEach(transport => {
            content += createCardHTML(transport, 'localTravel');
        });
        content += '</div>';
        
        localTravelDiv.innerHTML = content;
    }
    
    // Function to display tour guide options
    function displayTourGuides(cityName) {
        // Get mock data instead of fetching from API
        const data = getMockTourGuides(cityName);
        
        let content = `<h3 class="city-heading">Tour Guides in ${cityName}</h3>`;
        
        content += '<div class="row">';
        data.forEach(guide => {
            content += createCardHTML(guide, 'tourGuide');
        });
        content += '</div>';
        
        tourGuideDiv.innerHTML = content;
    }
    
    // Function to display travel package options
    function displayTravelPackages(cityName) {
        // Get mock data instead of fetching from API
        const data = getMockTravelPackages(cityName);
        
        let content = `<h3 class="city-heading">Travel Packages for ${cityName}</h3>`;
        
        content += '<div class="row">';
        data.forEach(package => {
            content += createCardHTML(package, 'travelPackage');
        });
        content += '</div>';
        
        travelsDiv.innerHTML = content;
    }
    
    // Function to fix missing images with placeholder images
    function replaceWithPlaceholder(img) {
        img.onerror = null; // Prevent infinite loop
        img.src = 'https://via.placeholder.com/300x200?text=Image+Not+Found';
    }
    
    // Update the city button click handler to display all sections with mock data
    cityButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            cityButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get city name
            const cityName = this.getAttribute('data-city-name');
            const cityId = this.getAttribute('data-city-id');
            
            // Show loading state
            welcomeMessageDiv.innerHTML = `
                <div class="text-center my-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading tour places for ${cityName}...</p>
                </div>
            `;
            welcomeMessageDiv.style.display = 'block';
            
            // Fetch tour places data
            fetch(`/api/tour-places/${cityId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Tour places data:', data);
                    
                    // Create section navigation buttons
                    let content = createSectionNavigation();
                    
                    // Display city heading
                    content += `<h3 class="city-heading">Discover ${cityName}</h3>`;
                    
                    // Check if data exists and has length
                    if (data && Array.isArray(data) && data.length > 0) {
                        // Display tour cards in a grid
                        content += '<div class="row">';
                        
                        data.forEach(place => {
                            // Format price with INR currency
                            const formattedPrice = new Intl.NumberFormat('en-IN', {
                                style: 'currency',
                                currency: 'INR'
                            }).format(place.price);
                            
                            // Create a card for each tour place
                            content += `
                                <div class="col-md-4 mb-4">
                                    <div class="tour-card">
                                        <div class="card-img-container">
                                     <img src="/tour-image/${place.photo.split('/').pop()}" alt="${place.name}" class="card-img-top">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title">${place.name}</h5>
                                            <p class="card-text">${place.description}</p>
                                            <div class="price">${formattedPrice}</div>
                                            <div class="card-buttons">
                                                <button class="btn btn-cart" 
                                                        onclick="addToCart(${place.id}, 'tourPlace', '${place.name.replace(/'/g, "\\'")}', ${place.price})">
                                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                                </button>
                                                <button class="btn btn-buy"
                                                        onclick="buyNow(${place.id}, 'tourPlace', '${place.name.replace(/'/g, "\\'")}', ${place.price})">
                                                    <i class="fas fa-bolt"></i> Buy Now
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        
                        content += '</div>';
                    } else {
                        // If data is not in the expected format, show error
                        content += `
                            <div class="error-message">
                                <p><strong>Error loading tour places.</strong> Please try again later.</p>
                                <p>Details: No tour places data found for ${cityName}.</p>
                            </div>
                        `;
                    }
                    
                    welcomeMessageDiv.innerHTML = content;
                    
                    // Display all sections with mock data (INCLUDING NEW TRANSFER SECTION)
                    displayTransferOptions(cityName);
                    displayAccommodations(cityName);
                    displayLocalTravel(cityName);
                    displayTourGuides(cityName);
                    displayTravelPackages(cityName);
                    
                    // Add error handling for images
                    setTimeout(() => {
                        document.querySelectorAll('img').forEach(img => {
                            img.onerror = function() { replaceWithPlaceholder(this); };
                        });
                    }, 500);
                })
                .catch(error => {
                    console.error('Error fetching tour places:', error);
                    welcomeMessageDiv.innerHTML = `
                        <div class="error-message">
                            <p><strong>Error loading tour places.</strong> Please try again later.</p>
                            <p>Details: ${error.message}</p>
                        </div>
                    `;
                    
                    // Still display other sections with mock data (INCLUDING NEW TRANSFER SECTION)
                    displayTransferOptions(cityName);
                    displayAccommodations(cityName);
                    displayLocalTravel(cityName);
                    displayTourGuides(cityName);
                    displayTravelPackages(cityName);
                });
        });
    });
});
</script>
@endsection