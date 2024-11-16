@extends('frontend.layouts.master')
@section('title', 'Career')
@section('meta_description', '')
@section('content')


<section class="Career-section  d-flex align-items-center justify-content-center">
    <h1 class="career-head">Career</h1>
</section>

<div class="container Tourism-Manneger py-5">
    <p class="TMP mt-5 mb-5 py-5">Joining BharatYatra offers a dynamic career opportunity in the vibrant travel
        industry. As part of our team, you’ll embark on a journey filled with growth, learning, and excitement.</p>

    <div class="row mt-5 align-items-center">
        <div class="col-md-8">
            <img src="{{ asset('assets/images/tourism-manager-img.webp')}}" width="100%" height="100%" alt="">
        </div>

        <div class="col-md-4 Tourism-translate">
            <div class="card shadow-lg bg-dark text-white py-3 px-2">
                <div class="card-body">
                    <h3 class="card-title"> TOURISM MANAGER</h3>

                    <hr style="border-width: 4px; color: white;">

                    <p class="mb-3" style="font-size: 16px; line-height: 26px; text-justify: auto;">Join us at
                        MakeMyBharatYatra as a Tourism Manager and lead the way in crafting unforgettable travel
                        experiences. In this role, you’ll oversee all aspects of tourism operations, from itinerary
                        planning to customer satisfaction. With your passion for travel and keen attention to detail,
                        you’ll ensure seamless journeys for our customers, making their dreams a reality. Take the helm
                        in our dynamic team and be part of shaping the future of travel with MakeMyBharatYatra.
                    </p>

                    <a href="{{ route('careerApply')}}" class="btn btn-primary btn-lg">Apply Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container Tourism-Ececutive mt-5 mb-5">

    <div class="row  mt-5 py-5 align-items-center">

        <div class="col-md-4 Tourism-secondbox">
            <div class="card shadow-lg bg-dark text-white py-3 px-2">
                <div class="card-body">
                    <h3 class="card-title">TOURISM EXECUTIVE </h3>

                    <hr style="border-width: 4px; color: white;">

                    <p class="mb-3" style="font-size: 16px; line-height: 35px; text-justify: auto; padding: 50px 20px;">
                        As a Tourism Executive with MakeMyBharatYatra, you’ll play a pivotal role in crafting
                        unforgettable travel experiences for our customers.
                        Join our dynamic team and embark on a journey filled with growth, excitement, and opportunities
                        to make a lasting impact in the vibrant travel industry. </p>

                    <a href="{{ route('careerApply')}}" class="btn btn-primary btn-lg">Apply Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <img src="{{ asset('assets/images/tourism-executive.jpg')}}" width="100%"  alt="">
        </div>

    </div>
</div>

<div class="container Customer Service Associate mt-5 mb-5">

    <div class="row mt-5 align-items-center">

        <div class="col-md-7">
            <img src="{{ asset('assets/images/Customer-Service-Associate-Jobs.jpg')}}" width="100%" height="100%" alt="">
        </div>

        <div class="col-md-5   Tourism-translate">
            <div class="card shadow-lg bg-dark text-white py-3 px-2">
                <div class="card-body">
                    <h3 class="card-title"> CUSTOMER SERVICE ASSOCIATE</h3>

                    <hr style="border-width: 4px; color: white;">

                    <p class="mb-3" style="font-size: 16px; line-height: 26px; text-justify: auto;">Join
                        MakeMyBharatYatra as a Customer Support Associate and embark on a fulfilling career in the
                        travel industry. As part of our passionate team, you’ll provide exceptional service to our
                        customers, assisting them with inquiries, resolving issues, and ensuring their travel
                        experiences are seamless and memorable. Enjoy a dynamic work environment, opportunities for
                        growth, and the chance to make a positive impact on travelers’ journeys. Join us in creating
                        unforgettable memories for our customers at MakeMyBharatYatra.</p>

                    <a href="{{ route('careerApply')}}" class="btn btn-primary btn-lg">Apply Now</a>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="container Tour Agent mt-5 mb-5">

    <div class="row mt-5 py-5 align-items-center">

        <div class="col-md-4  Tourism-secondbox ">
            <div class="card shadow-lg bg-dark text-white py-3 px-2">
                <div class="card-body">
                    <h3 class="card-title">TOUR AGENT </h3>

                    <hr style="border-width: 4px; color: white;">

                    <p class="mb-3" style="font-size: 16px; line-height: 26px; text-justify: auto;">
                        Joining MakeMyBharatYatra as a tour agent offers an exciting career opportunity in the travel
                        industry. As part of our team, you’ll help create unforgettable experiences for travelers,
                        handling bookings, organizing itineraries, and providing exceptional service. With opportunities
                        for growth, a supportive team environment, and rewarding benefits, a career as a tour agent with
                        MakeMyBharatYatra is your gateway to an exciting and fulfilling career in travel. </p>

                    <a href="{{ route('careerApply')}}" class="btn btn-primary btn-lg">Apply Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <img src="{{ asset('assets/images/tour-agent.jpg')}}" width="100%" height="100%" alt="">
        </div>

    </div>
