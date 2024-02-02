<?php
// Include your database connection file
require_once('../includes/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form submission for updating the trip in the database
    $RideID = $_POST["RideID"];
    $DepartureLocation = $_POST["DepartureLocation"];
    $Destination = $_POST["Destination"];
    $DepartureTime = $_POST["DepartureTime"];
    $AvailableSeats = $_POST["AvailableSeats"];
    $price = $_POST["price"];

    // Ajoutez ces lignes pour récupérer les coordonnées de latitude et longitude
    $positionLatitude = $_POST["positionLatitude"];
    $positionLongitude = $_POST["positionLongitude"];
    $destinationLatitude = $_POST["destinationLatitude"];
    $destinationLongitude = $_POST["destinationLongitude"];

    // Perform the update query (modify as per your database structure)
    $sql = "UPDATE rides SET 
            DepartureLocation = '$DepartureLocation', 
            Destination = '$Destination', 
            DepartureTime = '$DepartureTime', 
            AvailableSeats = '$AvailableSeats', 
            price = '$price',
            positionLatitude = '$positionLatitude',
            positionLongitude = '$positionLongitude',
            destinationLatitude = '$destinationLatitude',
            destinationLongitude = '$destinationLongitude'
            WHERE RideID = '$RideID'";

    // Execute the query
    mysqli_query($conn, $sql);

    // Redirect to the trip details page after updating
    header('Location: plan_route.php?RideID=' . urlencode($RideID));
    exit();
}

// Fetch the trip details from the database based on RideID
if (isset($_GET['RideID'])) {
    $RideID = $_GET['RideID'];

    $sql = "SELECT * FROM rides WHERE RideID = '$RideID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $DepartureLocation = $row["DepartureLocation"];
        $Destination = $row["Destination"];
        $DepartureTime = $row["DepartureTime"];
        $AvailableSeats = $row["AvailableSeats"];
        $price = $row["price"];
        $positionLatitude = $row["positionLatitude"];
        $positionLongitude = $row["positionLongitude"];
        $destinationLatitude = $row["destinationLatitude"];
        $destinationLongitude = $row["destinationLongitude"];
    } else {
        echo "Ride not found";
        exit();
    }
} else {
    echo "Invalid access";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="../css/edit_trip.css">
    <link rel="icon" href="../images/logopage.png" type="image/x-icon">
    <title>Twsila - Conducteur</title>
    <style>
        #map {
            position: relative;
            left: -10%;
            height: 300px; /* Ajustez la hauteur selon vos besoins */
            max-width: 90%; /* Ajustez la largeur maximale */
            margin-bottom: 10%;
           
            display: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }

        #close-button {
            display:none;
            top: 70%;
            right: 10px;
            padding: 8px 12px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        #close-button:hover {
            background-color: #2980b9;
        }

        /* Style the select element */
        #position {
            width: 70%;
            padding: 8px;
            margin-bottom: 2%;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* Style the options inside the select */
        #position option {
            height: auto;
            background-color: #fff; /* Background color of options */
            color: #333; /* Text color of options */
            font-size: 16px;
        }

        /* Style the select when it's focused */
        #position:focus {
            outline: none; /* Remove the default focus outline */
            border-color: #3498db; /* Change border color on focus */
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.7); /* Add a subtle box shadow on focus */
        }

       
    </style>
</head>
<body>
    <div class="main">
        <header>
            <div class="container">
                <a href="#"><img class="logo" src="../images/twsil3.png"></a>
                <nav class="navigation">
                    <ul style="margin-left: 50%;">
                        <li><a href="liste_driver.php">listes trajets</a></li>
                        <li><a href="reservation_driver.php">Voir Réservations</a></li>
                        <li><a href="../includes/logout.inc.php" class="logout">Déconnexion</a></li>
                    </ul>
                </nav>
            </div>
        </header>
    </div>
    <div class="div-container">
        <h1>Modifier le Trajet</h1>

        <form method="post" action="edit_trajet.php">
            <input type="hidden" name="RideID" value="<?php echo $RideID; ?>">
            
            <label for="DepartureLocation">Lieu de départ</label><br/>
            <select id="position">
                <option value="choose option" style="display:none">choose option</option>
                <option value="navigator">Let navigator choose my position automatically</option>
                <option value="manual" >Choose from the map search</option>
            </select>
            <input type="text" id="positionName" name="DepartureLocation" value="<?php echo $DepartureLocation; ?>" readonly>
            <br/>

            <label for="Destination">Destination</label><br>
            <input type="text" name="Destination" id="destination" value="<?php echo $Destination; ?>" onclick="showMap()">
            <br>
            <button id="close-button" onclick="closeMap()">Close Map</button>
            <div id="map"></div>

            <!-- Ajoutez ces lignes pour inclure les champs de latitude et longitude -->
            <input type="hidden" name="positionLatitude" id="positionLatitude" value="">
            <input type="hidden" name="positionLongitude" id="positionLongitude" value="">
            <input type="hidden" name="destinationLatitude" id="destinationLatitude" value="">
            <input type="hidden" name="destinationLongitude" id="destinationLongitude" value="">

            <label for="DepartureTime">Date et Heure</label><br>
            <input placeholder="Quand partez-vous ?" class="flatpickr" type="datetime-local" name="DepartureTime" value="<?php echo $DepartureTime; ?>" required>
            <br/>

            <label for="AvailableSeats">Nombre de places disponibles</label><br>
            <input type="number" name="AvailableSeats" value="<?php echo $AvailableSeats; ?>" required>
            <br>

            <label for="price">Prix par place</label><br>
            <input type="text" name="price" value="<?php echo $price; ?>" required>
            <br>

            <button type="submit">Enregistrer les Modifications</button>
        </form>
    </div>
