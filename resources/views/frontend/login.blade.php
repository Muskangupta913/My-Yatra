
// failed process 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    function hideProcessingOverlay() {
        document.getElementById('processingOverlay').style.display = 'none';
    }

    // Retrieve boarding and dropping points from sessionStorage
    const boardingPoint = JSON.parse(sessionStorage.getItem("BoardingPoint"));
    const droppingPoint = JSON.parse(sessionStorage.getItem("DroppingPoint"));
    const boardingPointId = boardingPoint ? boardingPoint.Id : null;
    const droppingPointId = droppingPoint ? droppingPoint.Id : null;

    const urlParams = new URLSearchParams(window.location.search);
    const paymentId = urlParams.get('payment_id');
    const traceId = urlParams.get('trace_id');
    const amount = urlParams.get('amount');
    const resultIndex = urlParams.get('result_index');

    // Check if required parameters are present
    if (!paymentId || !traceId || !amount || !resultIndex) {
        // Redirect to failed page if missing parameters
        window.location.href = '/payments/failed?message=Missing+required+payment+parameters';
        throw new Error("Missing required payment parameters");
    }

    // Parse passenger data from URL parameters
    const passengerDataEntries = Array.from(urlParams.entries())
        .filter(([key]) => key.startsWith('passenger_data'));

    const passengerData = passengerDataEntries.reduce((acc, [key, value]) => {
        const parts = key.match(/passenger_data\[(\d+)\]\[([^\]]+)\](?:\[([^\]]+)\])?(?:\[([^\]]+)\])?/);
        
        if (parts) {
            const [, index, firstLevel, secondLevel, thirdLevel] = parts;
            
            acc[index] = acc[index] || {};
            
            if (!secondLevel) {
                acc[index][firstLevel] = value;
            } else if (!thirdLevel) {
                acc[index][firstLevel] = acc[index][firstLevel] || {};
                acc[index][firstLevel][secondLevel] = value;
            } else {
                acc[index][firstLevel] = acc[index][firstLevel] || {};
                acc[index][firstLevel][secondLevel] = acc[index][firstLevel][secondLevel] || {};
                acc[index][firstLevel][secondLevel][thirdLevel] = value;
            }
        }
        
        return acc;
    }, {});

    try {
        // Basic validation of passenger data
        if (!passengerData[0] || !passengerData[0].SeatDetails || !passengerData[0].SeatDetails.SeatNumber) {
            window.location.href = '/payments/failed?message=Invalid+passenger+data';
            throw new Error("Invalid passenger data");
        }
    } catch (error) {
        window.location.href = '/payments/failed?message=Error+parsing+passenger+data';
        throw error;
    }

    // Fetch balance log and proceed with booking
    fetch(`/balance-log?TraceId=${traceId}&amount=${amount}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
    .then(response => {
        if (!response.ok) {
            window.location.href = '/payments/failed?message=Balance+log+API+error';
            throw new Error("Balance log API error");
        }
        return response.json();
    })
    .then(data => {
        if (!data.success || !data.balanceLogs || !data.balanceLogs[0]) {
            window.location.href = '/payments/failed?message=No+balance+log+found';
            throw new Error("No balance log found");
        }
        
        // Prepare booking request
        const bookingData = {
            ResultIndex: resultIndex,
            TraceId: traceId,
            BoardingPointId: boardingPointId,
            DroppingPointId: droppingPointId,
            RefID: "1",
            Passenger: [{
                LeadPassenger: true,
                PassengerId: 0,
                Title: passengerData[0].Title,
                FirstName: passengerData[0].FirstName,
                LastName: passengerData[0].LastName,
                Email: passengerData[0].Email,
                Phoneno: passengerData[0].Mobile,
                Gender: passengerData[0].Gender,
                IdType: null,
                IdNumber: null,
                Address: passengerData[0].Address,
                Age: passengerData[0].Age,
                Seat: {
                    ColumnNo: passengerData[0].SeatDetails.SeatNumber,
                    Height: 1,
                    IsLadiesSeat: false,
                    IsMalesSeat: false,
                    IsUpper: passengerData[0].SeatDetails.Deck === 'Upper',
                    RowNo: "000",
                    SeatFare: parseFloat(amount),
                    SeatIndex: parseInt(passengerData[0].SeatDetails.SeatIndex),
                    SeatName: passengerData[0].SeatDetails.SeatName,
                    SeatStatus: true,
                    SeatType: passengerData[0].SeatDetails.SeatType === 'Seater' ? 1 : 0,
                    Width: 1,
                    Price: {
                        CurrencyCode: "INR",
                        BasePrice: parseFloat(amount),
                        Tax: 0,
                        OtherCharges: 0,
                        Discount: 0,
                        PublishedPrice: parseFloat(amount),
                        PublishedPriceRoundedOff: parseFloat(amount),
                        OfferedPrice: parseFloat(amount),
                        OfferedPriceRoundedOff: parseFloat(amount),
                        AgentCommission: 0,
                        AgentMarkUp: 0,
                        TDS: 0,
                        GST: {
                            CGSTAmount: 0,
                            CGSTRate: 0,
                            CessAmount: 0,
                            CessRate: 0,
                            IGSTAmount: 0,
                            IGSTRate: 18,
                            SGSTAmount: 0,
                            SGSTRate: 0,
                            TaxableAmount: 0
                        }
                    }
                }
            }]
        };

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Make the booking API call
        return fetch('/bookbus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(bookingData)
        });
    })
    .then(response => {
        if (!response.ok) {
            window.location.href = '/payments/failed?message=Booking+API+error';
            throw new Error("Booking API error");
        }
        return response.json();
    })
    .then(bookingResult => {
        if (bookingResult.status === 'success') {
            hideProcessingOverlay();
            alert(`Booking Successful!\nTicket Number: ${bookingResult.data.TicketNo}\nStatus: ${bookingResult.data.BusBookingStatus}`);
        } 
        else {
            // Redirect to failed page with error message
            window.location.href = `/payments/failed?message=${encodeURIComponent(bookingResult.message || "Booking failed")}`;
        }
    })
    .catch(error => {
        console.error("Error:", error);
        // If not already redirected, redirect to failed page
        if (window.location.pathname !== '/payments/failed') {
            window.location.href = `/payments/failed?message=${encodeURIComponent(error.message || "An unknown error occurred")}`;
        }
    });
</script>