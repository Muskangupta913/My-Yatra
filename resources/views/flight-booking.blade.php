@extends('frontend.layouts.master')
@section('content')
<style>
    body {
        padding: 0;
        margin: 0;
    }

    header, footer {
        padding: 0;
        background-color: #f8f9fa;
        margin-bottom: 20px;
    }

    .container {
        margin-top: 20px;
    }

    .form-group label {
        font-weight: bold;
    }

    .form-control {
        margin-bottom: 10px;
    }

    .sidebar {
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
    }

    .sidebar h4 {
        margin-bottom: 15px;
    }

    .sidebar .card {
        margin-bottom: 15px;
    }

    @media (max-width: 768px) {
        .form-label {
            font-size: 14px;
        }

        .form-control {
            font-size: 14px;
        }

        .sidebar {
            margin-top: 20px;
        }
    }

    @media (max-width: 576px) {
        .sidebar h4 {
            font-size: 18px;
        }

        .btn {
            font-size: 14px;
        }
    }
    .card:hover {
    transform: scale(1.02);
    transition: transform 0.2s ease-in-out;
}
.card {
    height: 100%; /* Ensures cards expand equally */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.card-body {
       flex-grow: 1; /* Makes the body fill the available space */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 0.5rem;
}

.icon {
    font-size: 1.5rem;
}

    /* Style for the airline logo */
.airline-logo {
    width: 30px; /* Adjust logo size */
    margin-right: 20px; /* Space between logo and airline name */
    vertical-align: middle; /* Align logo with text */
}
.air-logo {
    width: 70px; /* Adjust logo size */
    margin-right: 30px; /* Space between logo and airline name */
    vertical-align: middle; /* Align logo with text */
}
</style>

<div class="container bg-dark text-white p-3 rounded">
    <!-- Flight Search Form -->
    <form class="row g-3 align-items-end">
        <div class="col-md-2 col-sm-6">
            <label for="from" class="form-label"><b>From:</b></label>
            <input type="text" class="form-control" id="from" placeholder="Departure city">
        </div>
        <div class="col-md-2 col-sm-6">
            <label for="to" class="form-label"><b>To:</b></label>
            <input type="text" class="form-control" id="to" placeholder="Destination city">
        </div>
        <div class="col-md-2 col-sm-6">
            <label for="departure-date" class="form-label"><b>Departure Date:</b></label>
            <input type="date" class="form-control" id="departure-date">
        </div>
        <div class="col-md-2 col-sm-6">
            <label for="return-date" class="form-label"><b>Return Date:</b></label>
            <input type="date" class="form-control" id="return-date">
        </div>
        <div class="col-md-2 col-sm-6">
            <label for="passengers" class="form-label"><b>Passengers:</b></label>
            <input type="number" class="form-control" id="passengers" placeholder="No. of passengers" min="1">
        </div>
        <div class="col-md-2 col-sm-6 d-flex align-items-center">
            <button type="submit" class="btn btn-primary w-100">Search Flights</button>
        </div>
    </form>
</div>
<div class="container mt-4">
    <div class="row">
        <!-- Left Sidebar -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="sidebar">
                <h4 class="text-black">Filter Flights</h4>

                <!-- Airlines Section -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Airlines</h5>
                    </div>
                    <div class="card-body">
                        <label class="form-label">Select Airlines:</label>
                        <div class="list-group">
                            <label class="list-group-item">
                                <input class="form-check-input me-2" type="checkbox" id="airline1">
                                Air India
                                <img src="{{ asset('assets/images/air.png') }}"  class="airline-logo me-2">
                            </label>
                            <label class="list-group-item">
                                <input class="form-check-input me-2" type="checkbox" id="airline2">
                                Indigo
                                <img src="{{ asset('assets/images/air india.png') }}" class="airline-logo me-2">
                            </label>
                            <label class="list-group-item">
                                <input class="form-check-input me-2" type="checkbox" id="airline3">
                                Air India Express
                                <img src="{{ asset('assets/images/airindia express.jfif') }}"  class="airline-logo me-2">
                            </label>
                            <label class="list-group-item">
                                <input class="form-check-input me-2" type="checkbox" id="airline3">
                                Spice Jet
                                <img src="{{ asset('assets/images/spicejet.jpg') }}"  class="airline-logo me-2">
                            </label>
                            <label class="list-group-item">
                                <input class="form-check-input me-2" type="checkbox" id="airline3">
                                Akasa Air
                                <img src="{{ asset('assets/images/akasa air.png') }}"  class="airline-logo me-2">
                            </label>
                            <label class="list-group-item">
                                <input class="form-check-input me-2" type="checkbox" id="airline3">
                                GO FIRST
                                <img src="{{ asset('assets/images/go first.png') }}"  class="airline-logo me-2">
                            </label>
                            <label class="list-group-item">
                                <input class="form-check-input me-2" type="checkbox" id="airline3">
                                Vistara
                                <img src="{{ asset('assets/images/vistara.png') }}"  class="airline-logo me-2">
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Price Range Section -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Price Range</h5>
                    </div>
                    <div class="card-body">
                        <label for="priceRange" class="form-label">Select Price Range:</label>
                        <div class="d-flex justify-content-between">
                            <span>$100</span>
                            <span>$2000</span>
                        </div>
                        <input type="range" class="form-range" min="100" max="2000" step="50" id="priceRange">
                        <p id="priceValue" class="mt-3 text-muted">Selected: <strong>$100</strong></p>
                    </div>
                </div>

                <!-- Timing Section -->
             <div class="card mb-3 shadow-sm">
                      <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Timing</h5>
                      </div>
                <div class="card-body">
                    <label class="form-label fs-5"><strong>Choose a Timing:</strong></label>
                 <div class="d-flex justify-content-between flex-wrap">
                   <!-- Morning -->
                 <div class="card text-center border-primary shadow-sm mx-2 flex-grow-1">
                     <div class="card-body">
                       <div class="icon mb-2" style="font-size: 2rem; color: #f9c74f;">
                         <i class="fas fa-sun"></i>
                       </div>
                       <h6 class="card-title">Morning</h6>
                       <p class="card-text text-muted">(6 AM - 12 PM)</p>
                       <input class="form-check-input" type="radio" name="timing" id="morning" value="morning">
                     </div>
                 </div>
                   <!-- Afternoon -->
                  <div class="card text-center border-warning shadow-sm mx-2 flex-grow-1">
                    <div class="card-body">
                      <div class="icon mb-2" style="font-size: 2rem; color: #f9844a;">
                        <i class="fas fa-cloud-sun"></i>
                      </div>
                      <h6 class="card-title">Afternoon</h6>
                      <p class="card-text text-muted">(12 PM - 6 PM)</p>
                      <input class="form-check-input" type="radio" name="timing" id="afternoon" value="afternoon">
                     </div>
                  </div>
                 <!-- Night -->
                 <div class="card text-center border-dark shadow-sm mx-2 flex-grow-1">
                    <div class="card-body">
                      <div class="icon mb-2" style="font-size: 2rem; color: #577590;">
                       <i class="fas fa-moon"></i>
                      </div>
                       <h6 class="card-title">Night</h6>
                       <p class="card-text text-muted">(6 PM - 12 AM)</p>
                       <input class="form-check-input" type="radio" name="timing" id="night" value="night">
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
</div>
        <!-- Main Content Section -->
        <div class="col-lg-9 col-md-8">
            <!-- Air India Section -->
            <div class="row mb-4">
                <h2 class="text-danger">Air India
                    <img src="{{ asset('assets/images/air.png') }}"  class="air-logo me-2"></h2>

                <!-- Economy Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            Economy Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$200</strong></p>
                            <p>Includes: Complimentary Snacks, In-flight Entertainment, Wi-Fi Access, 20kg Baggage</p>
                            <button class="btn btn-outline-success w-100">Select</button>
                        </div>
                    </div>
                </div>

                <!-- Business Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            Business Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$500</strong></p>
                            <p>Includes: Lounge Access, Extra Baggage, Priority Boarding, Premium Meals</p>
                            <button class="btn btn-outline-info w-100">Select</button>
                        </div>
                    </div>
                </div>

                <!-- First Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            First Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$1000</strong></p>
                            <p>Includes: Private Suite, Fine Dining, Personal Concierge, Unlimited Wi-Fi</p>
                            <button class="btn btn-outline-warning w-100">Select</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Air India Express Section -->
            <div class="row mb-4">
                <h2 class="text-danger">Air India Express
                <img src="{{ asset('assets/images/airindia express.jfif') }}"  class="air-logo me-2">
                </h2>

                <!-- Economy Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            Economy Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$200</strong></p>
                            <p>Includes: Complimentary Snacks, 15kg Baggage</p>
                            <button class="btn btn-outline-success w-100">Select</button>
                        </div>
                    </div>
                </div>

                <!-- Business Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            Business Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$400</strong></p>
                            <p>Includes: Priority Boarding, Extra Baggage</p>
                            <button class="btn btn-outline-info w-100">Select</button>
                        </div>
                    </div>
                </div>

                <!-- First Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            First Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$700</strong></p>
                            <p>Includes: Private Lounge, Premium Meals, Extra Baggage</p>
                            <button class="btn btn-outline-warning w-100">Select</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Indigo Section -->
            <div class="row mb-4">
                <h2 class="text-primary">Indigo 
                    <img src="{{ asset('assets/images/air india.png') }}" class="air-logo me-2"></h2>

                <!-- Economy Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            Economy Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$150</strong></p>
                            <p>Includes: Complimentary Snacks, In-flight Entertainment, 20kg Baggage</p>
                            <button class="btn btn-outline-success w-100">Select</button>
                        </div>
                    </div>
                </div>

                <!-- Business Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            Business Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$400</strong></p>
                            <p>Includes: Lounge Access, Priority Boarding, Extra Baggage, Premium Meals</p>
                            <button class="btn btn-outline-info w-100">Select</button>
                        </div>
                    </div>
                </div>

                <!-- First Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            First Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$800</strong></p>
                            <p>Includes: Private Suite, Gourmet Meals, Unlimited Wi-Fi, Personal Assistant</p>
                            <button class="btn btn-outline-warning w-100">Select</button>
                        </div>
                    </div>
                </div>
            </div>
             <!-- Vistara Section -->
            <div class="row mb-4">
                <h2 class="text-purple">Vistara 
                    <img src="{{ asset('assets/images/vistara.png') }}" class="air-logo me-2"></h2>

                <!-- Economy Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            Economy Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$150</strong></p>
                            <p>Includes: Complimentary Snacks, In-flight Entertainment, 20kg Baggage</p>
                            <button class="btn btn-outline-success w-100">Select</button>
                        </div>
                    </div>
                </div>

                <!-- Business Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            Business Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$400</strong></p>
                            <p>Includes: Lounge Access, Priority Boarding, Extra Baggage, Premium Meals</p>
                            <button class="btn btn-outline-info w-100">Select</button>
                        </div>
                    </div>
                </div>

                <!-- First Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            First Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$800</strong></p>
                            <p>Includes: Private Suite, Gourmet Meals, Unlimited Wi-Fi, Personal Assistant</p>
                            <button class="btn btn-outline-warning w-100">Select</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Spice Jet Section -->
            <div class="row mb-4">
                <h2 class="text-danger">Spice Jet 
                    <img src="{{ asset('assets/images/spicejet.jpg') }}" class="air-logo me-2"></h2>

                <!-- Economy Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            Economy Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$150</strong></p>
                            <p>Includes: Complimentary Snacks, In-flight Entertainment, 20kg Baggage</p>
                            <button class="btn btn-outline-success w-100">Select</button>
                        </div>
                    </div>
                </div>

                <!-- Business Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            Business Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$400</strong></p>
                            <p>Includes: Lounge Access, Priority Boarding, Extra Baggage, Premium Meals</p>
                            <button class="btn btn-outline-info w-100">Select</button>
                        </div>
                    </div>
                </div>

                <!-- First Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            First Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$800</strong></p>
                            <p>Includes: Private Suite, Gourmet Meals, Unlimited Wi-Fi, Personal Assistant</p>
                            <button class="btn btn-outline-warning w-100">Select</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Akasa Air Section -->
            <div class="row mb-4">
                <h2 class="text-purple">Akasa Air 
                    <img src="{{ asset('assets/images/akasa air.png') }}" class="air-logo me-2"></h2>

                <!-- Economy Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            Economy Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$150</strong></p>
                            <p>Includes: Complimentary Snacks, In-flight Entertainment, 20kg Baggage</p>
                            <button class="btn btn-outline-success w-100">Select</button>
                        </div>
                    </div>
                </div>

                <!-- Business Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            Business Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$400</strong></p>
                            <p>Includes: Lounge Access, Priority Boarding, Extra Baggage, Premium Meals</p>
                            <button class="btn btn-outline-info w-100">Select</button>
                        </div>
                    </div>
                </div>

                <!-- First Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            First Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$800</strong></p>
                            <p>Includes: Private Suite, Gourmet Meals, Unlimited Wi-Fi, Personal Assistant</p>
                            <button class="btn btn-outline-warning w-100">Select</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- GO FIRST Section -->
            <div class="row mb-4">
                <h2 class="text-primary">GO FIRST
                    <img src="{{ asset('assets/images/go first.png') }}" class="air-logo me-2"></h2>

                <!-- Economy Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            Economy Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$150</strong></p>
                            <p>Includes: Complimentary Snacks, In-flight Entertainment, 20kg Baggage</p>
                            <button class="btn btn-outline-success w-100">Select</button>
                        </div>
                    </div>
                </div>

                <!-- Business Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            Business Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$400</strong></p>
                            <p>Includes: Lounge Access, Priority Boarding, Extra Baggage, Premium Meals</p>
                            <button class="btn btn-outline-info w-100">Select</button>
                        </div>
                    </div>
                </div>

                <!-- First Class -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            First Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$800</strong></p>
                            <p>Includes: Private Suite, Gourmet Meals, Unlimited Wi-Fi, Personal Assistant</p>
                            <button class="btn btn-outline-warning w-100">Select</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('priceRange').addEventListener('input', function () {
        document.getElementById('priceValue').innerText = `Selected: $${this.value}`;
    });
</script>
@endsection
