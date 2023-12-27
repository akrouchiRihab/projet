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
    <title>Modifier le Trajet</title>
</head>
<body>
    <h1>Modifier le Trajet</h1>

    <form method="post" action="edit_trip.php">
        <input type="hidden" name="RideID" value="<?php echo $RideID; ?>">
        
        <label for="DepartureLocation">Lieu de départ:</label>
        <input type="text" name="DepartureLocation" value="<?php echo $DepartureLocation; ?>" required>

        <label for="Destination">Destination:</label>
        <input type="text" name="Destination" value="<?php echo $Destination; ?>" required>

        <label for="DepartureTime">Date et Heure:</label>
        <input type="datetime-local" name="DepartureTime" value="<?php echo $DepartureTime; ?>" required>

        <label for="AvailableSeats">Nombre de places disponibles:</label>
        <input type="number" name="AvailableSeats" value="<?php echo $AvailableSeats; ?>" required>

        <label for="price">Prix par place:</label>
        <input type="text" name="price" value="<?php echo $price; ?>" required>

        <button type="submit">Enregistrer les Modifications</button>
    </form>

    <br>

    <a href="plan_route.php?RideID=<?php echo urlencode($RideID); ?>">Retour aux Détails du Trajet</a>
</body>
</html>

