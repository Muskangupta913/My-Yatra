@extends('frontend.layouts.master')

@section('styles')
<style>
  /* Hero Section Styles */
  .wildlife-hero {
    position: relative;
    height: 80vh;
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/images/tiger.jpg') no-repeat center center;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-align: center;
  }
  
  .wildlife-hero h1 {
    font-size: 4rem;
    font-weight: 800;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
    animation: fadeIn 1.5s ease-in-out;
  }
  
  .wildlife-hero p {
    font-size: 1.5rem;
    max-width: 800px;
    margin: 0 auto;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
    animation: slideUp 1.5s ease-in-out;
  }
  
  /* Section Styles */
  .section-heading {
    position: relative;
    margin-bottom: 3rem;
    padding-bottom: 1rem;
    text-align: center;
    color: #2e7d32;
  }
  
  .section-heading:after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: linear-gradient(to right, #f9a825, #2e7d32);
  }
  
  /* Safari Card Styles */
  .safari-card {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    margin-bottom: 30px;
    background: #fff;
  }
  
  .safari-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
  }
  
  .safari-card .card-img {
    height: 250px;
    overflow: hidden;
  }
  
  .safari-card .card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }
  
  .safari-card:hover .card-img img {
    transform: scale(1.1);
  }
  
  .safari-card .card-body {
    padding: 1.5rem;
  }
  
  .safari-card .card-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: #2e7d32;
  }
  
  .safari-card .card-text {
    color: #666;
    margin-bottom: 1rem;
  }
  
  .safari-badge {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
  }
  
  .badge-wildlife {
    background-color: #e3f2fd;
    color: #1976d2;
  }
  
  .badge-season {
    background-color: #f9fbe7;
    color: #827717;
  }
  
  .badge-difficulty {
    background-color: #ffebee;
    color: #c62828;
  }
  
  /* Stats Section */
  .wildlife-stats {
    background: linear-gradient(to right, #2e7d32, #1b5e20);
    color: #fff;
    padding: 5rem 0;
  }
  
  .stat-item {
    text-align: center;
    padding: 2rem;
  }
  
  .stat-number {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 1rem;
    display: block;
  }
  
  .stat-text {
    font-size: 1.2rem;
    text-transform: uppercase;
    letter-spacing: 2px;
  }
  
  /* Wildlife Gallery */
  .wildlife-gallery {
    padding: 5rem 0;
    background-color: #f5f5f5;
  }
  
  .gallery-item {
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    height: 300px;
  }
  
  .gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.5s ease;
  }
  
  .gallery-item:hover img {
    transform: scale(1.1);
  }
  
  .gallery-caption {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    color: #fff;
    padding: 15px;
    opacity: 0;
    transition: all 0.3s ease;
  }
  
  .gallery-item:hover .gallery-caption {
    opacity: 1;
  }
  
  /* Testimonials */
  .testimonial-section {
    background: url('/images/wildlife/testimonial-bg.jpg') no-repeat center center;
    background-size: cover;
    padding: 5rem 0;
    position: relative;
  }
  
  .testimonial-section:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
  }
  
  .testimonial-card {
    background: rgba(255,255,255,0.9);
    border-radius: 10px;
    padding: 2rem;
    margin-bottom: 2rem;
    position: relative;
  }
  
  .testimonial-text {
    font-style: italic;
    margin-bottom: 1.5rem;
  }
  
  .testimonial-author {
    display: flex;
    align-items: center;
  }
  
  .testimonial-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 15px;
  }
  
  .testimonial-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  .testimonial-info h5 {
    margin-bottom: 0.2rem;
    color: #2e7d32;
  }
  
  .testimonial-info p {
    margin: 0;
    color: #666;
    font-size: 0.9rem;
  }
  
  /* Animations */
  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }
  
  @keyframes slideUp {
    from { 
      opacity: 0;
      transform: translateY(30px);
    }
    to { 
      opacity: 1;
      transform: translateY(0);
    }
  }
  
  .animated-item {
    opacity: 0;
    transform: translateY(30px);
    transition: all 1s ease;
  }
  
  .animated-item.active {
    opacity: 1;
    transform: translateY(0);
  }
  
  /* Wildlife Icons */
  .wildlife-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(46, 125, 50, 0.1);
    border-radius: 50%;
    color: #2e7d32;
    font-size: 2rem;
    transition: all 0.3s ease;
  }
  
  .wildlife-feature:hover .wildlife-icon {
    background: #2e7d32;
    color: #fff;
    transform: rotateY(180deg);
  }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="wildlife-hero">
  <div class="container">
    <h1>The Best Wildlife Safaris in India</h1>
    <p>Discover the untamed beauty of India's diverse ecosystems and encounter magnificent creatures in their natural habitat</p>
  </div>
</section>

<!-- Introduction Section -->
<section class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 mx-auto text-center animated-item">
        <h2 class="section-heading">Experience India's Wild Side</h2>
        <p class="lead mb-4">India is home to some of the world's most diverse wildlife and stunning natural landscapes. From the majestic Bengal tigers to the elusive snow leopards, from dense tropical forests to sprawling grasslands, the country offers unparalleled safari experiences for nature enthusiasts and wildlife photographers alike.</p>
        <p>With over 100 national parks and 550 wildlife sanctuaries spread across different geographical zones, India provides a haven for numerous endangered species and offers visitors the chance to witness these magnificent creatures in their natural habitats.</p>
      </div>
    </div>
    
    <!-- Wildlife Features -->
    <div class="row mt-5">
      <div class="col-md-4 text-center animated-item">
        <div class="wildlife-feature mb-4">
          <div class="wildlife-icon">
            <i class="fas fa-paw"></i>
          </div>
          <h3>Diverse Wildlife</h3>
          <p>Home to over 500 mammal species, 2000+ bird species, and countless reptiles</p>
        </div>
      </div>
      <div class="col-md-4 text-center animated-item">
        <div class="wildlife-feature mb-4">
          <div class="wildlife-icon">
            <i class="fas fa-tree"></i>
          </div>
          <h3>Varied Ecosystems</h3>
          <p>From Himalayan highlands to Western Ghats, desert to mangrove forests</p>
        </div>
      </div>
      <div class="col-md-4 text-center animated-item">
        <div class="wildlife-feature mb-4">
          <div class="wildlife-icon">
            <i class="fas fa-camera"></i>
          </div>
          <h3>Photography Paradise</h3>
          <p>Perfect lighting, stunning backdrops, and incredible wildlife moments</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Top Safari Destinations -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="section-heading">Top Wildlife Safari Destinations</h2>
    
    <div class="row">
      <!-- Jim Corbett National Park -->
      <div class="col-lg-4 col-md-6 animated-item">
        <div class="safari-card">
          <div class="card-img">
            <img src="assets/images/Corbet.jpg" alt="Jim Corbett National Park">
          </div>
          <div class="card-body">
            <span class="safari-badge badge-wildlife">Tigers</span>
            <span class="safari-badge badge-season">Nov-Jun</span>
            <span class="safari-badge badge-difficulty">Moderate</span>
            <h3 class="card-title">Jim Corbett National Park</h3>
            <p class="card-text">India's oldest national park offers a breathtaking landscape of hills, riverine belts, grasslands and a large lake. It's home to over 600 species of birds and animals including tigers, elephants, and deer.</p>
            <!-- <a href="#" class="btn btn-sm btn-outline-success">Explore More</a> -->
          </div>
        </div>
      </div>
      
      <!-- Ranthambore National Park -->
      <div class="col-lg-4 col-md-6 animated-item">
        <div class="safari-card">
          <div class="card-img">
            <img src="assets/images/Rantham.jpg" alt="Ranthambore National Park">
          </div>
          <div class="card-body">
            <span class="safari-badge badge-wildlife">Tigers</span>
            <span class="safari-badge badge-season">Oct-Jun</span>
            <span class="safari-badge badge-difficulty">Easy</span>
            <h3 class="card-title">Ranthambore National Park</h3>
            <p class="card-text">Famous for its Bengal tigers, this park is set against the backdrop of the Aravalli and Vindhya ranges. The dramatic ruins of a 10th-century fort add to the park's mystique.</p>
            <!-- <a href="#" class="btn btn-sm btn-outline-success">Explore More</a> -->
          </div>
        </div>
      </div>
      
      <!-- Kaziranga National Park -->
      <div class="col-lg-4 col-md-6 animated-item">
        <div class="safari-card">
          <div class="card-img">
            <img src="assets/images/kaziranga.jpg" alt="Kaziranga National Park">
          </div>
          <div class="card-body">
            <span class="safari-badge badge-wildlife">Rhinos</span>
            <span class="safari-badge badge-season">Nov-Apr</span>
            <span class="safari-badge badge-difficulty">Moderate</span>
            <h3 class="card-title">Kaziranga National Park</h3>
            <p class="card-text">Home to two-thirds of the world's one-horned rhinoceros population, Kaziranga also shelters tigers, elephants, wild water buffalo, and thousands of birds.</p>
            <!-- <a href="#" class="btn btn-sm btn-outline-success">Explore More</a> -->
          </div>
        </div>
      </div>
      
      <!-- Gir National Park -->
      <div class="col-lg-4 col-md-6 animated-item">
        <div class="safari-card">
          <div class="card-img">
            <img src="assets/images//gir.jpg" alt="Gir National Park">
          </div>
          <div class="card-body">
            <span class="safari-badge badge-wildlife">Lions</span>
            <span class="safari-badge badge-season">Dec-Apr</span>
            <span class="safari-badge badge-difficulty">Moderate</span>
            <h3 class="card-title">Gir National Park</h3>
            <p class="card-text">The last refuge of the Asiatic Lion, Gir's diverse ecosystem supports over 500 lions, leopards, hyenas, crocodiles, and a wide variety of bird species.</p>
            <!-- <a href="#" class="btn btn-sm btn-outline-success">Explore More</a> -->
          </div>
        </div>
      </div>
      
      <!-- Bandhavgarh National Park -->
      <div class="col-lg-4 col-md-6 animated-item">
        <div class="safari-card">
          <div class="card-img">
            <img src="assets/images/Bandavgarh.webp" alt="Bandhavgarh National Park">
          </div>
          <div class="card-body">
            <span class="safari-badge badge-wildlife">Tigers</span>
            <span class="safari-badge badge-season">Oct-Jun</span>
            <span class="safari-badge badge-difficulty">Easy</span>
            <h3 class="card-title">Bandhavgarh National Park</h3>
            <p class="card-text">Known for having one of the highest densities of Bengal tigers in the world, this park offers excellent sighting opportunities amidst beautiful forests and ancient ruins.</p>
            <!-- <a href="#" class="btn btn-sm btn-outline-success">Explore More</a> -->
          </div>
        </div>
      </div>
      
      <!-- Sundarbans National Park -->
      <div class="col-lg-4 col-md-6 animated-item">
        <div class="safari-card">
          <div class="card-img">
            <img src="assets/images/sundarbans.jpg" alt="Sundarbans National Park">
          </div>
          <div class="card-body">
            <span class="safari-badge badge-wildlife">Tigers</span>
            <span class="safari-badge badge-season">Sep-Mar</span>
            <span class="safari-badge badge-difficulty">Challenging</span>
            <h3 class="card-title">Sundarbans National Park</h3>
            <p class="card-text">The world's largest mangrove forest and a UNESCO World Heritage site, Sundarbans is home to the unique swimming tigers and numerous other species adapted to this tidal ecosystem.</p>
            <!-- <a href="#" class="btn btn-sm btn-outline-success">Explore More</a> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Wildlife Stats Section -->
