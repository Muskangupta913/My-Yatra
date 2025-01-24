<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Flight Search Results</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .fare-rules-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .fare-rules-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-height: 70%;
            overflow-y: auto;
        }
        .close-fare-rules {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <h1>Flight Search Results</h1>
        </div>
    </header>

    <div class="container">
        <div id="results-container" class="results-grid"></div>
    </div>

    <!-- Fare Rules Modal -->
    <div id="fareRulesModal" class="fare-rules-modal">
        <div class="fare-rules-content">
            <span class="close-fare-rules">&times;</span>
            <div id="fareRulesDetails"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const results = JSON.parse(sessionStorage.getItem('flightSearchResults')) || [];
            const resultsContainer = document.getElementById('results-container');
            const traceId = sessionStorage.getItem('flightTraceId');
            const fareRulesModal = document.getElementById('fareRulesModal');
            const fareRulesDetails = document.getElementById('fareRulesDetails');
            const closeFareRules = document.querySelector('.close-fare-rules');

            // Close modal when clicking on close button
            closeFareRules.onclick = function() {
                fareRulesModal.style.display = "none";
            }

            // Close modal when clicking outside of it
            window.onclick = function(event) {
                if (event.target == fareRulesModal) {
                    fareRulesModal.style.display = "none";
                }
            }

            if (results.length === 0) {
                resultsContainer.innerHTML = `
                    <div class="no-results">
                        <i class="fas fa-search fa-3x" style="color: var(--text-secondary); margin-bottom: 1rem;"></i>
                        <p>No flight results found. Please try another search.</p>
                    </div>`;
                return;
            }

            // Iterate over the results and create flight cards
            results.forEach(resultGroup => {
                resultGroup.forEach(result => {
                    if (result.FareDataMultiple && Array.isArray(result.FareDataMultiple)) {
                        result.FareDataMultiple.forEach(fareData => {
                            const flightCard = document.createElement('div');
                            flightCard.classList.add('flight-card');

                            const segment = result.Segments?.[0]?.[0];

                            flightCard.innerHTML = `
                                <div class="flight-details">
                                    <div class="airline-info">
                                        <h2>${fareData.FareSegments[0]?.AirlineName || 'Airline'}</h2>
                                        <p>Flight No: ${fareData.FareSegments[0]?.FlightNumber || 'N/A'}</p>
                                    </div>
                                    <div class="route-info">
                                        <p>${segment?.Origin?.AirportName || 'N/A'} (${segment?.Origin?.AirportCode || 'N/A'})</p>
                                        <p>to</p>
                                        <p>${segment?.Destination?.AirportName || 'N/A'} (${segment?.Destination?.AirportCode || 'N/A'})</p>
                                    </div>
                                    <div class="timing-info">
                                        <p>Departure: ${segment?.DepTime ? new Date(segment.DepTime).toLocaleString() : 'N/A'}</p>
                                        <p>Arrival: ${segment?.ArrTime ? new Date(segment.ArrTime).toLocaleString() : 'N/A'}</p>
                                    </div>
                                    <div class="fare-info">
                                        <p>Fare: ₹${fareData.Fare?.OfferedFare?.toLocaleString() || 'N/A'}</p>
                                        <p>Class: ${fareData.FareSegments[0]?.CabinClassName || 'N/A'}</p>
                                    </div>
                                    <div class="action-buttons">
                                        <button
                                           onclick="viewFlightDetails('${fareData.ResultIndex}')" 
                                           class="view-details-btn">
                                            <i class="fas fa-info-circle"></i> View Details
                                        </button>
                                        <button onclick="fetchFareRules('${fareData.ResultIndex}')" 
                                                class="fare-rules-btn">
                                            <i class="fas fa-file-alt"></i> Fare Rules
                                        </button>
                                    </div>
                                </div>
                            `;

                            resultsContainer.appendChild(flightCard);
                        });
                    }
                });
            });
        });
        function viewFlightDetails(resultIndex) {
    const traceId = sessionStorage.getItem('flightTraceId');
    const results = JSON.parse(sessionStorage.getItem('flightSearchResults')) || [];

    if (!traceId) {
        console.error('TraceId is not found in sessionStorage');
        return;
    }

    // Find the SrdvIndex for the specific resultIndex
    let srdvIndex = null;
    results.forEach(resultGroup => {
        resultGroup.forEach(result => {
            if (result.FareDataMultiple) {
                result.FareDataMultiple.forEach(fareData => {
                    if (fareData.ResultIndex === resultIndex) {
                        srdvIndex = fareData.SrdvIndex;
                    }
                });
            }
        });
    });

    // Ensure we have a valid SrdvIndex before making the API call
    if (!srdvIndex) {
        console.error('Unable to find SrdvIndex for the selected flight');
        alert('Error: Could not retrieve fare details for the selected flight.');
        return;
    }

    // Prepare payload for fareQuote API
    const payload = {
        EndUserIp: '1.1.1.1', // Replace with actual IP
        ClientId: '180133',
        UserName: 'MakeMy91',
        Password: 'MakeMy@910',
        SrdvType: 'MixAPI',
        SrdvIndex: srdvIndex,
        TraceId: traceId,
        ResultIndex: resultIndex
    };

    // Call the FareQuote API
    fetch('/flight/fareQutes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Store fare quote data in sessionStorage
            sessionStorage.setItem('fareQuoteData', JSON.stringify(data.fareQuote));
            sessionStorage.setItem('selectedFlightResultIndex', resultIndex);
            sessionStorage.setItem('selectedFlightTraceId', traceId);
         
            window.location.href = `/flight-booking?traceId=${traceId}&resultIndex=${resultIndex}`;


            // Redirect to the fare quote result page
            // window.location.href = `/flight-info?traceId=${traceId}&resultIndex=${resultIndex}`;
        } else {
            // Handle API error
            console.error('Fare Quote API Error:', data.message);
            alert(`Error fetching fare details: ${data.message}`);
        }
    })
    .catch(error => {
        console.error('Error fetching fare quote:', error);
        alert('An error occurred while fetching flight details.');
    });
}
     

        function fetchFareRules(resultIndex) {
    const results = JSON.parse(sessionStorage.getItem('flightSearchResults')) || [];
    const traceId = sessionStorage.getItem('flightTraceId');
    const fareRulesModal = document.getElementById('fareRulesModal');
    const fareRulesDetails = document.getElementById('fareRulesDetails');

    // Find the SrdvIndex for the specific resultIndex
    let srdvIndex = null;
    results.forEach(resultGroup => {
        resultGroup.forEach(result => {
            if (result.FareDataMultiple) {
                result.FareDataMultiple.forEach(fareData => {
                    if (fareData.ResultIndex === resultIndex) {
                        srdvIndex = fareData.SrdvIndex;
                    }
                });
            }
        });
    });

    // Show loading state
    fareRulesDetails.innerHTML = '<p>Loading fare rules...</p>';
    fareRulesModal.style.display = 'block';

    // Ensure we have a valid SrdvIndex before making the API call
    if (!srdvIndex) {
        fareRulesDetails.innerHTML = '<p>Unable to find SrdvIndex for the selected flight.</p>';
        return;
    }

    // Prepare payload for fare rules API
    const payload = {
        EndUserIp: '1.1.1.1', // Replace with actual IP
        ClientId: '180133',
        UserName: 'MakeMy91',
        Password: 'MakeMy@910',
        SrdvType: 'MixAPI', // This can also be dynamically extracted if needed
        SrdvIndex: srdvIndex,
        TraceId: traceId,
        ResultIndex: resultIndex
    };


            // Make API call to fetch fare rules
            fetch('flight/farerule', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(payload)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.fareRules) {
                    // Format and display fare rules
                    fareRulesDetails.innerHTML = `
                        <h2>Fare Rules for Flight</h2>
                        <p><strong>Airline:</strong> ${data.fareRules.Airline}</p>
                        <p><strong>Route:</strong> ${data.fareRules.Origin} to ${data.fareRules.Destination}</p>
                        <p><strong>Fare Basis Code:</strong> ${data.fareRules.FareBasisCode}</p>
                        <div class="fare-rule-details">
                            <h3>Fare Rule Details</h3>
                            <pre>${data.fareRules.FareRuleDetail}</pre>
                        </div>
                    `;
                } else {
                    fareRulesDetails.innerHTML = `<p>Unable to fetch fare rules: ${data.message || 'Unknown error'}</p>`;
                }
            })
            .catch(error => {
                console.error('Error fetching fare rules:', error);
                fareRulesDetails.innerHTML = `<p>Error fetching fare rules: ${error.message}</p>`;
            });
        }

  
    
    </script>
</body>
</html>