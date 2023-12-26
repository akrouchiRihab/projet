<?php
session_start();
require_once('../includes/db_connect.php'); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $RideID = $_POST["RideID"];
    $DepartureLocation = $_POST["DepartureLocation"];
    $Destination = $_POST["Destination"];
    $DepartureTime = $_POST["DepartureTime"];
    $AvailableSeats = $_POST["AvailableSeats"];
    $price = $_POST["price"];
    
    // Insert the data into the database (assuming you have a 'trajet' table)
    $sql = "INSERT INTO trajet (DepartureLocation, Destination, DepartureTime, AvaailableSeats, price) VALUES ('$DepartureLocation', '$Destination', '$DepartureTime', '$AvailableSeats', '$price')";
    mysqli_query($conn, $sql);

    // Close the database connection
    mysqli_close($conn);

    // Redirect to the current page after submitting
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <script src="https://cdn.jsdelivr.net/npm/smooth-scroll@16.1.3/dist/smooth-scroll.polyfills.min.js"></script>
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style2.css">
    <title>Conducteur</title>
    <script>
        var scroll = new SmoothScroll('a[href*="#"]');
    </script>
    <style>
        .main{
    min-height: auto;
    
}
 .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

    </style>
</head>
<body>
<div class="main">
    <header>
        <div class="container">
            <a href="#"><img class="logo" src="../images/logo2.png"></a>
    
            <nav class="navigation">
                <ul>
                    <li class="nav1"><a href="reservation.php" class="home">Voir Réservations</a></li>
                    <li>
                        
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    </div>
    <div class="container">
        <div class="col-2">
            <br/>
            <a id="openModal" class="proposer_btn" >+ proposer un trajet</a>
        </div>
        <br/>
        <div>
            <div class="div-content">
            <?php
// Fetch data from the database
$sql = "SELECT * FROM rides";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo '<a href="plan_route.php?RideID=' . urlencode($row["RideID"]) . '">';
        echo '<div class="station">';
        echo '<p>Depart: ' . $row["DepartureLocation"] . '</p>';
        echo '<p>Destination: ' . $row["Destination"] . '</p>';
        echo '<p>Date/Heure: ' . $row["DepartureTime"] . '</p>';
        echo '<p>Nombre de places: ' . $row["AvailableSeats"] . '</p>';
        if ($row["price"] !== "") {
            echo '<p style="margin-left: 250px;">Prix: ' . $row["price"] . '</p>';
        }
        echo '</div>';
        echo '</a>';
    }
} else {
    echo "0 results";
}

?>
      
</div>
        </div>
    </div>
    <div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="proposalForm" method="post" action="submit_proposal.php">
            <label for="DepartureLocation">Lien de départ:</label>
            <input type="text" name="DepartureLocation" required>

            <label for="Destination">Destination:</label>
            <input type="text" name="Destination" required>

            <label for="DepartureTime">Date et Heure:</label>
            <input type="datetime-local" name="DepartureTime" required>

            <label for="AvailableSeats">Nombre de places disponibles:</label>
            <input type="number" name="AvailableSeats" required>

            <label for="price">Prix par place:</label>
            <input type="text" name="price" required>

            <input type="submit" value="Proposer">
        </form>
    </div>
</div>
</div>
</body>
<script>
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("openModal");
    var span = document.getElementsByClassName("close")[0];
    btn.onclick = function() {
        modal.style.display = "block";
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</html>
