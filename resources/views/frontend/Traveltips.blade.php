@extends('frontend.layouts.master')

@section('content')
<!-- External Resources -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    /* Custom Professional Styling */
    body {
        background-color: #f8f9fa;
        color: #343a40;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .travel-tips-header {
        text-align: center;
        margin-bottom: 60px;
        padding-top: 40px;
    }
    
    .travel-tips-title {
        color: #0056b3;
        font-weight: 700;
        margin-bottom: 20px;
    }
    
    .travel-tips-subtitle {
        color: #6c757d;
        max-width: 700px;
        margin: 0 auto;
        line-height: 1.6;
    }
    
    .tips-card {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        padding: 25px;
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .tips-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }
    
    .tips-card-title {
        color: #0056b3;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        font-size: 22px;
    }
    
    .tips-card-title i {
        color: #0056b3;
        margin-right: 15px;
        font-size: 24px;
        width: 30px;
        text-align: center;
    }
    
    .tips-list {
        list-style-type: none;
        padding-left: 0;
        margin-bottom: 0;
    }
    
    .tips-list li {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .tips-list li:last-child {
        margin-bottom: 0;
    }
    
    .tips-list-icon {
        color: #28a745;
        margin-right: 15px;
        margin-top: 4px;
        flex-shrink: 0;
    }
    
    .tips-list-text {
        flex-grow: 1;
        line-height: 1.5;
    }
    
    .cultural-sensitivity-section {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border-radius: 8px;
        padding: 35px;
        margin-top: 60px;
        text-align: center;
    }
    
    .cultural-sensitivity-title {
        color: #0056b3;
        font-weight: 700;
        margin-bottom: 20px;
    }
    
    .cultural-sensitivity-text {
        color: #37474f;
        max-width: 800px;
        margin: 0 auto;
        line-height: 1.7;
        font-size: 18px;
    }
    
    @media (max-width: 767px) {
        .travel-tips-title {
            font-size: 28px;
        }
        
        .tips-card {
            margin-bottom: 20px;
        }
        
        .cultural-sensitivity-section {
            padding: 25px;
        }
        
        .cultural-sensitivity-title {
            font-size: 24px;
        }
        
        .cultural-sensitivity-text {
            font-size: 16px;
        }
    }
</style>

<div class="container">
    <!-- Header Section -->
    <div class="travel-tips-header">
        <h1 class="travel-tips-title display-4">Essential Travel Tips for India</h1>
        <p class="travel-tips-subtitle lead">
            Navigate the vibrant and diverse landscape of India with confidence using these crucial travel insights.
        </p>
    </div>
    
    <!-- Travel Tips Cards -->
    <div class="row g-4">
        <!-- Visa and Documentation -->
        <div class="col-md-6">
            <div class="tips-card">
                <h2 class="tips-card-title">
                    <i class="fas fa-passport"></i>
                    Visa and Documentation
                </h2>
                <ul class="tips-list">
                    <li>
                        <i class="fas fa-check-circle tips-list-icon"></i>
                        <span class="tips-list-text">Obtain an e-Visa or appropriate tourist visa before arrival</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle tips-list-icon"></i>
                        <span class="tips-list-text">Carry multiple copies of passport, visa, and important documents</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle tips-list-icon"></i>
                        <span class="tips-list-text">Register with your country's embassy for emergency support</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Health Precautions -->
        <div class="col-md-6">
            <div class="tips-card">
                <h2 class="tips-card-title">
                    <i class="fas fa-first-aid"></i>
                    Health Precautions
                </h2>
                <ul class="tips-list">
                    <li>
                        <i class="fas fa-check-circle tips-list-icon"></i>
                        <span class="tips-list-text">Get recommended vaccinations (Hepatitis A, Typhoid, etc.)</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle tips-list-icon"></i>
                        <span class="tips-list-text">Carry a basic medical kit and any personal medications</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle tips-list-icon"></i>
                        <span class="tips-list-text">Drink bottled water and avoid street food initially</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Money and Expenses -->
        <div class="col-md-6">
            <div class="tips-card">
                <h2 class="tips-card-title">
                    <i class="fas fa-rupee-sign"></i>
                    Money and Expenses
                </h2>
                <ul class="tips-list">
                    <li>
                        <i class="fas fa-check-circle tips-list-icon"></i>
                        <span class="tips-list-text">Inform your bank about travel to prevent card blockages</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle tips-list-icon"></i>
                        <span class="tips-list-text">Carry some cash and use multiple payment methods</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle tips-list-icon"></i>
                        <span class="tips-list-text">Be prepared to negotiate prices in local markets</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <!-- Communication Tips -->
        <div class="col-md-6">
            <div class="tips-card">
                <h2 class="tips-card-title">
                    <i class="fas fa-mobile-alt"></i>
                    Communication Tips
                </h2>
                <ul class="tips-list">
                    <li>
                        <i class="fas fa-check-circle tips-list-icon"></i>
                        <span class="tips-list-text">Purchase a local SIM card for affordable data and calls</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle tips-list-icon"></i>
                        <span class="tips-list-text">Download offline translation and navigation apps</span>
                    </li>
                    <li>
                        <i class="fas fa-check-circle tips-list-icon"></i>
                        <span class="tips-list-text">Learn a few basic Hindi or local language phrases</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Cultural Sensitivity Section -->
    <div class="cultural-sensitivity-section">
        <h2 class="cultural-sensitivity-title">Cultural Sensitivity</h2>
        <p class="cultural-sensitivity-text">
            Respect local customs by dressing modestly, asking permission before photographing people, 
            and being mindful of religious and cultural practices. India is diverse, so attitudes can 
            vary significantly between regions.
        </p>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection