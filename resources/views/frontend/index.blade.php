<!-- Include jQuery from CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Include Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@extends('frontend.layouts.master')
@section('content')
@section('styles')
<!-- Include Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
<style>
.flatpickr-calendar {
  font-family: 'Arial', sans-serif;
  border: 1px solid #ccc;
}

.flatpickr-day {
  padding: 8px;
}
.city-option {
    display: flex;
    align-items: center;
    gap: 8px;
}

.country-code {
    color: #666;
    font-size: 0.9em;
}
</style>
@endsection

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
          <!-- <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
            <p>Comming Soon!</p>
          </div> -->
          <!-- // hotel booking -->



          <div class="tab-content" id="myTabContent">

  <!-- Hotel Booking -->
  <div class="tab-pane fade mt-5" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <h4 class="mb-5" id="hotel-title">Book Hotels in India</h4>
    <hr class="searchline">
    <form id="hotelSearchForm">
        <div class="row">
            <!-- City Input -->
            <div class="mb-3 col-md-3 hotel-search">
                <div class="date-caption">Enter City</div>
                <input type="text" class="form-control rounded-0 py-3" name="CityName" id="hotelSearchCity" placeholder="Enter City Name" required autocomplete="off" style="text-align: center; width: 100%;" >
                <input type="hidden" name="CityId" id="cityIdInput" value="">
                <div id="hotelSearchCityList" class="card" style="position: absolute; width: 23%; max-height: 150px; overflow-y: scroll;"></div>
            </div>

            <!-- Check-in Date -->
            <div class="mb-3 col-md-2">
    <div class="date-caption">Check-in Date</div>
    <input type="text" id="checkinDatepicker" name="CheckInDate" class="form-control rounded-0 py-3 datepicker" placeholder="Select Check-in Date" required style="text-align: center;">
</div>

            <!-- Number of Nights -->
            <div class="mb-3 col-md-2">
                <div class="date-caption">No. of Nights</div>
                <input type="number" name="NoOfNights" class="form-control rounded-0 py-3" placeholder="Enter No. of Nights" required style="text-align: center;">
            </div>

            <div class="mb-3 col-md-3">
    <div class="date-caption">Room & Guests</div>
    <div class="dropdown">
        <button
            class="btn btn-outline-secondary dropdown-toggle w-100 rounded-0 py-3"
            type="button"
            id="roomGuestsDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            style="background-color: white; color: #6c757d; border-color: #ced4da;"
        >
            1 Room, 2 Adults, 0 Children
        </button>
        <ul class="dropdown-menu p-3" aria-labelledby="roomGuestsDropdown" style="width: 100%; max-width: 300px;">
            <li class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="noOfRooms" class="form-label mb-0">Rooms</label>
                    <select id="noOfRooms" name="NoOfRooms" class="form-select w-auto" onchange="updateRoomGuestsTitle()">
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
            </li>
            <li class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="noOfAdults" class="form-label mb-0">Adults</label>
                    <select id="noOfAdults" name="RoomGuests[0][NoOfAdults]" class="form-select w-auto" onchange="updateRoomGuestsTitle()">
                        <option value="1">1</option>
                        <option value="2" selected>2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
            </li>
            <li class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="noOfChildren" class="form-label mb-0">Children</label>
                    <select id="noOfChildren" name="RoomGuests[0][NoOfChild]" class="form-select w-auto" onchange="handleChildrenChange()">
                        <option value="0" selected>0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            </li>
            <li>
            <div id="childAgesContainer" class="mt-3" style="display: none;">
    <label class="form-label" style="font-size: 16px; font-weight: bold; color: #333;">Child Ages</label>
    <div id="childAgesInputs" class="d-flex flex-column gap-2">
        <!-- Child age inputs will be dynamically added here -->
    </div>
</div>

            </li>
        </ul>
    </div>
</div>
            <!-- Guest Nationality -->
            <div class="mb-3 col-md-2">
                <div class="date-caption"style="text-align: center;">Nationality</div>
                <select id="nationalitySelect" class="form-control rounded-0 py-3 text-center">
                    <option value="" selected>Select Nationality</option>
                    <option value="IN" data-nationality="Indian">INDIA</option>
                    <option value="US" data-nationality="American">American</option>
                    <option value="GB" data-nationality="British">British</option>
                    <option value="CA" data-nationality="Canadian">Canadian</option>
                </select>
            </div>

            <input type="hidden" name="CountryCode" id="countryCodeInput" value="">
            <input type="hidden" name="SelectedNationality" id="hiddenNationality" value="">

            <!-- Search Button -->
            <div class="mb-3 col-md-2">
                <div class="date-caption" style="visibility: hidden">Search</div>
                <button type="button" class="btn item-center btn-warning w-100 rounded-0 py-3 fw-bold hotelbuttonsearch" id="searchButton">Search</button>
            </div>
        </div>
    </form>
</div>


