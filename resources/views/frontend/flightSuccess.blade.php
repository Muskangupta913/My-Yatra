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


             // Add this at the beginning of your script, after the DOMContentLoaded event listener



//one way code 

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

    // Use regex to extract IATA code (e.g., "BOM" from "(BOM)")
    let iataMatch = origin.match(/\((.*?)\)$/);
    let iataCode = iataMatch ? iataMatch[1] : "";

    // Remove long words and keep essential parts
    let shortOrigin = origin
        .replace(/\(.*?\)/g, '') // Remove anything inside parentheses
        .replace(/CHHATRAPATI SHIVAJI/i, "CSM") // Abbreviate common long names
        .trim(); // Remove extra spaces

    // Combine back with IATA code (if available)
    shortOrigin = iataCode ? `${shortOrigin} (${iataCode})` : shortOrigin;

    // Ensure it's within 32 characters
    return shortOrigin.length > 32 ? shortOrigin.substring(0, 29) + "..." : shortOrigin;
}
        // Get passenger counts from cookies with default values
        const origin = getCookie('origin') ;
        const shortenedOrigin = shortenOrigin(origin);

        // Log the values
        console.log('Payment Page - ORIGIN Details:');
        console.log('ORIGIN:', shortenedOrigin);
        // Check what type of booking we're processing
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

// end of one way code 

    });
</script>
        