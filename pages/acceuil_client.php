<?php
session_start();
require_once('../includes/db_connect.php'); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_SESSION["UserID"])) {
    $UserID = $_SESSION["UserID"];
    $RideID = $_POST["RideID"];
    $DepartureLocation = $_POST["DepartureLocation"];
    $Destination = $_POST["Destination"];
    $DepartureTime = $_POST["DepartureTime"];
    $AvailableSeats = $_POST["AvailableSeats"];
    $price = $_POST["price"];
    
    // Insert the data into the database (assuming you have a 'trajet' table)
    $sql = "INSERT INTO trajet (DepartureLocation, Destination, DepartureTime, AvaailableSeats, price) VALUES ('$DepartureLocation', '$Destination', '$DepartureTime', '$AvailableSeats', '$price')";
    mysqli_query($conn, $sql);

    // Close the database connection
    mysqli_close($conn);

    // Redirect to the current page after submitting
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
   } else {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit();
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <!--  link to jquery  to make $ work in js-->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://www.bing.com/api/maps/mapcontrol?key=ApE-HNGaFCRDs_bsmYj3Dgak-HaLSYWyN7K35FxHQXjQt8ePrxpy8_uvZoXESwIg&callback=loadMapScenario" async defer>
    <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=ApE-HNGaFCRDs_bsmYj3Dgak-HaLSYWyN7K35FxHQXjQt8ePrxpy8_uvZoXESwIg'></script> 
    <script src="https://cdn.jsdelivr.net/npm/smooth-scroll@16.1.3/dist/smooth-scroll.polyfills.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style2.css">
    <title>Client</title>
    <script>
        var scroll = new SmoothScroll('a[href*="#"]');
    </script>


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
        height: 300px;
        width:80%;
      
        display: none;
        background-color: #fff; /* Couleur de fond de la carte */
        border: 1px solid #ddd; /* Bordure de la carte */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Ombre de la carte */
        margin-top: 20px;
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
    /* new code de   rihab */
    .main{
    min-height: auto;
    
}
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 3% auto;
    padding: 25px;
    border: 1px solid #888;
    width: 60%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}

.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-content form label {
    justify-content: center;
    align-items: center;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 5px;
    display: inline-block;
    width: 35%;
}

.modal-content form input {
    align-items: center;
    font-size: 16px;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    display: inline-block;
    width: 50%;
}
.modal-content form input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    margin-left: 35%;
    width:30%;
}

.modal-content form input[type="submit"]:hover {
    background-color: #45a049;
}
/* Style the button that opens the modal */
.modal button {
    background-color: #3e1f92;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    text-align: center;
    display: inline-block;
    font-size: 15px;
    margin: 4px 2px;
    transition: 0.3s;
    border-radius: 4px;
}

/* Change the background color of the button on hover */
.modal button:hover {
    background-color: #3e1f91;
}

.div-content {
    font-size: 0; /* Fix pour éliminer l'espace blanc entre les éléments inline-block */
}

.station {
    display: inline-block;
    width: 48%; /* Ajuste la largeur pour deux éléments par ligne */
    margin-bottom: 20px;
    margin-right: 20px;
    background-color: #f5f5f5;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 10px;
    box-sizing: border-box;
    vertical-align: top; /* Ajuste l'alignement vertical au sommet */
    font-size: 16px; /* Réinitialise la taille de la police après le fix de font-size: 0; */
}

.station h2,
.passenger h2 {
    font-size: 18px;
    font-weight: bold;
    margin-right: 10px;
}

.station p,
.passenger p {
    font-size: 16px;
    color: #333;
}

.station p {
    font-size: 16px;
    margin-right: 10px;
}

.station h2 {
    font-size: 18px;
    font-weight: bold;
    margin-right: 10px;
}



#bingMap {
    display: flex;
    flex: 1;
    height: 400px; 
    width: 100%;
}

   
</style>
</head>
<body>
<div class="main">
    <header>
        <div class="container">
            <a href="#"><img class="logo" src="../images/logo2.png"></a>
    
            <nav class="navigation">
                <ul>
                     <li>
                     <li class="nav1"><a href="../clientlistes.php">listes trajets</a></li>
                     <li class="nav1"><a href="../reservation.php">Mes reservations</a></li>
                    <?php
                  
                    ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    </div>

<!-- Modified search form with a select element for position -->
<div id="search-form">
    <label for="destination">Destination:</label>
    <input type="text" id="destination" onclick="showMap()" readonly>

    <!-- Use a select element for the position options -->
    <label for="position">Position:</label>
    <select id="position">
    <option value="choose option" style="display:none">choose option</option>
        <option value="navigator">Let navigator choose my position automatically</option>
        <option value="manual" >Choose from the map search</option>
    </select>
    <input type="text" id="positionName" readonly style='display:none';>
    <label for="seats">Number of Seats:</label>
    <input type="number" id="seats" min="1"  max='5' value="1">

    <button onclick="searchTrips()">Search</button>
</div>
<button id="close-button" onclick="closeMap()">Close Map</button><div id="map"></div>

<div class="container">
        <div>
            <div id="trip-list" class="div-content">
           
            <?php
