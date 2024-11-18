@extends('frontend.layouts.master')
@section('content')

<section class="hero">

  <div class="container">
    <div class="row">
      <div class="card search-engine-card py-5 px-4" style="position: relative">
        <ul class="nav nav-tabs border-0" style="position: absolute; top:0; left:1%; transform:translateY(-50%);"
          id="myTab" role="tablist">
          <!-- <li class="nav-item" role="presentation">
            <button class="nav-link px-4 shadow border-0" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
              type="button" role="tab" aria-controls="home" aria-selected="true">
              <i class="fa-solid fa-plane-departure d-block"></i>
              <small>Flighttt</small>
            </button>
          </li> -->
          <!-- <li class="nav-item" role="presentation">
            <button class="nav-link  px-4 shadow border-0" id="profile-tab" data-bs-toggle="tab"
              data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
              <i class="fa-solid fa-building d-block"></i>
              <small>Hotel</small>
            </button>
          </li> -->
          <li class="nav-item" role="presentation">
            <button class="nav-link active px-4 border-0 shadow" id="contact-tab" data-bs-toggle="tab"
              data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
              <i class="fa-solid fa-umbrella-beach d-block"></i>
              <small>Holidays</small>
            </button>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
            <p>Comming Soon!</p>
          </div>
          <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <p>Comming Soon!</p>
          </div>
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
              aria-selected="false">TOP DESTINATIONS</button>
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
                <option value="1">2 Days 1 Night</option>
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

<section class="tour-places tour-category mt-5 mb-5">
  <div class="container">
    <h2 class="border-start border-4 mb-5 border-warning px-2" style="font-weight: 400;">Wornderful Place For You<span
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

                  <del>{{ number_format($item->ragular_price) }} /-</del>
                  <span class="person"> per person</span>
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
          <img src="{{ asset('assets/images/offer-2.webp')}}" class="shadow" width="100%" alt="">
        </div>
          <div class="col-xl-4 col-lg-4  mb-3 col-md-12">
             <img src="{{ asset('assets/images/offer-1.webp')}}" class="shadow" width="100%" alt="">
          </div>
         <div class="col-xl-4 col-lg-4  mb-3 col-md-12">
          <img src="{{ asset('assets/images/offer-3.webp')}}" class="shadow" width="100%" alt="">
       </div>
         
      </div>
  </div>
</section>



@endsection



@section('scripts')
<script>
  $(document).ready(function () {
    // Fetch all states from the database on page load
    function fetchAllStates() {
      $.ajax({
        url: "{{ route('fetch.all.states') }}", // Laravel route to get all states
        method: "GET",
        success: function (data) {
          $('#destinationList').empty(); // Clear previous data



          $.each(data, function (index, state) {
            $('#destinationList').append('<div class="list-group-item" style="cursor: pointer;" data-id="' + state.id + '"> <i class="fa-solid fa-location-dot"></i> ' + state.destination_name + '</div>');
          });

          // Show the list by default
          $('#destinationList').show();

          var selectedStateId = null;

          // Handle selection from the list
          $('.list-group-item').on('click', function () {
             selectedStateId = $(this).data('id');
            var selectedValue = $(this).text(); // Get selected state
            $('#searchDestination').val(selectedValue); // Update the input field
            $('#destinationList').hide(); // Hide the list after selection

            // Fetch cities after selecting a state
            fetchCities(selectedStateId);
          });
    
         
           // city Keyup events
            $('#searchCity').on('focus', function(){

              console.log(selectedStateId);
              
            fetchCities(selectedStateId);
          });


        }
      });
    }


     
    // Search functionality when typing in the state input
    $('#searchDestination').on('keyup', function () {
      var query = $(this).val();
      if (query.length > 0) {
        $.ajax({
          url: "{{ route('search.destination') }}",
          method: 'GET',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: { query: query },
          success: function (data) {
            $('#destinationList').empty();
            if (data.length > 0) {
              $.each(data, function (index, destination) {
                $('#destinationList').append('<div class="list-group-item" style="cursor: pointer;" data-id="' + destination.id + '"> <i class="fa-solid fa-location-dot"></i> ' + destination.destination_name + '</div>');
              });

             
              // Add click event listener for each list item
              $('.list-group-item').on('click', function () {
                selectedStateId = $(this).data('id');
                var selectedValue = $(this).text(); // Get the text of the clicked item
                $('#searchDestination').val(selectedValue); // Set the value in the input field
                $('#destinationList').empty(); // Clear the list after selecting an item
                fetchCities(selectedStateId); // Fetch cities based on selected state
              });


          // city Keyup events
            $('#searchCity').on('focus', function(){

             console.log(selectedStateId);

            fetchCities(selectedStateId);
            });


            } else {
              $('#destinationList').append('<div class="list-group-item">No results found</div>');
            }
          }
        });
      } else {
        $('#destinationList').empty(); // Clear the results if input is cleared
      }
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
            // var maxCitiesToShow = 5; // Limit cities to show
            $.each(data, function (index, city) {
              $('#cityList').append('<div class="list-group-item"> <i class="fa-solid fa-location-dot"></i> ' + city.city_name + '</div>');
            });

            // Click event for selecting city
            $('.list-group-item').on('click', function () {
              var selectedCity = $(this).text();
              $('#searchCity').val(selectedCity); // Set city in input field
              $('#cityList').empty(); // Clear city list after selection
            });
          } else {
            // Append the 'No results found' message
              $('#cityList').append('<div class="list-group-item" id="noResults">No results found</div>');

              // Add a click event listener to hide the 'No results found' message
              $('#cityList').on('click', '#noResults', function() {
                  $(this).hide(); // Hide the clicked 'No results found' message
              });
           
          }
        }
      });
    }

    

    // Show state list when the input is clicked
    $('#searchDestination').on('focus', function () {
      fetchAllStates();
      $('#destinationList').show();
    });

    // Hide state/city list if clicked outside
    $(document).on('click', function (e) {
      if (!$(e.target).closest('#searchDestination, #destinationList, #searchCity, #cityList').length) {
        $('#destinationList').hide();
        //  $('#cityList').hide();

      }
    });
  });
</script>
@endsection