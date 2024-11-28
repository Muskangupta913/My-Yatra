@extends('frontend.layouts.master')
@section('content')
<style>
    
    /* delhi-destination-section-start */

   .delhi-banner-section{
    background: linear-gradient(rgba(0, 0, 0, 0.466), rgba(0, 0, 0, 0.444)), url('{{ asset("assets/images/delhi-banner.jpeg") }}') no-repeat center center;
    background-size: cover;
    height: 450px;
    width: 100%;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    resize: horizontal;

 }


  .tour-booking-container{
    background-image: url('../images/bg-form-img.jpeg');
    background-size: cover;
    height: 800px;
    width: 100%;
 background-position: center;
    background-repeat: no-repeat;
    
 }

 .banner-content p{
    font-size: 1.5rem;
    font-weight: 500;
 }

  .banner-content h1{
 font-size: 3rem;
 font-weight: 700;
 }

 .delhi-banner-c p{
    font-weight: 500;
    margin-top: 20px;
 }

 .delhi-destinations h3{
 margin: 10px 0px!important;
 }

 @media only screen and (max-width: 600px) {

    .delhi-destinations .col-md-3 img{   
        height: auto !important;
       }
  
    .delhi-banner-section{
        background: linear-gradient(rgba(0, 0, 0, 0.466), rgba(0, 0, 0, 0.444)), url('../images/delhi-banner.jpeg') no-repeat center center;
        background-size: cover;
        height: 300px;
        width: 100%;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
     }

     .delhi-content{
     padding: 0px 5px;
     }

  .ads img{
    width: 100%;
    height: 200px;
  }

  .map {
   width: 100%;
   height: 100%;
   margin-top: 30px;
  }

   .attraction-container h2{
  padding-top: 50px;
  }

 .itineraries-container{
    margin-top: 30px;
   }

   .banner-content p{
    font-size: 1.2rem;
 }

  .banner-content h1{
 font-size: 2rem;
 }

  .tour-booking-container{
    height: 780px;
 }
 }
 
     /* delhi-destination-section-end */


</style>
<!-- banner Section -->
<section class="delhi-banner-section">
    <div class="container-fluid delhi-banner-c">
        <div class="banner-content">
            <h1>Discover the Heart of India – Delhi</h1>
            <p>Experience the blend of ancient heritage and modern marvels in
                India’s capital city.</p>
        </div>

    </div>
</section>





<!-- About Delhi Section -->

<section id="about-box">
    <div class="container-fluid ads mt-5 g-5 text-center">
        <div class="row">

            <div class="col-md-6">
                <h2>About Delhi</h2>
                <p class="ads-p-c mt-4 b-5">
                    Delhi, the capital of India, is a dynamic city where
                    time-honored traditions and modernity exist side by side.
                    From its centuries-old monuments to bustling markets and
                    cutting-edge urban developments, Delhi offers a cultural,
                    historical, and architectural experience like no other. It
                    is a melting pot of diverse cultures, languages, and
                    communities, making it one of the most vibrant cities in the
                    world.
                </p>
                <img src="{{ asset('assets/images/delhi-about-short-img.jpg') }}" data-aos="flip-left"
                    width="400px" alt>
            </div>

                <div class="col-md-6">
                <iframe class="map"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d448194.82162352453!2d77.09323125!3d28.6440836!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x37205b715389640!2sDelhi!5e0!3m2!1sen!2sin!4v1727255134723!5m2!1sen!2sin"
                    width="600" height="450" style="border:0;" allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

        </div>
    </div>
</section>  
          
<!-- Top Attractions Section -->
<section id="attractions " data-aos="fade-up">
  <div class="container-fluid delhi-destinations  mb-4 mt-5 py-3 px-4 text-center">
        <h2>Top Attractions in Delhi</h2>
        <div class="row">

            <div class="col-md-3 mb-3 mt-4">
                <img src="{{ asset('assets/images/red-fort-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="delhi-content border">
                <h3>Red Fort</h3>
                <p>The 17th-century fort, a symbol of India’s rich past, stands
                    as a majestic reminder of Mughal grandeur.</p>  
            </div>
        </div>
            <div class="col-md-3 mb-3 mt-4">
                <img src="{{ asset('assets/images/qutub-minaar.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="delhi-content border">
                <h3>Qutub Minar</h3>
                <p>This UNESCO World Heritage Site is the tallest brick minaret
                    in the world, showcasing remarkable Indo-Islamic
                    architecture.</p>    
            </div>
        </div>
            <div class="col-md-3 mb-3 mt-4">
                <img src="{{ asset('assets/images/lotus-temple-img.jpeg') }}" data-aos="fade-up"
                    width="100%"  height="250px" alt="Lotus Temple">
                    <div class="delhi-content border">
                <h3>Lotus Temple</h3>
                <p>A symbol of peace, this Bahá’í House of Worship is known for
                    its flower-like design and tranquil ambiance.</p>    
            </div>
        </div>



            <div class="col-md-3 mb-3 mt-4">
                <img src="{{ asset('assets/images/humayus-tomb-img.jpeg') }}" data-aos="fade-up"
                    width="100%" height="250px"  alt="Humayun's Tomb">
                    <div class="delhi-content border">
                <h3>Humayun’s Tomb</h3>
                <p>The stunning garden tomb of Emperor Humayun, a precursor to
                    the Taj Mahal in its architectural brilliance.</p>    
            </div>
            </div>




            <div class="col-md-3 mb-3 mt-4">
                <img src="{{ asset('assets/images/indiagate.img') }}" data-aos="fade-up"
                    width="100%"  height="250px" alt="">
                    <div class="delhi-content border">
                <h3>India Gate</h3>
                <p>India Gate is a 42-meter-tall war memorial in New Delhi, built in 1931 to honor Indian soldiers who died in World War I. The Amar Jawan Jyoti, an eternal flame, commemorates soldiers' sacrifices in later wars. It's a major landmark and tourist attraction..</p>   
            </div>
            </div>


         
            
            <div class="col-md-3  mb-3 mt-4">
                <img src="{{ asset('assets/images/agra-img.jpg') }}" data-aos="fade-up"
                    width="100%"  height="250px" alt="">
                    <div class="delhi-content border">
                <h3>Delhi Agra</h3>
                <p>Agra, located near Delhi, is home to the iconic Taj Mahal, a UNESCO World Heritage Site and one of the Seven Wonders of the World. Famous for its Mughal architecture, including Agra Fort and Fatehpur Sikri, it’s a major tourist destination with a rich cultural history.</p>    
            </div>
            </div>



            <div class="col-md-3 mb-3 mt-4">
                <img src="{{ asset('assets/images/jama-maszid-img.jfif') }}" data-aos="fade-up"
                    width="100%"  height="250px" alt="">
                    <div class="delhi-content  border" >
                <h3>Jama Maszid</h3>
                <p>Jama Masjid in Agra, built in 1648 by Shah Jahan's daughter, is a large mosque known for its stunning Mughal architecture. Located near the Agra Fort, it features intricate red sandstone and marble designs, making it a significant historical and religious site.</p>
            </div>
            </div>



            <div class="col-md-3 mb-3 mt-4">
                <img src="{{ asset('assets/images/hauzkhas-img.jfif') }}" data-aos="fade-up"
                    width="100%"height="250px" alt="">
                    <div class="delhi-content border" >
                <h3>Hauz Khas</h3>
                <p>Hauz Khas is a trendy neighborhood in Delhi, blending historic ruins with modern cafes, boutiques, and art galleries. Known for the Hauz Khas Complex, it includes a medieval water reservoir, mosque, and tombs, making it a popular spot for both history and nightlife.</p>    
            </div>
            </div>




            <div class="col-md-3 mb-3 mt-4">
                <img src="{{ asset('assets/images/chandni-chowk-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px"           alt="">
                    <div class="delhi-content border">
                <h3>Chandni Chowk</h3>
                <p>Chandni Chowk is one of Delhi's oldest and busiest markets, known for its narrow lanes, vibrant bazaars, street food, and historical landmarks like the Red Fort and Jama Masjid. It's a bustling hub for shopping, especially for spices, jewelry, and textiles.
                 </p>
            </div>
            </div>



            <div class="col-md-3 mb-3 mt-4">
                <img src="{{ asset('assets/images/rashtrapati-bhawan-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px"         alt="">
                    <div class="delhi-content border">
                <h3>Rashtrapatie  Bhawan</h3>
                <p>Rashtrapati Bhawan, located in New Delhi, is the official residence of the President of India. Spanning 330 acres, it boasts 340 rooms and stunning Mughal Gardens. Designed by Sir Edwin Lutyens, it symbolizes India's democratic spirit and architectural grandeur.
                 </p> 
            </div>
            </div>



            <div class="col-md-3 mb-3 mt-4">
                <img src="{{ asset('assets/images/sarojini-nagar-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="delhi-content  border" >
                <h3>Sarojoini Nagar Market</h3>
                <p>Sarojini Nagar Market in Delhi is a popular shopping destination known for its affordable fashion, trendy clothing, and accessories. It attracts both locals and tourists looking for great bargains, making it a hub for budget-friendly shopping.                    .
                 </p> 
            </div>
            </div>


            <div class="col-md-3 mb-3 mt-4">
                <img src="{{ asset('assets/images/lodhi-gardens-img.jfif') }}"  data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="delhi-content border">
                <h3>Lodhi Garden</h3>
                <p>
                   Lodhi Garden in Delhi is a historic park featuring 15th-century tombs from the Lodhi dynasty. Known for its greenery and peaceful atmosphere, The gardens picnics, and photography. the tombs of 15th and 16th-century rulers from the Lodhi dynasty.
                 </p>       
            </div>
             </div>
    



                <div class="col-md-3 mb-3 mt-4">
                    <img src="{{ asset('assets/images/akshardham-temple-img.jpg') }}"  data-aos="fade-up"
                        width="100%" height="250px" alt="">
                        <div class="delhi-content border ">
                    <h3>Akshardham Temple</h3>
                            <p>Akshardham Temple in Delhi is a stunning Hindu temple known for its grand architecture and intricate carvings. Opened in 2005, it showcases India's ancient culture, spirituality, and traditions, making it a major spiritual and tourist attraction.
                            </p>
                </div>
                </div>


               
                <div class="col-md-3 mb-3  mt-4">
                    <img src="{{ asset('assets/images/gurudwara-bangla-sahib-img.jpg') }}" data-aos="fade-up"
                        width="100%" height="250px" alt="">
                        <div class="delhi-content border">
                    <h3>Gurudwara Bangla Sahib</h3>
                            <p>Gurudwara in Delhi is a prominent Sikh temple known for its serene atmosphere . It commemorates the 8th Sikh Guru, Guru Har Krishan, and is a major religious and tourist site, offering free meals (langar) to all visitors.
                            </p> 
                </div>
                </div>
                <div class="col-md-3 mb-3 mt-4">
                    <img src="{{ asset('assets/images/jantar-mantar-img.jpg') }}"  data-aos="fade-up"
                        width="100%" height="250px" alt="">
                        <div class="delhi-content  border">
                    <h3>Jantar Mantar</h3>
                            <p>Jantar Mantar in Delhi is an 18th-century astronomical observatory built by Maharaja Jai Singh II. It features large instruments used to study celestial bodies, making it a significant historical and scientific landmark.
                            </p>
                </div>
                </div>   
                <div class="col-md-3  mt-4">
                    <img src="{{ asset('assets/images/national-museum-img.jpg') }}"  data-aos="fade-up"
                        width="100%" height="250px" alt="">
                        <div class="delhi-content border ">
                    <h3>National Museum</h3>
                            <p>The National Museum in Delhi is one of India’s largest museums. Its extensive collection includes artifacts from the Indus Valley Civilization, and Indian art, offering a deep dive into the country’s cultural heritage.
                            </p>
                </div>
            </div>

            </div>
         </div>
        </section>
 <!-- Booking Form Section -->
 <!-- <section id="booking" class="tour-booking-section">
        <div class="container tour-booking-container shadow">
            <h2 class="text-center mb-4 " style="color: white; padding-top: 30px; font-weight: 700;">Book Your Delhi Tour</h2>
            <div class="row   booking-box justify-content-center">
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






    <!-- Gallery Section -->
    <!-- <section class="delhi-gallery-section">
    <div class="container">
        <h2 class="text-center  mt-5">Delhi Tour Gallery</h2>
        <div class="row">
            <div class="col-md-4 mt-4">
                <a href="images/delhi-g1-img.jpg" class="image-link"  title="Hauz Khas">
                    <img src="images/delhi-g1-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>

            <div class="col-md-4 mt-4">
                <a href="images/delhi-g2-img.jpg" class="image-link" title="Delhi Haat">
                    <img src="images/delhi-g2-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>

            <div class="col-md-4 mt-4">     
           <a href="images/delhi-g3-img.jpg" class="image-link"   title="India Gate">
            <img src="images/delhi-g3-img.jpg" class="w-100" style="height: 250px;" alt="">
             </a>
            </div>



            <div class="col-md-4 mt-4">
                <a href="images/delhi-g4-img.jpg" class="image-link" title="Agrasen Baoli">
                    <img src="images/delhi-g4-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>


            <div class="col-md-4 mt-4">
                <a href="images/delhi-g5-img.jpg" class="image-link" title="Akshardham Temple">
                    <img src="images/delhi-g5-img.jpg" class="w-100"  style="height: 250px;" alt="">
                </a>
            </div>


            <div class="col-md-4 mt-4">
                <a href="images/delhi-g6-img.jpg" class="image-link" title="Lotus Temple">
                    <img src="images/delhi-g6-img.jpg" class="w-100"  style="height: 250px;" alt="">
                </a>
            </div>


            <div class="col-md-4 mt-4">
                <a href="images/delhi-g7-img (1).jpg" class="image-link" title="Jantar Mantar">
                    <img src="images/delhi-g7-img (1).jpg" class="w-100"  style="height: 250px;"alt="">
                </a>
            </div>

            <div class="col-md-4 mt-4">
                <a href="images/delhi-g8-img.jpg" class="image-link" title="Purana Quila">
                    <img src="images/delhi-g8-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>


            <div class="col-md-4 mt-4">
                <a href="images/delhi-g9-img.jpg" class="image-link" title="Nehru Park">
                    <img src="images/delhi-g9-img.jpg" class="w-100"  style="height: 250px;" alt="">
                </a>
            </div>


            <div class="col-md-4 mt-4">
                <a href="images/delhi-g10-img.jpg" class="image-link" title="Snow World">
                    <img src="images/delhi-g10-img.jpg" class="w-100" style="height: 250px;" alt="">
                </a>
            </div>


            <div class="col-md-4 mt-4">
                <a href="images/delhi-g11-img.jpg" class="image-link" title="Craft Museum">
                    <img src="images/delhi-g11-img.jpg" class="w-100"  style="height: 250px;" alt="">
                </a>
            </div>



            <div class="col-md-4 mt-4">
                <a href="images/delhi-g12-img.jpg" class="image-link" title="Qutub Minar">
                    <img src="images/delhi-g12-img.jpg" class="w-100"  style="height: 250px;"  alt="">
                </a>
            </div>

        </div>
    </div>

    </section> -->



   


