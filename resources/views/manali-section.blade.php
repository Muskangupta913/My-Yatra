@extends('frontend.layouts.master')
@section('content')
<style>
    
 /* manalitour-destination-section-start */

  .manali-banner {
    background-image: linear-gradient(rgba(0, 0, 0, 0.466), rgba(0, 0, 0, 0.444)), url('{{ asset("assets/images/manali-banner.jpg") }}'); 
    background-size: cover;
    background-position: center;
    height: 450px;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
  }
 
  .package-card img {
    height: 200px;
    object-fit: cover;
  }

  .Manali-destinations h3{
    margin: 10px 0px;
    font-size: 22px;
  }

  .Manali-destinations p{
  padding: 0px 10px;
  }

  .manali-banner h1{
   font-weight: 700;
   font-size: 3rem;
  }
  
  .manali-banner p{
    font-weight: 500;
    padding: 0px 20px;
    margin-top: 20px;
    font-size: 1.5rem;
  }

  

  
  @media only screen and (max-width: 600px) {

    .manali-banner {
        background-image: linear-gradient(rgba(0, 0, 0, 0.466), rgba(0, 0, 0, 0.444)), url('../images/goa-banner-img.jpg'); 
        background-size: cover;
        background-position: center;
        height: 300px;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
      }

     

      .Manali-destinations img{
        height: 200px;
      }

       .manali-banner h1{
        font-size: 2rem;
        padding: 0px 10px;
       }

       .manali-container img{
      height: 100%;
      width: 100%;
       }

       .manali-banner p{
        font-weight: 500;
        margin-top: 1.2rem;
      }    
  }
  
 /* manalitour-destination-section-end */

</style>

 <!-- manali-banner- Section  start-->

 <section class="manali-banner  d-flex align-items-center justify-content-center">
    <div class="text-center">
      <h1>Explore the Beauty of Manali</h1>
      <p class="lead">Join us on an unforgettable journey to the heart of the Himalayas</p>
    </div>
</section>

   <!-- manali-banner- Section  end-->

 
    

  <!-- About Manali Section -->

<section id="about-box">
    <div class="container-fluid ads mt-5 g-5 text-center">
        <div class="row">

            <div class="col-md-6">
                <h2>About Manali</h2>
                <p class="ads-p-c mt-3 b-5">Manali, a popular hill station nestled in the mountains of Himachal Pradesh, offers stunning views, adventure activities, and a serene environment. It’s the perfect destination for nature lovers and adventure enthusiasts alike.</p>
       
                <img src='{{ asset("assets/images/manali-view-img3.cms") }}' data-aos="flip-left"
                    width="400px" alt="">
            </div>

           
            <div class="col-md-6">
                <iframe class="map"
                     src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26997.532023013307!2d77.1871198!3d32.23947205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39048708163fd03f%3A0x8129a80ebe5076cd!2sManali%2C%20Himachal%20Pradesh!5e0!3m2!1sen!2sin!4v1728046122934!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"> width="600" height="450"
                    width="600" height="450" style="border:0;" allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

        </div>
    </div>







  <!-- Top Attractions Section  start-->
<section id="attractions " data-aos="fade-up">

  <div class="container-fluid Manali-destinations mt-5 py-4 px-4 text-center">
        <h2>Top Attractions in Manali</h2>
        <div class="row">

            <div class="col-md-3 mb-3  mt-2">
                <img src='{{ asset("assets/images/manali-attraction1-img.webp") }}'data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="manali-content border">
                <h3>Hadimba Temple</h3>
                <p>Located just a short walk from the famous Calangute Beach, Villa Calangute offers a private, luxurious escape in Goa. Perfect for families or groups, this villa combines modern amenities with Goan charm, featuring spacious rooms, a private pool, lush gardens, and personalized service. Enjoy the best of Goa’s vibrant nightlife, shopping, and dining, all while relaxing in your private haven.
                  .</p>
            </div>
            </div>


            <div class="col-md-3 mb-3 mt-2">
              <img src='{{ asset("assets/images/manali-attraction2-img.webp") }}' data-aos="fade-up"
                  width="100%" height="250px" alt="">
                  <div class="manali-content border">
              <h3> Solang Valley</h3>
              <p>Located just a short walk from the famous Calangute Beach, Villa Calangute offers a private, luxurious escape in Goa. Perfect for families or groups, this villa combines modern amenities with Goan charm, featuring spacious rooms, a private pool, lush gardens, and personalized service. Enjoy the best of Goa’s vibrant nightlife, shopping, and dining, all while relaxing in your private haven.
                .</p>
          </div>
          </div>


          <div class="col-md-3 mb-3 mt-2">
            <img src='{{ asset("assets/images/manali-attraction3-img.webp") }}' data-aos="fade-up"
                width="100%" height="250px" alt="">
                <div class="manali-content border">
            <h3>Temple of Manu</h3>
            <p>Located just a short walk from the famous Calangute Beach, Villa Calangute offers a private, luxurious escape in Goa. Perfect for families or groups, this villa combines modern amenities with Goan charm, featuring spacious rooms, a private pool, lush gardens, and personalized service. Enjoy the best of Goa’s vibrant nightlife, shopping, and dining, all while relaxing in your private haven.
              .</p>
        </div>
        </div>



        <div class="col-md-3 mb-3 mt-2">
          <img src='{{ asset("assets/images/manali-attraction4-img.webp") }}' data-aos="fade-up"
              width="100%" height="250px" alt="">
              <div class="manali-content border">
          <h3>Manali Gompa</h3>
          <p>Located just a short walk from the famous Calangute Beach, Villa Calangute offers a private, luxurious escape in Goa. Perfect for families or groups, this villa combines modern amenities with Goan charm, featuring spacious rooms, a private pool, lush gardens, and personalized service. Enjoy the best of Goa’s vibrant nightlife, shopping, and dining, all while relaxing in your private haven.
            .</p>
      </div>
      </div>


      
      <div class="col-md-3 mb-3 mt-2">
        <img src='{{ asset("assets/images/manali-attraction5-img.webp") }}' data-aos="fade-up"
            width="100%" height="250px" alt="">
            <div class="manali-content border">
        <h3> Arjun Gufa </h3>
        <p>Located just a short walk from the famous Calangute Beach, Villa Calangute offers a private, luxurious escape in Goa. Perfect for families or groups, this villa combines modern amenities with Goan charm, featuring spacious rooms, a private pool, lush gardens, and personalized service. Enjoy the best of Goa’s vibrant nightlife, shopping, and dining, all while relaxing in your private haven.
          .</p>
    </div>
    </div>


    
    <div class="col-md-3 mb-3 mt-2">
      <img src='{{ asset("assets/images/manali-attraction6-img.webp") }}' data-aos="fade-up"
          width="100%" height="250px" alt="">
          <div class="manali-content border">
      <h3> Vashisht Hot Spring</h3>
      <p>Located just a short walk from the famous Calangute Beach, Villa Calangute offers a private, luxurious escape in Goa. Perfect for families or groups, this villa combines modern amenities with Goan charm, featuring spacious rooms, a private pool, lush gardens, and personalized service. Enjoy the best of Goa’s vibrant nightlife, shopping, and dining, all while relaxing in your private haven.
        .</p>
  </div>
  </div>


  <div class="col-md-3 mb-3 mt-2">
    <img src='{{ asset("assets/images/manali-attraction7-img.webp") }}' data-aos="fade-up"
        width="100%" height="250px" alt="">
        <div class="manali-content border">
    <h3> Beas River</h3>
    <p>Located just a short walk from the famous Calangute Beach, Villa Calangute offers a private, luxurious escape in Goa. Perfect for families or groups, this villa combines modern amenities with Goan charm, featuring spacious rooms, a private pool, lush gardens, and personalized service. Enjoy the best of Goa’s vibrant nightlife, shopping, and dining, all while relaxing in your private haven.
      .</p>
</div>
</div>


<div class="col-md-3 mb-3 mt-2">
  <img src='{{ asset("assets/images/manali-attraction8-img.webp") }}' data-aos="fade-up"
      width="100%" height="250px" alt="">
      <div class="manali-content border">
  <h3>  Great Himalaya National Park </h3>
  <p>Located just a short walk from the famous Calangute Beach, Villa Calangute offers a private, luxurious escape in Goa. Perfect for families or groups, this villa combines modern amenities with Goan charm, featuring spacious rooms, a private pool, lush gardens, and personalized service. Enjoy the best of Goa’s vibrant nightlife, shopping, and dining, all while relaxing in your private haven.
    .</p>
</div>
</div>


<div class="col-md-3 mt-2">
  <img src='{{ asset("assets/images/manali-attraction9-img.webp") }}' data-aos="fade-up"
      width="100%" height="250px" alt="">
      <div class="manali-content border">
  <h3>  Rahala Falls </h3>
  <p>Located just a short walk from the famous Calangute Beach, Villa Calangute offers a private, luxurious escape in Goa. Perfect for families or groups, this villa combines modern amenities with Goan charm, featuring spacious rooms, a private pool, lush gardens, and personalized service. Enjoy the best of Goa’s vibrant nightlife, shopping, and dining, all while relaxing in your private haven.
    .</p>
</div>
</div>



<div class="col-md-3  mt-2">
  <img src='{{ asset("assets/images/manali-attraction10-img.webp") }}' data-aos="fade-up"
      width="100%" height="250px" alt="">
      <div class="manali-content border">
  <h3> Castle of Naggar, Manali </h3>
  <p>Located just a short walk from the famous Calangute Beach, Villa Calangute offers a private, luxurious escape in Goa. Perfect for families or groups, this villa combines modern amenities with Goan charm, featuring spacious rooms, a private pool, lush gardens, and personalized service. Enjoy the best of Goa’s vibrant nightlife, shopping, and dining, all while relaxing in your private haven.
    .</p>
</div>
</div>




<div class="col-md-3  mt-2">
  <img src='{{ asset("assets/images/manali-attraction11-img.webp") }}' data-aos="fade-up"
      width="100%" height="250px" alt="">
      <div class="manali-content border">
  <h3> Rohtang Pass, Manali </h3>
  <p>Located just a short walk from the famous Calangute Beach, Villa Calangute offers a private, luxurious escape in Goa. Perfect for families or groups, this villa combines modern amenities with Goan charm, featuring spacious rooms, a private pool, lush gardens, and personalized service. Enjoy the best of Goa’s vibrant nightlife, shopping, and dining, all while relaxing in your private haven.
    .</p>
</div>
</div>



<div class="col-md-3  mt-2">
  <img src='{{ asset("assets/images/manali-attraction12
  -img.webp") }}' data-aos="fade-up"
      width="100%" height="250px" alt="">
      <div class="manali-content border">
  <h3> Gauri Shankar temple, Manali </h3>
  <p>Located just a short walk from the famous Calangute Beach, Villa Calangute offers a private, luxurious escape in Goa. Perfect for families or groups, this villa combines modern amenities with Goan charm, featuring spacious rooms, a private pool, lush gardens, and personalized service. Enjoy the best of Goa’s vibrant nightlife, shopping, and dining, all while relaxing in your private haven.
    .</p>
</div>
</div>


</div>
</div>

</section>

<!-- Top Attractions Section  end-->




<!-- Booking Form Section -->
<!-- <section id="booking" class="tour-booking-section">
        <div class="container tour-booking-container shadow mt-3">
            <h2 class="text-center mb-4 " style="color: white; padding-top: 30px; font-weight: 700;">Book Your Manali Tour</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form class="booking-form ">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your full name">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tourDate" class="form-label">Tour Date</label>
                            <input type="date" class="form-control" id="tourDate" required>
                        </div>


                        <div class="mb-3">
                            <label for="package" class="form-label">Select Package</label>
                            <select class="form-select" id="package">
                                <option value="basic">Basic Package</option>
                                <option value="premium">Premium Package</option>
                                <option value="luxury">Luxury Package</option>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="tourType" class="form-label">Select Tour Type</label>
                            <select class="form-select" id="tourType" required>
                                <option value="" disabled selected>Select a tour</option>
                                <option value="city">City Tour</option>
                                <option value="cultural">Cultural Tour</option>
                                <option value="historical">Historical Tour</option>
                                <option value="food">Food Tour</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Additional Requests</label>
                            <textarea class="form-control" id="message" rows="3" placeholder="Any special requests or notes"></textarea>
                        </div>


                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Book Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</section> -->



<!-- manali gallery Section  start

      <section class="  manali-gallery-section mt-5 ">
        <div class="container">
            <h2 class="text-center mb-3">Manali Tour Gallery</h2>
            <div class="row">

                <div class="col-md-4 mt-4">
                    <a href="images/manali-g1-img.jpg" class="image-link"  title="Hadimba Temple">
                        <img src="images/manali-g1-img.jpg" class="w-100" style="height: 250px;" alt="">
                    </a>
                </div>
    
                <div class="col-md-4 mt-4">
                    <a href="images/manali-g2-img.jpg" class="image-link" title="Solang Valley">
                        <img src="images/manali-g2-img.jpg" class="w-100" style="height: 250px;" alt="">
                    </a>
                </div>
     

                <div class="col-md-4 mt-4">
                  <a href="images/manali-g3-img.jpg" class="image-link" title="Rohtang Pass">
                      <img src="images/manali-g3-img.jpg" class="w-100" style="height: 250px;" alt="">
                  </a>
              </div>
   

              <div class="col-md-4 mt-4">
                <a href="images/manali-g4-img.jpg" class="image-link" title=" Manali Gompa">
                    <img src="images/manali-g4-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>
 

           
         

        <div class="col-md-4 mt-4">
          <a href="images/manali-g5-img.jpg" class="image-link" title="Hampta Pass">
              <img src="images/manali-g5-img.jpg" class="w-100" style="height: 250px;" alt="">
          </a>
      </div> -->


      <!-- <div class="col-md-4 mt-4">
        <a href="images/manali-g6-img.jpg" class="image-link" title="Manikaran">
            <img src="images/manali-g6-img.jpg" class="w-100" style="height: 250px;" alt="">
        </a>
    </div> -->


