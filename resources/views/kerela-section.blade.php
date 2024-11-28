@extends('frontend.layouts.master')
@section('content')
<style>
     /* kerala-tour-destination-section-start */

 .kerala-section {
    background: linear-gradient(rgba(0, 0, 0, 0.382), rgba(0, 0, 0, 0.366)), url('{{ asset("assets/images/kerala-banner.jpg") }}') no-repeat center center/cover;
    height: 450px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
}

.kerala-banner h1 {
    font-size: 3rem;
    font-weight: 700;
}

.kerala-banner p{
    font-weight: 500;
    font-size: 1.5rem;
    margin-top: 20px;
}

.about-section img {
    max-width: 300px;
    height: auto;
}

.card {
    border: none;
    transition: transform 0.3s ease;
}
/* 
.card:hover {
    transform: translateY(-10px);
} */
 
.kerala-destinations p{
    padding: 0px 10px;
}

.kerala-destinations h3{
 margin: 10px 0px;
}


@media only screen and (max-width: 600px) {

  
      .kerala-section {
        background: linear-gradient(rgba(0, 0, 0, 0.382), rgba(0, 0, 0, 0.366)), url('../images/kerala-banner.jpg') no-repeat center center/cover;
        height: 300px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .kerala-banner h1 {
        font-size: 2rem;
    }
    
    .kerala-banner p{
        font-size: 1.2rem;
    }
   
    .kerala-destinations img{
        height: 200px;
    }
    }

 /* keralatour-destination-section-end */
</style>
  <!-- kerala banner Section  start -->
  <section class="kerala-section">
        <div class="container kerala-banner">
            <h1>Explore the Beauty of Kerala</h1>
            <p>Backwaters, Beaches, and Hills - A Paradise on Earth</p>
        </div>
    </section>

  <!-- kerala banner Section  end -->

<!-- About kerala Section start -->

<section id="about-box">
    <div class="container-fluid ads mt-5 g-5 text-center">
        <div class="row">

            <div class="col-md-6">
                <h2>About Kerala</h2>
                <p  class="ads-p-c mt-3 b-5">Kerala, often referred to as "God's Own Country," is a beautiful state in the southern part of India, known for its lush green landscapes, serene backwaters, and rich cultural heritage. The state's major attractions include the tranquil backwaters of Alleppey, the scenic hill stations like Munnar, pristine beaches such as Kovalam, and the vibrant traditions like Kathakali dance and Ayurveda. Kerala is also famous for its spice plantations and delicious cuisine. Its unique mix of natural beauty and rich history makes it a must-visit destination for travelers.
                </p>
       
                <img src="{{ asset('assets/images/kerala-view-img1.jpg') }}" data-aos="flip-left"
                    width="400px" alt>
            </div>

           
            <div class="col-md-6">
                <iframe class="map"
                      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4016584.092792871!2d76.13836675!3d10.544276349999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b0812ffd49cf55b%3A0x64bd90fbed387c99!2sKerala!5e0!3m2!1sen!2sin!4v1728124386938!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"> width="600" height="450"
                    width="600" height="450" style="border:0;" allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

        </div>
    </div>


<!-- About kerala Section end -->






  <!-- Top Attractions Section  start-->
  <section id="attractions " data-aos="fade-up">

    <div class="container-fluid kerala-destinations  mt-5 py-3 px-4 text-center">
          <h2>Top Attractions in Kerala</h2>
          <div class="row">
  
              <div class="col-md-3 mb-3 mt-2">
                  <img src="{{ asset('assets/images/kerala-attraction1-img.jpg') }}" data-aos="fade-up"
                      width="100%" height="250px" alt="">
                      <div class="manali-content border">
                  <h3>Alleppey Backwaters</h3>
                  <p>Known as the "Venice of the East," Alleppey offers a serene experience with its scenic backwaters, and picturesque landscapes. It's perfect for a peaceful getaway, where you can float past coconut groves, paddy fields, and traditional Kerala villages.
                    .</p>
              </div>
              </div>


              <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/kerala-attraction2-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="manali-content border">
                <h3>Munnar</h3>
                <p> This hill station is famed for its tea plantations, misty hills. Munnar is a paradise for nature lovers and trekkers, with attractions like the Eravikulam National Park,  and the scenic Mattupetty Dam Tea Gardens: Expansive tea plantations offering picturesque views.

                  .</p>
            </div>
            </div>



            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/kerala-attraction3-img.webp') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="manali-content border">
                <h3>Kochi </h3>
                <p> A vibrant blend of old-world charm and modernity, Kochi is known for its historical landmarks like Fort Kochi, Chinese fishing nets, and Mattancherry Palace. The city is a cultural melting pot with influences from Portuguese, Dutch, and British colonial periods.
                  .</p>
            </div>
            </div>



            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/kerala-attraction4-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="manali-content border">
                <h3>Thekkady </h3>
                <p> Famous for its dense forests and diverse wildlife,  where you can enjoy boat rides on the Periyar Lake and spot elephants, tigers, and other wildlife in their natural habitat.Thekkady is a must-visit for wildlife enthusiasts and nature lovers exploring Kerala.</p>
            </div>
            </div>


            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/kerala-attraction5-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="manali-content border">
                <h3>Kovalam Beach</h3>
                <p> Kovalam is one of Kerala’s most popular beach destinations, known for its crescent-shaped beaches lined with palm trees. It's ideal for sunbathing, swimming, and enjoying water sports like surfing.</p>
            </div>
            </div>


            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/kerala-attraction6-img.jfif') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="manali-content border">
                <h3>Wayanad</h3>
                <p> A lush green paradise, Wayanad is perfect for nature lovers and adventure enthusiasts. Visit the Edakkal Caves, Chembra Peak, and enjoy wildlife spotting at the Wayanad Wildlife Sanctuary.</p>
            </div>
            </div>


            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/kerala-attraction7-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="manali-content border">
                <h3>Varkala Beach</h3>
                <p> Known for its unique cliff-side beach setting, Varkala stunning views of the Arabian Sea. It’s also a popular spot for spiritual seekers with its ancient Janardanaswamy Temple and natural spring with healing properties.</p>
            </div>
            </div>


            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/kerala-attraction8-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="manali-content border">
                <h3>Athirappilly Waterfalls</h3>
                <p>Often called the "Niagara of India," Athirappilly is the largest waterfall in Kerala, offering breathtaking views amidst lush greenery. It’s a great spot for nature lovers and photographers.</p>
            </div>
            </div>



            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/kerala-attraction9-img.jfif') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="manali-content border">
                <h3>Kumarakom </h3>
                <p>Nestled on the banks of Vembanad Lake, Kumarakom is a peaceful destination, famous for its backwater cruises, bird sanctuary, and Ayurvedic resorts. It’s a perfect blend of relaxation and nature.</p>
            </div>
            </div>



            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/kerala-attraction10-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="manali-content border">
                <h3>Trivandrum </h3>
                <p> Kerala's capital city offers attractions like the Padmanabhaswamy Temple, Napier Museum, and the nearby Kovalam Beach. It’s a great place to explore Kerala’s cultural heritage and history.</p>
            </div>
            </div>


            
            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/kerala-attraction11-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="manali-content border">
                <h3>Trissur </h3>
                <p>Thrissur, known as the cultural capital of Kerala,  temples, and heritage.its Houses the historic Vadakkunnathan Temple.  Known for its contributions to Kerala’s traditional arts and cultural activities.</p>
            </div>
            </div>


            
            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/kerala-attraction12-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="manali-content border">
                <h3>Silent Valley National Park </h3>
                <p> 
                    Silent Valley National Park is one of India's most ecologically diverse and well-preserved rainforests, located in the Nilgiri Hills of Kerala. Adventure  Offers birdwatching, ideal for nature lovers and researchers.
                </p>
            </div>
            </div>


              </div>
              </div>
              </section>

      <!-- Top Attractions Section  end--->




 
 <!-- Booking Form Section start -->
<!-- 
 <section id="booking" class="tour-booking-section ">
    <div class="container tour-booking-container shadow">
        <h2 class="text-center mb-4 " style="color: white; padding-top: 30px; font-weight: 700;">Book Your Kerala Tour</h2>
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


<!-- Booking Form Section end -->



    



  <!-- kerala  Gallery Section  start-->
<!-- 
  <section class="kerala-gallery-section">


    <div class="container kerala-g-container">
        <h2 class="text-center mb-4 mt-5">Kerala Tour Gallery</h2>
        <div class="row">

            <div class="col-md-4 mb-4">
                <a href="images/kerala-g1-img.jpg" class="image-link"  title=" Kochi">
                    <img src="images/kerala-g1-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>


            <div class="col-md-4 mb-4">
                <a href="images/kerala-g2-img.jpg" class="image-link"  title="Thekkady">
                    <img src="images/kerala-g2-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>

            <div class="col-md-4 mb-4">
                <a href="images/kerala-g3-img.jpg" class="image-link"  title="Kumarakom">
                    <img src="images/kerala-g3-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div> -->

<!-- 
            <div class="col-md-4 mb-4">
                <a href="images/kerala-g4-img.jpg" class="image-link"  title="Poovar Island">
                    <img src="images/kerala-g4-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>


            <div class="col-md-4 mb-4">
                <a href="images/kerala-g5-img.jpg" class="image-link"  title="Kovalam">
                    <img src="images/kerala-g5-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>


            <div class="col-md-4 mb-4">
                <a href="images/kerala-g6-img.jpg" class="image-link"  title="Thiruvananthapuram">
                    <img src="images/kerala-g6-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>


            <div class="col-md-4 mb-4">
                <a href="images/kerala-g7-img.jpg" class="image-link"  title="Kozhikode">
                    <img src="images/kerala-g7-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>


            
            <div class="col-md-4 mb-4">
                <a href="images/kerala-g8-img.jpg" class="image-link"  title="Ashtamudi">
                    <img src="images/kerala-g8-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>


            <div class="col-md-4 mb-4">
                <a href="images/kerala-g9-img.jpg" class="image-link"  title=" Guruvayur">
                    <img src="images/kerala-g9-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>


            
            <div class="col-md-4 mb-4">
                <a href="images/kerala-g10-img.jpg" class="image-link"  title=" Idukki">
                    <img src="images/kerala-g10-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>


            <div class="col-md-4 mb-4">
                <a href="images/kerala-g11-img.jpg" class="image-link"  title=" Kerala Food">
                    <img src="images/kerala-g11-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div> -->
<!-- 

            <div class="col-md-4 mb-4">
                <a href="images/kerala-g12-img.jpg" class="image-link"  title=" Shopping Kerala">
                    <img src="images/kerala-g12-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>


            </div>
            </div>
            </section> -->


      <!-- kerala  Gallery Section  end -->



    <!-- Tour Packages Section -->
    <section id="packages" class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="mb-4">Popular Kerala Tour Packages</h2>
            <div class="row">
                <!-- Package 1 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <img src="{{ asset('assets/images/kerala-houseboad-img.jfif') }}"class="card-img-top" alt="Backwaters Package">
                        <div class="card-body">
                            <h5 class="card-title">Backwaters and Houseboat Tour</h5>
                            <p class="card-text">Enjoy a tranquil houseboat ride through the scenic backwaters of Alleppey.</p>
                            <a href="#" class="btn btn-primary">Add to cart</a>
                        </div>
                    </div>
                </div>
                <!-- Package 2 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <img src="{{ asset('assets/images/kerala-beach-img.jpg') }}" class="card-img-top" alt="Beach and Ayurveda">
                        <div class="card-body">
                            <h5 class="card-title">Beach and Ayurveda Wellness Retreat</h5>
                            <p class="card-text">Relax on the golden beaches of Kovalam and indulge in Ayurvedic therapies.</p>
                            <a href="#" class="btn btn-primary">Add to cart</a>
                        </div>
                    </div>
                </div>
                <!-- Package 3 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card">
                        <img src="{{ asset('assets/images/kerala-munnar-hill-img.jpg') }}" class="card-img-top" alt="Hill Station Escape">
                        <div class="card-body">
                            <h5 class="card-title">Munnar Hill Station Escape</h5>
                            <p class="card-text">Breathe in the cool mountain air and explore the tea plantations of Munnar.</p>
                            <a href="#" class="btn btn-primary">Add to cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Travel Information Section start -->
<section id="travel-info text-center" data-aos="zoom-in">
    <div class="container travel-information-container  bg-warning text-center mt-3 py-4">
        <h2 class="TIH py-2">Travel Information</h2>

        <ul class="travel-info-list mt-3 list-unstyled  px-2"
            style="line-height: 25px; ">
            <li><strong>Best Time to Visit:</strong> ">October to June is ideal for visiting Manali, with December to February offering snow activities </li>
                <br>
            <li><strong>How to Get Around:</strong> trains, cabs, buses,
                and auto-rickshaws make it easy to navigate the city.</li>
                <br>
            <li><strong>Nearby Airport:</strong>  The nearest airport is Bhuntar Airport, 50 km from Manali.</li>
        </ul>
    </div>

</section>

<!-- Travel Information Section end -->


@endsection