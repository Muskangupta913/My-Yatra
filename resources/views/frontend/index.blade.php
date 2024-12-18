@extends('frontend.layouts.master')
@section('content')
<style>
.flatpickr-calendar {
  font-family: 'Arial', sans-serif;
  border: 1px solid #ccc;
}

.flatpickr-day {
  padding: 8px;
}
</style>
<section class="hero">
  <div class="container">
    <div class="row">
      <div class="card search-engine-card py-5 px-4" style="position: relative">
        <ul class="nav nav-tabs border-0" style="position: absolute; top:0; left:1%; transform:translateY(-50%);"
          id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link px-4 shadow border-0" id="flight-tab" data-bs-toggle="tab" data-bs-target="#flight"
              type="button" role="tab" aria-controls="flight" aria-selected="false">
              <i class="fa-solid fa-plane-departure d-block"></i>
              <small>Flight</small>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link  px-4 shadow border-0" id="profile-tab" data-bs-toggle="tab"
              data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
              <i class="fa-solid fa-building d-block"></i>
              <small>Hotel</small>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link active px-4 border-0 shadow" id="contact-tab" data-bs-toggle="tab"
              data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
              <i class="fa-solid fa-umbrella-beach d-block"></i>
              <small>Holidays</small>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-4 shadow border-0" id="bus-tab" data-bs-toggle="tab" data-bs-target="#bus"
              type="button" role="tab" aria-controls="bus" aria-selected="false">
              <i class="fa-solid fa-bus"></i><br>
              <small>Bus</small>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link px-4 shadow border-0" id="car-tab" data-bs-toggle="tab" data-bs-target="#car"
              type="button" role="tab" aria-controls="car" aria-selected="false">
              <i class="fa-solid fa-car"></i><br>
              <small>Car</small>
            </button>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
            <p>Comming Soon!</p>
          </div>
          <!-- // hotel booking -->
          <div class="tab-pane fade mt-5" id="profile" role="tabpanel" aria-labelledby="profile-tab">
               <h4 class="mb-5" id="hotel-title">Book Hotels in India</h4>
                <hr class="searchline">
                <form action="{{ route('hotels') }}" method="GET">
                <div class="row">
         <div class="mb-3 col-md-3 hotel-search">
            <div class="date-caption">City</div>
               <input type="text" class="form-control rounded-0 py-3" name="searchCity" id="hotelSearchCity"
                placeholder="Enter City" required>
              <div id="hotelCityList" class="card" style="position: absolute; width: 23%; max-height: 150px; overflow-y: scroll;">
            </div>
          </div>
           <div class="mb-3 col-md-2">
              <div class="date-caption">Check-in Date</div>
                      <input type="text" id="checkinDatepicker" name="check_in_date" class="form-control rounded-0 py-3 datepicker" placeholder="Select Check-in Date" required>
            </div>
      <div class="mb-3 col-md-2">
        <div class="date-caption">Check-out Date</div>
        <input type="text" id="checkoutDatepicker" name="check_out_date" class="form-control rounded-0 py-3 datepicker" placeholder="Select Check-out Date" required>
      </div>

      <div class="mb-3 col-md-2">
        <div class="date-caption" style="visibility: hidden">Search</div>
        <button type="submit" class="btn btn-warning w-100 rounded-0 py-3 fw-bold hotelbuttonsearch">Search</button>
      </div>
    </div>
  </form>
</div>

<!-- // flight booking -->
<div class="tab-pane fade mt-5" id="flight" role="tabpanel" aria-labelledby="home-tab">
  <h4 class="mb-5" id="flight-title">Book Flights</h4>
  <hr class="searchline">
  <form action="{{ route('flight.booking') }}" method="GET">
    <div class="row">
      <div class="mb-3 col-md-3">
        <div class="date-caption">From</div>
        <input type="text" class="form-control rounded-0 py-3" name="fromCity" id="flightFromCity" placeholder="Enter Departure City" required>
        <div id="flightFromCityList" class="card" style="position: absolute; width: 23%; max-height: 150px; overflow-y: scroll;"></div>
      </div>
      <div class="mb-3 col-md-3">
        <div class="date-caption">To</div>
        <input type="text" class="form-control rounded-0 py-3" name="toCity" id="flightToCity" placeholder="Enter Destination City" required>
        <div id="flightToCityList" class="card" style="position: absolute; width: 23%; max-height: 150px; overflow-y: scroll;"></div>
      </div>
      <div class="mb-3 col-md-2">
        <div class="date-caption">Departure Date</div>
        <input type="text" id="flightDepartureDate" name="departure_date" class="form-control rounded-0 py-3 datepicker" placeholder="Select Departure Date" required>
      </div>
      <div class="mb-3 col-md-2">
        <div class="date-caption">Return Date</div>
        <input type="text" id="flightReturnDate" name="return_date" class="form-control rounded-0 py-3 datepicker" placeholder="Select Return Date">
      </div>
      <div class="mb-3 col-md-2">
        <div class="date-caption" style="visibility: hidden">Search</div>
        <button type="submit" class="btn btn-warning w-100 rounded-0 py-3 fw-bold">Search Flights</button>
      </div>
    </div>
  </form>
