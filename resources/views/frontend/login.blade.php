// OLD CODE:
function fetchFareRules(resultIndex) {
    // REMOVE this block
    const results = JSON.parse(sessionStorage.getItem('flightSearchResults')) || [];
    const traceId = sessionStorage.getItem('flightTraceId');
    const fareRulesModal = document.getElementById('fareRulesModal');
    const fareRulesDetails = document.getElementById('fareRulesDetails');

    // REMOVE this block - old SrdvIndex search
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

// NEW CODE:
function fetchFareRules(resultIndex) {
    // ADD these lines
    const traceId = sessionStorage.getItem('flightTraceId');
    // ADD: Get journey type
    const journeyType = sessionStorage.getItem('journeyType');
    const fareRulesModal = document.getElementById('fareRulesModal');
    const fareRulesDetails = document.getElementById('fareRulesDetails');

    // ADD: Show loading state
    fareRulesDetails.innerHTML = '<p>Loading fare rules...</p>';
    fareRulesModal.style.display = 'block';

    let srdvIndex = null;

    // ADD: New journey type handling block
    if (journeyType === "2") {
        // Round-trip journey
        const outboundFlights = JSON.parse(sessionStorage.getItem('outboundFlights')) || [];
        const returnFlights = JSON.parse(sessionStorage.getItem('returnFlights')) || [];

        // Search in outbound flights
        outboundFlights.forEach(outbound => {
            if (outbound.FareDataMultiple && Array.isArray(outbound.FareDataMultiple)) {
                outbound.FareDataMultiple.forEach(fareData => {
                    if (fareData.ResultIndex === resultIndex) {
                        srdvIndex = fareData.SrdvIndex;
                    }
                });
            }
        });

        // If not found in outbound, search in return flights
        if (!srdvIndex) {
            returnFlights.forEach(returnFlight => {
                if (returnFlight.FareDataMultiple && Array.isArray(returnFlight.FareDataMultiple)) {
                    returnFlight.FareDataMultiple.forEach(fareData => {
                        if (fareData.ResultIndex === resultIndex) {
                            srdvIndex = fareData.SrdvIndex;
                        }
                    });
                }
            });
        }
    } else {
        // One-way journey - original code
        const results = JSON.parse(sessionStorage.getItem('flightSearchResults')) || [];
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
    }

    // Rest of your code remains the same...