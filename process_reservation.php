<?php
// process_reservation.php

require('includes/db_connect.php');

// Check if rideID is provided in the form data
if (isset($_POST['ride_id'])) {
    $rideID = $_POST['ride_id'];

    // Assuming you have a user identifier, replace 'USER_ID' with the actual user identifier
    $userID = 'USER_ID'; // Replace this with the actual user identifier or use your authentication system

    // Check if the user has already made a reservation for this ride
    $sqlCheckReservation = "SELECT * FROM reservations WHERE RideID = '$rideID' AND UserID = '$userID'";

    $resultCheckReservation = $conn->query($sqlCheckReservation);

    if ($resultCheckReservation->num_rows > 0) {
        // User has already made a reservation for this ride
        echo "Vous avez déjà réservé une place pour ce trajet.";
        echo '<a href="reservation.php">voir mes reservation</a>';
    } else {
        // User has not made a reservation for this ride, proceed with the reservation
        // Update the database to decrement the number of available seats
        $sqlUpdate = "UPDATE rides SET AvailableSeats = AvailableSeats - 1 WHERE RideID = '$rideID' AND AvailableSeats > 0";

        if ($conn->query($sqlUpdate) === TRUE) {
            // Insert a new row into the reservations table
            $sqlInsertReservation = "INSERT INTO reservations (RideID, UserID) VALUES ('$rideID', '$userID')";

            if ($conn->query($sqlInsertReservation) === TRUE) {
                echo "Réservé avec succès!";
                echo '<a href="reservation.php">voir mes reservation</a>';
            } else {
                echo "Erreur lors de l'insertion de la réservation : " . $conn->error;
            }
        } else {
            echo "Erreur lors de la réservation : " . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Erreur : Aucun identifiant de trajet fourni.";
}
?>
