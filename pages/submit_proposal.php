<?php
require_once '../includes/config_session.inc.php';
require_once('../includes/db_connect.php'); // Inclure votre fichier de connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION["UserID"])) {
    // Récupérer l'ID de l'utilisateur connecté
    $DriverID = $_SESSION["UserID"];
    echo 'your id is'.$DriverID;}
    if($_SERVER["REQUEST_METHOD"]==="POST"){
    // Récupérer les autres champs du formulaire
    $DepartureLocation = $_POST["DepartureLocation"];
    $Destination = $_POST["Destination"];
    $DepartureTime = $_POST["DepartureTime"];
    $AvailableSeats = $_POST["AvailableSeats"];
    $price = $_POST["price"];

    // Insérer les données dans la base de données
    $sql = "INSERT INTO rides (DriverID, DepartureLocation, Destination, DepartureTime, AvailableSeats, price) 
            VALUES ('$DriverID', '$DepartureLocation', '$Destination', '$DepartureTime', '$AvailableSeats', '$price')";

    if ($conn->query($sql) === TRUE) {
        echo "Nouvel enregistrement créé avec succès";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }

    // Fermer la connexion à la base de données
    $conn->close();

    // Rediriger vers la page précédente après la soumission
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else if (!isset($_SESSION["user_id"])){
    echo "L'utilisateur n'est pas connecté.";
}

?>
