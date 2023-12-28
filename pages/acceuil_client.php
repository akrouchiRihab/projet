<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
        }

        #search-form {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
            background: white;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div id="map"></div>
<div id="search-form">
    <label for="destination">Destination:</label>
    <input type="text" id="destination">

    <label for="current-location">Current Location:</label>
    <input type="text" id="current-location" readonly>

    <label for="seats">Number of Seats:</label>
    <input type="number" id="seats" min="1" value="1">

    <button onclick="searchTrips()">Search</button>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([0, 0], 2);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Get current location using the browser's geolocation API
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;

            // Use reverse geocoding to get the address
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                .then(response => response.json())
                .then(data => {
                    var address = data.display_name;
                    document.getElementById('current-location').value = address;
                })
                .catch(error => {
                    console.error('Error getting address:', error.message);
                });

            // Center the map on the user's location
            map.setView([lat, lon], 13);
        }, function (error) {
            console.error('Error getting geolocation:', error.message);
        });
    } else {
        console.error('Geolocation is not supported by this browser.');
    }

    function searchTrips() {
        // Implement your logic for searching trips here
        // Use the values from the destination, current location, and seats fields

        // For now, let's just display an example result
        alert('Searching for trips to ' + document.getElementById('destination').value +
            ' from ' + document.getElementById('current-location').value +
            ' with ' + document.getElementById('seats').value + ' available seats.');
    }
</script>

</body>
</html>