// Fetch data from the database
$sql = "SELECT * FROM rides WHERE AvailableSeats > 0";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo '<a style=" height:auto;" href="rechercher.php?RideID=' . urlencode($row["RideID"]) . '">';
        echo '<div class="station">';
        echo '<p style="font-weight: bold; text-align: center;">' . $row["DepartureTime"] . '</p>';
        echo '<br/>';
        echo '<span style="color: black; text-decoration: none; font-size: 20px; display: inline-block;" class="fas fa-map-marker-alt"></span>     <p style=" display: inline-block;">' . $row["DepartureLocation"] . '</p>';
        if ($row["price"] !== "") {
            echo '<p style=" font-weight: bold; margin-left: 85% ; display: inline-block;" class="price" style="margin-left: 250px;">' . $row["price"] . '</p>';
        }
        echo '<br/>';
        echo '<span style="color: black; text-decoration: none; font-size: 20px; display: inline-block;" class="fas fa-flag"></span>     <p style=" display: inline-block;"> ' . $row["Destination"] . '</p>';
        echo '<p style="display: inline-block; font-size: 30px; margin-left: 80%;">' . $row["AvailableSeats"] . '</p><img style="display: inline-block;  width: 7%; height:7%;" src="../images/car-seat.png"/>';
        echo '</div>';
        echo '</a>';
    }
} else {
    echo "0 results";
}
?>
      
</div>
           
</div>
   
    </div>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script>
    
    var map = L.map('map').setView([0, 0], 2);
    var destinationInput = document.getElementById('destination');
    var positionSelect = document.getElementById('position');
    var positionNameInput = document.getElementById('positionName');
    var seatsInput = document.getElementById('seats');
    var tripListContainer = document.getElementById('trip-list');
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
                        
                       
                          var  city = data.address.city || data.address.town || data.address.village;
                          
                        var city_name = city || 'Unknown';
                       
                        positionNameInput.style.display='block';
                        positionNameInput.value = city_name;
                        positionSelect.value = 'choose option';
                        // Set the position latitude and longitude
                        positionLatitude = lat;
                        positionLongitude = lon;
                     
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

        // Hide the map after selecting a location
        document.getElementById('map').style.display = 'none';
        document.getElementById('close-button').style.display = 'none';
        positionSelect.value = 'choose option';
    });
    }
});

  

function searchTrips()  {
        var position = $('#position').val();
        var destination = $('#destination').val();
        var seats = $('#seats').val();
        console.log('position latitude:', positionLatitude);
        console.log('Destination:', destination);
    console.log('Seats:', seats);
        // Use AJAX to send a request to the server
        $.ajax({
            url: 'searchTrips.php', // The server-side script
            type: 'POST', // Send as a POST request
            data: { destination: destination,seats: seats,destinationLongitude:destinationLongitude,destinationLatitude:destinationLatitude ,positionLongitude :positionLongitude , positionLatitude: positionLatitude}, // Data to send to the server
            dataType: 'json', // Make sure to specify the expected data type
            
            success: function (data) {
                console.log("heres data")
                console.log(data);
                // Handle the data received from the server
                if (data.error) {
                    // Display an error message if no results found
                    $('#trip-list').html('<p>' + data.error + '</p>');
                } else {
                    // Render the trips dynamically
                    renderTrips(data);
                }
            },
            error: function () {
                // Handle the error case
                $('#trip-list').html('<p>Error fetching data.</p>');
            }
        });
    }
    function renderTrips(trips) {
    // Clear the existing content in the trips container
    $('#trip-list').html('');

    // Iterate through the trips and append them to the container
    trips.forEach(function (trip) {
        var tripHtml = '<a style=" height:auto;" href="rechercher.php?RideID=' + trip.RideID + '">';
        tripHtml += '<div class="station">';
        tripHtml += '<p style="font-weight: bold; text-align: center;">' + trip.DepartureTime + '</p>';
        tripHtml += '<br/>';
        tripHtml += '<span style="color: black; text-decoration: none; font-size: 20px; display: inline-block;" class="fas fa-map-marker-alt"></span>';
        tripHtml += '<p style=" display: inline-block;">' + trip.DepartureLocation + '</p>';
        if (trip.price !== "") {
            tripHtml += '<p style=" font-weight: bold; margin-left: 85% ; display: inline-block;" class="price" style="margin-left: 250px;">' + trip.price + '</p>';
        }
        tripHtml += '<br/>';
        tripHtml += '<span style="color: black; text-decoration: none; font-size: 20px; display: inline-block;" class="fas fa-flag"></span>';
        tripHtml += '<p style=" display: inline-block;"> ' + trip.Destination + '</p>';
        tripHtml += '<p style="display: inline-block; font-size: 30px; margin-left: 80%;">' + trip.AvailableSeats + '</p><img style="display: inline-block;  width: 7%; height:7%;" src="../images/car-seat.png"/>';
        tripHtml += '</div>';
        tripHtml += '</a>';

        // Append the generated HTML to the container
        $('#trip-list').append(tripHtml);
    });
}


    function haversineDistance(lat1, lon1, lat2, lon2) {
        var R = 6371;
        var dLat = deg2rad(lat2 - lat1);
        var dLon = deg2rad(lon2 - lon1);
        var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var distance = R * c;
        return distance;
    }

    function deg2rad(deg) {
        return deg * (Math.PI / 180);
    }
</script>

</body>
</html>