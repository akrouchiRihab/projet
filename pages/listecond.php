<?php
require_once '../includes/config_session.inc.php';
require_once('../includes/db_connect.php'); // Include your database connection file

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <script src="https://cdn.jsdelivr.net/npm/smooth-scroll@16.1.3/dist/smooth-scroll.polyfills.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style2.css">
    <link rel="icon" href="../images/tt.png" type="image/x-icon">
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
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 3% auto;
    padding: 25px;
    border: 1px solid #888;
    width: 60%;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}

.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-content form label {
    justify-content: center;
    align-items: center;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 5px;
    display: inline-block;
    width: 35%;
}

.modal-content form input {
    align-items: center;
    font-size: 16px;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    display: inline-block;
    width: 50%;
}
.modal-content form input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    margin-left: 35%;
    width:30%;
}

.modal-content form input[type="submit"]:hover {
    background-color: #45a049;
}
/* Style the button that opens the modal */
.modal button {
    background-color: #3e1f92;
    color: white;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    text-align: center;
    display: inline-block;
    font-size: 15px;
    margin: 4px 2px;
    transition: 0.3s;
    border-radius: 4px;
}

/* Change the background color of the button on hover */
.modal button:hover {
    background-color: #3e1f91;
}

.div-content {
    font-size: 0; /* Fix pour éliminer l'espace blanc entre les éléments inline-block */
}

.station {
    display: inline-block;
    width: 48%; /* Ajuste la largeur pour deux éléments par ligne */
    margin-bottom: 20px;
    margin-right: 20px;
    background-color: #f5f5f5;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 10px;
    box-sizing: border-box;
    vertical-align: top; /* Ajuste l'alignement vertical au sommet */
    font-size: 16px; /* Réinitialise la taille de la police après le fix de font-size: 0; */
}

.station h2,
.passenger h2 {
    font-size: 18px;
    font-weight: bold;
    margin-right: 10px;
}

.station p,
.passenger p {
    font-size: 16px;
    color: #333;
}

.station p {
    font-size: 16px;
    margin-right: 10px;
}

.station h2 {
    font-size: 18px;
    font-weight: bold;
    margin-right: 10px;
}
.navigation{
    margin-left:50%;
}
    </style>
</head>
<body>
<div class="main">
    <header>
        <div class="container">
            <a href="#"><img class="logo" src="../images/twsil3.png"></a>
    
            <nav class="navigation">
                <ul>
                    <li><a href="../reservation.php" class="logout">Voir Réservations</a></li>
                    <li><a href="../includes/logout.inc.php" class="logout">Déconnexion</a></li>
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

/*$result = $conn->query($sql);*/

$DriverID = $_SESSION["UserID"];
$sql = "SELECT * FROM rides WHERE DriverID = ?";
$statement = $conn->prepare($sql);
$statement->bind_param('i', $DriverID);
$statement->execute();
$result = $statement->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<a style=" height:auto;" href="plan_route.php?RideID=' . urlencode($row["RideID"]) . '">';
        echo '<div class="station">';
        echo '<p style="font-weight: bold; text-align: center;">' . $row["DepartureTime"] . '</p>';
        echo '<br/>';
        echo '<span style="color: black; text-decoration: none; font-size: 20px; display: inline-block;" class="fas fa-map-marker-alt"></span>     <p style=" display: inline-block;">' . $row["DepartureLocation"] . '</p>';
        if ($row["price"] !== "") {
            echo '<p style=" font-weight: bold; margin-left: 85% ; display: inline-block;" class="price" style="margin-left: 250px;">' . $row["price"] . '</p>';
        }
        echo '<br/>';
        echo '<span style="color: black; text-decoration: none; font-size: 20px; display: inline-block;" class="fas fa-flag"></span>     <p style=" display: inline-block;"> ' . $row["Destination"] . '</p>';
        echo '<p style="display: inline-block; font-size: 30px; margin-left: 80%;">' . $row["AvailableSeats"] . '</p><img style="display: inline-block;  width: 7%; height:7%;" src="../images/car-seat.png"/>';
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
            <label for="DepartureLocation">Lieu de départ</label>
            <input type="text" placeholder="Saisissez le lieu de départ" name="DepartureLocation" id="departureLocation" required>
            <button><a alt="votre location" class='fas fa-map-marker-alt'></a></button>
            <br/>

            <label for="Destination">Destination</label>
            <input type="text" name="Destination" placeholder="Saisissez la destination" id="destinationLocation" required>
            <br/>

            <label for="DepartureTime">Date et Heure</label>
            <input placeholder="Quand partez-vous ?" class="flatpickr" type="datetime-local" name="DepartureTime" required>
            <br/>
            
            <label for="AvailableSeats">Nombre de places </label>
            <input placeholder="Combien de passagers pouvez-vous accepter ?" type="number" name="AvailableSeats" required>
            <br/>
            <label for="price">Prix </label>
            <input placeholder="Fixez votre prix par place"  type="text" name="price" required>
            <br/><br/>
           
            <?php if (isset($_SESSION['errorMessages'])): ?>
                <div style="color: red; width: 80%; margin-bottom: 10px;"><?php echo $_SESSION['errorMessages']; ?></div>
                <?php unset($_SESSION['errorMessages']); // Effacer les messages après les avoir affichés ?>
            <?php endif; ?>
            
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
<script>
        flatpickr(".flatpickr", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            // Ajoutez d'autres options selon vos besoins
        });
</script>
</html>
