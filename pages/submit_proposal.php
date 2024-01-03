<?php
session_start();
require_once('../includes/db_connect.php'); // Inclure votre fichier de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier si la clé "email" existe dans le tableau $_POST
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        
        require_once '../includes/dbh.inc.php';
        require_once '../includes/login_model.inc.php';
        
        $result = get_email($pdo, $email);
        
        $user_id = get_user_id($pdo, $email);
        $_SESSION["user_id"] = (int) $user_id;

        // Vérifier si l'utilisateur est connecté
        if (isset($_SESSION["user_id"])) {
            // Récupérer l'ID de l'utilisateur connecté
            $DriverID = $_SESSION["user_id"];

            // Récupérer les autres champs du formulaire
            $DepartureLocation = $_POST["DepartureLocation"];
            $Destination = $_POST["Destination"];
            $DepartureTime = $_POST["DepartureTime"];
            $AvailableSeats = $_POST["AvailableSeats"];
            $price = $_POST["price"];

            // Insérer les données dans la base de données
            $sql = "INSERT INTO rides (DriverID, DepartureLocation, Destination, DepartureTime, AvailableSeats, price) 
                    VALUES ('$DriverID', '$DepartureLocation', '$Destination', '$DepartureTime', '$AvailableSeats', '$price')";

            if ($pdo->query($sql) === TRUE) {
                echo "Nouvel enregistrement créé avec succès";
            } else {
                echo "Erreur : " . $sql . "<br>" . $pdo->error;
            }

            // Rediriger vers la page précédente après la soumission
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
            echo "L'utilisateur n'est pas connecté.";
        }
    } else {
        echo "La clé 'email' n'est pas définie dans la requête POST.";
    }
} 
?>

