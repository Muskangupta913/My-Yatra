@extends('frontend.layouts.master')
@section('content')
<style>

h2, h3 {
    color: #004d40; /* Elegant green shade */
}

.btn-primary {
    background-color: #00796b; 
    border-color: #004d40;
}

.btn-primary:hover {
    background-color: #004d40;
    border-color: #00796b;
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
        <h2 class="display-4 font-weight-bold">Discover the Beauty of Kashmir</h2>
        <p class="text-muted">Experience paradise on earth with breathtaking views, tranquil lakes, and lush valleys.</p>
    </div>
    <div class="row">
        <!-- First Image and Content -->
        <div class="col-md-6 mb-4">
            <img src="{{ asset('assets/images/k1.jpg') }}" class="img-fluid rounded shadow w-100 smaller-img" alt="Kashmir Valley">
        </div>
        <div class="col-md-6 mb-4 d-flex align-items-center">
            <div>
                <h3 class="font-weight-bold">Kashmir Valley</h3>
                <p>
                Known as the "Paradise on Earth," Kashmir Valley offers mesmerizing views of lush green meadows, towering pine forests, and pristine rivers. It's a perfect retreat for those seeking tranquility and natural beauty.
            </p>
            <ul>
                <li>Best Time to Visit: March to October</li>
                <li>Top Activities: Trekking, Nature Walks, Photography</li>
            </ul>
                <!-- <a href="{{ route('kashmir') }}" class="btn btn-primary btn-lg">Explore More</a> -->
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Second Content and Image -->
        <div class="col-md-6 mb-4 order-md-1">
            <img src="{{ asset('assets/images/k2.jpg') }}" class="img-fluid rounded shadow w-100 smaller-img" alt="Dal Lake">
        </div>
        <div class="col-md-6 mb-4 d-flex align-items-center order-md-2">
            <div>
                <h3 class="font-weight-bold">Dal Lake</h3>
                <p>
                Dal Lake, the "Jewel of Kashmir," is famous for its houseboats, vibrant Shikara rides, and floating gardens. As the sun sets, the lake turns into a painter's canvas, radiating hues of orange and pink.
            </p>
            <ul>
                <li>Best Time to Visit: April to November</li>
                <li>Must-Try: Overnight stay in a houseboat</li>
            </ul>
                <!-- <a href="{{ route('kashmir') }}" class="btn btn-primary btn-lg">Learn More</a> -->
            </div>
        </div>
       
    </div>
    <div class="row">
        <!-- Third Image and Content -->
        <div class="col-md-6 mb-4">
            <img src="{{ asset('assets/images/k3.jpg') }}" class="img-fluid rounded shadow w-100 smaller-img" alt="Gulmarg">
        </div>
        <div class="col-md-6 mb-4 d-flex align-items-center">
            <div>
                <h3 class="font-weight-bold">Gulmarg</h3>
                <p>
                Famous for its picturesque meadows and world-class ski resorts, Gulmarg is a paradise for adventure lovers and leisure seekers. The Gulmarg Gondola offers sweeping views of snow-covered peaks.
            </p>
            <ul>
                <li>Best Time to Visit: December to February for skiing</li>
                <li>Popular Activities: Skiing, Gondola Ride, Trekking</li>
            </ul>
                <!-- <a href="{{ route('kashmir') }}" class="btn btn-primary btn-lg">Discover More</a> -->
            </div>
        </div>
    </div>
    <div class="row">
     <!-- fourth Content and Image -->
     <div class="col-md-6 mb-4 order-md-1">
            <img src="{{ asset('assets/images/k4.jpg') }}" class="img-fluid rounded shadow w-100 smaller-img" alt="Dal Lake">
        </div>
     <div class="col-md-6 mb-4 d-flex align-items-center order-md-2">
            <div>
                <h3 class="font-weight-bold">Sonmarg</h3>
                <p>
                Sonmarg, meaning the "Meadow of Gold," is a gateway to the breathtaking glaciers of Ladakh. It offers unparalleled views of the Himalayan peaks and is a haven for trekkers and nature lovers.
            </p>
            <ul>
                <li>Best Time to Visit: May to October</li>
                <li>Highlights: Thajiwas Glacier, White Water Rafting</li>
            </ul>
                <!-- <a href="{{ route('kashmir') }}" class="btn btn-primary btn-lg">Learn More</a> -->
            </div>
        </div>
        
    </div>
</div>





@endsection