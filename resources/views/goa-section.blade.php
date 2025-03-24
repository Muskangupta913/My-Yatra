@extends('frontend.layouts.master')
@section('content')
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        .container-fluid,
        .container {
            margin-top: 20px;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
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
            background-image: linear-gradient(rgba(0, 0, 0, 0.533), rgba(0, 0, 0, 0.511)), url('{{ asset('assets/images/goa-about-img.jpg') }}');
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
            padding-bottom: 56.25%;
            /* 16:9 aspect ratio */
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
                        Goa is India’s premier beach destination. Stay with Villa Calangute for families and couples alike,
                        exploring the best beaches in Goa. Let your romantic self indulge at scenic Anjuna Beach, romantic
                        Palolem Beach, and dynamic Baga Beach, famous for their beauty and nightlife. Book the best
                        honeymoon in Goa for couples for stylish stays and peace by the seaside. Find couples' top
                        destinations in Goa honeymoon places for couples family holiday packages in Goa instead.Famous for
                        its seafood and colorful festivals.
                    </p>
                    <img src="{{ asset('assets/images/goa-banner-img.jpg') }}" data-aos="flip-left" width="400px" alt>
                </div>


                <div class="col-md-6">
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d984956.6952529158!2d73.34716334663365!3d15.350084463361895!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bbfba106336b741%3A0xeaf887ff62f34092!2sGoa!5e0!3m2!1sen!2sin!4v1732606006417!5m2!1sen!2sin"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

            </div>
        </div>
    </section>

   <!-- Top Attractions Section -->
<section id="attractions-goa" data-aos="fade-up">
    <div class="container-fluid Goa-destinations mt-5 py-4 px-4 text-center">
        <h2>Top Attractions in Goa</h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/goa-attraction1-img.jpg') }}" class="card-img-top" alt="Villa Calangute" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title">Villa Calangute</h3>
                        <p class="card-text">Located just a short walk from the famous Calangute Beach, this villa combines modern amenities
                            with Goan charm, and personalized service. Enjoy the best of Goa's vibrant nightlife, and
                            dining, all while relaxing in your private haven. Elegant interiors amenities and private
                            gardens.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/goa-attraction2-img.jpg') }}" class="card-img-top" alt="Baga Beach" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title">Baga Beach</h3>
                        <p class="card-text">Baga Beach is famous for its nightlife and lively beach stalls. A favorite among partygoers,
                            travelers, and adventure seekers, making it one of the most happening places in Goa. Water
                            sports like parasailing and windsurfing. Baga Beach is ideal for those who look for fun and
                            entertainment in Goa.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/goa-attraction3-img.jfif') }}" class="card-img-top" alt="Basilica of Bom Jesus" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title">Basilica of Bom Jesus</h3>
                        <p class="card-text">The Basilica of Bom Jesus, situated in Old Goa, is a 16th-century church which contains the
                            sacred relics of St. Francis Xavier. Famous for its beautiful architecture and religiosity, it
                            ranks among the most significant historical sites in Goa and a must-see destination for heritage
                            enthusiasts.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/goa-attraction4-img.jpg') }}" class="card-img-top" alt="Dudhsagar Waterfalls" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title">Dudhsagar Waterfalls</h3>
                        <p class="card-text">Dudhsagar Waterfalls is amongst India's tallest and most majestic waterfalls situated on the
                            borders of Goa-Karnataka. Falling from more than 300 meters height, particularly during monsoon,
                            and is a sought-after destination among trekkers and nature enthusiasts. An adrenalin-boosting
                            trip through the wilderness to get there.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/goa-attraction5-img.avif') }}" class="card-img-top" alt="Fort Aguada" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title">Fort Aguada</h3>
                        <p class="card-text">Constructed during the 17th century by the Portuguese, Fort Aguada stands overlooking the Arabian
                            Sea and commands panoramic views. Famous for its historical value. It is among Goa's most
                            well-preserved forts and an absolute must-see for those interested in history and photography.
                            Strategic Significance: Guarded Goa against intruders.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/goa-attraction6-img.jpg') }}" class="card-img-top" alt="Anujuna Flea Market" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title">Anujuna Flea Market</h3>
                        <p class="card-text">Every Wednesday, the Anjuna Flea Market offers a colorful forum for shopping and cultural
                            immersion. Providing a plethora of handicrafts, attire, jewelry, and souvenirs, the market
                            reflects the eclecticism of Goa and welcomes tourists on the lookout for offbeat products and
                            local cuisines.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/goa-attraction7-img.jpg') }}" class="card-img-top" alt="Chapora Fort" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title">Chapora Fort</h3>
                        <p class="card-text">Chapora Fort, popularly seen in Bollywood movies, has stunning views of the coast and landscape.
                            Constructed in the 17th century, it is a witness to Goa's history and is a favorite place for
                            sunset photography and adventure. Historic Significance by the Portuguese in 1617.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/goa-attraction8-img.jfif') }}" class="card-img-top" alt="Palolem Beach" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title">Palolem Beach</h3>
                        <p class="card-text">Palolem Beach is famous for its peaceful beauty. Suitable for relaxation and swimming, the
                            palm-lined beach has a relaxed environment, which makes it an ideal destination for families and
                            couples looking for a quiet retreat. Palolem provides a mix of nature and makes it one of the
                            most sought-after beaches in Goa.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/goa-attraction9-img.jpg') }}" class="card-img-top" alt="Se Cathedral" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title">Se Cathedral</h3>
                        <p class="card-text">Se Cathedral is famous for its exquisite Portuguese-Manueline architecture and its historical
                            value. It has grand interiors and is home to the legendary Golden Bell, which makes it
                            compulsory for history and architecture lovers. It is home to the "Golden Bell," the biggest
                            church bell in Goa.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/goa-attraction10-img.jfif') }}" class="card-img-top" alt="Goa Carnival" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title">Goa Carnival</h3>
                        <p class="card-text">The Goa Carnival is a colorful annual festival held in February, with exuberant parades, music,
                            dance, and street shows. Characterized by its festive mood, the carnival highlights the culture
                            of rich heritage of Goa and is a festivity that is much awaited by locals as well as visitors,
                            announcing the start of the Lent period.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/goa-attraction11-img.webp') }}" class="card-img-top" alt="Anjuna Beach" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title">Anjuna Beach</h3>
                        <p class="card-text">Anjuna Beach is Goa's most well-known and happening beach, celebrated for its sheer natural
                            beauty, and hippie culture. It is renowned for: Spanning golden sands and palm groves with the
                            Arabian Sea in the background. Anjuna Beach is a place that must be visited by travelers looking
                            for adventure, relaxation, and Goa culture.</p>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/goa-attraction12-img.jpg') }}" class="card-img-top" alt="Divar Island" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h3 class="card-title">Divar Island</h3>
                        <p class="card-text">Divar Island is a tranquil and beautiful island within the Mandovi River, Goa, which is a great
                            haven from the crowds on the beaches. divar island Green vegetation, and view of the scenic
                            river. Historic Charm Reputed to be centuries-old churches and historic spots, such as the
                            well-known Our Lady of Compassion Church.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Travel Information Section -->
<section id="travel-info" data-aos="zoom-in" class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h2 class="mb-0 fw-bold">Travel Information</h2>
                    </div>
                    <div class="card-body bg-light p-4 p-md-5">
                        <div class="row g-4">
                            <div class="col-md-4 text-center">
                                <div class="info-card h-100 p-4 bg-white shadow-sm rounded">
                                    <i class="fas fa-calendar-alt fa-2x mb-3 text-primary"></i>
                                    <h4 class="mb-3">Best Time to Visit</h4>
                                    <p class="mb-0">November to February</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="info-card h-100 p-4 bg-white shadow-sm rounded">
                                    <i class="fas fa-route fa-2x mb-3 text-primary"></i>
                                    <h4 class="mb-3">How to Get Around</h4>
                                    <p class="mb-0">Delhi Metro, cabs, buses, and auto-rickshaws make it easy to navigate the city.</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="info-card h-100 p-4 bg-white shadow-sm rounded">
                                    <i class="fas fa-plane fa-2x mb-3 text-primary"></i>
                                    <h4 class="mb-3">Nearby Airport</h4>
                                    <p class="mb-0">Goa International Airport (Dabolim Airport), located approximately 28 km from the popular beaches.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Goa tour packages Section -->
    <div class="container my-5">
        <h1 class="text-center mb-5">Goa Tour Packages</h1>
        <div class="row g-4">

            <!-- Tour Package 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/adventure.jpeg') }}" class="card-img-top"
                        alt="Goa Adventure Tour">
                    <div class="card-body">
                        <h5 class="card-title">Goa Adventure Tour Package</h5>
                        <p class="card-text">Indulge in thrilling water sports like parasailing, scuba diving, and more
                            while exploring Goa's pristine beaches.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="tour-details">
                                <p><strong>Duration:</strong> 5 Days / 4 Nights</p>
                                <!-- <p><strong>Price:</strong> ₹12,999 per person</p> -->
                            </div>
                            <!-- <a href="#" class="btn btn-primary">Add to cart</a> -->
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
                        <p class="card-text">Relax on the beautiful beaches there, visit the historic forts, and enjoy the
                            vibrant nightlife in this 4-day get away.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="tour-details">
                                <p><strong>Duration:</strong> 4 Days / 3 Nights</p>
                                <!-- <p><strong>Price:</strong> ₹10,499 per person</p> -->
                            </div>
                            <!-- <a href="#" class="btn btn-primary">Add to cart</a> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tour Package 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <img src="{{ asset('assets/images/goa.jpeg') }}" class="card-img-top"
                        alt="Goa Heritage and Culture Tour">
                    <div class="card-body">
                        <h5 class="card-title">Goa Heritage and Culture Tour Package</h5>
                        <p class="card-text">Discover Goa's rich colonial history, visit ancient churches, spice
                            plantations, and enjoy local Goan cuisine.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="tour-details">
                                <p><strong>Duration:</strong> 3 Days / 2 Nights</p>
                                <!-- <p><strong>Price:</strong> ₹8,499 per person</p> -->
                            </div>
                            <!-- <a href="#" class="btn btn-primary">Add to cart</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
