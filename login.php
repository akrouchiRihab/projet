<?php 
require_once 'includes/config_session.inc.php';
require_once 'includes/login_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <title>Se connecter</title>
</head>
<body>

    <form action="includes/login.inc.php" method="post">
  
        <div class="wrapper">
          <h1>Se connecter</h1>
         
          <div class="input-data">
            <input type="email" name="email" id="email" autocomplete="off" onkeyup="validateemail()">
            <div class="underline"></div>
            <label id="email-label"><i class="fa-solid fa-envelope iconemail"></i> Email</label>
            <span id="email-error"></span>
         </div>
        
          <div class="input-data">
            <input type="password"  name="pwd" id="pwd"  onkeyup="return validatepwd()">
            <div class="underline"></div>
            <label id="pwd-label"><i class="fa-solid fa-lock icon"></i> mot de passe</label>
            <span id="pwd-error"></span>
         </div>
        
        
         <div class="pass"><a>Mot de passe oublié?</a></div>
         <input type="submit" name="" value="Se connecter" onclick="return validateform()">
         <span id="submit-error"></span>
        
        <div class="signin_lnk">
            pas de compte? <a href="signin.php">S'inscrire</a>
        </div>
        <?php
         check_login_errors();
        ?>
        </div>
       
        </form>
        <script src="js/login.js"></script>
</body>
</html>