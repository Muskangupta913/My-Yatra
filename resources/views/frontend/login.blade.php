public function blockRoom(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'ResultIndex' => 'required',
                'HotelCode' => 'required',
                'HotelName' => 'required',
                'GuestNationality' => 'required',
                'NoOfRooms' => 'required',
                'HotelRoomsDetails' => 'required|array',
                'HotelRoomsDetails.*.RoomId' => 'required',
                'HotelRoomsDetails.*.RoomIndex' => 'required',
                'HotelRoomsDetails.*.HotelPassenger' => 'required|array',
                'HotelRoomsDetails.*.HotelPassenger.*.Title' => 'required|in:Mr,Mrs,Ms',
                'HotelRoomsDetails.*.HotelPassenger.*.FirstName' => 'required',
                'HotelRoomsDetails.*.HotelPassenger.*.LastName' => 'required',
                'HotelRoomsDetails.*.HotelPassenger.*.Phoneno' => 'required',
                'HotelRoomsDetails.*.HotelPassenger.*.Email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 400);
            }

            // Merge client credentials with request data
            $requestBody = array_merge($request->all(), [
                "EndUserIp" => "1.1.1.1",
            "ClientId" => "180133",
            "UserName" => "MakeMy91",
            "Password" => "MakeMy@910"
            ]);

            // Call the booking API
            $response = Http::post($this->baseUrl . 'Book', $requestBody);

            if ($response->successful()) {
                $bookResult = $response->json()['BookResult'] ?? null;

                if ($bookResult && $bookResult['Status'] === 'Confirmed') {
                    // Log successful booking
                    Log::info('Successful Booking', [
                        'BookingRefNo' => $bookResult['BookingRefNo'],
                        'ConfirmationNo' => $bookResult['ConfirmationNo']
                    ]);

                    // You might want to save booking details to your database here
                    // $this->saveBookingToDatabase($bookResult, $request->all());

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Booking confirmed successfully',
                        'BookResult' => $bookResult
                    ]);
                }

                return response()->json([
                    'status' => 'error',
                    'message' => 'Booking failed',
                    'BookResult' => $bookResult
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to process booking',
                'error' => $response->json()
            ], $response->status());

        } catch (\Exception $e) {
            Log::error('Booking Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing the booking',
                'error' => $e->getMessage()
            ], 500);
        }
    }















    function bookRoom(roomId, roomIndex) {
    // Show modal with passenger form
    const modal = document.createElement('div');
    modal.className = 'modal';
    modal.innerHTML = `
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Enter Passenger Details</h2>
            <form id="passengerForm">
                <div class="passenger-container" id="passengerContainer">
                    <div class="passenger-entry">
                        <h3>Lead Passenger</h3>
                        <div class="form-group">
                            <select name="title" required>
                                <option value="Mr">Mr</option>
                                <option value="Mrs">Mrs</option>
                                <option value="Ms">Ms</option>
                            </select>
                            <input type="text" name="firstName" placeholder="First Name" required>
                            <input type="text" name="lastName" placeholder="Last Name" required>
                            <input type="email" name="email" placeholder="Email" required>
                            <input type="tel" name="phone" placeholder="Phone Number" required>
                            <input type="text" name="pan" placeholder="PAN Number (Optional)">
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addPassenger()">Add Another Passenger</button>
                <button type="submit">Block Room</button>
            </form>
        </div>
    `;

    document.body.appendChild(modal);

    // Close modal functionality
    const closeBtn = modal.querySelector('.close');
    closeBtn.onclick = function() {
        modal.remove();
    }

    // Form submission handler
    const form = modal.querySelector('#passengerForm');
    form.onsubmit = function(e) {
        e.preventDefault();
        blockRoom(roomId, roomIndex, form);
    }
}

function addPassenger() {
    const container = document.getElementById('passengerContainer');
    const passengerEntry = document.createElement('div');
    passengerEntry.className = 'passenger-entry';
    passengerEntry.innerHTML = `
        <h3>Additional Passenger</h3>
        <div class="form-group">
            <select name="title" required>
                <option value="Mr">Mr</option>
                <option value="Mrs">Mrs</option>
                <option value="Ms">Ms</option>
            </select>
            <input type="text" name="firstName" placeholder="First Name" required>
            <input type="text" name="lastName" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="phone" placeholder="Phone Number" required>
            <input type="text" name="pan" placeholder="PAN Number (Optional)">
        </div>
        <button type="button" class="remove-passenger" onclick="this.parentElement.remove()">Remove</button>
    `;
    container.appendChild(passengerEntry);
}

function blockRoom(roomId, roomIndex, form) {
    const urlParams = new URLSearchParams(window.location.search);
    const traceId = urlParams.get('traceId');
    const hotelCode = urlParams.get('hotelCode');
    const hotelName = document.querySelector('.hotel-name').textContent;

    // Collect all passenger entries
    const passengers = [];
    const passengerEntries = form.querySelectorAll('.passenger-entry');
    
    passengerEntries.forEach((entry, index) => {
        passengers.push({
            Title: entry.querySelector('select[name="title"]').value,
            FirstName: entry.querySelector('input[name="firstName"]').value,
            MiddleName: null,
            LastName: entry.querySelector('input[name="lastName"]').value,
            Phoneno: entry.querySelector('input[name="phone"]').value,
            Email: entry.querySelector('input[name="email"]').value,
            PaxType: "1",
            LeadPassenger: index === 0,
            PAN: entry.querySelector('input[name="pan"]').value || ""
        });
    });

    const requestBody = {
        ResultIndex: hotelCode,
        HotelCode: hotelCode,
        HotelName: hotelName,
        GuestNationality: "IN",
        NoOfRooms: "1",
        ClientReferenceNo: 0,
        IsVoucherBooking: true,
        HotelRoomsDetails: [{
            RoomId: roomId,
            RoomIndex: roomIndex,
            HotelPassenger: passengers
            // Add other required room details from your existing data
        }],
        SrdvType: "MixAPI",
        SrdvIndex: "15",
        TraceId: parseInt(traceId),
        EndUserIp: "1.1.1.1"
    };

    // Show loading state
    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.textContent = 'Blocking Room...';

    fetch('/block-room', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(requestBody)
    })
    .then(response => response.json())
    .then(data => {
        if (data.BookResult && data.BookResult.Status === 'Confirmed') {
            alert(`Booking Confirmed!\nBooking Reference: ${data.BookResult.BookingRefNo}`);
            // Close modal and refresh page or redirect to booking confirmation page
            form.closest('.modal').remove();
            // Optionally redirect to booking confirmation page
            // window.location.href = `/booking-confirmation/${data.BookResult.BookingRefNo}`;
        } else {
            alert('Booking failed: ' + (data.BookResult?.Error?.ErrorMessage || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing your booking. Please try again.');
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.textContent = 'Block Room';
    });
}








.then(data => {
        if (data.status === 'success') {
            const roomDetails = data.data.HotelRoomsDetails[0];
            
            // Show success message with room details
            const message = `
                Room blocked successfully!
                Hotel: ${data.data.HotelName}
                Room Type: ${roomDetails.RoomTypeName}
                Price: ${roomDetails.Price.CurrencyCode} ${roomDetails.Price.OfferedPriceRoundedOff}
                
                Do you want to proceed with booking?
            `;

            if (confirm(message)) {
                // Redirect to booking page with necessary parameters
                const bookingUrl = `/hotel/booking?` + new URLSearchParams({
                    traceId: traceId,
                    resultIndex: resultIndex,
                    hotelCode: hotelCode,
                    roomId: roomId,
                    roomIndex: roomIndex
                }).toString();
                
                window.location.href = bookingUrl;
            }
        } else {
            alert('Failed to block room: ' + (data.message || 'Unknown error'));
        }