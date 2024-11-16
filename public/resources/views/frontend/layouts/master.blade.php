<!doctype html>
<html lang="en">

<head>

    <!-- Dynamic Title -->
    <title>@yield('title', 'Make My Bharat Yatra')</title>

    <!-- Dynamic Meta Description -->
    <meta name="description" content="@yield('meta_description', 'Make My Bharat Yatra')">
     <link rel="canonical" href="{{ request()->url() }}">
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/style1.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
  <!-- Link Swiper's CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="icon" href="{{ asset('assets/img/favicon.png')}}" type="icon">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  @yield('styles')

<meta name="google-site-verification" content="l_InFcZkDV2-5fVK_Wx5m0YEH_kdV-ntTlwliOmbenA" />
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6VR342NV7T"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-6VR342NV7T');
</script>
</head>

<body>
  <div class="topbar bg-dark text-white py-2">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 col-lg-6 col-xl-6 d-none d-lg-block">
          <a href="tel:(+91) 01204379908" target="_blank" class="text-white text-decoration-none px-2 "><i
              class="fa-solid fa-phone px-1"></i> +91 1204379908</a>
          <a href="mailto:info@makemybharatyatra.com" target="_blank"
            class="text-white text-decoration-none border-start border-2 px-3"> <i
              class="fa-solid fa-envelope px-1"></i> info@makemybharatyatra.com</a>
        </div>
        <div class="col-md-6 text-end">
          {{-- <button class="btn btn-warning btn-sm rounded-0 fw-bold mx-3 px-4 d-none d-lg-block"> <i
              class="fa fa-map-signs"></i> PLAN A TRIP</button> --}}

          <a href="tel:1204379908" target="_blank"
            class="text-white float-start text-decoration-none px-2 d-lg-none "><i class="fa-solid fa-phone px-1">
            </i></a>

          <a href="mailto:info@makemybharatyatra.com" target="_blank"
            class="text-white float-start text-decoration-none border-start border-2 px-3 d-lg-none"> <i
              class="fa-solid fa-envelope px-1"></i></a>
          <a href="{{ route('loginView')}}" class="btn btn-warning btn-sm rounded-0 fw-bold mx-3 px-3"><i
              class="fa-regular fa-user"></i> LOGIN</a>
        </div>
      </div>
    </div>
  </div>
  {{-- end top header --}}
  <nav class="navbar navbar-expand-lg navbar-light primary-header shadow bg-light">
    <div class="container">
      <a class="navbar-brand" href="{{ route('home')}}"><img
          src="{{ asset('assets/img/make-my-bharat-yatra-logo.png')}}" width="200" alt="make-my-bharat-yatra-logo"></a>
      <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
        data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
          <li class="nav-item">
            <a class="nav-link text-danger active" href="{{ route('home')}}" aria-current="page">Home
              <span class="visually-hidden">(current)</span></a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdownId1" data-bs-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false">Travel Packages</a>
            <div class="dropdown-menu mega-dropdown " aria-labelledby="dropdownId1">
          
              <a class="dropdown-item" href="https://makemybharatyatra.com/holidays/goa-tour-package">Goa</a>
              <a class="dropdown-item" href="https://makemybharatyatra.com/holidays/uttar-pradesh-tour-packages">Uttar Pradesh</a>
             
  
              
            </div>
          </li>

          {{-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false">Top Destination</a>
            <div class="dropdown-menu" aria-labelledby="dropdownId">
              <a class="dropdown-item" href="#">Action 1</a>
              <a class="dropdown-item" href="#">Action 2</a>
            </div>
          </li> --}}

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false">Travel Attraction</a>
            <div class="dropdown-menu" aria-labelledby="dropdownId">
              <a class="dropdown-item" href="https://makemybharatyatra.com/tour-category/adevanture">Adventure Tour</a>
              {{-- <a class="dropdown-item" href="http://127.0.0.1:8000/tour-category/city-tours">City Tour</a> --}}
              <a class="dropdown-item" href="https://makemybharatyatra.com/tour-category/honeymoon">Honeymoon</a>
            </div>
          </li>

          <li class="nav-item">
            <a href="" class="nav-link">Blog</a>
          </li>

          <li class="nav-item">
            <a href="{{ route('contactUs') }}" class="nav-link">Contact Us</a>
          </li>
        </ul>

      </div>
    </div>
  </nav>


  @yield('content')


  <footer class="footer mt-5">

    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4 mb-3">
          <img src="{{ asset('assets/img/make-my-bharat-yatra-logo.png')}}" width="250" class="mb-3" alt="make-my-bharat-yatra-logo">
          <p>Make My Bharat Yatra offers expertly crafted, personalized Travel experiences across India. <br> Enjoy
            exceptional service, unique adventures, and seamless journeys to India's top destinations with us</p>

          <div class="SocialList">
            <a href=""><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://www.linkedin.com/in/make-my-bharatyatra-516776304/" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
            <a href=""><i class="fa-brands fa-youtube"></i></a>
            <a href=""><i class="fa-brands fa-square-instagram"></i></a>

          </div>
        </div>

        <div class="col-md-2 quick-links col-lg-2 col-xl-2 mb-3">
          <h5>Quick Links</h5>
          <ul>
            <li><a href="{{ route('home')}}">Home</a></li>
            <li><a href="{{ route('aboutUs')}}">About Us</a></li>
            <li><a href="{{ route('services')}}">Our Services</a></li>
            <li><a href="{{ route('membership')}}">Membership</a></li>
            <li><a href="{{ route('career')}}">Career</a></li>
            <li><a href="{{ route('termsCondition')}}">Terms of Service</a></li>
          </ul>
        </div>


        <div class="col-md-3 quick-links col-lg-3 col-xl-3 mb-3">
          <h5>Top Destinations</h5>
          <ul>
            <li><a href="#">Delhi</a></li>
            <li><a href="#">Goa Tour</a></li>
            <li><a href="#">Manali</a></li>
            <li><a href="#">Kerala</a></li>
            <li><a href="#">Coimbatore</a></li>
            <li><a href="#">Mussoorie</a></li>
          </ul>
        </div>

        <div class="col-md-3 quick-links address col-lg-3 col-xl-3 mb-3 p-0">
          <h5>Contact</h5>
          <ul class="list-unstyled">
            <li> <i class="fa-solid fa-location-dot"></i> D-59, D-Block, Sector 63, Noida, <span class="px-lg-4">Uttar
                Pradesh 201301, India</span></li>
            <li><a href="tel:(+91) 9871980066"> <i class="fa-solid fa-phone-volume"></i> +91 98719 80066</a></li>
            <li><a href="tel:(+91 1204379908"> <i class="fa-solid fa-phone-volume"></i> +91 12043 79908</a></li>
            <li><a href="mailto:info@makemybharatyatra.com"> <i class="fa-solid fa-envelope"></i>
                info@makemybharatyatra.com</a></li>
            <li><a href="mailto:support@makemybharatyatra.com"> <i class="fa-solid fa-envelope"></i>
                support@makemybharatyatra.com</a></li>
          </ul>
        </div>

        <div class="col-12">
          <div class="footer-bottom text-center">
            <p> <span style="font-size: 16px;">&copy;</span> 2018 Make My Bharat Yatra | All rights reserved</p>
          </div>
        </div>
      </div>
    </div>

  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>


  @yield('scripts')

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper(".mySwiper", {
      slidesPerView: 4,
      spaceBetween: 10,
      autoplay: {
        delay: 2500,
      },

      // Responsive breakpoints
      breakpoints: {
        // when window width is >= 320px
        320: {
          slidesPerView: 2,
          spaceBetween: 5
        },
        // when window width is >= 480px
        480: {
          slidesPerView: 2,
          spaceBetween: 10
        },
        // when window width is >= 640px
        640: {
          slidesPerView: 4,
          spaceBetween: 10
        }
      }
    });
    var swiper = new Swiper(".mySwipercategory", {
      slidesPerView: 3,
      spaceBetween: 10,
      autoplay: {
        delay: 6000,
      },
      // Responsive breakpoints
      breakpoints: {
        // when window width is >= 320px
        320: {
          slidesPerView: 2,
          spaceBetween: 10
        },
        // when window width is >= 480px
        480: {
          slidesPerView: 2,
          spaceBetween: 10
        },
        // when window width is >= 640px
        640: {
          slidesPerView: 3,
          spaceBetween: 10
        }
      }
    });

    var swiper = new Swiper(".mySwiperHoliday", {
      slidesPerView: 3,
      spaceBetween: 30,
      autoplay: {
        delay: 6000,
      },
      pagination: {
        el: ".swiper-pagination",
        dynamicBullets: true,
      },

      // Responsive breakpoints
      breakpoints: {
        // when window width is >= 320px
        320: {
          slidesPerView: 1,
          spaceBetween: 10
        },
        // when window width is >= 480px
        480: {
          slidesPerView: 1,
          spaceBetween: 10
        },
        // when window width is >= 640px
        640: {
          slidesPerView: 3,
          spaceBetween: 20
        }
      }

    });


    $(function () {

      // Initialize the datepicker
      $("#datepicker").datepicker({
        dateFormat: "dd M, yy", // Format for day, month, and year
        minDate: 0, // Disable all past dates
        onSelect: function (dateText, inst) {
          var date = $(this).datepicker('getDate');
          var dayOfWeek = $.datepicker.formatDate('DD', date); // Get the day of the week
          $("#formatted-date").html(dateText + " " + dayOfWeek); // Display the formatted date
        }
      });

      // Set the current date
      $("#datepicker").datepicker("setDate", new Date());

      // Trigger onSelect to update the formatted display initially
      $("#datepicker").datepicker("option", "onSelect")($.datepicker.formatDate("dd M, yy", new Date()), {});

    });



    var swiper = new Swiper(".serviceSlider", {
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      spaceBetween: 10,
      autoplay: {
        delay: 3000,
      },
      // Responsive breakpoints
      breakpoints: {
        // when window width is >= 320px
        320: {
          slidesPerView: 1,
          spaceBetween: 20
        },
        // when window width is >= 480px
        480: {
          slidesPerView: 3,
          spaceBetween: 30
        },
        // when window width is >= 640px
        640: {
          slidesPerView: 3,
          spaceBetween: 40
        }
      }
    });



  </script>
</body>

</html>