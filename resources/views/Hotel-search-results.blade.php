<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Loaded</title>
<link rel="icon" href="favicon.ico">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .hotel {
            display: flex;
            align-items: flex-start;
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .hotel:last-child {
            border-bottom: none;
        }
        .hotel img {
            width: 150px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 20px;
        }
        .hotel-details {
            flex: 1;
        }
        .hotel-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .hotel-description {
            font-size: 14px;
            color: #666;
            margin: 10px 0;
        }
        .hotel-price {
            font-size: 16px;
            font-weight: bold;
            color: #27ae60;
        }
        .btn-book {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        .btn-book:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
       document.addEventListener('DOMContentLoaded', function () {
    const searchResults = JSON.parse(sessionStorage.getItem('searchResults')) || [];
    const resultsContainer = document.getElementById('results-container');
    
    // Get traceId from sessionStorage at the top level
    const traceId = sessionStorage.getItem('traceId');
    console.log('TraceId from sessionStorage:', traceId);

    if (searchResults.length === 0) {
        resultsContainer.innerHTML = '<p>No results found. Please try again.</p>';
        return;
    }

    searchResults.forEach(result => {
        const hotelElement = document.createElement('div');
        hotelElement.classList.add('hotel');
        
        // Fixed template literal syntax and added traceId to the href
        hotelElement.innerHTML = `
            <img src="${result.HotelPicture || 'https://via.placeholder.com/150'}" alt="${result.HotelName}">
            <div class="hotel-details">
                <div class="hotel-name">${result.HotelName || 'Unnamed Hotel'} (${result.StarRating} Stars)</div>
                <div class="hotel-description">${result.HotelAddress || 'No description available.'}</div>
                <div class="hotel-price">Price: ₹${result.Price?.PublishedPrice || 'N/A'}</div>
               <a href="/hotel-info?traceId=${traceId}&resultIndex=${result.ResultIndex}&hotelCode=${result.HotelCode}" 
                   onclick="viewHotelDetails('${result.ResultIndex}', '${result.HotelCode}')" 
                   class="view-details-btn">
                    View Details
                </a>
            </div>
        `;
        
        resultsContainer.appendChild(hotelElement);
    });
});

function viewHotelDetails(resultIndex) {
    console.log('Setting session storage:');
    console.log('ResultIndex:', resultIndex);
    console.log('HotelCode:', hotelCode);
    
    // Get traceId from sessionStorage
    const traceId = sessionStorage.getItem('traceId');
    console.log('TraceId from sessionStorage:', traceId);

    if (!traceId) {
        console.error('TraceId is not found in sessionStorage');
        return;
    }

    sessionStorage.setItem('selectedHotelResultIndex', resultIndex);
    sessionStorage.setItem('selectedHotelTraceId', traceId);
    sessionStorage.setItem('selectedHotelCode', hotelCode);
    
    
    // Use template literals for the URL
    window.location.href = `/hotel-info?traceId=${traceId}&resultIndex=${resultIndex}&hotelCode=${hotelCode}`;
}
    </script>
</head>
<body>
    <div class="container">
        <h1>Search Results</h1>
        <!-- Missing container added here -->
        <div id="results-container"></div>
    </div>
</body>
</html>