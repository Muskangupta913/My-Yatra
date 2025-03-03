<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>Payment Successful</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5">
                <div class="card-header bg-success text-white">Payment Successful</div>

                <div class="card-body text-center">
                    <i class="fa fa-check-circle fa-5x text-success mb-3"></i>
                    <h2>Thank You!</h2>
                    <p class="lead">Your payment has been processed successfully.</p>
                    
                    <div class="mt-4">
                        <a href="index.html" class="btn btn-primary">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        console.log("DOM fully loaded - Starting processing...");
        
        // Check what type of booking we're processing
        const urlParams = new URLSearchParams(window.location.search);
        const flightDetailsStr = urlParams.get("details");
        const roomDetailsStr = urlParams.get("roomDetails");
        const traceId = urlParams.get("traceId");
        const busParams = urlParams.get("PassengerData");
        console.log('room details', roomDetailsStr);

         // Parse room details JSON
    
    console.log("Raw room details string:", roomDetailsStr);
    const roomDetails = roomDetailsStr ? JSON.parse(decodeURIComponent(roomDetailsStr)) : null;
    console.log("Room Details:", roomDetails);
    console.log("Room Childcount:", roomDetails.childCount);

    // Parse passenger details JSON with detailed logging
    const passengerDetailsStr = urlParams.get('passengerDetails');
    console.log("Raw passenger details string:", passengerDetailsStr);
        
        // Process the appropriate booking type
        if (flightDetailsStr) {
            console.log("Processing flight booking...");
            const bookingDetails = getBookingDetailsFromURL();
            if (bookingDetails) {
                fetchBalanceLogAndBookLCC();
            } else {
                console.error("Invalid flight booking details");
            }
        } 
        else if (roomDetailsStr) {
            console.log("Processing hotel booking...");
            const bookingData = getUrlParameters();
            console.log("Booking data:", bookingData);
            if (bookingData && bookingData.roomDetails && bookingData.passengerDetails) {
                processHotelBooking(bookingData);
            } else {
                console.error("Missing hotel booking details");
            }
        }
        else if (traceId && urlParams.get("bookingId") && urlParams.get("pnr")) {
            console.log("Processing GDS ticket...");
            fetchBalanceLogAndBookGDS();
        }
        else if (busParams) {
            console.log("Processing bus booking...");
            processBusBooking();
        }
        else {
            console.log("No specific booking details found - displaying payment confirmation only");
        }
    });

    // Function to process bus booking
    function processBusBooking() {
        const urlParams = new URLSearchParams(window.location.search);
        const traceId = urlParams.get('TraceId');
        const amount = urlParams.get("amount");
        const passengerDataStr = urlParams.get('PassengerData');
        const resultIndex = urlParams.get('ResultIndex');
        
        if (!traceId || !amount || !passengerDataStr) {
            console.error("Missing required bus booking parameters");
            return;
        }

        // Parse boarding and dropping points from sessionStorage
        let boardingPoint, droppingPoint, boardingPointId, droppingPointId;
        
        try {
            boardingPoint = JSON.parse(sessionStorage.getItem("BoardingPoint"));
            droppingPoint = JSON.parse(sessionStorage.getItem("DroppingPoint"));
            boardingPointId = boardingPoint ? boardingPoint.Id : null;
            droppingPointId = droppingPoint ? droppingPoint.Id : null;
        } catch (e) {
            console.error("Error parsing boarding/dropping points:", e);
        }

        // Parse the passenger data
        let passengerData;
        try {
            passengerData = JSON.parse(decodeURIComponent(passengerDataStr));
        } catch (e) {
            console.error("Error parsing passenger data:", e);
            return;
        }

        // First call the balance log API
        fetch(`/balance-log?TraceId=${traceId}&amount=${amount}`, {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const balanceLog = data.balanceLogs[0];
                
                if (balanceLog) {
                    // After successful balance log, prepare booking request
                    const bookingData = {
                        ResultIndex: resultIndex,
                        TraceId: traceId,
                        BoardingPointId: boardingPointId,
                        DroppingPointId: droppingPointId,
                        RefID: "1",
                        Passenger: [{
                            LeadPassenger: true,
                            PassengerId: 0,
                            Title: passengerData.Title,
                            FirstName: passengerData.FirstName,
                            LastName: passengerData.LastName,
                            Email: passengerData.Email,
                            Phoneno: passengerData.Phoneno,
                            Gender: passengerData.Gender,
                            IdType: null,
                            IdNumber: null,
                            Address: passengerData.Address,
                            Age: passengerData.Age,
                            Seat: passengerData.SeatDetails || passengerData.Seat
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
                } else {
                    throw new Error("No balance log found");
                }
            } else {
                throw new Error(data.errorMessage || "Balance log failed");
            }
        })
        .then(response => response.json())
        .then(bookingResult => {
            if (bookingResult.status === 'success') {
                console.log(`Bus Booking Successful - Ticket Number: ${bookingResult.data.TicketNo}`);
            } else {
                console.error(`Bus Booking Failed: ${bookingResult.message}`);
            }
        })
        .catch(error => {
            console.error("Bus booking error:", error);
        });
    }

    // HOTEL RELATED FUNCTIONS
    function getUrlParameters() {
        const urlParams = new URLSearchParams(window.location.search);

        // Parse room details JSON
        const roomDetailsStr = urlParams.get('roomDetails');
        let roomDetails = null;
        
        try {
            if (roomDetailsStr) {
                roomDetails = JSON.parse(decodeURIComponent(roomDetailsStr));
                console.log("Room Details:", roomDetails);
            }
        } catch (e) {
            console.error("Error parsing room details:", e);
        }

        // Parse passenger details JSON
        const passengerDetailsStr = urlParams.get('passengerDetails');
        let passengerDetails = [];
        
        try {
            if (passengerDetailsStr) {
                const decodedStr = decodeURIComponent(passengerDetailsStr);
                const parsedData = JSON.parse(decodedStr);
                
                if (Array.isArray(parsedData)) {
                    passengerDetails = parsedData;
                } else if (typeof parsedData === 'object' && parsedData !== null) {
                    passengerDetails = [parsedData];
                }
            }
        } catch (error) {
            console.error("Error parsing passenger details:", error);
        }

        return {
            hotelDetails: {
                traceId: urlParams.get('traceId'),
                resultIndex: urlParams.get('resultIndex'),
                hotelCode: urlParams.get('hotelCode'),
                hotelName: urlParams.get('hotelName')
            },
            roomDetails: roomDetails,
            passengerDetails: passengerDetails
        };
    }

    async function processHotelBooking(bookingData) {
        try {
            if (!bookingData || !bookingData.roomDetails || !bookingData.hotelDetails.traceId) {
                throw new Error('Missing required hotel booking data');
            }

            // Prepare balance payload
            const balancePayload = {
                amount: bookingData.roomDetails.OfferedPrice,
                TraceId: bookingData.hotelDetails.traceId
            };
            

            // Call Balance API
            const balanceResponse = await fetch('/balancelog', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(balancePayload),
            });

            const balanceData = await balanceResponse.json();
            
            if (!balanceData.success) {
                throw new Error(balanceData.errorMessage || 'Insufficient balance or payment failed.');
            }

            const hotelPassengers = bookingData.passengerDetails.map(passenger => ({
                Title: passenger.Title,
                FirstName: passenger.FirstName,
                LastName: passenger.LastName,
                Phoneno: passenger.Phoneno || "",
                Email: passenger.Email || "",
                PaxType: passenger.PaxType || "1",
                LeadPassenger: passenger.LeadPassenger || false,
                PAN: passenger.PAN || ""
            }));

            const roomDetail = {
                RoomId: bookingData.roomDetails.RoomId,
                RoomStatus: "Active",
                RoomIndex: bookingData.roomDetails.RoomIndex,
                RoomTypeCode: bookingData.roomDetails.RoomTypeCode,
                RoomTypeName: bookingData.roomDetails.RoomTypeName,
                RatePlanCode: bookingData.roomDetails.RatePlanCode,
                RatePlan: bookingData.roomDetails.RatePlan,
                InfoSource: bookingData.roomDetails.InfoSource || "",
                SequenceNo: bookingData.roomDetails.SequenceNo || "",
                SmokingPreference: "0",
                ChildCount: bookingData.roomDetails.childCount || 0,
                RequireAllPaxDetails: false,
                HotelPassenger: hotelPassengers,
                Currency: bookingData.roomDetails.Currency,
                OfferedPrice: bookingData.roomDetails.OfferedPrice
            };

            const bookingPayload = {
                ResultIndex: bookingData.hotelDetails.resultIndex,
                HotelCode: bookingData.hotelDetails.hotelCode,
                HotelName: bookingData.hotelDetails.hotelName,
                GuestNationality: "IN",
                NoOfRooms: bookingData.roomDetails.NoOfRooms || 1,
                ClientReferenceNo: 0,
                IsVoucherBooking: true,
                HotelRoomsDetails: [roomDetail],
                SrdvType: "MixAPI",
                SrdvIndex: "15",
                TraceId: bookingData.hotelDetails.traceId,
                EndUserIp: "1.1.1.1",
                ClientId: "180133",
                UserName: "MakeMy91",
                Password: "MakeMy@910"
            };
 console.log('payload data', bookingPayload);
            // Call Booking API
            const bookingResponse = await fetch('/book-room', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                body: JSON.stringify(bookingPayload),
            });

            const bookingDataResponse = await bookingResponse.json();
            
            if (!bookingDataResponse.success) {
                throw new Error(bookingDataResponse.errorMessage || 'Booking failed after successful payment.');
            }

            console.log("Hotel booking completed successfully:", bookingDataResponse.bookingDetails);
        } catch (error) {
            console.error('Error during hotel booking:', error);
        }
    }

    // FLIGHT RELATED FUNCTIONS
    function getCookie(name) {
        let nameEQ = name + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
            let c = ca[i].trim();
            if (c.indexOf(nameEQ) === 0) {
                return c.substring(nameEQ.length);
            }
        }
        return null;
    }

    function getBookingDetailsFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        const encodedDetails = urlParams.get('details');

        if (!encodedDetails) {
            console.error('No booking details found in URL');
            return null;
        }

        try {
            const flightDetails = JSON.parse(decodeURIComponent(encodedDetails));
            
            // Extract main booking details
            const {
                resultIndex,
                srdvIndex,
                traceId,
                totalFare,
                fare,
                grandTotal
            } = flightDetails;

            // Extract passengers
            const passengers = flightDetails.passengers || [];

            // Construct extracted details
            return {
                resultIndex,
                srdvIndex,
                traceId,
                totalFare,
                grandTotal,
                passengers: passengers.map(pax => ({
                    title: pax.title,
                    firstName: pax.firstName,
                    lastName: pax.lastName,
                    gender: pax.gender,
                    contactNo: pax.contactNo || "",
                    email: pax.email || "",
                    paxType: pax.paxType,
                    addressLine1: getCookie('origin') || "",
                    city: getCookie('origin') || "",
                    passportNo: pax.passportNo || "",
                    passportExpiry: pax.passportExpiry || "",
                    passportIssueDate: pax.passportIssueDate || "",
                    dateOfBirth: pax.dateOfBirth || "",
                    countryCode: "IN",
                    countryName: "INDIA",
                    selectedServices: {
                        seat: pax.selectedServices?.seat || null,
                        baggage: pax.selectedServices?.baggage || null,
                        meals: pax.selectedServices?.meals || []
                    }
                })),
                baseFare: fare?.baseFare,
                tax: fare?.tax,
                yqTax: fare?.yqTax,
                transactionFee: fare?.transactionFee,
                additionalTxnFeeOfrd: fare?.additionalTxnFeeOfrd,
                additionalTxnFeePub: fare?.additionalTxnFeePub,
                airTransFee: fare?.airTransFee
            };
        } catch (error) {
            console.error('Error parsing booking details:', error);
            return null;
        }
    }

    function fetchBalanceLogAndBookLCC() {
        const bookingDetails = getBookingDetailsFromURL();
        if (!bookingDetails?.traceId || !bookingDetails?.grandTotal) {
            console.error('Booking details are missing or incomplete!');
            return;
        }

        // Send as POST request with JSON body
        fetch('/flight/balance-log', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                TraceId: bookingDetails.traceId,
                amount: bookingDetails.grandTotal
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Balance log processed:', data.balanceLog);
                // Proceed with booking only if balance deduction was successful
                bookLCC(bookingDetails);
            } else {
                console.error(data.errorMessage || 'Failed to process balance log');
            }
        })
        .catch(error => {
            console.error('Balance log error:', error);
        });
    }

    function bookLCC(bookingDetails) {
        if (!bookingDetails || !bookingDetails.passengers || !Array.isArray(bookingDetails.passengers)) {
            console.error("Passenger details are missing or not in array format!");
            return;
        }

        // Prepare payload using extracted data
        const payload = {
            srdvIndex: bookingDetails.srdvIndex,
            traceId: bookingDetails.traceId,
            resultIndex: bookingDetails.resultIndex,

            // Map each passenger with all available details, including fare
            passenger: bookingDetails.passengers.map(pax => ({
                title: pax.title,
                firstName: pax.firstName,
                lastName: pax.lastName,
                gender: pax.gender,
                contactNo: pax.contactNo,
                email: pax.email,
                paxType: pax.paxType,
                dateOfBirth: pax.dateOfBirth,
                passportNo: pax.passportNo,
                passportExpiry: pax.passportExpiry,
                passportIssueDate: pax.passportIssueDate,
                addressLine1: pax.addressLine1,
                city: pax.city,
                countryCode: pax.countryCode,
                countryName: pax.countryName,

                // Handle baggage with null check
                baggage: pax.selectedServices?.baggage ? [{
                    Code: pax.selectedServices.baggage.Code,
                    Weight: pax.selectedServices.baggage.Weight,
                    Price: pax.selectedServices.baggage.Price,
                    Origin: pax.selectedServices.baggage.Origin,
                    Destination: pax.selectedServices.baggage.Destination,
                    WayType: pax.selectedServices.baggage.WayType,
                    Currency: pax.selectedServices.baggage.Currency
                }] : [],

                // Handle meals with null check
                mealDynamic: pax.selectedServices?.meals ? pax.selectedServices.meals.map(meal => ({
                    Code: meal.Code,
                    AirlineDescription: meal.AirlineDescription,
                    Price: meal.Price,
                    Origin: meal.Origin,
                    Destination: meal.Destination,
                    WayType: meal.WayType,
                    Quantity: meal.Quantity,
                    Currency: meal.Currency
                })) : [],

                // Handle seat with null check
                seat: pax.selectedServices?.seat ? [{
                    Code: pax.selectedServices.seat.code,
                    SeatNumber: pax.selectedServices.seat.seatNumber,
                    Amount: pax.selectedServices.seat.amount,
                    AirlineName: pax.selectedServices.seat.airlineName,
                    AirlineCode: pax.selectedServices.seat.airlineCode,
                    AirlineNumber: pax.selectedServices.seat.airlineNumber
                }] : [],

                // Assign individual fare for each passenger
                fare: {
                    baseFare: bookingDetails.baseFare,
                    tax: bookingDetails.tax,
                    yqTax: bookingDetails.yqTax,
                    transactionFee: parseFloat(bookingDetails.transactionFee || 0),
                    additionalTxnFeeOfrd: bookingDetails.additionalTxnFeeOfrd,
                    additionalTxnFeePub: bookingDetails.additionalTxnFeePub,
                    airTransFee: parseFloat(bookingDetails.airTransFee || 0)
                }
            }))
        };

        // Send booking request
        fetch('/flight/bookLCC', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log("Flight LCC booking successful!");
            } else {
                console.error("Flight LCC booking failure:", data);
            }
        })
        .catch(error => {
            console.error('Error during flight LCC booking:', error);
        });
    }

    function BookGdsTickte() {
        const queryParams = new URLSearchParams(window.location.search);
        const traceId = queryParams.get("traceId");
        const resultIndex = queryParams.get("resultIndex");
        const bookingId = queryParams.get("bookingId");
        const pnr = queryParams.get("pnr");
        const srdvIndex = queryParams.get("srdvIndex");
        const grandTotal = queryParams.get("grandTotal");

        if (traceId && resultIndex && bookingId && pnr && srdvIndex && grandTotal) {
            return { resultIndex, bookingId, pnr, srdvIndex, traceId, grandTotal };
        } else {
            console.error("Missing required parameters for GDS ticket booking.");
            return null;
        }
    }

    function fetchBalanceLogAndBookGDS() {
        const gdsTicketDetails = BookGdsTickte();
        
        if (!gdsTicketDetails) {
            console.error('Booking details are missing or incomplete!');
            return;
        }

        // Send as POST request with JSON body
        fetch('/flight/balance-log', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                TraceId: gdsTicketDetails.traceId,
                amount: gdsTicketDetails.grandTotal
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Balance log processed:', data.balanceLog);
                // Proceed with booking only if balance deduction was successful
                processGdsTicket(gdsTicketDetails);
            } else {
                console.error(data.errorMessage || 'Failed to process balance log');
            }
        })
        .catch(error => {
            console.error('Balance log error:', error);
        });
    }

    // Function to process the GDS Ticket booking
    function processGdsTicket(gdsTicketDetails) {
        const payload = {
            EndUserIp: "1.1.1.1",
            ClientId: "180133",
            UserName: "MakeMy91",
            Password: "MakeMy@910",
            srdvType: "MixAPI",
            srdvIndex: gdsTicketDetails.srdvIndex,
            traceId: gdsTicketDetails.traceId,
            pnr: gdsTicketDetails.pnr,
            bookingId: gdsTicketDetails.bookingId
        };

        fetch("/flight/bookGdsTicket", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                console.log("GDS ticket booking successful:", {
                    bookingId: data.data.bookingId,
                    pnr: data.data.pnr,
                    ticketStatus: data.data.ticketStatus
                });
            } else {
                console.error("GDS ticket booking failed:", data.message);
            }
        })
        .catch(error => {
            console.error("GDS ticket API error:", error);
        });
    }

   
</script>
</body>
</html>
