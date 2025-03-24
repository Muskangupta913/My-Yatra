@extends('frontend.layouts.master')

@section('content')
<!-- External Resources -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    /* Custom CSS for professional design */
    .destinations-header {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        padding: 80px 0 60px;
        margin-bottom: 50px;
    }
    
    .destinations-title {
        color: #2c3e50;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 20px;
    }
    
    .destinations-subtitle {
        color: #546e7a;
        font-weight: 400;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.6;
    }
    
    .destination-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 30px;
        height: 100%;
    }
    
    .destination-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .card-img-container {
        position: relative;
        height: 250px;
        overflow: hidden;
    }
    
    .card-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .destination-card:hover .card-img-container img {
        transform: scale(1.05);
    }
    
    .image-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
        padding: 20px;
        color: white;
    }
    
    .destination-name {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .destination-location {
        display: flex;
        align-items: center;
        font-size: 14px;
        opacity: 0.9;
    }
    
    .destination-location i {
        margin-right: 5px;
    }
    
    .card-body {
        padding: 25px;
    }
    
    .destination-description {
        color: #546e7a;
        margin-bottom: 20px;
        line-height: 1.6;
    }
    
    .section-title {
        color: #1976d2;
        font-weight: 600;
        font-size: 18px;
        margin-bottom: 12px;
    }
    
    .highlight-list, .tips-list {
        padding-left: 5px;
        list-style-type: none;
    }
    
    .highlight-list li, .tips-list li {
        position: relative;
        padding-left: 25px;
        margin-bottom: 8px;
        color: #546e7a;
    }
    
    .highlight-list li:before {
        content: "\f00c";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        left: 0;
        color: #4caf50;
    }
    
    .tips-list li:before {
        content: "\f0eb";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        left: 0;
        color: #ff9800;
    }
    
    .best-time {
        display: flex;
        align-items: center;
        color: #546e7a;
        font-size: 14px;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #e0e0e0;
    }
    
    .best-time i {
        margin-right: 8px;
        color: #1976d2;
    }
    
    .cta-section {
        background-color: #f5f7fa;
        padding: 60px 0;
        margin-top: 50px;
        text-align: center;
    }
    
    .cta-text {
        color: #2c3e50;
        font-size: 24px;
        margin-bottom: 25px;
    }
    
    .cta-button {
        background-color: #1976d2;
        color: white;
        padding: 12px 30px;
        border-radius: 30px;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.3s ease;
        display: inline-block;
    }
    
    .cta-button:hover {
        background-color: #1565c0;
        color: white;
    }
    
    @media (max-width: 767px) {
        .destinations-header {
            padding: 40px 0 30px;
        }
        
        .destinations-title {
            font-size: 28px;
        }
        
        .destinations-subtitle {
            font-size: 16px;
        }
        
        .destination-name {
            font-size: 20px;
        }
    }
</style>

<!-- Header Section -->
<div class="destinations-header">
    <div class="container">
        <div class="text-center">
            <h1 class="destinations-title display-4">Incredible Destinations of India</h1>
            <p class="destinations-subtitle lead">
                Embark on a journey through India's most breathtaking landscapes, where ancient traditions meet modern marvels. 
                Discover destinations that offer unique experiences, from architectural wonders to natural paradises.
            </p>
        </div>
    </div>
</div>

<!-- Destinations Section -->
<div class="container">
    <div class="row">
        @php
        $destinations = [
            [
                'name' => 'Taj Mahal',
                'location' => 'Agra, Uttar Pradesh',
                'image' => 'taj-mahal.jpg',
                'description' => 'A mesmerizing marble mausoleum, symbol of eternal love and architectural brilliance.',
                'highlights' => [
                    'UNESCO World Heritage Site',
                    'Built by Mughal Emperor Shah Jahan',
                    'One of the Seven Wonders of the World',
                    'Stunning white marble architecture'
                ],
                'best_time' => 'October to March',
                'travel_tips' => [
                    'Book tickets online in advance',
                    'Arrive early to avoid crowds',
                    'Hire a local guide for deep insights'
                ]
            ],
            [
                'name' => 'Kerala Backwaters',
                'location' => 'Kerala, South India',
                'image' => 'kerela.jpg',
                'description' => 'A network of stunning lagoons, lakes, and canals offering a tranquil tropical paradise.',
                'highlights' => [
                    'Unique houseboat experiences',
                    'Lush tropical landscapes',
                    'Traditional village life',
                    'Rich biodiversity'
                ],
                'best_time' => 'September to March',
                'travel_tips' => [
                    'Book an overnight houseboat',
                    'Explore local villages',
                    'Try traditional Kerala cuisine'
                ]
            ],
            [
                'name' => 'Jaipur - Pink City',
                'location' => 'Rajasthan',
                'image' => 'jaipur.jpg',
                'description' => 'A royal city showcasing Rajasthan\'s rich cultural heritage and magnificent architecture.',
                'highlights' => [
                    'Amber Fort',
                    'City Palace',
                    'Hawa Mahal',
                    'Vibrant local markets'
                ],
                'best_time' => 'October to March',
                'travel_tips' => [
                    'Take a guided heritage walk',
                    'Shop for traditional handicrafts',
                    'Experience local Rajasthani cuisine'
                ]
            ],
            [
                'name' => 'Varanasi',
                'location' => 'Uttar Pradesh',
                'image' => 'Varanasi.jpg',
                'description' => 'The spiritual capital of India, where ancient traditions and religious practices come alive.',
                'highlights' => [
                    'Ancient ghats along the Ganges',
                    'Spiritual and cultural experiences',
                    'Historic temples',
                    'Evening Ganga Aarti ceremony'
                ],
                'best_time' => 'October to March',
                'travel_tips' => [
                    'Attend the evening Ganga Aarti',
                    'Take a sunrise boat ride',
                    'Respect local religious practices'
                ]
            ],
            [
                'name' => 'Goa',
                'location' => 'Western Coast',
                'image' => 'Goa.jpg',
                'description' => 'A tropical paradise blending Portuguese colonial charm with stunning beaches and vibrant culture.',
                'highlights' => [
                    'Beautiful sandy beaches',
                    'Portuguese colonial architecture',
                    'Water sports and activities',
                    'Vibrant nightlife'
                ],
                'best_time' => 'November to February',
                'travel_tips' => [
                    'Try water sports',
                    'Explore local markets',
                    'Visit historic churches'
                ]
            ],
            [
                'name' => 'Ladakh',
                'location' => 'Leh and Ladakh',
                'image' => 'ladakh.jpg',
                'description' => 'A high-altitude desert with breathtaking Himalayan landscapes and unique Buddhist culture.',
                'highlights' => [
                    'Stunning mountain landscapes',
                    'Ancient Buddhist monasteries',
                    'High-altitude lakes',
                    'Adventure tourism'
                ],
                'best_time' => 'June to September',
                'travel_tips' => [
                    'Acclimatize to high altitude',
                    'Visit Buddhist monasteries',
                    'Take photography tours'
                ]
            ]
        ];
        @endphp

        @foreach($destinations as $destination)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="destination-card">
                <div class="card-img-container">
                    <img src="{{ asset('assets/images/' . $destination['image']) }}" alt="{{ $destination['name'] }}">
                    <div class="image-overlay">
                        <h2 class="destination-name">{{ $destination['name'] }}</h2>
                        <p class="destination-location">
                            <i class="fas fa-map-marker-alt"></i> {{ $destination['location'] }}
                        </p>
                    </div>
                </div>
                <div class="card-body">
                    <p class="destination-description">{{ $destination['description'] }}</p>
                    
                    <div class="mb-4">
                        <h3 class="section-title">Highlights</h3>
                        <ul class="highlight-list">
                            @foreach($destination['highlights'] as $highlight)
                                <li>{{ $highlight }}</li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="mb-4">
                        <h3 class="section-title">Travel Tips</h3>
                        <ul class="tips-list">
                            @foreach($destination['travel_tips'] as $tip)
                                <li>{{ $tip }}</li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="best-time">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Best Time to Visit: {{ $destination['best_time'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- CTA Section -->
<div class="cta-section">
    <div class="container">
        <p class="cta-text">Ready to embark on an unforgettable journey through India?</p>
        <a href="#" class="cta-button">Plan Your Trip</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection