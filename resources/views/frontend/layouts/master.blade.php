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
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-6VR342NV7T"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

        gtag('config', 'G-6VR342NV7T');
    </script>
    <style>
        @media (min-width: 992px) {
            .navbar .dropdown:hover>.dropdown-menu {
                display: block;
            }

            .navbar .dropdown:hover>.nav-link {
                color: #0d6efd;
            }
        }
    </style>
</head>

<body>
    <div class="topbar bg-dark text-white py-2">
        <div class="container">
            <div class="row align-items-center">
                <!-- Contact Info Section -->
                <div class="col-6" style="font-size: 14px;">
                    <!-- Hidden on small screens, visible on lg -->
                    <div class="d-none d-lg-block">
                        <a href="tel:(+91) 1204223100" target="_blank" class="text-white text-decoration-none px-2">
                            <i class="fa-solid fa-phone px-1"></i> +91 1204223100
                        </a>
                        <a href="mailto:info@makemybharatyatra.com" target="_blank"
                            class="text-white text-decoration-none border-start border-2 px-3">
                            <i class="fa-solid fa-envelope px-1"></i> info@makemybharatyatra.com
                        </a>
                    </div>
                    <!-- Visible only on small screens -->
                    <div class="d-lg-none" style="display: flex; gap: 15px;">
                        <a href="tel:(+91) 1204223100" target="_blank" class="text-white text-decoration-none"
                            style="padding: 5px;">
                            <i class="fa-solid fa-phone"></i>
                        </a>
                        <a href="mailto:info@makemybharatyatra.com" target="_blank"
                            class="text-white text-decoration-none" style="padding: 5px;">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                    </div>
                </div>

                <!-- Login/Cart Section -->
                <!-- Login/Cart Section -->
                <div class="col-6">
                    <div style="display: flex; justify-content: flex-end; align-items: center; gap: 10px;">
                        @guest
                            <a href="{{ route('loginView') }}" class="btn btn-warning btn-sm rounded-0 fw-bold"
                                style="padding: 6px 15px; font-size: 13px;">
                                <span>LOGIN</span>
                            </a>
                        @else
                            <!-- Cart Icon -->
                            <a href="{{ route('checkout') }}" class="nav-link position-relative" style="padding: 5px;">
                                <i class="fa fa-shopping-cart" style="font-size: 18px;"></i>
                                <span id="cart-count" class="badge bg-danger rounded-pill position-absolute"
                                    style="top: -8px; right: -8px; font-size: 10px;">
                                    {{ $cartCount }}
                                </span>
                            </a>

                            <!-- User Profile Dropdown -->
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown"
                                    style="text-decoration: none;">
                                    <div class="profile-circle bg-warning d-flex align-items-center justify-content-center"
                                        style="width: 35px; height: 35px; border-radius: 50%; color: #333; font-weight: bold;">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li class="dropdown-item disabled text-muted">Hello,
                                        {{ explode(' ', Auth::user()->name)[0] }}</li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fa-solid fa-sign-out-alt me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end top header --}}
    <nav class="navbar navbar-expand-lg navbar-light primary-header shadow bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}"><img
                    src="{{ asset('assets/img/make-my-bharat-yatra-logo.png') }}" width="200"
                    alt="make-my-bharat-yatra-logo"></a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-danger active" href="{{ route('home') }}" aria-current="page">Home
                            <span class="visually-hidden">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownId1"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Travel Packages</a>
                        <div class="dropdown-menu mega-dropdown " aria-labelledby="dropdownId1">
                            <a class="dropdown-item" href="http://127.0.0.1:8000/holidays/goa-tour-package">Goa</a>
                            <a class="dropdown-item" href="http://127.0.0.1:8000/holidays/uttar-pradesh-tour-packages">Uttar Pradesh</a>
                            <a class="dropdown-item" href="http://127.0.0.1:8000/holidays/delhi-tour-packages">Delhi</a>
                            <a class="dropdown-item" href="http://127.0.0.1:8000/holidays/uttarakhand-tour-packages">Uttarakhand</a>
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
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Travel Attraction</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownId">
                            <a class="dropdown-item" href="http://127.0.0.1:8000/tour-category/adventure">Adventure Tour</a>
                            <a class="dropdown-item" href="http://127.0.0.1:8000/tour-category/honeymoon">Honeymoon</a>
                            <a class="dropdown-item" href="http://127.0.0.1:8000/tour-category/religious-places">Religious Places</a>
                            <a class="dropdown-item" href="http://127.0.0.1:8000/tour-category/heritage">Heritage</a>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('blog') }}" class="nav-link">Blog</a>
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
                    <img src="{{ asset('assets/img/make-my-bharat-yatra-logo.png') }}" width="250" class="mb-3"
                        alt="make-my-bharat-yatra-logo">
                    <p>Make My Bharat Yatra offers expertly crafted, personalized Travel experiences across India. <br>
                        Enjoy
                        exceptional service, unique adventures, and seamless journeys to India's top destinations with
                        us</p>
                    <div class="SocialList">
                        <a href=""><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://www.linkedin.com/in/make-my-bharatyatra-516776304/" target="_blank"><i
                                class="fa-brands fa-linkedin"></i></a>
                        <a href=""><i class="fa-brands fa-youtube"></i></a>
                        <a href=""><i class="fa-brands fa-square-instagram"></i></a>
                    </div>
                </div>
                <div class="col-md-2 quick-links col-lg-2 col-xl-2 mb-3">
                    <h5>Quick Links</h5>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('aboutUs') }}">About Us</a></li>
                        <li><a href="{{ route('services') }}">Our Services</a></li>
                        <li><a href="{{ route('membership') }}">Membership</a></li>
                        <li><a href="{{ route('career') }}">Career</a></li>
                        <li><a href="{{ route('termsCondition') }}">Terms And Conditions</a></li>
                    </ul>
                </div>
                <div class="col-md-3 quick-links col-lg-3 col-xl-3 mb-3">
                    <h5>Top Destinations</h5>
                    <ul>
                        <li><a href="{{ url('/delhi-section') }}">Delhi</a></li>
                        <li><a href="{{ url('/goa-section') }}">Goa Tour</a></li>
                        <li><a href="{{ url('/manali-section') }}">Manali</a></li>
                        <li><a href="{{ url('/kerela-section') }}">Kerala</a></li>
                        <li><a href="{{ url('/coimbatore-section') }}">Coimbatore</a></li>
                        <li><a href="{{ url('/mussoorie-section') }}">Mussoorie</a></li>
                    </ul>
                </div>
                <div class="col-md-3 quick-links address col-lg-3 col-xl-3 mb-3 p-0">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li> <i class="fa-solid fa-location-dot"></i> D-59, D-Block, Sector 63, Noida, <span
                                class="px-lg-4">Uttar
                                Pradesh 201301, India</span></li>
                        <li><a href="tel:(+91) 9871980066"> <i class="fa-solid fa-phone-volume"></i> +91 98719
                                80066</a></li>
                        <li><a href="tel:(+91 1204223100"> <i class="fa-solid fa-phone-volume"></i> +91 1204223100</a>
                        </li>
                        <li><a href="mailto:info@makemybharatyatra.com"> <i class="fa-solid fa-envelope"></i>
                                info@makemybharatyatra.com</a></li>
                        <li><a href="mailto:support@makemybharatyatra.com"> <i class="fa-solid fa-envelope"></i>
                                support@makemybharatyatra.com</a></li>
                    </ul>
                </div>
                <div class="col-12">
                    <div class="footer-bottom text-center">
                        <p> <span style="font-size: 16px;">&copy;</span> 2025 Make My Bharat Yatra | All rights
                            reserved</p>
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
        $(function() {

            // Initialize the datepicker
            $("#datepicker").datepicker({
                dateFormat: "dd M, yy", // Format for day, month, and year
                minDate: 0, // Disable all past dates
                onSelect: function(dateText, inst) {
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

        $(document).ready(function() {
            // Function to update cart count
            function updateCartCount(count) {
                $('#cart-count').text(count);
            }

            // Add to cart AJAX call
            $('.add-to-cart-btn').click(function(e) {
                e.preventDefault();
                let packageId = $(this).data('package-id');

                $.ajax({
                    url: '/cart/add/' + packageId,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            updateCartCount(response.cartCount);
                            // Optional: Show success message
                            alert('Package added to cart successfully!');
                        }
                    },
                    error: function(xhr) {
                        console.error('Error adding to cart:', xhr);
                        alert('Failed to add package to cart');
                    }
                }); 
            });

            // Enable hover dropdown for desktop - this was in the wrong place
            if (window.innerWidth >= 992) { // Bootstrap lg breakpoint
                $('.navbar .dropdown').hover(
                    function() {
                        $(this).find('.dropdown-menu').first().stop(true, true).delay(50).slideDown(200);
                        $(this).addClass('show');
                        $(this).find('.dropdown-toggle').attr('aria-expanded', 'true');
                    },
                    function() {
                        $(this).find('.dropdown-menu').first().stop(true, true).delay(50).slideUp(200);
                        $(this).removeClass('show');
                        $(this).find('.dropdown-toggle').attr('aria-expanded', 'false');
                    }
                );
            }
        });
    </script>
</body>
</html>
