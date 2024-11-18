
 

@extends('frontend.layouts.master') <!-- Assuming there's a main layout -->

@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

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
            <img src="{{ asset('images/travelblog-images.jpg') }}" width="100%" height="100%" alt="">
        </div>
    </div>
</div>
@endsection



<!-- Blog banner end -->







<!-- second container blog start -->

 

<section id="featured-posts" class="featured-posts">
    <div class="container-fluid blog-second">
        <div class="row">
            <div class="col-md-4 post-card">
                <div class="card">
                    <img src="{{ asset('images/blog-s1-img.jpg') }}" class="card-img-top" alt="Taj Mahal">
                    <div class="card-body">
                        <h5 class="card-title">6 Must-Visit Destinations in India</h5>
                        <p class="card-text">
                            Explore India's top ten must-see locations that offer life-changing experiences, 
                            from the magnificent Taj Mahal to the energetic streets of Jaipur.
                        </p>
                        <a href="{{ url('link-to-full-post.html') }}" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 post-card">
                <div class="card">
                    <img src="{{ asset('images/blog-s3-img.jfif') }}" class="card-img-top" alt="Travel Tips">
                    <div class="card-body">
                        <h5 class="card-title">Essential Travel Tips for India</h5>
                        <p class="card-text">
                            Are you making your first trip to India? These crucial pointers, which cover everything from 
                            packing necessities to cultural etiquette, will guarantee a seamless and joyful trip.
                        </p>
                        <a href="{{ url('link-to-full-post.html') }}" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 post-card">
                <div class="card">
                    <img src="{{ asset('images/blog-s4-img.jpg') }}" class="card-img-top" alt="Wildlife Safari">
                    <div class="card-body">
                        <h5 class="card-title">The Best Wildlife Safaris in India</h5>
                        <p class="card-text">
                            Savor the excitement of India's wildlife safaris! Discover the top national parks and reserves 
                            to see amazing creatures in their native environment.
                        </p>
                        <a href="{{ url('link-to-full-post.html') }}" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




  <!-- second container blog end-->
  




<!-- 5 offbeat travel start -->

<section 
  class="relative min-h-[150vh] bg-fixed bg-cover bg-center text-white text-center py-4 px-2 mt-2" 
  style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('images/blog-s1-img.jpg') }}');">
  
  <!-- Overlay to create the filler effect if additional overlay needed -->
  <div class="absolute inset-0 bg-black opacity-50 z-0"></div>
  
  <!-- Content section positioned above the overlay -->
  <div class="relative z-10 p-4">
    <h1 class="text-4xl font-bold">Top 5 Off beat Travel Destinations in India</h1>
    <p class="text-lg">Discover Hidden Gems and Explore India Differently</p>
    <small class="text-gray-300">Published on: {{ $postDate ?? 'September 16, 2024' }} | By: {{ $author ?? 'Make My Bharat Yatra Team' }}</small>
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

<!-- Swiper section start -->
<div class="p-4 mt-5">
  <!-- Swiper Wrapper -->
  <div class="swiper myimagesslider">
    <div class="swiper-wrapper">

      @foreach($vacationSpots as $spot)
        <!-- Card -->
        <div class="swiper-slide flex justify-center">
          <div class="max-w-xs rounded-lg shadow-lg overflow-hidden bg-white">
            <img src="{{ asset('images/' . $spot->image) }}" class="w-full h-56 object-cover" alt="{{ $spot->name }}">
            <div class="p-2">
              <h5 class="text-lg font-semibold">{{ $spot->name }}</h5>
              <p class="text-sm text-gray-600">{{ $spot->description }}</p>
            </div>
          </div>
        </div>
      @endforeach

    </div>

    <!-- Pagination (bullets) placed below the cards -->
    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal w-full mt-4"></div>
  </div>
</div>

