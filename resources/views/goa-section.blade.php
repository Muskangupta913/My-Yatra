@extends('frontend.layouts.master')
@section('content')
<style>
 /* General Styles */
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
}

.container-fluid, .container {
    margin-top: 20px;
}

h1, h2, h3, h4, h5 {
    margin-bottom: 15px;
}

.card {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}

.card:hover {
    transform: scale(1.05);
}

.go-content {
    padding: 10px;
    margin: 15px 0;
}

/* Goa Banner Section */
.goa-banner {
    background-image: linear-gradient(rgba(0, 0, 0, 0.533), rgba(0, 0, 0, 0.511)), url('{{ asset("assets/images/goa-about-img.jpg") }}');
    background-size: cover;
    background-position: center;
    height: 500px;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.goa-banner h1 {
    font-size: 3rem;
    font-weight: 700;
}

.goa-banner p {
    font-size: 1.5rem;
    font-weight: 500;
    margin-top: 20px;
}

/* About Section */
.ads img {
    width: 50%;
    height: auto;
}

/* Top Attractions Section */
.Goa-destinations img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.goa-content {
    padding: 10px;
    margin-top: 10px;
}

/* Responsive Map Embed */
.map-container {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    height: 0;
    overflow: hidden;
    max-width: 100%;
    background: #f9f9f9;
    margin-top: 20px;
}

.map-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

/* Flex Layout for Price, Duration, and Button */
.card-body .d-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.tour-details p {
    margin: 5px 0;
}

.tour-details {
    flex: 1;
}

.card-body a {
    margin-left: 20px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .Goa-destinations img {
        height: 200px;
    }

    .goa-banner {
        height: 300px;
    }

    .goa-banner h1 {
        font-size: 2rem;
    }

    .goa-banner p {
        font-size: 1.2rem;
    }
}

@media (max-width: 576px) {
    .goa-banner h1 {
        font-size: 1.5rem;
    }

    .goa-banner p {
        font-size: 1rem;
    }

    .Goa-destinations img {
        height: 150px;
    }

    .form-control,
    .btn {
        font-size: 0.9rem;
    }

    .travel-information-container ul {
        padding: 0;
    }

    .travel-info-list {
        padding: 0;
        font-size: 0.9rem;
    }
}

</style>

<!-- goa  banner Section -->
<section class="goa-banner-section">
    <div class="container-fluid goa-banner d-flex justify-content-center">
        <div class="banner-content">
        <h1>Explore the Beauty of Goa</h1>
        <p>Discover the beaches, culture, and vibrant life of Goa.</p>
        </div>

    </div>
</section>




<!-- goa  About Section -->

<section id="about-box">
    <div class="container-fluid ads mt-4 g-5 text-center">
        <div class="row">

            <div class="col-md-6">
                <h2>About Goa</h2>
                <p class="ads-p-c mt-3 b-5">
                Goa is India’s premier beach destination, known for its golden sands,  and rich cultural heritage. From lively beaches like Baga and Calangute to the peaceful shores of Palolem, Goa offers something for every traveler.
    Adventure seekers can enjoy water sports like parasailing and scuba diving, while history buffs can explore centuries-old churches, forts, and the unique blend of Indian and Portuguese influences.
   Famous for its seafood and vibrant festivals, Goa promises an unforgettable experience, whether you’re looking to relax or party under the stars.
                </p>
                <img src="{{ asset('assets/images/goa-banner-img.jpg') }}" data-aos="flip-left"
                    width="400px" alt>
            </div>

           
            <div class="col-md-6"> 
                <div class="map-container"> 
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d984956.6952529158!2d73.34716334663365!3d15.350084463361895!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bbfba106336b741%3A0xeaf887ff62f34092!2sGoa!5e0!3m2!1sen!2sin!4v1732606006417!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                </div>
            </div>

        </div>
    </div>
</section>            
<!-- Top Attractions Section -->
<section id="attractions-goa" data-aos="fade-up">

  <div class="container-fluid  Goa-destinations mt-5 py-4 px-4 text-center">
        <h2>Top Attractions in Goa</h2>
        <div class="row">

            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/goa-attraction1-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="goa-content border">
                <h3>Villa Calangute</h3>
                <p>Located just a short walk from the famous Calangute Beach, this villa combines modern amenities with Goan charm,  and personalized service. Enjoy the best of Goa’s vibrant nightlife, and dining, all while relaxing in your private haven.Elegant interiors amenities and private gardens.
                  .</p>
            </div>
            </div>

          
          

          <div class="col-md-3 mb-3 mt-2">
            <img src="{{ asset('assets/images/goa-attraction2-img.jpg') }}" data-aos="fade-up"
                width="100%" height="250px" alt="">
                <div class="goa-content border">
            <h3>Baga Beach</h3>
            <p>Baga Beach is renowned for its vibrant nightlife, and lively beach shacks. A favorite for partygoers and adventure enthusiasts, making it one of the most happening spots in Goa. Water Sports parasailing, and windsurfing.   Baga Beach is perfect for those seeking fun, and entertainment in Goa.
              .</p>
        </div>
        </div>


        <div class="col-md-3 mb-3 mt-2">
          <img src="{{ asset('assets/images/goa-attraction3-img.jfif') }}" data-aos="fade-up"
              width="100%" height="250px" alt="">
              <div class="goa-content border">
          <h3>Basilica of Bom Jesus</h3>
          <p>The Basilica of Bom Jesus, located in Old Goa, is a 16th-century church that houses the sacred remains of St. Francis Xavier. Known for its stunning  architecture and religious significance, it is one of Goa’s most important historical landmarks and a must-visit for heritage lovers.
            .</p>
      </div>
      </div>


      <div class="col-md-3 mb-3 mt-2">
        <img src="{{ asset('assets/images/goa-attraction4-img.jpg') }}" data-aos="fade-up"
            width="100%" height="250px" alt="">
            <div class="goa-content border">
        <h3>Dudhsagar Waterfalls</h3>
        <p>Dudhsagar Waterfalls is one of India’s tallest and most breathtaking waterfalls, located on the Goa-Karnataka border. Cascading from a height of over 300 meters, especially during the monsoon, and is a popular spot for trekking and nature lovers.
       A thrilling ride through the jungle to reach the falls.  .</p>
    </div>
    </div>



    <div class="col-md-3 mb-3 mt-2">
      <img src="{{ asset('assets/images/goa-attraction5-img.avif') }}" data-aos="fade-up"
          width="100%" height="250px" alt="">
          <div class="goa-content border">
      <h3>Fort Aguada</h3>
      <p>Built in the 17th century by the Portuguese, Fort Aguada overlooks the Arabian Sea and offers panoramic views. Known for its historical significance. it is one of Goa’s best-preserved forts and a must-visit for history buffs and photography enthusiasts.
        Strategic Importance: Protected Goa from invaders.
      </p>
  </div>
  </div>


  <div class="col-md-3 mb-3 mt-2">
    <img src="{{ asset('assets/images/goa-attraction6-img.jpg') }}" data-aos="fade-up"
        width="100%" height="250px" alt="">
        <div class="goa-content border">
    <h3>Anujuna Flea Market</h3>
    <p>The Anjuna Flea Market, held every Wednesday, is a vibrant hub for shopping and cultural experience. Offering a wide array of handicrafts, clothing, jewelry, and souvenirs, it showcases Goa’s eclectic spirit and attracts visitors looking for unique finds and local flavors.</p>
</div>
</div>



<div class="col-md-3 mb-3 mt-2">
  <img src="{{ asset('assets/images/goa-attraction7-img.jpg') }}" data-aos="fade-up"
      width="100%" height="250px" alt="">
      <div class="goa-content border">
  <h3>Chapora Fort</h3>
  <p>Chapora Fort, famously featured in Bollywood films, offers breathtaking views of the coastline and surrounding landscape. Built in the 17th century, it stands as a testament to Goa’s rich history and is a popular spot for sunset photography and exploration.Historic Significance by the Portuguese in 1617.
  </p>
</div>
</div>


<div class="col-md-3 mb-3 mt-2">
  <img src="{{ asset('assets/images/goa-attraction8-img.jfif') }}" data-aos="fade-up"
      width="100%" height="250px" alt="">
      <div class="goa-content border">
  <h3>Palolem Beach</h3>
  <p>Palolem Beach is known for its tranquil beauty. Ideal for relaxation and swimming, this palm-fringed beach offers a laid-back atmosphere, making it a perfect retreat for families and couples seeking a peaceful getaway. Palolem offers a blend of natural beauty and making it one of Goa's most popular beaches.
  </p>
</div>
</div>



<div class="col-md-3 mb-3 mt-2">
  <img src="{{ asset('assets/images/goa-attraction9-img.jpg') }}" data-aos="fade-up"
      width="100%" height="250px" alt="">
      <div class="goa-content border">
  <h3>Se Cathedral</h3>
  <p>Se Cathedral,  is renowned for its stunning Portuguese-Manueline architecture and historical significance. it features impressive interiors and houses the famous Golden Bell, making it a must-visit for history and architecture enthusiast.
  Home to the "Golden Bell," the largest church bell in Goa.

  </p>
</div>
</div>



<div class="col-md-3 mb-3 mt-2">
  <img src="{{ asset('assets/images/goa-attraction10-img.jfif') }}" data-aos="fade-up"
      width="100%" height="250px" alt="">
      <div class="goa-content border">
  <h3>Goa Carnival</h3>
  <p>The Goa Carnival is a vibrant annual festival celebrated in February, featuring lively parades, music, dance, and street performances. Known for its joyous spirit, the carnival showcases Goa’s rich cultural heritage and is a highlight for locals and tourists alike, marking the beginning of the Lent season.
  </p>
</div>
</div>


<div class="col-md-3 mb-3 mt-2">
  <img src="{{ asset('assets/images/goa-attraction11-img.webp') }}" data-aos="fade-up"
      width="100%" height="250px" alt="">
      <div class="goa-content border">
  <h3>Anjuna Beach</h3>
  <p>
    Anjuna Beach is one of Goa's most popular and vibrant beaches, known for its stunning natural beauty, and rich hippie culture. It is famous for:
 Stretching over golden sands and palm trees with the Arabian Sea in the backdrop.  Anjuna Beach is a must-visit for travelers seeking a mix of adventure, relaxation, and Goan culture.  </p>
</div>
</div>


<div class="col-md-3 mb-3 mt-2">
  <img src="{{ asset('assets/images/goa-attraction12-img.jpg') }}" data-aos="fade-up"
      width="100%" height="250px" alt="">
      <div class="goa-content border">
  <h3>Divar Island </h3>
  <p>
   Divar Island is a serene and picturesque island located in the Mandovi River, Goa, offering a peaceful escape from the bustling beaches.
  divar island Lush greenery, and scenic river views.Historic Charm Known for its centuries-old churches and heritage sites, including the famous Our Lady of Compassion Church.</P>
 </div>
  </div>
        </div>
      </div>
    </section>

<!-- Travel Information Section -->
<section id="travel-info text-center shadow" data-aos="zoom-in">
  <div class="container travel-information-container  bg-warning text-center py-4">
      <h2 class="TIH py-3">Travel Information</h2>
      <ul class="travel-info-list list-unstyled  px-2"
          style="line-height: 22px; ">
          <li><strong>Best Time to Visit:</strong>  November to February.</li>
          <br>

          <li><strong>How to Get Around:</strong> Delhi Metro, cabs, buses,
              and auto-rickshaws make it easy to navigate the city.</li>
              <br>
          <li><strong>Nearby Airport:</strong> The nearest airport is Goa International Airport (Dabolim Airport), located approximately 28 km from the popular beaches.</li>
      </ul>
  </div>
</section>
<!-- Goa tour packages Section -->

<div class="container my-5">
    <h1 class="text-center mb-5">Goa Tour Packages</h1>
    <div class="row g-4">
      
     <!-- Tour Package 1 -->
<div class="col-md-6 col-lg-4">
  <div class="card h-100">
    <img src="{{ asset('assets/images/adventure.jpeg') }}" class="card-img-top" alt="Goa Adventure Tour">
    <div class="card-body">
      <h5 class="card-title">Goa Adventure Tour Package</h5>
      <p class="card-text">Indulge in thrilling water sports like parasailing, scuba diving, and more while exploring Goa's pristine beaches.</p>
      <div class="d-flex justify-content-between align-items-center">
      <div class="tour-details">
      <p><strong>Duration:</strong> 5 Days / 4 Nights</p>
      <p><strong>Price:</strong> ₹12,999 per person</p>
    </div>
      <a href="#" class="btn btn-primary">Add to cart</a>
    </div>
    </div>
  </div>
</div>
      
     <!-- Tour Package 2 -->
<div class="col-md-6 col-lg-4">
  <div class="card h-100">
    <img src="{{ asset('assets/images/goa-beach.jpg') }}" class="card-img-top" alt="Goa Beach Tour">
    <div class="card-body">
      <h5 class="card-title">Goa Beach Tour Package</h5>
      <p class="card-text">Relax on the beautiful beaches there, visit the historic forts, and enjoy the vibrant nightlife in this 4-day get away.</p>
      <div class="d-flex justify-content-between align-items-center">
      <div class="tour-details">
      <p><strong>Duration:</strong> 4 Days / 3 Nights</p>
      <p><strong>Price:</strong> ₹10,499 per person</p>
    </div>
      <a href="#" class="btn btn-primary">Add to cart</a>
    </div>
    </div>
  </div>
</div>
      
     <!-- Tour Package 3 -->
<div class="col-md-6 col-lg-4">
  <div class="card h-100">
    <img src="{{ asset('assets/images/goa.jpeg') }}" class="card-img-top" alt="Goa Heritage and Culture Tour">
    <div class="card-body">
      <h5 class="card-title">Goa Heritage and Culture Tour Package</h5>
      <p class="card-text">Discover Goa's rich colonial history, visit ancient churches, spice plantations, and enjoy local Goan cuisine.</p>
      <div class="d-flex justify-content-between align-items-center">
        <div class="tour-details">
          <p><strong>Duration:</strong> 3 Days / 2 Nights</p>
          <p><strong>Price:</strong> ₹8,499 per person</p>
        </div>
        <a href="#" class="btn btn-primary">Add to cart</a>
      </div>
    </div>
  </div>
    </div>
</div>
    </div>
@endsection