<div class="tab-pane fade mt-5" id="flight" role="tabpanel" aria-labelledby="home-tab">
    <h4 class="mb-5" id="flight-title">Book Flights</h4>
    <hr class="searchline">
    
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
        <div class="mb-2 col-md-2">
    <div class="date-caption">From</div>
    <input type="text" class="form-control rounded-0 py-3" id="flightFromCity" placeholder="Enter Departure City" required>
    <!-- Note: removed 'name' attribute from display input and added it to hidden input -->
    <input type="hidden" id="flightFromCityCode" name="origin" required>
    <div id="flightFromCityList" class="card" style="position: absolute; width: 23%; max-height: 150px; overflow-y: scroll;"></div>
</div>
            
<div class="mb-2 col-md-2">
    <div class="date-caption">To</div>
    <input type="text" class="form-control rounded-0 py-3" id="flightToCity" placeholder="Enter Destination City" required>
    <!-- Note: removed 'name' attribute from display input and added it to hidden input -->
    <input type="hidden" id="flightToCityCode" name="destination" required>
    <div id="flightToCityList" class="card" style="position: absolute; width: 23%; max-height: 150px; overflow-y: scroll;"></div>
</div>
            <div class="mb-2 col-md-2">
                <div class="date-caption">Departure Date</div>
                <input type="text" id="flightDepartureDate" name="departureDate"
                    class="form-control rounded-0 py-3 datepicker"
                    placeholder="Select Departure Date" required>
            </div>
            <div class="mb-2 col-md-2">
                <div class="date-caption">Return Date</div>
                <input type="text" id="flightReturnDate" name="returnDate"
                    class="form-control rounded-0 py-3 datepicker"
                    placeholder="Select Return Date">
            </div>
            <div class="mb-2 col-md-2">
    <div class="date-caption">Passengers</div>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="passengerDropdown" data-bs-toggle="dropdown">
            Passengers
        </button>
        <div class="dropdown-menu p-3" style="width: 250px;">
            <div class="mb-2">
                <label for="adultCount">Adults</label>
                <input type="number" 
                       id="adultCount"
                       name="adultCount" 
                       class="form-control" 
                       value="1" 
                       min="1" 
                       max="9">
            </div>
            <div class="mb-2">
                <label for="childCount">Children</label>
                <input type="number" 
                       id="childCount"
                       name="childCount" 
                       class="form-control" 
                       value="0" 
                       min="0" 
                       max="9">
            </div>
            <div class="mb-2">
                <label for="infantCount">Infants</label>
                <input type="number" 
                       id="infantCount"
                       name="infantCount" 
                       class="form-control" 
                       value="0" 
                       min="0" 
                       max="9">
            </div>
        </div>
    </div>
</div>
            <div class="mb-2 col-md-2">
                <div class="date-caption" style="visibility: hidden">Search</div>
                <button type="submit" id="flightSearch" class="btn btn-warning w-100 rounded-0 py-3 fw-bold">Search Flights</button>
            </div>
        </div>

      
    </form>
</div>



                        <!-- Car Booking -->
                        <div class="tab-pane fade mt-5" id="car" role="tabpanel" aria-labelledby="car-tab">
                            <h4 class="mb-5" id="car-title">Book Cars</h4>
                            <hr class="searchline">
                            <form action="{{ route('cars.index') }}" method="GET">
                                <div class="row">
                                    <div class="mb-3 col-md-3">
                                        <div class="date-caption">Pickup Location</div>
                                        <input type="text" class="form-control rounded-0 py-3" name="pickupLocation"
                                            id="carPickupLocation" placeholder="Enter Pickup Location" required>
                                        <input type="hidden" name="pickupLocationCode" id="carPickupLocationCode">
                                        <div id="carPickupLocationList" class="card"
                                            style="position: absolute; width: 23%; max-height: 150px; overflow-y: scroll;">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <div class="date-caption">Drop-off Location</div>
                                        <input type="text" class="form-control rounded-0 py-3" name="dropoffLocation"
                                            id="carDropoffLocation" placeholder="Enter Drop-off Location" required>
                                        <input type="hidden" name="dropoffLocationCode" id="carDropoffLocationCode">
                                        <div id="carDropoffLocationList" class="card"
                                            style="position: absolute; width: 23%; max-height: 150px; overflow-y: scroll;">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <div class="date-caption">Pickup Date</div>
                                        <input type="text" id="carPickupDate" name="pickup_date"
                                            class="form-control rounded-0 py-3 datepicker"
                                            placeholder="Select Pickup Date" required>
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <label>Trip Type</label>
                                        <select name="trip_type" id="carTripType" class="form-control rounded-0 py-3">
                                            <option value="0">One Way</option>
                                            <option value="1">Return</option>
                                            <option value="2">Local</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <div class="date-caption" style="visibility: hidden">Search</div>
                                        <button type="submit" class="btn btn-warning w-100 rounded-0 py-3 fw-bold">Search
                                            Cars</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Bus Booking -->
 <div class="tab-pane fade mt-5" id="bus" role="tabpanel" aria-labelledby="bus-tab">
  <h4 class="mb-5" id="bus-title">Book Bus Tickets</h4>
  <hr class="searchline">
  <!-- Bus Search Form -->
  <form action="{{ route('buses.search') }}" method="POST" id="busSearchForm">
    @csrf
    <div class="row">
        <!-- Source City -->
        <div class="mb-3 col-md-3">
            <div class="date-caption">From</div>
            <input type="text" class="form-control rounded-0 py-3" name="source_city" id="busFromCity" placeholder="Enter Departure City" required>
            <input type="hidden" name="source_code" id="busFromCode"> <!-- Hidden field to store source city code -->
            <div id="busFromCityList" class="card" style="position: absolute; width: 23%; max-height: 200px; overflow-y: scroll;"></div>
        </div>

        <!-- Destination City -->
        <div class="mb-3 col-md-3">
            <div class="date-caption">To</div>
            <input type="text" class="form-control rounded-0 py-3" name="destination_city" id="busToCity" placeholder="Enter Destination City" required>
            <input type="hidden" name="destination_code" id="busToCode"> <!-- Hidden field to store destination city code -->
            <div id="busToCityList" class="card" style="position: absolute; width: 23%; max-height: 150px; overflow-y: scroll;"></div>
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


