@extends('frontend.layouts.master')
@section('content')

<style>
    .hidden { display: none; }
</style>

<div class="container-fluid mt-3 gx-5">
    <div class="row">
        <!-- Left Sidebar -->
        <div class="col-lg-3 col-md-3 mb-4">
            <div class="sidebar">
                <h4 class="text-black">Filter Cars</h4>

                <!-- Price Section -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Price</h5>
                        <button class="btn btn-link text-white p-0 toggle-icon" type="button" aria-expanded="true">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="FilterPrice">
                        <div class="card-body">
                            <label class="form-label">Select Price:</label>
                            <div class="list-group">
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="price" value="below-10000">
                                    Below 300
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="price" value="10000-20000">
                                    ₹300 - ₹500
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="price" value="20000-35000">
                                    ₹500 - ₹1000
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="price" value="above-35000">
                                    Above ₹1000
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Name Section -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Company Name</h5>
                        <button class="btn btn-link text-white p-0 toggle-icon" type="button" aria-expanded="true">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="FilterCompany">
                        <div class="card-body">
                            <label class="form-label">Select Company Name:</label>
                            <div class="list-group">
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="company" value="ihcl">
                                    Maruti Suzuki
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="company" value="rosetum">
                                    Tata Motors
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="company" value="oberoi">
                                    Mahindra
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Section -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Category</h5>
                        <button class="btn btn-link text-white p-0 toggle-icon" type="button" aria-expanded="true">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="FilterReview">
                        <div class="card-body">
                            <label class="form-label">Select Category :</label>
                            <div class="list-group">
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="review" value="5-star">
                                AC
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="review" value="4-star">
                                    NON AC
                                </label>
                                <label class="list-group-item">
                                    <input class="form-check-input filter-checkbox" type="checkbox" data-filter="review" value="3-star">
                                    Luxury
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>




        <!-- Main Content Section -->
        <div class="col-lg-9 col-md-9 text-center mt-5">
            <div id="hotelList">
                <div class="hotel-item" data-price="below-10000" data-company="ihcl" data-review="5-star">
<!-- 
                 <h5>Rosetum Anjuna Hotel</h5>
                    <p>Price: ₹8,000 | Company: IHCL | Review: 5 Star</p> -->
                    <div class="card">
                <div class="card-body" style="background-color: floralwhite;">

                    <div class="col-md-2 col-sm-6 mb-4">
                        <label for="from" class="form-label"><b>Comapny</b></label>
                        <input type="text" class="form-control bg-warning" id="from" placeholder="Comapny Name">
                    </div>

                    <div class="row">
                         <!--  First Column: Static Image -->
                      <div class="col-md-7">
                              <!--  main Image -->
                           
                                <img src="./images/cars.img" style="height: 400px !important;" class="object-fit-cover img-fluid rounded" 
                                data-bs-toggle="modal" data-bs-target="#imageModal1" width="100%" alt="Static Image">

                                <!-- Button on Image -->
                                <a href="#" class="btn btn-info shadow fw-bold" style="transform: translateY(-60px);"
                                   data-bs-toggle="modal" data-bs-target="#imageModal1"> 
                                    See More photos/video <Potos>
                                     <i class="bi bi-arrow-right ms-2"></i>
                                </a>
                        
                                <h3 class="hotelname fs-4" style="margin-top: -20px;">cars</h3>
                                <p>Mapusa Road, Goa</p>
                            </div>
                
                          

  <!-- Second Column: Slider with Hidden Images -->

  <div class="col-md-5">