<!-- Swiper JS -->
<script>
  const swiper = new Swiper('.myimagesslider', {
    slidesPerView: 3,  // Initially show 3 cards
    spaceBetween: 20,   // Space between cards
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
                        <img src="./images/north-indian-festival-img.jpg" class="card-img-top festival-img" alt="North India Festivals">
                        <div class="card-body">
                            <h5 class="card-title">North India Festivals</h5>
                            <p class="card-text"><strong>Major Festivals:</strong> Diwali, Holi, Lohri</p>
                            <p><strong>Significance:</strong> Celebrate the coming of spring and the victory of light over darkness.</p>
                            <p><strong>Best Places:</strong> Amritsar for Lohri, Mathura for Holi, and Varanasi for Diwali.</p>
                            <a href="north-festivals.html" class="btn btn-primary">Explore North Festivals</a>
                        </div>
                    </div>
                </div>
                <!-- South India Festivals -->
                <div class="col-md-3 mb-4">
                    <div class="card festival-card">
                        <img src="./images/south-india-festivals-img.jfif" class="card-img-top festival-img" alt="South India Festivals">
                        <div class="card-body">
                            <h5 class="card-title">South India Festivals</h5>
                            <p class="card-text"><strong>Major Festivals:</strong> Pongal, Onam, Ugadi</p>
                            <p><strong>Significance:</strong> festivals of harvest that honor the area's agricultural heritage.</p>
                            <p><strong>Best Places:</strong> Karnataka celebrates Ugadi, Kerala celebrates Onam, while Tamil Nadu celebrates Pongal.</p>
                            <a href="south-festivals.html" class="btn btn-primary">Explore South Festivals</a>
                        </div>
                    </div>
                </div>
                <!-- East India Festivals -->
                <div class="col-md-3 mb-4">
                    <div class="card festival-card">
                        <img src="./images/east-india-festivals-img.webp" class="card-img-top festival-img" alt="East India Festivals">
                        <div class="card-body">
                            <h5 class="card-title">East India Festivals</h5>
                            <p class="card-text"><strong>Major Festivals:</strong> Durga Puja, Bihu,rath yatra</p>
                            <p><strong>Significance:</strong> Honoring the harvest season and the triumph of good over evil.</p>
                            <p><strong>Best Places:</strong> Kolkata for Durga Puja, Assam for Bihu, Puri for Rath Yatra.</p>
                            <a href="east-festivals.html" class="btn btn-primary">Explore East Festivals</a>
                        </div>
                    </div>
                </div>
                <!-- West India Festivals -->
                <div class="col-md-3 mb-4">
                    <div class="card festival-card">
                        <img src="./images/west-india-festivals-img.jfif" class="card-img-top festival-img" alt="West India Festivals">
                        <div class="card-body">
                            <h5 class="card-title">West India Festivals</h5>
                            <p class="card-text"><strong>Major Festivals:</strong> Ganesh Chaturthi.</p>
                            <p><strong>Significance:</strong> Honoring deities and celebrating the harvest season.</p>
                            <p><strong>Best Places:</strong> Mumbai for Ganesh Chaturthi, Gujarat for Navratri, Rajasthan for Sankranti.</p>
                            <a href="west-festivals.html" class="btn btn-primary">Explore West Festivals</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
  

    <!-- categories section end-->




  
    <!-- travel tips section start-->
    
    <section class="festivals-section">
    <div class="container-fluid blog-categories text-center">
        <h2 class="mb-5">Explore Festivals by Regions</h2>
        <div class="row">
            @foreach($festivalRegions as $region)
                <!-- Festival Region Card -->
                <div class="col-md-3 mb-4">
                    <div class="card festival-card">
                        <img src="{{ asset('images/' . $region['image']) }}" class="card-img-top festival-img" alt="{{ $region['name'] }} Festivals">
                        <div class="card-body">
                            <h5 class="card-title">{{ $region['name'] }} Festivals</h5>
                            <p class="card-text"><strong>Major Festivals:</strong> {{ implode(', ', $region['festivals']) }}</p>
                            <p><strong>Significance:</strong> {{ $region['significance'] }}</p>
                            <p><strong>Best Places:</strong> {{ implode(', ', $region['best_places']) }}</p>
                            <a href="{{ url('festivals/' . Str::slug($region['name'])) }}" class="btn btn-primary">Explore {{ $region['name'] }} Festivals</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Travel Tips Section -->
<section class="travel-tips-section">
    <div class="container tts">
        <h2 class="text-center mb-5">Essential Tips for Traveling in India</h2>
        <div class="row">
            @foreach($travelTips as $tip)
                <!-- Travel Tip Card -->
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body tts-card bg-light">
                            <div class="icon-box mb-3 text-center">
                                <i class="{{ $tip['icon'] }}"></i>
                            </div>
                            <h5 class="card-title">{{ $tip['title'] }}</h5>
                            <p class="card-text">{{ $tip['description'] }}</p>
                            <ul>
                                @foreach($tip['details'] as $detail)
                                    <li>{{ $detail }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
    
    
 <!-- travel tips section start-->







    
 <!-- food experiences section start-->

 
 <section class="culinary-section">
    <div class="container">
        <h2 class="text-center mb-5">A Culinary Journey Through India</h2>
        <div class="row">
            <!-- North Indian Cuisine -->
            <div class="col-md-6 mb-4">
                <div class="card dish-card">
                    <img src="{{ asset('images/chicken.jpeg') }}" class="card-img-top dish-img" alt="North Indian Cuisine">
                    <div class="card-body">
                        <h5 class="card-title">North Indian Cuisine</h5>
                        <p class="card-text"><strong>Popular Dishes:</strong> Butter Chicken, Rogan Josh, Chole Bhature</p>
                        <p><strong>Recommended Restaurants:</strong> 
                            <ul>
                                <li>Bukhara, New Delhi</li>
                                <li>Karim's, Old Delhi</li>
                                <li>Punjab Grill, Amritsar</li>
                            </ul>
                        </p>
                        <a href="{{ url('/north-indian-cuisine') }}" class="btn btn-primary">Discover More</a>
                    </div>
                </div>
            </div>
            <!-- South Indian Cuisine -->
            <div class="col-md-6 mb-4">
                <div class="card dish-card">
                    <img src="{{ asset('images/south-india-food.jpg') }}" class="card-img-top dish-img" alt="South Indian Cuisine">
                    <div class="card-body">
                        <h5 class="card-title">South Indian Cuisine</h5>
                        <p class="card-text"><strong>Popular Dishes:</strong> Dosa, Sambar, Hyderabadi Biryani</p>
                        <p><strong>Recommended Restaurants:</strong> 
                            <ul>
                                <li>MTR, Bengaluru</li>
                                <li>Saravana Bhavan, Chennai</li>
                                <li>Paradise Biryani, Hyderabad</li>
                            </ul>
                        </p>
                        <a href="{{ url('/south-indian-cuisine') }}" class="btn btn-primary">Discover More</a>
                    </div>
                </div>
            </div>
            <!-- East Indian Cuisine -->
            <div class="col-md-6 mb-4">
                <div class="card dish-card">
                    <img src="{{ asset('images/east.jpeg') }}" class="card-img-top dish-img" alt="East Indian Cuisine">
                    <div class="card-body">
                        <h5 class="card-title">East Indian Cuisine</h5>
                        <p class="card-text"><strong>Popular Dishes:</strong> Momos, Fish Curry, Rasgulla</p>
                        <p><strong>Recommended Restaurants:</strong> 
                            <ul>
                                <li>Oh! Calcutta, Kolkata</li>
                                <li>Kasturi, Kolkata</li>
                                <li>6 Ballygunge Place, Kolkata</li>
                            </ul>
                        </p>
                        <a href="{{ url('/east-indian-cuisine') }}" class="btn btn-primary">Discover More</a>
                    </div>
                </div>
            </div>
            <!-- West Indian Cuisine -->
            <div class="col-md-6 mb-4">
                <div class="card dish-card">
                    <img src="{{ asset('images/west.jpeg') }}" class="card-img-top dish-img" alt="West Indian Cuisine">
                    <div class="card-body">
                        <h5 class="card-title">West Indian Cuisine</h5>
                        <p class="card-text"><strong>Popular Dishes:</strong> Pav Bhaji, Goan Fish Curry, Dhokla</p>
                        <p><strong>Recommended Restaurants:</strong> 
                            <ul>
                                <li>Brittos, Goa</li>
                                <li>Swati Snacks, Mumbai</li>
                                <li>Sukanta, Pune</li>
                            </ul>
                        </p>
                        <a href="{{ url('/west-indian-cuisine') }}" class="btn btn-primary">Discover More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection