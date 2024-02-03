<?php
// process_reservation.php
session_start();
require('../includes/db_connect.php');

// Check if rideID is provided in the form data
if (isset($_POST['ride_id'])) {
    $rideID = $_POST['ride_id'];

    // Assuming you have a user identifier, replace 'USER_ID' with the actual user identifier
    if (isset($_SESSION["UserID"])) {
        $userID = $_SESSION["UserID"];
    } else {
        echo 'echec';
        exit; // Ajout pour arrêter l'exécution du script en cas d'échec
    }

    // Check if the user has already made a reservation for this ride
    $sqlCheckReservation = "SELECT * FROM reservations WHERE RideID = '$rideID' AND UserID = '$userID'";

    $resultCheckReservation = $conn->query($sqlCheckReservation);

    if ($resultCheckReservation->num_rows > 0) {
        // User has already made a reservation for this ride
        echo '<script>alert("Vous avez déjà réservé une place pour ce trajet."); 
        window.location.href = "reservation.php"; 
        </script>';
        } else {
        // User has not made a reservation for this ride, proceed with the reservation
        // Update the database to decrement the number of available seats
        $sqlUpdate = "UPDATE rides SET AvailableSeats = AvailableSeats - 1 WHERE RideID = '$rideID' AND AvailableSeats > 0";

        if ($conn->query($sqlUpdate) === TRUE) {
            // Insert a new row into the reservations table
            $sqlInsertReservation = "INSERT INTO reservations (RideID, UserID) VALUES ('$rideID', '$userID')";


// Execute the query
$conn->query($sqlInsertReservation);
            if ($conn->query($sqlInsertReservation) === TRUE) {
                // Succès de la réservation
                echo '<script>alert("Réservé avec succès! ");
                window.location.href = "reservation.php"; 
                </script>';
                } else {
                // Erreur lors de l'insertion de la réservation
                echo '<script>alert("Erreur lors de l\'insertion de la réservation : ' . $conn->error . '");
                window.location.href = "reservation.php"; </script>';
            }
        } else {
            // Erreur lors de la mise à jour des places disponibles
            echo '<script>alert("Erreur lors de la mise à jour des places disponibles : ' . $conn->error . '");window.location.href = "reservation.php"; </script>';
        }
    }
} else {
    echo "Erreur : Aucun identifiant de trajet fourni.";
}

$conn->close();
?>