</div>
 <!-- Car Booking -->
<div class="tab-pane fade mt-5" id="car" role="tabpanel" aria-labelledby="car-tab">
  <h4 class="mb-5" id="car-title">Book Cars</h4>
  <hr class="searchline">
  <form action="{{ route('cars') }}" method="GET">
    <div class="row">
      <div class="mb-3 col-md-3">
        <div class="date-caption">Pickup Location</div>
        <input type="text" class="form-control rounded-0 py-3" name="pickupLocation" id="carPickupLocation" placeholder="Enter Pickup Location" required>
        <div id="carPickupLocationList" class="card" style="position: absolute; width: 23%; max-height: 150px; overflow-y: scroll;"></div>
      </div>
      <div class="mb-3 col-md-3">
        <div class="date-caption">Drop-off Location</div>
        <input type="text" class="form-control rounded-0 py-3" name="dropoffLocation" id="carDropoffLocation" placeholder="Enter Drop-off Location" required>
        <div id="carDropoffLocationList" class="card" style="position: absolute; width: 23%; max-height: 150px; overflow-y: scroll;"></div>
      </div>
      <div class="mb-3 col-md-2">
        <div class="date-caption">Pickup Date</div>
        <input type="text" id="carPickupDate" name="pickup_date" class="form-control rounded-0 py-3 datepicker" placeholder="Select Pickup Date" required>
      </div>
      <div class="mb-3 col-md-2">
        <div class="date-caption">Drop-off Date</div>
        <input type="text" id="carDropoffDate" name="dropoff_date" class="form-control rounded-0 py-3 datepicker" placeholder="Select Drop-off Date" required>
      </div>
      <div class="mb-3 col-md-2">
        <div class="date-caption" style="visibility: hidden">Search</div>
        <button type="submit" class="btn btn-warning w-100 rounded-0 py-3 fw-bold">Search Cars</button>
      </div>
    </div>
  </form>
</div>
 <!-- Bus Booking -->
 <div class="tab-pane fade mt-5" id="bus" role="tabpanel" aria-labelledby="bus-tab">
  <h4 class="mb-5" id="bus-title">Book Bus Tickets</h4>
  <hr class="searchline">
  
  <!-- Add CSRF token -->
  <form action="{{ route('buses.search') }}" method="POST" id="busSearchForm">
    @csrf
    <div class="row">
        <!-- Source City -->
        <div class="mb-3 col-md-3">
            <div class="date-caption">From</div>
            <input type="text" class="form-control rounded-0 py-3" name="source_city" id="busFromCity" placeholder="Enter Departure City" required>
            <input type="hidden" name="source_code" id="busFromCode">
            <div id="busFromCityList" class="card" style="position: absolute; width: 95%; max-height: 150px; overflow-y: scroll; display: none;"></div>
        </div>

        <!-- Destination City -->
        <div class="mb-3 col-md-3">
            <div class="date-caption">To</div>
            <input type="text" class="form-control rounded-0 py-3" name="destination_city" id="busToCity" placeholder="Enter Destination City" required>
            <input type="hidden" name="destination_code" id="busToCode">
            <div id="busToCityList" class="card" style="position: absolute; width: 95%; max-height: 150px; overflow-y: scroll; display: none;"></div>
        </div>

        <!-- Journey Date -->
        <div class="mb-3 col-md-3">
            <div class="date-caption">Journey Date</div>
            <input type="text" id="busJourneyDate" name="depart_date" class="form-control rounded-0 py-3 datepicker" placeholder="Select Journey Date" required>
        </div>

        <!-- Submit Button -->
        <div class="mb-3 col-md-3">
            <div class="date-caption" style="visibility: hidden">Search</div>
            <button type="submit" class="btn btn-warning w-100 rounded-0 py-3 fw-bold">Search Buses</button>
        </div>
    </div>
</form>
</div>

<!-- holiday booking  -->
          <div class="tab-pane fade mt-5 show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            {{-- holiday packages searches --}}
            <h4 class="mb-5" id="tour-title">Book Domestic and International Holiday Packages
            </h4>
            <hr class="searchline">
            <form action="{{ route('searchPackages') }}" method="GET">
              <div class="row">
                <div class="mb-3 col-md-4 holiday-search">
                  <div class="date-caption">Search Destination</div>
                  <input type="text" class="form-control rounded-0 py-3" name="searchDestination" id="searchDestination"
                    placeholder="Search Destination" required>
                  <div class="search-icon">
                    <i class="fa-solid fa-magnifying-glass"></i>
                  </div>
                  <div id="destinationList" class="card" style=" position: absolute;
                      width: 95%; max-height: 150px; overflow-y: scroll; display: none;">
                      </div>
                </div>
                <div class="mb-3 col-md-3">
                  <div class="date-caption">Select City</div>
                  <input type="text" class="form-control rounded-0 py-3" name="searchCity" id="searchCity"
                    placeholder="Select City">
                  <div id="cityList" class="list-group mt-2" style="position: absolute;
                                width: 23%; max-height: 150px; overflow-y: scroll;"></div>
                </div>
                <div class="mb-3 col-md-3">
                  <div class="date-caption">Travel Date</div>
                  <input type="text" id="datepicker" name="travel_date" class="form-control rounded-0 py-3">
                </div>
                <div class="mb-3 col-md-2">
                  <div class="date-caption" style="visibility: hidden">Search</div>
                  <button type="submit" class="btn btn-warning w-100 rounded-0 py-3 fw-bold tourbuttonsearch">Search</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- <div class="container-fluid booking">
    <div class="row">
      <div class="col-md-6 m-auto py-3 shadow">
        <ul class="nav nav-pills justify-content-md-center mb-3 mobile_tabs_button" id="pills-tab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active bg-info text-dark fw-bold rounded-start-pill" id="pills-home-tab"
              data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
              aria-selected="true">TOUR PACKAGES</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link bg-danger text-white rounded-end-pill" id="pills-profile-tab" data-bs-toggle="pill"
              data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
              aria-selected="true">TOP DESTINATIONS</button>
          </li>
        </ul>

        <div class="tab-content" id="pills-tabContent" style="margin-top: -5px;">
          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
            tabindex="0">
            <div class="input-group mobile_tabs mb-3">
              <input type="text" class="form-control py-3 rounded-start-pill " aria-describedby="button-addon2"
                placeholder="Search : Delhi, Agra, Jaipur etc">
              <select class="form-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                <option selected>No. Of Nights</option>
                <option value="1">2 Days 1 Nights</option>
                <option value="2">3 Days 2 Nights</option>
                <option value="3">4 Days 3 Nights</option>
              </select>
              <button class="btn btn-warning rounded-end-pill px-4" type="submit"
                onclick="alert('Wait')">Search</button>
            </div>
          </div>
          <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
            tabindex="0">
            <div class="input-group  mobile_tabs mb-3">
              <input type="text" class="form-control py-3 rounded-start-pill" aria-describedby="button-addon2"
                placeholder="Example : Delhi, Agra, Jaipur etc">

              <input type="text" class="form-control py-3" placeholder="No. Of Nights (optional)"
                aria-describedby="button-addon2">

              <button class="btn btn-warning rounded-end-pill px-4" type="button">Search</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  </div> --}}
</section>
{{-- Tour places --}}
<section class="tour-places mt-5 mb-5">
  <div class="container">
    <h2 class="border-start border-4 mb-5 border-warning px-2" style="font-weight: 400;">Best <span
        style="font-size: 30px; font-weight:bold;">Tourist Places</span> to Visit in the <span
        style="font-size: 30px; font-weight:bold;">India</span></h2>   
    <div class="row">
      <div class="swiper mySwiper best-places px-2">
        <div class="swiper-wrapper">
          @foreach ($destinations as $item)
          @if($item->status == 1)
          <div class="swiper-slide item">
            <a href="{{ url('holidays/' . $item->slug) }}">

              <img src="{{ asset('uploads/destination/' .$item->photo) }}" class="w-100" alt="">
              <div class="strip">
                <h5>{{ $item->state_name }}</h5>
              </div>
            </a>
          </div>
          @endif

          @endforeach
        </div>

      </div>

    </div>
  </div>