<!-- Include Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- <script>
  // Date Pickers
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd', // Format: 2024-12-17
    autoclose: true,
    startDate: 'today'
  }).datepicker('setDate', new Date()); // Automatically set today's date
  </script>
   -->


   <script>
    document.addEventListener('DOMContentLoaded', function() {
    updateRoomGuestsTitle();
});

function updateRoomGuestsTitle() {
    const rooms = document.getElementById("noOfRooms").value;
    const adults = document.getElementById("noOfAdults").value;
    const children = document.getElementById("noOfChildren").value;

    const title = `${rooms} Room${rooms > 1 ? "s" : ""}, ${adults} Adult${adults > 1 ? "s" : ""}, ${children} Child${children > 1 ? "ren" : ""}`;
    document.getElementById("roomGuestsDropdown").textContent = title;
}

function handleChildrenChange() {
    const childCount = parseInt(document.getElementById("noOfChildren").value);
    const container = document.getElementById("childAgesContainer");
    const inputsContainer = document.getElementById("childAgesInputs");
    
    // Update the title
    updateRoomGuestsTitle();
    
    // Show/hide the child ages container
    container.style.display = childCount > 0 ? "block" : "none";
    
    // Clear existing inputs
    inputsContainer.innerHTML = "";
    
    // Create age selectors for each child
    for (let i = 0; i < childCount; i++) {
        const ageSelector = document.createElement("div");
        ageSelector.className = "d-flex justify-content-between align-items-center";
        ageSelector.innerHTML = `
            <label class="form-label mb-0">Child ${i + 1} Age</label>
            <select name="RoomGuests[0][ChildAges][${i}]" class="form-select w-auto ms-2" onchange="updateRoomGuestsTitle()">
                ${generateAgeOptions()}
            </select>
        `;
        inputsContainer.appendChild(ageSelector);
    }
}

