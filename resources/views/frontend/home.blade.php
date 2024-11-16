@extends('frontend.layouts.main')
@section('title', 'Make My Bharat Yatra')
@section('meta_description', 'Book customized India tour packages with Make My Bharat Yatra. Discover top travel destinations, affordable tours, flights, hotels, and personalized itineraries. Explore the beauty of India now!')

@section('content')

<div class="hero-3" id="hero">
    <div class="swiper hero-slider-3" id="heroSlide3">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="hero-inner">
                    <div class="th-hero-bg" data-bg-src="assets/img/hero/hero_bg_3_1.jpg"></div>
                    <div class="container">
                        <div class="hero-style3">
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="hero-inner">
                    <div class="th-hero-bg" data-bg-src="assets/img/hero/hero_bg_3_2.jpg"></div>
                    <div class="container">
                        <div class="hero-style3">
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="hero-inner">
                    <div class="th-hero-bg" data-bg-src="assets/img/hero/hero_bg_3_3.jpg"></div>
                    <div class="container">
                        <div class="hero-style3">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="hero-inner">
                    <div class="th-hero-bg" data-bg-src="assets/img/hero/hero_bg_3_4.jpg"></div>
                    <div class="container">
                        <div class="hero-style3">
                           
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="swiper-slide">
                <div class="hero-inner"><video autoplay loop muted>
                        <source src="assets/img/hero/hero-video3.mp4" type="video/mp4">
                    </video>
                    <div class="container">
                        <div class="hero-style3">
                            <h1 class="hero-title" data-ani="slideinleft" data-ani-delay="0.2s">Travel experience
                                with tourm</h1>
                            <p class="hero-text" data-ani="slideinleft" data-ani-delay="0.4s">Tourm an international
                                travel management company with 25 years of experience, specializing in business and
                                maritime travel.</p>
                            <div class="btn-group" data-ani="slideinup" data-ani-delay="0.6s"><a
                                    href="destination.html" class="th-btn style2 th-icon">Explore Tours</a></div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="hero3-wrapper">
        <div class="container">
            <div class="row justify-content-center align-items-end flex-row-reverse">
                <div class="col-lg-4">
                    <div class="hero3-swiper-custom"><button data-slider-prev="#heroSlide3"
                            class="swiper-button-next"><img src="assets/img/icon/hero-arrow-right.svg"
                                alt=""></button>
                        <div class="swiper-pagination"></div><button data-slider-next="#heroSlide3"
                            class="swiper-button-prev"><img src="assets/img/icon/hero-arrow-left.svg"
                                alt=""></button>
                    </div>
                    <div class="swiper hero3Thumbs">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="hero-inner">
                                    <div class="hero3-card">
                                        <div class="hero-img"><img src="assets/img/hero/hero_bg_3_1.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="hero-inner">
                                    <div class="hero3-card">
                                        <div class="hero-img"><img src="assets/img/hero/hero_bg_3_2.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="hero-inner">
                                    <div class="hero3-card">
                                        <div class="hero-img"><img src="assets/img/hero/hero_bg_3_3.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="hero-inner">
                                    <div class="hero3-card">
                                        <div class="hero-img"><img src="assets/img/hero/hero_bg_3_4.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="hero-inner">
                                    <div class="hero3-card">
                                        <div class="hero-img"><img src="assets/img/hero/hero_bg_3_5.jpg" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="hero-booking">
                        <form action="#" method="POST"
                            class="booking-form style2 ajax-contact">
                            <div class="input-wrap">
                                <div class="row align-items-center justify-content-between">
                                    <div class="form-group col-md-6 col-xl-auto">
                                        <div class="icon"><i class="fa-light fa-route"></i></div>
                                        <div class="search-input"><label>Destination</label> <select
                                                class="nice-select" name="Destination" id="Destination">
                                                <option value="Select Destination" selected="selected"
                                                    disabled="disabled">Select Destination</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Dubai">Dubai</option>
                                                <option value="England">England</option>
                                                <option value="Sweden">Sweden</option>
                                                <option value="Thailand">Thailand</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="Saudi Arab">Saudi Arab</option>
                                                <option value="Switzerland">Switzerland</option>
                                                <option value="Scandinavia">Scandinavia</option>
                                                <option value="Western Europe">Western Europe</option>
                                                <option value="Indonesia">Indonesia</option>
                                                <option class="Italy">Italy</option>
                                            </select></div>
                                    </div>
                                    <div class="form-group col-md-6 col-xl-auto">
                                        <div class="icon"><i class="fa-regular fa-person-hiking"></i></div>
                                        <div class="search-input"><label>Type</label> <select class="nice-select"
                                                name="type" id="type">
                                                <option value="Adventure" selected="selected" disabled="disabled">
                                                    Adventure</option>
                                                <option value="Beach">Beach</option>
                                                <option value="Group Tour">Group Tour</option>
                                                <option value="Couple Tour">Couple Tour</option>
                                                <option value="Family Tour">Family Tour</option>
                                            </select></div>
                                    </div>
                                    <div class="form-group col-md-6 col-xl-auto">
                                        <div class="icon"><i class="fa-light fa-clock"></i></div>
                                        <div class="search-input"><label>Duration</label> <select
                                                class="form-select nice-select" name="Duration" id="Duration">
                                                <option value="Normal" selected="selected" disabled="disabled">
                                                    Duration</option>
                                                <option value="1">1 days</option>
                                                <option value="2">2 days</option>
                                                <option value="3">3 days</option>
                                                <option value="4">4 days</option>
                                                <option value="5">5 days</option>
                                                <option value="6">6 days</option>
                                                <option value="7">7 days</option>
                                            </select></div>
                                    </div>
                                    <div class="form-btn col-md-6 col-xl-auto"><button class="th-btn"><img
                                                src="assets/img/icon/search.svg" alt="">Search</button></div>
                                </div>
                                <p class="form-messages mb-0 mt-3"></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="scroll-down"><a href="#destination-sec" class="scroll-wrap"><span><img
                    src="assets/img/icon/down-arrow.svg" alt=""></span>Scroll Down</a></div>
