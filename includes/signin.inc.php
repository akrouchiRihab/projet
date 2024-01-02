<?php
//verifier que le formulaire a été bien remplie
if($_SERVER["REQUEST_METHOD"]==="POST"){

   $firstname = $_POST["firstname"];
   $lastname = $_POST["lastname"];
   $email = $_POST["email"];
   $phone = $_POST["phone"];
   $pwd = $_POST["pwd"];
   $cpwd = $_POST["cpwd"];
   $role = $_POST["role"];

     try{
         require_once 'dbh.inc.php';
         require_once 'signin_model.inc.php';
         require_once 'signin_contr.inc.php';

         // ERROR HANDLERS
         $errors = [];

         if ( is_input_empty($firstname,$lastname,$email,$pwd,$cpwd,$phone,$role)){
            $errors["empty_input"] = "fill in all fields!";
         }
         if ( is_email_invalid ($email)){
            $errors["invalid_email"] = "invalid email";
         }
         if ( is_username_taken($pdo,$firstname,$lastname)){
            $errors["username_taken"] = "username taken";
         }
         if (  is_email_registered($pdo,$email)){
            $errors["email_used"] = "email already registered!";
         }
         if( is_pwd_nomatch($pwd,$cpwd)){
            $errors["pwd_nomatch"] = "password invalid!";
         }

         require_once 'config_session.inc.php';//contient session_start

         if($errors){
           $_SESSION["errors_signup"]=$errors;


           header("Location:../signin.php");
           die();
         }
        
         create_user($pdo,$email, $firstname ,$lastname,$pwd,$phone,$role);

         $id=get_id($pdo , $email);
         $_SESSION["user_id"] = (int) $id["UserId"];
         $_SESSION["user_role"] = $role;

         $pdo=null;
         $stmt=null;
         /*if ($role === 'driver') {
            header('Location: ../pages/listecond.php');
            exit();
        } elseif ($role === 'passenger') {
            header('Location: ../clientlistes.php');
            exit();
        }*/
        header("Location:../index.php?signin=success");
         die();
      

     }catch(PDOException $e){
        die("Query failed: " .$e->getMessage());
     }
}else{
    header("Location:../signin.php");
    die();
}