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

    // Perform the update query (modify as per your database structure)
    $sql = "UPDATE rides SET 
            DepartureLocation = '$DepartureLocation', 
            Destination = '$Destination', 
            DepartureTime = '$DepartureTime', 
            AvailableSeats = '$AvailableSeats', 
            price = '$price' 
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
    <link rel="stylesheet" href="../css/edit_trip.css">
    <title>Modifier le Trajet</title>
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
    <h1>Modifier le Trajet</h1>

    <form method="post" action="edit_trip.php">
        <input type="hidden" name="RideID" value="<?php echo $RideID; ?>">
        <label for="DepartureLocation">Lieu de départ</label><br>
        <input type="text" name="DepartureLocation" value="<?php echo $DepartureLocation; ?>" required>
        <br>
        <label for="Destination">Destination</label><br>
        <input type="text" name="Destination" value="<?php echo $Destination; ?>" required>
        <br>
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
</html>

