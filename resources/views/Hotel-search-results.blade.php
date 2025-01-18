<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Search Results</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --text-primary: #1f2937;
            --text-secondary: #4b5563;
            --background-light: #f3f4f6;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background-color: var(--background-light);
            color: var(--text-primary);
            line-height: 1.6;
        }

        .header {
            background: linear-gradient(to right, #2563eb, #1e40af);
            padding: 2rem 0;
            color: white;
            margin-bottom: 2rem;
        }

        .header h1 {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .results-grid {
            display: grid;
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .hotel-card {
            background: white;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease;
        }

        .hotel-card:hover {
            transform: translateY(-4px);
        }

        .hotel-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .hotel-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hotel-rating {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(0, 0, 0, 0.7);
            color: #fbbf24;
            padding: 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }

        .hotel-content {
            padding: 1.5rem;
        }

        .hotel-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .hotel-address {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: start;
            gap: 0.5rem;
        }

        .hotel-address i {
            color: var(--primary-color);
            margin-top: 0.25rem;
        }

        .hotel-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 1rem 0;
        }

        .view-details-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .view-details-btn:hover {
            background-color: var(--secondary-color);
        }

        @media (min-width: 768px) {
            .results-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .results-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            background: white;
            border-radius: 1rem;
            box-shadow: var(--card-shadow);
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>Hotel Search Results</h1>
        </div>
    </header>

    <div class="container">
        <div id="results-container" class="results-grid"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchResults = JSON.parse(sessionStorage.getItem('searchResults')) || [];
            const resultsContainer = document.getElementById('results-container');
            const traceId = sessionStorage.getItem('traceId');

            if (searchResults.length === 0) {
                resultsContainer.innerHTML = `
                    <div class="no-results">
                        <i class="fas fa-search fa-3x" style="color: var(--text-secondary); margin-bottom: 1rem;"></i>
                        <p>No results found. Please try another search.</p>
                    </div>`;
                return;
            }

            searchResults.forEach(result => {
                const hotelCard = document.createElement('div');
                hotelCard.classList.add('hotel-card');
                
                hotelCard.innerHTML = `
                    <div class="hotel-image">
                        <img src="${result.HotelPicture || '/api/placeholder/400/200'}" alt="${result.HotelName}">
                        <div class="hotel-rating">
                            <i class="fas fa-star"></i> ${result.StarRating}
                        </div>
                    </div>
                    <div class="hotel-content">
                        <h2 class="hotel-name">${result.HotelName || 'Unnamed Hotel'}</h2>
                        <div class="hotel-address">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>${result.HotelAddress || 'Address not available'}</span>
                        </div>
                        <div class="hotel-price">₹${result.Price?.PublishedPrice?.toLocaleString() || 'N/A'}</div>
                        <a href="/hotel-info?traceId=${traceId}&resultIndex=${result.ResultIndex}&hotelCode=${result.HotelCode}" 
                           onclick="viewHotelDetails('${result.ResultIndex}', '${result.HotelCode}')" 
                           class="view-details-btn">
                            <i class="fas fa-info-circle"></i> View Details
                        </a>
                    </div>
                `;
                
                resultsContainer.appendChild(hotelCard);
            });
        });

        function viewHotelDetails(resultIndex, hotelCode) {
            const traceId = sessionStorage.getItem('traceId');
            
            if (!traceId) {
                console.error('TraceId is not found in sessionStorage');
                return;
            }

            sessionStorage.setItem('selectedHotelResultIndex', resultIndex);
            sessionStorage.setItem('selectedHotelTraceId', traceId);
            sessionStorage.setItem('selectedHotelCode', hotelCode);
            
            window.location.href = `/hotel-info?traceId=${traceId}&resultIndex=${resultIndex}&hotelCode=${hotelCode}`;
        }
    </script>
</body>
</html>