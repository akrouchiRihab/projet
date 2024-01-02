<?php
// process_reservation.php

require('includes/db_connect.php');
// Check if rideID is provided in the form data
if (isset($_POST['ride_id'])) {
    $rideID = $_POST['ride_id'];

    // Update the database to decrement the number of available seats
    $sqlUpdate = "UPDATE rides SET AvailableSeats = AvailableSeats - 1 WHERE RideID = '$rideID' AND AvailableSeats > 0";

    if ($conn->query($sqlUpdate) === TRUE) {
        echo "Réservé avec succès!";
    } else {
        echo "Erreur lors de la réservation : " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Erreur : Aucun identifiant de trajet fourni.";
}
?>
