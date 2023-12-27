<?php 
require_once 'includes/config_session.inc.php';
require_once 'includes/login_view.inc.php';
require_once 'includes/search_view.inc.php';
require_once 'includes/search_model.inc.php';
require_once 'includes/dbh.inc.php';


$result=[];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <script src="https://cdn.jsdelivr.net/npm/smooth-scroll@16.1.3/dist/smooth-scroll.polyfills.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  
  

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
  <title>Acceuil</title>
  <script>
    var scroll = new SmoothScroll('a[href*="#"]');
  </script>


</head>

<body class="client" >

  
  <!-- start header-->
  <div class="main">
    <header>
      <div class="container">


        <a href="#"><img class="logo" src="images/logo.png"></a>


        <nav class="navigation">
          <ul>
            <li><a href="#" class="home"> Acceuil</a></li>

            <li><a href="#contact">Contact</a></li>
            <li><a href="#about"> À propos</a></li>
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
      
  <style>

        .square {
            align-items: center;
            border-radius: 10px;
            width: 500px;
            height: 300px;
            border-color: gray;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1);
            background-color: whitesmoke; /* Couleur de fond des carrés */
            margin: 10px; /* Marge entre les carrés */
        }
    </style>
  <?php  
   $rideId = 1; // Remplacez 1 par l'ID du trajet que vous souhaitez afficher
   $sql = "SELECT DepartureLocation, Destination, DepartureTime, DriverID FROM Rides WHERE RideID = :rideId";

   // Préparation de la requête
   $stmt = $pdo->prepare($sql);
   $stmt->bindParam(':rideId', $rideId, PDO::PARAM_INT);

   // Exécution de la requête
   $stmt->execute();

   // Récupération des résultats
   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($row) {
       // Afficher les données
       echo "<p>Départ: " . $row["DepartureLocation"] . "</p>";
       echo "<p>Destination: " . $row["Destination"] . "</p>";
       echo "<p>Heure de départ: " . $row["DepartureTime"] . "</p>";
       echo "<p>Conducteur: " . $row["Driver"] . "</p>";
   }
  ?>
    <div class="container">
        <h1>Trajets</h1>
        <div class="square">
    <form id="rideForm">
        Départ: <input type="text" name="departure_location" required>
        <br>
        Destination: <input type="text" name="destination" required>
        <br>
        Heure de départ: <input type="datetime-local" name="departure_time" required>
        <br>
        Conducteur: <input type="text" name="driver" required>
        <br>
        <button type="button" onclick="submitForm()">Soumettre</button>
    </form>
</div>

        <div class="square"></div>
        <div class="square"></div>
        <div class="square"></div>
        <div class="square"></div>
        <div class="square"></div>
        <!-- Ajoutez plus de carrés si nécessaire -->
    </div>


    </div>
  </div>
  <!-- end header-->

 

  <!--end about section-->
  
  

  <!--footer-->
  <footer id="contact">
    <div class="container">
      <div class="flex-box">
        <div class="img">
          <img src="images/logo.png">
        </div>

        <div class="contact-foot">
          <h2>Contact</h2>
          <p>Bonjour, nous sommes toujours
            ouverts à la coopération et aux suggestions
            . Contactez-nous de l'une des manières suivantes :
          </p>
          <span>Adresse</span>
          <p>USTHB Bab-zouar</p>
          <span>phone</span>
          <p>+0123 4567 8910</p>
          <span>Email</span>
          <p>pweb@usthb.dz</p>
         
        </div>
       
      </div>

    </div>

    <div class="bottom">
      <p>Powered by <span>USTHB</span> - Designed by <span>Algerian students</span></p>
    </div>
  </footer>
  <!--end footer-->

  <script src="js/homepage.js"></script>
  <script src="js/geo.js"></script>
  
  
 
 

</body>

</html>