<?php
// Include your database connection file
require_once('../includes/db_connect.php');

// Check if rideID is provided in the URL for deletion
if (isset($_GET['deleteID'])) {
    $deleteID = $_GET['deleteID'];

    // Perform the delete query (modify as per your database structure)
    $sql = "DELETE FROM rides WHERE RideID = '$deleteID'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Redirect to the same page after deleting
        header('Location: listecond.php');
        exit();
    } else {
        // Handle errors
        echo "Error deleting record: " . mysqli_error($conn);
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
        $availableSeats = $row["AvailableSeats"];
        $price = $row["price"];
    } else {
        // Handle case where rideID is not found
        echo "Ride not found";
        exit();
    }
} else {
    // Handle case where rideID is not provided
    echo "Invalid accessbbbb";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include necessary meta tags, stylesheets, etc. -->
    <title>Plan de Route</title>
</head>
<body>
    <h1>Détails du Trajet</h1>
    <p><strong>Depart:</strong> <?php echo $departureLocation; ?></p>
    <p><strong>Destination:</strong> <?php echo $destination; ?></p>
    <p><strong>Date/Heure:</strong> <?php echo $departureTime; ?></p>
    <p><strong>Nombre de places:</strong> <?php echo $availableSeats; ?></p>
    <p><strong>Prix:</strong> <?php echo $price; ?></p>

    <a href="edit_trip.php?RideID=<?php echo urlencode($RideID); ?>">Modifier</a>
    <a href="?deleteID=<?php echo urlencode($RideID); ?>" onclick="return confirm('Are you sure you want to delete this trip?')">Supprimer</a>

    <br>

    <a href="listecond.php">Retour</a>
</body>
</html>
