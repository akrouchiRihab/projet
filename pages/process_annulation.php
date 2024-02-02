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
        echo 'Échec';
        exit; // Ajout pour arrêter l'exécution du script en cas d'échec
    }

    // Check if the user has already made a reservation for this ride
    $sqlCheckReservation = "SELECT * FROM reservations WHERE RideID = '$rideID' AND UserID = '$userID'";
    $resultCheckReservation = $conn->query($sqlCheckReservation);

    if ($resultCheckReservation->num_rows > 0) {
        // User has made a reservation for this ride, proceed with the cancellation
        // Update the database to increment the number of available seats
        $sqlUpdate = "UPDATE rides SET AvailableSeats = AvailableSeats + 1 WHERE RideID = '$rideID' ";

        if ($conn->query($sqlUpdate) === TRUE) {
            // Delete the row from the reservations table
            $sqlDeleteReservation = "DELETE FROM reservations WHERE RideID = '$rideID' AND UserID = '$userID'";
            if ($conn->query($sqlDeleteReservation) === TRUE) {
            
                echo '<script>alert("Réservation annulée avec succès.");
                window.location.href = "reservation.php"</script>';
            } else {
                echo "Erreur lors de l'annulation de la réservation : " . $conn->error;
            }
        } else {
            echo "Erreur lors de la mise à jour des places disponibles : " . $conn->error;
        }
    } else {
        echo "Aucune réservation trouvée pour ce trajet et cet utilisateur.";
    }
} else {
    echo "Aucun identifiant de trajet fourni.";
}

$conn->close();
?>
