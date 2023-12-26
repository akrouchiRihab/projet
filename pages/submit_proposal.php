<?php
session_start();
require_once('../includes/db_connect.php'); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $DepartureLocation = $_POST["DepartureLocation"];
    $Destination = $_POST["Destination"];
    $DepartureTime = $_POST["DepartureTime"];
    $AvailableSeats = $_POST["AvailableSeats"];
    $price = $_POST["price"];
    
    // Insert the data into the database (assuming you have a 'trajet' table)
    $sql = "INSERT INTO rides (DepartureLocation, Destination, DepartureTime, AvailableSeats, price) 
            VALUES ('$DepartureLocation', '$Destination', '$DepartureTime', '$AvailableSeats', '$price')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();

    // Redirect to the current page after submitting
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