</div> --}}
<section class="position-relative overflow-hidden space" id="destination-sec"
    data-bg-src="assets/img/bg/line-pattern3.png">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-6">
                <div class="title-area"><span class="sub-title">Top Destination</span>
                    <h2 class="sec-title">Popular Destination</h2>
                </div>
            </div>
            <div class="col-lg-5">
                <h2 class="destination-title"><span class="counter-number">850</span>+ Destinations</h2>
                <p class="sec-text mb-30">One of the most well-liked travel companies for people looking to
                    experience adventure and see the world is Tourm.</p>
            </div>
        </div>
        <div class="slider-area">
            <div class="swiper th-slider has-shadow"
                data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1300":{"slidesPerView":"4"}}}'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="destination-item th-ani">
                            <div class="destination-item_img global-img"><img
                                    src="assets/img/destination/destination_3_1.jpg" alt="image"></div>
                            <div class="destination-content">
                                <h3 class="box-title"><a href="destination-details.html">Dubai, UAE</a></h3>
                                <p class="destination-text">25 Listing</p><a href="destination-details.html"
                                    class="th-btn style4 th-icon">Book Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="destination-item th-ani">
                            <div class="destination-item_img global-img"><img
                                    src="assets/img/destination/destination_3_2.jpg" alt="image"></div>
                            <div class="destination-content">
                                <h3 class="box-title"><a href="destination-details.html">Japan</a></h3>
                                <p class="destination-text">25 Listing</p><a href="destination-details.html"
                                    class="th-btn style4 th-icon">Book Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="destination-item th-ani">
                            <div class="destination-item_img global-img"><img
                                    src="assets/img/destination/destination_3_3.jpg" alt="image"></div>
                            <div class="destination-content">
                                <h3 class="box-title"><a href="destination-details.html">Switzerland</a></h3>
                                <p class="destination-text">25 Listing</p><a href="destination-details.html"
                                    class="th-btn style4 th-icon">Book Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="destination-item th-ani">
                            <div class="destination-item_img global-img"><img
                                    src="assets/img/destination/destination_3_4.jpg" alt="image"></div>
                            <div class="destination-content">
                                <h3 class="box-title"><a href="destination-details.html">Brazil</a></h3>
                                <p class="destination-text">25 Listing</p><a href="destination-details.html"
                                    class="th-btn style4 th-icon">Book Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="destination-item th-ani">
                            <div class="destination-item_img global-img"><img
                                    src="assets/img/destination/destination_3_1.jpg" alt="image"></div>
                            <div class="destination-content">
                                <h3 class="box-title"><a href="destination-details.html">Dubai, UAE</a></h3>
                                <p class="destination-text">25 Listing</p><a href="destination-details.html"
                                    class="th-btn style4 th-icon">Book Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="destination-item th-ani">
                            <div class="destination-item_img global-img"><img
                                    src="assets/img/destination/destination_3_2.jpg" alt="image"></div>
                            <div class="destination-content">
                                <h3 class="box-title"><a href="destination-details.html">Japan</a></h3>
                                <p class="destination-text">25 Listing</p><a href="destination-details.html"
                                    class="th-btn style4 th-icon">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="destination-btn text-center mt-60"><a href="destination.html" class="th-btn style3 th-icon">View
                All</a></div>
    </div>
</section>
<section class="category-area3 bg-smoke space" data-bg-src="assets/img/bg/line-pattern3.png">
    <div class="container th-container">
        <div class="title-area text-center"><span class="sub-title">Wornderful Place For You</span>
            <h2 class="sec-title">Tour Categories</h2>
        </div>
        <div class="slider-area">
            <div class="swiper th-slider has-shadow category-slider3" id="categorySlider3"
                data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"5"}}}'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="category-card single2">
                            <div class="box-img global-img"><img src="assets/img/category/category_1_1.jpg"
                                    alt="Image"></div>
                            <h3 class="box-title"><a href="destination.html">Cruises</a></h3><a class="line-btn"
                                href="destination.html">See more</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="category-card single2">
                            <div class="box-img global-img"><img src="assets/img/category/category_1_2.jpg"
                                    alt="Image"></div>
                            <h3 class="box-title"><a href="destination.html">Hiking</a></h3><a class="line-btn"
                                href="destination.html">See more</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="category-card single2">
                            <div class="box-img global-img"><img src="assets/img/category/category_1_3.jpg"
                                    alt="Image"></div>
                            <h3 class="box-title"><a href="destination.html">Airbirds</a></h3><a class="line-btn"
                                href="destination.html">See more</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="category-card single2">
                            <div class="box-img global-img"><img src="assets/img/category/category_1_4.jpg"
                                    alt="Image"></div>
                            <h3 class="box-title"><a href="destination.html">Wildlife</a></h3><a class="line-btn"
                                href="destination.html">See more</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="category-card single2">
                            <div class="box-img global-img"><img src="assets/img/category/category_1_5.jpg"
                                    alt="Image"></div>
                            <h3 class="box-title"><a href="destination.html">Walking</a></h3><a class="line-btn"
                                href="destination.html">See more</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="category-card single2">
                            <div class="box-img global-img"><img src="assets/img/category/category_1_1.jpg"
                                    alt="Image"></div>
                            <h3 class="box-title"><a href="destination.html">Cruises</a></h3><a class="line-btn"
                                href="destination.html">See more</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="category-card single2">
                            <div class="box-img global-img"><img src="assets/img/category/category_1_2.jpg"
                                    alt="Image"></div>
                            <h3 class="box-title"><a href="destination.html">Hiking</a></h3><a class="line-btn"
                                href="destination.html">See more</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="category-card single2">
                            <div class="box-img global-img"><img src="assets/img/category/category_1_3.jpg"
                                    alt="Image"></div>
                            <h3 class="box-title"><a href="destination.html">Airbirds</a></h3><a class="line-btn"
                                href="destination.html">See more</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="category-card single2">
                            <div class="box-img global-img"><img src="assets/img/category/category_1_4.jpg"
                                    alt="Image"></div>
                            <h3 class="box-title"><a href="destination.html">Wildlife</a></h3><a class="line-btn"
                                href="destination.html">See more</a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="category-card single2">
                            <div class="box-img global-img"><img src="assets/img/category/category_1_5.jpg"
                                    alt="Image"></div>
                            <h3 class="box-title"><a href="destination.html">Walking</a></h3><a class="line-btn"
                                href="destination.html">See more</a>
                        </div>
                    </div>
                </div>
                <div class="slider-pagination"></div>
            </div>
        </div>
    </div>
