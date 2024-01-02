<?php
// Include your database connection file
require_once('includes/db_connect.php');

// Check if rideID is provided in the form submission
if (isset($_POST['ride_id'])) {
    $rideID = $_POST['ride_id'];

    // Fetch the current AvailableSeats value
    $sql = "SELECT AvailableSeats FROM rides WHERE RideID = '$rideID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $availableSeats = $row['AvailableSeats'];

        // Check if there are available seats to reserve
        if ($availableSeats > 0) {
            // Decrement the AvailableSeats value
            $updatedSeats = $availableSeats - 1;

            // Update the database with the new value
            $updateSql = "UPDATE rides SET AvailableSeats = '$updatedSeats' WHERE RideID = '$rideID'";
            if ($conn->query($updateSql) === TRUE) {
                // Handle successful update (e.g., redirect to confirmation page)
                header("Location: process_reservation.php");
                exit();
            } else {
                // Handle update failure
                echo "Error updating record: " . $conn->error;
            }
        } else {
            // Handle case where no available seats are left
            echo "No available seats for reservation.";
        }
    } else {
        // Handle case where rideID is not found
        echo "Ride not found";
    }
} else {
    // Handle case where rideID is not provided
    echo "Invalid access";
}

// Close the database connection
$conn->close();
?>
