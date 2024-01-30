<?php
// Vérifier si les données nécessaires sont présentes
if (isset($_POST['latitude']) && isset($_POST['longitude'])) {
    // Récupérer les valeurs de latitude et de longitude
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Enregistrez ces valeurs dans votre base de données comme vous le feriez normalement
    // Assurez-vous de sécuriser vos requêtes pour éviter les injections SQL

    // Exemple de connexion à la base de données (remplacez les informations appropriées)
    require_once '../includes/db_connect.php';

    // Exemple de requête SQL pour insérer les données dans une table 'locations'
    $sql = "INSERT INTO ride (latitude, longitude) VALUES (?, ?)";
    $statement = $conn->prepare($sql);
    $statement->bind_param('dd', $latitude, $longitude);

    if ($statement->execute()) {
        // Succès
        echo 'Location enregistrée avec succès dans la base de données.';
    } else {
        // Échec
        echo 'Erreur lors de l\'enregistrement de la location dans la base de données.';
    }

    // Fermer la connexion
    $statement->close();
    $conn->close();
} else {
    // Données manquantes
    echo 'Données manquantes.';
}
?>
