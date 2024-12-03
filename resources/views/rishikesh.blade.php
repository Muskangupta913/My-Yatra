@extends('frontend.layouts.master')
@section('content')

<style>
h2, h3 {
    color: #004d40; /* Elegant green shade */
}

.btn-primary {
    background-color: #6a1b9a; 
    border-color: #4a148c;
}

.btn-primary:hover {
    background-color: #4a148c;
    border-color: #6a1b9a;
}

.text-muted {
    font-size: 1.1rem;
    line-height: 1.6;
}

.img-fluid {
    transition: transform 0.3s ease-in-out;
}

.img-fluid:hover {
    transform: scale(1.05);
}

.smaller-img {
    max-height: 200px; /* Limits the height to 200px */
    object-fit: cover; /* Ensures the image scales properly */
}
</style>

<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="display-4 font-weight-bold">Explore the Serenity of Rishikesh</h2>
        <p class="text-muted">Rishikesh, the "Yoga Capital of the World," offers a unique blend of spirituality, adventure, and natural beauty.</p>
    </div>
    <div class="row">
        <!-- First Image and Content -->
        <div class="col-md-6 mb-4">
            <img src="{{ asset('assets/images/r1.jpg') }}" class="img-fluid rounded shadow w-100 smaller-img" alt="Ganga Aarti">
        </div>
        <div class="col-md-6 mb-4 d-flex align-items-center">
            <div>
                <h3 class="font-weight-bold">Ganga Aarti</h3>
                <p>
                Experience the divine Ganga Aarti at the Triveni Ghat. The mesmerizing rituals, chants, and floating diyas create an atmosphere of spiritual bliss.
            </p>
            <ul>
                <li>Best Time to Visit: February to May, September to November</li>
                <li>Highlights: Evening Aarti, Riverside Meditation</li>
            </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Second Content and Image -->
        <div class="col-md-6 mb-4 order-md-1">
            <img src="{{ asset('assets/images/r2.jpg') }}" class="img-fluid rounded shadow w-100 smaller-img" alt="Lakshman Jhula">
        </div>
        <div class="col-md-6 mb-4 d-flex align-items-center order-md-2">
            <div>
                <h3 class="font-weight-bold">Lakshman Jhula</h3>
                <p>
                A historic suspension bridge over the Ganges, Lakshman Jhula is a key landmark in Rishikesh, offering breathtaking views of the river and surrounding hills.
            </p>
            <ul>
                <li>Best Time to Visit: All Year Round</li>
                <li>Activities: Photography, Exploring Local Markets</li>
            </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Third Image and Content -->
        <div class="col-md-6 mb-4">
            <img src="{{ asset('assets/images/r3.jpg') }}" class="img-fluid rounded shadow w-100 smaller-img" alt="River Rafting">
        </div>
        <div class="col-md-6 mb-4 d-flex align-items-center">
            <div>
                <h3 class="font-weight-bold">River Rafting</h3>
                <p>
                Rishikesh is famous for its thrilling white-water rafting on the Ganges. It's an adventure enthusiast's paradise with rapids ranging from easy to challenging.
            </p>
            <ul>
                <li>Best Time to Visit: March to June, September to November</li>
                <li>Popular Activities: River Rafting, Kayaking</li>
            </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Fourth Content and Image -->
        <div class="col-md-6 mb-4 order-md-1">
            <img src="{{ asset('assets/images/r4.jpg') }}" class="img-fluid rounded shadow w-100 smaller-img" alt="Yoga Retreat">
        </div>
        <div class="col-md-6 mb-4 d-flex align-items-center order-md-2">
            <div>
                <h3 class="font-weight-bold">Yoga Retreats</h3>
                <p>
                Immerse yourself in the tranquility of yoga retreats in Rishikesh. Renowned worldwide, these retreats offer a perfect blend of asanas, meditation, and holistic healing.
            </p>
            <ul>
                <li>Best Time to Visit: October to April</li>
                <li>Highlights: Meditation Camps, International Yoga Festival</li>
            </ul>
            </div>
        </div>
    </div>
</div>

@endsection