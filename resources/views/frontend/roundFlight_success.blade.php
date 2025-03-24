
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
    console.log("Fare details being processed:", {
        baseFare: fareDetails.baseFare,
        tax: fareDetails.tax,
        yqTax: fareDetails.yqTax,
        transactionFee: fareDetails.transactionFee,
        additionalTxnFeeOfrd: fareDetails.additionalTxnFeeOfrd,
        additionalTxnFeePub: fareDetails.additionalTxnFeePub,
        airTransFee: fareDetails.airTransFee
    });


        return {
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
        const encodedDetails = new URLSearchParams(window.location.search).get('details');
        return encodedDetails ? JSON.parse(decodeURIComponent(encodedDetails)) : null;
    } catch (error) {
        console.error('Error parsing URL details:', error);
        return null;
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
document.addEventListener("DOMContentLoaded", async function(){
    event.preventDefault();

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
});
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

document.addEventListener("DOMContentLoaded", async function() {
    event.preventDefault();

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
});
});

</script>