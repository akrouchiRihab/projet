
<?php 

require_once('../includes/db_connect.php'); // Include your database connection file
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['destination'], $_POST['seats'])) {
    $destination = $_POST['destination'];
    $seats = $_POST['seats'];

    // Perform database query (modify as per your database schema)
    $sql = "SELECT *,DepartureLocation FROM rides r,users u WHERE Destination = '$destination' AND AvailableSeats >= '$seats' and u.userID=r.driverID";
   $result = $conn->query($sql); // Uncomment and modify according to your database connection
   function fetchCoordinates($cityName) {
    $geocodeUrl = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($cityName);

    $ch = curl_init($geocodeUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'MyGeocodingApp');
    
    $geocodeData = curl_exec($ch);
    
    curl_close($ch);

    $geocodeData = json_decode($geocodeData, true);

    if (!empty($geocodeData) && isset($geocodeData[0]['lat']) && isset($geocodeData[0]['lon'])) {
        return [
            'lat' => $geocodeData[0]['lat'],
            'lon' => $geocodeData[0]['lon'],
        ];
    } else {
        return ['lat' => 0, 'lon' => 0];
    }
}

    // Assuming $result is your query result
    if ($result->num_rows > 0) {
        // Fetch all results into an array
        $trips = array();
        while ($row = $result->fetch_assoc()) {
            // ... Your existing code
        
            // Fetch coordinates dynamically based on the city name
            $cityName = $row['DepartureLocation'];
            $coordinates = fetchCoordinates($cityName);
        
            // Add fetched coordinates to the $row array
            $row['startLat'] = $coordinates['lat'];
            $row['startLon'] = $coordinates['lon'];
        
            // Push the row to the $trips array
            $trips[] = $row;
        }
        function haversineDistance($lat1, $lon1, $lat2, $lon2) {
            $R = 6371;
            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);
            $a = sin($dLat / 2) * sin($dLat / 2) +
                cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = $R * $c;
            return $distance;
        }
        // Sort the array of trips based on distance (use your startLat and startLon)
        usort($trips, function ($a, $b) {
            $currentLat = $_POST['positionLatitude']; // Replace with the actual current latitude
            $currentLon = $_POST['positionLongitude']; // Replace with the actual current longitude

            $distanceA = haversineDistance($currentLat, $currentLon, $a['startLat'], $a['startLon']);
            $distanceB = haversineDistance($currentLat, $currentLon, $b['startLat'], $b['startLon']);

            return $distanceA - $distanceB;
        });

        header('Content-Type: application/json');

if (!empty($trips)) {
    echo json_encode($trips);
} else {
    echo '[]';
}
    }
}
    ?>