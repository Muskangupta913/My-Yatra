@extends('frontend.layouts.master')

@section('title', 'Our Service')
@section('meta_description', 'Make My Bharat Yatra Service')
@section('content')


    <section class="service-section   d-flex align-items-center justify-content-center">
        <h1>Our Services</h1>
    </section>

    <div class="container service-second-section mt-5">
        <h2>It's Time to Start Your Adventures<h2>
                <p> Eleveating Your Travel Experience</p>
                <div class="row mt-5 ">
                    <div class="col-md-6">
                        <img src="{{ asset('assets/images/service-welcome.jpg') }}" width="100%" , height="100%" alt>
                    </div>

                    <div class="col-md-6">
                        <h3 class="welcome-head mt-5 ">Welcome to Make My Bharat
                            Yatra</h3>
                        <p class="welcome-page mt-4">Make My Bharat Yatra is one of India's leading tour & travel companies in India offering budget vacations, holiday packages, and Domestic & International airline services. As a company that excels in providing a satisfactory tourism experience, we have amazing offers on airfare booking from our highly reputed Indian travel agency. Travel with us to enjoy the lowest rates for flights to all around the globe. Being one of India's best travel and tourism websites, we work day and night to make your holidays unforgettable. Why look anywhere else when we provide specialized holiday packages and offers? Enjoy great savings on holidays, accommodations, and tours with all the information required before you leave. Call us now for great discounts and an unforgettable holiday on a low budget.</p>
                    </div>
                </div>
    </div>

    <div class="container ">
        <h4 class="services-swiper mt-5 mb-5">Our Services</h4>
        <div class="row">
            <div class="swiper serviceSlider px-3">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="card card-body p-0" style="height: 100%;">
                            <img src="{{ asset('assets/images/service2.jpeg') }}" width="100%" height="100%" alt="">
                            <div class="desc py-3 px-3">
                                <h5 class="swiper-tophead">Travel Planning Assistance</h5>
                                <p>
                                    Planning a vacation can be thrilling but also daunting. From selecting destinations to reserving flights and hotels, there are numerous details to take into account. That's where travel planning support comes in to assist you in arranging every detail of your trip smoothly and effectively.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card card-body p-0" style="height: 100%;">
                            <img src="{{ asset('assets/images/resort.jpg') }}" width="100%" height="100%" alt="">
                            <div class="desc px-3 py-3">
                                <h5 class="swiper-tophead">Resort Accommodation</h5>
                                <p>
                                    Enjoy the ultimate resort stay with lavish rooms, stunning views, and excellent amenities. Whether you want relaxation by the pool, activity-packed pursuits, or gourmet dining, our resort has it all for an unforgettable experience. Book your dream vacation today.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card card-body p-0" style="height: 100%;">
                            <img src="{{ asset('assets/images/customer.jpg') }}" width="100%" height="100%" alt="">
                            <div class="desc px-3 py-3">
                                <h5 class="swiper-tophead">Customer Support</h5>
                                <p>
                                    Improve your travel and tourism website with superior customer service! Offer smooth booking support, instant question answering, and customized travel advice. Provide a trouble-free experience for tourists with 24/7 support, chatbots, and trained agents for memories to last a lifetime.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card card-body p-0" style="height: 100%;">
                            <img src="{{ asset('assets/images/sustain.jpg') }}" width="100%" height="100%" alt="">
                            <div class="desc px-3 py-3">
                                <h5 class="swiper-tophead">Sustainability Initiatives</h5>
                                <p>
                                    Best holiday tour packages in India that meld natural beauty and rich culture. Travel in an eco-friendly way backed up with sustainability initiatives, thus ensuring a responsible and unforgettable experience through magnificent landscapes and heritage sites.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="card card-body p-0" style="height: 100%;">
                            <img src="{{ asset('assets/images/offer.jpg') }}" width="100%" height="100%" alt="">
                            <div class="desc px-3 py-3">
                                <h5 class="swiper-tophead">Special Offer And Promotion</h5>
                                <p class="desc-p-content">
                                    Don't miss our special offer on Make My Bharat Yatra. See the beauty of India at priceless prices. Book now for a special deal and a beautiful journey. Book today for a limited time.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
                <!-- Add Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.serviceSlider', {
            slidesPerView: 1,
            spaceBetween: 10,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                },
            },
        });
    </script>
@endpush

@push('styles')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
@endpush