<section class="wildlife-stats">
  <div class="container">
    <div class="row">
      <div class="col-md-3 animated-item">
        <div class="stat-item">
          <span class="stat-number">104</span>
          <span class="stat-text">National Parks</span>
        </div>
      </div>
      <div class="col-md-3 animated-item">
        <div class="stat-item">
          <span class="stat-number">2967</span>
          <span class="stat-text">Bengal Tigers</span>
        </div>
      </div>
      <div class="col-md-3 animated-item">
        <div class="stat-item">
          <span class="stat-number">3500+</span>
          <span class="stat-text">Elephant Count</span>
        </div>
      </div>
      <div class="col-md-3 animated-item">
        <div class="stat-item">
          <span class="stat-number">1340</span>
          <span class="stat-text">Bird Species</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- When to Visit Section -->
<section class="py-5">
  <div class="container">
    <h2 class="section-heading">When to Visit</h2>
    
    <div class="row">
      <div class="col-lg-6 animated-item">
        <div class="card mb-4">
          <div class="card-body">
            <h3 class="h4 mb-3 text-success"><i class="fas fa-calendar-alt mr-2"></i> Best Seasons for Wildlife Safari</h3>
            <p>Most wildlife sanctuaries and national parks in India are open from October to June, with specific seasons varying based on the region:</p>
            <ul class="list-unstyled">
              <li class="mb-2"><strong class="text-primary">Winter (November-February):</strong> Ideal for most parks with pleasant temperatures and high animal visibility</li>
              <li class="mb-2"><strong class="text-primary">Summer (March-June):</strong> Excellent for tiger sightings as animals gather around water sources</li>
              <li class="mb-2"><strong class="text-primary">Monsoon (July-September):</strong> Many parks close during this period due to heavy rainfall</li>
            </ul>
          </div>
        </div>
      </div>
      
      <div class="col-lg-6 animated-item">
        <div class="card">
          <div class="card-body">
            <h3 class="h4 mb-3 text-success"><i class="fas fa-clock mr-2"></i> Safari Timing</h3>
            <p>Most parks offer two safari sessions daily:</p>
            <ul class="list-unstyled">
              <li class="mb-2"><strong class="text-primary">Morning Safari:</strong> Usually starts at sunrise (5:30-6:30 AM) and lasts for 3-4 hours</li>
              <li class="mb-2"><strong class="text-primary">Evening Safari:</strong> Typically begins around 3:00-4:00 PM and continues until sunset</li>
              <li class="mb-2"><strong class="text-primary">Permits:</strong> Advance booking recommended, especially during peak season</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Safari Types Section -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="section-heading">Safari Experiences</h2>
    
    <div class="row">
      <div class="col-lg-3 col-md-6 animated-item">
        <div class="card mb-4">
          <img src="assets/images/Jeep.jpg" class="card-img-top" alt="Jeep Safari"style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <div class="wildlife-icon">
              <i class="fas fa-car"></i>
            </div>
            <h3 class="h4 mb-3">Jeep Safari</h3>
            <p>The most popular option offering mobility and guidance from experienced naturalists.</p>
          </div>
        </div>
      </div>
      
      <div class="col-lg-3 col-md-6 animated-item">
        <div class="card mb-4">
          <img src="assets/images/Elephant.webp" class="card-img-top" alt="Elephant Safari"style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <div class="wildlife-icon">
            <i class="fas fa-paw"></i>
            </div>
            <h3 class="h4 mb-3">Elephant Safari</h3>
            <p>Traditional way to explore dense forests, especially in parks like Kaziranga and Corbett.</p>
          </div>
        </div>
      </div>
      
      <div class="col-lg-3 col-md-6 animated-item">
        <div class="card mb-4">
          <img src="assets/images/Boat.webp" class="card-img-top" alt="Boat Safari"style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <div class="wildlife-icon">
              <i class="fas fa-ship"></i>
            </div>
            <h3 class="h4 mb-3">Boat Safari</h3>
            <p>Unique feel in places like Sundarbans or along the river sections of national parks.</p>
          </div>
        </div>
      </div>
      
      <div class="col-lg-3 col-md-6 animated-item">
        <div class="card mb-4">
          <img src="assets/images/walking.jpg" class="card-img-top" alt="Walking Safari"style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <div class="wildlife-icon">
              <i class="fas fa-hiking"></i>
            </div>
            <h3 class="h4 mb-3">Walking Safari</h3>
            <p>Guided walking trails for a more immersive and intimate wildlife experience.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Wildlife Gallery -->
