@extends('frontend.layouts.master')
@section('content')

<style>
  /*mussoorie-destination-section-start */

  .mussoorie-section {
    background-image: linear-gradient(rgba(0, 0, 0, 0.562), rgba(0, 0, 0, 0.468)), url('{{ asset("assets/images/mussoorie-banner.jfif") }}');
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

.mussoorie-section h1 {
    font-size: 3rem;
    font-weight:700;
}

.mussoorie-section p {
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
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.mussoorie-destinations h3{
    margin: 10px 0px;
}

.mussoorie-destinations p{
    padding: 0px 10px;
}
 

@media only screen and (max-width: 600px) {  
 
      .mussoorie-section{
        height: 300px;
      }

      .mussoorie-container img{
      width: 100%;
      height: auto;
      }
      
      .mussoorie-map{
       height: 100%;
       width: 100%;
       margin-top: 20px;
      }

      .mussoorie-attraction-container h2{
        font-size: 19px;
        font-weight: 600;
     }

     .mussoorie-section h1{
        font-size: 2rem;
        
     }

     .mussoorie-section p{
     font-size: 1.2rem;
     padding: 0px 10px;
     }
}

</style>
  
<!-- mussoorie-banner- Section  start-->
    <section class="mussoorie-section">
        <h1>Welcome to Mussoorie</h1>
        <p>Experience the Queen of Hills</p>
    </section>

  <!-- mussoorie-banner- Section  end-->
     <!-- About mussoorie Section  start -->

     <section id="about-box">
    <div class="container-fluid ads mt-5 g-5 text-center">
        <div class="row">

            <div class="col-md-6">
                <h2>About Mussoorie </h2>
     <p class="ads-p-c mt-3 b-5">Mussoorie, known as the "Queen of the Hills," is a charming hill station nestled in the foothills of the Garhwal Himalayas in Uttarakhand. It is one of India's most popular tourist destinations, offering a perfect blend of scenic beauty, pleasant weather, and colonial charm. Situated at an altitude of around 2,000 meters (6,600 feet), Mussoorie provides breathtaking views of the snow-capped Himalayan ranges and the Doon Valley.</P>

                <img src='{{ asset("assets/images/mussoorie-about-img.jpg") }}' data-aos="flip-left"
                    width="400px" alt>
            </div>

           

            <div class="col-md-6">
                <iframe class="map"
                       src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d27514.743485043957!2d78.0764401!3d30.454723299999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3908d0cfa61cda5b%3A0x197fd47d980e85b1!2sMussoorie%2C%20Uttarakhand!5e0!3m2!1sen!2sin!4v1728284771399!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"> width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"> width="600" height="450"
                    width="600" height="450" style="border:0;" allowfullscreen
                    lo ading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>

 <!-- About mussoorie Section  end-->
    
<!-- Top Attractions Section  start-->

<section id="attractions-mussoorie" data-aos="fade-up">

    <div class="container-fluid  mussoorie-destinations mt-5 py-3 px-4 text-center  justify-content-center">
          <h2>Top Attractions in Mussoorie </h2>
          <div class="row">
  
              <div class="col-md-3 mb-3 mt-3">
                  <img src='{{ asset("assets/images/kemptyfalls-img.jfif") }}'data-aos="fade-up"
                      width="100%" height="250px" alt="">
                      <div class="mussoorie-content border">
                  <h3> Kempty Falls</h3>
                  <p>  One of the most famous attractions in Mussoorie, perfect for picnics and swimming. The cool, refreshing water and scenic surroundings make it a must-visit spot for families and tourists.</p>
              </div>
              </div>
              <div class="col-md-3 mb-3 mt-3">
                <img src='{{ asset("assets/images/gun-hill-img.jpg") }}' data-aos="fade-up"
                    width="100%" height="250px" alt="">
                    <div class="mussoorie-content border">
                <h3> Gun Hill </h3>
                <p>   The second-highest peak in Mussoorie, and the snow-capped Himalayas. You can reach the top by taking a cable car ride or through a scenic hike. It's a popular spot for photography and sunset views.</p>
            </div>
            </div>



            
            
            <div class="col-md-3 mb-3 mt-3">
                    <img src='{{ asset("assets/images/mall-road-img.jpg") }}' data-aos="fade-up" width="100%" height="250px" alt="">
                    <div class="mussoorie-content border">
                        <h3>Mall Road</h3>
                        <p >The bustling Mall Road is the heart of Mussoorie’s social scene.  cafes, shops, and restaurants, it’s perfect for shopping, dining, and leisurely strolls. You’ll find local handicrafts, woolens, and souvenirs here.</p>
                    </div>
                </div>



                <div class="col-md-3 mb-3 mt-3">
                    <img src='{{ asset("assets/images/mussoorie-attraction1-img.jpg") }}' data-aos="fade-up" width="100%" height="250px" alt="">
                        <div class="mussoorie-content border">
                            <h3>Lal Tibba</h3>
                            <p>Lal Tibba is the highest point in Mussoorie and  the surrounding mountains, including the Badrinath and Kedarnath peaks on a clear day. It's a peaceful place for nature lovers and photographers.</p>
                        </div>
                    </div>
            


                    
                <div class="col-md-3 mb-3 mt-3">
                    <img src='{{ asset("assets/images/mussoorie-attraction1-img.jpg") }}' data-aos="fade-up" width="100%" height="250px" alt="">
                        <div class="mussoorie-content border">
                            <h3>Lal Tibba</h3>
                            <p>Lal Tibba is the highest point in Mussoorie and offers a breathtaking panoramic view of the surrounding mountains, including the Badrinath and Kedarnath peaks on a clear day. It's a peaceful place for nature lovers and photographers.</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3 mt-3">
                        <img src='{{ asset("assets/images/mussoorie-attraction2-img.cms") }}' data-aos="fade-up" width="100%" height="250px" alt="">
                                <div class="mussoorie-content border">
                                <h3>Camel’s Back Road</h3>
                                <p>This 3 km long stretch is named after the camel-shaped rock formation along the path. Ideal for morning and evening walks, the road offers stunning views of the surrounding mountains and valleys. Horse rides are also available for a unique experience.</p>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3 mt-3">
                            <img src='{{ asset("assets/images/mussoorie-attraction3-img.webp") }}' data-aos="fade-up" width="100%" height="250px" alt="">
                                    <div class="mussoorie-content border">
                                    <h3>Cloud’s End</h3>
                                    <p>Located about 7 km from the main town, Cloud’s End marks the geographical end of Mussoorie.  it’s a peaceful escape for nature lovers. Ideal for short treks and sunset views, Cloud’s End is a must-visit for its serene beauty and tranquil atmosphere..</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3 mt-3">
                                <img src='{{ asset("assets/images/mussoorie-attraction4-img.jpg") }}' data-aos="fade-up" width="100%" height="250px" alt="">
                                    <div class="mussoorie-content border">
                                        <h3>Company Garden</h3>
                                        <p>A beautifully maintained garden with colorful flowers, and a small artificial lake. It’s a great place for families and nature lovers to relax, with boating facilities and a playground for children.
                                            Waterfall small but picturesque waterfall within the park.

                                        </p>
                                    </div>
                                </div>
            
                            <div class="col-md-3 mb-3 mt-3">
                                <img src='{{ asset("assets/images/mussoorie-attraction5-img.jpg") }}' data-aos="fade-up" width="100%" height="250px" alt="">
                                <div class="mussoorie-content border">
                                        <h3>Mussoorie Lake</h3>
                                        <p>A man-made lake located on the Mussoorie-Dehradun road, this small but scenic spot is ideal for boating and picnicking. The lake offers serene views of the surrounding hills and is a popular stop for tourists.</p>
                                    </div>
                                </div>
                    
                                <div class="col-md-3 mb-3 mt-3">
                                    <img src='{{ asset("assets/images/mussoorie-attraction6-img.jpg") }}' data-aos="fade-up" width="100%" height="250px" alt="">
                                            <div class="mussoorie-content border">
                                            <h3>Jharipani Falls</h3>
                                            <p> Located about 9 km from Mussoorie, Jharipani Falls is a quieter and lesser-known waterfall, offering an escape into nature. It’s perfect for trekking enthusiasts and those looking for solitude amidst nature.</p>
                                        </div>
                                    </div>
                 
                                <div class="col-md-3 mb-3 mt-3">
                                    <img src='{{ asset("assets/images/mussoorie-attraction7-img.jpg") }}'data-aos="fade-up" width="100%" height="250px" alt="">
                                            <div class="mussoorie-content border">
                                            <h3>Benog Wildlife Sanctuary</h3>
                                            <p>A haven for nature lovers and bird watchers, the Benog Wildlife Sanctuary is part of the Rajaji National Park. It’s home to a variety of wildlife including leopards, deer, and rare birds, offering a peaceful trek through lush greenery.</p>
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3 mt-3">
                                        <img src='{{ asset("assets/images/mussoorie-attraction13-img.jpg") }}' data-aos="fade-up" width="100%" height="250px" alt="">
                                        <div class="mussoorie-content border">
                                                <h3> Christ Church</h3>
                                                <p>Christ Church in Mussoorie, built in 1836, is one of the oldest churches in the Himalayas. Its  peaceful ambiance make it a significant landmark.  this serene church offers visitors a blend of history.</p>
                                    </div>
                                    </div>
                    
                    
                                    
                                    <div class="col-md-3 mb-3 mt-3">
                                        <img src='{{ asset("assets/images/mussoorie-attraction14-img.jpg") }}' data-aos="fade-up" width="100%" height="250px" alt="">
                                                <div class="mussoorie-content border">
                                                <h3> Soham Heritage Centre</h3>
                                                <p>Soham Heritage Centre in Mussoorie showcases the rich cultural heritage . With traditional artifacts, paintings, and sculptures, it offers a glimpse into the region’s culture, and lifestyle. Mussoorie, this small yet insightful museum is perfect for a quick cultural tour.</p>
                                            </div>
                                        </div>
                            

                                        <div class="col-md-3 mb-3 mt-3">
                                            <img src='{{ asset("assets/images/mussoorie-attraction15-img.jpg") }}' data-aos="fade-up" width="100%" height="250px" alt="">
                                                    <div class="mussoorie-content border">
                                                    <h3> Landour </h3>
                                                 <p> Colonial CharmFamous for its British-era architecture and serene atmosphere.Landour is ideal for travelers seeking tranquility and natural beauty near Mussoorie. Notable Landmarks Includes Char Dukan, St. Paul’s Church, and Ivy Cottage.
                                                    </p>
                                                </div>
                                            </div>
                                

                                            <div class="col-md-3 mb-3 mt-3">
                                                <img src='{{ asset("assets/images/mussoorie-attraction16.jpg") }}' data-aos="fade-up" width="100%" height="250px" alt="">
                                                        <div class="mussoorie-content border">
                                                        <h3> Jwala Devi Temple </h3>
                                                        <p> Jwala Devi Temple, located atop Benog Hill in Mussoorie, is dedicated to Goddess Durga.
                                                            The temple is a must-visit for spiritual seekers and nature lovers touring Mussoorie.
                                                          Spiritual Significance A revered site for devotees of Goddess Durga.  </p>
                                                    </div>
                                                </div>
                                
                                                
                                                <div class="col-md-3 mb-3 mt-3">
                                                    <img src='{{ asset("assets/images/mussoorie-attraction17-img.jpg") }}' data-aos="fade-up" width="100%" height="250px" alt="">
                                                            <div class="mussoorie-content border">
                                                            <h3> Nag Devta Temple </h3>
                                                            <p>  Nag Devta Temple is a revered shrine dedicated to the Snake God (Nag Devta) in Mussoorie. Spiritual Significance Worshipped by locals for protection and prosperity.
                                                                The temple is a peaceful spot for spiritual seekers. and surrounding landscape.
                                                            </p>
                                                        </div>
                                                    </div>
                                        

              </div>
              </div>
              </section>
<!-- mussoorie tour packages Section  start-->

<section class="bg-light">
  <div class="container my-5">
    <h1 class="text-center mb-5 py-3">Mussoorie Tour Packages</h1>
    <div class="row g-4">
      
      <!-- Tour Package 1 -->
      <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src='{{ asset("assets/images/tour1.jpg") }}' class="card-img-top" alt="Mussoorie Heritage Tour">
          <div class="card-body">
            <h5 class="card-title">Mussoorie Heritage Tour Package</h5>
            <p class="card-text"> Discover landmarks like Lal Tibba and Kellogg Church, showcasing colonial charm.</p>
            <p><strong>Duration:</strong> 3 Days / 2 Nights</p>
            <p><strong>Price:</strong> ₹5,000 per person</p>
            <!-- <a href="#" class="btn btn-primary">Book Now</a> -->
          </div>
        </div>
      </div>


       <!-- Tour Package 2 -->
       <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src='{{ asset("assets/images/tour2.jpg") }}' class="card-img-top" alt="Cultural & Shopping Tour">
          <div class="card-body">
            <h5 class="card-title">Mussoorie Cultural & Shopping Tour</h5>
            <p class="card-text">Discover Mussoorie vibrant culture, shop in local markets, and indulge in street food.</p>
            <p><strong>Duration:</strong> 2 Days / 1 Night</p>
            <p><strong>Price:</strong> ₹5,999 per person</p>
            <!-- <a href="#" class="btn btn-primary">Book Now</a> -->
          </div>
        </div>
      </div>
      
      <!-- Tour Package 3 -->
      <!-- <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src='{{ asset("assets/images/tour.jpg") }}' class="card-img-top" alt="Spiritual Tour">
          <div class="card-body">
            <h5 class="card-title"> Mussoorie Spiritual Tour Package</h5>
            <p class="card-text">
Find peace at serene spots like Jwala Devi Temple and Shedup Choepelling Tibetan Temple.</p>
            <p><strong>Duration:</strong> 2 Days / 1 Night</p>
            <p><strong>Price:</strong> ₹4,500 per person</p>
            <a href="#" class="btn btn-primary">Book Now</a>
          </div>
        </div>
      </div> -->



      
       <!-- Tour Package 4 -->
       <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src='{{ asset("assets/images/tour3.jpg") }}' class="card-img-top" alt="Adventure Tour">
          <div class="card-body">
            <h5 class="card-title"> Mussoorie Adventure & Outdoor Tour</h5>
            <p class="card-text">
Experience thrilling activities like trekking to George Everest, paragliding, and exploring the Kempty Falls.</p>
            <p><strong>Duration:</strong> 3 Days / 2 Nights</p>
            <p><strong>Price:</strong> ₹6,000 per person</p>
            <!-- <a href="#" class="btn btn-primary">Book Now</a> -->
          </div>
        </div>
      </div>

      <!-- Tour Package 5 -->
      <!-- <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="tour-image-5.jpg" class="card-img-top" alt="Express Tour">
          <div class="card-body">
            <h5 class="card-title"> Mussoorie in One Day: Express Tour</h5>
            <p class="card-text">Visit top spots like Kempty Falls, Gun Hill, and Mall Road in just one day.</p>
            <p><strong>Duration:</strong> 1 Day</p>
            <p><strong>Price:</strong> ₹3,000 per person</p>
            <a href="#" class="btn btn-primary">Book Now</a>
          </div>
        </div>
      </div> -->



      
       <!-- Custom Tour -->
       <!-- <div class="col-md-6 col-lg-4">
        <div class="card h-100">
          <img src="tour-image-6.jpg" class="card-img-top" alt="Custom Tour">
          <div class="card-body">
            <h5 class="card-title">Customize Your  Mussoorie Tour</h5>
            <p class="card-text">Create your own personalized itinerary with our fully customizable packages.</p>
            <a href="#" class="btn btn-secondary">Customize Now</a>
          </div>
        </div>
      </div> -->

    </div>
  </div>

</section>



<!-- mussoorie tour packages Section  end-->




   <!-- Travel Information Section start -->
<section id="travel-info" data-aos="zoom-in">
    <div class="container travel-information-container bg-warning text-center mt-4  py-4">
        <h2 class="TIH py-3 text-center">Travel Information</h2>
  
        <ul class="travel-info-list mt-2 list-unstyled  px-2"
            style="line-height: 25px; ">
            <li><strong>Best Time to Visit:</strong> March to June and September to November are ideal times to visit Mussoorie.</li>
                <br>
            <li><strong>How to Get Around:</strong>  cabs, buses, trains
                and auto-rickshaws make it easy to navigate the city.</li>
                <br>
            <li><strong>Nearby Airport:</strong> Nearest airport is Jolly Grant Airport (Dehradun), 60 km away. </li>
        </ul>
    </div>
  
  </section>
  
  <!-- Travel Information Section end-->

@endsection