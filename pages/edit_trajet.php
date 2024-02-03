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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="../bootstrap/css/all.min.css" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../bootstrap/js/all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/smooth-scroll@16.1.3/dist/smooth-scroll.polyfills.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    

    <script src='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js' crossorigin='anonymous'></script>
    <link rel="icon" href="../images/logopage.png" type="image/x-icon">
    <title>Twsila - Conducteur</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500&display=swap');
*{
    -webkit-box-sizing: border-box;
    -moz-box-sizing:border-box;
    box-sizing: border-box;
    padding:0;
    margin:0;
 }

 :root {
    --clr-primary: #fafafa;
    --clr-body: #333;
    
  }
 html{
    scroll-behavior: smooth;
 }
body{
    font-family: 'Poppins', sans-serif;
    /*background-color:#fafafa;*/
    
   /* background-image: url(../images/herosect.jpg);*/
    background-size: 100% 100vh;
    
    background-repeat: no-repeat;
    
    background-position: top;
   /* overflow-y: scroll;*/
    
}


/* Hide the default scrollbar */
body::-webkit-scrollbar {
    width: 0.6rem;
  }
  
  /* Track */
  body::-webkit-scrollbar-track {
    background: #f1f1f1;
  }
  
  /* Handle */
  body::-webkit-scrollbar-thumb {
    background: #9e9e9e;
    border-radius: 10px;
  }
  
  /* Handle on hover */
  body::-webkit-scrollbar-thumb:hover {
    background: #6d6d6d;
  }

.main{
    min-height: auto;
    
}

header .container,.container{
    padding-left :100px;
    padding-right:100px;
    margin-left: auto;
    margin-right: auto;
    
}
header .container{
   
    display:flex;
    justify-content: space-between;
    align-items: center;
    /*background-color:white;
    /*border-bottom: 1px solid #ccc;*/
    height:60px;
    width:100%;
     position:relative;
}
header .container::after{
    content:"";
    position:absolute;
    bottom:0px;
    height:1px;
    background-color: #a2a2a2;
    width:calc(100% - 200px);
    left:100px;
}
.logo{
    height:70px;
    width:100px;
    margin-right: 10px;
    margin-top: 1%;
}


a{
    text-decoration: none;
    cursor: pointer;
}

.navigation ul li{
    text-decoration: none;
   display:inline-block;
   margin:10px;
   list-style: none;
   

}
.nav1{
    text-align: right;
    position: relative;
    left: 67%;
    text-decoration: none;
}
 
 
nav{
    flex:1;
}

.logout-icon{
   margin-left: 650px;
   border: none;
   font-size: 20px;
   cursor: pointer;
   background-color: transparent;
}

.container ul li a {
    color:black;
}
.home{
    color:#3e1f92;
}
.container .navigation ul li a:hover ,
.container .navigation ul li a.home{
   
   /* border-bottom: 1px solid #a267c9;
    color:#a267c9;*/
    border-bottom: 1px solid #3e1f92;
    color:#3e1f92;

 }

 .container .navigation ul li a{
    padding:10px;
    transition: all ease;
 }

h1 {
    margin-top: 1%;
    color: #333;
    text-align: center;
}

.form {
    padding: 25px;
    margin-left: 25%;
}
.form label {
    align-items: right;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 5px;
    display: inline-block;
    width: 35%;
}

.form input {
    align-items: center;
    font-size: 16px;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    display: inline-block;
    width: 70%;
}
.form input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    margin-left: 35%;
    width:30%;
}

.form input[type="submit"]:hover {
    background-color: #45a049;
}
.button {
    background-color: #45a049;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    text-align: center;
    align-items: center;
    display: inline-block;
    font-size: 15px;
    margin: 4px 2px;
    margin-left: 21%;
    transition: 0.3s;
    border-radius: 4px;
}

/* Change the background color of the button on hover */
.button:hover {
    background-color: #45a040;
}
        #map {
            position: relative;
            left: -10%;
            height: 300px; /* Ajustez la hauteur selon vos besoins */
            max-width: 90%; /* Ajustez la largeur maximale */
            margin-bottom: 10%;
           margin-top: 2%;
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
                <a href="liste_driver.php"><img class="logo" src="../images/twsil3.png"></a>
                <nav class="navigation">
                    <ul style="margin-top: 2%; margin-left: 30%;">
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

        <form class="form" method="post" action="edit_trajet.php">
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
            <button id="close-button" onclick="closeMap()">Close Map</button><div id="map"></div>

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

            <button class="button" type="submit">Enregistrer les Modifications</button>
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