<section class="wildlife-gallery">
  <div class="container">
    <h2 class="section-heading">Wildlife Gallery</h2>
    
    <div class="row">
      <div class="col-lg-4 col-md-6 animated-item">
        <div class="gallery-item">
          <img src="assets/images/Bengal.jpg" alt="Bengal Tiger">
          <div class="gallery-caption">
            <h4>Bengal Tiger</h4>
            <p>The national animal of India</p>
          </div>
        </div>
      </div>
      
      <div class="col-lg-4 col-md-6 animated-item">
        <div class="gallery-item">
          <img src="assets/images/elephants.jpg" alt="Indian Elephant">
          <div class="gallery-caption">
            <h4>Indian Elephant</h4>
            <p>Majestic gentle giants of the forest</p>
          </div>
        </div>
      </div>
      
      <div class="col-lg-4 col-md-6 animated-item">
        <div class="gallery-item">
          <img src="assets/images/rhino.jpg" alt="One-horned Rhinoceros">
          <div class="gallery-caption">
            <h4>One-horned Rhinoceros</h4>
            <p>Pride of Kaziranga National Park</p>
          </div>
        </div>
      </div>
      
      <div class="col-lg-4 col-md-6 animated-item">
        <div class="gallery-item">
          <img src="assets/images/lion.jpg" alt="Asiatic Lion">
          <div class="gallery-caption">
            <h4>Asiatic Lion</h4>
            <p>The pride of Gir Forest</p>
          </div>
        </div>
      </div>
      
      <div class="col-lg-4 col-md-6 animated-item">
        <div class="gallery-item">
          <img src="assets/images/peacock.jpeg" alt="Indian Peacock">
          <div class="gallery-caption">
            <h4>Indian Peacock</h4>
            <p>National bird in all its glory</p>
          </div>
        </div>
      </div>
      
      <div class="col-lg-4 col-md-6 animated-item">
        <div class="gallery-item">
          <img src="assets/images/leopard.jpg" alt="Indian Leopard">
          <div class="gallery-caption">
            <h4>Indian Leopard</h4>
            <p>Master of camouflage and stealth</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Tips Section -->
