@include('sales.layouts.header')
@include('sales.layouts.sidebar')
@include('sales.layouts.navbar')

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
                                            {{$packageCount}}

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
                                            {{$destinationCount}}
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
                                            {{$cardDetailsCount}}
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
<div style="width: 55%; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); padding: 20px; margin-bottom: 20px;">
  <h2 style="font-size: 24px; color: #007BFF; margin-bottom: 15px;">Generated Package Details</h2>
  <div id="packageDetails" style="font-size: 16px;"></div>
</div>

<!-- Right: Filters -->
<div style="width: 40%; background-color: #fff; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); padding: 20px; margin-bottom: 20px;">
  <h2 style="font-size: 24px; color: #007BFF; margin-bottom: 15px;">Client Search Filters</h2>

  <!-- Budget Input -->
  <label for="budgetInput" style="font-size: 16px; margin-bottom: 8px; display: block;">Enter Client Budget (in INR):</label>
  <input type="number" id="budgetInput" placeholder="Enter budget..." style="width: 100%; padding: 10px; margin-bottom: 15px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;"/>

  <div style="display: flex; gap: 20px; margin-bottom: 15px;">

<!-- State Dropdown -->
<div style="flex: 1;">
  <label for="stateSelect" style="font-size: 16px; margin-bottom: 8px; display: block;">State:</label>
  <select id="stateSelect" onchange="updateCities()" style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;">
    <option value="">-- Select State --</option>
    @foreach($states as $state)
      <option value="{{ $state->id }}">{{ $state->destination_name }}</option>
    @endforeach
  </select>
</div>

<!-- City Dropdown -->
<div style="flex: 1;">
  <label for="citySelect" style="font-size: 16px; margin-bottom: 8px; display: block;">City:</label>
  <select id="citySelect" style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;">
    <option value="">-- Select City --</option>
  </select>
</div>
</div>
  <!-- Travel Date -->
  <label for="travelDate" style="font-size: 16px; margin-bottom: 8px; display: block;">Select Travel Date:</label>
  <input type="date" id="travelDate" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;"/>
  <div style="display: flex; gap: 20px; margin-bottom: 15px;">
   <!-- Travel Mode -->
   <div style="flex: 1;">
    <label for="travelMode" style="font-size: 16px; margin-bottom: 8px; display: block;">Travel Mode:</label>
    <select id="travelMode" style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;">
      <option value="Flight">Flight</option>
      <option value="Train">Train</option>
      <option value="Bus">Bus</option>
      <option value="Car">Car</option>
    </select>
  </div>

  <!-- Hotel Type -->
  <div style="flex: 1;">
    <label for="hotelType" style="font-size: 16px; margin-bottom: 8px; display: block;">Hotel:</label>
    <select id="hotelType" style="width: 100%; padding: 10px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;">
      <option value="2 Star">2 Star</option>
      <option value="3 Star">3 Star</option>
      <option value="5 Star">5 Star</option>
    </select>
  </div>
</div>
  <!-- Tour Type -->
<label for="tourType" style="font-size: 16px; margin-bottom: 8px; display: block;">Tour Type:</label>
<select id="tourType" style="width: 100%; padding: 10px; margin-bottom: 15px; border: 2px solid #007BFF; border-radius: 5px; font-size: 16px;" onchange="showTourOptions()">
  <option value="">-- Select Tour Type --</option>
  @foreach($tourTypes as $tour)
    <option value="{{ $tour->name }}">{{ $tour->name }}</option>
  @endforeach
</select>

  <!-- Tour Options (Checkboxes) -->
  <div id="tourOptions" style="margin-bottom: 15px; display: none;"></div>

  <!-- Generate Package Section -->
  <button onclick="generatePackage()" style="width: 100%; padding: 12px; background-color: #007BFF; color: white; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">
    Generate Package
  </button>
</div>

</div>
</div>
  @include('sales.layouts.footer')
<script>
// Update city options based on selected state

  const states = @json($states); // Pass states data as JSON to JavaScript

  // Update city dropdown based on the selected state
  function updateCities() {
    const stateId = document.getElementById('stateSelect').value;
    const citySelect = document.getElementById('citySelect');
    
    // Clear existing options
    citySelect.innerHTML = '<option value="">-- Select City --</option>';

    // Find the state and its cities
    const selectedState = states.find(state => state.id == stateId);
    if (selectedState && selectedState.cities) {
      selectedState.cities.forEach(city => {
        const option = document.createElement('option');
        option.value = city.id;
        option.textContent = city.city_name;
        citySelect.appendChild(option);
      });
    }
  }

  function showTourOptions() {
  const tourType = document.getElementById("tourType").value;
  const tourOptionsDiv = document.getElementById("tourOptions");
  tourOptionsDiv.innerHTML = ''; // Clear existing checkboxes
  tourOptionsDiv.style.display = 'none'; // Hide initially

  const optionsByTourType = {
    "Adventure": ["Trekking", "Rishikesh Adventure", "Goa Adventure"],
    "Religious": ["Varanasi", "Haridwar", "Tirupati"],
    "Honeymoon": ["Manali", "Shimla", "Goa"]
  };

  if (optionsByTourType[tourType]) {
    tourOptionsDiv.style.display = 'block'; // Show checkboxes

    optionsByTourType[tourType].forEach(option => {
      const checkbox = document.createElement("input");
      checkbox.type = "checkbox";
      checkbox.id = option;
      checkbox.name = "tourOptions";
      checkbox.value = option;
      
      const label = document.createElement("label");
      label.setAttribute("for", option);
      label.textContent = option;

      const div = document.createElement("div");
      div.appendChild(checkbox);
      div.appendChild(label);
      tourOptionsDiv.appendChild(div);
    });
  }
}
// Function to generate package details with estimated costs
function generatePackage() {
  const budget = document.getElementById("budgetInput").value;
  const stateName = stateSelect.options[stateSelect.selectedIndex].text;
  const travelDate = document.getElementById("travelDate").value;
  const hotelType = document.getElementById("hotelType").value;
  const travelMode = document.getElementById("travelMode").value;
  const tourType = document.getElementById("tourType").value;
  const tourOptions = Array.from(document.querySelectorAll('input[name="tourOptions"]:checked')).map(el => el.value);
  
  const hotelCosts = {
    "2 Star": 2000,
    "3 Star": 3500,
    "5 Star": 6000
  };

  const travelCosts = {
    "Flight": 5000,
    "Train": 1500,
    "Bus": 1000,
    "Car": 3000
  };

  const tourCosts = {
    "Adventure": 2000,
    "Religious": 1500,
    "Honeymoon": 2500
  };

  // Estimated costs based on the selections
  let totalCost = 0;

  totalCost += hotelCosts[hotelType] * 2; // For 2 people
  totalCost += travelCosts[travelMode];
  tourOptions.forEach(option => {
    totalCost += tourCosts[tourType];
  });

  // Show package details
  document.getElementById("packageDetails").innerHTML = `
    <h3>Package Details:</h3>
    <p><strong>State:</strong> ${stateName}</p>
    <p><strong>Travel Date:</strong> ${travelDate}</p>
    <p><strong>Hotel Type:</strong> ${hotelType}</p>
    <p><strong>Travel Mode:</strong> ${travelMode}</p>
    <p><strong>Tour Type:</strong> ${tourType}</p>
    <p><strong>Selected Tour Options:</strong> ${tourOptions.join(', ')}</p>
    <p><strong>Total Estimated Cost:</strong> ₹${totalCost}</p>
  `;
}
</script>
        