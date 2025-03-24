@extends('frontend.layouts.master')
@section('content')
    <style>
        /* Filter Section Styling */
        .filter-section {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .filter-section h5 {
            color: #333;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ffc107;
        }

        .filter-section h6 {
            font-weight: 600;
            color: #555;
            margin-bottom: 12px;
        }

        .filter-check-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .filter-check-item input[type="checkbox"] {
            margin-right: 10px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .filter-check-item label {
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 0;
        }

        /* Package Card Styling */
        .package-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 8px;
            overflow: hidden;
            height: 100%;
        }

        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .package-img {
            height: 220px;
            object-fit: cover;
        }

        .package-desc {
            padding: 15px;
        }

        .package-desc h5 {
            font-weight: 600;
            color: #333;
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .package-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .package-price {
            font-size: 18px;
            font-weight: 700;
            color: #e91e63;
            margin-bottom: 15px;
        }

        .booking-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-book-now {
            background-color: #ffc107;
            border: none;
            padding: 8px 15px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-book-now:hover {
            background-color: #ffaa00;
        }

        .flight-dropdown .dropdown-toggle {
            background-color: #6c757d;
            border: none;
            padding: 8px 12px;
        }

        .flight-dropdown .dropdown-menu {
            min-width: 160px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .flight-dropdown .dropdown-item {
            padding: 8px 15px;
            font-size: 14px;
        }

        .flight-dropdown .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .badge-flight {
            padding: 6px 10px;
            font-weight: 500;
        }

        /* Empty state styling */
        .empty-state {
            padding: 60px 0;
        }

        .empty-state img {
            max-width: 250px;
            margin-bottom: 20px;
        }

        .empty-state p {
            font-size: 16px;
            color: #666;
            margin-bottom: 25px;
        }
    </style>

    @if ($packages->isEmpty())
        <div class="container empty-state">
            <div class="text-center m-auto">
                <img src="{{ asset('assets/img/package-not-found.png') }}" alt="No packages found">
                <p class="mt-4">No package(s) found for the selected city. Please try another city or contact our travel
                    experts at <a href="tel:9871980066" class="text-decoration-none fw-bold">+91 9871980066</a>.</p>
                <a href="{{ route('home') }}" class="btn btn-warning btn-lg rounded-0">Return Home</a>
            </div>
        </div>
    @else
        <section style="background-color: #fff;">
            <div class="container py-5">
                <div class="row">
                    <!-- Filter Section -->
                    <div class="col-md-3">
                        <div class="filter-section mb-4">
                            <h5 class="text-center">Filters</h5>
                            <form id="filterForm">
                                <div class="mb-4">
                                    <h6>Price Range</h6>
                                    <div class="filter-check-item">
                                        <input type="checkbox" class="filter-price" value="low" id="priceLow">
                                        <label for="priceLow">Low to High</label>
                                    </div>
                                    <div class="filter-check-item">
                                        <input type="checkbox" class="filter-price" value="high" id="priceHigh">
                                        <label for="priceHigh">High to Low</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <h6>Duration</h6>
                                    <div class="filter-check-item">
                                        <input type="checkbox" class="filter-duration" value="1N2D" id="duration1N2D">
                                        <label for="duration1N2D">1 Night 2 Days</label>
                                    </div>
                                    <div class="filter-check-item">
                                        <input type="checkbox" class="filter-duration" value="2N3D" id="duration2N3D">
                                        <label for="duration2N3D">2 Nights 3 Days</label>
                                    </div>
                                    <div class="filter-check-item">
                                        <input type="checkbox" class="filter-duration" value="4N5D" id="duration4N5D">
                                        <label for="duration4N5D">4 Nights 5 Days</label>
                                    </div>
                                    <div class="filter-check-item">
                                        <input type="checkbox" class="filter-duration" value="5N6D" id="duration5N6D">
                                        <label for="duration5N6D">5 Nights 6 Days</label>
                                    </div>
                                    <div class="filter-check-item">
                                        <input type="checkbox" class="filter-duration" value="6N7D" id="duration6N7D">
                                        <label for="duration6N7D">6 Nights 7 Days</label>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-primary btn-sm" id="applyFilter">Apply
                                        Filters</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="clearFilter">Clear
                                        All</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Package List -->
                    <div class="col-md-9">
                        <div class="row">
                            @foreach ($packages as $item)
                                <div class="col-md-6 mb-4 package-item" data-price="{{ $item->offer_price }}"
                                    data-duration="{{ $item->duration }}">
                                    <div class="package-card shadow">
                                        <a href="{{ url('holidays/' . $item->slug) }}"
                                            class="text-decoration-none text-dark">
                                            <img src="{{ asset('uploads/packages/' . $item->photo) }}"
                                                class="w-100 package-img" alt="{{ $item->package_name }}">
                                            <div class="package-desc">
                                                <h5>{{ \Illuminate\Support\Str::limit($item->package_name, 38, '...') }}
                                                </h5>
                                                <p class="package-info">Duration: {{ $item->duration }} days</p>
                                                <p class="package-price">₹{{ number_format($item->offer_price, 2) }}</p>
                                        </a>
                                        <div class="booking-options">
                                            @if ($item->flight_included)
                                                <button class="btn btn-book-now booknow" data-id="{{ $item->id }}">Book
                                                    Now</button>
                                                <span class="badge bg-info text-dark badge-flight">With Flight</span>
                                            @else
                                                <button class="btn btn-book-now booknow" data-id="{{ $item->id }}"
                                                    data-flight="without">Book Now</button>

                                                <div class="dropdown flight-dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                        id="flightOptionDropdown{{ $item->id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Without Flight
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="flightOptionDropdown{{ $item->id }}">
                                                        <li><a class="dropdown-item flight-option" href="#"
                                                                data-id="{{ $item->id }}"
                                                                data-flight="without">Without Flight</a></li>
                                                        <li><a class="dropdown-item flight-option" href="#"
                                                                data-id="{{ $item->id }}" data-flight="with">With Flight</a></li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                        </div>
    @endforeach
    </div>
    </div>
    </div>
    </div>
    </section>
    @endif
    <!-- Booking Modal -->
<!-- Flight Booking Modal -->
<div class="modal fade" id="flightBookingModal" tabindex="-1" aria-labelledby="flightBookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="flightBookingModalLabel">Book Your Flight</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Flight Booking Form -->
        <form id="flightSearchForm" action="{{ route('flight.search') }}" method="POST">
          @csrf
          <div class="row mb-3">
            <div class="col-md-4">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="journeyType" id="oneWay" value="1" checked>
                <label class="form-check-label" for="oneWay">One Way</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="journeyType" id="roundTrip" value="2">
                <label class="form-check-label" for="roundTrip">Round Trip</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="mb-2 col-md-6 position-relative">
              <div class="date-caption">From</div>
              <div class="position-relative">
                <input type="text" class="form-control rounded-0 py-3" id="flightFromCity" placeholder="Origin" required>
                <input type="hidden" id="flightFromCityCode" name="origin" required>
                <div id="flightFromCityList" class="card" style="position: absolute; width: 100%; max-height: 150px; overflow-y: scroll; z-index: 1000;"></div>
              </div>
            </div>          
            <div class="mb-2 col-md-6 position-relative">
              <div class="date-caption">To</div>
              <div class="position-relative">
                <input type="text" class="form-control rounded-0 py-3" id="flightToCity" placeholder="Arriving" required>
                <input type="hidden" id="flightToCityCode" name="destination" required>
                <div id="flightToCityList" class="card" style="position: absolute; width: 100%; max-height: 150px; overflow-y: scroll; z-index: 1000;"></div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="mb-2 col-md-6">
              <div class="date-caption">Departure</div>
              <input type="text" id="flightDepartureDate" name="departureDate" class="form-control rounded-0 py-3 datepicker" placeholder="Departure" required>
            </div>
            <div class="mb-2 col-md-6">
              <div class="date-caption">Return</div>
              <input type="text" id="flightReturnDate" name="returnDate" class="form-control rounded-0 py-3 datepicker" placeholder="Return">
            </div>
          </div>

          <div class="row">
            <div class="mb-2 col-md-6">
              <div class="date-caption">Passengers</div>
              <div class="dropdown">
                <button class="form-control rounded-0 py-3 text-start" type="button" id="passengerDropdown" data-bs-toggle="dropdown">
                  Passengers
                </button>
                <div class="dropdown-menu p-3" style="position: absolute; width: 100%; max-height: 150px; overflow-y: scroll; z-index: 1000;">
                  <div class="mb-2">
                    <label for="adultCount">Adults</label>
                    <input type="number" id="adultCount" name="adultCount" class="form-control" value="1" min="1" max="9">
                  </div>
                  <div class="mb-2">
                    <label for="childCount">Child</label>
                    <input type="number" id="childCount" name="childCount" class="form-control" value="0" min="0" max="9">
                  </div>
                  <div class="mb-2">
                    <label for="infantCount">Infants</label>
                    <input type="number" id="infantCount" name="infantCount" class="form-control" value="0" min="0" max="9">
                  </div>
                </div>
              </div>
            </div>

            <div class="mb-2 col-md-6">
              <div class="date-caption">Fare Type</div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="fareType" id="normalFare" value="1" checked>
                    <label class="form-check-label" for="normalFare">Normal</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="fareType" id="studentFare" value="2">
                    <label class="form-check-label" for="studentFare">Student</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="fareType" id="seniorCitizenFare" value="3">
                    <label class="form-check-label" for="seniorCitizenFare">Senior</label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="mt-3 text-center">
            <button type="submit" id="flightSearch" class="btn btn-warning rounded-0 py-2 fw-bold px-5">Search Flights</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Ensure dropdown functionality works
            $('.dropdown-toggle').dropdown();

            // Update dropdown button text and "Book Now" button's flight option
            $('.flight-option').on('click', function(event) {
                event.preventDefault();
                var id = $(this).data("id");
                var flightOption = $(this).data("flight");

                // Update the dropdown button text
                $('#flightOptionDropdown' + id).text(flightOption === 'with' ? 'With Flight' : 'Without Flight');

                // Update the "Book Now" button's data-flight attribute
                $('.booknow[data-id="' + id + '"]').data('flight', flightOption);

                // Automatically open the Flight Booking Modal if "With Flight" is selected
                if (flightOption === 'with') {
                    $('#flightBookingModal').modal('show'); // Open the Flight Modal
                    $('#package_id').val(id); // Set the package ID in the modal
                    $('#flight_option').val(flightOption); // Set the flight option in the modal
                }
            });

            // Filter functionality
            $('#applyFilter').on('click', function() {
                applyFilters();
            });

            $('#clearFilter').on('click', function() {
                $('#filterForm input[type="checkbox"]').prop('checked', false);
                $('.package-item').show();
            });

            function applyFilters() {
                // Get selected price filter
                var priceFilter = [];
                $('.filter-price:checked').each(function() {
                    priceFilter.push($(this).val());
                });

                // Get selected duration filters
                var durationFilters = [];
                $('.filter-duration:checked').each(function() {
                    durationFilters.push($(this).val());
                });

                // First show all items
                $('.package-item').show();

                // If any price filter is selected
                if (priceFilter.length > 0) {
                    if (priceFilter.includes('low')) {
                        // Sort by price low to high
                        $('.row').append($('.package-item').sort(function(a, b) {
                            return parseFloat($(a).data('price')) - parseFloat($(b).data('price'));
                        }));
                    } else if (priceFilter.includes('high')) {
                        // Sort by price high to low
                        $('.row').append($('.package-item').sort(function(a, b) {
                            return parseFloat($(b).data('price')) - parseFloat($(a).data('price'));
                        }));
                    }
                }

                // If any duration filter is selected
                if (durationFilters.length > 0) {
                    $('.package-item').each(function() {
                        var duration = $(this).data('duration');
                        var durationKey = '';

                        // Convert duration days to night-day format
                        if (duration == 2) durationKey = '1N2D';
                        else if (duration == 3) durationKey = '2N3D';
                        else if (duration == 5) durationKey = '4N5D';
                        else if (duration == 6) durationKey = '5N6D';
                        else if (duration == 7) durationKey = '6N7D';

                        if (!durationFilters.includes(durationKey)) {
                            $(this).hide();
                        }
                    });
                }
            }
        });

        // Initialize Flight Modal functions
$(document).ready(function() {
  // Initialize datepicker for the modal
  $('#flightBookingModal .datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    startDate: new Date()
  });

  // Trip type handling for modal
  $('#flightBookingModal input[name="journeyType"]').on('change', function() {
    const tripType = $(this).val();
    const returnDateField = $('#flightBookingModal #flightReturnDate');

    if (tripType === '1') { // One way
      returnDateField.prop('disabled', true).val('');
      returnDateField.closest('.mb-2').fadeOut();
    } else { // Round trip
      returnDateField.prop('disabled', false);
      returnDateField.closest('.mb-2').fadeIn();
    }
  });

  // Initialize airport search functionality
  function initializeModalAirportSearch() {
    const searchConfig = [
      {
        inputId: '#flightBookingModal #flightFromCity',
        codeInputId: '#flightBookingModal #flightFromCityCode',
        listId: '#flightBookingModal #flightFromCityList'
      },
      {
        inputId: '#flightBookingModal #flightToCity',
        codeInputId: '#flightBookingModal #flightToCityCode',
        listId: '#flightBookingModal #flightToCityList'
      }
    ];

    // Add a document click handler
    $(document).on('mouseup', function(e) {
      searchConfig.forEach(config => {
        const list = $(config.listId);
        const input = $(config.inputId);
        
        if (!input.is(e.target) && !list.is(e.target) && list.has(e.target).length === 0) {
          list.hide();
        }
      });
    });

    searchConfig.forEach(config => {
      const input = $(config.inputId);
      const codeInput = $(config.codeInputId);
      const list = $(config.listId);
      let searchTimeout;

      input.on('input', function() {
        clearTimeout(searchTimeout);
        const query = $(this).val();

        if (query.length < 2) {
          list.hide();
          return;
        }

        searchTimeout = setTimeout(() => {
          fetchAirports(query, list, input, codeInput);
        }, 300);
      });
    });
  }

  // Call the initialization function
  initializeModalAirportSearch();
  
  // Show/hide return date field based on initial journey type
  const initialTripType = $('#flightBookingModal input[name="journeyType"]:checked').val();
  if (initialTripType === '1') {
    $('#flightBookingModal #flightReturnDate').prop('disabled', true).closest('.mb-2').hide();
  }
  
  // Handle form submission
  $('#flightBookingModal #flightSearchForm').on('submit', function(e) {
    e.preventDefault();
    
    // Same AJAX code as in your original script
    const adultCount = $('#flightBookingModal #adultCount').val() || "1";
    const childCount = $('#flightBookingModal #childCount').val() || "0";
    const infantCount = $('#flightBookingModal #infantCount').val() || "0";
    
    setCookie('adultCount', adultCount, 7);
    setCookie('childCount', childCount, 7);
    setCookie('infantCount', infantCount, 7);
    
    const fareType = $('#flightBookingModal input[name="fareType"]:checked').val() || "1";
    const journeyType = $('#flightBookingModal input[name="journeyType"]:checked').val();
    sessionStorage.setItem('journeyType', journeyType);
    
    const departureDate = convertToISODate($('#flightBookingModal #flightDepartureDate').val());
    const segments = [{
      Origin: $('#flightBookingModal #flightFromCityCode').val().toUpperCase(),
      Destination: $('#flightBookingModal #flightToCityCode').val().toUpperCase(),
      FlightCabinClass: 1, // Default to economy
      PreferredDepartureTime: `${departureDate}T00:00:00`,
      PreferredArrivalTime: `${departureDate}T00:00:00`
    }];
    
    const searchParams = new URLSearchParams({
      from: $('#flightBookingModal #flightFromCity').val(),
      fromCode: $('#flightBookingModal #flightFromCityCode').val(),
      to: $('#flightBookingModal #flightToCity').val(),
      toCode: $('#flightBookingModal #flightToCityCode').val(),
      departureDate: $('#flightBookingModal #flightDepartureDate').val(),
      returnDate: $('#flightBookingModal #flightReturnDate').val(),
      tripType: journeyType,
      adults: adultCount,
      children: childCount,
      infants: infantCount,
      fareType: fareType,
      cabinClass: "1" // Default to economy
    });
    
    if (journeyType === '2') {
      const returnDate = convertToISODate($('#flightBookingModal #flightReturnDate').val());
      segments.push({
        Origin: $('#flightBookingModal #flightToCityCode').val().toUpperCase(),
        Destination: $('#flightBookingModal #flightFromCityCode').val().toUpperCase(),
        FlightCabinClass: 1,
        PreferredDepartureTime: `${returnDate}T00:00:00`,
        PreferredArrivalTime: `${returnDate}T00:00:00`
      });
    }
    
    const payload = {
      AdultCount: adultCount.toString(),
      ChildCount: childCount.toString(),
      InfantCount: infantCount.toString(),
      JourneyType: journeyType,
      FareType: fareType,
      Segments: segments
    };
    
    $.ajax({
      url: '/flight/search',
      method: 'POST',
      contentType: 'application/json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      data: JSON.stringify(payload),
      success: function(response) {
        if (response.success) {
          console.log('Flight search results:', response);
          
          // Store common details
          sessionStorage.setItem('flightTraceId', response.traceId);
          sessionStorage.setItem('flightSearchParams', JSON.stringify(payload));
          
          // Store flight results based on journey type
          if (payload.JourneyType === "2") {  // RoundTrip
            sessionStorage.setItem('outboundFlights', JSON.stringify(response.outbound));
            sessionStorage.setItem('returnFlights', JSON.stringify(response.return));
          } else {  // OneWay
            sessionStorage.setItem('flightSearchResults', JSON.stringify(response.results));
          }
          
          // Close the modal
          $('#flightBookingModal').modal('hide');
          
          // Redirect to results page
          window.location.href = `/flight?${searchParams.toString()}`;
        } else {
          toastr.info(response.message || 'No flights found.', 'Search Results');
        }
      },
      error: function(xhr) {
        console.error('Error:', xhr.responseJSON);
        toastr.error(xhr.responseJSON?.message || 'An error occurred.', 'Search Error');
      }
    });
  });
});
    </script>
@endsection