<div id="slider" class="carousel slide" data-bs-interval="false"> <!-- Removed auto-swiping -->
    <div class="carousel-inner">

        <!-- Static Slider Items -->
        <div class="carousel-item active">
            <img src="./images/rosetum-anjuna-deluxeroom-img.jpg" class="d-block w-100 rounded" style="height: 300px;" alt="Image 1">
            <div class="card">
            <p class="card-text fw-bold mt-3">AC Car</p>
           
            <button class="btn btn-success btn-lg d-flex align-items-center justify-content-center mx-auto">
                <span class="me-2">Per Person Price</span>
                 <span class="badge bg-light text-dark">₹500</span>
                </button>
                       
            <div class="offcontent d-flex align-items-center justify-content-center mx-auto mt-2">
            <span class="text-muted text-decoration-line-through fs-5">₹ 800</span>
            <span class="text-danger fs-8 fw-bold ms-2">
              10 % off<span id="discountedPrice"></span>
                 </span>   
             
                     </div>
                    </div>
                    </div>


                    <div class="carousel-item">
                <img src="./images/rosetum-anjuna-executiveroom-img.jpg"  class="d-block w-100 rounded" style="height: 300px;" alt="Image 2">
                <div class="card">
                <p class="card-text fw-bold mt-3">Non Ac Car</p>
                <button class="btn btn-success btn-lg d-flex align-items-center justify-content-center mx-auto">
                    <span class="me-2">Per Person Price</span>
                    <span class="badge bg-light text-dark">₹400</span>
                </button>
                <div class="offcontent d-flex align-items-center justify-content-center mx-auto mt-2">
                    <span class="text-muted text-decoration-line-through fs-5">₹ 500</span>
                <span class="text-danger fs-8 fw-bold ms-2">
                     10 % off<span id="discountedPrice"></span>
                </span>   
        </div>            
      </div>
            </div>


                    <div class="carousel-item">
                <img src="./images/rosetum-anjuna-royalsuites-room-img.jpg" class="d-block w-100 rounded" style="height: 300px;" alt="Image 3">
                <div class="card">
                <p class="card-text fw-bold mt-3">Luxury </p>
                <button class="btn btn-success btn-lg d-flex align-items-center justify-content-center mx-auto">
                    <span class="me-2">Per Person Price</span>
                    <span class="badge bg-light text-dark">₹800</span>
                </button>
                <div class="offcontent d-flex align-items-center justify-content-center mx-auto mt-2">
                    <span class="text-muted text-decoration-line-through fs-5">₹ 1000</span>
                <span class="text-danger fs-8 fw-bold ms-2">
                     10 % off<span id="discountedPrice"></span>
                </span>  
        </div>            
      </div>
            </div>

    

             <!-- Left and Right Arrows -->
 <button class="carousel-control-prev" type="button" data-bs-target="#slider" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#slider" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
</button>
<!-- </div> -->


 <!-- Hidden Images -->
 <div id="hiddenImages" class="d-none">
    <img src="" class="img-fluid rounded" alt="Hidden Image 1">
    <img src="" class="img-fluid rounded" alt="Hidden Image 2">
    <img src="" class="img-fluid rounded" alt="Hidden Image 3">
    <!-- Add more hidden images as needed -->
</div>

</div>
</div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>



 <!--First card  Modal strat-->
 <div class="modal fade" id="imageModal1" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Rosetum Anjuna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <!-- Slide 1 -->
                        <div class="carousel-item active">
                            <img src="./images/anjuna-slide1img.jpg" class="d-block w-100" alt="Image 1">
                        </div>
                        <!-- Slide 2 -->
                        <div class="carousel-item">
                            <img src="./images/anjuna-slide2img.jpg" class="d-block w-100" alt="Image 2">
                        </div>
                        <!-- Slide 3 -->
                        <div class="carousel-item">
                            <img src="./images/anjuna-slide3img.jpg" class="d-block w-100" alt="Image 3">
                        </div>
                        <!-- Slide 4 -->
                        <div class="carousel-item">
                            <img src="./images/anjuna-slide4img.jpg" class="d-block w-100" alt="Image 4">
                        </div>
                        <!-- Slide 5 (Video) -->
                        <div class="carousel-item">
                            <video id="carouselVideo" class="w-100" height="100%" autoplay loop muted>
                                <source src="./images/rosetum-anjuna-hotel-video.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>

                    </div>
                    </div>
                     </div>


                      <!-- Carousel Controls -->
                      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Bootstrap JS and Icons -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">




