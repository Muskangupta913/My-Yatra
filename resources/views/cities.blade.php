<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City List</title>
</head>
<body>
    <h1>Available Cities</h1>
    <button onclick="fetchCities()">Load Cities</button>

    <table border="1" id="city-table">
        <thead>
            <tr>
                <th>City ID</th>
                <th>City Name</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        function fetchCities() {
            fetch('/fetch-all-cities')
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const tableBody = document.querySelector('#city-table tbody');
            tableBody.innerHTML = ''; // Clear the table
            data.cities.forEach(city => {
                const row = document.createElement('tr');
                row.innerHTML = `<td>${city.CityId}</td><td>${city.CityName}</td>`;
                tableBody.appendChild(row);
            });
        } else {
            alert(data.message); // Display error message from server
        }
    })
    .catch(error => {
        console.error('Error fetching cities:', error);
    });
        }
    </script>
</body>
</html>