function generateAgeOptions() {
    let options = '';
    // Generate options for ages 0-12
    for (let i = 0; i <= 12; i++) {
        options += `<option value="${i}">${i} ${i === 1 ? 'year' : 'years'}</option>`;
    }
    return options;
}


    
  $(document).ready(function () {
    // CSRF Token setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        },
    });

    // Function to fetch all cities for autocomplete
    function fetchAllCities(inputField) {
        console.log("Fetching all cities...");
        $.ajax({
            url: "{{ route('fetch.all.cities') }}",
            method: "GET",
            success: function (response) {
                console.log("Cities fetched successfully:", response);
                const citiesList = $(inputField + 'List');
                citiesList.empty();

                if (response.status === 'success' && response.data && response.data.length > 0) {
                    response.data.forEach(city => {
                        const cityHTML = `
                            <div class="list-group-item" style="cursor: pointer;" 
                                 data-id="${city.CityId}">
                                <i class="fa-solid fa-location-dot"></i> 
                                ${city.CityName}
                            </div>`;
                        citiesList.append(cityHTML);
                    });

                    // Event handler for city selection
                    citiesList.find('.list-group-item').on('click', function () {
                        const selectedId = $(this).data('id'); // Get CityId from data-id attribute
                        const selectedValue = $(this).text().trim(); // Get City Name

                        // Update the input field with the selected city name
                        $(inputField).val(selectedValue).data('city-id', selectedId);
                        $('#cityIdInput').val(selectedId); // Store the CityId in the hidden input field

                        // Set the source_code or destination_code hidden field for bus
                        if (inputField === '#busFromCity') {
                            $('#busFromCode').val(selectedId); // Store CityId as source_code
                        } else if (inputField === '#busToCity') {
                            $('#busToCode').val(selectedId); // Store CityId as destination_code
                        }

                        citiesList.hide(); // Hide the dropdown list
                    });
                } else {
                    citiesList.html('<div class="list-group-item">No cities found</div>');
                }
            },
            error: function (xhr) {
                console.error("Error fetching cities:", xhr.responseText);
                $(inputField + 'List').html(
                    '<div class="list-group-item text-danger">Failed to load cities</div>'
                );
            }
        });
    }

    // Input field focus event handlers for bus city
    const cityInputsForBus = ['#busFromCity', '#busToCity'];

    cityInputsForBus.forEach(input => {
        $(input).on('focus', function () {
            fetchAllCities(input);
            $(input + 'List').show();
        });
    });

    // Input field focus event handlers for hotel city
    // const cityInputsForHotel = ['#hotelSearchCity'];

    // cityInputsForHotel.forEach(input => {
    //     $(input).on('focus', function () {
    //         fetchAllCities(input);
    //         $(input + 'List').show();
    //     });
    // });

    // Hide dropdowns when clicking outside
    $(document).on('click', function (e) {
        // Combine the city inputs for both bus and hotel
        const cityElements = [...cityInputsForBus, ...cityInputsForHotel].map(input => `${input}, ${input}List`).join(', ');

        // Check if the clicked target is outside of the city input fields and lists
        if (!$(e.target).closest(cityElements).length) {
            // Hide the city suggestion lists for both bus and hotel
            [...cityInputsForBus, ...cityInputsForHotel].forEach(input => {
                $(input + 'List').hide();
            });
        }
    });

    // Autocomplete functionality when typing in source and destination city inputs
    function fetchCities(input, list) {
        let city = $(input).val();
        if (city.length > 0) { 
            $.ajax({
                url: "{{ route('autocomplete.cities') }}",
                method: 'GET',
                data: { query: city },
                success: function (response) {
                    $(list).empty().show();
                    if (response.length > 0) {
                        response.forEach(city => {
                            $(list).append(
                                `<div class="city-option" data-cityid="${city.CityId}">${city.CityName}</div>`
                            );
                        });
                    } else {
                        $(list).append(`<div class="no-results">No cities found</div>`);
                    }
                },
                error: function (xhr) {
                    console.error("Error fetching cities:", xhr.responseText);
                }
            });
        } else {
            $(list).hide();
        }
    }

    // Handle input for source city
    $('#busFromCity').on('input', function () {
        fetchCities(this, '#busFromCityList');
    });

    // Handle input for destination city
    $('#busToCity').on('input', function () {
        fetchCities(this, '#busToCityList');
    });

    // Select city from the list
    $(document).on('click', '.city-option', function () {
        const cityName = $(this).text();
        const cityId = $(this).data('cityid'); 
        if ($(this).closest('#busFromCityList').length) {
            $('#busFromCity').val(cityName);
            $('#busFromCode').val(cityId); 
            $('#busFromCityList').hide();
        } else if ($(this).closest('#busToCityList').length) {
            $('#busToCity').val(cityName);  // Corrected here to use 'cityName'
            $('#busToCode').val(cityId); 
            $('#busToCityList').hide();
        }
    });

    // Hide dropdowns when clicking outside
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#busFromCity, #busFromCityList, #busToCity, #busToCityList').length) {
            $('#busFromCityList, #busToCityList').hide();
        }
    });

   // Hide dropdowns when pressing 'Esc' key
   $(document).on('keydown', function (e) {
        if (e.key === "Escape") {
            $('#busFromCityList, #busToCityList').hide();
        }
    });

    // Form submission without page refresh
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd', // Format: 2024-12-17
        autoclose: true,
        startDate: 'today',
    todayHighlight: true  // Highlights today's date

    }).datepicker('setDate', new Date()); // Automatically set today's date

    // Ensure the date is in the correct format before submitting the form
    $('#busSearchForm').on('submit', function (event) {
        event.preventDefault(); // Prevents default form submission

        // Ensure the date is in 'yyyy-mm-dd' format
        let formattedDate = $('#busJourneyDate').val();
    const dateParts = formattedDate.split('/'); // Handles MM/DD/YYYY if that's returned
    if (dateParts.length === 3) {
        formattedDate = `${dateParts[2]}-${dateParts[0].padStart(2, '0')}-${dateParts[1].padStart(2, '0')}`;
    }
        // Collect form data
        const data = {
            source_city: $('#busFromCity').val(),
            source_code: $('#busFromCode').val(),
            destination_city: $('#busToCity').val(),
            destination_code: $('#busToCode').val(),
            depart_date: formattedDate // Use the formatted date
        };

        console.log('Search Buses Request Data:', data);

        // Send the AJAX request
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
    console.log('API Response:', responseData); // <-- Add this line
    if (responseData.status) {
        sessionStorage.setItem('busSearchResults', JSON.stringify({
            buses: responseData.data, 
            searchParams: data,
            traceId: responseData.traceId
        }));
        window.location.href = "{{ route('bus') }}?source_city=" + encodeURIComponent(data.source_city) +
    "&destination_city=" + encodeURIComponent(data.destination_city) +
    "&depart_date=" + data.depart_date +
    "&trace_id=" + responseData.traceId;
    } else {
      toastr.error('No buses found in this route', 'Error');
    }
})
.catch(error => console.error('Error:', error));
    });
  });



  //  ****************************************************
  //                    HOTEL SEARCH
  //  ****************************************************




  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Accept': 'application/json'
    },
});

