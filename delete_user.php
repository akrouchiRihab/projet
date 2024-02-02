<?php
// Connect to your database or include necessary files
require_once './includes/db_connect.php';

// Check if userId is set in the POST request
if (isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Perform the deletion query
    $sql = "DELETE FROM users WHERE UserID = $userId";
    $result = $conn->query($sql);

    // Check if the deletion was successful
    if ($result) {
        echo "User deleted successfully!";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "Invalid request. User ID not provided.";
}
?>
