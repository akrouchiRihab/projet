<?php 
session_start();
require_once('../includes/db_connect.php'); // Inclure votre fichier de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION["UserID"])) {
        $userID = $_SESSION["UserID"];
        $rideID = $_POST["RideID"];
        $departureLocation = $_POST["DepartureLocation"];
        $destination = $_POST["Destination"];
        $departureTime = $_POST["DepartureTime"];
        $availableSeats = $_POST["AvailableSeats"];
        $price = $_POST["price"];

        // Insérer les données dans la table 'trajet' (assuming you have a 'trajet' table)
        $sql = "INSERT INTO trajet (DepartureLocation, Destination, DepartureTime, AvailableSeats, price) VALUES ('$departureLocation', '$destination', '$departureTime', '$availableSeats', '$price')";
        mysqli_query($conn, $sql);

        // Fermer la connexion à la base de données
        mysqli_close($conn);

        // Rediriger vers la page actuelle après la soumission
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        header("Location: ../login.php");
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
    <link rel="stylesheet" href="https://www.bing.com/api/maps/mapcontrol?key=ApE-HNGaFCRDs_bsmYj3Dgak-HaLSYWyN7K35FxHQXjQt8ePrxpy8_uvZoXESwIg&callback=loadMapScenario" async defer>
    <script type='text/javascript' src='https://www.bing.com/api/maps/mapcontrol?key=ApE-HNGaFCRDs_bsmYj3Dgak-HaLSYWyN7K35FxHQXjQt8ePrxpy8_uvZoXESwIg'></script> 
    <script src="https://cdn.jsdelivr.net/npm/smooth-scroll@16.1.3/dist/smooth-scroll.polyfills.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/js/all.min.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style2.css">
    <link rel="icon" href="../images/logopage.png" type="image/x-icon">
    <title>Twsila - Client</title>
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



#bingMap {
    display: flex;
    flex: 1;
    height: 400px; 
    width: 100%;
}
.ride-container {
    transition: transform 0.3s ease; /* Add smooth transition for zoom effect */
}

.ride-container:hover {
    transform: scale(1.05); /* Scale up by 5% on hover */
}
    </style>
</head>
<body>
<div class="main">
    <header>
        <div class="container">


            <a href="clientlistes.php"><img class="logo" src="../images/twsil3.png"></a>

            <nav class="navigation">
                <ul style="margin-top: 1%; margin-left: 45%;">
                     <li>
                     <li><a href="clientlistes.php">listes trajets</a></li>
                     <li><a href="reservation.php">Mes reservations</a></li>
                     <li><a href="../includes/logout.inc.php" class="logout">Déconnexion</a></li>
             
                    <?php
                     $userID = $_SESSION["UserID"]; 
                    ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    </div>
    <div class="container">
        <div class="col-2">
            <br/>
        </div>
        <br/>
        <div>
            <div class="div-content " >
            <?php

$sql = "SELECT Distinct r.RideID, r.DepartureTime, r.DepartureLocation, r.Destination, r.AvailableSeats, r.price, u.phonenumber
        FROM rides r
        INNER JOIN reservations res ON r.RideID = res.RideID
        INNER JOIN users u ON u.UserID = res.UserID
        WHERE res.UserID = '$userID'
        ORDER BY r.RideID ASC";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {

                echo '<a style="height:auto;" href="maReservation.php?RideID=' . urlencode($row["RideID"]) . '">';
                echo '<div class="station">';
                echo '<p style="font-weight: bold; text-align: center;">' . $row["DepartureTime"] . '</p>';
                echo '<br/>';
                echo '<span style="color: black; text-decoration: none; font-size: 20px; display: inline-block;" class="fas fa-map-marker-alt"></span>     <p style="display: inline-block;">' . $row["DepartureLocation"] . '</p>';
                echo '<br/>';
                echo '<span style="color: black; text-decoration: none; font-size: 20px; display: inline-block;" class="fas fa-flag"></span>     <p style="display: inline-block;"> ' . $row["Destination"] . '</p>';
                echo '<p style="font-weight: bold;" class="price" style="margin-left: 250px;">Numero de telephone : ' . $row["phonenumber"] . '</p>';
                echo '<p style="font-weight: bold;" class="price" style="margin-left: 250px;">Prix : ' . $row["price"] . '</p>';
                echo '<p style="display: inline-block; font-size: 30px;">Places disponibles : ' . $row["AvailableSeats"] . '</p>';
                echo '<form action="process_annulation.php" method="post">';
                echo '<input type="hidden" name="ride_id" value="' . urlencode($row["RideID"]) . '">';
                echo '<button type="submit" class="annuler_btn">Annuler</button> </form>';
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
<script>
    function initMap() {
        var myLatLng;

        // Check if userCoordinates is not empty
        if (Object.keys(userCoordinates).length !== 0) {
            myLatLng = [userCoordinates.lat, userCoordinates.lng];
        }

        // Utiliser Leaflet pour créer une carte
        var map = L.map('map').setView(myLatLng, 15);

        // Ajouter une couche OpenStreetMap à la carte
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Ajouter un marqueur à la position de l'utilisateur
        if (myLatLng) {
            L.marker(myLatLng).addTo(map)
                .bindPopup('User Location')
                .openPopup();
        }
    }
</script>


</html>
