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
    
    determineFlightTypes();


    function determineFlightTypes() {
    // Get both possible booking detail types from session storage
    const finalBookingDetailsStr = sessionStorage.getItem('finalBookingDetails');
    const bookingDetails = sessionStorage.getItem('bookingDetails');
    
    console.log("Session storage check:");
    console.log("- finalBookingDetails:", finalBookingDetailsStr ? "Found" : "Not found");
    console.log("- bookingDetails:", bookingDetails ? "Found" : "Not found");
    
    // Try to parse finalBookingDetails if it exists
    let finalBookingDetails = null;
    if (finalBookingDetailsStr && finalBookingDetailsStr !== "undefined" && finalBookingDetailsStr !== "null") {
        try {
            finalBookingDetails = JSON.parse(finalBookingDetailsStr);
            console.log("Parsed finalBookingDetails:", finalBookingDetails);
        } catch (error) {
            console.error("Error parsing finalBookingDetails:", error);
        }
    }
    
    // Check if we have valid round trip data (with lcc or nonLcc property)
    if (finalBookingDetails && (finalBookingDetails.lcc || finalBookingDetails.nonLcc)) {
        console.log("Processing round trip booking...");
        handleRoundTripBooking();
    } else if (bookingDetails && bookingDetails !== "undefined" && bookingDetails !== "null") {
        console.log("Processing one-way booking...");
        handleOneWayBooking();
    } else {
        console.error("No valid booking details found in session storage");
    }
}



        




        
        



        //start of one way flight code 
function handleOneWayBooking() {

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

        function shortenOrigin(origin) {
    if (!origin) return ""; // Handle empty values
    let iataMatch = origin.match(/\((.*?)\)$/);
    let iataCode = iataMatch ? iataMatch[1] : "";
    let shortOrigin = origin
        .replace(/\(.*?\)/g, '') // Remove anything inside parentheses
        .replace(/CHHATRAPATI SHIVAJI/i, "CSM") // Abbreviate common long names
        .trim(); // Remove extra spaces

    shortOrigin = iataCode ? `${shortOrigin} (${iataCode})` : shortOrigin;

    return shortOrigin.length > 32 ? shortOrigin.substring(0, 29) + "..." : shortOrigin;
}
        // Get passenger counts from cookies with default values
        const origin = getCookie('origin') ;
        const shortenedOrigin = shortenOrigin(origin);

        // Log the values

        console.log('Payment Page - ORIGIN Details:');
        console.log('ORIGIN:', shortenedOrigin);
    function determineBookingType() {
        // Check for LCC (Low Cost Carrier) booking details in session storage
        const flightDetailsStr = sessionStorage.getItem('bookingDetails');
        
        // Check for GDS ticket details in session storage
        const gdsDetailsStr = sessionStorage.getItem('successQueryParams');
        
        if (flightDetailsStr) {
            console.log("Processing flight booking (LCC)...");
            const bookingDetails = getBookingDetailsFromSession();
            if (bookingDetails) {
                fetchBalanceLogAndBookLCC();
            } else {
                console.error("Invalid flight booking details");
            }
        } else if (gdsDetailsStr) {
            console.log("Processing GDS ticket booking...");
            fetchBalanceLogAndBookGDS();
        } else {
            console.error("No booking details found in session storage");
        }
    }
    
    // Run the determination logic once the page is loaded
    determineBookingType();
     
        function getBookingDetailsFromSession() {
    // Get booking details from session storage instead of URL
    const bookingDetailsString = sessionStorage.getItem('bookingDetails');
    
    console.log('1. Raw booking details from session storage:', bookingDetailsString);

    if (!bookingDetailsString) {
        console.error('❌ No booking details found in session storage');
        return null;
    }

    try {
        const flightDetails = JSON.parse(bookingDetailsString);
        console.log('2. Parsed booking details:', flightDetails);

        // Extract main booking details
        const {
            resultIndex,
            srdvIndex,
            traceId,
            totalFare,
            fare,
            grandTotal
        } = flightDetails;

        // Extract passengers correctly
        const passengers = flightDetails.passengers || [];

        // Log each passenger's details
        passengers.forEach((pax, index) => {
            console.log(`3.${index + 1} Passenger Details:`, pax);
        });

        // Construct extracted details
        const extractedDetails = {
            resultIndex,
            srdvIndex,
            traceId,
            totalFare,
            grandTotal,

            // Passenger details as an array
            passengers: passengers.map((pax, index) => ({
                title: pax.title,
                firstName: pax.firstName,
                lastName: pax.lastName,
                gender: pax.gender,
                contactNo: pax.contactNo || "",
                email: pax.email || "",
                paxType: pax.paxType,
                addressLine1: shortenedOrigin|| "",
                city:shortenedOrigin || "",
                passportNo: pax.passportNo || "",
                passportExpiry: pax.passportExpiry || "",
                passportIssueDate: pax.passportIssueDate || "",
                dateOfBirth: pax.dateOfBirth || "",
                countryCode: "IN",
                countryName: "INDIA",

                // Selected services
                selectedServices: {
                    seat: pax.selectedServices?.seat || null,
                    baggage: pax.selectedServices?.baggage || null,
                    meals: pax.selectedServices?.meals || []
                }
            })),

            // Fare details
            baseFare: fare?.baseFare,
            tax: fare?.tax,
            yqTax: fare?.yqTax,
            transactionFee: fare?.transactionFee,
            additionalTxnFeeOfrd: fare?.additionalTxnFeeOfrd,
            additionalTxnFeePub: fare?.additionalTxnFeePub,
            airTransFee: fare?.airTransFee
        };

        // Log each passenger's extracted services separately
        extractedDetails.passengers.forEach((pax, index) => {
            console.log(`4.${index + 1} Passenger Selected Services:`, {
                seat: pax.selectedServices.seat,
                baggage: pax.selectedServices.baggage,
                meals: pax.selectedServices.meals
            });
        });

        console.log('5. Final Extracted Booking Details:', extractedDetails);

        return extractedDetails;
    } catch (error) {
        console.error('❌ Error parsing booking details:', error);
        return null;
    }
}

function fetchBalanceLogAndBookLCC() {
    const bookingDetails = getBookingDetailsFromSession();
    if (!bookingDetails?.traceId || !bookingDetails?.grandTotal) {
        showError('Booking details are missing or incomplete!');
        return;
    }

    console.log('Processing balance log for:', {
        traceId: bookingDetails.traceId,
        amount: bookingDetails.grandTotal
    });

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
            showError(data.errorMessage || 'Failed to process balance log');
        }
    })
    .catch(error => {
        console.error('Balance log error:', error);
        showError('Failed to process balance check. Please try again.');
    });
}

