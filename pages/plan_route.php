<?php
// Include your database connection file
require_once('../includes/db_connect.php');

// Check if rideID is provided in the URL for deletion
if (isset($_GET['deleteID'])) {
    $deleteID = $_GET['deleteID'];

    // Supprimer d'abord les enregistrements liés dans la table "reservations"
    $deleteReservationsQuery = "DELETE FROM reservations WHERE RideID = '$deleteID'";
    if ($conn->query($deleteReservationsQuery) === TRUE) {
        // Ensuite, supprimer la ligne dans la table "rides"
        $deleteRideQuery = "DELETE FROM rides WHERE RideID = '$deleteID'";
        if ($conn->query($deleteRideQuery) === TRUE) {
            // Redirect to the same page after deleting
            header('Location: liste_driver.php');
            exit();
        } else {
            // Handle errors
            echo "Error deleting record: " . mysqli_error($conn);
            exit();
        } 
    } else {
        // Handle errors
        echo "Error deleting reservations: " . mysqli_error($conn);
        exit();
    }
}

// Check if rideID is provided in the URL for fetching details
if (isset($_GET['RideID'])) {
    $RideID = $_GET['RideID'];

    // Fetch ride details based on rideID
    $sql = "SELECT * FROM rides WHERE RideID = '$RideID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of the specific ride
        $row = $result->fetch_assoc();
        $departureLocation = $row["DepartureLocation"];
        $destination = $row["Destination"];
        $departureTime = $row["DepartureTime"];
        $dateObj = new DateTime($departureTime);
        // Afficher le nom complet du jour de la semaine
        $dayOfWeek = $dateObj->format('l');
        $availableSeats = $row["AvailableSeats"];
        $price = $row["price"];
    } else {
        // Handle case where rideID is not found
        echo "Ride not found";
        exit();
    }
} else {
    // Handle case where rideID is not provided
    echo "Invalid access";
    exit();
}
?>
<?php
// Assurez-vous de remplacer ces informations par les vôtres
require_once '../includes/db_connect.php';

$RideID = $_GET['RideID'];  // Assurez-vous de sécuriser cette valeur pour éviter les injections SQL

$sql = "SELECT destinationLatitude, destinationLongitude, positionLatitude, positionLongitude FROM rides WHERE RideID = ?";
$statement = $conn->prepare($sql);
$statement->bind_param('i', $RideID);
$statement->execute();
$statement->bind_result($destinationLatitude, $destinationLongitude, $positionLatitude, $positionLongitude);
$statement->fetch();
$statement->close(); // Fermez la première déclaration ici si vous n'avez plus besoin de travailler avec la base de données

// Assurez-vous de rouvrir la connexion si vous avez fermé la connexion
// $conn = new mysqli($servername, $username, $password, $dbname);

session_start(); // Assurez-vous que la session utilisateur est active

$UserID = $_SESSION['UserID']; // Assurez-vous que la session utilisateur est active

// Requête pour compter le nombre de réservations pour ce trajet et cet utilisateur
$reservationCountQuery = "SELECT COUNT(*) AS reservationCount FROM reservations WHERE RideID = ? AND UserID = ?";
$statement = $conn->prepare($reservationCountQuery);
$statement->bind_param('ii', $RideID, $UserID);
$statement->execute();
$statement->bind_result($reservationCount);
$statement->fetch();
$statement->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/plan_route.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<link rel="icon" href="../images/logopage.png" type="image/x-icon">
    <title>Twsila - Conducteur</title>
    <style>
        .div-container{
            margin-left: 2%;
            display: inline-block;
            width: 40%;
            height: 40%;
        }
        /* Style for the map container */
        #map {
            display : inline-block;
            height: 330px;
            width: 40%;
            position: relative;
            left: 5%;
            top: 1%;
            margin-top : 1%;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="main">
        <header>
            <div class="container">
                <a href="liste_driver.php"><img class="logo" src="../images/twsil3.png"></a>
                <nav class="navigation">
                    <ul style="margin-left: 50%;">
                        <li><a style="text-decoration: none;" href="liste_driver.php">listes trajets</a></li>
                        <li><a style="text-decoration: none;" href="reservation_driver.php">Voir Réservations</a></li>
                        <li><a style="text-decoration: none;" href="../includes/logout.inc.php" class="logout">Déconnexion</a></li>
                    </ul>
                </nav>
            </div>
        </header>
    </div>
    <div class="div-container">
        <div class="titre">
            <h1>Plan de route</h1>
        </div>
        <div class="infos">
            <h3><?php echo $dayOfWeek . ' ' . $departureTime; ?></h3>
            <p><strong>Depart:</strong> <a href="#" onclick="showMap('<?php echo $departureLocation; ?>')"><?php echo $departureLocation; ?></a></p>
            <p><strong>Destination:</strong> <a href="#" onclick="showMap('<?php echo $destination; ?>')"><?php echo $destination; ?></a></p>
            <br/>
            <hr>
            <?php
