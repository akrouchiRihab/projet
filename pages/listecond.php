<?php
require_once '../includes/config_session.inc.php';
require_once('../includes/db_connect.php'); // Include your database connection file

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <script src="https://cdn.jsdelivr.net/npm/smooth-scroll@16.1.3/dist/smooth-scroll.polyfills.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style2.css">
    <link rel="icon" href="../images/tt.png" type="image/x-icon">
    <title>Conducteur</title>
    <script>
        var scroll = new SmoothScroll('a[href*="#"]');
    </script>
    <style>
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
.navigation{
    margin-left:50%;
}
#map {
    position: relative;
    height: 300px; /* Ajustez la hauteur selon vos besoins */
    max-width: 100%; /* Ajustez la largeur maximale */
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
/* Style the select element */
#position {
    width: 50%;
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
                <ul>
                    <li><a href="../reservation.php" class="logout">Voir Réservations</a></li>
                    <li><a href="../includes/logout.inc.php" class="logout">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>
    </div>
    <div class="container">
        <div class="col-2">
            <br/>
            <a id="openModal" class="proposer_btn" >+ proposer un trajet</a>
        </div>
        <br/>
        <div>
            <div class="div-content">
            <?php
// Fetch data from the database

/*$result = $conn->query($sql);*/

$DriverID = $_SESSION["UserID"];
$sql = "SELECT * FROM rides WHERE DriverID = ?";
$statement = $conn->prepare($sql);
$statement->bind_param('i', $DriverID);
$statement->execute();
$result = $statement->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<a style=" height:auto;" href="plan_route.php?RideID=' . urlencode($row["RideID"]) . '">';
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
    <div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="proposalForm" method="post" action="submit_proposal.php">
            <label for="DepartureLocation">Lieu de départ</label>
            <input type="text" name="DepartureLocation" id="positionName" readonly style='display:none';>
            <select id="position">
            <option value="choose option" style="display:none">choose option</option>
                <option value="navigator">Let navigator choose my position automatically</option>
                <option value="manual" >Choose from the map search</option>
            </select>
            <br/>

            <label for="Destination">Destination</label>
            <input type="text" name="Destination" id="destination" onclick="showMap()" readonly>
            <br/>
            <button id="close-button" onclick="closeMap()">Close Map</button><div id="map"></div>
            <label for="DepartureTime">Date et Heure</label>
            <input placeholder="Quand partez-vous ?" class="flatpickr" type="datetime-local" name="DepartureTime" required>
            <br/>
            
            <label for="AvailableSeats">Nombre de places </label>
            <input placeholder="Combien de passagers pouvez-vous accepter ?" type="number" name="AvailableSeats" required>
            <br/>
            <label for="price">Prix </label>
            <input placeholder="Fixez votre prix par place"  type="text" name="price" required>
            <br/><br/>
            
            <?php if (isset($_SESSION['errorMessages'])): ?>
                <div style="color: red; width: 80%; margin-bottom: 10px;"><?php echo $_SESSION['errorMessages']; ?></div>
                <?php unset($_SESSION['errorMessages']); // Effacer les messages après les avoir affichés ?>
            <?php endif; ?>
            
            <input type="submit" value="Proposer">
        </form>
    </div>
</div>
</div>
</body>
<script>
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("openModal");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
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

</script>
</html>
