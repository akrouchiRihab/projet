<?php

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    

    try{
         require_once 'dbh.inc.php';
         
         require_once 'login_model.inc.php';
         require_once 'login_contr.inc.php';
         require_once 'config_session.inc.php';//contient session_start
        
          // ERROR HANDLERS
          $errors = [];

          if ( is_input_empty($email,$pwd)){
             $errors["empty_input"] = "fill in all fields!";
          }
          
          $result=get_email($pdo , $email);
          
<<<<<<< HEAD
          $id=get_id($pdo , $email);
=======
          /*$id=get_id($pdo , $email);*/
>>>>>>> 9b3ae4a86a8a0ea459a746b33969f9153fd4f9aa
          $_SESSION["user_id"] = (int) $id["UserId"];

          if(is_email_wrong($result)){
            $errors["email_invalid"] = "email n'existe pas";
          }
          
           if(!is_email_wrong($result) && is_pwd_wrong($pwd,$result["Password"])){
            $errors["email_invalid"] = "mot de passe incorrect!";
          }
 
          
  
          if($errors){
            $_SESSION["errors_login"]=$errors;
 
 
            header("Location:../login.php");
            die();
          }

          /*if(isset($result['Role'])){
            echo'yes';
            $_SESSION["user_id"] = (int) $id["UserId"];
            $userID = $_SESSION["user_id"];
            if ($result['Role'] === 'driver') {
              header('Location: ../pages/listecond.php');
              exit();
          } elseif ($result['Role'] === 'passenger') {
              header('Location: ../clientlistes.php');
              exit();
          }
          }*/
          
          
          $_SESSION["user_fname"] = htmlspecialchars($result["FirstName"]); 
          $_SESSION["user_lname"] = htmlspecialchars($result["LastName"]);
          $_SESSION["user_phone"] = htmlspecialchars($result["phonenumber"]);
          $_SESSION["user_role"] = htmlspecialchars($result["Role"]);

          $pdo=null;
          $stmt=null;
          header("Location:../index.php?login=success");
          
          die();

    }catch(PDOException $e){
        die("Query failed: " .$e->getMessage());
     }
}
else{
    header("Location:../login.php");
    die();
}