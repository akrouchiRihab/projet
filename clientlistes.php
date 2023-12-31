<?php require('includes/db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <style>
        .square {
            display: inline-block;
            width: 200px; /* Ajustez la largeur selon vos besoins */
            padding: 10px;
            margin: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Ombre légère */
            border-radius: 5px;
        }
    </style>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
       
        <script src="https://cdn.jsdelivr.net/npm/smooth-scroll@16.1.3/dist/smooth-scroll.polyfills.min.js"></script>
      
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        
        
      
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="css/style2.css">
        <title>Client</title>
        <script>
          var scroll = new SmoothScroll('a[href*="#"]');
        </script>
      
      
      </head>
<body>

    <div class="main">
        <header>
          <div class="container">
    
    
            <a href="#"><img class="logo" src="images/logo2.png"></a>
    
    
            <nav class="navigation">
              <ul>
                 <li>
                <?php 
             if(isset($_SESSION["user_id"])){ ?>
                  
          <form action="includes/logout.inc.php" method="post">
             <button class="logout-icon"><i class="fa-solid fa-right-from-bracket" ></i></button>
          </form>
            <?php }
            ?>
                </li>
              </ul>
              
            </nav>
    
    
          </div>
    
        </header>
        <div class="container">
          <div class="col-2">
            <br/>
            <a href="" class="proposer_btn" >rechercher un trajet ?</a>
            
          </div>
          <br/>
          <div class="trajets">
    <h1>Trajets</h1>
    
    <?php
    // Vérifiez la connexion à la base de données
    if ($conn->connect_error) {
        die("La connexion a échoué : " . $conn->connect_error);
    }

    // Récupération des trajets depuis la base de données
    $sql = "SELECT * FROM rides";
    $result = $conn->query($sql);

    // Vérification s'il y a des résultats
    if ($result !== false && $result->num_rows > 0) {
        // Parcours des résultats
        while ($row = $result->fetch_assoc()) {
            echo '<div class="square">';
            echo '    Départ: ' . $row["DepartureLocation"] . '<br>';
            echo '    Destination: ' . $row["Destination"] . '<br>';
            echo '    Heure de départ: ' . $row["DepartureTime"] . '<br>';
            echo '    Conducteur: ' . $row["DriverID"] . '<br>';
            echo '</div>';
        }
    } else {
        echo "Aucun trajet trouvé dans la base de données.";
    }

    // Fermeture de la connexion à la base de données
    $conn->close();
    ?>
</div>

        </div>
      </div>

</body>
</html>