</body>
<script>
    flatpickr(".flatpickr", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        // Ajoutez d'autres options selon vos besoins
    });
</script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
    var map = L.map('map').setView([0, 0], 2);
    var destinationInput = document.getElementById('destination');
    var positionSelect = document.getElementById('position');
    var positionNameInput = document.getElementById('positionName');
    var destinationLatitude, destinationLongitude;
    var positionLatitude, positionLongitude;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    var geocoder = L.Control.geocoder().addTo(map);

    function showMap() {
        document.getElementById('map').style.display ='block';
        document.getElementById('close-button').style.display = 'block';
        map.invalidateSize();
    }

    function closeMap() {
        var mapElement = document.getElementById('map');
        mapElement.style.display = 'none';
        document.getElementById('close-button').style.display = 'none';
    }

    destinationInput.addEventListener('click', function() {
        showMap();
        geocoder.off('markgeocode');
        geocoder.on('markgeocode', function (e) {
            var city = e.geocode.properties.address.city || e.geocode.properties.address.town || e.geocode.properties.address.village;
            var city_name = city || 'Unknown';
            
            destinationInput.value = city_name;
            // Set the destination latitude and longitude
            destinationLatitude = e.geocode.center.lat;
            destinationLongitude = e.geocode.center.lng;

            // Update the hidden fields with new destination latitude and longitude
            document.getElementById('destinationLatitude').value = destinationLatitude;
            document.getElementById('destinationLongitude').value = destinationLongitude;

            // Hide the map after selecting a location
            document.getElementById('map').style.display = 'none';
            document.getElementById('close-button').style.display = 'none';
        });
    });

    positionSelect.addEventListener('change', function() {
        var selectedOption = positionSelect.value;

        if (selectedOption === 'navigator') {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var lat = position.coords.latitude;
                    var lon = position.coords.longitude;

                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                        .then(response => response.json())
                        .then(data => {
                            var city = data.address.city || data.address.town || data.address.village;
                            var city_name = city || 'Unknown';
                            
                            positionNameInput.style.display='block';
                            positionNameInput.value = city_name;
                            positionSelect.value = 'choose option';

                            // Set the position latitude and longitude
                            positionLatitude = lat;
                            positionLongitude = lon;

                            // Update the hidden fields with new position latitude and longitude
                            document.getElementById('positionLatitude').value = positionLatitude;
                            document.getElementById('positionLongitude').value = positionLongitude;
                        })
                        .catch(error => {
                            console.error('Error getting address:', error.message);
                        });

                    map.setView([lat, lon], 13);
                }, function (error) {
                    console.error('Error getting geolocation:', error.message);
                });
            } else {
                console.error('Geolocation is not supported by this browser.');
            }
        } else if (selectedOption === 'manual') {
            // Show the map when choosing manually
            showMap();
            geocoder.off('markgeocode');
            geocoder.on('markgeocode', function (e) {
                var city = e.geocode.properties.address.city || e.geocode.properties.address.town || e.geocode.properties.address.village;
                var city_name = city || 'Unknown';
                positionNameInput.style.display='block';
                positionNameInput.value = city_name;

                // Set the position latitude and longitude
                positionLatitude = e.geocode.center.lat;
                positionLongitude = e.geocode.center.lng;

                // Update the hidden fields with new position latitude and longitude
                document.getElementById('positionLatitude').value = positionLatitude;
                document.getElementById('positionLongitude').value = positionLongitude;

                // Hide the map after selecting a location
                document.getElementById('map').style.display = 'none';
                document.getElementById('close-button').style.display = 'none';
                positionSelect.value = 'choose option';
            });
        }
    });
</script>
</html>