</section>
<div class="about-area position-relative overflow-hidden space" id="about-sec">
    <div class="container">
        <div class="row">
            <div class="col-xl-7">
                <div class="img-box3">
                    <div class="img1"><img src="assets/img/normal/about_3_1.jpg" alt="About"></div>
                    <div class="img2"><img src="assets/img/normal/about_3_2.jpg" alt="About"></div>
                    <div class="img3 movingX"><img src="assets/img/normal/about_3_3.jpg" alt="About"></div>
                </div>
            </div>
            <div class="col-xl-5">
                <div class="ps-xl-4">
                    <div class="title-area mb-20 pe-xxl-5 me-xxl-5"><span class="sub-title style1">Let’s Go
                            Together</span>
                        <h2 class="sec-title mb-20 pe-xl-5 me-xl-5 heading">Plan Your Trip With us</h2>
                    </div>
                    <p class="sec-text mb-30">There are many variations of passages of available but the majority
                        have suffered alteration in some form, by injected hum randomised words.</p>
                    <div class="about-item-wrap">
                        <div class="about-item style2">
                            <div class="about-item_img"><img src="assets/img/icon/about_1_1.svg" alt=""></div>
                            <div class="about-item_centent">
                                <h5 class="box-title">Exclusive Trip</h5>
                                <p class="about-item_text">There are many variations of passages of available but
                                    the majority.</p>
                            </div>
                        </div>
                        <div class="about-item style2">
                            <div class="about-item_img"><img src="assets/img/icon/about_1_2.svg" alt=""></div>
                            <div class="about-item_centent">
                                <h5 class="box-title">Safety First Always</h5>
                                <p class="about-item_text">There are many variations of passages of available but
                                    the majority.</p>
                            </div>
                        </div>
                        <div class="about-item style2">
                            <div class="about-item_img"><img src="assets/img/icon/about_1_3.svg" alt=""></div>
                            <div class="about-item_centent">
                                <h5 class="box-title">Professional Guide</h5>
                                <p class="about-item_text">There are many variations of passages of available but
                                    the majority.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-35"><a href="about.html" class="th-btn style3 th-icon">Learn More</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="shape-mockup movingX d-none d-xxl-block" data-top="4%" data-left="2%"><img
            src="assets/img/shape/shape_2_1.png" alt="shape"></div>
    <div class="shape-mockup jump d-none d-xxl-block" data-top="28%" data-right="5%"><img
            src="assets/img/shape/shape_2_2.png" alt="shape"></div>
    <div class="shape-mockup spin d-none d-xxl-block" data-bottom="18%" data-left="2%"><img
            src="assets/img/shape/shape_2_3.png" alt="shape"></div>
    <div class="shape-mockup movixgX d-none d-xxl-block" data-bottom="18%" data-right="2%"><img
            src="assets/img/shape/shape_2_4.png" alt="shape"></div>
    <div class="shape-mockup movingCar d-none d-xxl-block" data-bottom="0%" data-right="2%"><img
            src="assets/img/shape/car_1.png" alt="shape"></div>
    <div class="shape-mockup d-none d-xxl-block" data-bottom="0%" data-right="0%"><img
            src="assets/img/shape/tree_1.png" alt="shape"></div>