// Function to fetch all hotel cities
function fetchHotelAllCities(inputField, listId) {
    console.log("Fetching hotel cities...");
    $.ajax({
        url: "{{ route('fetch.hotel.cities') }}",
        method: "GET",
        success: function (response) {
            console.log("Cities fetched successfully:", response);
            const list = $(listId);
            list.empty();

            if (response.status === 'success' && response.data && response.data.length > 0) {
                response.data.forEach(city => {
                    const cityHTML = `
                        <div class="list-group-item city-option" style="cursor: pointer;" data-cityid="${city.cityid}">
                            <i class="fa-solid fa-location-dot"></i> 
                            ${city.Destination} 
                        </div>`;
                    list.append(cityHTML);
                });
                list.show();
            } else {
                list.html('<div class="list-group-item">No cities found</div>').show();
            }
        },
        error: function () {
            console.error("Error fetching hotel cities");
            $(listId).html('<div class="list-group-item text-danger">Failed to load cities</div>').show();
        }
    });
}

// Function to fetch cities based on user input (autocomplete)
function fetchHotelCities(inputField, listId) {
    const query = $(inputField).val().trim();

    if (query.length > 0) {
        $.ajax({
            url: "{{ route('autocomplete.hotelcities') }}",
            method: "GET",
            data: { query },
            success: function (response) {
                const list = $(listId);
                list.empty().show();

                if (response.data && response.data.length > 0) {
                    response.data.forEach(city => {
                        list.append(
                            `<div class="list-group-item city-option" data-cityid="${city.cityid}">
                                ${city.Destination} (${city.country})
                            </div>`
                        );
                    });
                } else {
                    list.append('<div class="list-group-item">No cities found</div>');
                }
            },
            error: function () {
                console.error("Error fetching hotel cities");
                $(listId).html('<div class="list-group-item text-danger">Failed to load cities</div>');
            }
        });
    } else {
        fetchHotelAllCities(inputField, listId); // Fetch all cities if input is cleared
    }
}

// Input field focus and input handlers
const cityInputConfig = [
    { input: '#hotelSearchCity', list: '#hotelSearchCityList', hidden: '#cityIdInput' }
];

cityInputConfig.forEach(config => {
    // Fetch all cities on input focus
    $(config.input).on('focus', function () {
        fetchHotelAllCities(config.input, config.list);
    });

    // Autocomplete based on user input
    $(config.input).on('input', function () {
        fetchHotelCities(config.input, config.list);
    });

    // Handle city selection from the dropdown
    $(document).on('click', `${config.list} .city-option`, function () {
        const cityName = $(this).data('cityname');
        const countryCode = $(this).data('countrycode');
        const cityId = $(this).data('cityid');
        
        // Set the display value with city and country
        $(config.input).val(`${cityName} (${countryCode})`);
        $(config.hidden).val(cityId);
        $(config.list).hide();
    });
});

$(document).on('click', '.city-option', function() {
    const cityId = $(this).data('cityid');
    const cityText = $(this).text().trim();
    
    $('#hotelSearchCity').val(cityText);
    $('#cityIdInput').val(cityId);
    $('#hotelSearchCityList').hide();
});

