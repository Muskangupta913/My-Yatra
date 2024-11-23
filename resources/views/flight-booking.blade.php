@extends('frontend.layouts.master')
@section('content')
<style>
    .sticky-sidebar {
        position: sticky;
        top: 0;
    }
    body { padding: 0px; }
     header, footer { padding: 0px; background-color: #f8f9fa; margin-bottom: 20px; } 
     .container { margin-top: 20px; } 
     .form-group label { font-weight: bold; } 
     .form-control { margin-bottom: 10px; } 
     .sidebar { padding: 15px; background-color: #f8f9fa; border-radius: 5px; } 
     .sidebar h4 { margin-bottom: 15px; } 
     .sidebar .card { margin-bottom: 15px; }
</style>

<div class="container">
    <!-- Flight Search Form -->
    <form class="row g-3">
        <div class="col-md-2">
            <label for="from" class="form-label">From:</label>
            <input type="text" class="form-control" id="from" placeholder="Departure city">
        </div>
        <div class="col-md-2">
            <label for="to" class="form-label">To:</label>
            <input type="text" class="form-control" id="to" placeholder="Destination city">
        </div>
        <div class="col-md-2">
            <label for="departure-date" class="form-label">Departure Date:</label>
            <input type="date" class="form-control" id="departure-date">
        </div>
        <div class="col-md-2">
            <label for="return-date" class="form-label">Return Date:</label>
            <input type="date" class="form-control" id="return-date">
        </div>
        <div class="col-md-2">
            <label for="passengers" class="form-label">Passengers:</label>
            <input type="number" class="form-control" id="passengers" placeholder="No. of passengers" min="1">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Search Flights</button>
        </div>
    </form>
</div>

<div class="container">
    <div class="row">
        <!-- Left Sidebar -->
        <div class="col-md-3 mb-4">
            <div class="sidebar">
                <h4 class="text-primary">Filter Flights</h4>
                <!-- Airlines Section -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        Airlines
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="airline1">
                            <label class="form-check-label" for="airline1">Airline A</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="airline2">
                            <label class="form-check-label" for="airline2">Airline B</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="airline3">
                            <label class="form-check-label" for="airline3">Airline C</label>
                        </div>
                    </div>
                </div>

                <!-- Price Range Section -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        Price Range
                    </div>
                    <div class="card-body">
                        <input type="range" class="form-range" min="100" max="2000" step="50" id="priceRange">
                        <p id="priceValue" class="mt-2 text-secondary">Selected: $100 - $2000</p>
                    </div>
                </div>

                <!-- Timing Section -->
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        Timing
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="timing" id="morning" value="morning">
                            <label class="form-check-label" for="morning">Morning (6 AM - 12 PM)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="timing" id="afternoon" value="afternoon">
                            <label class="form-check-label" for="afternoon">Afternoon (12 PM - 6 PM)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="timing" id="night" value="night">
                            <label class="form-check-label" for="night">Night (6 PM - 12 AM)</label>
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
        </div>
    </div>
</div>
@endsection

<script>
    document.getElementById('priceRange').addEventListener('input', function () {
        document.getElementById('priceValue').innerText = Selected: $${this.value};
    });
</script>