<!--     
    <div class="col-md-4 mt-4">
      <a href="images/manali-g7-img.jpg" class="image-link" title="Great Himalayan National Park">
          <img src="images/manali-g7-img.jpg" class="w-100" style="height: 250px;" alt="">
      </a>
  </div> -->


<!--   
  <div class="col-md-4 mt-4">
    <a href="images/manali-g8-img.jpg" class="image-link" title="Bhrigu Lake">
        <img src="images/manali-g8-img.jpg" class="w-100" style="height: 250px;" alt="">
    </a>
</div> -->


<!-- <div class="col-md-4 mt-4">
  <a href="images/manali-g9-img.jpg" class="image-link" title="Museum of Himachal Culture and Folk Art">
      <img src="images/manali-g9-img.jpg" class="w-100" style="height: 250px;" alt="">
  </a>
</div> -->

<!-- 
<div class="col-md-4 mt-4">
  <a href="images/manali-g10-img.jpg" class="image-link" title="Nehru Kund">
      <img src="images/manali-g10-img.jpg" class="w-100" style="height: 250px;" alt="">
  </a>
</div> -->



<!-- <div class="col-md-4 mt-4">
  <a href="images/manali-g11-img.jpg" class="image-link" title="Naggar Castle">
      <img src="images/manali-g11-img.jpg" class="w-100" style="height: 250px;" alt="">
  </a>
</div> -->


<!-- 
<div class="col-md-4 mt-4">
  <a href="images/manali-g12-img.jpg" class="image-link" title="Himalayan Nyingmapa Buddhist Temple">
      <img src="images/manali-g12-img.jpg" class="w-100" style="height: 250px;" alt="">
  </a>
</div> -->

     <!-- </section> -->
    
    
<!-- manali gallery Section  end->            
    




 <!-- Tour Packages Section -->
 <section id="packages" class="bg-light py-5">
  <div class="container text-center">
    <h2 class="section-title">Our Manali Tour Packages</h2>
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="card package-card">
          <img src='{{ asset("assets/images/manali-honymoon-img.jpg") }}' class="card-img-top" alt="Manali Package 1">
          <div class="card-body">
            <h5 class="card-title">Manali Honeymoon Package</h5>
            <p class="card-text">Experience the romantic side of Manali with our 5-day honeymoon package. Includes accommodation, meals, and sightseeing.</p>
            <a href="#" class="btn btn-primary">Add to cart</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card package-card">
          <img src='{{ asset("assets/images/manali-adventure-img.jpg") }}'class="card-img-top" alt="Manali Package 2">
          <div class="card-body">
            <h5 class="card-title">Adventurous Manali</h5>
            <p class="card-text">Explore the thrill of adventure in Manali with paragliding, trekking, and skiing. A 6-day package for the thrill-seekers.</p>
            <a href="#" class="btn btn-primary">Add to cart</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card package-card">
          <img src='{{ asset("assets/images/familytour-manali.jpg") }}' class="card-img-top" alt="Manali Package 3">
          <div class="card-body">
            <h5 class="card-title">Family Tour in Manali</h5>
            <p class="card-text">Enjoy a 7-day family vacation in Manali with comfortable accommodations, guided tours, and fun activities for all ages.</p>
            <a href="#" class="btn btn-primary">Add to cart</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>





<!-- Travel Information Section  start-->

<section id="travel-info text-center" data-aos="zoom-in">
    <div class="container travel-information-container  bg-warning text-center mt-5 py-4">
        <h2 class="TIH py-2">Travel Information</h2>

        <ul class="travel-info-list mt-3 list-unstyled  px-2"
            style="line-height: 23px; ">
            <li><strong>Best Time to Visit:</strong> October to June</li>
                <br>
            <li><strong>How to Get Around:</strong> trains, cabs, buses,
                and auto-rickshaws make it easy to navigate the city.</li>
                <br>
            <li><strong>Nearby Airport:</strong>The nearest airport is Kullu-Manali Airport (Bhuntar Airport), located approximately 50 km from Manali. It offers flights primarily from Delhi.</li>
        </ul>
    </div>

</section>

<!-- Travel Information Section end -->


@endsection