@extends('frontend.layouts.master')
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    @section('content')
<body class="bg-gray-50 text-gray-800">
    <div class="container mx-auto px-4 py-8">
        <header class="text-center mb-12">
            <h1 class="text-4xl font-bold text-blue-600 mb-4">Essential Travel Tips for India</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Navigate the vibrant and diverse landscape of India with confidence using these crucial travel insights.
            </p>
        </header>

        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-blue-500 mb-4">
                    <i class="fas fa-passport mr-3"></i>Visa and Documentation
                </h2>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span>Obtain an e-Visa or appropriate tourist visa before arrival</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span>Carry multiple copies of passport, visa, and important documents</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span>Register with your country's embassy for emergency support</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-blue-500 mb-4">
                    <i class="fas fa-first-aid mr-3"></i>Health Precautions
                </h2>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span>Get recommended vaccinations (Hepatitis A, Typhoid, etc.)</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span>Carry a basic medical kit and any personal medications</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span>Drink bottled water and avoid street food initially</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-blue-500 mb-4">
                    <i class="fas fa-rupee-sign mr-3"></i>Money and Expenses
                </h2>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span>Inform your bank about travel to prevent card blockages</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span>Carry some cash and use multiple payment methods</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span>Be prepared to negotiate prices in local markets</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-blue-500 mb-4">
                    <i class="fas fa-mobile-alt mr-3"></i>Communication Tips
                </h2>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span>Purchase a local SIM card for affordable data and calls</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span>Download offline translation and navigation apps</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-3 mt-1"></i>
                        <span>Learn a few basic Hindi or local language phrases</span>
                    </li>
                </ul>
            </div>
        </div>

        <section class="mt-12 bg-blue-50 rounded-lg p-8 text-center">
            <h2 class="text-3xl font-bold text-blue-700 mb-4">Cultural Sensitivity</h2>
            <p class="text-lg text-gray-700 max-w-3xl mx-auto">
                Respect local customs by dressing modestly, asking permission before photographing people, 
                and being mindful of religious and cultural practices. India is diverse, so attitudes can 
                vary significantly between regions.
            </p>
        </section>
    </div>
</body>
@endsection