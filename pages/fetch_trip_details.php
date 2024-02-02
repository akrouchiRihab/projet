<?php
// fetch_trip_details.php


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rideData'])) {
    // Include your database connection file
    require_once('../includes/db_connect.php');

    $rideData = json_decode($_POST['rideData'], true);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM rides WHERE RideID = ?");
    $stmt->bind_param('s', $rideData);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Retrieve other details as needed
        $dayOfWeek = ''; // Add your logic to calculate dayOfWeek
        $details = array(
            'dayOfWeek' => $dayOfWeek,
            'departureTime' => $row['DepartureTime'],
            'departureLocation' => $row['DepartureLocation'],
            'destination' => $row['Destination'],
            'availableSeats' => $row['AvailableSeats']
        );
        error_reporting(E_ALL);
header('Content-Type: application/json'); // Set the content type to JSON
        // Encode the array as JSON and return it
        echo json_encode($details);
    } else {
        // Return an error message if no details found
        echo json_encode(array('error' => 'No details found for the selected trip.'));
    }

    $stmt->close();
    $conn->close();
} else {
    // If the request is not a POST request or missing rideData, handle accordingly
    echo json_encode(array('error' => 'Invalid request or missing rideData.'));
}
?>