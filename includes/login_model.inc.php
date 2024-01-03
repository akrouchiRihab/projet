<?php 
declare(strict_types=1);

function get_email(object $pdo,string $email){
   
    $query = "SELECT * FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_id(object $pdo, string $email){
    $query = "SELECT UserID FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;

}
function get_user_id(object $pdo, string $email): int
{
    $result = get_email($pdo, $email);

    if (!is_email_wrong($result)) {
        return (int)$result["UserId"];
    }

    return 0; // Retourne 0 si l'e-mail n'est pas trouvé
}

?>