// Hide dropdowns on outside click or Escape key
$(document).on('click keydown', function (e) {
    if (e.type === "keydown" && e.key !== "Escape") return;

    cityInputConfig.forEach(config => {
        $(config.list).hide();
    });
});




 
 document.addEventListener('DOMContentLoaded', function () {
    // Initialize datepicker with API-compatible format
    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy', // Changed to MM/DD/YYYY format
        autoclose: true,
        startDate: 'today',
        todayHighlight: true,
    }).datepicker('setDate', new Date());

    // Handle search form submission
    const searchButton = document.getElementById('searchButton');
    if (searchButton) {
        searchButton.addEventListener('click', function (event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('hotelSearchForm'));
            const data = Object.fromEntries(formData.entries());

            const [month, day, year] = data.CheckInDate.split('/');
            // Ensure month and day are padded with leading zeros if needed
            const paddedMonth = month.padStart(2, '0');
            const paddedDay = day.padStart(2, '0');
            const formattedCheckInDate = `${year}-${paddedMonth}-${paddedDay}`;


            // Get all child ages
        const childCount = parseInt(data["RoomGuests[0][NoOfChild]"]);
        const childAges = [];
        
        // Only collect ages if there are children
        if (childCount > 0) {
            for (let i = 0; i < childCount; i++) {
                const ageSelect = document.querySelector(`select[name="RoomGuests[0][ChildAges][${i}]"]`);
                if (ageSelect) {
                    childAges.push(parseInt(ageSelect.value));
                }
            }
        }


        function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}

// Example usage - Get cookie values
console.log('NoOfChildren:', getCookie('noOfChildren'));
console.log('ChildAges:', getCookie('childAges'));
console.log('NoOfAdults:', getCookie('noOfAdults'));

       
        // Get the selected number of children
const noOfChildrenSelect = document.querySelector('select[name="RoomGuests[0][NoOfChild]"]');
const selectedChildCount = noOfChildrenSelect ? noOfChildrenSelect.value : '0';

// Set cookies with expiry time (e.g., 7 days)
document.cookie = `noOfChildren=${selectedChildCount}; path=/; max-age=604800`;
document.cookie = `childAges=${childAges}; path=/; max-age=604800`;
document.cookie = `noOfAdults=${String(data["RoomGuests[0][NoOfAdults]"])}; path=/; max-age=604800`;



// Check specific cookies
console.log('Cookies:', document.cookie);




            const payload = {
                ClientId: "180189",
                UserName: "MakeMy91",
                Password: "MakeMy@910",
                EndUserIp: "1.1.1.1",
                BookingMode: "5",
                CheckInDate: formattedCheckInDate,
                NoOfNights: String(data.NoOfNights),
                CityId: data.CityId,
                CountryCode: data.CountryCode || '',
                GuestNationality: document.getElementById("nationalitySelect").value,
                PreferredCurrency: "INR",
                NoOfRooms: String(data.NoOfRooms),
                RoomGuests: [
                    {
                        NoOfAdults: String(data["RoomGuests[0][NoOfAdults]"]),
                        NoOfChild: String(data["RoomGuests[0][NoOfChild]"]),
                        ChildAge:  childAges,
                    },
                ],
            };

            fetch('/search-hotel', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    body: JSON.stringify(payload),
})
.then(response => {
    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
})
.then(data => {
    if (data.status === 'success') {
      console.log('Search results:', data.results);
      console.log('TraceId:', data.traceId); // Debug log
        sessionStorage.setItem('searchResults', JSON.stringify(data.results));
        sessionStorage.setItem('traceId', data.traceId);
        sessionStorage.setItem('searchParams', JSON.stringify(payload));
        const hotelCodes = data.results.map(result => result.HotelCode);
            console.log('Hotel Codes:', hotelCodes);

            // Optional: Store HotelCodes as a separate sessionStorage item
            sessionStorage.setItem('hotelCodes', JSON.stringify(hotelCodes));
        window.location.href = '/search-result';
    } else {
        console.error('API Error:', data.message);
        alert(data.message || 'No results found. Please try different search criteria.');
    }
})
.catch(error => {
    console.error('Error:', error);
    alert('An error occurred while searching. Please try again later.');
});
        });
    }
});

     // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // +                  Car Script                                   +
        // +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#carPickupDate", {
                dateFormat: "d/m/Y",
                minDate: "today",
                defaultDate: 'today'
            });
        });

        function fetchCities(inputId, suggestionId) {
            const query = document.getElementById(inputId).value;
            if (query.length < 2) {
                document.getElementById(suggestionId).innerHTML = '';
                return;
            }
            fetch('{{ route('fetchCities') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        query
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const suggestionList = document.getElementById(suggestionId);
                    suggestionList.innerHTML = '';
                    data.forEach(city => {
                        const option = document.createElement('div');
                        option.className = 'suggestion-item';
                        option.textContent =
                        `${city.caoncitlst_city_name}, ${city.caoncitlst_id}`; // Display city name and code
                        option.onclick = () => {
                            document.getElementById(inputId).value = city.caoncitlst_city_name;
                            document.getElementById(inputId === 'carPickupLocation' ?
                                    'carPickupLocationCode' : 'carDropoffLocationCode').value = city
                                .caoncitlst_id; // Set city code
                            suggestionList.innerHTML = '';
                        };
                        suggestionList.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching cities:', error));
        }

        document.getElementById('carPickupLocation').addEventListener('input', () => {
            fetchCities('carPickupLocation', 'carPickupLocationList');
        });
        document.getElementById('carDropoffLocation').addEventListener('input', () => {
            fetchCities('carDropoffLocation', 'carDropoffLocationList');
        });


        















        $(document).ready(function() {
    // Airport search functionality
    function initializeAirportSearch() {
        const searchConfig = [
            { inputId: '#flightFromCity', listId: '#flightFromCityList' },
            { inputId: '#flightToCity', listId: '#flightToCityList' }
        ];

        searchConfig.forEach(config => {
            const input = $(config.inputId);
            const list = $(config.listId);
            let searchTimeout;

            // Input event handler with debounce
            input.on('input', function() {
                clearTimeout(searchTimeout);
                const query = $(this).val();
                
                if (query.length < 2) {
                    list.fadeOut().empty();
                    return;
                }

                searchTimeout = setTimeout(() => {
                    fetchAirports(query, list, input);
                }, 300);
            });

            // Close dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest(config.inputId).length && 
                    !$(e.target).closest(config.listId).length) {
                    list.fadeOut().empty();
                }
            });
        });
    }

    // Function to fetch airports from the server
    function fetchAirports(query, listElement, inputElement) {
        $.ajax({
            url: '/fetch-airports',
            method: 'GET',
            data: { query: query },
            beforeSend: function() {
                listElement.html('<div class="p-2">Loading...</div>').show();
            },
            success: function(response) {
                if (!response.length) {
                    listElement.html('<div class="p-2">No airports found</div>');
                    return;
                }

                const suggestions = response.map(airport => `
                    <a href="#" class="dropdown-item airport-option py-2" 
                       data-code="${airport.airport_code}"
                       data-name="${airport.airport_city_name} (${airport.airport_name}) (${airport.airport_code})">
                        <div class="d-flex align-items-center">
                            <div>
                                <div class="font-weight-bold">${airport.airport_city_name}</div>
                                <div class="small text-muted">${airport.airport_name}</div>
                            </div>
                            <div class="ml-auto">
                                <span class="badge badge-light">${airport.airport_code}</span>
                            </div>
                        </div>
                    </a>
                `).join('');

                listElement.html(suggestions).show();

                // Handle airport selection
                listElement.find('.airport-option').on('click', function(e) {
                    e.preventDefault();
                    const code = $(this).data('code');
                    const name = $(this).data('name');
                    
                    inputElement.val(name);
                    inputElement.attr('data-code', code);
                    listElement.fadeOut().empty();

                    // Trigger validation if needed
                    validateForm();
                });
            },
            error: function() {
                listElement.html('<div class="p-2 text-danger">Error fetching airports</div>');
            }
        });
    }

    // Form validation
    function validateForm() {
        const fromCity = $('#flightFromCity');
        const toCity = $('#flightToCity');
        
        // Basic validation
        if (fromCity.val() === toCity.val() && fromCity.val() !== '') {
            toCity.addClass('is-invalid');
            $('#sameCityError').show();
            return false;
        }
        
        toCity.removeClass('is-invalid');
        $('#sameCityError').hide();
        return true;
    }

    // Trip type handling
    function handleTripTypeChange() {
        const tripType = $('input[name="journeyType"]:checked').val();
        const returnDateField = $('#flightReturnDate');
        
        if (tripType === '1') { // One way
            returnDateField.prop('disabled', true).val('');
            returnDateField.closest('.mb-2').fadeOut();
        } else { // Round trip
            returnDateField.prop('disabled', false);
            returnDateField.closest('.mb-2').fadeIn();
        }
    }

    // Initialize all components
    initializeAirportSearch();
    
    // Set up event listeners
    $('input[name="journeyType"]').on('change', handleTripTypeChange);
    
    // Initialize trip type on page load
    handleTripTypeChange();

    // Form submission
    $('#flightSearchForm').on('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });
});

$(document).ready(function () {
    // Initialize datepicker with the correct format
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date()
    });

    // Airport search functionality
    function initializeAirportSearch() {
        const searchConfig = [
            {
                inputId: '#flightFromCity',
                codeInputId: '#flightFromCityCode',
                listId: '#flightFromCityList'
            },
            {
                inputId: '#flightToCity',
                codeInputId: '#flightToCityCode',
                listId: '#flightToCityList'
            }
        ];

        searchConfig.forEach(config => {
            const input = $(config.inputId);
            const codeInput = $(config.codeInputId);
            const list = $(config.listId);
            let searchTimeout;

            // Input event handler with debounce
            input.on('input', function () {
                clearTimeout(searchTimeout);
                const query = $(this).val();

                if (query.length < 2) {
                    list.fadeOut().empty();
                    return;
                }

                searchTimeout = setTimeout(() => {
                    fetchAirports(query, list, input, codeInput);
                }, 300);
            });

            // Close dropdown when clicking outside
            $(document).on('click', function (e) {
                if (!$(e.target).closest(config.inputId).length &&
                    !$(e.target).closest(config.listId).length) {
                    list.fadeOut().empty();
                }
            });
        });
    }

    // Function to fetch airports from the server
    function fetchAirports(query, listElement, inputElement, codeInputElement) {
        $.ajax({
            url: '/fetch-airports',
            method: 'GET',
            data: { query: query },
            beforeSend: function () {
                listElement.html('<div class="p-2">Loading...</div>').show();
            },
            success: function (response) {
                if (!response.length) {
                    listElement.html('<div class="p-2">No airports found</div>');
                    return;
                }

                const suggestions = response.map(airport => `
                    <a href="#" class="dropdown-item airport-option py-2" 
                       data-code="${airport.airport_code}"
                       data-name="${airport.airport_city_name} (${airport.airport_name}) (${airport.airport_code})">
                        <div class="d-flex align-items-center">
                            <div>
                                <div class="font-weight-bold">${airport.airport_city_name}</div>
                                <div class="small text-muted">${airport.airport_name}</div>
                            </div>
                            <div class="ml-auto">
                                <span class="badge badge-light">${airport.airport_code}</span>
                            </div>
                        </div>
                    </a>
                `).join('');

                listElement.html(suggestions).show();

                // Handle airport selection
                listElement.find('.airport-option').on('click', function (e) {
                    e.preventDefault();
                    const code = $(this).data('code');
                    const name = $(this).data('name');

                    inputElement.val(name);
                    codeInputElement.val(code); // Store the code in hidden input
                    listElement.fadeOut().empty();

                    validateForm();
                });
            },
            error: function () {
                listElement.html('<div class="p-2 text-danger">Error fetching airports</div>');
            }
        });
    }

    // Form validation
    function validateForm() {
        const fromCity = $('#flightFromCity');
        const toCity = $('#flightToCity');

        if (fromCity.val() === toCity.val() && fromCity.val() !== '') {
            toCity.addClass('is-invalid');
            $('#sameCityError').show();
            return false;
        }

        toCity.removeClass('is-invalid');
        $('#sameCityError').hide();
        return true;
    }

    // Trip type handling
    function handleTripTypeChange() {
        const tripType = $('input[name="journeyType"]:checked').val();
        const returnDateField = $('#flightReturnDate');

        if (tripType === '1') { // One way
            returnDateField.prop('disabled', true).val('');
            returnDateField.closest('.mb-2').fadeOut();
        } else { // Round trip
            returnDateField.prop('disabled', false);
            returnDateField.closest('.mb-2').fadeIn();
        }
    }

    // Form submission
    $('#flightSearchForm').on('submit', function (e) {
        e.preventDefault();

        function convertToISODate(dateString) {
        const [month, day, year] = dateString.split('/');
        return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
    }

    const adultCount = $('input[name="adultCount"]').val() || "1";
    const childCount = $('input[name="childCount"]').val() || "0";
    const infantCount = $('input[name="infantCount"]').val() || "0";

    const departureDate = convertToISODate($('#flightDepartureDate').val());
        const segments = [{
            Origin: $('#flightFromCityCode').val().toUpperCase(),
            Destination: $('#flightToCityCode').val().toUpperCase(),
            FlightCabinClass: parseInt($('#flightCabinClass').val()) || 1,
            PreferredDepartureTime: `${departureDate}T00:00:00`,
            PreferredArrivalTime: `${departureDate}T00:00:00`
        }];

        if ($('input[name="journeyType"]:checked').val() === '2') {
            const returnDate = $('#flightReturnDate').val();
            segments.push({
                Origin: $('#flightToCityCode').val().toUpperCase(),
                Destination: $('#flightFromCityCode').val().toUpperCase(),
                FlightCabinClass: parseInt($('#flightCabinClass').val()) || 1,
                PreferredDepartureTime: `${returnDate}T00:00:00`,
                PreferredArrivalTime: `${returnDate}T00:00:00`
            });
        }

        const payload = {
            EndUserIp: "1.1.1.1",
            ClientId: "180133",
            UserName: "MakeMy91",
            Password: "MakeMy@910",
            AdultCount: adultCount.toString(),
        ChildCount: childCount.toString(),
        InfantCount: infantCount.toString(),
            JourneyType: $('input[name="journeyType"]:checked').val(),
            FareType: "1",
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
    success: function (response) {
        if (response.success) {
            console.log('Flights:', response.results);

            console.log('Flight search results:', response.results);
        console.log('TraceId:', response.traceId);

        // Store response data in sessionStorage
        sessionStorage.setItem('flightSearchResults', JSON.stringify(response.results));
        sessionStorage.setItem('flightTraceId', response.traceId);
        sessionStorage.setItem('flightSearchParams', JSON.stringify(payload));

        // Optional: Add a log to confirm data is stored
        console.log('Stored in sessionStorage:');
        console.log('flightSearchResults:', sessionStorage.getItem('flightSearchResults'));
        console.log('flightTraceId:', sessionStorage.getItem('flightTraceId'));
        console.log('flightSearchParams:', sessionStorage.getItem('flightSearchParams'));
        window.location.href = '/flight';

 
            // Optional: Keep only the last 5 searches
        
        } else {
            alert(response.message || 'No flights found.');
        }
    },
    error: function (xhr) {
        console.error('Error:', xhr.responseJSON);
        alert(xhr.responseJSON?.message || 'An error occurred.');
    }
});
    });


    // Initialize components
    initializeAirportSearch();
    $('input[name="journeyType"]').on('change', handleTripTypeChange);
    handleTripTypeChange();
});

</script>


@endsection 