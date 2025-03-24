@extends('frontend.layouts.master')

@section('content')
<!-- External Resources -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


<style>
/* Your custom CSS code here */
.myimagesslider {
    width: 100%;
    height: 100%;
}
.img-content {
    text-align: center;
    font-size: 18px;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
}
.img-content img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.myimagesslider{
    width: 100%;
    height: 300px;
    margin: 20px auto;
}
.featured-posts {
    margin: 40px 0;
}
.post-card {
    margin-bottom: 30px;
}
.newsletter {
    background-color: #f8f9fa;
    padding: 30px 0;
    text-align: center;
}
.festivals-section {
    padding: 10px 0;
}
.festival-card {
    transition: transform 0.2s;
    height: 100%; /* Ensure all cards have the same height */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
    border: none; 
    border-radius: 10px; 
}
.festival-card:hover {
    transform: scale(1.05);
}
.festival-img {
    height: 200px;
    object-fit: cover;
    width: 100%; 
    height: 200px; 
    object-fit: cover; 
    border-top-left-radius: 10px; 
    border-top-right-radius: 10px;
}
.travel-tips-section {
    padding: 30px 0;
}
.icon-box i {
    font-size: 60px;
    color: #3c8fe8;
}
.card-body h5 {
    font-size: 1.25rem;
}
.culinary-section {
    padding: 50px 0;
}
.dish-card {
    transition: transform 0.2s;
}
.dish-card:hover {
    transform: scale(1.05);
}
.dish-img {
    object-fit: cover;
}
.adventure-section {
    padding: 50px 0;
}
.activity-card {
    transition: transform 0.2s;
}
.activity-card:hover {
    transform: scale(1.05);
}
.activity-img {
    object-fit: cover;
}
.icon-box {
    font-size: 48px;
    color: #007bff;
}
.adventure-container h2{
    font-size: 30px;
}
.swiper {
    width: 100%;
    height: 100%;
}
.swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
}
.swiper-slide img {
    display: block;
    width: 100%;
    height: 300px !important;
    object-fit: cover;
}
.tip-icon {
    font-size: 40px;
    color: #007bff;
}
.tip-title {
    font-weight: bold;
    color: #007bff;
}
.travelt-icon i {
    font-size: 50px;
    color: red;
}
.myimagesslider p{
    padding: 0px 10px;
}
.cta-section {
    background-color: rgba(89, 89, 252, 0.522);
    padding: 100px 0;
    color: white;
}
.cta-overlay {
    background-color: rgba(0, 0, 0, 0.6);
    padding: 27px;
}
.cta-title {
    font-size: 2.5rem;
    font-weight: bold;
}
.cta-btn {
    background-color: #ff5722;
    color: white;
    font-weight: bold;
    padding: 15px 30px;
    border-radius: 50px;
}
.cta-btn:hover {
    background-color: #e64a19;
    color: #fff;
}
.overlay-text{
    line-height: 40px;
}
.overlay-text h2{
    font-size: 40px;
    font-weight: 700;
}
.overlay-text p{
    font-size: 20px;
}
.call-to-action{
    margin: 40px 0px;
}
.swiper-caption h5{
    font-size: 20px;
    font-weight: 700;
}
.swiper-caption p{
    padding: 0px 30px;
}
.main-top-container h1{
    font-size: 60px;
    font-weight: 800;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 80px;
}
@media only screen and (max-width: 600px) {
    .main-top-container h2{
        font-size: 30px;
    }
    .main-top-container p{
        text-align: center;
        padding: 0px 10px;
    }
    .blog-destination{
        height: 300px;
    }
    .second-container {
        padding: 0px 20px;
    }
    .swi-img{
        width: 100%;
        height: 200px;
    }
    .display-6{
        font-size: 20px;
    }
    .second-container  h3{
        font-size: 20px;
    }
    .second-container  p{
        font-size: 12px;
    }
    .second-container img{
        height: 200px;
    }
    .offbeat-destination{
        height: 200px;
        text-align: center;
        align-items: center;
    }
    .offbeat-destination h1{
        font-size: 25px;
    }
    .offbeat-destination p{
        margin: 30px 0px;
        font-size: 15px;
    }
    .mtext{
        font-size: 15px;
    }
    .bcontent h2{
        font-size: 20px;
    }
    .goap{
        font-size: 14px;
    }
    .cta-section{
        background-image: url('./images/cta-banner.jpeg'); 
        height: 300px !important; 
        background-position: center;
        background-repeat: no-repeat; 
        background-size: cover;  
    }
    .overlay-text{
        line-height: 20px;
    }
    .overlay-text h2{
        font-size: 16px;
    }
    .overlay-text p{
        font-size: 12px;
    }
    .cta-title{
        font-size: 15px;
    }
    .call-p{
        font-size: 10px;
    }
    .cta-btn{
        font-size: 9px;
    }
    .call-to-action {
        margin-bottom: 50px;
    }
    .cta-section {
        padding: 10px 0;
        color: white;
    }
    .overlay-text{
        padding: 60px;
    }
    .swiper-hpc p{
        font-size: 12px;
        padding: 0px 20px;
    }
    .swiper-hpc{
        height: 160px;
    }
    .swiper-slide img {
        display: block;
        width: 100%;
        height: 200px !important;
        object-fit: cover;
    }
    .main-top-container h1{
        margin: 20px;
        font-size: 50px;
    }
    .blog-p-c h5{
        font-size: 13px;
        padding: 0px 10px;
    }
}