<script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.querySelector('#imageModal');
            const carousel = document.querySelector('#carouselExample');
            const video = document.querySelector('#carouselVideo');
            const bootstrapModal = bootstrap.Modal.getOrCreateInstance(modal);
    
            // Ensure video stops when modal is closed
            modal.addEventListener('hide.bs.modal', () => {
                if (video) video.pause();
            });
    
            // Pause video when switching carousel slides
            carousel.addEventListener('slid.bs.carousel', () => {
                const activeSlide = carousel.querySelector('.carousel-item.active video');
                if (!activeSlide) {
                    video.pause();
                }
            });
    
            // Play video only when its slide is active
            carousel.addEventListener('slide.bs.carousel', (event) => {
                const   nextSlide = event.relatedTarget;
                if (nextSlide.contains(video)) {
                    video.play();
                    const nextSlide = event.relatedTarget;
                    if (nextSlide.contains(video)){
                        video.play();
                    }

                }  
            });
    
            // Ensure video loads when modal is fully shown
            modal.addEventListener('shown.bs.modal', () => {
                const activeSlide = carousel.querySelector('.carousel-item.active video');
                if (activeSlide) activeSlide.load();
            });
        });
    </script>
    
<script>
    const hiddenImagesContainer = document.getElementById('hiddenImages'); // Container for hidden images
    const sliderInner = document.querySelector('#slider .carousel-inner'); // Carousel inner container

    let currentHiddenImageIndex = 0; // Index of the current hidden image

    // Function to append the next hidden image to the slider
    function appendNextHiddenImage() {
        const hiddenImages = hiddenImagesContainer.querySelectorAll('img'); // Get hidden images
        if (currentHiddenImageIndex < hiddenImages.length) { // Check if there are more hidden images
            const hiddenImage = hiddenImages[currentHiddenImageIndex]; // Get the current hidden image
            const newSlide = document.createElement('div'); // Create a new slide
            newSlide.classList.add('carousel-item'); // Add the Bootstrap class
            newSlide.innerHTML = `<img src="${hiddenImage.src}" class="d-block w-100 rounded" alt="${hiddenImage.alt}">`; // Add the hidden image
            sliderInner.appendChild(newSlide); // Append the new slide to the carousel
            currentHiddenImageIndex++; // Move to the next hidden image
        }
    }

    // Event listener for slider navigation
    document.querySelector('#slider').addEventListener('slide.bs.carousel', function () {
        if (currentHiddenImageIndex < hiddenImagesContainer.querySelectorAll('img').length) {
            appendNextHiddenImage(); // Append the next hidden image when navigating
        }
    });

    </script>





<!-- filter acc data -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Select all filter checkboxes
    const checkboxes = document.querySelectorAll('.filter-checkbox');
    const hotelItems = document.querySelectorAll('.hotel-item');

    // Add event listener to checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', filterHotels);
    });

    function filterHotels() {
        const filters = {
            price: [],
            company: [],
            review: []
        };

        // Collect active filters
        checkboxes.forEach(cb => {
            if (cb.checked) {
                filters[cb.dataset.filter].push(cb.value);
            }
        });

        // Filter hotels based on selected filters
        hotelItems.forEach(item => {
            const matchesPrice = filters.price.length === 0 || filters.price.includes(item.dataset.price);
            const matchesCompany = filters.company.length === 0 || filters.company.includes(item.dataset.company);
            const matchesReview = filters.review.length === 0 || filters.review.includes(item.dataset.review);

            // Show or hide items based on filter match
            if (matchesPrice && matchesCompany && matchesReview) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }
});
</script>


<!-- filter icon toggle -->

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Select all toggle buttons
    const toggleButtons = document.querySelectorAll('.toggle-icon');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Find the icon inside the clicked button
            const icon = this.querySelector('i');
            const target = this.closest('.card').querySelector('.collapse');

            // Toggle the collapse content visibility
            if (target.classList.contains('show')) {
                target.classList.remove('show');
                icon.classList.remove('bi-chevron-down');
                icon.classList.add('bi-chevron-up');
            } else {
                target.classList.add('show');
                icon.classList.remove('bi-chevron-up');
                icon.classList.add('bi-chevron-down');
            }
        });
    });
});

</script>
@endsection