@extends('frontend.layouts.master')
@section('content')
<style>
    .sticky-sidebar {
        position: sticky;
        top: 0;
    }
    body { 
        padding: 0px; 
    }
     header, footer {
         padding: 0px; 
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
</style>

<div class="container">
    <!-- Flight Search Form -->
    <form class="row g-3">
        <div class="col-md-2">
            <label for="from" class="form-label"><b>From:</b></label>
            <input type="text" class="form-control" id="from" placeholder="Departure city">
        </div>
        <div class="col-md-2">
            <label for="to" class="form-label"><b>To:</b></label>
            <input type="text" class="form-control" id="to" placeholder="Destination city">
        </div>
        <div class="col-md-2">
            <label for="departure-date" class="form-label"><b>Departure Date:</b></label>
            <input type="date" class="form-control" id="departure-date">
        </div>
        <div class="col-md-2">
            <label for="return-date" class="form-label"><b>Return Date:</b></label>
            <input type="date" class="form-control" id="return-date">
        </div>
        <div class="col-md-2">
            <label for="passengers" class="form-label"><b>Passengers:</b></label>
            <input type="number" class="form-control" id="passengers" placeholder="No. of passengers" min="1">
        </div>
        <div class="col-md-2 d-flex align-items">
            <button type="submit" class="btn btn-primary w-100">Search Flights</button>
        </div>
    </form>
</div>

<div class="container">
    <div class="row">
        <!-- Left Sidebar -->
        <div class="col-md-3 mb-4">
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
            </label>
            <label class="list-group-item">
                <input class="form-check-input me-2" type="checkbox" id="airline2">
                Indigo
            </label>
            <label class="list-group-item">
                <input class="form-check-input me-2" type="checkbox" id="airline3">
                Air India Express
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
        <label class="form-label">Choose a Timing:</label>
        <div class="row">
            <div class="col-12 mb-2">
                <label class="list-group-item d-flex align-items-center">
                    <input class="form-check-input me-2" type="radio" name="timing" id="morning" value="morning">
                    Morning (6 AM - 12 PM)
                </label>
            </div>
            <div class="col-12 mb-2">
                <label class="list-group-item d-flex align-items-center">
                    <input class="form-check-input me-2" type="radio" name="timing" id="afternoon" value="afternoon">
                    Afternoon (12 PM - 6 PM)
                </label>
            </div>
            <div class="col-12">
                <label class="list-group-item d-flex align-items-center">
                    <input class="form-check-input me-2" type="radio" name="timing" id="night" value="night">
                    Night (6 PM - 12 AM)
                </label>
            </div>
        </div>
    </div>
</div>


            </div>
        </div>

        <!-- Main Content Section -->
        <div class="col-md-9">
            <div class="row">
                <h4 class="text-primary">Air India</h4>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            Economy Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$200</strong></p>
                            <p>Includes: Complimentary Snacks and ggdfg</p>
                            <button class="btn btn-outline-success w-100">Select</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            Business Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$500</strong></p>
                            <p>Includes: Lounge Access, Extra Baggage</p>
                            <button class="btn btn-outline-info w-100">Select</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            First Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$1000</strong></p>
                            <p>Includes: Private Suite, Fine Dining</p>
                            <button class="btn btn-outline-warning w-100">Select</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional content for flight details can go here -->
            <div class="col-md-9">
            <div class="row">
                <h4 class="text-primary">Air India</h4>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            Economy Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$200</strong></p>
                            <p>Includes: Complimentary Snacks and ggdfg</p>
                            <button class="btn btn-outline-success w-100">Select</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            Business Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$500</strong></p>
                            <p>Includes: Lounge Access, Extra Baggage</p>
                            <button class="btn btn-outline-info w-100">Select</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            First Class
                        </div>
                        <div class="card-body">
                            <p>Price: <strong>$1000</strong></p>
                            <p>Includes: Private Suite, Fine Dining</p>
                            <button class="btn btn-outline-warning w-100">Select</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional content for flight details can go here -->
        </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.getElementById('priceRange').addEventListener('input', function () {
        document.getElementById('priceValue').innerText = Selected: $${this.value};
    });
</script>