.culinary-section .card {
    height: 100%; 
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
    border: none; 
    border-radius: 10px; 
}

.culinary-section .dish-img {
    width: 100%; 
    height: 200px; 
    object-fit: cover; 
    border-top-left-radius: 10px; 
    border-top-right-radius: 10px;
}

.culinary-section .card-body {
    flex-grow: 1; 
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.culinary-section ul {
    padding-left: 20px; 
    margin: 0;
    list-style-type: disc; 
}

.culinary-section .card-text {
    margin-bottom: 10px; 
}
 .dish-card {
        width: 100%;
        max-width: 400px; /* Adjust as needed */
        margin: auto;
    }
    .dish-img {
        height: 250px; /* Fixed height */
        object-fit: cover; /* Ensures images fit properly */
    }

</style>

<!-- Blog banner start -->
<div class="container-fluid main-top-container" style="text-align: center;">
    <div class="row">
        <div class="col-md-5">
            <h1>Travel Blog</h1>
            <h2>Best Places to Visit in India</h2>
            <p>
                These trade-offs, which are (mostly) free of selfie stick attacks and lines long enough 
                to be a flight time during the off-season, are likely to make you fall in love, even though 
                the famous cities of London and Paris never really lose their crowds.
            </p>  
        </div>
        <div class="col-md-7">
            <img src="{{ asset('assets/images/travelblog-images.jpg') }}" width="100%" height="100%" alt="">
        </div>
    </div>
</div>
<!-- Blog banner end -->
<!-- second container blog start -->

<section id="featured-posts" class="featured-posts">
    <div class="container-fluid blog-second">
        <div class="row">
            <div class="col-md-4 post-card mb-4">
                <a href="{{ url('destination') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm hover:shadow-lg transition-shadow duration-300">
                        <img src="{{ asset('assets/images/taj-mahal.jpg') }}" class="card-img-top" alt="Taj Mahal">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title font-weight-bold mb-3">6 Must-Visit Destinations in India</h5>
                            <p class="card-text flex-grow-1 text-muted">
                                Discover the timeless beauty of the Taj Mahal, a UNESCO World Heritage Site and one of the world's most iconic monuments. Built by Mughal Emperor Shah Jahan in memory of his wife Mumtaz Mahal, this breathtaking masterpiece symbolizes love and architectural brilliance.
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-md-4 post-card mb-4">
                <a href="{{ url('travel-tips') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm hover:shadow-lg transition-shadow duration-300">
                          <img src="{{ asset('assets/images/traveltips.png') }}" class="card-img-top" alt="Travel Tips">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title font-weight-bold mb-3">Essential Travel Tips for India</h5>
                            <p class="card-text flex-grow-1 text-muted">
                                Are you making your first trip to India? These crucial pointers, which cover everything from packing necessities to cultural etiquette, will guarantee a seamless and joyful trip.
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-md-4 post-card mb-4">
                <a href="{{ url('wildlife') }}" class="text-decoration-none">
                    <div class="card h-100 shadow-sm hover:shadow-lg transition-shadow duration-300">
                           <img src="{{ asset('assets/images/tiger.png') }}" class="card-img-top" alt="Wildlife Safari">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title font-weight-bold mb-3">The Best Wildlife Safaris in India</h5>
                            <p class="card-text flex-grow-1 text-muted">
                                Savor the excitement of India's wildlife safaris! Discover the top national parks and reserves to see amazing creatures in their native environment.
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

  <!-- second container blog end-->


<!-- 5 offbeat travel start -->

<section 
  class="relative min-h-[150vh] bg-fixed bg-cover bg-center text-white text-center py-4 px-2 mt-2" 
 style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('/assets/images/background.jpeg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
  
  <!-- Overlay to create the filler effect if additional overlay needed -->
  <div class="absolute inset-0 bg-black opacity-50 z-0"></div>
  
  <!-- Content section positioned above the overlay -->
  <div class="relative z-10 p-4">
      <!--<img src="{{ asset('assets/images/background.jpeg') }}" >-->
    <h1 class="text-4xl font-bold">Top 5 Off beat Travel Destinations in India</h1>
    <p class="text-lg">Discover Hidden Gems and Explore India Differently</p>
    <small class="text-gray-300"> By: {{ $author ?? 'Make My Bharat Yatra Team' }}</small>
  </div>
  
  <!-- Scrolling content that moves with the page -->
  <div class="relative z-10 pt-10">
    <p class="text-lg">
      To learn more about the unusual places to visit and where to go next for an unforgettable journey, scroll down.
    </p>
    <p class="text-lg mt-5">
      There are several lesser-known gems in India that provide distinctive experiences away from the crowds. There is a lot to explore, from the serene Northeastern hills to Gujarat's uncharted beaches. You will fall in love with India's lesser-known beauty after reading this list of the top 5 hidden jewels in the country.
    </p>
  </div>
</section>


<!-- 5 offbeat travel end -->
<!------blog-section-content start -------->

<section class="container bcontent my-4 text-center">
  <div class="row">
    <div class="col-md-12 mx-auto">

      <h2 class="mb-3 mt-3">India's Unusual Vacation Spots You Should Visit</h2>
      <p class="goap">India has more to offer than just the well-known travel destinations like Goa, Kerala, and Jaipur. Off-the-beaten-path locations are where the real magic happens for tourists looking for adventure, seclusion, and one-of-a-kind encounters.</p>
      <p>You can enjoy pristine scenery, cultural diversity, and an opportunity to get away from the masses at these undiscovered treasures. These are the top 5 unusual places to visit in India that you should definitely consider.</p>
    </div>
  </div>
</section>


    </div>

    <!-- Pagination (bullets) placed below the cards -->
    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal w-full mt-4"></div>
  </div>
</div>

<!-- Swiper JS -->
<script>
  const swiper = new Swiper('.myimagesslider', {
    slidesPerView: 3,  
    spaceBetween: 20,  
    breakpoints: {
      640: {
        slidesPerView: 1,
        spaceBetween: 10,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 20,
      }
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    }
  });
</script>
   <!------ swiper section end-------->
 
    <!-- categories section start-->     
    <section class="festivals-section">
        <div class="container-fluid blog-categories text-center">
            <h2 class="mb-5">Explore Festivals by Regions</h2>
            <div class="row">
                <!-- North India Festivals -->
                <div class="col-md-3 mb-4">
                    <div class="card festival-card">
                        <img src="{{ asset('assets/images/north east.png') }}" class="card-img-top festival-img" alt="North India Festivals">
                        <div class="card-body">
                            <h5 class="card-title">North India Festivals</h5>
                            <p class="card-text"><strong>Major Festivals:</strong> Diwali, Holi, Lohri</p>
                            <p><strong>Significance:</strong> Celebrate the coming of spring and the victory of light over darkness.</p>
                            <p><strong>Best Places:</strong> Amritsar for Lohri, Mathura for Holi, and Varanasi for Diwali.</p>
                       
                        </div>
                    </div>
                </div>
                <!-- South India Festivals -->
                <div class="col-md-3 mb-4">
                    <div class="card festival-card">
                        <img src="{{ asset('assets/images/South_east.png') }}" class="card-img-top festival-img" alt="South India Festivals">
                        <div class="card-body">
                            <h5 class="card-title">South India Festivals</h5>
                            <p class="card-text"><strong>Major Festivals:</strong> Pongal, Onam, Ugadi</p>
                            <p><strong>Significance:</strong> festivals of harvest that honor the area's agricultural heritage.</p>
                            <p><strong>Best Places:</strong> Karnataka celebrates Ugadi, Kerala celebrates Onam, while Tamil Nadu celebrates Pongal.</p>
                         
                        </div>
                    </div>
                </div>
                <!-- East India Festivals -->
                <div class="col-md-3 mb-4">
                    <div class="card festival-card">
                        <img src="{{ asset('assets/images/durga.jpg') }}" class="card-img-top festival-img" alt="East India Festivals">
                        <div class="card-body">
                            <h5 class="card-title">East India Festivals</h5>
                            <p class="card-text"><strong>Major Festivals:</strong> Durga Puja, Bihu, rath yatra</p>
                            <p><strong>Significance:</strong> Honoring the harvest season and the triumph of good over evil.</p>
                            <p><strong>Best Places:</strong> Kolkata for Durga Puja, Assam for Bihu, Puri for Rath Yatra.</p>
                        </div>
                    </div>
                </div>
                <!-- West India Festivals -->
                <div class="col-md-3 mb-4">
                    <div class="card festival-card">
                        <img src="{{ asset('assets/images/ganesh.png') }}" class="card-img-top festival-img" alt="West India Festivals">
                        <div class="card-body">
                            <h5 class="card-title">West India Festivals</h5>
                            <p class="card-text"><strong>Major Festivals:</strong> Ganesh Chaturthi.</p>
                            <p><strong>Significance:</strong> Honoring deities and celebrating the harvest season.</p>
                            <p><strong>Best Places:</strong> Mumbai for Ganesh Chaturthi, Gujarat for Navratri, Rajasthan for Sankranti.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</section>
    

 <!-- food experiences section start-->

 <section class="culinary-section">
    <div class="container">
        <h2 class="text-center mb-5">A Culinary Journey Through India</h2>
        <div class="row">
            <!-- North Indian Cuisine -->
            <div class="col-md-6 mb-4">
                <div class="card dish-card">
                    <!-- Bootstrap Carousel -->
                    <div id="northDishCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('assets/images/butter chicken.webp') }}" class="d-block w-100 dish-img" alt="Butter Chicken">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/images/Dal Makhani.webp') }}" class="d-block w-100 dish-img" alt="Dal Makhani">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/images/Chole Bhature.webp') }}" class="d-block w-100 dish-img" alt="Chole Bhature">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">North Indian Cuisine</h5>
                        <p class="card-text"><strong>Popular Dishes:</strong> Butter Chicken, Dal Makhani, Chole Bhature</p>
                        <p><strong>Recommended Restaurants:</strong></p>
                        <ul>
                            <li>Bukhara, New Delhi</li>
                            <li>Karim's, Old Delhi</li>
                            <li>Punjab Grill, Amritsar</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- South Indian Cuisine -->
            <div class="col-md-6 mb-4">
                <div class="card dish-card">
                    <!-- Bootstrap Carousel -->
                    <div id="dishCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('assets/images/dosa.webp') }}" class="d-block w-100 dish-img" alt="Dosa">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/images/dosa.webp') }}" class="d-block w-100 dish-img" alt="Dosa">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/images/Hyderabadi Biryani.webp') }}" class="d-block w-100 dish-img" alt="Hyderabadi Biryani">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">South Indian Cuisine</h5>
                        <p class="card-text"><strong>Popular Dishes:</strong> Dosa, Sambar, Hyderabadi Biryani</p>
                        <p><strong>Recommended Restaurants:</strong></p>
                        <ul>
                            <li>MTR, Bengaluru</li>
                            <li>Saravana Bhavan, Chennai</li>
                            <li>Paradise Biryani, Hyderabad</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- East Indian Cuisine -->
            <div class="col-md-6 mb-4">
                <div class="card dish-card">
                    <!-- Bootstrap Carousel -->
                    <div id="eastDishCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('assets/images/Momos.webp') }}" class="d-block w-100 dish-img" alt="Momos">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/images/Fish Curry.webp') }}" class="d-block w-100 dish-img" alt="Fish Curry">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/images/Rasgulla.webp') }}" class="d-block w-100 dish-img" alt="Rasgulla">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">East Indian Cuisine</h5>
                        <p class="card-text"><strong>Popular Dishes:</strong> Momos, Fish Curry, Rasgulla</p>
                        <p><strong>Recommended Restaurants:</strong></p>
                        <ul>
                            <li>Oh! Calcutta, Kolkata</li>
                            <li>Kasturi, Kolkata</li>
                            <li>6 Ballygunge Place, Kolkata</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- West Indian Cuisine -->
            <div class="col-md-6 mb-4">
                <div class="card dish-card">
                    <!-- Bootstrap Carousel -->
                    <div id="westDishCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('assets/images/Pav Bhaji.webp') }}" class="d-block w-100 dish-img" alt="Pav Bhaji">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/images/Goan Fish Curry.webp') }}" class="d-block w-100 dish-img" alt="Goan Fish Curry">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('assets/images/Dhokla.webp') }}" class="d-block w-100 dish-img" alt="Dhokla">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">West Indian Cuisine</h5>
                        <p class="card-text"><strong>Popular Dishes:</strong> Pav Bhaji, Goan Fish Curry, Dhokla</p>
                        <p><strong>Recommended Restaurants:</strong></p>
                        <ul>
                            <li>Brittos, Goa</li>
                            <li>Swati Snacks, Mumbai</li>
                            <li>Sukanta, Pune</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection