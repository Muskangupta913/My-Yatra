public function getHotelDetails(Request $request)
{
    $request->validate([
        'ResultIndex' =>  'required|integer',
    ]);

    $payload = [
        "ClientId" => "180133",
        "UserName" => "MakeMy91",
        "Password" => "MakeMy@910",
        "EndUserIp" => "1.1.1.1",
        "SrdvIndex" => "15",
        "SrdvType" => "MixAPI",
        "ResultIndex" => $request->input('resultIndex'),
        "TraceId" => $request->input('traceId', '12207'),
        "HotelCode" => $request->input('hotelCode', 'hsid3359333842-15079424'),
    ];

    try {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Api-Token' => 'MakeMy@910@23'
        ])->post('https://hotel.srdvtest.com/v5/rest/GetHotelInfo', $payload);

        if ($response->failed()) {
            return response()->json([
                'status' => 'error',
                'message' => 'External API request failed',
                'errorDetails' => $response->body(),
            ], 500);
        }

        $apiResponse = $response->json();

        if (!isset($apiResponse['HotelInfoResult']) || $apiResponse['HotelInfoResult']['Error']['ErrorCode'] !== 0) {
            return response()->json([
                'status' => 'error',
                'message' => $apiResponse['HotelInfoResult']['Error']['ErrorMessage'] ?? 'Unexpected API response',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'hotelDetails' => $apiResponse['HotelInfoResult']['HotelDetails'] ?? [],
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch hotel details',
            'exceptionMessage' => $e->getMessage(),
        ], 500);
    }
}






function viewHotelDetails(resultIndex) {
    fetch('/hotel-details', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            resultIndex: resultIndex
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.text(); // Get raw response text
    })
    .then(text => {
        console.log('Raw Response:', text);
        try {
            const data = JSON.parse(text); // Attempt to parse JSON
            console.log('Parsed Data:', data);

            if (data.status !== 'success') {
                throw new Error(data.message || 'Failed to fetch hotel details');
            }

            // Success: Handle/display hotel details
            console.log('Hotel Details:', data.hotelDetails);
        } catch (error) {
            console.error('JSON Parsing Error:', error.message);
            console.error('Response Text:', text); // Log for debugging
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error.message);
    });
}

    </script>
</head>
<body>
    <div class="container">
        <h1>Search Results</h1>
        <div id="results-container"></div>
    </div>

    <!-- Modal for displaying hotel details -->
    <div id="hotel-modal" class="modal">
        <div class="modal-content">
            <!-- Dynamic content will be loaded here -->
        </div>
    </div>