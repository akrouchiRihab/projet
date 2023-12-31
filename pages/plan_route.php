<?php
// Include your database connection file
require_once('../includes/db_connect.php');

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

        // Include the Bing Maps JavaScript SDK
        echo '<script type="text/javascript" src="https://www.bing.com/api/maps/mapcontrol?key=ApE-HNGaFCRDs_bsmYj3Dgak-HaLSYWyN7K35FxHQXjQt8ePrxpy8_uvZoXESwIg&callback=loadMapScenario" async defer></script>';

        // Function to load Bing Maps
        echo '<script type="text/javascript">
            function loadMapScenario() {
                var map = new Microsoft.Maps.Map(document.getElementById("map"), {
                    credentials: "ApE-HNGaFCRDs_bsmYj3Dgak-HaLSYWyN7K35FxHQXjQt8ePrxpy8_uvZoXESwIg"
                });

                // Add pushpins for departure and destination
                var departureLocation = new Microsoft.Maps.Location(' . json_encode($departureLocation) . ');
                var destination = new Microsoft.Maps.Location(' . json_encode($destination) . ');

                var departurePin = new Microsoft.Maps.Pushpin(departureLocation);
                var destinationPin = new Microsoft.Maps.Pushpin(destination);

                map.entities.push(departurePin);
                map.entities.push(destinationPin);

                // Calculate and display directions
                Microsoft.Maps.loadModule("Microsoft.Maps.Directions", function () {
                    var directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);

                    directionsManager.setRequestOptions({
                        routeMode: Microsoft.Maps.Directions.RouteMode.driving,
                        routeDraggable: false
                    });

                    var waypoint1 = new Microsoft.Maps.Directions.Waypoint({
                        address: ' . json_encode($departureLocation) . ',
                        location: departureLocation
                    });

                    var waypoint2 = new Microsoft.Maps.Directions.Waypoint({
                        address: ' . json_encode($destination) . ',
                        location: destination
                    });

                    directionsManager.addWaypoint(waypoint1);
                    directionsManager.addWaypoint(waypoint2);

                    directionsManager.setRenderOptions({
                        autoUpdateMapView: true
                    });

                    directionsManager.calculateDirections();
                });
            }
        </script>';
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


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Plan de Route</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfYaBDnZ6vo0t_f8ACEzHhJirgcMfwpyI&callback=initMap" async defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/plan_route.css">
</head>
<body>
    <div class="main">
        <header>
            <div class="container">
                <a href="#"><img class="logo" src="../images/logo2.png"></a>
                <nav class="navigation">
                    <ul>
                        <li class="nav1"><a href="listecond.php">listes trajets</a></li>
                        <li class="nav1"><a href="reservation.php">Voir Réservations</a></li>
                        <li>
                            <?php if(isset($_SESSION["user_id"])){ ?>
                            <form action="../includes/logout.inc.php" method="post">
                                <button class="logout-icon"><i class="fa-solid fa-right-from-bracket"></i></button>
                            </form>
                            <?php } ?>
                        </li>
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
            <p style="margin:2%;">Aucun passager pour ce trajet</p>
            <hr>
        </div><br><br>
        <div class="parametre">
            <a class="edit" href="edit_trip.php?RideID=<?php echo urlencode($RideID); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modifier votre trajet</a> 
            <a class="delete" href="#" onclick="confirmDelete('<?php echo urlencode($RideID); ?>')">
                <i class="fa fa-trash-o" aria-hidden="true"></i> Annuler votre trajet
            </a>
        </div>
        <div></div>
        <div></div>
    </div>
    <div id="map" style="z-index: -5; display: inline-block; height: 400px; width: 50%; margin-top: 1%;"></div>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                    <button type="button" class="btn btn-danger" onclick="deleteRide('<?php echo $RideID; ?>')">Oui</button>
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
        function showMap(location) {
            // Remplacez 'YOUR_GOOGLE_MAPS_API_KEY' par votre clé API Google Maps
            var apiKey = 'AIzaSyDfYaBDnZ6vo0t_f8ACEzHhJirgcMfwpyI';
            var mapUrl = 'https://www.google.com/maps/embed/v1/place?key=' + apiKey + '&q=' + encodeURIComponent(location);
            window.open(mapUrl, '_blank');
        }
    </script>
    <link rel="stylesheet" href="https://www.bing.com/api/maps/mapcontrol?key=ApE-HNGaFCRDs_bsmYj3Dgak-HaLSYWyN7K35FxHQXjQt8ePrxpy8_uvZoXESwIg&callback=loadMapScenario" async defer>
    
   <!-- Remplacez le script Google Maps par le script Leaflet -->
   <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

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
</body>
</html>
