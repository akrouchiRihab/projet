<?php 
declare(strict_types=1);

function is_email_wrong(bool|array $result){
   if(!$result){  //si result=false
    //ya pas l'email dans la base de donnée
      return true;

   }else{
    return false; // email exist
   }
   
}

function is_pwd_wrong(string $pwd ,string $hashedpwd){
    if(!password_verify($pwd,$hashedpwd)){ 
       return true;
 
    }else{
     return false; 
    }
    
 }

 function is_input_empty(string $email, string $pwd){
    if(empty($email) || empty($pwd)){
        return true;
    }else{
        return false;
    }
 }