function bookLCC(bookingDetails) {
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

    console.log("✅ Final Payload Ready for Booking:", payload);

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
            alert('✅ Booking successful!');
            console.log("✅ Booking successful!");
        } else {
            alert('❌ Booking failed: ' + (data.message || 'Unknown error'));
            console.error("❌ Booking Failure:", data);
        }
    })
    .catch(error => {
        console.error('❌ Error:', error);
        alert('An error occurred during booking');
    });
}

function showError(message) {
    console.error('Error:', message);
    alert('❌ ' + message);
}

function getGdsTicketDetailsFromSession() {
    const successQueryParams = sessionStorage.getItem('successQueryParams');
    
    if (!successQueryParams) {
        console.error('❌ No GDS ticket details found in session storage');
        return null;
    }
    
    try {
        const params = JSON.parse(successQueryParams);
        const traceId = params.traceId;
        const resultIndex = params.resultIndex;
        const bookingId = params.bookingId;
        const pnr = params.pnr;
        const srdvIndex = params.srdvIndex;
        const grandTotal = params.grandTotal;

        console.log("Result Index:", resultIndex);
        console.log("Booking ID:", bookingId);
        console.log("PNR:", pnr);
        console.log("SRDV Index:", srdvIndex);
        console.log("Trace ID:", traceId);
        console.log("grandTotal:", grandTotal);

        if (traceId && resultIndex && bookingId && pnr && srdvIndex && grandTotal) {
            return { resultIndex, bookingId, pnr, srdvIndex, traceId, grandTotal };
        } else {
            console.error("❌ Missing required parameters for GDS ticket booking.");
            return null;
        }
    } catch (error) {
        console.error('❌ Error parsing GDS ticket details:', error);
        return null;
    }
}

function fetchBalanceLogAndBookGDS() {
    const gdsTicketDetails = getGdsTicketDetailsFromSession();
    
    if (!gdsTicketDetails) {
        console.error('❌ Booking details are missing or incomplete!');
        return;
    }

    console.log('🚀 Fetching Balance Log for:', {
        traceId: gdsTicketDetails.traceId,
        amount: gdsTicketDetails.grandTotal
    });

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
            showError(data.errorMessage || 'Failed to process balance log');
        }
    })
    .catch(error => {
        console.error('Balance log error:', error);
        showError('Failed to process balance check. Please try again.');
    });
}

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

    console.log("Sending payload:", payload);

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
        console.log("API Response:", data);
        if (data.status === "success") {
            console.log("Booking successful:", {
                bookingId: data.data.bookingId,
                pnr: data.data.pnr,
                ticketStatus: data.data.ticketStatus,
                passengers: data.data.passengers
            });
        } else {
            console.error("Booking failed:", data.message);
        }
    })
    .catch(error => {
        console.error("API Error:", error);
    });
}
}

//end of one way code 


//start of round trip code
 async function handleRoundTripBooking() {

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

        function shortenOrigin(origin) {
    if (!origin) return ""; // Handle empty values
    let iataMatch = origin.match(/\((.*?)\)$/);
    let iataCode = iataMatch ? iataMatch[1] : "";
    let shortOrigin = origin
        .replace(/\(.*?\)/g, '') // Remove anything inside parentheses
        .replace(/CHHATRAPATI SHIVAJI/i, "CSM") // Abbreviate common long names
        .trim(); // Remove extra spaces

    shortOrigin = iataCode ? `${shortOrigin} (${iataCode})` : shortOrigin;

    return shortOrigin.length > 32 ? shortOrigin.substring(0, 29) + "..." : shortOrigin;
}
        // Get passenger counts from cookies with default values
        const origin = getCookie('origin') ;
        const shortenedOrigin = shortenOrigin(origin);

        // Log the values

        console.log('Payment Page - ORIGIN Details:');
        console.log('ORIGIN:', shortenedOrigin);
function getBookingDetailsFromURL() {
            try {
        const storedDetails = sessionStorage.getItem('finalBookingDetails');
        if (!storedDetails) {
            console.error('❌ No booking details found in sessionStorage');
            return null;
        }
        
        const bookingDetails = JSON.parse(storedDetails);
        console.log('1. Retrieved booking details from session:', bookingDetails);
        
        let extractedFlights = {
            lcc: {
                outbound: null,
                return: null
            },
            nonLcc: []
        };
        
        // Process LCC flights if present
        if (bookingDetails.lcc) {
            // Process outbound LCC flight
            if (bookingDetails.lcc.outbound) {
                const farePax = bookingDetails.lcc.outbound.passengers[0]?.fare?.[0] || {};
                
                extractedFlights.lcc.outbound = {
                    resultIndex: bookingDetails.lcc.outbound.resultIndex,
                    srdvIndex: bookingDetails.lcc.outbound.srdvIndex,
                    traceId: bookingDetails.lcc.outbound.traceId,
                    totalFare: bookingDetails.lcc.outbound.totalFare,
                    baseFare: farePax.baseFare || 0,
                    tax: farePax.tax || 0,
                    yqTax: farePax.yqTax || 0,
                    transactionFee: farePax.transactionFee || '0',
                    additionalTxnFeeOfrd: farePax.additionalTxnFeeOfrd || 0,
                    additionalTxnFeePub: farePax.additionalTxnFeePub || 0,
                    airTransFee: farePax.airTransFee || '0',
                    passengers: bookingDetails.lcc.outbound.passengers.map((pax, index) => ({
                        title: pax.title,
                        firstName: pax.firstName,
                        lastName: pax.lastName,
                        gender: pax.gender,
                        contactNo: pax.contactNo || "",
                        email: pax.email || "",
                        paxType: pax.paxType,
                        addressLine1: shortenedOrigin,
                        city: shortenedOrigin,
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
                        },
                        totalSSRCost: pax.totalSSRCost || 0,
                        fare: pax.fare || []
                    }))
                };
            }

            // Process return LCC flight
            if (bookingDetails.lcc.return) {
                const farePax = bookingDetails.lcc.return.passengers[0]?.fare?.[0] || {};
                
                extractedFlights.lcc.return = {
                    resultIndex: bookingDetails.lcc.return.resultIndex,
                    srdvIndex: bookingDetails.lcc.return.srdvIndex,
                    traceId: bookingDetails.lcc.return.traceId,
                    totalFare: bookingDetails.lcc.return.totalFare,
                    baseFare: farePax.baseFare || 0,
                    tax: farePax.tax || 0,
                    yqTax: farePax.yqTax || 0,
                    transactionFee: farePax.transactionFee || '0',
                    additionalTxnFeeOfrd: farePax.additionalTxnFeeOfrd || 0,
                    additionalTxnFeePub: farePax.additionalTxnFeePub || 0,
                    airTransFee: farePax.airTransFee || '0',
                    passengers: bookingDetails.lcc.return.passengers.map((pax, index) => ({
                        title: pax.title,
                        firstName: pax.firstName,
                        lastName: pax.lastName,
                        gender: pax.gender,
                        contactNo: pax.contactNo || "",
                        email: pax.email || "",
                        paxType: pax.paxType,
                        addressLine1: destination,
                        city: destination,
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
                        },
                        totalSSRCost: pax.totalSSRCost || 0,
                        fare: pax.fare || []
                    }))
                };
            }
        }

        // Process non-LCC flights if present
        if (bookingDetails.nonLcc) {
            extractedFlights.nonLcc = bookingDetails.nonLcc;
        }

        // Log detailed information
        console.log('2. Extracted LCC Outbound Flight:', extractedFlights.lcc.outbound);
        console.log('3. Extracted LCC Return Flight:', extractedFlights.lcc.return);
        console.log('4. Extracted Non-LCC Flights:', extractedFlights.nonLcc);

        // Log passenger details for each flight
        if (extractedFlights.lcc.outbound) {
            extractedFlights.lcc.outbound.passengers.forEach((pax, index) => {
                console.log(`5. Outbound LCC Passenger ${index + 1}:`, {
                    basic: {
                        name: `${pax.title} ${pax.firstName} ${pax.lastName}`,
                        type: pax.paxType
                    },
                    services: pax.selectedServices,
                    ssrCost: pax.totalSSRCost
                });
            });
        }

        if (extractedFlights.lcc.return) {
            extractedFlights.lcc.return.passengers.forEach((pax, index) => {
                console.log(`6. Return LCC Passenger ${index + 1}:`, {
                    basic: {
                        name: `${pax.title} ${pax.firstName} ${pax.lastName}`,
                        type: pax.paxType
                    },
                    services: pax.selectedServices,
                    ssrCost: pax.totalSSRCost
                });
            });
        }

        return extractedFlights;
    } catch (error) {
        console.error('❌ Error parsing booking details from session:', error);
        return null;
    }
}


async function processBalanceLog(flightData) {
        if (!flightData) {
            console.error('❌ No flight data provided for balance log processing');
            return false;
        }

        const bookingDetails = getBookingDetailsFromURL();


        try {
            const traceId = flightData.traceId;
            const amount = bookingDetails.grandTotal;

            if (!traceId) {
                console.error('❌ Missing traceId for balance log');
                return false;
            }

            console.log('🚀 Processing balance log for:', {
                traceId: traceId,
                amount: amount
            });

            const response = await fetch('/flight/balance-log', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    TraceId: traceId,
                    amount: amount
                })
            });

            const data = await response.json();
            
            if (data.success) {
                console.log('✅ Balance log processed successfully:', data.balanceLog);
                return true;
            } else {
                console.error('❌ Balance log processing failed:', data.errorMessage || 'Unknown error');
                return false;
            }
        } catch (error) {
            console.error('❌ Error during balance log processing:', error);
            return false;
        }
    }


async function bookLCC() {
    const bookingDetails = getBookingDetailsFromURL();

    if (!bookingDetails || !bookingDetails.lcc) {
        console.error("❌ No valid LCC booking details found!");
        return;
    }

    console.log("🚀 Full Booking Details:", bookingDetails);

    // Function to create payload for a single flight
    const createFlightPayload = (flightDetails) => {
        if (!flightDetails || !flightDetails.passengers || !Array.isArray(flightDetails.passengers)) {
            console.error("❌ Invalid flight details!");
            return null;
        }
        const fareDetails = flightDetails.passengers[0]?.fare?.[0] || {};
        // Log fare details for debugging
        // Log fare details for debugging
    // console.log("Grand Total Value:", {
    //     grandTotal:  bookingDetails.grandTotal,
       
    // });


        return {
            grandTotal:  bookingDetails.grandTotal,
            srdvIndex: flightDetails.srdvIndex,
            traceId: flightDetails.traceId,
            resultIndex: flightDetails.resultIndex,
            totalFare: flightDetails.totalFare,
            passenger: flightDetails.passengers.map(pax => ({
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

                baggage: pax.selectedServices?.baggage ? [{
                    Code: pax.selectedServices.baggage.Code,
                    Weight: pax.selectedServices.baggage.Weight,
                    Price: pax.selectedServices.baggage.Price,
                    Origin: pax.selectedServices.baggage.Origin,
                    Destination: pax.selectedServices.baggage.Destination,
                    WayType: pax.selectedServices.baggage.WayType,
                    Currency: pax.selectedServices.baggage.Currency
                }] : [],

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

                seat: pax.selectedServices?.seat ? [{
                    Code: pax.selectedServices.seat.code,
                    SeatNumber: pax.selectedServices.seat.seatNumber,
                    Amount: pax.selectedServices.seat.amount,
                    AirlineName: pax.selectedServices.seat.airlineName,
                    AirlineCode: pax.selectedServices.seat.airlineCode,
                    AirlineNumber: pax.selectedServices.seat.airlineNumber
                }] : [],
                fare: {
            baseFare: fareDetails.baseFare || 0,
            tax: fareDetails.tax || 0,
            yqTax: fareDetails.yqTax || 0,
            transactionFee: fareDetails.transactionFee || '0',
            additionalTxnFeeOfrd: fareDetails.additionalTxnFeeOfrd || 0,
            additionalTxnFeePub: fareDetails.additionalTxnFeePub || 0,
            airTransFee: fareDetails.airTransFee || '0'
        }
            })),
            
        };
    };


    // Book outbound flight
    try {
        const promises = [];

        // Process outbound flight
        if (bookingDetails.lcc.outbound) {
            const outboundPromise = (async () => {
                const balanceLogSuccess = await processBalanceLog(bookingDetails.lcc.outbound);
                if (!balanceLogSuccess) {
                        throw new Error("Failed to process balance log for outbound flight");
                    }
                const outboundPayload = createFlightPayload(bookingDetails.lcc.outbound);
                if (!outboundPayload) return false;

                const response = await fetch('/flight/bookLCC', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(outboundPayload)
                });
                const data = await response.json();
                if (data.status !== 'success') {
                    throw new Error(`Outbound booking failed: ${data.message}`);
                }
                return true;
            })();
            promises.push(outboundPromise);
        }

        // Process return flight
        if (bookingDetails.lcc.return) {
            const returnPromise = (async () => {
                const returnPayload = createFlightPayload(bookingDetails.lcc.return);
                if (!returnPayload) return false;
                const balanceLogSuccess = await processBalanceLog(bookingDetails.lcc.return);
                if (!balanceLogSuccess) {
                        throw new Error("Failed to process balance log for outbound flight");
                    }

                const response = await fetch('/flight/bookLCC', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify(returnPayload)
                });
                const data = await response.json();
                if (data.status !== 'success') {
                    throw new Error(`Return booking failed: ${data.message}`);
                }
                return true;
            })();
            promises.push(returnPromise);
        }

        // Wait for all promises to resolve
        const results = await Promise.all(promises);
        return results.every(result => result === true);

    } catch (error) {
        console.error("❌ Error in LCC booking:", error);
        throw error;
    }
}





function BookGdsTicket() {
    try {
        // Get booking details from sessionStorage
        const storedDetails = sessionStorage.getItem('bookingDetails');
        if (!storedDetails) {
            console.error('No booking details found in sessionStorage');
            return null;
        }

        // Parse the stored details (which should be an array)
        const bookingDetailsArray = JSON.parse(storedDetails);
        if (!Array.isArray(bookingDetailsArray) || bookingDetailsArray.length === 0) {
            console.error('Invalid or empty booking details array');
            return null;
        }

        // For demonstration, we'll return the first booking detail
        // You might want to add logic to handle multiple bookings if needed
        return bookingDetailsArray[0];
    } catch (error) {
        console.error('Error processing booking details:', error);
        return null;
    }
}


async function bookGDS() {
    const bookingDetails = getBookingDetailsFromURL();

    const gdsTicketDetails = BookGdsTicket();

        // console.log('gdsticket deatilss',gdsTicketDetails);
        // console.log('Outbound Booking ID:', bookingDetails.nonLcc.outbound.bookingId);
        // console.log('Return Booking ID:', bookingDetails.nonLcc.return.bookingId);


    if (!gdsTicketDetails) {
        console.error("Missing required parameters for GDS ticket booking.");
        return;
    }

    
    // Destructuring with default values
 

    // if (!bookingDetails || !bookingDetails.nonLcc) {
    //     console.error("❌ No valid GDS booking details found!");
    //     return;
    // }

    console.log("🚀 Full GDS Booking Details:", bookingDetails);

    // Function to create payload for a single GDS flight
    const createGDSPayload = (flightDetails) => {
        if (!flightDetails || !flightDetails.bookingId || !flightDetails.pnr) {
            console.error("❌ Invalid GDS flight details!");
            return null;
        }

        

    };

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    if (!csrfToken) {
        console.error("❌ CSRF token not found!");
        return;
    }

    

    try {
        const promises = [];

        // Process outbound flight
        if (bookingDetails.nonLcc.outbound) {
            const outboundPromise = (async () => {
                const payload = {
                    EndUserIp: "1.1.1.1",
                    ClientId: "180133",
                    UserName: "MakeMy91",
                    Password: "MakeMy@910",
                    srdvType: "MixAPI",
                    srdvIndex: bookingDetails.nonLcc.outbound.srdvIndex,
                    traceId: bookingDetails.nonLcc.outbound.traceId,
                    pnr: bookingDetails.nonLcc.outbound.pnr,
                    bookingId: bookingDetails.nonLcc.outbound.bookingId
                };

                console.log('outbound payload data',payload);

                const response = await fetch('/flight/bookGdsTicket', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(payload)
                });
                const data = await response.json();
                if (data.status !== 'success') {
                    throw new Error(`GDS outbound booking failed: ${data.message}`);
                }
                return true;
            })();
            promises.push(outboundPromise);
        }

        // Process return flight
        if (bookingDetails.nonLcc.return) {
            const returnPromise = (async () => {
                const payload = {
                    EndUserIp: "1.1.1.1",
                    ClientId: "180133",
                    UserName: "MakeMy91",
                    Password: "MakeMy@910",
                    srdvType: "MixAPI",
                    srdvIndex: bookingDetails.nonLcc.return.srdvIndex,
                    traceId: bookingDetails.nonLcc.return.traceId,
                    pnr: bookingDetails.nonLcc.return.pnr,
                    bookingId: bookingDetails.nonLcc.return.bookingId
                };
                console.log('return payload data',payload);


                const response = await fetch('/flight/bookGdsTicket', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(payload)
                });
                const data = await response.json();
                if (data.status !== 'success') {
                    throw new Error(`GDS return booking failed: ${data.message}`);
                }
                return true;
            })();
            promises.push(returnPromise);
        }

        // Wait for all promises to resolve
        const results = await Promise.all(promises);
        return results.every(result => result === true);

    } catch (error) {
        console.error("❌ Error in GDS booking:", error);
        throw error;
    }


    // If no GDS flights were processed, log a warning
    if (!bookingDetails.nonLcc.outbound && !bookingDetails.nonLcc.return) {
        console.warn("⚠️ No GDS flights found to process");
        return;
    }

    return true;
}


// Helper function to get booking details from URL
function getBookingDetailsFromURL() {
    try {
        const storedDetails = sessionStorage.getItem('finalBookingDetails');
        if (!storedDetails) {
            console.error('❌ No booking details found in sessionStorage');
            return null;
        }
        return JSON.parse(storedDetails); // Parsing the stored JSON data
    } catch (error) {
        console.error('⚠️ Error retrieving booking details:', error);
        return null;
    } finally {
        console.log('ℹ️ getBookingDetailsFromURL() execution completed.');
    }
}



async function executeLCCBooking(bookingDetails) {
    if (!bookingDetails?.lcc) {
        console.log("No LCC flights to book");
        return null;
    }
    console.log("🚀 Executing LCC booking");
    return bookLCC();
}

// Helper function to execute GDS booking if needed
async function executeGDSBooking(bookingDetails) {
    if (!bookingDetails?.nonLcc) {
        console.log("No GDS flights to book");
        return null;
    }
    console.log("🚀 Executing GDS booking");
    return bookGDS();
}

// Dummy function for LCC booking
// function bookLCC(bookingDetails) {
//     console.log("Processing LCC flight booking:", bookingDetails);
// }

// Event listener for the "Pay Now" button


    try {
        // Get booking details from URL
        const bookingDetails = getBookingDetailsFromURL();
        if (!bookingDetails) {
            throw new Error("No valid booking details found");
        }

        console.log("Starting parallel booking process...");

        try {
            // Execute both LCC and GDS bookings in parallel
            const [lccResult, gdsResult] = await Promise.all([
                executeLCCBooking(bookingDetails),
                executeGDSBooking(bookingDetails)
            ]);

            console.log("Booking Results:", {
                lcc: lccResult,
                gds: gdsResult
            });

            // Handle success cases
            if (bookingDetails.lcc && !lccResult) {
                throw new Error("LCC booking failed");
            }
            if (bookingDetails.nonLcc && !gdsResult) {
                throw new Error("GDS booking failed");
            }

            // If we reach here, all required bookings were successful
            console.log("✅ All bookings completed successfully");
            // Redirect or show success message
            // window.location.href = '/booking/confirmation';

        } catch (error) {
            console.error("❌ Error during parallel booking:", error);
            throw new Error(`Booking failed: ${error.message}`);
        }

    } catch (error) {
        console.error("Booking error:", error);
        alert(`Error during booking: ${error.message}`);
    }