</div>
<section class="position-relative bg-top-center overflow-hidden space" id="service-sec"
    data-bg-src="assets/img/bg/tour_bg_1.jpg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="title-area text-center"><span class="sub-title">Best Experience</span>
                    <h2 class="sec-title">Amazing Travel Experience</h2>
                </div>
            </div>
        </div>
        <div class="nav nav-tabs tour-tabs" id="nav-tab" role="tablist"><button class="nav-link th-btn active"
                id="nav-step1-tab" data-bs-toggle="tab" data-bs-target="#nav-step1" type="button"><img
                    src="assets/img/icon/tour_icon_1.svg" alt="">Tour Package</button> <button
                class="nav-link th-btn" id="nav-step2-tab" data-bs-toggle="tab" data-bs-target="#nav-step2"
                type="button"><img src="assets/img/icon/tour_icon_2.svg" alt="">Hotel</button> <button
                class="nav-link th-btn" id="nav-step3-tab" data-bs-toggle="tab" data-bs-target="#nav-step3"
                type="button"><img src="assets/img/icon/tour_icon_3.svg" alt="">Transport</button></div>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade active show" id="nav-step1" role="tabpanel">
                <div class="slider-area tour-slider">
                    <div class="swiper th-slider has-shadow"
                        data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"4"}}}'>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_1.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Greece Tour Package</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_2.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Italy Tour package</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_3.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Dubai Tour Package</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_4.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Switzerland</a></h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_1.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Greece Tour Package</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_2.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Italy Tour package</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_3.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Dubai Tour Package</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_4.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Switzerland</a></h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slider-pagination"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-step2" role="tabpanel">
                <div class="slider-area tour-slider">
                    <div class="swiper th-slider has-shadow"
                        data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"4"}}}'>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_5.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">The Plaza, New York</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_6.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Hotel Ritz Paris</a></h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$970.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_7.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Claridge’s, London</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$960.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_8.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Taj Mahal Palace,
                                                India</a></h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$940.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_9.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Peninsula Hong Kong</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$970.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_10.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">The Ritz Hotel London</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$940.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_11.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">The Shelbourne Hotel,
                                                Dublin</a></h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$990.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_12.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Beverly Hills Hotel</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$950.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slider-pagination"></div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-step3" role="tabpanel">
                <div class="slider-area tour-slider">
                    <div class="swiper th-slider has-shadow"
                        data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"4"}}}'>
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_13.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Caravan Trip Package</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_14.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Sleeper Buses Package</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_15.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Trips by Train Package</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_16.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Travel by Air Flight
                                                Package</a></h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_17.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Cruise Transports
                                                Package</a></h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_18.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Travel by Air Flight
                                                Package</a></h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_19.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Sleeper Buses Package</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="tour-box th-ani gsap-cursor">
                                    <div class="tour-box_img global-img"><img src="assets/img/tour/tour_box_20.jpg"
                                            alt="image"></div>
                                    <div class="tour-content">
                                        <h3 class="box-title"><a href="tour-details.html">Trips by Train Package</a>
                                        </h3>
                                        <div class="tour-rating">
                                            <div class="star-rating" role="img" aria-label="Rated 5.00 out of 5">
                                                <span style="width:100%">Rated <strong class="rating">5.00</strong>
                                                    out of 5 based on <span class="rating">4.8</span>(4.8
                                                    Rating)</span></div><a href="tour-details.html"
                                                class="woocommerce-review-link">(<span class="count">4.8</span>
                                                Rating)</a>
                                        </div>
                                        <h4 class="tour-box_price"><span class="currency">$980.00</span>/Person</h4>
                                        <div class="tour-action"><span><i class="fa-light fa-clock"></i>7
                                                Days</span> <a href="tour-guider-details.html"
                                                class="th-btn style4 th-icon">Book Now</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slider-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="overflow-hidden space-bottom">
    <div class="container">
        <div class="title-area text-center"><span class="sub-title">Make Your Tour More Pleasure</span>
            <h2 class="sec-title">Recent Gallery</h2>
        </div>
        <div class="row gy-24 gx-24 justify-content-center">
            <div class="col-lg-3">
                <div class="gallery-box style2">
                    <div class="gallery-img global-img"><a href="assets/img/gallery/gallery_3_1.jpg"
                            class="popup-image">
                            <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div><img
                                src="assets/img/gallery/gallery_3_1.jpg" alt="gallery image">
                        </a></div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="gallery-box style2">
                    <div class="gallery-img global-img"><a href="assets/img/gallery/gallery_3_2.jpg"
                            class="popup-image">
                            <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div><img
                                src="assets/img/gallery/gallery_3_2.jpg" alt="gallery image">
                        </a></div>
                </div>
                <div class="gallery-box style2">
                    <div class="gallery-img global-img"><a href="assets/img/gallery/gallery_3_4.jpg"
                            class="popup-image">
                            <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div><img
                                src="assets/img/gallery/gallery_3_4.jpg" alt="gallery image">
                        </a></div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="gallery-box style2">
                    <div class="gallery-img global-img"><a href="assets/img/gallery/gallery_3_3.jpg"
                            class="popup-image">
                            <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div><img
                                src="assets/img/gallery/gallery_3_3.jpg" alt="gallery image">
                        </a></div>
                </div>
                <div class="gallery-box-wrapp">
                    <div class="gallery-box style2">
                        <div class="gallery-img global-img"><a href="assets/img/gallery/gallery_3_5.jpg"
                                class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div><img
                                    src="assets/img/gallery/gallery_3_5.jpg" alt="gallery image">
                            </a></div>
                    </div>
                    <div class="gallery-box style2">
                        <div class="gallery-img global-img"><a href="assets/img/gallery/gallery_3_6.jpg"
                                class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div><img
                                    src="assets/img/gallery/gallery_3_6.jpg" alt="gallery image">
                            </a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="team-area3 position-relative bg-top-center space" data-bg-src="assets/img/bg/team_bg_2.jpg">
    <div class="container z-index-common">
        <div class="title-area text-center"><span class="sub-title">Meet with Guide</span>
            <h2 class="sec-title">Meet with Tour Guide</h2>
        </div>
        <div class="slider-area">
            <div class="swiper th-slider teamSlider3 has-shadow" id="teamSlider3"
                data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}}}'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="th-team team-grid">
                            <div class="team-img"><img src="assets/img/team/team_img_1.jpg" alt="Team"></div>
                            <div class="team-img2"><img src="assets/img/team/team_1_1.jpg" alt="Team"></div>
                            <div class="team-content">
                                <div class="media-body">
                                    <h3 class="box-title"><a href="tour-guider-details.html">Michel Smith</a></h3>
                                    <span class="team-desig">Tourist Guide</span>
                                    <div class="th-social"><a target="_blank" href="https://facebook.com/"><i
                                                class="fab fa-facebook-f"></i></a> <a target="_blank"
                                            href="https://twitter.com/"><i class="fab fa-twitter"></i></a> <a
                                            target="_blank" href="https://linkedin.com/"><i
                                                class="fab fa-linkedin-in"></i></a> <a target="_blank"
                                            href="https://youtube.com/"><i class="fab fa-youtube"></i></a> <a
                                            target="_blank" href="https://instagram.com/"><i
                                                class="fab fa-instagram"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="th-team team-grid">
                            <div class="team-img"><img src="assets/img/team/team_img_2.jpg" alt="Team"></div>
                            <div class="team-img2"><img src="assets/img/team/team_1_2.jpg" alt="Team"></div>
                            <div class="team-content">
                                <div class="media-body">
                                    <h3 class="box-title"><a href="tour-guider-details.html">Janny Willson</a></h3>
                                    <span class="team-desig">Tourist Guide</span>
                                    <div class="th-social"><a target="_blank" href="https://facebook.com/"><i
                                                class="fab fa-facebook-f"></i></a> <a target="_blank"
                                            href="https://twitter.com/"><i class="fab fa-twitter"></i></a> <a
                                            target="_blank" href="https://linkedin.com/"><i
                                                class="fab fa-linkedin-in"></i></a> <a target="_blank"
                                            href="https://youtube.com/"><i class="fab fa-youtube"></i></a> <a
                                            target="_blank" href="https://instagram.com/"><i
                                                class="fab fa-instagram"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="th-team team-grid">
                            <div class="team-img"><img src="assets/img/team/team_img_3.jpg" alt="Team"></div>
                            <div class="team-img2"><img src="assets/img/team/team_1_3.jpg" alt="Team"></div>
                            <div class="team-content">
                                <div class="media-body">
                                    <h3 class="box-title"><a href="tour-guider-details.html">Jacob Jones</a></h3>
                                    <span class="team-desig">Tourist Guide</span>
                                    <div class="th-social"><a target="_blank" href="https://facebook.com/"><i
                                                class="fab fa-facebook-f"></i></a> <a target="_blank"
                                            href="https://twitter.com/"><i class="fab fa-twitter"></i></a> <a
                                            target="_blank" href="https://linkedin.com/"><i
                                                class="fab fa-linkedin-in"></i></a> <a target="_blank"
                                            href="https://youtube.com/"><i class="fab fa-youtube"></i></a> <a
                                            target="_blank" href="https://instagram.com/"><i
                                                class="fab fa-instagram"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="th-team team-grid">
                            <div class="team-img"><img src="assets/img/team/team_img_1.jpg" alt="Team"></div>
                            <div class="team-img2"><img src="assets/img/team/team_1_4.jpg" alt="Team"></div>
                            <div class="team-content">
                                <div class="media-body">
                                    <h3 class="box-title"><a href="tour-guider-details.html">Maria Prova</a></h3>
                                    <span class="team-desig">Tourist Guide</span>
                                    <div class="th-social"><a target="_blank" href="https://facebook.com/"><i
                                                class="fab fa-facebook-f"></i></a> <a target="_blank"
                                            href="https://twitter.com/"><i class="fab fa-twitter"></i></a> <a
                                            target="_blank" href="https://linkedin.com/"><i
                                                class="fab fa-linkedin-in"></i></a> <a target="_blank"
                                            href="https://youtube.com/"><i class="fab fa-youtube"></i></a> <a
                                            target="_blank" href="https://instagram.com/"><i
                                                class="fab fa-instagram"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="th-team team-grid">
                            <div class="team-img"><img src="assets/img/team/team_img_2.jpg" alt="Team"></div>
                            <div class="team-img2"><img src="assets/img/team/team_1_5.jpg" alt="Team"></div>
                            <div class="team-content">
                                <div class="media-body">
                                    <h3 class="box-title"><a href="tour-guider-details.html">Rebeka Maliha</a></h3>
                                    <span class="team-desig">Tourist Guide</span>
                                    <div class="th-social"><a target="_blank" href="https://facebook.com/"><i
                                                class="fab fa-facebook-f"></i></a> <a target="_blank"
                                            href="https://twitter.com/"><i class="fab fa-twitter"></i></a> <a
                                            target="_blank" href="https://linkedin.com/"><i
                                                class="fab fa-linkedin-in"></i></a> <a target="_blank"
                                            href="https://youtube.com/"><i class="fab fa-youtube"></i></a> <a
                                            target="_blank" href="https://instagram.com/"><i
                                                class="fab fa-instagram"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="th-team team-grid">
                            <div class="team-img"><img src="assets/img/team/team_img_3.jpg" alt="Team"></div>
                            <div class="team-img2"><img src="assets/img/team/team_1_6.jpg" alt="Team"></div>
                            <div class="team-content">
                                <div class="media-body">
                                    <h3 class="box-title"><a href="tour-guider-details.html">Alif Mahmud</a></h3>
                                    <span class="team-desig">Tourist Guide</span>
                                    <div class="th-social"><a target="_blank" href="https://facebook.com/"><i
                                                class="fab fa-facebook-f"></i></a> <a target="_blank"
                                            href="https://twitter.com/"><i class="fab fa-twitter"></i></a> <a
                                            target="_blank" href="https://linkedin.com/"><i
                                                class="fab fa-linkedin-in"></i></a> <a target="_blank"
                                            href="https://youtube.com/"><i class="fab fa-youtube"></i></a> <a
                                            target="_blank" href="https://instagram.com/"><i
                                                class="fab fa-instagram"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="th-team team-grid">
                            <div class="team-img"><img src="assets/img/team/team_img_1.jpg" alt="Team"></div>
                            <div class="team-img2"><img src="assets/img/team/team_1_3.jpg" alt="Team"></div>
                            <div class="team-content">
                                <div class="media-body">
                                    <h3 class="box-title"><a href="tour-guider-details.html">Guy Hawkins</a></h3>
                                    <span class="team-desig">Tourist Guide</span>
                                    <div class="th-social"><a target="_blank" href="https://facebook.com/"><i
                                                class="fab fa-facebook-f"></i></a> <a target="_blank"
                                            href="https://twitter.com/"><i class="fab fa-twitter"></i></a> <a
                                            target="_blank" href="https://linkedin.com/"><i
                                                class="fab fa-linkedin-in"></i></a> <a target="_blank"
                                            href="https://youtube.com/"><i class="fab fa-youtube"></i></a> <a
                                            target="_blank" href="https://instagram.com/"><i
                                                class="fab fa-instagram"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="th-team team-grid">
                            <div class="team-img"><img src="assets/img/team/team_img_2.jpg" alt="Team"></div>
                            <div class="team-img2"><img src="assets/img/team/team_1_4.jpg" alt="Team"></div>
                            <div class="team-content">
                                <div class="media-body">
                                    <h3 class="box-title"><a href="tour-guider-details.html">Jenny Wilson</a></h3>
                                    <span class="team-desig">Tourist Guide</span>
                                    <div class="th-social"><a target="_blank" href="https://facebook.com/"><i
                                                class="fab fa-facebook-f"></i></a> <a target="_blank"
                                            href="https://twitter.com/"><i class="fab fa-twitter"></i></a> <a
                                            target="_blank" href="https://linkedin.com/"><i
                                                class="fab fa-linkedin-in"></i></a> <a target="_blank"
                                            href="https://youtube.com/"><i class="fab fa-youtube"></i></a> <a
                                            target="_blank" href="https://instagram.com/"><i
                                                class="fab fa-instagram"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slider-pagination"></div>
            </div><button data-slider-prev="#teamSlider3" class="slider-arrow slider-prev"><img
                    src="assets/img/icon/right-arrow2.svg" alt=""></button> <button data-slider-next="#teamSlider3"
                class="slider-arrow slider-next"><img src="assets/img/icon/left-arrow2.svg" alt=""></button>
        </div>
    </div>
