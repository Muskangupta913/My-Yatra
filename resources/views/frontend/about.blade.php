@extends('frontend.layouts.master')
@section('title', 'About Us - Make My Bharat Yatra')
@section('meta_description', '')

@section('content')

<div class="container-fluid about-section d-flex align-items-center justify-content-center">
    <h1>About Us<h1>
</div>

<section class="bg-light py-5">
    <div class="container py-5 mb-5 mt-5 about-s-box bg-light ">
        <div class="row">

            <div class="col-md-6" style="position: relative;">

                <div class="animation-frame" style="position: absolute; right:20%; top: -40px; z-index: 1;">
                    <img src="{{ asset('assets/images/about-shape-img.png')}}" width="120" alt="">
                </div>

                <img class="about-travel" src="{{ asset('assets/images/about-img-3.png')}}"
                    style="position: relative; z-index: 2;" class="shadow rounded-2" width="500px" alt="">

                <div class="caption-img" style="position: absolute; left: 26px; bottom: -60px; z-index: 3;">
                    <img src="{{ asset('assets/images/chotu-keyframe-img.png')}}"
                        style="border: 10px solid white; border-radius: 5px;" width="200px" alt="">
                </div>

            </div>


            <div class="col-md-6 aboutMobile">
                <h2 class="aus">ABOUT US</h2>
                <p class="aboutP-Content" style="line-height: 25px;">
                    Welcome to Make My Bharat Yatra Pvt. Ltd., your go-to destination for unforgettable tour and travel
                    experiences. Since our inception in 2010, we have been passionate about creating personalized travel
                    journeys that leave lasting memories.</p>

                <h4>Our Expertise: </h4>

                <ul>
                    <li class="mb-3"><b>Tour and Travel Services:</b> At the heart of our operations, we specialize in
                        providing meticulously crafted domestic and international tour packages. Whether you're seeking
                        a serene getaway, an adventurous escape, or a cultural exploration, we curate experiences that
                        cater to every traveler’s desires.</li>

                    <li class="mb-3"><b>Customized Itineraries:</b> We believe every journey should be unique. That’s
                        why we design custom itineraries that align with your preferences, ensuring a seamless travel
                        experience from start to finish.</li>

                    <li class="mb-3"><b>Local and Global Reach:</b> From exploring the hidden gems of India to venturing
                        abroad, our extensive network allows us to offer a wide range of tour options.</li>
                </ul>

                 <p class="fw-bold">Make My Bharat Yatra was established in 2010 and registered in Domestic & International Airlines Services, Travel & Tourism Trust in 2015 NCT (NATIONAL CAPITAL TERRITORY - Government of India) and our company MSME was registered in 2024.
                </p>

                {{-- <p class="important-headline ">
                    "Discover the magic of travel with MakeMyBharatYatra India. Every journey is an opportunity to
                    create unforgettable memories."
                </p>

                <p class="aboutP-Content">
                    Make My Bharat Yatra was established in 2010 and registered in Domestic & International Airlines
                    Services, Travel & Tourism Trust in 2015 NCT <b>(NATIONAL CAPITAL TERRITORY - Government of
                        India)</b> and our company MSME was registered in 2024.</p> --}}

            </div>

        </div>

      
    </div>
</section>






<div class="container mt-5 ">
    <div class="row ">
        <div class="col-md-10 m-auto shadow">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('assets/images/vision1.jpg')}}" width="100%" height="100%" alt="">
                </div>

                <div class="col-md-6 px-3 py-5">
                    <h3 class="top-4c">Vision</h3>
                    <p class="top-4p">At Make My Bharat Yatra, we aim to redefine the travel experience by blending comfort, convenience, and unique destinations, all while delivering exceptional customer service.</p>
                </div>
            </div>

        </div>

    </div>

    <div class="row">
        <div class="col-md-10 m-auto shadow mt-5">
            <div class="row">
                <div class="col-md-6 py-5">
                    <h3 class="top-4c">Mission</h3>
                    <p class="top-4p ">At Make My Bharat Yatra, our vision is to be the premier provider of unforgettable family
                        vacations, offering unparalleled access to diverse destinations and delivering exceptional
                        service that exceeds expectations.</p>
                </div>
                <div class="col-md-6">
                    <img src="{{asset('assets/images/mission.jfif')}}" width="100%" height="100%" alt="">
                </div>


            </div>

        </div>

    </div>

    <div class="row mt-5">
    <div class="col-md-10 m-auto">
        <div class="card shadow rounded-0 card-body border-0">
            <h4 class="mb-3">Upcoming Services:</h4>
            <ul>
                <li class="mb-3"> <span class="fw-bold">Train Booking:</span> We are in the process of expanding our services to include domestic and international flight bookings, making your travel planning even more convenient.</li>

                <li class="mb-3"> <span class="fw-bold"> Hotel Booking:</span> Soon, we will be offering hotel booking services, ensuring that your accommodation needs are taken care of effortlessly.</li>

                <li class="mb-3"> <span class="fw-bold">  Cab, Bus, and Train Booking:</span> We are also working to introduce comprehensive transportation booking options for cabs, buses, and trains to enhance your travel experience.</li>
            </ul>
        </div>
    </div>
</div>
</div>



<!-- <div class="row"> -->
<!-- <div class="col-md-10 m-auto shadow">
            <div class="row mt-5">
               
             
                     <div class="col-md-6 px-3">
                         <h3 class="top-4c">Mission</h3>
                         <p class="top-4p ">At BharatYatra, our vision is to be the premier provider of unforgettable family vacations, offering unparalleled access to diverse destinations and delivering exceptional service that exceeds expectations.</p>
                     </div>

                     <div class="col-md-6">
                        <img src=""  width="100%" height="100%" alt="">
                         </div>
            </div>

        </div>
       



        
    
            </div>
           
    

            

           
                    </div>
        
                </div> 
               
        
        






    <!-- </div> -->
@endsection