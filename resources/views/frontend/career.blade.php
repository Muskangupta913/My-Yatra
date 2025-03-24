@extends('frontend.layouts.master')
@section('title', 'Career Opportunities')
@section('meta_description', 'Explore exciting career opportunities with Make My Bharat Yatra in the tourism and travel industry')
@section('content')

<style>
    /* Banner styles */
    .Career-section {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset("assets/images/career-banner.jpg") }}');
        background-size: cover;
        background-position: center;
        height: 300px;
        color: white;
        margin-bottom: 2rem;
        text-align: center;
    }

    .career-head {
        font-size: 3rem;
        font-weight: 700;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    /* Job section styles */
    .job-section {
        padding: 3rem 0;
    }

    .job-section:nth-child(even) {
        background-color: #f8f9fa;
    }

    /* Intro text */
    .intro-text {
        font-size: 1.25rem;
        line-height: 1.8;
        text-align: center;
        max-width: 900px;
        margin: 0 auto 2rem;
        color: #444;
    }

    /* Job card styles */
    .job-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        height: 100%;
        transition: transform 0.3s ease;
    }

    .job-card:hover {
        transform: translateY(-10px);
    }

    .job-card .card-body {
        padding: 1.75rem;
    }

    .job-card .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .job-card hr {
        border-width: 3px;
        margin: 1rem 0;
        opacity: 0.8;
    }

    .job-card .card-text {
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .job-card .btn {
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .job-card .btn:hover {
        transform: scale(1.05);
    }

    /* Image styles */
    .job-image {
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .job-image:hover {
        transform: scale(1.02);
    }

    /* Responsive adjustments */
    @media (max-width: 991px) {
        .Career-section {
            height: 220px;
        }

        .career-head {
            font-size: 2.5rem;
        }

        .job-card {
            margin-bottom: 2rem;
        }

        .reverse-mobile {
            flex-direction: column-reverse;
        }
    }

    @media (max-width: 767px) {
        .Career-section {
            height: 180px;
        }

        .career-head {
            font-size: 2rem;
        }

        .intro-text {
            font-size: 1.1rem;
            padding: 0 1rem;
        }

        .job-card .card-title {
            font-size: 1.3rem;
        }

        .job-image {
            margin-bottom: 1.5rem;
        }

        .job-section {
            padding: 2rem 0;
        }
    }
</style>

<section class="Career-section d-flex align-items-center justify-content-center">
    <h1 class="career-head">Career Opportunities</h1>
</section>

<div class="container">
    <p class="intro-text">
        Joining Bharat Yatra opens the door to an exciting career in the lively travel industry. 
        When you become part of our team, you'll set off on a journey brimming with growth, 
        learning, and plenty of adventure. Explore travel and tourism jobs!
    </p>
</div>

<!-- Tourism Manager -->
<div class="container job-section">
    <div class="row align-items-center">
        <div class="col-lg-7 col-md-6 mb-4 mb-md-0">
            <img src="{{ asset('assets/images/tourism-manager-img.webp') }}" class="job-image" alt="Tourism Manager">
        </div>
        <div class="col-lg-5 col-md-6">
            <div class="card job-card bg-dark text-white">
                <div class="card-body">
                    <h3 class="card-title">TOURISM MANAGER</h3>
                    <hr style="color: white;">
                    <p class="card-text">
                        Join Make My Bharat Yatra as our Tourism Manager to become the leader who develops exceptional travel
                        experiences. Managers in tourist operations maintain full responsibility for every aspect of
                        operational activities including itinerary management and client satisfaction in this position.
                        As part of Make My Bharat Yatra, we want you to fulfill client dreams through your
                        organizational skills while focusing on travel excellence and customer satisfaction.
                    </p>
                    <a href="{{ route('careerApply') }}" class="btn btn-primary">Apply Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tourism Executive -->
<div class="container job-section">
    <div class="row align-items-center reverse-mobile">
        <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
            <div class="card job-card bg-dark text-white">
                <div class="card-body">
                    <h3 class="card-title">TOURISM EXECUTIVE</h3>
                    <hr style="color: white;">
                    <p class="card-text">
                        The Make My Bharat Yatra Tourism Executive role allows you to develop extraordinary tours and
                        travels experiences for our customer base. Our energetic workplace welcomes prospective
                        colleagues who want to experience growth and opportunities for making a sustainable impact while
                        embracing the vibrant tourism industry.
                    </p>
                    <a href="{{ route('careerApply') }}" class="btn btn-primary">Apply Now</a>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-6">
            <img src="{{ asset('assets/images/tourism-executive.jpg') }}" class="job-image" alt="Tourism Executive">
        </div>
    </div>
</div>

<!-- Customer Service Associate -->
<div class="container job-section">
    <div class="row align-items-center">
        <div class="col-lg-7 col-md-6 mb-4 mb-md-0">
            <img src="{{ asset('assets/images/Customer-Service-Associate-Jobs.jpg') }}" class="job-image" alt="Customer Service Associate">
        </div>
        <div class="col-lg-5 col-md-6">
            <div class="card job-card bg-dark text-white">
                <div class="card-body">
                    <h3 class="card-title">CUSTOMER SERVICE ASSOCIATE</h3>
                    <hr style="color: white;">
                    <p class="card-text">
                        The travel industry offers a fulfilling career opportunity to Customer Support Associates through Make My
                        Bharat Yatra. Our customer support team delivers outstanding assistance to customers by handling
                        queries and resolving problems to offer them perfect travel experiences. The job offers exciting
                        workplace conditions with developmental prospects together with a meaningful impact on customer
                        travel experiences.
                    </p>
                    <a href="{{ route('careerApply') }}" class="btn btn-primary">Apply Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tour Agent -->
<div class="container job-section">
    <div class="row align-items-center reverse-mobile">
        <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
            <div class="card job-card bg-dark text-white">
                <div class="card-body">
                    <h3 class="card-title">TOUR AGENT</h3>
                    <hr style="color: white;">
                    <p class="card-text">
                        Joining Make My Bharat Yatra as a tour agent opens up enriching prospects in the travel
                        industry. Your team responsibilities at Make My Bharat Yatra include booking management
                        alongside itinerary organization and maintaining travelers exceptional service quality. A career
                        at Make My Bharat Yatra as a tour agent offers you both career growth possibilities and
                        supportive colleagues while providing generous welfare plans.
                    </p>
                    <a href="{{ route('careerApply') }}" class="btn btn-primary">Apply Now</a>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-6">
            <img src="{{ asset('assets/images/tour-agent.jpg') }}" class="job-image" alt="Tour Agent">
        </div>
    </div>
</div>

<!-- Ticket Service Executive -->
<div class="container job-section">
    <div class="row align-items-center">
        <div class="col-lg-7 col-md-6 mb-4 mb-md-0">
            <img src="{{ asset('assets/images/ticket-service-executive.jpg') }}" class="job-image" alt="Ticket Service Executive">
        </div>
        <div class="col-lg-5 col-md-6">
            <div class="card job-card bg-dark text-white">
                <div class="card-body">
                    <h3 class="card-title">TICKET SERVICE EXECUTIVE</h3>
                    <hr style="color: white;">
                    <p class="card-text">
                        Become a Ticket Support Executive at Make My Bharat Yatra and deliver world-class customer
                        service! Help travelers with questions, resolve problems, and make travel a breeze. Join a
                        high-energy team that's passionate about crafting unforgettable experiences while learning
                        valuable skills and experiencing growth. If you love travel and customer care, this is your
                        opportunity to make a difference.
                    </p>
                    <a href="{{ route('careerApply') }}" class="btn btn-primary">Apply Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Passenger Service Associate -->
<div class="container job-section">
    <div class="row align-items-center reverse-mobile">
        <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
            <div class="card job-card bg-dark text-white">
                <div class="card-body">
                    <h3 class="card-title">PASSENGER SERVICE ASSOCIATE</h3>
                    <hr style="color: white;">
                    <p class="card-text">
                        Join as a Passenger Service Associate on Make My Bharat Yatra and start a rewarding career with us
                        in the travel industry! Assist passengers' travel needs, deliver exceptional customer service,
                        and make travel hassle-free. Expect opportunities to grow, a warm and supportive team, and the
                        chance to make memories with travelers. Be part of a dynamic team who strives to make every
                        journey outstanding.
                    </p>
                    <a href="{{ route('careerApply') }}" class="btn btn-primary">Apply Now</a>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-6">
            <img src="{{ asset('assets/images/passenger-service.webp') }}" class="job-image" alt="Passenger Service Associate">
        </div>
    </div>
</div>

<!-- Sales Executive/Manager -->
<div class="container job-section">
    <div class="row align-items-center">
        <div class="col-lg-7 col-md-6 mb-4 mb-md-0">
            <img src="{{ asset('assets/images/sales-executive-manager.jpg') }}" class="job-image" alt="Sales Executive/Manager">
        </div>
        <div class="col-lg-5 col-md-6">
            <div class="card job-card bg-dark text-white">
                <div class="card-body">
                    <h3 class="card-title">SALES EXECUTIVE/MANAGER</h3>
                    <hr style="color: white;">
                    <p class="card-text">
                        Join Make My Bharat Yatra as a Sales Executive/Manager and be a part of a thrilling experience
                        in the travel sector! Your contribution will be instrumental in selling our varied travel
                        products and services, assisting customers in creating memories to last a lifetime. Join a team
                        that is passionate about what they do, learn continuously, and develop your career in a
                        fast-paced environment.
                    </p>
                    <a href="{{ route('careerApply') }}" class="btn btn-primary">Apply Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Relationship Executive/Manager -->
<div class="container job-section">
    <div class="row align-items-center reverse-mobile">
        <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
            <div class="card job-card bg-dark text-white">
                <div class="card-body">
                    <h3 class="card-title">RELATIONSHIP EXECUTIVE/MANAGER</h3>
                    <hr style="color: white;">
                    <p class="card-text">
                        Join Make My Bharat Yatra as a Relationship Executive/Manager! Foster and maintain strong customer
                        relationships, offer personalized support, and deliver satisfaction. In this exciting role,
                        you'll respond to queries, enrich customer experiences, and be an integral part of turning
                        travel fantasies into reality. Join our dedicated team in the travel sector and start a
                        fulfilling career path.
                    </p>
                    <a href="{{ route('careerApply') }}" class="btn btn-primary">Apply Now</a>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-md-6">
            <img src="{{ asset('assets/images/relationship-manager-executive.webp') }}" class="job-image" alt="Relationship Executive/Manager">
        </div>
    </div>
</div>

@endsection