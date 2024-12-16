<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Cities API</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .api-response {
            max-height: 400px;
            overflow-y: auto;
        }
        .status-badge {
            font-size: 0.8em;
            padding: 0.35em 0.65em;
        }
        #searchResults {
            position: absolute;
            width: 100%;
            z-index: 1000;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="mb-3">City API Test Dashboard</h2>
                <div class="d-flex gap-2">
                    <button id="fetchCities" class="btn btn-primary">Fetch All Cities</button>
                    <button id="clearResults" class="btn btn-secondary">Clear Results</button>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">API Status</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center gap-3">
                            <div>Status: <span id="apiStatus" class="badge bg-secondary">Not Tested</span></div>
                            <div>Cities Found: <span id="cityCount" class="badge bg-secondary">0</span></div>
                            <div>Last Updated: <span id="lastUpdated" class="text-muted">Never</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-0">Raw API Response</h5></div>
                    <div class="card-body api-response">
                        <pre id="rawResponse" class="mb-0">No data yet</pre>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header"><h5 class="mb-0">Processed Cities</h5></div>
                    <div class="card-body api-response">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>City ID</th>
                                    <th>City Name</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="cityList">
                                <tr><td colspan="3" class="text-center">No data available</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fetchButton = document.getElementById('fetchCities');
            const clearButton = document.getElementById('clearResults');
            const apiStatus = document.getElementById('apiStatus');
            const cityCount = document.getElementById('cityCount');
            const lastUpdated = document.getElementById('lastUpdated');
            const rawResponse = document.getElementById('rawResponse');
            const cityList = document.getElementById('cityList');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            // Original fetch all cities functionality
            fetchButton.addEventListener('click', async () => {
                try {
                    fetchButton.disabled = true;
                    apiStatus.className = 'badge bg-warning';
                    apiStatus.textContent = 'Loading...';

                    const response = await fetch('{{ route("fetch.all.cities") }}', {
                        method:'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    const data = await response.json();
                    rawResponse.textContent = JSON.stringify(data, null, 2);

                    if (data.status === 'success' && data.data) {
                        const cities = data.data;
                        cityCount.textContent = cities.length;
                        apiStatus.className = 'badge bg-success';
                        apiStatus.textContent = 'Success';

                        cityList.innerHTML = '';
                        cities.forEach(city => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${city.code || 'N/A'}</td>
                                <td>${city.city_name || 'N/A'}</td>
                                <td><span class="badge bg-success status-badge">Valid</span></td>
                            `;
                            cityList.appendChild(row);
                        });
                    } else {
                        apiStatus.className = 'badge bg-danger';
                        apiStatus.textContent = 'No Cities Found';
                        cityList.innerHTML = '<tr><td colspan="3" class="text-center text-danger">No cities found</td></tr>';
                    }

                    lastUpdated.textContent = new Date().toLocaleString();
                } catch (error) {
                    apiStatus.className = 'badge bg-danger';
                    apiStatus.textContent = 'Error';
                    rawResponse.textContent = error.message;
                    cityList.innerHTML = '<tr><td colspan="3" class="text-center text-danger">Error fetching cities: ' + error.message + '</td></tr>';
                } finally {
                    fetchButton.disabled = false;
                }
            });

            clearButton.addEventListener('click', () => {
                apiStatus.className = 'badge bg-secondary';
                apiStatus.textContent = 'Not Tested';
                cityCount.textContent = '0';
                lastUpdated.textContent = 'Never';
                rawResponse.textContent = 'No data yet';
                cityList.innerHTML = '<tr><td colspan="3" class="text-center">No data available</td></tr>';
            });
        });
    </script>
</body>
</html>
