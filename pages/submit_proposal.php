<?php
session_start();
require_once('../includes/db_connect.php'); // Inclure votre fichier de connexion à la base de données
require_once '../includes/dbh.inc.php';
require_once '../includes/login_model.inc.php';

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

            // Récupérer la date et l'heure actuelles
            $currentDateTime = date('Y-m-d H:i:s');

            // Vérifier que la date et l'heure fournies ne sont pas inférieures à la date et à l'heure actuelles
            if ($_POST["DepartureTime"] < $currentDateTime) {
                $errorMessage = "La date et l'heure de départ ne peuvent pas être inférieures à la date et à l'heure actuelles.";
            } else {
                $DepartureTime = $_POST["DepartureTime"];
                $AvailableSeats = $_POST["AvailableSeats"];
                $price = $_POST["price"];

                // Vérifier que le nombre de places est inférieur à 4
                if ($AvailableSeats < 4) {
                    $errorMessage = "Le nombre de places doit être au moins 4.";
                } else {
                    // Ajouter "DA" après le prix
                    $price = $price . " DA";

                    // Insérer les données dans la base de données
                    $sql = "INSERT INTO rides (DriverID, DepartureLocation, Destination, DepartureTime, AvailableSeats, price) 
                            VALUES ('$DriverID', '$DepartureLocation', '$Destination', '$DepartureTime', '$AvailableSeats', '$price')";

                    if ($pdo->query($sql) === TRUE) {
                        $successMessage = "Nouvel enregistrement créé avec succès";
                        // Rediriger vers la page précédente après la soumission
                        header('Location: ' . $_SERVER['HTTP_REFERER']);
                        exit();
                    } else {
                        $errorMessage = "Erreur : " . $sql . "<br>" . $pdo->error;
                    }
                }
            }
        } else {
            $errorMessage = "L'utilisateur n'est pas connecté.";
        }
    } else {
        $errorMessage = "La clé 'email' n'est pas définie dans la requête POST.";
    }
}
?>