<section class="py-5">
  <div class="container">
    <h2 class="section-heading">Safari Tips & Essentials</h2>
    
    <div class="row">
      <div class="col-lg-6 animated-item">
        <div class="card mb-4">
          <div class="card-body">
            <h3 class="h4 mb-3 text-success"><i class="fas fa-list-check mr-2"></i> What to Pack</h3>
            <ul>
              <li>Neutral-colored clothing (avoid bright colors and strong perfumes)</li>
              <li>Comfortable walking shoes/boots</li>
              <li>Hat, sunglasses, and sunscreen</li>
              <li>Binoculars and camera with zoom lens</li>
              <li>Water bottle and light snacks</li>
              <li>Light jacket or sweater (for early morning safaris)</li>
              <li>Insect repellent</li>
              <li>First-aid kit with essential medications</li>
            </ul>
          </div>
        </div>
      </div>
      
      <div class="col-lg-6 animated-item">
        <div class="card">
          <div class="card-body">
            <h3 class="h4 mb-3 text-success"><i class="fas fa-lightbulb mr-2"></i> Safari Etiquette</h3>
            <ul>
              <li>Maintain silence during safari to avoid disturbing animals</li>
              <li>Never feed or attempt to attract wildlife</li>
              <li>Follow your guide's instructions at all times</li>
              <li>Stay inside the vehicle unless otherwise instructed</li>
              <li>Respect park rules and regulations</li>
              <li>Don't litter - carry all trash with you</li>
              <li>Keep a safe distance from wildlife</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Conservation Section -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="section-heading">Conservation Efforts</h2>
    
    <div class="row align-items-center">
      <div class="col-lg-6 animated-item">
        <img src="assets/images/wildlife.jpeg" alt="Wildlife Conservation" class="img-fluid rounded shadow-lg">
      </div>
      
      <div class="col-lg-6 animated-item">
        <h3 class="mb-4 text-success">Protecting India's Wildlife Heritage</h3>
        <p>India has implemented several successful conservation programs to protect its rich biodiversity:</p>
        <div class="d-flex mb-3">
          <div class="mr-3 text-success"><i class="fas fa-shield-alt fa-2x"></i></div>
          <div>
            <h4 class="h5">Project Tiger</h4>
            <p>Launched in 1973, this initiative has helped increase the tiger population from 1,200 to nearly 3,000.</p>
          </div>
        </div>
        <div class="d-flex mb-3">
          <div class="mr-3 text-success"><i class="fas fa-paw fa-2x"></i></div>
          <div>
            <h4 class="h5">Indian Rhino Vision 2020</h4>
            <p>A successful program that aimed to increase the rhino population to 3,000 by 2020.</p>
          </div>
        </div>
        <div class="d-flex mb-3">
          <div class="mr-3 text-success"><i class="fas fa-leaf fa-2x"></i></div>
          <div>
            <h4 class="h5">Conservation Reserves</h4>
            <p>Establishing protected corridors between national parks to allow wildlife movement.</p>
          </div>
        </div>
        <div class="d-flex">
          <div class="mr-3 text-success"><i class="fas fa-users fa-2x"></i></div>
          <div>
            <h4 class="h5">Community Involvement</h4>
            <p>Engaging local communities in conservation efforts through education and sustainable tourism.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- FAQ Section -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="section-heading">Frequently Asked Questions</h2>
    
    <div class="row">
      <div class="col-lg-6 animated-item">
        <div class="accordion" id="faqAccordion1">
          <div class="card mb-3">
            <div class="card-header bg-white" id="faqHeading1">
              <h3 class="h5 mb-0">
                <button class="btn btn-link text-success collapsed" type="button" data-toggle="collapse" data-target="#faqCollapse1" aria-expanded="false">
                  What is the best time to see tigers in India?
                </button>
              </h3>
            </div>
            <div id="faqCollapse1" class="collapse" aria-labelledby="faqHeading1" data-parent="#faqAccordion1">
              <div class="card-body">
                The summer months (March to June) offer the best tiger sightings as animals gather around water sources. However, many parks are open from October to June, with different regions having specific optimal periods.
              </div>
            </div>
          </div>
          
          <div class="card mb-3">
            <div class="card-header bg-white" id="faqHeading2">
              <h3 class="h5 mb-0">
                <button class="btn btn-link text-success collapsed" type="button" data-toggle="collapse" data-target="#faqCollapse2" aria-expanded="false">
                  How far in advance should I book a wildlife safari?
                </button>
              </h3>
            </div>
            <div id="faqCollapse2" class="collapse" aria-labelledby="faqHeading2" data-parent="#faqAccordion1">
              <div class="card-body">
                For popular parks like Ranthambore and Jim Corbett, it's advisable to book at least 3-4 months in advance, especially during peak season (October-March). Less frequented parks may allow bookings 1-2 months in advance.
              </div>
            </div>
          </div>
          
          <div class="card mb-3">
            <div class="card-header bg-white" id="faqHeading3">
              <h3 class="h5 mb-0">
                <button class="btn btn-link text-success collapsed" type="button" data-toggle="collapse" data-target="#faqCollapse3" aria-expanded="false">
                  Are wildlife safaris safe for children?
                </button>
              </h3>
            </div>
            <div id="faqCollapse3" class="collapse" aria-labelledby="faqHeading3" data-parent="#faqAccordion1">
              <div class="card-body">
                Yes, wildlife safaris are generally safe for children. However, some parks have age restrictions for certain activities. It's advisable to check with the specific park beforehand and ensure children follow safety guidelines during the safari.
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-6 animated-item">
        <div class="accordion" id="faqAccordion2">
          <div class="card mb-3">
            <div class="card-header bg-white" id="faqHeading4">
              <h3 class="h5 mb-0">
                <button class="btn btn-link text-success collapsed" type="button" data-toggle="collapse" data-target="#faqCollapse4" aria-expanded="false">
                  Which park has the highest tiger sighting probability?
                </button>
              </h3>
            </div>
            <div id="faqCollapse4" class="collapse" aria-labelledby="faqHeading4" data-parent="#faqAccordion2">
              <div class="card-body">
                Bandhavgarh National Park in Madhya Pradesh has one of the highest tiger densities and consequently the best chances of tiger sightings, followed closely by Ranthambore, Kanha, and Tadoba.
              </div>
            </div>
          </div>
          
          <div class="card mb-3">
            <div class="card-header bg-white" id="faqHeading5">
              <h3 class="h5 mb-0">
                <button class="btn btn-link text-success collapsed" type="button" data-toggle="collapse" data-target="#faqCollapse5" aria-expanded="false">
                  What camera equipment is recommended for wildlife photography?
                </button>
              </h3>
            </div>
            <div id="faqCollapse5" class="collapse" aria-labelledby="faqHeading5" data-parent="#faqAccordion2">
              <div class="card-body">
                A DSLR or mirrorless camera with a telephoto lens (at least 300mm, preferably 400-600mm) is ideal for wildlife photography. Also bring spare batteries, memory cards, a sturdy tripod or monopod, and rain protection for your gear.
              </div>
            </div>
          </div>
          
          <div class="card mb-3">
            <div class="card-header bg-white" id="faqHeading6">
              <h3 class="h5 mb-0">
                <button class="btn btn-link text-success collapsed" type="button" data-toggle="collapse" data-target="#faqCollapse6" aria-expanded="false">
                  Are there any special permits required for wildlife safaris?
                </button>
              </h3>
            </div>
            <div id="faqCollapse6" class="collapse" aria-labelledby="faqHeading6" data-parent="#faqAccordion2">
              <div class="card-body">
                Yes, most national parks require entry permits that can be booked online through the respective state forest department websites or through authorized tour operators. For foreign nationals, carrying a valid passport is necessary while visiting the parks.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- JavaScript for animations -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    
    // Intersection Observer for animation
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('active');
        }
      });
    }, {
      threshold: 0.1
    });
    
    // Observe all animated items
    document.querySelectorAll('.animated-item').forEach(item => {
      observer.observe(item);
    });
  });
  
</script>
@endsection