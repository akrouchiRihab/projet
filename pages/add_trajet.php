<?php
session_start();
require_once('../includes/db_connect.php');
require_once '../includes/login_model.inc.php';
require_once('../includes/dbh.inc.php');
var_dump($_POST);

// Initialiser les messages d'erreur à une chaîne vide
$errorMessages = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION["UserID"])) {
        // Récupérer l'ID de l'utilisateur connecté
        $DriverID = $_SESSION["UserID"];

        // Récupérer les autres champs du formulaire
        $DepartureLocation = $_POST["DepartureLocation"];
        $Destination = $_POST["Destination"];
        $DepartureTime = $_POST["DepartureTime"];
        $AvailableSeats = $_POST["AvailableSeats"];
        $price = $_POST["price"];
        $destinationLatitude = $_POST["destinationLatitude"];
        $destinationLongitude = $_POST["destinationLongitude"];
        $positionLatitude = $_POST['positionLatitude'];
        $positionLongitude = $_POST['positionLongitude'];
        // Vérifier que la date et l'heure fournies ne sont pas inférieures à la date et à l'heure actuelles
        $currentDateTime = date('Y-m-d H:i:s');
        if ($DepartureTime < $currentDateTime) {
            $errorMessages .= "La date et l'heure de départ ne peuvent pas être inférieures à la date et à l'heure actuelles.";
        }

        // Vérifier que le nombre de places est supérieur ou égal à 4
        if ($AvailableSeats > 4) {
            $errorMessages .= "/ Le nombre de places doit être au moins 4.";
        }

        // Si des erreurs sont détectées, afficher les messages d'erreur et arrêter l'exécution
        if (!empty($errorMessages)) {
            $_SESSION['ride_creation_errors'] = $errorMessages;
        }

        // Ajouter "DA" après le prix
        $price = $price . " DA";

        // Insérer les données dans la base de données
        $sql = "INSERT INTO rides (DriverID, DepartureLocation, Destination, DepartureTime, AvailableSeats, price, destinationLatitude, destinationLongitude, positionLatitude, positionLongitude ) 
                VALUES ('$DriverID', '$DepartureLocation', '$Destination', '$DepartureTime', '$AvailableSeats', '$price', '$destinationLatitude', '$destinationLongitude', '$positionLatitude', '$positionLongitude')";

        // Exécuter la requête SQL
        if ($pdo->query($sql)) {
            echo "Nouvel enregistrement créé avec succès";
        } else {
            echo "Erreur : " . $sql . "<br>" . $pdo->errorInfo()[2];
        }

        // Rediriger vers la page précédente après la soumission
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "L'utilisateur n'est pas connecté.";
    }
} else {
    echo "La requête n'est pas une requête POST.";
}
?>