</section>
<div class="elements-sec bg-white overflow-hidden">
    <div class="container-fluid">
        <div class="tags-container relative"></div>
    </div>
</div>
<div class="bg-top-center overflow-hidden" data-bg-src="assets/img/bg/contact_bg_1.jpg">
    <div class="container">
        <div class="row gy-4 justify-content-between align-items-center">
            <div class="col-lg-5">
                <div class="pt-80 p-lg-0">
                    <div class="title-area pe-xl-5"><span class="sub-title text-white">Get in touch</span>
                        <h2 class="sec-title text-white">Say hello to us</h2>
                        <p class="contact-text text-white">We’love to hear from you. Our friendly team is always
                            here to chat</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="contact-form-area">
                    <form action="https://html.themeholy.com/tourm/demo/mail.php" method="POST"
                        class="contact-form2 ajax-contact">
                        <div class="row">
                            <div class="form-group col-12"><input type="text" class="form-control" name="name"
                                    id="name3" placeholder="First Name"> <img src="assets/img/icon/user.svg" alt="">
                            </div>
                            <div class="form-group col-12"><input type="email" class="form-control" name="email3"
                                    id="email3" placeholder="Your Mail"> <img src="assets/img/icon/mail.svg" alt="">
                            </div>
                            <div class="form-group col-12"><select name="subject" id="subject"
                                    class="form-select nice-select">
                                    <option value="Select Tour Type" selected="selected" disabled="disabled">Select
                                        Tour Type</option>
                                    <option value="Africa Adventure">Africa Adventure</option>
                                    <option value="Africa Wild">Africa Wild</option>
                                    <option value="Asia">Asia</option>
                                    <option value="Scandinavia">Scandinavia</option>
                                    <option value="Western Europe">Western Europe</option>
                                </select></div>
                            <div class="form-group col-12"><textarea name="message" id="message" cols="30" rows="3"
                                    class="form-control" placeholder="Your Message"></textarea> <img
                                    src="assets/img/icon/chat.svg" alt=""></div>
                        </div>
                        <p class="form-messages mb-0 mt-3"></p>
                    </form>
                    <div class="form-btn-wrapp">
                        <div class="form-btn"><button class="th-btn white-btn">Send Message <img
                                    src="assets/img/icon/plane3.svg" alt=""></button></div>
                        <div class="contact-info">
                            <p class="contact-info_link"><a href="tel:+0123456789">+012 345 6789</a></p>
                            <div class="contact-info_icon"><a href="tel:+0123456789"><img
                                        src="assets/img/icon/call.svg" alt=""></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="testi-area3 bg-bottom-center overflow-hidden space" id="testi-sec"
    data-bg-src="assets/img/bg/map.png">
    <div class="container">
        <div class="title-area text-center"><span class="sub-title">Testimonials</span>
            <h2 class="sec-title">Our Clients Feedback</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="swiper th-slider testiSlide3" id="testiSlide3"
                    data-slider-options='{"effect":"slide","loop":false,"thumbs":{"swiper":".testi-grid-thumb"}}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testi-grid">
                                <div class="testi-grid_author"><img src="assets/img/testimonial/testi_3_1.png"
                                        alt="Avater"></div>
                                <div class="testi-grid_content">
                                    <p class="testi-grid_text">“A home that perfectly blends sustainability with
                                        luxury until discovered Ecoland Residence. The moment I stepped community, I
                                        knew it was where I wanted to live.”</p>
                                    <h6 class="testi-grid_name box-title">Andrew Simon</h6><span
                                        class="testi-grid_desig">Traveller</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-grid">
                                <div class="testi-grid_author"><img src="assets/img/testimonial/testi_3_2.png"
                                        alt="Avater"></div>
                                <div class="testi-grid_content">
                                    <p class="testi-grid_text">“The home boasts sleek, contemporary architecture
                                        with clean lines and expansive windows, allowing natural light to flood the
                                        interiors It incorporates passive design principles”</p>
                                    <h6 class="testi-grid_name box-title">Maria Doe</h6><span
                                        class="testi-grid_desig">Traveller</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-grid">
                                <div class="testi-grid_author"><img src="assets/img/testimonial/testi_3_3.png"
                                        alt="Avater"></div>
                                <div class="testi-grid_content">
                                    <p class="testi-grid_text">“Solar panels adorn the roof, harnessing renewable
                                        energy to power the home and even feed excess electricity back into the
                                        grid. High-performance insulation and triple-glazed”</p>
                                    <h6 class="testi-grid_name box-title">Angelina Rose</h6><span
                                        class="testi-grid_desig">Traveller</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-grid">
                                <div class="testi-grid_author"><img src="assets/img/testimonial/testi_3_4.png"
                                        alt="Avater"></div>
                                <div class="testi-grid_content">
                                    <p class="testi-grid_text">A sophisticated rainwater harvesting system collects
                                        and filters rainwater for irrigation and non-potable uses, reducing reliance
                                        on municipal water sources. Greywater systems</p>
                                    <h6 class="testi-grid_name box-title">Michel Carlos</h6><span
                                        class="testi-grid_desig">Traveller</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-grid">
                                <div class="testi-grid_author"><img src="assets/img/testimonial/testi_3_5.png"
                                        alt="Avater"></div>
                                <div class="testi-grid_content">
                                    <p class="testi-grid_text">Throughout the interior, eco-friendly materials like
                                        reclaimed wood, bamboo flooring, and recycled glass countertops create a
                                        luxurious yet sustainable ambiance.</p>
                                    <h6 class="testi-grid_name box-title">Michel Smith</h6><span
                                        class="testi-grid_desig">Traveller</span>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-grid">
                                <div class="testi-grid_author"><img src="assets/img/testimonial/testi_3_6.png"
                                        alt="Avater"></div>
                                <div class="testi-grid_content">
                                    <p class="testi-grid_text">“A home that perfectly blends sustainability with
                                        luxury until discovered Ecoland Residence. The moment I stepped community, I
                                        knew it was where I wanted to live.”</p>
                                    <h6 class="testi-grid_name box-title">Jesmen</h6><span
                                        class="testi-grid_desig">Traveller</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slider-pagination"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="swiper th-slider testi-grid-thumb"
        data-slider-options='{"effect":"slide","slidesPerView":"6","spaceBetween":7,"loop":false}'>
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="box-img"><img src="assets/img/testimonial/testi_3_1.png" alt="Image"></div>
            </div>
            <div class="swiper-slide">
                <div class="box-img"><img src="assets/img/testimonial/testi_3_2.png" alt="Image"></div>
            </div>
            <div class="swiper-slide">
                <div class="box-img"><img src="assets/img/testimonial/testi_3_3.png" alt="Image"></div>
            </div>
            <div class="swiper-slide">
                <div class="box-img"><img src="assets/img/testimonial/testi_3_4.png" alt="Image"></div>
            </div>
            <div class="swiper-slide">
                <div class="box-img"><img src="assets/img/testimonial/testi_3_5.png" alt="Image"></div>
            </div>
            <div class="swiper-slide">
                <div class="box-img"><img src="assets/img/testimonial/testi_3_6.png" alt="Image"></div>
            </div>
        </div>
    </div>
    <div class="shape-mockup movingX d-none d-xl-block" data-top="20%" data-left="5%"><img class="gmovingX"
            src="assets/img/shape/shape_7.png" alt="shape"></div>
    <div class="shape-mockup spin d-none d-xl-block" data-bottom="12%" data-right="5%"><img
            src="assets/img/shape/shape_2_5.png" alt="shape"></div>
    <div class="shape-mockup jump d-none d-xl-block" data-bottom="15%" data-left="5%"><img
            src="assets/img/shape/shape_2_2.png" alt="shape"></div>