<!-- Delhi tour packages Section -->

<section class="bg-light">
  <div class="container my-5">
    <h1 class="text-center mb-5 py-3">Delhi Tour Packages</h1>
    <div class="row g-4">
      
      <!-- Tour Package 1 -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="{{ asset('assets/images/tour-image-1.jpg') }}" class="card-img-top" alt="Delhi Heritage Tour">
          <div class="card-body">
            <h5 class="card-title">Delhi Heritage Tour Package</h5>
            <p class="card-text">Explore Red Fort, Qutub Minar, Humayun’s Tomb, and more on this 3-day cultural journey.</p>
            <p><strong>Duration:</strong> 3 Days / 2 Nights</p>
            <p><strong>Price:</strong> ₹7,499 per person</p>
            <a href="#" class="btn btn-primary">Add to cart</a>
          </div>
        </div>
      </div>
      
      <!-- Tour Package 2 -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="{{ asset('assets/images/tour-image-2.jpg') }}" class="card-img-top" alt="Cultural & Shopping Tour">
          <div class="card-body">
            <h5 class="card-title">Delhi Cultural & Shopping Tour</h5>
            <p class="card-text">Discover Delhi’s vibrant culture, shop in local markets, and indulge in street food.</p>
            <p><strong>Duration:</strong> 2 Days / 1 Night</p>
            <p><strong>Price:</strong> ₹5,999 per person</p>
            <a href="#" class="btn btn-primary">Add to cart</a>
          </div>
        </div>
      </div>
      
      <!-- Tour Package 3 -->
      <!-- <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="{{ asset('assets/images/tour-image-3.jpg') }}"  class="card-img-top" alt="Spiritual Tour">
          <div class="card-body">
            <h5 class="card-title">Delhi Spiritual Tour Package</h5>
            <p class="card-text">Visit Akshardham, Lotus Temple, Jama Masjid, and more on this spiritual retreat.</p>
            <p><strong>Duration:</strong> 2 Days / 1 Night</p>
            <p><strong>Price:</strong> ₹6,499 per person</p>
            <a href="#" class="btn btn-primary">Book Now</a>
          </div>
        </div>
      </div> -->

      <!-- Tour Package 4 -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="{{ asset('assets/images/tour-image-4.jpg') }}"  class="card-img-top" alt="Adventure Tour">
          <div class="card-body">
            <h5 class="card-title">Delhi Adventure & Outdoor Tour</h5>
            <p class="card-text">Experience nature, cycling tours, and hot air balloon rides with this adventurous package.</p>
            <p><strong>Duration:</strong> 3 Days / 2 Nights</p>
            <p><strong>Price:</strong> ₹8,999 per person</p>
            <a href="#" class="btn btn-primary">Add to cart</a>
          </div>
        </div>
      </div>

      <!-- Tour Package 5 -->
      <!-- <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="{{ asset('assets/images/tour-image-5.jpg') }}" class="card-img-top" alt="Express Tour">
          <div class="card-body">
            <h5 class="card-title">Delhi in One Day: Express Tour</h5>
            <p class="card-text">See all the major landmarks like Qutub Minar, Red Fort, and India Gate in one day.</p>
            <p><strong>Duration:</strong> 1 Day</p>
            <p><strong>Price:</strong> ₹3,499 per person</p>
            <a href="#" class="btn btn-primary">Book Now</a>
          </div>
        </div>
      </div> -->

      <!-- Custom Tour -->
      <!-- <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="{{ asset('assets/images/tour-image-6.jpg') }}"  class="card-img-top" alt="Custom Tour">
          <div class="card-body">
            <h5 class="card-title">Customize Your Delhi Tour</h5>
            <p class="card-text">Create your own personalized itinerary with our fully customizable packages.</p>
            <a href="#" class="btn btn-secondary">Customize Now</a>
          </div>
        </div>
      </div> -->

    </div>
  </div>

</section>





<!-- Travel Information Section -->
<section id="travel-info text-center" data-aos="zoom-in">
    <div class="container travel-information-container  bg-warning text-center mt-5 py-4">
        <h2 class="TIH py-2">Travel Information</h2>

        <ul class="travel-info-list mt-3 list-unstyled  px-2"
            style="line-height: 25px; ">
            <li><strong>Best Time to Visit:</strong> October to March, when the
                weather is pleasant.</li>
                <br>
            <li><strong>How to Get Around:</strong> Delhi Metro, cabs, buses,
                and auto-rickshaws make it easy to navigate the city.</li>
                <br>
            <li><strong>Nearby Airport:</strong> Indira Gandhi International
                Airport, located about 15 km from the city center.</li>
        </ul>
    </div>

</section>

@endsection