@extends('frontend.layouts.master')

@section('title', 'Our Service')
@section('meta_description', 'Make My Bharat Yatra Service')

@section('content')


<section class="service-section   d-flex align-items-center justify-content-center">

    <h1>Our Services</h>
</section>


<div class="container service-second-section mt-5">
    <h2>It's Time to Start Your 
        Adventures<h2>
            <p> Eleveating Your Travel Experience</p>

            <div class="row mt-5 ">
                <div class="col-md-6">
                    <img src="{{ asset('assets/images/service-welcome.jpg')}}" width="100%" ,
                        height="100%" alt>
                </div>

                <div class="col-md-6">
                    <h3 class="welcome-head mt-5 ">Welcome to Make My Bharat
                        Yatra</h3>
                    <p class="welcome-page mt-4">Make My Bharat Yatra stands
                        among the top-rated aviation and tour & travel companies
                        in India, specializing in budget-friendly getaways,
                        holiday packages, and Domestic & International Airlines
                        Services. With a reputation for delivering satisfying
                        tourism experiences, we offer fantastic discounts on
                        airline tickets through our esteemed Indian travel
                        agency. Book with us for the most affordable prices to
                        destinations worldwide.

                        As a leading travel website in India, we tirelessly work
                        to make your trips memorable. Why search elsewhere when
                        we offer specialized holiday packages and deals? With
                        all the necessary information provided prior to your
                        trip, enjoy fantastic savings on getaways,
                        accommodations, and excursions. Contact us now for
                        significant discounts and an unforgettable trip on a
                        tight budget.</p>
                </div>
            </div>
        </div>

        <div class="container ">
            <h4 class="services-swiper mt-5 mb-5">Our Services</h4>
            <div class="row">
                <div class="swiper  serviceSlider px-3">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="card card-body p-0">
                                  <img src="{{ asset("assets/images/service2.jpeg")}}" width="100%" height="100%"  alt="">
                                  <div class="desc py-3 px-3">
                                    <h5 class="swiper-tophead">Travel Planning Assistance</h5>
                                      <p>
                                      Let our dedicated team of travel experts assist you in planning your dream vacation. From personalized itinerary recommendations to booking flights and activities, we're here to ensure every aspect of your trip is seamless and stress-free.</p>
                                  </div>
                              </div>
                            </div>
                      




                      
                            <div class="swiper-slide">
                            <div class="card card-body p-0">
                                  <img src="{{ asset('assets/images/service3.jpeg')}}"  width="100%"   height="100%"   alt="">
                                  <div class="desc px-3 py-3">
                                    <h5 class="swiper-tophead">Resort Accommodation</h5>
                                      <p>
                                      Experience the comfort and luxury of our handpicked resorts located in some of the most picturesque destinations in India. Whether you're seeking relaxation, adventure, or cultural immersion, we have the perfect accommodations for every traveler.</p>
                                  </div>
                              </div>
                            </div>
                      
                      
                      
                            <div class="swiper-slide">
                            <div class="card card-body p-0">
                                  <img src="{{ asset('assets/images/service4.jpeg')}}"  width="100%" height="100%" alt="">
                                  <div class="desc  px-3 py-3">
                                    <h5 class="swiper-tophead">Customer Support</h5>
                                      <p>
                                      At MakeMyBharatYatra, customer satisfaction is our top priority. Our friendly and knowledgeable support team is available to assist you with any inquiries, concerns, or assistance you may need before, during, or after your vacation.</p>
                                  </div>
                              </div>
                            </div>



                           
                      



                            
                            <div class="swiper-slide">
                            <div class="card card-body p-0">
                                  <img src="{{ asset("assets/images/service4.jpeg")}}" width="100%" height="100%" alt="">
                                  <div class="desc  px-3 py-3">
                                    <h5 class="swiper-tophead">Sustainability Initiatives </h5>
                                      <p>
							We are committed to promoting responsible and sustainable tourism practices. Through our initiatives, we aim to minimize our environmental impact, support local communities, and preserve the natural beauty and cultural heritage of our destinations.</p>
                                  </div>
                              </div>
                            </div>
                


                      
                      
                            <div class="swiper-slide">
                            <div class="card card-body p-0">
                                  <img src="{{ asset("assets/images/service5.jpeg")}}"  width="100%" height="100%" alt="">
                                  <div class="desc px-3 py-3">
                                  <h5 class="swiper-tophead">Special Offer And Promotion</h5>
                                      <p class="desc-p-content">
                                        Take advantage of our exclusive deals, discounts, and promotions to make your vacation experience even more rewarding. From seasonal specials to limited-time offers, there's always a way to save on your next getaway with MakeMyBharatYatra.</p>
                                  </div>
                              </div>
                            </div>

                    </div>
                </div>
            

            </div>
        </div>

            



            
    
@endsection