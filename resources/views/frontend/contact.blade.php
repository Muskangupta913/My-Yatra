@extends('frontend.layouts.master')
@section('title', 'Contact Us - Make My Bharat Yatra')
@section('meta_description', '')

@section('styles')
<style>
    small{
    color: red;
    font-weight: bold;
    }
</style>
@endsection
@section('content')

<section class="Contact-section   d-flex align-items-center justify-content-center">
    <h1>Contact Us</h1>
</section>

<!-- comments -->

<section style="background-color: #ebe8e8;">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-4">

                        <div class="card card-body">


                            <div class="icon border-bottom d-flex">
                                <div class="contact-icon col-md-2">
                                    <i class="fa fa-phone" style="color: blue; font-size: 17px;"></i>
                                </div>
                                <div class="contact-desc col-md-10">
                                    <span class="icon-head px-4">Phone Number </span>
                                    <ul style="list-style: none;">
                                        <li><a href="tel:9871980066">+91 9871980066</a></li>
                                        <li><a href="tel:(+91) 1204379908">+91 1204379908</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="icon border-bottom d-flex">
                                <div class="contact-icon col-md-2">
                                    <i class="fa-solid fa-envelope" style="color: blue; font-size: 17px;"></i>
                                </div>
                                <div class="contact-desc col-md-10">
                                    <span class="icon-head px-4">Email </span>
                                    <ul style="list-style: none; padding-left: 0.5rem; margin-right: 0.5rem; width: 90%;">
            <li style="white-space: normal; word-break: break-all; overflow-wrap: anywhere; margin-bottom: 8px;">
                <i class="fa-solid fa-circle-info" style="color: #666; font-size: 14px; margin-right: 5px;"></i>
                <a href="mailto:info@makemybharatyatra.com" style="font-size: 0.9rem;">info@makemybharatyatra.com</a>
            </li>
            <li style="white-space: normal; word-break: break-all; overflow-wrap: anywhere;">
                <i class="fa-solid fa-headset" style="color: #666; font-size: 14px; margin-right: 5px;"></i>
                <a href="mailto:support@makemybharatyatra.com" style="font-size: 0.9rem;">support@makemybharatyatra.com</a>
            </li>
        </ul>
                                </div>
                            </div>


                            <div class="icon d-flex">
                                <div class="contact-icon col-md-2">
                                    <i class="fa-solid fa-location-crosshairs"
                                        style="color: blue; font-size: 17px;"></i>
                                </div>

                                <div class="contact-desc col-md-10">
                                    <span class="icon-head px-4">Location
                                    </span>

                                    <ul style="list-style: none;">
                                        <li></li>D-59, D-Block, Sector 63, Noida, Uttar Pradesh 201301, India
                                        </li>
                                    </ul>
                                </div>

                            </div>

                        </div>
                    </div>


                    <div class="col-md-8 ">
                        <div class="card py-3">
                            <div class="card-body">

                                @if(session('success'))
                                    
                               <div
                                class="alert alert-primary alert-dismissible fade show"
                                role="alert"
                               >
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Close"
                                ></button>
                               
                                <strong>{{session('success')}}</strong> 
                               </div>
                               
                    
                                @endif

                                <h3 class="MS">Send Message</h3>
                                <p class="mb-3">Get in touch via form below and we will reply as soos as we can.</p>

                                <form action="{{ url('/contact-us')}}" method="post">
                                    @csrf
                                    <div class="row">

                                        <div class="mb-3 col-md-6">
                                            <input type="text" class="form-control py-3 rounded-0" name="name" value="{{ old('name')}}" placeholder="Name" required>

                                            @error('name')
                                            <small>{{ $message}}</small>
                                                
                                            @enderror

                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <input type="text" class="form-control py-3 rounded-0" name="phone" value="{{ old('phone')}}" placeholder="Phone" required>
                                            @error('phone')
                                            <small>{{ $message}}</small>
                                                
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <input type="text" class="form-control py-3 rounded-0" name="email" value="{{ old('email')}}" placeholder="Email" required>
                                        @error('email')
                                        <small>{{ $message}}</small>
                                            
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <textarea name="message" class="form-control rounded-0" placeholder="Message" cols="10"
                                            rows="4" id="" value="{{ old('message')}}" required></textarea>
                                            @error('message')
                                            <small>{{ $message}}</small>
                                                
                                            @enderror
                                    </div>

                                    <div class="mb-3">
                                        <button class="btn btn-warning  text-white rounded-0"
                                            style="font-weight: 600;">SEND MESSAGE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


<div class="container mt-5">
    <h4 class="location-head mb-4 mt-5">Find Us On Google Maps</h4>
    <iframe class="location-img"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3502.3728790921355!2d77.3796366113161!3d28.618584575570857!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ceff4f6c9264f%3A0xda17d39d29f4b5ae!2sMake%20My%20Bharat%20Yatra!5e0!3m2!1sen!2sin!4v1725856222865!5m2!1sen!2sin"
        width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>


@endsection