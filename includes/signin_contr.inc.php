<?php
declare(strict_types=1);

//verifier que les champs sont toute remplie
function is_input_empty(string $firstname,string $lastname,string $email,string $pwd,string $cpwd,$phone) {
     if(empty($firstname) || empty($lastname) || empty($email) || empty($pwd) || empty($cpwd) || empty($phone)){
         return true;
     }else{
        return false; 
     }
}

//verifier que l'email est valide
function is_email_invalid (string $email) {
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }else{
       return false; 
    }
}
function checkPasswordMatch($pwd, $cpwd) {
    return $pwd === $cpwd;
}
function is_pwd_nomatch(string $pwd,string $cpwd){
    
 if (!checkPasswordMatch($pwd, $cpwd)) {
        // Les mots de passe ne correspondent pas
        return true;
    }
      
}

function is_username_taken(object $pdo,string $firstname,string $lastname)
{
    if(get_username($pdo, $firstname , $lastname)){
        return true;
    }else{
        return false;
    }
}

function is_email_registered(object $pdo,string $email)
{
    if(get_email($pdo, $email)){
        return true;
    }else{
        return false;
    }
}

function create_user(object $pdo,string $email,string $firstname ,string $lastname,string $pwd,string $phone){
   set_user($pdo,$email,$firstname ,$lastname,$pwd,$phone);
}
