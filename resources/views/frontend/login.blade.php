function createFilterSection(title, name, options) {
    if (name === 'airlines') {
        const optionsHTML = Array.from(options).map(airlineName => {
            // Find the airline code for this airline name
            let airlineCode = '';
            
            if (journeyType === "2") {
                // For round trips, check both outbound and return flights
                const outboundFlights = JSON.parse(sessionStorage.getItem('outboundFlights')) || [];
                const returnFlights = JSON.parse(sessionStorage.getItem('returnFlights')) || [];
                
                // First check outbound flights
                const outboundFlight = outboundFlights.find(flight => 
                    flight.FareDataMultiple?.some(fareData => 
                        fareData.FareSegments[0]?.AirlineName === airlineName
                    )
                );
                
                if (outboundFlight) {
                    const fareData = outboundFlight.FareDataMultiple.find(fd => 
                        fd.FareSegments[0]?.AirlineName === airlineName
                    );
                    airlineCode = fareData?.FareSegments[0]?.AirlineCode;
                }
                
                // If not found in outbound, check return flights
                if (!airlineCode) {
                    const returnFlight = returnFlights.find(flight => 
                        flight.FareDataMultiple?.some(fareData => 
                            fareData.FareSegments[0]?.AirlineName === airlineName
                        )
                    );
                    
                    if (returnFlight) {
                        const fareData = returnFlight.FareDataMultiple.find(fd => 
                            fd.FareSegments[0]?.AirlineName === airlineName
                        );
                        airlineCode = fareData?.FareSegments[0]?.AirlineCode;
                    }
                }
            } else {
                // For one-way flights
                for (const resultGroup of results) {
                    const flight = resultGroup.find(result => 
                        result.FareDataMultiple?.some(fareData => 
                            fareData.FareSegments[0]?.AirlineName === airlineName
                        )
                    );
                    
                    if (flight) {
                        const fareData = flight.FareDataMultiple.find(fd => 
                            fd.FareSegments[0]?.AirlineName === airlineName
                        );
                        airlineCode = fareData?.FareSegments[0]?.AirlineCode;
                        break;
                    }
                }
            }

            // Ensure we have a valid airline code, or use a default
            const logoPath = airlineCode ? getAirlineLogo(airlineCode) : '/assets/images/airlines/airlines/48_48/6E.png';

            return `
                <label class="flex items-center mb-3 hover:bg-gray-50 p-2 rounded">
                    <input type="checkbox" name="${name}" value="${airlineName}" class="mr-3">
                    <img src="${logoPath}" 
                         alt="${airlineName}" 
                         class="w-8 h-8 mr-3 object-contain"
                         onerror="this.onerror=null; this.src='/assets/images/airlines/airlines/48_48/6E.png'; this.classList.add('grayscale', 'opacity-70');">
                    <span class="text-sm">${airlineName}</span>
                </label>
            `;
        }).join('');
        
        return `
            <div class="mb-6">
                <h4 class="font-semibold mb-3 text-gray-700">${title}</h4>
                <div class="space-y-1">${optionsHTML}</div>
            </div>
        `;
    } else {
        // Original handling for other filter sections
        const optionsHTML = Array.from(options).map(option => `
            <label class="flex items-center mb-2">
                <input type="checkbox" name="${name}" value="${option}" class="mr-2">
                ${option}
            </label>
        `).join('');
        
        return `
            <div class="mb-4">
                <h4 class="font-semibold mb-2">${title}</h4>
                <div class="space-y-2">${optionsHTML}</div>
            </div>
        `;
    }
}