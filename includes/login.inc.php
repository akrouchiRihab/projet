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
          
          $id=get_id($pdo , $email);
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
          
          $_SESSION["user_fname"] = htmlspecialchars($result["FirstName"]); 
          $_SESSION["user_lname"] = htmlspecialchars($result["LastName"]);
          $_SESSION["user_phone"] = htmlspecialchars($result["phonenumber"]);
         

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