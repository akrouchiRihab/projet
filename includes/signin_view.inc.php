<!DOCTYPE html>
<head>
<link rel="stylesheet" href="../css/signin.css">
</head>
<?php



function check_signin_errors(){
    if(isset($_SESSION['errors_signup'])){
        $errors = $_SESSION['errors_signup'];

        echo "<br>";
        
        foreach($errors as $error){ ?>
         <div class=form-error-div>
          <p class="form-error">
         <?php echo  $error ; ?>
           <br>
          </p>
         </div>
       <?php
        }


        //supprimer la variable de session 
        unset($_SESSION['errors_signup']);
    }
    else if (isset($_GET["signin"])&& $_GET["signin"] === "success"){
      echo '<br>';
      echo '<p class="form-success">vous etes inscrit!</p>';
    }
}
?>
</html>
