<?php 
// Assurez-vous que vous avez la connexion à la base de données
// Include your database connection file
session_start();
require_once('../includes/db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <script src="https://cdn.jsdelivr.net/npm/smooth-scroll@16.1.3/dist/smooth-scroll.polyfills.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style2.css">
    <link rel="icon" href="../images/logopage.png" type="image/x-icon">
    <title>Twsila - Conducteur</title>
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



#bingMap {
    display: flex;
    flex: 1;
    height: 400px; 
    width: 100%;
}

    </style>
</head>
<body>
<div class="main">
    <header>
        <div class="container">
            <a href="listecond.php"><img class="logo" src="../images/twsil3.png"></a>
    
            <nav class="navigation">
                <ul style="margin-left: 60%;">
                     <li>
                     <li><a href="listecond.php" class="logout">listes trajets</a></li>
                     <li><a href="../includes/logout.inc.php" class="logout">Déconnexion</a></li>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    </div>
    <div class="container">
        <div class="col-2">
            <br/>
        </div>
        <br/>
        <div>
            <div class="div-content">
            <?php
// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['UserID'])) {
    $userID = $_SESSION['UserID'];

    // Vérifier si la connexion à la base de données est établie
    if ($conn) {
        // Requête SQL
        $sql = "SELECT
                    rides.DepartureLocation,
                    rides.Destination,
                    rides.DepartureTime,
                    rides.AvailableSeats,
                    rides.price,
                    users.FirstName,
                    users.LastName,
                    users.phonenumber
                FROM
                    reservations
                JOIN
                    rides ON reservations.RideID = rides.RideID
                JOIN
                    users ON reservations.UserID = users.UserID
                WHERE
                    rides.DriverID = ?";

        // Préparation de la requête
        $statement = $conn->prepare($sql);

        // Vérifier si la préparation de la requête a réussi
        if ($statement) {
            $statement->bind_param('i', $userID);
            $statement->execute();
            $result = $statement->get_result();

            // Affichage des résultats
            while ($row = $result->fetch_assoc()) {
                // Afficher les informations de réservation, trajet et client
                echo '<a style=" height:auto;">';
                echo '<div class="station">';
                echo '<p style="font-weight: bold; text-align: center;">' . $row["DepartureTime"] . '</p>';
                echo '<span style="color: black; text-decoration: none; font-size: 20px; display: inline-block;" class="fas fa-map-marker-alt"></span>     <p style=" display: inline-block;">' . $row["DepartureLocation"] . '</p>';
                echo '<p style=" font-weight: bold; margin-left: 85% ; display: inline-block;" class="price" style="margin-left: 250px;">' . $row["price"] . '</p>';
                echo '<span style="color: black; text-decoration: none; font-size: 20px; display: inline-block;" class="fas fa-flag"></span>     <p style=" display: inline-block;"> ' . $row["Destination"] . '</p>';
                echo '<br/>';
                echo '<br/>';
                echo '<p style="text-align: center;">Places disponibles: <strong>' . $row['AvailableSeats'] . '</strong></p>';
                echo '<p style="text-align: center;">Nom du client: <strong>' . $row['FirstName'] . ' ' . $row['LastName'] . '</strong></p>';
                echo '<p style="text-align: center;">Numero telephone du client: <strong>' . $row['phonenumber'] . '</strong></p>';
                echo '</div>';
                echo '</a>';
 
            }

            // Fermer la connexion et la requête
            $statement->close();
        } else {
            // Gérer l'échec de la préparation de la requête
            echo "Erreur lors de la préparation de la requête.";
        }

        $conn->close();
    } else {
        // Gérer l'échec de la connexion à la base de données
        echo "Erreur de connexion à la base de données.";
    }
}
?>     
</div>
        </div>
    </div>
   
    
</div>
</div>
</body>
<script>
        flatpickr(".flatpickr", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            // Ajoutez d'autres options selon vos besoins
        });
</script>

</html>

