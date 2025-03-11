@extends('frontend.layouts.master')
@section('content')

<style>
 /*coimbatore-destination-section-start */
 .coimbatore-section{
    background-image:linear-gradient(rgba(0, 0, 0, 0.562), rgba(0, 0, 0, 0.468)), url('{{ asset("assets/images/coimbatore-destination-banner2.PNG") }}');
    background-size: cover;
    background-position: center;
    height: 450px;
    color: white;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

.coimbatore-section  h1 {
    font-size: 3rem;
    font-weight: 700;
}


.coimbatore-section  p {
    font-size: 1.5rem;
    font-weight: 500;
    margin-top: 20px;
}

.icon {
    font-size: 2rem;
}

.card img {
    height: 200px;
    object-fit: cover;
}


.booking-form {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.coimbatore-container img {
    max-width:100%;
    height:auto;

}

 .coimbatore-content p{
 padding: 0px 10px;
 }

 .coimbatore-content h3{
    margin: 10px 0px;
 }



@media only screen and (max-width: 600px) {  
 
 .coimbatore-section{
    background-image:linear-gradient(rgba(0, 0, 0, 0.562), rgba(0, 0, 0, 0.468)), url('../images/coimbatore-banner.webp');
    background-size: cover;
    background-position: center;
    height: 300px;
    color: white;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

 .Coimbatore-map{
 width: 100%;
 height: 100%;
 margin-top: 30px;
}


.coimbatore-section  h1 {
    font-size: 2rem;
}

.coimbatore-section p {
    font-size: 1.2rem;
}

}

 /* coimbatore-destination-section-end */

</style>

    <!-- coimbatore- Section -->
    <section class="coimbatore-section">
        <h1>Welcome to Coimbatore</h1>
        <p>Explore the beauty of South India's Manchester</p>
    </section>




     <!-- About coimbatore Section  start -->

<section id="about-box">
    <div class="container ads mt-5 g-5 text-center">
        <div class="row">

            <div class="col-md-6">
                <h2>About Coimbatore</h2>
                <p class="ads-p-c mt-3 b-5">Manali, a popular hill station nestled in the mountains of Himachal Pradesh, offers stunning views, adventure activities, and a serene environment. It’s the perfect destination for nature lovers and adventure enthusiasts alike.</p>
       
                <img src="{{ asset('assets/images/about-coimbatore-img.jpg') }}" data-aos="flip-left"
                    width="400px" alt>
            </div>

           
            <div class="col-md-6">
                <iframe class="map"
                      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125322.50873824842!2d76.967235!3d11.013968899999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba859af2f971cb5%3A0x2fc1c81e183ed282!2sCoimbatore%2C%20Tamil%20Nadu!5e0!3m2!1sen!2sin!4v1728229742256!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"> width="600" height="450"
                    width="600" height="450" style="border:0;" allowfullscreen
                    lo ading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

 <!-- About coimbatore Section  end-->




    
<!-- Top Attractions Section -->
<section id="attractions-coimbatore" data-aos="fade-up">

    <div class="container-fluid  coimbatore-destinations mt-5 py-3 px-4 text-center">
          <h2>Top Attractions in coimbatore </h2>
          <div class="row">
  
              <div class="col-md-3 mb-3 mt-2">
                  <img src="{{ asset('assets/images/coimbatore-attraction1-img.jpg') }}" data-aos="fade-up"
                      width="100%" height="250px" alt="">
                      <div class="coimbatore-content border">
                  <h3>Marudhamalai Temple</h3>
                  <p>Situated on a hill, this ancient temple is dedicated to Lord Murugan. The scenic surroundings and peaceful atmosphere make it a must-visit for spiritual seekers and those looking to enjoy stunning hilltop views.</p>
              </div>
              </div>


              <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/coimbatore-attraction2-img.avif') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="coimbatore-content border">
                <h3> Vydehi Falls </h3>
                <p> Located about 35 km from Coimbatore, this picturesque waterfall is a popular spot for nature lovers and trekkers. The surrounding forest area provides a serene environment for picnics and short hikes.
                    .</p>
            </div>
            </div>



            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/coimbatore-attraction3-img.avif') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="coimbatore-content border">
                <h3> Perur Pateeswarar Temple </h3>
                <p>  An architectural marvel, this ancient temple is dedicated to Lord Shiva and showcases intricate carvings and a rich history dating back over 1,500 years. It's one of Coimbatore's most revered religious sites.</p>
            </div>
            </div>



            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/coimbatore-attraction4-img.webp') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="coimbatore-content border">
                <h3> Adiyogi Shiva Statue </h3>
                <p>  The 112-foot-tall Adiyogi statue, is a magnificent sight and has become an iconic symbol of the city. It's a place where visitors can experience peace and spirituality through yoga and meditation sessions.</p>
            </div>
            </div>



            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/coimbatore-attraction5-img.jfif') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="coimbatore-content border">
                <h3> Siruvani Waterfalls </h3>
                <p>   Known for its crystal-clear water, Siruvani Waterfalls is a popular spot for trekking and nature walks. The surrounding dense forest and the scenic beauty of the falls make it an ideal destination for a day trip from Coimbatore.</p>
                </p>
            </div>
            </div>


            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/coimbatore-attraction6-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="coimbatore-content border">
                <h3> Gass Forest Museum  </h3>
                <p> This fascinating museum offers insights into forestry and wildlife. With exhibits ranging from stuffed animals to ancient tree specimens, it’s an informative experience for nature enthusiasts and families.
                </p>
            </div>
            </div>



            
            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/coimbatore-attraction7-img.avif') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="coimbatore-content border">
                <h3> Black Thunder Water Park  </h3>
                <p> Located in Mettupalayam, Black Thunder is a famous amusement park offering thrilling water rides and activities. It’s perfect for a fun family outing or a day of adventure with friends.</p>
                </p>
            </div>
            </div>



            
            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/coimbatore-attraction8-img.webp') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="coimbatore-content border">
                <h3> VOC Park & Zoo </h3>
                <p>  A family-friendly destination, and a variety of animals and birds to explore.  A serene park offering a relaxing environment.
             Great for learning about wildlife and nature conservation.</p>
            </div>
            </div>


            
            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/coimbatore-attraction9-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="coimbatore-content border">
                <h3> TNAU Botanical Garden </h3>
                <p>   Spread over acres of greenery, this botanical garden is managed by Tamil Nadu Agricultural University and is known for its wide variety of plants, trees, and flowers. It's a peaceful place to enjoy nature and relax. </p>
            </div>
            </div>



            <div class="col-md-3 mb-3 mt-2">
                <img src="{{ asset('assets/images/coimbatore-attraction10-img.jpg') }}" data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="coimbatore-content border">
                <h3> Eachanari Vinayagar Temple </h3>
                <p> One of the oldest temples in Coimbatore, and is famous for its large idol of the deity.
                    The temple attracts seeking blessings for success and prosperity.
                </p>
            </div>
        </div>

        <div class="col-md-3 mb-3 mt-2">
            <img src="{{ asset('assets/images/coimbatore-attractioin11-img.jpg') }}" data-aos="fade-up"
                width="100%" height="250px" alt="">
                <div class="coimbatore-content border">
            <h3> Velliangiri Hill Temple </h3>
            <p> Velliangiri hill temple Dedicated to Lord Shiva, ." Seven Hills undertake a challenging trek across seven hills to reach the temple. Natural Beauty Surrounded by lush forests and scenic landscapes.
            </p>
        </div>
    </div>

    <div class="col-md-3 mb-3 mt-2">
        <img src="{{ asset('assets/images/coimbatore-attraction12-img.png') }}" data-aos="fade-up"
            width="100%" height="250px" alt="">
            <div class="coimbatore-content border">
        <h3> Nehru Park </h3>
        <p> Nehru Park in Coimbatore is a well-maintained public park, ideal for relaxation and family outings.  The park is a popular spot for morning walks and fitness activities, offering a peaceful environment in the heart of the city.</p>
    </div>
</div>

              </div>
              </div>
              </section>

 <!-- coimbatore Attractions Section end -->






 <!-- coimbatore  Booking Form Section  start-->
<!--        
 <section id="booking" class="tour-booking-section">
    <div class="container tour-booking-container shadow mt-3">
        <h2 class="text-center mb-4 " style="color: white; padding-top: 30px; font-weight: 700;">Book Yor Coimbatore Tour</h2>
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
              
 <!-- coimbatore booking Form Section end -->








<!-- coimbatore gallery Section  start-->
<!-- 
<section class="py-5"> -->
        <!-- <div class="container coimbatore-gallery">
            <h2 class="text-center mb-1"> Coimbatore Tour Gallery</h2>
            <div class="row">

                <div class="col-md-4 mt-3">
                    <a href="images/coimbatore-gallery1-img.jpg" class="image-link"  title="kovai Kondattam">
                        <img src="images/coimbatore-gallery1-img.jpg" class="w-100" style="height: 250px;" alt="">
                    </a>
                </div>


                <div class="col-md-4 mt-3">
                    <a href="images/coimbatore-gallery2-img.jpg" class="image-link"  title=" Sree Ayyappan Temple">
                        <img src="images/coimbatore-gallery2-img.jpg" class="w-100" style="height: 250px;" alt="">
                    </a>
                </div> -->

                <!-- <div class="col-md-4 mt-3">
                    <a href="images/coimbatore-gallery3-img.jpg" class="image-link"  title="Velliangiri Hill Temple">
                        <img src="images/coimbatore-gallery3-img.jpg" class="w-100" style="height: 250px;" alt="">
                    </a>
                </div>

                <div class="col-md-4 mt-3">
                    <a href="images/coimbatore-gallery4-img.jpg" class="image-link"  title=" Monkey Falls">
                        <img src="images/coimbatore-gallery4-img.jpg" class="w-100" style="height: 250px;" alt="">
                    </a>
                </div>


                
                
                <div class="col-md-4 mt-3">
                    <a href="images/coimbatore-gallery5-img.jpg" class="image-link"  title=" Nilgiri Biosphere Nature Park">
                        <img src="images/coimbatore-gallery5-img.jpg" class="w-100" style="height: 250px;" alt="">
                    </a>
                </div>


                 
                <div class="col-md-4 mt-3">
                    <a href="images/coimbatore-gallery6-img.png" class="image-link"  title=" Kodiveri Dam">
                        <img src="images/coimbatore-gallery6-img.png" class="w-100" style="height: 250px;" alt="">
                    </a>
                </div> -->


<!--                  
                <div class="col-md-4 mt-3">
                    <a href="images/coimbatore-gallery7-img.png" class="image-link"  title=" Siruvani Dam">
                        <img src="images/coimbatore-gallery7-img.png" class="w-100" style="height: 250px;" alt="">
                    </a>
                </div>


                <div class="col-md-4 mt-3">
                    <a href="images/coimbatore-gallery8-img.jpg" class="image-link"  title="Brookefields Mall">
                        <img src="images/coimbatore-gallery8-img.jpg" class="w-100" style="height: 250px;" alt="">
                    </a>
                </div>


                
                <div class="col-md-4 mt-3">
                    <a href="images/coimbatore-gallery9-img.jpg" class="image-link"  title="Gedee Car Museum">
                        <img src="images/coimbatore-gallery9-img.jpg" class="w-100" style="height: 250px;" alt="">
                    </a>
                </div>


                
                <div class="col-md-4 mt-3">
                    <a href="images/coimbatore-gallery10-img.jpg" class="image-link"  title="coimbatore famous food">
                        <img src="images/coimbatore-gallery10-img.jpg" class="w-100" style="height: 250px;" alt="">
                    </a>
                </div>
 -->

<!--                 
                <div class="col-md-4 mt-3">
                    <a href="images/coimbatore-gallery11-img.jpg" class="image-link"  title="food">
                        <img src="images/coimbatore-gallery11-img.jpg" class="w-100" style="height: 250px;" alt="">
                    </a>
                </div>


                <div class="col-md-4 mt-3">
                    <a href="images/coimbatore-gallery12-img.jpg" class="image-link"  title=" Town Hall Market">
                        <img src="images/coimbatore-gallery12-img.jpg" class="w-100" style="height: 250px;" alt="">
                    </a>
                </div>

               </div>
               </div>
        </section> -->



<!-- coimbatore gallery Section  end-->






<!-- Coimbatore tour packages Section  start-->

<section class="bg-light">
  <div class="container my-5">
    <h1 class="text-center mb-5 py-3">Coimbatore Tour Packages</h1>
    <div class="row g-4">
      
      <!-- Tour Package 1 -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="{{ asset('assets/images/t1.jpg') }}" class="card-img-top" alt="Coimbatore Heritage Tour">
          <div class="card-body">
            <h5 class="card-title">Coimbatore Heritage Tour Package</h5>
            <p class="card-text">Explore Red Fort, Qutub Minar, Humayun’s Tomb, and more on this 3-day cultural journey.</p>
            <p><strong>Duration:</strong> 3 Days / 2 Nights</p>
            <p><strong>Price:</strong> ₹7,499 per person</p>
            <!-- <a href="#" class="btn btn-primary">Book Now</a> -->
          </div>
        </div>
      </div>


       <!-- Tour Package 2 -->
       <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="{{ asset('assets/images/t3.jpg') }}" class="card-img-top" alt="Cultural & Shopping Tour">
          <div class="card-body">
            <h5 class="card-title">Coimbatore Cultural & Shopping Tour</h5>
            <p class="card-text">Discover Delhi’s vibrant culture, shop in local markets, and indulge in street food.</p>
            <p><strong>Duration:</strong> 2 Days / 1 Night</p>
            <p><strong>Price:</strong> ₹5,999 per person</p>
            <!-- <a href="#" class="btn btn-primary">Book Now</a> -->
          </div>
        </div>
      </div>
      
      <!-- Tour Package 3 -->
      <!-- <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="tour-image-3.jpg" class="card-img-top" alt="Spiritual Tour">
          <div class="card-body">
            <h5 class="card-title">Coimbatore Spiritual Tour Package</h5>
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
          <img src="{{ asset('assets/images/t2.jpg') }}" class="card-img-top" alt="Adventure Tour">
          <div class="card-body">
            <h5 class="card-title">Coimbatore Adventure & Outdoor Tour</h5>
            <p class="card-text">Experience nature, cycling tours, and hot air balloon rides with this adventurous package.</p>
            <p><strong>Duration:</strong> 3 Days / 2 Nights</p>
            <p><strong>Price:</strong> ₹8,999 per person</p>
            <!-- <a href="#" class="btn btn-primary">Book Now</a> -->
          </div>
        </div>
      </div>

      <!-- Tour Package 5 -->
      <!-- <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="tour-image-5.jpg" class="card-img-top" alt="Express Tour">
          <div class="card-body">
            <h5 class="card-title">Coimbatore in One Day: Express Tour</h5>
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
          <img src="tour-image-6.jpg" class="card-img-top" alt="Custom Tour">
          <div class="card-body">
            <h5 class="card-title">Customize Your Coimbatore Tour</h5>
            <p class="card-text">Create your own personalized itinerary with our fully customizable packages.</p>
            <a href="#" class="btn btn-secondary">Customize Now</a>
          </div>
        </div>
      </div> -->

    </div>
  </div>

</section>

<!-- Coimbatore tour packages Section  end-->
<!-- Travel Information Section start -->
<section id="travel-info text-center" data-aos="zoom-in">
    <div class="container travel-information-container  bg-warning text-center py-4">
        <h2 class="TIH py-2">Travel Information</h2>

        <ul class="travel-info-list mt-3 list-unstyled  px-2"
            style="line-height: 25px; ">
            <li><strong>Best Time to Visit:</strong> September to March is the best time to visit Coimbatore due to its pleasant weather.</li>
                <br>
            <li><strong>How to Get Around:</strong> trains, cabs, buses,
                and auto-rickshaws make it easy to navigate the city.</li>
                <br>
            <li><strong>Nearby Airport:</strong> Coimbatore International Airport connects to major cities in India and abroad.</li>
        </ul>
    </div>

  </section>
<!-- Travel Information Section end -->


@endsection