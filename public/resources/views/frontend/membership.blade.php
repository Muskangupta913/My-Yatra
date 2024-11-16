@extends('frontend.layouts.master')
@section('title', "Membership Plans")
@section('meta_description','')
@section('content')
<section class="Membership-section d-flex align-items-center justify-content-center">
    <h1 class="Membership-head">Membership Plans</h1>
    <p class=" py-3 px-5">
        Explore our exclusive membership plans at
        Make My BharatYatra. <br/> Enjoy personalized travel experiences, exceptional
        service, and unique adventures <br/> across India's top destinations.</p>
</section>

<div class="Membership-Buy1 py-5" style="background-color:#eee;">

    <h4 class="text-center">MMBY Membership Benefits</h4>
    

    <div class="container-fluid py-5 px-5">
        
        <div class="flex-row">

            <div class="membership-card text-center">
                <h3 class="title" style="font-weight: 800; font-size: 30px;">Bronze Plan</h3>
                <h5 class=" membership-heading" style="font-weight: 700; font-size: 20px">% 5 Discount</h5>
                <p>Access to exclusive deals and offers
                    Complimentary travel insurance for domestic trips Priority customer support</p>
                <p class="price" style="font-weight: 700; font-size: 17px;"> Annual Fee: ₹2,000</p>
                <button class="But-btn"
                    style="font-weight: 700; font-size: 20px; border-radius: 100px; border: 2px solid black;">BUY
                    NOW</button>
            </div>



            <div class="membership-card  text-center">
                <h3 class="title" style="font-weight: 800; font-size: 30px;">Silver Plan</h3>
                <h5 class=" membership-heading" style="font-weight: 700; font-size: 20px;">% 10 Discount</h5>
                <p>10% discount on all bookings
                    Access to airport lounge services
                    Early access to special promotions
                    Priority customer support</p>
                <p class="price" style="font-weight: 700; font-size: 17px;">Annual Fee: ₹5,000</p>
                <button class="But-btn"
                    style="font-weight: 700; font-size: 20px; border-radius: 100px; border: 2px solid black;">BUY
                    NOW</button>
            </div>


            <div class="membership-card   text-center">
                <h3 class="title" style="font-weight: 800; font-size: 30px;">Gold Plan</h3>
                <h5 class=" membership-heading" style="font-weight: 700; font-size: 20px;">% 15 Discount</h5>
                <p>5% discount on all bookings
                    Complimentary room upgrades
                    Dedicated travel concierge service
                    Priority customer support</p>
                <p class="price" style="font-weight: 700; font-size: 17px;">Annual Fee: ₹10,000</p>
                <button class="But-btn"
                    style="font-weight: 700; font-size: 20px; border-radius: 100px; border: 2px solid black;">BUY
                    NOW</button>
            </div>

            <div class="membership-card  text-center">
                <h3 class="title" style="font-weight: 800; font-size: 30px;">Platinum Plan</h3>
                <h5 class=" membership-heading" style="font-weight: 700; font-size: 20px;">% 20 Discount</h5>
                <p>Dedicated 24/7 travel concierge service
                    Complimentary VIP transfers
                    Complimentary room upgrades
                    10% discount on all bookings</p>
                <p class="price" style="font-weight: 700; font-size: 17px;">Annual Fee: ₹15,000</p>
                <button class="But-btn"
                    style="font-weight: 700; font-size: 20px; border-radius: 100px; border: 2px solid black;">BUY
                    NOW</button>
            </div>




            <div class="membership-card   text-center ">
                <h3 class="title" style="font-weight: 800; font-size: 30px;">Diamond Plan</h3>
                <h5 class="membership-heading " style="font-weight: 700; font-size: 20px;">% 25 Discount</h5>
                <p>Unlimited access to airport lounge services
                    Dedicated 24/7 travel concierge service
                    Private guide Complimentary VIP transfersd tours
                    Private guided tours</p>
                <p class="price" style="font-weight: 700; font-size: 17px;">Annual Fee: ₹20,000</p>
                <button class="But-btn"
                    style="font-weight: 700; font-size: 20px; border-radius: 100px; border: 2px solid black;">BUY
                    NOW</button>
            </div>

        </div>
    </div>

</div>
@endsection