</section>
<div class="brand-area overflow-hidden space">
    <div class="container th-container">
        <div class="swiper th-slider brandSlider1" id="brandSlider1"
            data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"3"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"6"},"1400":{"slidesPerView":"8"}}}'>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="brand-box"><a href="#"><img class="original" src="assets/img/brand/brand_1_1.svg"
                                alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_1.svg"
                                alt="Brand Logo"></a></div>
                </div>
                <div class="swiper-slide">
                    <div class="brand-box"><a href="#"><img class="original" src="assets/img/brand/brand_1_2.svg"
                                alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_2.svg"
                                alt="Brand Logo"></a></div>
                </div>
                <div class="swiper-slide">
                    <div class="brand-box"><a href="#"><img class="original" src="assets/img/brand/brand_1_3.svg"
                                alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_3.svg"
                                alt="Brand Logo"></a></div>
                </div>
                <div class="swiper-slide">
                    <div class="brand-box"><a href="#"><img class="original" src="assets/img/brand/brand_1_4.svg"
                                alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_4.svg"
                                alt="Brand Logo"></a></div>
                </div>
                <div class="swiper-slide">
                    <div class="brand-box"><a href="#"><img class="original" src="assets/img/brand/brand_1_5.svg"
                                alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_5.svg"
                                alt="Brand Logo"></a></div>
                </div>
                <div class="swiper-slide">
                    <div class="brand-box"><a href="#"><img class="original" src="assets/img/brand/brand_1_6.svg"
                                alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_6.svg"
                                alt="Brand Logo"></a></div>
                </div>
                <div class="swiper-slide">
                    <div class="brand-box"><a href="#"><img class="original" src="assets/img/brand/brand_1_7.svg"
                                alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_7.svg"
                                alt="Brand Logo"></a></div>
                </div>
                <div class="swiper-slide">
                    <div class="brand-box"><a href="#"><img class="original" src="assets/img/brand/brand_1_8.svg"
                                alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_8.svg"
                                alt="Brand Logo"></a></div>
                </div>
                <div class="swiper-slide">
                    <div class="brand-box"><a href="#"><img class="original" src="assets/img/brand/brand_1_4.svg"
                                alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_4.svg"
                                alt="Brand Logo"></a></div>
                </div>
                <div class="swiper-slide">
                    <div class="brand-box"><a href="#"><img class="original" src="assets/img/brand/brand_1_3.svg"
                                alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_3.svg"
                                alt="Brand Logo"></a></div>
                </div>
                <div class="swiper-slide">
                    <div class="brand-box"><a href="#"><img class="original" src="assets/img/brand/brand_1_2.svg"
                                alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_2.svg"
                                alt="Brand Logo"></a></div>
                </div>
                <div class="swiper-slide">
                    <div class="brand-box"><a href="#"><img class="original" src="assets/img/brand/brand_1_1.svg"
                                alt="Brand Logo"> <img class="gray" src="assets/img/brand/brand_1_1.svg"
                                alt="Brand Logo"></a></div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="bg-smoke overflow-hidden space">
    <div class="container">
        <div class="row justify-content-lg-between justify-content-center align-items-end">
            <div class="col-lg">
                <div class="title-area text-center text-lg-start"><span class="sub-title">Blog and Article</span>
                    <h2 class="sec-title">Blog & Articles From Tourm</h2>
                </div>
            </div>
            <div class="col-lg-auto d-none d-lg-block">
                <div class="sec-btn"><a href="blog.html" class="th-btn style4 th-icon">See More Articles</a></div>
            </div>
        </div>
        <div class="row gx-24 gy-30">
            <div class="col-xl-5">
                <div class="blog-grid th-ani">
                    <div class="blog-img global-img"><img src="assets/img/blog/blog_3_1.jpg" alt="blog image"></div>
                    <div class="blog-grid_content">
                        <div class="blog-meta"><a class="author" href="blog.html">July 05, 2024</a> <a
                                href="blog.html">6 min read</a></div>
                        <h3 class="box-title"><a href="blog-details.html">Travel agency for those who want to
                                explore the world and try to make adventure</a></h3><a href="blog-details.html"
                            class="th-btn style4 th-icon">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="blog-grid style2 th-ani">
                    <div class="blog-img global-img"><img src="assets/img/blog/blog_3_2.jpg" alt="blog image"></div>
                    <div class="blog-grid_content">
                        <div class="blog-meta"><a class="author" href="blog.html">July 07, 2024</a> <a
                                href="blog.html">7 min read</a></div>
                        <h3 class="box-title"><a href="blog-details.html">The best time to visit japan & enjoy the
                                cherry blossoms</a></h3><a href="blog-details.html"
                            class="th-btn style4 th-icon">Read More</a>
                    </div>
                </div>
                <div class="blog-grid th-ani style2 mt-24">
                    <div class="blog-img global-img"><img src="assets/img/blog/blog_3_3.jpg" alt="blog image"></div>
                    <div class="blog-grid_content">
                        <div class="blog-meta"><a class="author" href="blog.html">July 10, 2024</a> <a
                                href="blog.html">8 min read</a></div>
                        <h3 class="box-title"><a href="blog-details.html">Hiden history of Japan in the world and
                                try to make adventure</a></h3><a href="blog-details.html"
                            class="th-btn style4 th-icon">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="shape-mockup shape1 d-none d-xxl-block" data-top="14%" data-right="9%"><img
            src="assets/img/shape/shape_1.png" alt="shape"></div>
    <div class="shape-mockup shape2 d-none d-xl-block" data-top="25%" data-right="6%"><img
            src="assets/img/shape/shape_2.png" alt="shape"></div>
    <div class="shape-mockup shape3 d-none d-xxl-block" data-top="15%" data-right="4%"><img
            src="assets/img/shape/shape_3.png" alt="shape"></div>
    <div class="shape-mockup movingX d-none d-xxl-block" data-bottom="0%" data-right="10%"><img
            src="assets/img/shape/shape_9.png" alt="shape"></div>
</section>


    
@endsection