</section>

<section id="tour-places" class="tour-places tour-category mt-5 mb-5">
  <div class="container">
    <h2 class="border-start border-4 mb-5 border-warning px-2" style="font-weight: 400;">Wonderful Place For You<span
        style="font-size: 30px; font-weight:bold;"> Tour Categories</span> </h2>
    
    <div class="row">

      <div class="swiper mySwipercategory best-places px-2">
        <div class="swiper-wrapper">
          @foreach($tourTypes as $tourType)
          <div class="swiper-slide item">
            @php
            $slug = Illuminate\Support\Str::slug($tourType->name);
            @endphp

            <a href="{{ url('tour-category', $slug)}}" class="text-decoration-none text-dark">

              @if($tourType->packages->isNotEmpty())
              <img src="{{ asset('uploads/packages/' . $tourType->packages->first()->photo) }}"
                alt="{{ $tourType->name }}">
              @endif
              <div class="strip">
                <h5>{{ $tourType->name }}</h5>
            </a>
          </div>
        </div>
        @endforeach

      </div>
    </div>
  </div>
  </div>
</section>

<section class="tripPlan">
  <div class="container">
    <div class="row">
      <div class="col-xl-6">
        <div class="img-box3">
          <div class="img1"><img src="assets/img/normal/about_3_1.jpg" alt="About"></div>
          <div class="img2 movingX"><img src="assets/img/tour/tour_2_4.jpg" alt="About"></div>

        </div>
      </div>
      <div class="col-xl-6 trip-descriptions">
        <div class="ps-xl-4">
          <div class="title-area mb-20 pe-xxl-5 me-xxl-5">
            <span class="sub-title style1">Let’s Go
              Together</span>
            <h2 class="sec-title mb-20 pe-xl-5 me-xl-5 heading">Plan Your Dream Trip with Us</h2>
          </div>
          <p class="sec-text mb-30">At <strong>Make My Bharat Yatra Pvt. Ltd.,</strong> we believe that every journey should be memorable. Whether it's exploring exotic destinations or enjoying a peaceful retreat, we're here to ensure your trip is one-of-a-kind. Let us take care of all the details while you focus on creating unforgettable memories.</p>
          <div class="about-item-wrap">
            <div class="about-item style2">
              <div class="about-item_img"><img src="assets/img/icon/about_1_1.svg" alt=""></div>
              <div class="about-item_centent">
                <h5 class="box-title">Exclusive Trip</h5>
                <p class="about-item_text">Experience unique, handpicked tour packages designed just for you. Our expert team ensures you get the most out of every destination.</p>
              </div>
            </div>
            <div class="about-item style2">
              <div class="about-item_img"><img src="assets/img/icon/about_1_2.svg" alt=""></div>
              <div class="about-item_centent">
                <h5 class="box-title">Safety First Always</h5>
                <p class="about-item_text">Your safety is our top priority. We follow stringent safety standards to ensure a secure and worry-free travel experience.</p>
              </div>
            </div>
            <div class="about-item style2">
              <div class="about-item_img"><img src="assets/img/icon/about_1_3.svg" alt=""></div>
              <div class="about-item_centent">
                <h5 class="box-title">Professional Guide</h5>
                <p class="about-item_text">Our knowledgeable and friendly guides are here to enhance your travel with deep insights, ensuring you don’t miss out on any hidden gems.</p>
              </div>
            </div>
          </div>
          <div class="mt-35"><a href="{{ route('aboutUs')}}" class="btn btn-warning rounded-pill py-3 px-4 mt-3 fw-semibold">Learn More <i
                class="fa-solid fa-arrow-right"></i></a></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="holiday-packages">
  <div class="container">
    <h3 class="border-start border-4 border-warning px-3 mb-4">Best Selling India
      Holiday Packages</h3>
    <div class="swiper mySwiperHoliday  best-places">
      <div class="swiper-wrapper shadow">
        @if ($tourpackages->count() > 0)
        @foreach ($tourpackages as $item)
        <div class="swiper-slide holiday-packages-swiper mt-3">
          <div class="card">
            <div class="card-body items p-0">
              @php
              $discount = (($item->ragular_price - $item->offer_price) / $item->ragular_price) * 100;
              @endphp
              <a href="{{ url('holiday-packages', $item->slug)}}">
                <img src="{{asset('uploads/packages/'.$item->photo)}}" class="w-100" alt="{{$item->package_name}}">
                <div class="recommended under-checkbox">{{ round($discount, 2) }}% OFF<span></span></div>
                <div class="duration">
                  <div class="duration-days">
                    <small style="font-size: 14px;
                 font-weight: 700;"> <i class="fa-solid fa-calendar-days"></i> {{$item->duration}}</small>
                  </div>
                  <div class="features">
                    <i class="fa-solid fa-hotel"></i>
                    <i class="fa-solid fa-car"></i>
                    <i class="fa-solid fa-utensils"></i>
                  </div>
                </div>
              </a>
            </div>
            <div class="card-footer py-3 bg-white">
              <div class="desc">
             <h5 class="title"><a href="{{ url('holiday-packages', $item->slug)}}" class="title text-decoration-none">
                    {{ \Illuminate\Support\Str::limit($item->package_name, 32, '...') }}</a> </h5>
                <p class="sub-title fs-5 text-secondary">{{$item->destination->destination_name}}</p>
                <p class="sub-titles">Starting From</p>
                <span class="price">
                  <span>₹{{ number_format($item->offer_price) }}</span>
                  <div class="item-center">
                  <del>{{ number_format($item->ragular_price) }} /-</del>
                  <span class="person"> per person</span>
                  <a href="{{ url('holiday-packages', $item->slug)}}" 
                   style="display: inline-block; background-color: #ff9800; margin: 0 0 0 240px; color: white; text-decoration: none; 
                   padding: 10px 20px; font-size: 16px; font-weight: 600; border-radius: 5px; 
                   box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease;">
                   Details
                  </a>
                  </div>
                </span> 
              </div>   
            </div>
          </div>
        </div>
        @endforeach
        @endif
      </div>
    </div>
  </div>
  </div>
