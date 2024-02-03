<?php
  require_once 'includes/signin_view.inc.php';
  require_once 'includes/config_session.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <title>S'inscrire</title>
    <style>
      .role-select {
 width: 80%;
 margin-left: 2%;
  padding: 8px 12px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  background-color: #fff;
  cursor: pointer;
}

.role-select:focus {
  outline: none;
  border-color: #007bff; /* Couleur de la bordure lorsqu'il est en focus */
  box-shadow: 0 0 5px rgba(0, 123, 255, 0.5); /* Ombre lorsqu'il est en focus */
}
   </style>
</head>
<body>
    <form action="includes/signin.inc.php" name="formfill"  id="my-form" method="post" class="form">
  
        <div class="wrapper">
          <h1>s'inscrire</h1>
          
          <div class="input-data">
             <input type="text" name="firstname" id="user-name"  autocomplete="off"  onkeyup="validateusername()" onsubmit="validateuser()"> 
             <div class="underline"></div> 
             <label id="username-label" > <i class="fa-solid fa-user icon"></i> nom </label>
             <span id="username-error"></span>
          </div>
         
          <div class="input-data">
            <input type="text" name="lastname" id="user-name"  autocomplete="off"  onkeyup="validateuserp()" onsubmit="validateuser()"> 
            <div class="underline"></div> 
            <label id="userp-label" > <i class="fa-solid fa-user icon"></i> prénom </label>
            <span id="userp-error"></span>
         </div>
          
             <div class="input-data">
                <input type="email" name="email" id="email" autocomplete="off" onkeyup="validateemail()" >
                <div class="underline"></div>
                <label id="email-label"><i class="fa-solid fa-envelope iconemail"></i>Email</label>
                <span id="email-error"></span>
             </div>
             <div class="input-data">
               <input type="phone" name="phone" id="phone" autocomplete="off" onkeyup="validatePhoneNumber()" >
               <div class="underline"></div>
               <label id="phone-label"><i class="fa-solid fa-phone iconemail"></i>numéro de téléphone</label>
               <span id="phone-error"></span>
            </div>

            <div class="selection">
            <label for="role" class="role-label">Role:</label>
               <select id="role" name="role" class="role-select"required>
                  <option value="driver">Driver</option>
                  <option value="passenger">Passenger</option>
               </select>
            </div>
              
            
          <div class="input-data">
            <input type="password" name="pwd" id="pwd" autocomplete="off" onkeyup="validatepwd()" >
            <div class="underline"></div>
            <label id="pwd-label"><i class="fa-solid fa-lock icon"></i> mot de passe</label>
            <span id="pwd-error"></span>
         </div>
         <div class="input-data">
            <input type="password" name="cpwd" id="cpwd" onkeyup="validatecpwd()">
            <div class="underline"></div>
            <label id="cpwd-label"><i class="fa-solid fa-lock icon"></i> Confirmer mot de passe</label>
            <span id="cpwd-error"></span>
         </div>
        
        
        
         <input type="submit" name="" value="s'inscrire" onclick="return validateform()">
         <span id="submit-error"></span>
         <?php
         check_signin_errors();
        ?>
        </div>
        </form>
        
        
     <script src="js/signin.js"></script>  
</body>
</html>