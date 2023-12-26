<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pweb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally, you can set the character set
mysqli_set_charset($conn, "utf8");

// Now $conn is the connection variable that you can use in other parts of your code
?>