</section>

{{-- <section class="best-destination mt-5">
  <div class="container">

   
    <div class="row">

    </div>
  </div>

</section> --}}

<section class="bd-offer-area py-5 section-space-bottom">
  <div class="container">
    <h3 class="border-start border-4 mb-4 border-warning px-3">Trending Destinations</h3>
      <div class="row gy-24">
        <div class="col-xl-4 col-lg-4 mb-3 col-md-12 ">
        <a href="{{ route('kashmir') }}"> <!-- Link to the 'kashmir' route -->
        <img src="{{ asset('assets/images/offer-2.webp') }}" class="shadow" width="100%" alt="">
    </a>
        </div>
          <div class="col-xl-4 col-lg-4  mb-3 col-md-12">
          <a href="#tour-places">
             <img src="{{ asset('assets/images/offer-1.webp')}}" class="shadow" width="100%" alt="">
          </a>
          </div>
         <div class="col-xl-4 col-lg-4  mb-3 col-md-12">
         <a href="{{ route('rishikesh') }}"> <!-- Link to the 'rishikesh' route -->
          <img src="{{ asset('assets/images/offer-3.webp')}}" class="shadow" width="100%" alt=""></a>
       </div>
         
      </div>
  </div>
</section>
@endsection
@section('scripts')


<script>
   // Date Pickers
   $('.datepicker').datepicker({
    format: 'd M, yyyy', // Format: 9 Dec, 2024
    autoclose: true,
    startDate: 'today'
  }).datepicker('setDate', new Date()); // Automatically set today's date;
  
</script>


<script>
  $(document).ready(function () {
    // CSRF Token setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
        
    });

    // City Search Similar to Destination Search
    function fetchAllCities() { 
    console.log("Fetching all cities...");
    $.ajax({
        url: "/fetch-all-cities", // Change this to URL instead of route()
        method: "GET",
        success: function (data) {
            console.log("Cities fetched successfully:", data);

            if (data.data && data.data.length > 0) {
                $('#busFromCityList').empty();
                $.each(data.data, function (index, city) {
                    const cityHTML = `
                        <div class="list-group-item" style="cursor: pointer;" data-id="${city.id}">
                            <i class="fa-solid fa-location-dot"></i> ${city.city_name}
                        </div>`;
                    $('#busFromCityList').append(cityHTML);
                });

                // Click handler for dynamically created list items
                $('#busFromCityList .list-group-item').on('click', function () {
                    const selectedValue = $(this).text();
                    $('#busFromCity').val(selectedValue);
                    $('#busFromCityList').hide();
                });

            } else {
                $('#busFromCityList').html('<div class="list-group-item">No cities found</div>');
            }
        },
        error: function (xhr) {
            console.error("Error fetching cities:", xhr.responseText);
        },
    });
}

