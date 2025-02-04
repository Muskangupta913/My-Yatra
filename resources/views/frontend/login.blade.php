// Find this section in your code and replace it:
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('traceId');
    const resultIndex = urlParams.get('resultIndex');
    const encodedDetails = urlParams.get('details');
    const origin = getCookie('origin');
    console.log(' ORIGIN Details:');
    console.log('ORIGIN:', origin);
      
    // Initialize the global passengerSelections object - ADD THIS
    window.passengerSelections = {
        seats: {},    
        meals: {},    
        baggage: {}   
    };

    // Rest of your cookie and passenger count code remains the same
    function getCookie(name) {
        // Your existing getCookie function remains unchanged
    }

    const adultCount = getCookie('adultCount');
    const childCount = getCookie('childCount');
    const infantCount = getCookie('infantCount');

    // Your existing createPassengerForm function remains mostly the same
    // But modify the SSR buttons to include proper IDs:
    function createPassengerForm(passengerType, count, typeValue) {
        for (let i = 1; i <= count; i++) {
            // ... existing code ...

            let ssrOptions = '';
            if (typeValue === 1 || typeValue === 2) { // Adult or Child
                ssrOptions = `
                    <div class="ssr-options mt-4">
                        <h6 class="mb-3">Additional Services</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-primary w-100 mb-2" 
                                    id="selectSeatBtn-${passengerType}-${i}">
                                    Select Seat
                                </button>
                                <div id="seatInfo-${passengerType}-${i}" class="small text-muted"></div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-primary w-100 mb-2" 
                                    id="meal-btn-${passengerType}-${i}">
                                    Select Meal
                                </button>
                                <div id="mealInfo-${passengerType}-${i}" class="small text-muted"></div>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-primary w-100 mb-2" 
                                    id="baggage-btn-${passengerType}-${i}">
                                    Select Baggage
                                </button>
                                <div id="baggageInfo-${passengerType}-${i}" class="small text-muted"></div>
                            </div>
                        </div>
                        <div id="options-container-${passengerType}-${i}" class="mt-3"></div>
                    </div>`;
            }
            // ... rest of function remains the same
        }
    }

    // MODIFY the fetchSSRData function:
    function fetchSSRData(type, index, passengerType) {
        if (!type || !index || !passengerType) {
            console.error('Missing required parameters:', { type, index, passengerType });
            return;
        }

        const passengerId = `${passengerType}-${index}`;
        const button = document.getElementById(`${type}-btn-${passengerId}`);
        
        if (button) {
            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Loading...';
        }

        fetch("{{ route('fetch.ssr.data') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                EndUserIp: '1.1.1.1',
                ClientId: '180133',
                UserName: 'MakeMy91',
                Password: 'MakeMy@910',
                SrdvType: "MixAPI",
                SrdvIndex: srdvIndex,
                TraceId: traceId,
                ResultIndex: resultIndex
            })
        })
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById(`options-container-${passengerId}`);
            
            if (!data.success) {
                container.innerHTML = `<p>Service not available: ${data.message || 'No details available'}</p>`;
                return;
            }

            if (type === 'baggage' && data.Baggage?.[0]?.length > 0) {
                renderBaggageOptions(data.Baggage[0], container, passengerId);
            } else if (type === 'meal' && data.MealDynamic?.[0]?.length > 0) {
                renderMealOptions(data.MealDynamic[0], container, passengerId);
            } else {
                container.innerHTML = `<p>No ${type} options available for this flight.</p>`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: `Failed to load ${type} options. Please try again.`
            });
        })
        .finally(() => {
            if (button) {
                button.disabled = false;
                button.innerHTML = `Select ${type.charAt(0).toUpperCase() + type.slice(1)}`;
            }
        });
    }

    // MODIFY the updateMealSelections function:
    window.updateMealSelections = function(checkbox, passengerId) {
        if (!window.passengerSelections.meals[passengerId]) {
            window.passengerSelections.meals[passengerId] = [];
        }

        const mealData = {
            Code: checkbox.value,
            AirlineDescription: checkbox.getAttribute('data-description'),
            Price: parseFloat(checkbox.getAttribute('data-price')) || 0,
            WayType: checkbox.getAttribute('data-wayType'),
            Quantity: parseInt(checkbox.closest('.meal-option').querySelector('.quantity-input')?.value || 1),
            Currency: checkbox.getAttribute('data-currency'),
            Description: checkbox.getAttribute('data-descript')
        };

        if (checkbox.checked) {
            window.passengerSelections.meals[passengerId].push(mealData);
        } else {
            window.passengerSelections.meals[passengerId] = 
                window.passengerSelections.meals[passengerId].filter(meal => meal.Code !== mealData.Code);
        }

        updateMealDisplay(passengerId);
        updateTotalFare();
    };

    // ADD this new function for total fare updates:
    function updateTotalFare() {
        const baseFare = parseFloat(document.getElementById('totalFare').value) || 0;
        let totalSSRCost = 0;

        // Calculate SSR costs
        Object.values(window.passengerSelections.seats).forEach(seat => {
            totalSSRCost += parseFloat(seat.amount) || 0;
        });

        Object.values(window.passengerSelections.baggage).forEach(baggage => {
            totalSSRCost += parseFloat(baggage.Price) || 0;
        });

        Object.values(window.passengerSelections.meals).forEach(meals => {
            meals.forEach(meal => {
                totalSSRCost += (parseFloat(meal.Price) || 0) * (parseInt(meal.Quantity) || 1);
            });
        });

        const grandTotal = baseFare + totalSSRCost;
        document.getElementById('totalFare').value = grandTotal.toFixed(2);
    }

    // MODIFY the selectSeat function:
    window.selectSeat = function(code, seatNumber, amount, airlineName, airlineCode, airlineNumber) {
        const modal = Swal.getPopup();
        if (!modal) return;
        
        const passengerId = modal.getAttribute('data-passenger-id');
        if (!passengerId) return;

        window.passengerSelections.seats[passengerId] = {
            code,
            seatNumber,
            amount: parseFloat(amount),
            airlineName,
            airlineCode,
            airlineNumber
        };

        const seatInfoElement = document.getElementById(`seatInfo-${passengerId}`);
        if (seatInfoElement) {
            seatInfoElement.textContent = `Selected: ${seatNumber} (₹${amount})`;
        }

        Swal.fire({
            icon: 'success',
            title: 'Seat Selected!',
            text: `Seat ${seatNumber} (₹${amount}) selected`,
            showConfirmButton: false,
            timer: 1500
        });

        updateTotalFare();
    };

    // Initialize the form
    function initializeForm() {
        const fareQuoteData = JSON.parse(sessionStorage.getItem('fareQuoteData'));
        if (fareQuoteData?.Fare?.OfferedFare) {
            document.getElementById('totalFare').value = fareQuoteData.Fare.OfferedFare;
        }
    }

    // Call initialization
    initializeForm();
});