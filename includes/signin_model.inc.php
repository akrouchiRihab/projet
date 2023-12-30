
<?php


function get_username(object $pdo, string $firstname, string $lastname)
{
    $query = "SELECT firstname , lastname FROM users WHERE firstname = :firstname and lastname = :lastname;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":firstname", $firstname);
    $stmt->bindParam(":lastname", $lastname);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_email(object $pdo, string $email)
{
    $query = "SELECT email FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}



function set_user($pdo,$email, $firstname ,$lastname,$pwd,$phone,$role){
    $query = "INSERT INTO users (FirstName,Lastname,phonenumber,Email,Role,Password) VALUES (:Firstname ,:Lastname,:phonenumber,:Email,:Role,:Password);";
   $statement = $pdo->prepare($query);

   $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);

   $statement->bindParam(':Firstname', $firstname);
   $statement->bindParam(':Lastname', $lastname);
   $statement->bindParam(':phonenumber', $phone);
   $statement->bindParam(':Email', $email);
   $statement->bindParam(':Role', $role);
   $statement->bindParam(':Password', $hashedPassword);
   $statement->execute();
}

function get_id(object $pdo, string $email){
    $query = "SELECT UserID FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}