</div>


<div class="container Ticket Service Executive  mt-5 mb-5">

    <div class="row mt-5 align-items-center">

        <div class="col-md-8">
            <img src="{{ asset("assets/images/ticket-service-executive.jpg")}}" width="100%" height="100%" alt="">
        </div>

        <div class="col-md-4  Tourism-translate">
            <div class="card shadow-lg bg-dark text-white py-3 px-2">
                <div class="card-body">
                    <h3 class="card-title"> TICKET SERVICE EXECUTIVE</h3>

                    <hr style="border-width: 4px; color: white;">

                    <p class="mb-3" style="font-size: 16px; line-height: 26px; text-justify: auto;">Join us at
                        MakeMyBharatYatra as a Ticket Support Executive and be at the forefront of delivering
                        exceptional customer service. As part of our dynamic team, you’ll assist travelers with their
                        inquiries, resolve issues, and ensure every customer receives personalized assistance. Enjoy a
                        rewarding career where you’ll make a difference in travelers’ journeys while gaining valuable
                        experience and opportunities for growth. Join us and be part of creating memorable travel
                        experiences for our customers.</p>


                    <a href="{{ route('careerApply')}}" class="btn btn-primary btn-lg">Apply Now</a>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="container Passenger-Service-Associate  mt-5 mb-5">

    <div class="row mt-5 py-5 align-items-center">

        <div class="col-md-5  Tourism-secondbox ">
            <div class="card shadow-lg bg-dark text-white py-3 px-2">
                <div class="card-body">
                    <h3 class="card-title">PASSENGER SERVICE ASSOCIATE </h3>

                    <hr style="border-width: 4px; color: white;">

                    <p class="mb-3" style="font-size: 16px; line-height: 26px; text-justify: auto;">
                        Join MakeMyBharatYatra as a Passenger Service Associate and embark on a rewarding career in the
                        travel industry. As a key member of our team, you’ll assist passengers with their travel needs,
                        provide exceptional customer service, and ensure smooth and enjoyable travel experiences. With
                        opportunities for growth, a supportive work environment, and a passion for creating memorable
                        journeys, MakeMyBharatYatra offers an exciting career path for individuals who are dedicated to
                        making every trip unforgettable. </p>

                    <a href="{{ route('careerApply')}}" class="btn btn-primary btn-lg">Apply Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <img src="{{ asset('assets/images/passenger-service.webp')}}" width="100%" height="100%" alt="">
        </div>

    </div>
</div>

<div class="container Sales-Executive-Manager  mt-5 mb-5">

    <div class="row mt-5 align-items-center">

        <div class="col-md-8">
            <img src="{{ asset('assets/images/sales-executive-manager.jpg')}}" width="100%" height="100%" alt="">
        </div>

        <div class="col-md-4  Tourism-translate">
            <div class="card shadow-lg bg-dark text-white py-3 px-2">
                <div class="card-body">
                    <h3 class="card-title"> SALES EXECUTIVE/ MANAGER</h3>

                    <hr style="border-width: 4px; color: white;">

                    <p class="mb-3" style="font-size: 16px; line-height: 26px; text-justify: auto;">Join
                        MakeMyBharatYatra as a Sales Executive and become part of an exciting journey in the travel
                        industry. As a Sales Executive, you’ll play a vital role in promoting our diverse range of
                        travel products and services, helping customers create unforgettable experiences. Join our
                        passionate team, enjoy continuous learning and growth opportunities, and contribute to making
                        travel dreams a reality. Apply now and embark on a rewarding career with MakeMyBharatYatra!
                    </p>


                    <a href="{{ route('careerApply')}}" class="btn btn-primary btn-lg">Apply Now</a>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="container Relationship-Executive mt-5 mb-5">

    <div class="row mt-5 py-5 align-items-center">

        <div class="col-md-4   Tourism-secondbox">
            <div class="card shadow-lg bg-dark text-white py-3 px-2">
                <div class="card-body">
                    <h3 class="card-title">RELATIONSHIP EXECUTIVE / MANAGER</h3>

                    <hr style="border-width: 4px; color: white;">

                    <p class="mb-3" style="font-size: 16px; line-height: 26px; text-justify: auto;">
                        Join a dynamic team at MakeMyBharatYatra as a Relationship Executive/ Manager, where you’ll play
                        a vital role in building and nurturing relationships with our valued customers. As a
                        Relationship Executive/ Manager, you’ll have the opportunity to provide personalized assistance,
                        address inquiries, and ensure customer satisfaction. Join us and embark on a rewarding career
                        journey in the travel industry, where you’ll help create unforgettable experiences for our
                        customers and make travel dreams come true. </p>

                    <a href="{{ route('careerApply')}}" class="btn btn-primary btn-lg">Apply Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <img src="{{ asset("assets/images/relationship-manager-executive.webp")}}" width="100%" height="100%" alt="">
        </div>

    </div>
</div>
@endsection