// STEP 1: At the top of your script, right after the DOMContentLoaded event listener starts,
// add these state variables:

document.addEventListener('DOMContentLoaded', function () {
    // Add these lines right here
    let selectedOutboundIndex = null;
    let selectedReturnIndex = null;

    const outboundFlights = JSON.parse(sessionStorage.getItem('outboundFlights')) || [];
    // ... rest of your existing variables


// STEP 2: In your renderFilteredResults function, find the section where you create the radio 
// container for outbound flights. Replace this section:

                const radioContainer = document.createElement('div');
                radioContainer.classList.add(
                    'absolute', 'top-4', 'right-4',
                    'w-6', 'h-6'
                );
                radioContainer.innerHTML = `
                    <input type="radio" 
                           name="outbound-flight" 
                           class="w-6 h-6 cursor-pointer "
                           value="${outboundFareData.ResultIndex}">
                `;

// With this updated version:

                const radioContainer = document.createElement('div');
                radioContainer.classList.add(
                    'absolute', 'top-4', 'right-4',
                    'w-6', 'h-6'
                );
                const isSelected = outboundFareData.ResultIndex === selectedOutboundIndex;
                radioContainer.innerHTML = `
                    <input type="radio" 
                           name="outbound-flight" 
                           class="w-6 h-6 cursor-pointer"
                           value="${outboundFareData.ResultIndex}"
                           ${isSelected ? 'checked' : ''}>
                `;

// STEP 3: Find the event listener for outbound flight selection and replace it with:

                flightCard.querySelector('input[type="radio"]').addEventListener('change', (e) => {
                    if (e.target.checked) {
                        selectedOutboundIndex = outboundFareData.ResultIndex;
                        selectedOutbound = {
                            resultIndex: outboundFareData.ResultIndex,
                            airline: outboundFareData.FareSegments[0]?.AirlineName,
                            flightNumber: outboundFareData.FareSegments[0]?.FlightNumber,
                            price: outboundFareData.Fare?.OfferedFare
                        };
                        updateSelectionDiv();
                    }
                });

// STEP 4: Similarly for return flights, replace the radio container creation with:

                const radioContainer = document.createElement('div');
                radioContainer.classList.add(
                    'absolute', 'top-4', 'right-4',
                    'w-6', 'h-6'
                );
                const isSelected = returnFareData.ResultIndex === selectedReturnIndex;
                radioContainer.innerHTML = `
                    <input type="radio" 
                           name="return-flight" 
                           class="w-6 h-6 cursor-pointer"
                           value="${returnFareData.ResultIndex}"
                           ${isSelected ? 'checked' : ''}>
                `;

// STEP 5: Update the return flight event listener:

                flightCard.querySelector('input[type="radio"]').addEventListener('change', (e) => {
                    if (e.target.checked) {
                        selectedReturnIndex = returnFareData.ResultIndex;
                        selectedReturn = {
                            resultIndex: returnFareData.ResultIndex,
                            airline: returnFareData.FareSegments[0]?.AirlineName,
                            flightNumber: returnFareData.FareSegments[0]?.FlightNumber,
                            price: returnFareData.Fare?.OfferedFare
                        };
                        updateSelectionDiv();
                    }
                });

// STEP 6: In your applyFilters function, update the round-trip handling section:

    if (journeyType === "2") {
        // Get the original flights from sessionStorage
        const originalOutboundFlights = JSON.parse(sessionStorage.getItem('outboundFlights')) || [];
        const originalReturnFlights = JSON.parse(sessionStorage.getItem('returnFlights')) || [];

        // Apply filters to both outbound and return flights
        const filteredOutbound = originalOutboundFlights.filter(filterFlight);
        const filteredReturn = originalReturnFlights.filter(filterFlight);

        // Check if selected flights still exist in filtered results
        const outboundExists = filteredOutbound.some(flight => 
            flight.FareDataMultiple?.some(fare => fare.ResultIndex === selectedOutboundIndex)
        );
        const returnExists = filteredReturn.some(flight => 
            flight.FareDataMultiple?.some(fare => fare.ResultIndex === selectedReturnIndex)
        );
        
        // Clear selections if flights no longer exist in filtered results
        if (!outboundExists) selectedOutboundIndex = null;
        if (!returnExists) selectedReturnIndex = null;

        // Clear the existing results container
        const resultsContainer = document.getElementById('results-container');
        resultsContainer.innerHTML = '';

        // Render the filtered results
        renderFilteredResults([filteredOutbound, filteredReturn], "2");

        // Update the results count
        const totalResults = filteredOutbound.length + filteredReturn.length;
        const resultsCountDisplay = document.getElementById('results-count');
        if (resultsCountDisplay) {
            resultsCountDisplay.textContent = `${totalResults} results`;
        }
    }