require_once '../includes/db_connect.php';
if (isset($_GET['RideID'])) {
    $RideID = $_GET['RideID'];
// Perform a simple SELECT query to count the number of reservations
$sql = "SELECT COUNT(*) AS reservationCount FROM reservations WHERE RideID = '$RideID'";

// Check if the connection is successful before executing the query
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();

    echo '<p style="margin:2%;">';
    if ($row['reservationCount'] > 0) {
        echo "Nombre de passagers pour ce trajet : " . $row['reservationCount'];
    } else {
        echo "Aucun passager pour ce trajet";
    }
    echo '</p>';
} else {
    // Handle query error if needed
    echo "Error executing query: " . $conn->error;
}
}
?>

            <hr>
        </div>
        <div class="parametre">
            <a class="edit" href="edit_trajet.php?RideID=<?php echo urlencode($RideID); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modifier votre trajet</a> 
            <a class="delete" href="#" onclick="confirmDelete('<?php echo urlencode($RideID); ?>')">
                <i class="fa fa-trash-o" aria-hidden="true"></i> Annuler votre trajet
            </a>
        </div>
        <div></div>
        <div></div>
        
        </div>
        <div id="map"></div>
    <div class="modal" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Annuler le trajet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment annuler ce trajet?
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-danger" onclick="deleteRide('<?php echo $RideID; ?>')">Oui</button>
                    <button type="button" style="margin-left: 1%;" class="btn btn-secondary" data-dismiss="modal">Non</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(RideID) {
            var modal = document.getElementById('deleteModal');
            modal.style.display = 'block';

            var confirmButton = modal.querySelector('.btn-danger');
            confirmButton.onclick = function() {
                deleteRide(RideID);
            };

            var cancelButton = modal.querySelector('.btn-secondary');
            cancelButton.onclick = function() {
                modal.style.display = 'none';
            };
            var closeButton = modal.querySelector('.close');
            closeButton.onclick = function() {
                modal.style.display = 'none';
            };
        }

        function deleteRide(RideID) {
            window.location.href = '?deleteID=' + RideID;
        }

        window.onclick = function(event) {
            var modal = document.getElementById('deleteModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    </script>
<script>
var map = L.map('map').setView([0, 0], 2);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Ajoutez des marqueurs pour la position et la destination
L.marker([<?php echo $positionLatitude; ?>, <?php echo $positionLongitude; ?>]).addTo(map).bindPopup('Position');
L.marker([<?php echo $destinationLatitude; ?>, <?php echo $destinationLongitude; ?>]).addTo(map).bindPopup('Destination');

// Ajoutez une ligne pour représenter le trajet
var polyline = L.polyline([
    [<?php echo $positionLatitude; ?>, <?php echo $positionLongitude; ?>],
    [<?php echo $destinationLatitude; ?>, <?php echo $destinationLongitude; ?>]
], { color: 'blue' }).addTo(map);

map.fitBounds(polyline.getBounds());
</script>
</body>
</html>
