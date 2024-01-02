<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
    body {
        background-color: #f0f0f0; /* Couleur de fond blanche */
        color: #333; /* Couleur du texte principale */
        font-family: Arial, sans-serif; /* Police par défaut */
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #map {
        height: 400px;
        width: 400px;
        left: 40%;
        display: none;
        background-color: #fff; /* Couleur de fond de la carte */
        border: 1px solid #ddd; /* Bordure de la carte */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Ombre de la carte */
        margin-top: 20px;
    }

    #search-form {
        display: flex;
        flex-direction: row;
        align-items: center;
        margin-top: 20px;
    }

    #search-form label {
        margin-right: 10px;
        color: #3498db; /* Couleur du texte des labels */
    }

    #search-form input[type="text"],
    #search-form input[type="number"] {
        padding: 8px;
        box-sizing: border-box;
        margin-right: 10px;
    }

    #search-form button {
        background-color: #3498db; /* Couleur de fond du bouton */
        color: #fff; /* Couleur du texte du bouton */
        border: none;
        padding: 10px 15px;
        border-radius: 3px;
        cursor: pointer;
    }

    #trip-list {
        margin-top: 20px;
       
    }

    .trip-container {
        background-color: #fff; /* Couleur de fond des conteneurs de voyage */
        border: 1px solid #ddd; /* Bordure des conteneurs de voyage */
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Ombre des conteneurs de voyage */
    }
</style>

</head>
<body>

<div id="map"></div>
<div id="search-form">
    <label for="destination">Destination:</label>
    <input type="text" id="destination" onclick="showMap()" readonly>

    <label for="current-location">Current Location:</label>
    <input type="text" id="current-location" readonly>

    <label for="seats">Number of Seats:</label>
    <input type="number" id="seats" min="1" value="1">

    <button onclick="searchTrips()">Search</button>
</div>
<div id="trip-list"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
    var map = L.map('map').setView([0, 0], 2);
    var destinationInput = document.getElementById('destination');
    var seatsInput = document.getElementById('seats');
    var tripListContainer = document.getElementById('trip-list');


    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Add the geocoder control to the map
    var geocoder = L.Control.geocoder().addTo(map);
    var trips = [
        { destination: 'Paris', currentLocation: 'reghaia', availableSeats: 3 },
        { destination: 'Berlin, Allemagne', currentLocation: 'Zéralda', availableSeats: 2 },
        { destination: 'Berlin, Allemagne', currentLocation: 'reghaia', availableSeats: 4 }
        // Add more trips as needed
    ];
    // Get current location using the browser's geolocation API
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;

            // Use reverse geocoding to get the address
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                .then(response => response.json())
                .then(data => {
                  
                    var city = data.address.city;
        if (!city) {
            // If city is not available, check for other properties like town or village
            city = data.address.town || data.address.village;
        }
        var city_name = city || 'Unknown'; // Use city if available, otherwise set to 'Unknown'
        document.getElementById('current-location').value = city_name;
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

    function showMap() {
        // Display the map when the "Destination" input is clicked
        document.getElementById('map').style.display = 'block';
    }

    // Listen for the geocoding result event
    geocoder.on('markgeocode', function (e) {
        // Update the "Destination" input with the selected location
        destinationInput.value = e.geocode.name;

        // Disable the "Destination" input after selecting a location
       

        // Hide the map after selecting a location
        document.getElementById('map').style.display = 'none';
    });

    function searchTrips() {
    // Clear previous trip list
    tripListContainer.innerHTML = '';

    // Get the current location coordinates
    var currentLat, currentLon;
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            currentLat = position.coords.latitude;
            currentLon = position.coords.longitude;

            // Filter trips based on search criteria
            var filteredTrips = trips.filter(function (trip) {
                return trip.destination.toLowerCase() === destinationInput.value.toLowerCase() &&
                    trip.availableSeats >= parseInt(seatsInput.value);
            });

            // Sort trips by proximity to the current location
            filteredTrips.sort(function (a, b) {
    var distanceA = haversineDistance(currentLat, currentLon, a.lat, a.lon); // Use a.lat and a.lon
    var distanceB = haversineDistance(currentLat, currentLon, b.lat, b.lon); // Use b.lat and b.lon
    return distanceA - distanceB;
});

            // Display the sorted trips
            filteredTrips.forEach(function (trip) {
                var tripContainer = document.createElement('div');
                tripContainer.className = 'trip-container';
                tripContainer.innerHTML = '<strong>Destination:</strong> ' + trip.destination +
                    '<br><strong>Current Location:</strong> ' + trip.currentLocation +
                    '<br><strong>Available Seats:</strong> ' + trip.availableSeats +
                    '<br><strong>Distance:</strong> ' + haversineDistance(currentLat, currentLon, trip.startLat, trip.startLon).toFixed(2) + ' km';
                tripListContainer.appendChild(tripContainer);
            });
        }, function (error) {
            console.error('Error getting geolocation:', error.message);
        });
    } else {
        console.error('Geolocation is not supported by this browser.');
    }
}

// Function to calculate haversine distance between two points on the Earth's surface
function haversineDistance(lat1, lon1, lat2, lon2) {
    var R = 6371; // Radius of the Earth in kilometers
    var dLat = deg2rad(lat2 - lat1);
    var dLon = deg2rad(lon2 - lon1);
    var a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    var distance = R * c;
    return distance;
}

// Function to convert degrees to radians
function deg2rad(deg) {
    return deg * (Math.PI / 180);
}
</script>

</body>
</html>
