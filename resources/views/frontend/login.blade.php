// Update the applyFilters function to handle both journey types
function applyFilters() {
    const journeyType = sessionStorage.getItem('journeyType') || "1";
    const selectedFilters = {
        airlines: getSelectedValues('airlines'),
        stops: getSelectedValues('stops'),
        departureTime: getSelectedValues('departure-time'),
        cabinClass: getSelectedValues('cabin-class'),
        baggage: getSelectedValues('baggage'),
        flightDuration: getSelectedValues('flight-duration'),
        minPrice: parseFloat(document.getElementById('min-price').value) || 0,
        maxPrice: parseFloat(document.getElementById('max-price').value) || Infinity
    };

    if (journeyType === "1") {
        // Single journey filtering (existing logic)
        const filteredResults = results.map(resultGroup => 
            resultGroup.filter(result => filterFlight(result, selectedFilters))
        );
        renderFilteredResults(filteredResults, journeyType);
    } else if (journeyType === "2") {
        // Round trip filtering
        const outboundFlights = JSON.parse(sessionStorage.getItem('outboundFlights')) || [];
        const returnFlights = JSON.parse(sessionStorage.getItem('returnFlights')) || [];

        // Filter outbound flights
        const filteredOutbound = outboundFlights.filter(flight => filterFlight(flight, selectedFilters));
        
        // Filter return flights
        const filteredReturn = returnFlights.filter(flight => filterFlight(flight, selectedFilters));

        // Store filtered results in session storage
        sessionStorage.setItem('filteredOutboundFlights', JSON.stringify(filteredOutbound));
        sessionStorage.setItem('filteredReturnFlights', JSON.stringify(filteredReturn));

        // Render the filtered results
        renderFilteredResults([filteredOutbound, filteredReturn], journeyType);
    }
}

// Separate the flight filtering logic into its own function
function filterFlight(flight, filters) {
    return flight.FareDataMultiple.some(fareData => {
        const segment = flight.Segments[0][0];
        const fareSegment = fareData.FareSegments[0];
        const departureTime = new Date(segment.DepTime);
        const duration = segment.Duration;

        // Airline filter
        const airlineMatch = filters.airlines.length === 0 || 
            filters.airlines.includes(fareSegment.AirlineName);

        // Price filter
        const priceMatch = fareData.Fare.OfferedFare >= filters.minPrice && 
            fareData.Fare.OfferedFare <= filters.maxPrice;

        // Stops filter
        const stopMatch = filters.stops.length === 0 || 
            filters.stops.some(stop => 
                (stop === 'Non-stop' && flight.Segments[0].length === 1) ||
                (stop !== 'Non-stop' && flight.Segments[0].length > 1)
            );

        // Departure time filter
        const departureTimeMatch = filters.departureTime.length === 0 || 
            (departureTime.getHours() < 12 && filters.departureTime.includes('Morning (Before 12 PM)')) ||
            (departureTime.getHours() >= 12 && filters.departureTime.includes('Evening (After 12 PM)'));

        // Cabin class filter
        const cabinClassMatch = filters.cabinClass.length === 0 || 
            filters.cabinClass.includes(fareSegment.CabinClassName);

        // Baggage filter
        const baggageMatch = filters.baggage.length === 0 || 
            filters.baggage.includes(fareSegment.Baggage);

        // Duration filter
        const durationMatch = filters.flightDuration.length === 0 || 
            filters.flightDuration.includes(
                duration <= 60 ? 'Short (≤ 1 hour)' :
                duration <= 120 ? 'Medium (1-2 hours)' :
                'Long (> 2 hours)'
            );

        return airlineMatch && priceMatch && stopMatch && 
               departureTimeMatch && cabinClassMatch && 
               baggageMatch && durationMatch;
    });
}

// Update the extractAdvancedFilters function to handle both journey types
function extractAdvancedFilters(results) {
    const journeyType = sessionStorage.getItem('journeyType') || "1";
    let flightsToFilter = [];

    if (journeyType === "1") {
        flightsToFilter = results.flat();
    } else if (journeyType === "2") {
        const outboundFlights = JSON.parse(sessionStorage.getItem('outboundFlights')) || [];
        const returnFlights = JSON.parse(sessionStorage.getItem('returnFlights')) || [];
        flightsToFilter = [...outboundFlights, ...returnFlights];
    }

    const filters = {
        airlines: new Set(),
        stops: new Set(),
        priceRange: { min: Infinity, max: -Infinity },
        departureTime: { early: [], late: [] },
        cabinClasses: new Set(),
        baggageOptions: new Set(),
        flightDurations: []
    };

    flightsToFilter.forEach(flight => {
        if (flight.FareDataMultiple) {
            flight.FareDataMultiple.forEach(fareData => {
                const segment = flight.Segments[0][0];
                const fareSegment = fareData.FareSegments[0];

                // Extract all filter options (existing logic)
                filters.airlines.add(fareSegment.AirlineName || 'Unknown');
                filters.stops.add(flight.Segments[0].length === 1 ? 'Non-stop' : `${flight.Segments[0].length - 1} Stop`);
                filters.priceRange.min = Math.min(filters.priceRange.min, fareData.Fare.OfferedFare);
                filters.priceRange.max = Math.max(filters.priceRange.max, fareData.Fare.OfferedFare);
                
                const departureTime = new Date(segment.DepTime);
                const hours = departureTime.getHours();
                if (hours < 12) filters.departureTime.early.push('Morning (Before 12 PM)');
                else filters.departureTime.late.push('Evening (After 12 PM)');

                filters.cabinClasses.add(fareSegment.CabinClassName || 'Unknown');
                filters.baggageOptions.add(fareSegment.Baggage || 'Unknown');

                const duration = segment.Duration;
                if (duration) {
                    filters.flightDurations.push(
                        duration <= 60 ? 'Short (≤ 1 hour)' :
                        duration <= 120 ? 'Medium (1-2 hours)' :
                        'Long (> 2 hours)'
                    );
                }
            });
        }
    });

    // Clean up filter sets
    filters.departureTime.early = [...new Set(filters.departureTime.early)].filter(Boolean);
    filters.departureTime.late = [...new Set(filters.departureTime.late)].filter(Boolean);
    filters.flightDurations = [...new Set(filters.flightDurations)];

    return filters;
}