// Show dropdowns and fetch data on input focus
$('#searchCity').on('focus', function () {
    fetchAllCities();
    $('#cityList').show();
});

$('#carPickupLocation').on('focus', function () {
    fetchAllCities();
    $('#carPickupLocationList').show();
});

$('#carDropoffLocation').on('focus', function () {
    fetchAllCities();
    $('#carDropoffLocationList').show();
});

$('#busFromCity').on('focus', function () {
    fetchAllCities();
    $('#busFromCityList').show();
});

$('#busToCity').on('focus', function () {
    fetchAllCities();
    $('#busToCityList').show();
});
$('#flightToCity').on('focus', function () {
    fetchAllCities();
    $('#flightToCityList').show();
});
$('#flightFromCity').on('focus', function () {
    fetchAllCities();
    $('#flightFromCityList').show();
});
$('#hotelSearchCity').on('focus', function () {
    fetchAllCities();
    $('#hotelCityList').show();
});

// Hide dropdowns when clicking outside
$(document).on('click', function (e) {
    if (!$(e.target).closest('#searchCity, #cityList, #carPickupLocation, #carPickupLocationList, #carDropoffLocation, #carDropoffLocationList, #busFromCity, #busFromCityList, #busToCity, #busToCityList,#flightToCity,#flightToCityList,#flightFromCity,#flightFromCityList,#hotelSearchCity,#hotelCityList').length) {
        $('#cityList, #carPickupLocationList, #carDropoffLocationList, #busFromCityList, #busToCityList,#flightToCityList,#flightFromCityList,#hotelCityList').hide();
    }
});
    // Search functionality when typing in the searchCity input
    $('#searchCity').on('keyup', function () {
        var query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: "{{ route('search.cities') }}", //  route to search cities
                method: "GET",
                data: { query: query },
                success: function (data) {
                    $('#cityList').empty();
                    if (data.length > 0) {
                        $.each(data, function (index, city) {
                            $('#cityList').append(
                                `<div class="list-group-item" style="cursor: pointer;" data-id="${city.id}">
                                    <i class="fa-solid fa-location-dot"></i> ${city.city_name}
                                 </div>`
                            );
                        });

                        // Add click handler for cities
                        $('#cityList .list-group-item').on('click', function () {
                            var selectedValue = $(this).text();
                            $('#searchCity').val(selectedValue);
                            $('#cityList').hide();
                        });
                    } else {
                        $('#cityList').append(`<div class="list-group-item">No results found</div>`);
                    }
                }
            });
        } else {
            $('#cityList').empty();
            fetchAllCities(); // Show all cities if search is cleared
        }
    });
    

    // Fetch states
    function fetchAllStates() {
        console.log("Fetching all states...");
        $.ajax({
            url: "{{ route('fetch.all.states') }}", // Laravel route to get all states
            method: "GET",
            success: function (data) {
                console.log("States fetched successfully:", data);
                $('#destinationList').empty(); // Clear previous data
                if (data.length > 0) {
                    $.each(data, function (index, state) {
                        $('#destinationList').append(
                            `<div class="list-group-item" style="cursor: pointer;" data-id="${state.id}">
                                <i class="fa-solid fa-location-dot"></i> ${state.destination_name}
                             </div>`
                        );
                    });

                    // Add click handler for states
                    $('#destinationList .list-group-item').on('click', function () {
                        var selectedStateId = $(this).data('id');
                        var selectedValue = $(this).text();
                        $('#searchDestination').val(selectedValue); // Set selected state
                        $('#destinationList').hide(); // Hide list after selection
                        fetchCities(selectedStateId); // Fetch cities for the selected state
                    });
                } else {
                    $('#destinationList').append(`<div class="list-group-item">No states found</div>`);
                }
            },
            error: function (xhr) {
                console.error("Error fetching states:", xhr.responseText);
                
            },
        });
    }

    // Search functionality for destination input (state)
    $('#searchDestination').on('keyup', function () {
        var query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: "{{ route('search.destination') }}", // Laravel route to search destinations
                method: 'GET',
                data: { query: query },
                success: function (data) {
                    $('#destinationList').empty();
                    if (data.length > 0) {
                        $.each(data, function (index, destination) {
                            $('#destinationList').append(
                                `<div class="list-group-item" style="cursor: pointer;" data-id="${destination.id}">
                                    <i class="fa-solid fa-location-dot"></i> ${destination.destination_name}
                                 </div>`
                            );
                        });

                        // Add click handler for destinations
                        $('#destinationList .list-group-item').on('click', function () {
                            var selectedStateId = $(this).data('id');
                            var selectedValue = $(this).text();
                            $('#searchDestination').val(selectedValue);
                            $('#destinationList').hide();
                            fetchCities(selectedStateId); // Fetch cities based on selected state
                        });
                    } else {
                        $('#destinationList').append(`<div class="list-group-item">No results found</div>`);
                    }
                }
            });
        } else {
            $('#destinationList').empty(); // Clear the results if input is cleared
        }
    });


    document.getElementById('busSearchForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        const formData = new FormData(this);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        console.log('Search Buses Request Data:', data);

        fetch('{{ route('buses.search') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(responseData => {
            console.log('Search Buses Response:', responseData);
            alert(responseData.message);
        })
        .catch(error => console.error('Error:', error));
    });

    
    

    $(document).ready(function () {
    // Fetch cities for autocomplete
    function fetchCities(input, list) {
        let city = $(input).val();
        if (city.length > 2) {
            $.ajax({
                url: "{{ route('autocomplete.cities') }}",
                method: 'GET',
                data: { query: city },
                success: function(response) {
                    $(list).empty().show();
                    response.forEach(city => {
                        $(list).append(
                            `<div class="city-option" data-code="${city.code}">${city.city_name}</div>`
                        );
                    });
                },
                error: function(xhr) {
                    console.error("Error fetching cities:", xhr.responseText);
                }
            });
        }
    }

    // Handle input for source city
    $('#busFromCity'). on('input', function() {
        fetchCities(this, '#busFromCityList');
    });

    // Handle input for destination city
    $('#busToCity').on('input', function() {
        fetchCities(this, '#busToCityList');
    });

    // Select city from the list
    $(document).on('click', '.city-option', function() {
        const cityName = $(this).text();
        const cityCode = $(this).data('code');
        if ($(this).closest('#busFromCityList').length) {
            $('#busFromCity').val(cityName);
            $('#busFromCode').val(cityCode); // Set the hidden input for source city
            $('#busFromCityList').hide();
        } else if ($(this).closest('#busToCityList').length) {
            $('#busToCity').val(cityName);
            $('#busToCode').val(cityCode); // Set the hidden input for destination city
            $('#busToCityList').hide();
        }
    });

    // Hide dropdowns when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#busFromCity, #busFromCityList, #busToCity, #busToCityList').length) {
            $('#busFromCityList, #busToCityList').hide();
        }
    });
});








    // Fetch cities based on selected state
    function fetchCities(stateId) {
        $.ajax({
            url: "{{ route('search.cities') }}", // Laravel route to get cities by state
            method: 'GET',
            data: { state_id: stateId },
            success: function (data) {
                $('#cityList').empty(); // Clear previous data
                if (data.length > 0) {
                    $.each(data, function (index, city) {
                        $('#cityList').append(
                            `<div class="list-group-item">
                                <i class="fa-solid fa-location-dot"></i> ${city.city_name}
                             </div>`
                        );
                    });

                    // Click event for selecting city
                    $('#cityList .list-group-item').on('click', function () {
                        var selectedCity = $(this).text();
                        $('#searchCity').val(selectedCity);
                        $('#cityList').empty(); // Clear city list after selection
                    });
                } else {
                    $('#cityList').append(`<div class="list-group-item">No results found</div>`);
                }
            }
        });
    }

    // Show state list when the input is focused
    $('#searchDestination').on('focus', function () {
        fetchAllStates();
        $('#destinationList').show();
    });

    // Hide state/city list if clicked outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#searchDestination, #destinationList, #searchCity, #cityList').length) {
            $('#destinationList').hide();
            $('#cityList').hide();
        }
    });
  });
</script>

@endsection