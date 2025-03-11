@extends('frontend.layouts.master')

@section('content')
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection

<div class="bg-gradient-to-b from-blue-100 to-white min-h-screen">
    <div class="container mx-auto px-4 py-12">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-extrabold text-blue-900 mb-6 tracking-tight">
                Incredible Destinations of India
            </h1>
            <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                Embark on a journey through India's most breathtaking landscapes, where ancient traditions meet modern marvels. 
                Discover destinations that offer unique experiences, from architectural wonders to natural paradises.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
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
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 hover:scale-105 hover:shadow-3xl">
        <div class="relative">
            <img 
            src="{{ asset('assets/images/' . $destination['image']) }}" 
                alt="{{ $destination['name'] }}" 
                class="w-full h-72 object-cover"
            >
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-6 text-white">
                <h2 class="text-3xl font-bold">{{ $destination['name'] }}</h2>
                <p class="text-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>
                    {{ $destination['location'] }}
                </p>
            </div>
        </div>
        <div class="p-6">
            <p class="text-gray-700 mb-4">{{ $destination['description'] }}</p>
            
            <div class="space-y-4 mb-4">
                <div>
                    <h3 class="font-semibold text-blue-800 mb-2">Highlights</h3>
                    <ul class="space-y-1 text-sm text-gray-600">
                        @foreach($destination['highlights'] as $highlight)
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ $highlight }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-blue-800 mb-2">Travel Tips</h3>
                    <ul class="space-y-1 text-sm text-gray-600">
                        @foreach($destination['travel_tips'] as $tip)
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 10l-2.293 2.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"/>
                                </svg>
                                {{ $tip }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="flex justify-between items-center mt-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm text-gray-600">Best Time: {{ $destination['best_time'] }}</span>
                </div>
            </div>
        </div>
            </div>
    @endforeach
</div>
        <div class="text-center mt-16">
            <p class="text-xl text-gray-700 mb-6">
                Ready to embark on an unforgettable journey through India?
            </p>
            <!-- <a href="#" class="bg-blue-700 text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-blue-800 transition shadow-lg">
                Plan Your Trip
            </a> -->
        </div>
    </div>
</div>
@endsection