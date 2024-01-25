<php>
    if (isset($_POST['destination'])) {
    $destination = $_POST['destination'];

 
    $sql = "SELECT * FROM rides WHERE Destination = '$destination' and AvailableSeats>='$seats'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch all results into an array
        $trips = array();
        while ($row = $result->fetch_assoc()) {
            $trips[] = $row;
        }

        // Sort the array of trips based on distance (use your startLat and startLon)
        usort($trips, function ($a, $b) {
            $currentLat = 0; // Replace with the actual current latitude
            $currentLon = 0; // Replace with the actual current longitude

            $distanceA = haversineDistance($currentLat, $currentLon, $a['startLat'], $a['startLon']);
            $distanceB = haversineDistance($currentLat, $currentLon, $b['startLat'], $b['startLon']);

            return $distanceA - $distanceB;
        });
        foreach ($trips as $trip) {
            echo '<div class="trip-container">';
            echo '<strong>Destination:</strong> ' . $trip["Destination"] . '<br>';
            echo '<strong>Current Location:</strong> ' . $trip["CurrentLocation"] . '<br>';
            echo '<strong>Available Seats:</strong> ' . $trip["AvailableSeats"] . '<br>';
            echo '</div>';
        }
    } else {
        echo 'No results found.';
    }
};

<?php>