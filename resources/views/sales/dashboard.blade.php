@include('sales.layouts.header')
@include('sales.layouts.sidebar')
@include('sales.layouts.navbar')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.20/jspdf.plugin.autotable.min.js"></script>


<div class="container-fluid" style="margin-top: 6%;">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('sales.booking') }}" style="text-decoration: none;">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Today Bookings
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            {{ $bookingCount }} <!-- Total bookings -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('sales.package') }}" style="text-decoration: none;">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Packages</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $packageCount }}

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('sales.destination') }}" style="text-decoration: none;">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Destinations</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $destinationCount }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-globe fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!--  Card DetailsExample -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ route('sales.cardDetails') }}" style="text-decoration: none;">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total card details</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $cardDetailsCount }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-comments fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Main Container -->
    <div style="display: flex; justify-content: space-between; padding: 20px; flex-wrap: wrap;">

        <!-- Left: Package Details -->
        <div
            style="width: 55%; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); padding: 20px; margin-bottom: 20px;">
            <h2 style="font-size: 24px; color: #007BFF; margin-bottom: 15px;">Generated Package Details</h2>

            <div id="packageDetails" style="font-size: 16px;">
                <!-- Package details will be displayed here -->
            </div>
            <button onclick="downloadPDF()" class="btn btn-primary" style="padding: 8px 16px;">
                <i class="fas fa-download"></i> Download PDF
            </button>
        </div>

        <!-- Right: Filters -->
        <div
            style="width: 40%; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); padding: 20px; margin-bottom: 20px;">
            <h2 style="font-size: 24px; color: #007BFF; margin-bottom: 15px;">Client Search Filters</h2>

            <!-- Budget Input -->
            <label for="budgetInput" style="font-size: 16px; margin-bottom: 8px; display: block;">Enter Client Budget
                (in INR):</label>
            <input type="number" id="budgetInput" placeholder="Enter budget..."
                style="width: 100%; padding: 10px; margin-bottom: 15px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;" />

            <!-- Travel State and City -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <label for="travelStateSelect" style="font-size: 16px; margin-bottom: 8px; display: block;">Travel
                        State:</label>
                    <select id="travelStateSelect" onchange="updateTravelCities()"
                        style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;">
                        <option value="">-- Select State --</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->destination_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="flex: 1;">
                    <label for="travelCitySelect" style="font-size: 16px; margin-bottom: 8px; display: block;">Travel
                        City:</label>
                    <select id="travelCitySelect"
                        style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;">
                        <option value="">-- Select City --</option>
                    </select>
                </div>
            </div>

            <!-- Destination State and City -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <label for="destStateSelect"
                        style="font-size: 16px; margin-bottom: 8px; display: block;">Destination State:</label>
                    <select id="destStateSelect" onchange="updateDestinationCities()"
                        style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;">
                        <option value="">-- Select State --</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}">{{ $state->destination_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="flex: 1;">
                    <label for="destCitySelect" style="font-size: 16px; margin-bottom: 8px; display: block;">Destination
                        City:</label>
                    <select id="destCitySelect"
                        style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;">
                        <option value="">-- Select City --</option>
                    </select>
                </div>
            </div>

            <!-- visting Places  -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <label for="destPlaceSelect"
                        style="font-size: 16px; margin-bottom: 8px; display: block;">Destination Places:</label>
                    <select id="destplaces" onchange="showDestinationPlacesCheckboxes()"
                        style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;">
                        <option value="">-- Select Places --</option>
                        @foreach ($places as $place)
                            <option value="{{ $place->id }}">{{ $place->place_name }} - {{ $place->state ? $place->state->state_name : 'N/A' }} - {{ $place->city ? $place->city->city_name : 'N/A' }}</option>
                        @endforeach
                    </select>
                    <div id="placesCheckboxes" style="margin-top: 10px; display: none;">
                        @foreach ($places as $place)
                            <div>
                                <input type="checkbox" id="place_{{ $place->id }}" name="places[]" value="{{ $place->id }}" onchange="updateSelectedPlaces()">
                                <label for="place_{{ $place->id }}">{{ $place->place_name }} - {{ $place->state ? $place->state->state_name : 'N/A' }} - {{ $place->city ? $place->city->city_name : 'N/A' }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Travel Date -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <label for="travelStartDate" style="font-size: 16px; margin-bottom: 8px; display: block;">Start
                        Date:</label>
                    <input type="date" id="travelStartDate"
                        style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;" />
                </div>
                <div style="flex: 1;">
                    <label for="travelEndDate" style="font-size: 16px; margin-bottom: 8px; display: block;">End
                        Date:</label>
                    <input type="date" id="travelEndDate"
                        style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;" />
                </div>
            </div>
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                <!-- Travel Mode Going -->
                <div style="flex: 1;">
                    <label for="goingMode" style="font-size: 16px; margin-bottom: 8px; display: block;">Travel Mode:
                        (Going)</label>
                    <select id="goingMode"
                        style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;">
                        <option value="Going_Mode">Select Mode</option>
                        <option value="Flight">Flight</option>
                        <!-- <option value="Train">Train</option> -->
                        <option value="Bus">Bus</option>
                        <option value="Car">Car</option>
                    </select>
                </div>


                <!-- Travel Mode Coming -->
                <div style="flex: 1;">
                    <label for="comingMode" style="font-size: 16px; margin-bottom: 8px; display: block;">Travel Mode:
                        (Come)</label>
                    <select id="comingMode"
                        style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;">
                        <option value="Coming_Mode">Select Mode</option>
                        <option value="Flight">Flight</option>
                        <!-- <option value="Train">Train</option> -->
                        <option value="Bus">Bus</option>
                        <option value="Car">Car</option>
                    </select>
                </div>
            </div>

            <!-- Local Travel -->
            <div style="display: flex; gap: 20px; margin-bottom: 15px;">
                <div style="flex: 1;">
                    <label for="localTravel" style="font-size: 16px; margin-bottom: 8px; display: block;">Local
                        Travels:</label>
                    <select id="localTravel"
                        style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;">
                        <option value="Local_Travel">Select Mode</option>
                        <option value="Bus">Bus</option>
                        <option value="Car">Car</option>
                        <option value="Car">Bike</option>
                    </select>
                </div>
            </div>

            <!-- Hotel Type -->
            <div style="flex: 1;">
                <label for="hotelType" style="font-size: 16px; margin-bottom: 8px; display: block;">Hotel:</label>
                <select id="hotelType"
                    style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;">
                    <option value="Select">Select</option>
                    <option value="2 Star">2 Star</option>
                    <option value="3 Star">3 Star</option>
                    <option value="5 Star">5 Star</option>
                </select>
            </div>

            <!-- Tour Type -->
            <label for="tourType" style="font-size: 16px; margin-bottom: 8px; display: block;">Tour Type:</label>
            <select id="tourType"
                style="width: 100%; padding: 10px; margin-bottom: 15px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;"
                onchange="showTourOptions()">
                <option value="">-- Select Tour Type --</option>
                @foreach ($tourTypes as $tour)
                    <option value="{{ $tour->name }}">{{ $tour->name }}</option>
                @endforeach
            </select>
            <div style="margin-bottom: 15px;">
                <label style="font-size: 16px; margin-bottom: 8px; display: block;">Hotel Amenities:</label>
                <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                    <div>
                        <input type="checkbox" id="welcomeDrink" name="hotelAmenities" value="Welcome Drink">
                        <label for="welcomeDrink">Welcome Drink</label>
                        <input type="checkbox" id="breakfast" name="hotelAmenities" value="Breakfast">
                        <label for="breakfast">Breakfast</label>
                        <input type="checkbox" id="lunch" name="hotelAmenities" value="Lunch">
                        <label for="lunch">Lunch</label><br>
                        <input type="checkbox" id="dinner" name="hotelAmenities" value="Dinner">
                        <label for="dinner">Dinner</label>
                    </div>
                </div>
            </div>
            <!-- Extra Activities -->
            <div style="margin-bottom: 15px;">
                <label style="font-size: 16px; margin-bottom: 8px; display: block;">Extra Activities</label>
                <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                    <div>
                        <input type="checkbox" id="trekking" name="extraActivities" value="Trekking">
                        <label for="Trekking">Trekking</label>
                        <input type="checkbox" id="hiking" name="extraActivities" value="Hiking">
                        <label for="hiking">Hiking</label>
                        <input type="checkbox" id="camping" name="extraActivities" value="Camping">
                        <label for="camping">Camping</label><br>
                        <input type="checkbox" id="survivalSkills" name="extraActivities" value="Survival Skills">
                        <label for="survivalSkills">Survival Skills</label>
                        <input type="checkbox" id="scubaDiving" name="extraActivities" value="Scuba Diving">
                        <label for="scubaDiving">Scuba Diving</label>
                        <input type="checkbox" id="snorkeling" name="extraActivities" value="Snorkeling">
                        <label for="snorkeling">Snorkeling</label><br>
                        <input type="checkbox" id="cyclingExpeditions" name="extraActivities" value="Cycling Expeditions">
                        <label for="cyclingExpeditions">Cycling Expeditions</label>
                        <input type="checkbox" id="boating" name="extraActivities" value="Boating">
                        <label for="boating">Boating</label>
                        <input type="checkbox" id="zipline" name="extraActivities" value="Zipline">
                        <label for="Zipline">Zipline</label><br>
                        <input type="checkbox" id="bunjingJumping" name="extraActivities" value="Bunjing Jumping">
                        <label for="bunjingJumping">Bunjing Jumping</label>
                        <input type="checkbox" id="rafting" name="extraActivities" value="Rafting">
                        <label for="rafting">Rafting</label>
                        <input type="checkbox" id="boneFire" name="extraActivities" value="Bone Fire">
                        <label for="boneFire">Bone Fire</label><br>
                        <input type="checkbox" id="offRoading" name="extraActivities" value="Off Roading">
                        <label for="offRoading">Off Roading</label>
                        <input type="checkbox" id="hillClimbing" name="extraActivities" value="Hill Climbing">
                        <label for="hillClimbing">Hill Climbing</label>
                        <input type="checkbox" id="paragliding" name="extraActivities" value="Paragliding">
                        <label for="paragliding">Paragliding</label><br>
                        <input type="checkbox" id="iceSketting" name="extraActivities" value="Ice Sketting">
                        <label for="iceSketting">Ice Sketting</label>
                        <input type="checkbox" id="volleyball" name="extraActivities" value="Volleyball">
                        <label for="volleyball">Volleyball</label>
                        <input type="checkbox" id="jetskiing" name="extraActivities" value="jetskiing">
                        <label for="jetskiing">Jet Skiing</label><br>
                        <input type="checkbox" id="parasailing" name="extraActivities" value="parasailing">
                        <label for="parasailing">Parasailing</label>
                        <input type="checkbox" id="bumperRides" name="extraActivities" value="bumperRides">
                        <label for="bumperRides">Bumper Rides</label>
                        <input type="checkbox" id="fishing" name="extraActivities" value="fishing">
                        <label for="fishing">Fishing</label><br>
                        <input type="checkbox" id="bananaBoatRides" name="extraActivities" value="bananaBoatRides">
                        <label for="bananaBoatRides">Banana Boat Rides</label>
                    </div>
                </div>
            </div>
            <!-- Tour Options (Checkboxes) -->
            <div id="tourOptions" style="margin-bottom: 15px; display: none;"></div>

            <!-- Generate Package Section -->
            <button onclick="generatePackage()"
                style="width: 100%; padding: 12px; background-color: #007BFF; color: white; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">
                Generate Package
            </button>
        </div>
    </div>
</div>

<script>
    // Define package options and base prices
    const PACKAGE_OPTIONS = {
        accommodation: {
            name: "Accommodation",
            subOptions: {
                "2 Star": {
                    basePrice: 2000,
                    description: "Basic comfort, essential amenities"
                },
                "3 Star": {
                    basePrice: 3500,
                    description: "Mid-range comfort, additional amenities"
                },
                "5 Star": {
                    basePrice: 6000,
                    description: "Luxury accommodation, full amenities"
                }
            }
        },

        tourType: {
            name: "Tour Type",
            subOptions: {
                "Adventure": {
                    basePrice: 2000,
                    description: "Exciting outdoor activities"
                },
                "Religious": {
                    basePrice: 1500,
                    description: "Visit to religious sites"
                },
                "Honeymoon": {
                    basePrice: 2500,
                    description: "Romantic getaway package"
                }
            }
        },
        amenities: {
            name: "Hotel Amenities",
            subOptions: {
                "Welcome Drink": {
                    basePrice: 200,
                    description: "Complimentary welcome drink"
                },
                "Breakfast": {
                    basePrice: 300,
                    description: "Daily breakfast included"
                },
                "Lunch": {
                    basePrice: 400,
                    description: "Daily lunch included"
                },
                "Dinner": {
                    basePrice: 500,
                    description: "Daily dinner included"
                }
            }
        }
    };

    const ACTIVITY_PRICES = {
        "Trekking": 1500,
        "Hiking": 1200,
        "Camping": 2000,
        "Survival Skills": 2500,
        "Scuba Diving": 3500,
        "Snorkeling": 2000,
        "Cycling Expeditions": 1800,
        "Boating": 1500,
        "Zipline": 2000,
        "Bunjing Jumping": 2500,
        "Rafting": 3000,
        "Bone Fire": 1000,
        "Off Roading": 2000,
        "Hill Climbing ": 1500,
        "Paragliding": 3000,
        "Ice Sketting": 2000,
        "Volleyball": 1000,
        "Jet Skiing": 3000,
        "Parasailing": 2500,   
        "Bumper Rides": 1500,
        "Fishing": 2000,
        "Banana Boat Rides": 2500
    };

    // Add this to your existing PACKAGE_OPTIONS object
    if (!PACKAGE_OPTIONS.activities) {
        PACKAGE_OPTIONS.activities = {
            name: "Extra Activities",
            subOptions: {}
        };

        // Initialize the activities with their prices
        Object.entries(ACTIVITY_PRICES).forEach(([activity, price]) => {
            PACKAGE_OPTIONS.activities.subOptions[activity] = {
                basePrice: price,
                description: `${activity} activity`
            };
        });
    }
    // Initialize states data from backend
    const states = @json($states);



    // Common function to update city options based on state selection
    function updateCities(stateSelectId, citySelectId) {
        const stateId = document.getElementById(stateSelectId).value;
        const citySelect = document.getElementById(citySelectId);

        citySelect.innerHTML = '<option value="">-- Select City --</option>';

        const selectedState = states.find(state => state.id == stateId);
        if (selectedState && selectedState.cities) {
            selectedState.cities.forEach(city => {
                const option = document.createElement('option');
                option.value = city.id;
                option.textContent = city.city_name;
                citySelect.appendChild(option);
            });
        }
        updatePackageDetails();
    }

    // Specific functions for travel and destination cities
    function updateTravelCities() {
        updateCities('travelStateSelect', 'travelCitySelect');
    }

    function updateDestinationCities() {
        updateCities('destStateSelect', 'destCitySelect');
    }

    // Add price display divs after select elements
    function updateTravelModeSection() {
        const goingModeSelect = document.getElementById('goingMode');
        const comingModeSelect = document.getElementById('comingMode');
        const localTravelSelect = document.getElementById('localTravel');

        if (!document.getElementById('goingPrice')) {
            const goingPriceDiv = document.createElement('div');
            goingPriceDiv.id = 'goingPrice';
            goingPriceDiv.className = 'price-display';
            goingPriceDiv.style.marginTop = '5px';
            goingPriceDiv.style.color = '#4e73df';
            goingPriceDiv.style.fontWeight = 'bold';
            goingPriceDiv.contentEditable = 'true'; // Make the div editable

            // Add placeholder text
            goingPriceDiv.textContent = 'Enter price...';

            // Optional: Add some styling for better user experience
            goingPriceDiv.style.padding = '2px 5px';
            goingPriceDiv.style.border = '1px solid transparent';
            goingPriceDiv.style.borderRadius = '3px';

            // Add hover effect
            goingPriceDiv.addEventListener('mouseover', () => {
                goingPriceDiv.style.border = '1px solid #4e73df';
            });

            goingPriceDiv.addEventListener('mouseout', () => {
                goingPriceDiv.style.border = '1px solid transparent';
            });

            // Optional: Add event listener to save the changes
            goingPriceDiv.addEventListener('blur', () => {
                const price = parseFloat(goingPriceDiv.textContent.replace(/[^0-9.]/g, '')) || 0;
                goingPriceDiv.dataset.price = price;
                updatePackageDetails();
            });

            goingModeSelect.parentNode.appendChild(goingPriceDiv);
        }

        if (!document.getElementById('comingPrice')) {
            const comingPriceDiv = document.createElement('div');
            comingPriceDiv.id = 'comingPrice';
            comingPriceDiv.className = 'price-display';
            comingPriceDiv.style.marginTop = '5px';
            comingPriceDiv.style.color = '#4e73df';
            comingPriceDiv.style.fontWeight = 'bold';
            comingPriceDiv.contentEditable = 'true'; // Make the div editable

            // Add placeholder text
            comingPriceDiv.textContent = 'Enter price...';

            // Styling for better user experience
            comingPriceDiv.style.padding = '2px 5px';
            comingPriceDiv.style.border = '1px solid transparent';
            comingPriceDiv.style.borderRadius = '3px';

            // Add hover effect
            comingPriceDiv.addEventListener('mouseover', () => {
                comingPriceDiv.style.border = '1px solid #4e73df';
            });

            comingPriceDiv.addEventListener('mouseout', () => {
                comingPriceDiv.style.border = '1px solid transparent';
            });

            // Save changes when user clicks outside
            comingPriceDiv.addEventListener('blur', () => {
                const price = parseFloat(comingPriceDiv.textContent.replace(/[^0-9.]/g, '')) || 0;
                comingPriceDiv.dataset.price = price;
                updatePackageDetails();
            });

            comingModeSelect.parentNode.appendChild(comingPriceDiv);
        }

        if (!document.getElementById('localTravelPrice')) {
            const localTravelPriceDiv = document.createElement('div');
            localTravelPriceDiv.id = 'localTravelPrice';
            localTravelPriceDiv.className = 'price-display';
            localTravelPriceDiv.style.marginTop = '5px';
            localTravelPriceDiv.style.color = '#4e73df';
            localTravelPriceDiv.style.fontWeight = 'bold';
            localTravelPriceDiv.contentEditable = 'true'; // Make the div editable

            // Add placeholder text
            localTravelPriceDiv.textContent = 'Enter price...';

            // Styling for better user experience
            localTravelPriceDiv.style.padding = '2px 5px';
            localTravelPriceDiv.style.border = '1px solid transparent';
            localTravelPriceDiv.style.borderRadius = '3px';

            // Add hover effect
            localTravelPriceDiv.addEventListener('mouseover', () => {
                localTravelPriceDiv.style.border = '1px solid #4e73df';
            });

            localTravelPriceDiv.addEventListener('mouseout', () => {
                localTravelPriceDiv.style.border = '1px solid transparent';
            });

            // Save changes when user clicks outside
            localTravelPriceDiv.addEventListener('blur', () => {
                const price = parseFloat(localTravelPriceDiv.textContent.replace(/[^0-9.]/g, '')) || 0;
                localTravelPriceDiv.dataset.price = price;
                updatePackageDetails();
            });

            localTravelSelect.parentNode.appendChild(localTravelPriceDiv);
        }
    }

    // Add this styling and structure similar to travel modes:
    function updateHotelSection() {
        const hotelTypeSelect = document.getElementById('hotelType');

        if (!document.getElementById('hotelPrice')) {
            const hotelPriceDiv = document.createElement('div');
            hotelPriceDiv.id = 'hotelPrice';
            hotelPriceDiv.className = 'price-display';
            hotelPriceDiv.style.marginTop = '5px';
            hotelPriceDiv.style.color = '#4e73df';
            hotelPriceDiv.style.fontWeight = 'bold';
            hotelPriceDiv.contentEditable = 'true';

            // Add placeholder text
            hotelPriceDiv.textContent = 'Enter price...';

            // Styling for better user experience
            hotelPriceDiv.style.padding = '2px 5px';
            hotelPriceDiv.style.border = '1px solid transparent';
            hotelPriceDiv.style.borderRadius = '3px';

            // Add hover effect
            hotelPriceDiv.addEventListener('mouseover', () => {
                hotelPriceDiv.style.border = '1px solid #4e73df';
            });

            hotelPriceDiv.addEventListener('mouseout', () => {
                hotelPriceDiv.style.border = '1px solid transparent';
            });

            // Save changes when user clicks outside
            hotelPriceDiv.addEventListener('blur', () => {
                const price = parseFloat(hotelPriceDiv.textContent.replace(/[^0-9.]/g, '')) || 0;
                hotelPriceDiv.dataset.price = price;
                updatePackageDetails();
            });

            hotelTypeSelect.parentNode.appendChild(hotelPriceDiv);
        }
    }
    // Update travel mode prices
    function updateTravelModePrices() {
        const goingMode = document.getElementById('goingMode').value;
        const comingMode = document.getElementById('comingMode').value;
        const localTravel = document.getElementById('localTravel').value;
        const goingPriceDiv = document.getElementById('goingPrice');
        const comingPriceDiv = document.getElementById('comingPrice');
        const localTravelPriceDiv = document.getElementById('localTravelPrice');

        if (goingMode && goingMode !== 'Going_Mode') {
            if (!goingPriceDiv.dataset.price) {
                const goingPrice = BASE_TRAVEL_PRICES[goingMode];
                goingPriceDiv.textContent = `₹${goingPrice.toLocaleString('en-IN')}`;
                goingPriceDiv.dataset.price = goingPrice;
            }
        } else {
            goingPriceDiv.textContent = 'Enter price...';
            goingPriceDiv.dataset.price = 0;
        }

        if (comingMode && comingMode !== 'Coming_Mode') {
            if (!comingPriceDiv.dataset.price) {
                const comingPrice = BASE_TRAVEL_PRICES[comingMode];
                comingPriceDiv.textContent = `₹${comingPrice.toLocaleString('en-IN')}`;
                comingPriceDiv.dataset.price = comingPrice;
            }
        } else {
            comingPriceDiv.textContent = 'Enter price...';
            comingPriceDiv.dataset.price = 0;
        }

        if (localTravel && localTravel !== 'Local_Travel') {
            if (!localTravelPriceDiv.dataset.price) {
                const localTravelPrice = BASE_TRAVEL_PRICES[localTravel];
                localTravelPriceDiv.textContent = `₹${localTravelPrice.toLocaleString('en-IN')}`;
                localTravelPriceDiv.dataset.price = localTravelPrice;
            }
        } else {
            localTravelPriceDiv.textContent = 'Enter price...';
            localTravelPriceDiv.dataset.price = 0;
        }

        updatePackageDetails();
    }
    // Add function to update hotel prices
    function updateHotelPrices() {
        const hotelType = document.getElementById('hotelType').value;
        const hotelPriceDiv = document.getElementById('hotelPrice');

        if (hotelType && hotelType !== 'Select') {
            if (!hotelPriceDiv.dataset.price) {
                const hotelPrice = PACKAGE_OPTIONS.accommodation.subOptions[hotelType].basePrice;
                hotelPriceDiv.textContent = `₹${hotelPrice.toLocaleString('en-IN')}`;
                hotelPriceDiv.dataset.price = hotelPrice;
            }
        } else {
            hotelPriceDiv.textContent = 'Enter price...';
            hotelPriceDiv.dataset.price = 0;
        }

        updatePackageDetails();
    }

    // Tour options handling
    function showTourOptions() {
        const tourType = document.getElementById("tourType").value;
        const tourOptionsDiv = document.getElementById("tourOptions");
        tourOptionsDiv.innerHTML = '';
        tourOptionsDiv.style.display = 'none';

        if (optionsByTourType[tourType]) {
            tourOptionsDiv.style.display = 'block';

            optionsByTourType[tourType].forEach(option => {
                const checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.id = option;
                checkbox.name = "tourOptions";
                checkbox.value = option;
                checkbox.addEventListener('change', updatePackageDetails);

                const label = document.createElement("label");
                label.setAttribute("for", option);
                label.textContent = option;

                const div = document.createElement("div");
                div.appendChild(checkbox);
                div.appendChild(label);
                tourOptionsDiv.appendChild(div);
            });
        }

        updatePackageDetails();
    }

    // Package details update function
    function updatePackageDetails() {
        const budget = parseFloat(document.getElementById('budgetInput').value) || 0;
        const travelStateName = document.getElementById('travelStateSelect').selectedOptions[0]?.text || '';
        const travelCityName = document.getElementById('travelCitySelect').selectedOptions[0]?.text || '';
        const destStateName = document.getElementById('destStateSelect').selectedOptions[0]?.text || '';
        const destCityName = document.getElementById('destCitySelect').selectedOptions[0]?.text || '';
        const startDate = document.getElementById('travelStartDate').value;
        const endDate = document.getElementById('travelEndDate').value;
        const hotelType = document.getElementById('hotelType').value;
        const goingMode = document.getElementById('goingMode').value;
        const comingMode = document.getElementById('comingMode').value;
        const localTravel = document.getElementById('localTravel').value;
        const tourType = document.getElementById('tourType').value;

        // Get checked options
        const tourOptions = Array.from(document.querySelectorAll('input[name="tourOptions"]:checked')).map(el => el
            .value);
        const hotelAmenities = Array.from(document.querySelectorAll('input[name="hotelAmenities"]:checked')).map(el =>
            el.value);
        const extraActivities = Array.from(document.querySelectorAll('input[name="extraActivities"]:checked')).map(el =>
            el.value);
        const selectedPlaces = Array.from(document.querySelectorAll('input[name="places[]"]:checked')).map(el => el.nextElementSibling.textContent.trim());

        // Calculate number of days
        const days = startDate && endDate ?
            Math.max(1, Math.ceil((new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24))) : 0;

        // Calculate total cost
        let totalCost = 0;

        // Add hotel costs
        const hotelPrice = parseFloat(document.getElementById('hotelPrice')?.dataset.price) || 0;
        if (hotelPrice && days) {
            totalCost += hotelPrice * days;
        }

        // Add travel costs
        const goingPrice = parseFloat(document.getElementById('goingPrice')?.dataset.price) || 0;
        const comingPrice = parseFloat(document.getElementById('comingPrice')?.dataset.price) || 0;
        const localTravelPrice = parseFloat(document.getElementById('localTravelPrice')?.dataset.price) || 0;

        totalCost += goingPrice + comingPrice;
        if (localTravelPrice && days) {
            totalCost += localTravelPrice * days;
        }

        // Add tour type costs
        if (tourType && PACKAGE_OPTIONS.tourType.subOptions[tourType]) {
            totalCost += PACKAGE_OPTIONS.tourType.subOptions[tourType].basePrice;
        }

        // Add amenity costs
        hotelAmenities.forEach(amenity => {
            if (PACKAGE_OPTIONS.amenities.subOptions[amenity]) {
                totalCost += PACKAGE_OPTIONS.amenities.subOptions[amenity].basePrice * days;
            }
        });

        // Add extra activities costs
        extraActivities.forEach(activity => {
            if (ACTIVITY_PRICES[activity]) {
                totalCost += ACTIVITY_PRICES[activity] * days;
            }
        });

        // Generate and display package HTML
        const packageHTML = generatePackageHTML(
            budget, travelStateName, travelCityName, destStateName, destCityName,
            startDate, endDate, days, hotelType, goingMode, comingMode, localTravel,
            tourType, tourOptions, hotelAmenities, extraActivities, totalCost,
            goingPrice, comingPrice, localTravelPrice, selectedPlaces
        );

        // Update the package details div
        const packageDetails = document.getElementById('packageDetails');
        if (packageDetails) {
            packageDetails.innerHTML = packageHTML;
        }
    }

    function generatePackageHTML(budget, travelStateName, travelCityName, destStateName, destCityName,
        startDate, endDate, days, hotelType, goingMode, comingMode, localTravel,
        tourType, tourOptions, hotelAmenities, extraActivities, totalCost,
        goingPrice, comingPrice, localTravelPrice, selectedPlaces) {

        const formatCurrency = (amount) => `₹${amount.toLocaleString('en-IN')}`;

        return `
        <div class="package-summary" style="border: 1px solid #e3e6f0; padding: 20px; border-radius: 5px; margin-top: 20px;">
            <h3 style="color: #4e73df; margin-bottom: 20px;">Package Summary</h3>
            <div class="details-grid" style="display: grid; grid-template-columns: 1fr 2fr; gap: 15px; margin-bottom: 20px;">
                ${budget ? `
                    <div style="font-weight: bold;">Budget:</div>
                    <div>${formatCurrency(budget)}</div>
                ` : ''}
                
                ${travelStateName ? `
                    <div style="font-weight: bold;">Travel From:</div>
                    <div>${travelStateName}${travelCityName ? ` - ${travelCityName}` : ''}</div>
                ` : ''}
                
                ${destStateName ? `
                    <div style="font-weight: bold;">Destination:</div>
                    <div>${destStateName}${destCityName ? ` - ${destCityName}` : ''}</div>
                ` : ''}
                
                ${startDate ? `
                    <div style="font-weight: bold;">Travel Period:</div>
                    <div>${new Date(startDate).toLocaleDateString('en-IN')} to ${new Date(endDate).toLocaleDateString('en-IN')} (${days} days)</div>
                ` : ''}
                
                ${hotelType ? `
                    <div style="font-weight: bold;">Hotel Category:</div>
                    <div>${hotelType}</div>
                ` : ''}
                
                ${goingMode && goingMode !== 'Going_Mode' ? `
                    <div style="font-weight: bold;">Travel Mode (Going):</div>
                    <div>${goingMode} (${formatCurrency(goingPrice)})</div>
                ` : ''}
                
                ${comingMode && comingMode !== 'Coming_Mode' ? `
                    <div style="font-weight: bold;">Travel Mode (Return):</div>
                    <div>${comingMode} (${formatCurrency(comingPrice)})</div>
                ` : ''}
                
                ${localTravel && localTravel !== 'Local_Travel' ? `
                    <div style="font-weight: bold;">Local Travel:</div>
                    <div>${localTravel} (${formatCurrency(localTravelPrice)} per day)</div>
                ` : ''}
                
                ${tourType ? `
                    <div style="font-weight: bold;">Tour Type:</div>
                    <div>${tourType}</div>
                ` : ''}
                
                ${tourOptions.length ? `
                    <div style="font-weight: bold;">Tour Activities:</div>
                    <div>${tourOptions.join(', ')}</div>
                ` : ''}
                
                ${hotelAmenities.length ? `
                    <div style="font-weight: bold;">Hotel Amenities:</div>
                    <div>${hotelAmenities.map(amenity => 
                        `${amenity} (${formatCurrency(PACKAGE_OPTIONS.amenities.subOptions[amenity].basePrice)}/day)`
                    ).join(', ')}</div>
                ` : ''}
                
                ${extraActivities.length ? `
                    <div style="font-weight: bold;">Extra Activities:</div>
                    <div>${extraActivities.map(activity => 
                        `${activity} (${formatCurrency(ACTIVITY_PRICES[activity])}/day)`
                    ).join(', ')}</div>
                ` : ''}
                
                ${selectedPlaces.length ? `
                    <div style="font-weight: bold;">Selected Places:</div>
                    <div>${selectedPlaces.join(', ')}</div>
                ` : ''}
            </div>
            
            ${totalCost ? `
                <div style="border-top: 1px solid #e3e6f0; padding-top: 15px; margin-top: 15px;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-size: 1.2em; font-weight: bold;">Total Estimated Cost:</span>
                        <span style="font-size: 1.4em; color: #4e73df; font-weight: bold;">${formatCurrency(totalCost)}</span>
                    </div>
                </div>
            ` : ''}
        </div>
    `;
    }

    function updateSelectedPlaces() {
        const selectedPlaces = Array.from(document.querySelectorAll('input[name="places[]"]:checked')).map(el => el.nextElementSibling.textContent.trim());
        updatePackageDetails();
    }

    // PDF Generation
    function downloadPDF() {
        try {
            // Get the package details div content
            const packageDetailsDiv = document.getElementById('packageDetails');
            if (!packageDetailsDiv) {
                throw new Error('Package details not found');
            }

            // Initialize jsPDF
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4'
            });

            // Document styling
            const primaryColor = [78, 115, 223]; // #4e73df

            doc.setFillColor(...primaryColor);
            doc.rect(0, 0, 210, 30, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFontSize(20);
            doc.text("Make My Bharat Yatra - Package Report", 20, 20);

            // Get the package summary div content
            const packageSummary = packageDetailsDiv.querySelector('.package-summary');
            if (!packageSummary) {
                throw new Error('Package summary not found');
            }

            // Extract details from the package summary
            const detailsGrid = packageSummary.querySelector('.details-grid');
            const rows = [];

            if (detailsGrid) {
                const divs = detailsGrid.children;
                for (let i = 0; i < divs.length; i += 2) {
                    if (divs[i] && divs[i + 1]) {
                        const label = divs[i].textContent.trim();
                        const value = divs[i + 1].textContent.trim();
                        if (label && value) {
                            // Special handling for Travel Mode to improve formatting
                            if (label === 'Travel Mode:') {
                                const modes = value.split('\n');
                                if (modes.length > 1) {
                                    // Add Going mode
                                    rows.push(['Travel Mode (Going)', modes[0].replace('Going: ', '')]);
                                    // Add Return mode with proper spacing
                                    rows.push(['Travel Mode(Return)', modes[1].replace('Return: ', '')]);
                                } else {
                                    rows.push([label, value]);
                                }
                            } else {
                                rows.push([label, value]);
                            }
                        }
                    }
                }
            }

            // Add package details table
            doc.autoTable({
                startY: 40,
                head: [
                    ['Description', 'Details']
                ],
                body: rows,
                theme: 'grid',
                headStyles: {
                    fillColor: primaryColor,
                    textColor: [255, 255, 255],
                    fontSize: 12
                },
                styles: {
                    fontSize: 10,
                    cellPadding: 5
                },
                columnStyles: {
                    0: {
                        fontStyle: 'bold'
                    },
                    1: {
                        cellWidth: 100
                    }
                }
            });

            // Add total cost if present
            const costDiv = packageSummary.querySelector('div[style*="border-top"]');
            if (costDiv) {
                const costText = costDiv.textContent.trim();
                const yPos = doc.lastAutoTable.finalY + 10;
                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);
                doc.text(costText, 20, yPos);
            }

            // Add footer
            const pageCount = doc.internal.getNumberOfPages();
            for (let i = 1; i <= pageCount; i++) {
                doc.setPage(i);
                doc.setFontSize(8);
                doc.setTextColor(128, 128, 128);
                doc.text(
                    `Make My Bharat Yatra - Page ${i} of ${pageCount}`,
                    105,
                    290, {
                        align: 'center'
                    }
                );
            }

            // Save the PDF
            doc.save(`package-details-${Date.now()}.pdf`);

        } catch (error) {
            console.error('PDF Generation Error:', error);
            alert('Please generate a package before downloading the PDF.');
        }
    }

    // Add event listener for the download button
    document.addEventListener('DOMContentLoaded', function() {
        const downloadButton = document.querySelector('button[onclick="downloadPDF()"]');
        if (downloadButton) {
            downloadButton.onclick = function(e) {
                e.preventDefault();
                downloadPDF();
            };
        }
    });
    // Package Generation Function
    function generatePackage() {
        if (!validatePackageDetails()) return;

        updatePackageDetails();
        const packageData = storePackageData();

        alert('Package generated successfully! You can now download the PDF.');
    }

    // Initialize everything when the document is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize travel mode section
        updateTravelModeSection();
        // Initialize hotel section
        updateHotelSection();

        // Add listeners to all form elements
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('change', updatePackageDetails);
        });

        // Add specific listeners for state/city dropdowns
        document.getElementById('travelStateSelect').addEventListener('change', updateTravelCities);
        document.getElementById('travelCitySelect').addEventListener('change', updatePackageDetails);
        document.getElementById('destStateSelect').addEventListener('change', updateDestinationCities);
        document.getElementById('destCitySelect').addEventListener('change', updatePackageDetails);

        // Add event listeners for travel mode changes
        document.getElementById('goingMode').addEventListener('change', updateTravelModePrices);
        document.getElementById('comingMode').addEventListener('change', updateTravelModePrices);
        document.getElementById('localTravel').addEventListener('change', updateTravelModePrices);

        // Add listener for hotel type changes
        document.getElementById('hotelType').addEventListener('change', updateHotelPrices);
        // Add input event listener to budget for real-time updates
        document.getElementById('budgetInput').addEventListener('input', updatePackageDetails);

        // Add validation on form submission
        const generateButton = document.querySelector('button[onclick="generatePackage()"]');
        if (generateButton) {
            generateButton.addEventListener('click', function(e) {
                e.preventDefault();
                generatePackage();
            });
        }

        // Load stored data if available
        const storedData = retrievePackageData();
        if (storedData) {
            // Populate form with stored data
            Object.keys(storedData).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    element.value = storedData[key];
                }
            });
            // Update display after loading stored data
            updatePackageDetails();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const extraActivitiesCheckboxes = document.querySelectorAll('input[name="extraActivities"]');
        extraActivitiesCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updatePackageDetails);
        });
    });

    function showDestinationPlacesCheckboxes() {
        const select = document.getElementById('destplaces');
        const checkboxesDiv = document.getElementById('placesCheckboxes');
        if (select.value) {
            checkboxesDiv.style.display = 'block';
        } else {
            checkboxesDiv.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('input[name="places[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedPlaces);
        });
    });
</script>
@include('sales.layouts.footer')