async function executeLCCBooking(bookingDetails) {
    if (!bookingDetails?.lcc) {
        console.log("No LCC flights to book");
        return null;
    }
    console.log("🚀 Executing LCC booking");
    return bookLCC();
}

// Helper function to execute GDS booking if needed
async function executeGDSBooking(bookingDetails) {
    if (!bookingDetails?.nonLcc) {
        console.log("No GDS flights to book");
        return null;
    }
    console.log("🚀 Executing GDS booking");
    return bookGDS();
}


    try {
        // Get booking details from URL
        const bookingDetails = getBookingDetailsFromURL();
        if (!bookingDetails) {
            throw new Error("No valid booking details found");
        }

        console.log("Starting parallel booking process...");

        try {
            // Execute both LCC and GDS bookings in parallel
            const [lccResult, gdsResult] = await Promise.all([
                executeLCCBooking(bookingDetails),
                executeGDSBooking(bookingDetails)
            ]);

            console.log("Booking Results:", {
                lcc: lccResult,
                gds: gdsResult
            });

            // Handle success cases
            if (bookingDetails.lcc && !lccResult) {
                throw new Error("LCC booking failed");
            }
            if (bookingDetails.nonLcc && !gdsResult) {
                throw new Error("GDS booking failed");
            }

            // If we reach here, all required bookings were successful
            console.log("✅ All bookings completed successfully");
            // Redirect or show success message
            // window.location.href = '/booking/confirmation';

        } catch (error) {
            console.error("❌ Error during parallel booking:", error);
            throw new Error(`Booking failed: ${error.message}`);
        }

    } catch (error) {
        console.error("Booking error:", error);
        alert(`Error during booking: ${error.message}`);
    }

}
        

// end of round trip code

  });




</script>
        