@extends('frontend.layouts.master')
@section('content')
    <style>
        /* Global styles and responsive adjustments */
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #f8f9fa;
            --card-border-color: #dee2e6;
            --text-dark: #212529;
            --text-light: #ffffff;
        }

        /* Banner section improvements */
        .delhi-banner-section {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('assets/images/delhi-banner.jpeg') }}') no-repeat center center;
            background-size: cover;
            height: 450px;
            width: 100%;
            color: var(--text-light);
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .banner-content h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .banner-content p {
            font-size: 1.5rem;
            font-weight: 500;
        }

        /* About Delhi section enhancements */
        #about-box {
            padding: 3rem 0;
        }

        #about-box h2 {
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        #about-box h2:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            background-color: var(--primary-color);
            bottom: -10px;
            left: 25%;
        }

        .ads img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .ads img:hover {
            transform: scale(1.02);
        }

        /* Top Attractions section - Card fixes */
        .delhi-destinations {
            padding: 3rem 0;
        }

        .delhi-destinations h2 {
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
        }

        .delhi-destinations h2:after {
            content: '';
            position: absolute;
            width: 30%;
            height: 3px;
            background-color: var(--primary-color);
            bottom: -10px;
            left: 35%;
        }

        /* Card uniformity fix */
        .delhi-destinations .col-md-3 {
            display: flex;
            flex-direction: column;
        }

        .delhi-destinations .col-md-3 img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .delhi-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 1rem;
            background-color: var(--text-light);
            border: 1px solid var(--card-border-color) !important;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .delhi-content:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .delhi-content h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0.5rem 0;
            color: var(--text-dark);
        }

        .delhi-content p {
            font-size: 0.9rem;
            margin-bottom: 0;
            color: #666;
            flex: 1;
            display: block; /* Changed from -webkit-box to block */
            overflow: visible; /* Changed from hidden to visible */
        }

        /* Tour packages section improvements */
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 8px;
            overflow: hidden;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 1.25rem;
        }

        .card-title {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
            transform: translateY(-2px);
        }

        /* Travel Information section */
        .travel-information-container {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            background-color: #ffe8a1 !important;
            border: 1px solid #ffc107;
        }

        .travel-information-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .TIH {
            color: #212529;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .TIH:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 3px;
            background-color: #212529;
            bottom: -5px;
            left: 25%;
        }

        .travel-info-list {
            text-align: left;
            max-width: 800px;
            margin: 0 auto;
        }

        .travel-info-list li {
            margin-bottom: 0.75rem;
        }

        /* Responsive Adjustments */
        @media only screen and (max-width: 1200px) {
            .delhi-destinations .col-md-3 {
                width: 33.33%;
            }
        }

        @media only screen and (max-width: 992px) {
            .delhi-destinations .col-md-3 {
                width: 50%;
            }

            .banner-content h1 {
                font-size: 2.5rem;
            }
        }

        @media only screen and (max-width: 768px) {
            .delhi-banner-section {
                height: 350px;
            }

            .banner-content h1 {
                font-size: 2rem;
            }

            .banner-content p {
                font-size: 1.2rem;
            }

            .delhi-destinations .col-md-3 {
                width: 100%;
            }

            .delhi-destinations .col-md-3 img {
                height: 220px;
            }

            #about-box .col-md-6 {
                margin-bottom: 2rem;
            }

            .map {
                height: 300px;
                margin-top: 2rem;
                width: 100%;
            }
        }

        @media only screen and (max-width: 576px) {
            .delhi-banner-section {
                height: 300px;
            }

            .banner-content h1 {
                font-size: 1.75rem;
            }

            .banner-content p {
                font-size: 1rem;
            }

            .delhi-destinations .col-md-3 img {
                height: 200px;
            }

            .map {
                height: 250px;
                width: 100%;
            }

            .travel-info-list li {
                padding: 0 1rem;
            }
        }

        .travel-info-section {
            background-color: #f8f9fa;
            position: relative;
            overflow: hidden;
        }

        .travel-info-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('assets/images/delhi-pattern.png') }}');
            background-size: 300px;
            background-repeat: repeat;
            opacity: 0.05;
            z-index: 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .section-divider {
            height: 4px;
            width: 80px;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            margin: 0 auto 20px;
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .info-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 30px 25px;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .info-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .info-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .info-icon i {
            font-size: 28px;
            color: white;
        }

        .info-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }

        .info-text {
            color: #666;
            line-height: 1.6;
            text-align: center;
        }

        .btn-travel-info {
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-travel-info:hover {
            background: linear-gradient(135deg, #feb47b, #ff7e5f);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 126, 95, 0.3);
            color: white;
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .section-title {
                font-size: 2rem;
            }

            .info-card {
                padding: 25px 20px;
                margin-bottom: 20px;
            }
        }
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
                        Delhi, the vibrant capital of India, is the best travel agency in India offers a rich blend of
                        history and modernity. Tourists should visit the main attractions, which include India Gate and both
                        the Red Fort and Qutub Minar in combination with the Lotus Temple building. Multiple attractions
                        await families who visit Delhi tour packages for family because these tours deliver heritage sites
                        and markets with flavorsome street food and historical landmarks to both adults and children.

                    </p>
                    <img src="{{ asset('assets/images/delhi-about-short-img.jpg') }}" data-aos="flip-left" width="400px" alt>
                </div>

                <div class="col-md-6">
                    <iframe class="map"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d448194.82162352453!2d77.09323125!3d28.6440836!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x37205b715389640!2sDelhi!5e0!3m2!1sen!2sin!4v1727255134723!5m2!1sen!2sin"
                        width="600" height="450" style="border:0;" allowfullscreen loading="lazy"
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
                    <img src="{{ asset('assets/images/red-fort-img.jpg') }}" data-aos="fade-up" width="100%"
                        height="250px" alt="">
                    <div class="delhi-content border">
                        <h3>Red Fort</h3>
                        <p>The 17th-century fort, a symbol of India’s rich past, stands
                            as a majestic reminder of Mughal grandeur.</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mt-4">
                    <img src="{{ asset('assets/images/qutub-minaar.jpg') }}" data-aos="fade-up" width="100%"
                        height="250px" alt="">
                    <div class="delhi-content border">
                        <h3>Qutub Minar</h3>
                        <p>This UNESCO World Heritage Site is the tallest brick minaret
                            in the world, showcasing remarkable Indo-Islamic
                            architecture.</p>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mt-4">
                    <img src="{{ asset('assets/images/lotus-temple-img.jpeg') }}" data-aos="fade-up" width="100%"
                        height="250px" alt="Lotus Temple">
                    <div class="delhi-content border">
                        <h3>Lotus Temple</h3>
                        <p>A symbol of peace, this Bahá’í House of Worship is known for
                            its flower-like design and tranquil ambiance.</p>
                    </div>
                </div>



                <div class="col-md-3 mb-3 mt-4">
                    <img src="{{ asset('assets/images/humayus-tomb-img.jpeg') }}" data-aos="fade-up" width="100%"
                        height="250px" alt="Humayun's Tomb">
                    <div class="delhi-content border">
                        <h3>Humayun’s Tomb</h3>
                        <p>The stunning garden tomb of Emperor Humayun, a precursor to
                            the Taj Mahal in its architectural brilliance.</p>
                    </div>
                </div>




                <div class="col-md-3 mb-3 mt-4">
                    <img src="{{ asset('assets/images/indiagate.img') }}" data-aos="fade-up" width="100%" height="250px"
                        alt="">
                    <div class="delhi-content border">
                        <h3>India Gate</h3>
                        <p>India Gate is a 42-meter-tall war memorial in New Delhi, built in 1931 to honor Indian soldiers
                            who died in World War I. The Amar Jawan Jyoti, an eternal flame, commemorates soldiers'
                            sacrifices in later wars. It's a major landmark and tourist attraction..</p>
                    </div>
                </div>




                <div class="col-md-3  mb-3 mt-4">
                    <img src="{{ asset('assets/images/agra-img.jpg') }}" data-aos="fade-up" width="100%" height="250px"
                        alt="">
                    <div class="delhi-content border">
                        <h3>Delhi Agra</h3>
                        <p>Agra, which is close to Delhi, boasts the famous Taj Mahal, a UNESCO World Heritage property and
                            one of the Seven Wonders of the World. Renowned for Mughal structures such as Agra Fort and
                            Fatehpur Sikri, it's a huge top attractions in Delhi with a vibrant cultural past. Best travel companies.
                        </p>
                    </div>
                </div>



                <div class="col-md-3 mb-3 mt-4">
                    <img src="{{ asset('assets/images/jama-maszid-img.jfif') }}" data-aos="fade-up" width="100%"
                        height="250px" alt="">
                    <div class="delhi-content  border">
                        <h3>Jama Masjid</h3>
                        <p>Jama Masjid in Agra, constructed in 1648 by the daughter of Shah Jahan, is a massive mosque
                            famous for its beautiful Mughal architecture. Situated close to the Agra Fort, it contains
                            elaborate red sandstone and marble work, thus being an important historical and religious
                            landmark.
                        </p>
                    </div>
                </div>



                <div class="col-md-3 mb-3 mt-4">
                    <img src="{{ asset('assets/images/hauzkhas-img.jfif') }}" data-aos="fade-up"
                        width="100%"height="250px" alt="">
                    <div class="delhi-content border">
                        <h3>Hauz Khas</h3>
                        <p>Hauz Khas is a hip neighborhood in Delhi that combines ancient ruins with contemporary cafes,
                            boutiques, and art galleries. Famous for the Hauz Khas Complex, it comprises a medieval
                            reservoir of water, a mosque, and tombs and is a favorite haunt for both history buffs and party
                            people.
                        </p>
                    </div>
                </div>




                <div class="col-md-3 mb-3 mt-4">
                    <img src="{{ asset('assets/images/chandni-chowk-img.jpg') }}" data-aos="fade-up" width="100%"
                        height="250px" alt="">
                    <div class="delhi-content border">
                        <h3>Chandni Chowk</h3>
                        <p>Chandni Chowk is a very old and busy market in Delhi, which is famous for its narrow roads,
                            colorful bazaars, street food, and historical buildings such as the Red Fort and Jama Masjid. It
                            is a busy shopping destination, particularly for spices, jewelry, and fabric.
                        </p>
                    </div>
                </div>



                <div class="col-md-3 mb-3 mt-4">
                    <img src="{{ asset('assets/images/rashtrapati-bhawan-img.jpg') }}" data-aos="fade-up" width="100%"
                        height="250px" alt="">
                    <div class="delhi-content border">
                        <h3>Rashtrapatie Bhawan</h3>
                        <p>Rashtrapati Bhawan in New Delhi served as the residence of the President of India. It covers an
                            area of 330 acres with 340 rooms and beautiful Mughal gardens. Sir Edwin Lutyens designed it,
                            and it represents the democratic nature of India and architectural splendor. </p>
                    </div>
                </div>



                <div class="col-md-3 mb-3 mt-4">
                    <img src="{{ asset('assets/images/sarojini-nagar-img.jpg') }}" data-aos="fade-up" width="100%"
                        height="250px" alt="">
                    <div class="delhi-content  border">
                        <h3>Sarojoini Nagar Market</h3>
                        <p>Sarojini Nagar Market in Delhi is one of the top shopping places, popular for its inexpensive
                            fashion, modern clothing, and accessories. Both locals and travelers visit it for great deals,
                            and hence, it is the center for economical shopping.
                        </p>
                    </div>
                </div>


                <div class="col-md-3 mb-3 mt-4">
                    <img src="{{ asset('assets/images/lodhi-gardens-img.jfif') }}" data-aos="fade-up" width="100%"
                        height="250px" alt="">
                    <div class="delhi-content border">
                        <h3>Lodhi Garden</h3>
                        <p>
                            Lodhi Garden in Delhi is a historic park featuring 15th-century tombs from the Lodhi dynasty.
                            Known for its greenery and peaceful atmosphere, The gardens picnics, and photography. the tombs
                            of 15th and 16th-century rulers from the Lodhi dynasty.
                        </p>
                    </div>
                </div>




                <div class="col-md-3 mb-3 mt-4">
                    <img src="{{ asset('assets/images/akshardham-temple-img.jpg') }}" data-aos="fade-up" width="100%"
                        height="250px" alt="">
                    <div class="delhi-content border ">
                        <h3>Akshardham Temple</h3>
                        <p>Akshardham Temple, Delhi, is an exquisite Hindu temple famous for its imposing architecture and
                            beautifully carved pillars. Since it was opened in 2005, it has depicted India's ancient
                            civilization, spirituality, and traditions and has become a huge spiritual and tourism site.</p>
                    </div>
                </div>



                <div class="col-md-3 mb-3  mt-4">
                    <img src="{{ asset('assets/images/gurudwara-bangla-sahib-img.jpg') }}" data-aos="fade-up"
                        width="100%" height="250px" alt="">
                    <div class="delhi-content border">
                        <h3>Gurudwara Bangla Sahib</h3>
                        <p>Delhi Gurudwara is one of the most famous Sikh temples famous for its peaceful ambiance. It marks
                            the 8th Sikh Guru, Guru Har Krishan, and is a big religious and tourist attraction center,
                            providing free food (langar) to everyone. </p>
                    </div>
                </div>
                <div class="col-md-3 mb-3 mt-4">
                    <img src="{{ asset('assets/images/jantar-mantar-img.jpg') }}" data-aos="fade-up" width="100%"
                        height="250px" alt="">
                    <div class="delhi-content  border">
                        <h3>Jantar Mantar</h3>
                        <p>Jantar Mantar in Delhi is an 18th-century observatory constructed by Maharaja Jai Singh II. It
                            has large instruments employed to observe celestial bodies, and it is a historical and
                            scientific landmark. </p>
                    </div>
                </div>
                <div class="col-md-3  mt-4">
                    <img src="{{ asset('assets/images/national-museum-img.jpg') }}" data-aos="fade-up" width="100%"
                        height="250px" alt="">
                    <div class="delhi-content border ">
                        <h3>National Museum</h3>
                        <p>The National Museum in Delhi is among India's biggest museums. Its vast collection comprises
                            artifacts from the Indus Valley Civilization and Indian art, providing an in-depth insight into
                            the nation's cultural heritage. </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Delhi tour packages Section -->
    <section class="bg-light">
        <div class="container my-5">
            <h2 class="text-center mb-5 py-3">Delhi Tour Packages</h2>
            <div class="row g-4">
                <!-- Tour Package 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <img src="{{ asset('assets/images/tour-image-1.jpg') }}" class="card-img-top"
                            alt="Delhi Heritage Tour">
                        <div class="card-body">
                            <h5 class="card-title">Delhi Heritage Tour Package</h5>
                            <p class="card-text">Explore Red Fort, Qutub Minar, Humayun’s Tomb, and more on this 3-day
                                cultural journey.</p>
                            <p><strong>Duration:</strong> 3 Days / 2 Nights</p>
                            <!-- <p><strong>Price:</strong> ₹7,499 per person</p> -->
                            <!-- <a href="#" class="btn btn-primary">Add to cart</a> -->
                        </div>
                    </div>
                </div>

                <!-- Tour Package 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <img src="{{ asset('assets/images/tour-image-2.jpg') }}" class="card-img-top"
                            alt="Cultural & Shopping Tour">
                        <div class="card-body">
                            <h5 class="card-title">Delhi Cultural & Shopping Tour</h5>
                            <p class="card-text">Discover Delhi’s vibrant culture, shop in local markets, and indulge in
                                street food.</p>
                            <p><strong>Duration:</strong> 2 Days / 1 Night</p>
                            <!-- <p><strong>Price:</strong> ₹5,999 per person</p> -->
                            <!-- <a href="#" class="btn btn-primary">Add to cart</a> -->
                        </div>
                    </div>
                </div>
                <!-- Tour Package 4 -->
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <img src="{{ asset('assets/images/tour-image-4.jpg') }}" class="card-img-top"
                            alt="Adventure Tour">
                        <div class="card-body">
                            <h5 class="card-title">Delhi Adventure & Outdoor Tour</h5>
                            <p class="card-text">Experience nature, cycling tours, and hot air balloon rides with this
                                adventurous package.</p>
                            <p><strong>Duration:</strong> 3 Days / 2 Nights</p>
                            <!-- <p><strong>Price:</strong> ₹8,999 per person</p> -->
                            <!-- <a href="#" class="btn btn-primary">Add to cart</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Travel Information Section -->
    <section id="travel-info" class="travel-info-section py-5" data-aos="zoom-in">
        <div class="container">
            <div class="travel-info-header text-center mb-5">
                <h2 class="section-title">Travel Information</h2>
                <div class="section-divider"></div>
                <p class="section-subtitle">Everything you need to know for your Delhi adventure</p>
            </div>

            <div class="row justify-content-center">
                <!-- Best Time to Visit -->
                <div class="col-md-4 mb-4">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3 class="info-title">Best Time to Visit</h3>
                        <p class="info-text">October to March, when the weather is pleasant with temperatures ranging from
                            10°C to 25°C, perfect for sightseeing.</p>
                    </div>
                </div>

                <!-- Getting Around -->
                <div class="col-md-4 mb-4">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-subway"></i>
                        </div>
                        <h3 class="info-title">Getting Around</h3>
                        <p class="info-text">Delhi Metro, cabs, buses, and auto-rickshaws make it easy to navigate the
                            city. The metro is the fastest and most convenient option.</p>
                    </div>
                </div>

                <!-- Airport Information -->
                <div class="col-md-4 mb-4">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-plane"></i>
                        </div>
                        <h3 class="info-title">Airport</h3>
                        <p class="info-text">Indira Gandhi International Airport, located about 15 km from the city center,
                            is well-connected with major cities worldwide.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
