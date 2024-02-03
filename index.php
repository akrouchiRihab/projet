<?php 
require_once 'includes/config_session.inc.php';
require_once 'includes/login_view.inc.php';
require_once 'includes/search_view.inc.php';
require_once 'includes/search_model.inc.php';



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

<body>

  
  <!-- start header-->
  <div class="main">
    <header>
      <div class="container">


        <a href="index.php"><img class="logo" src="images/twsila.png"></a>


        <nav class="navigation">
          <ul>
            <li><a href="#" class="home"> Acceuil</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="#about"> À propos</a></li>
            <li>
            <?php 
         if(isset($_SESSION["UserID"])){ ?>
              
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
        <h1><span>Trouvez</span> votre trajet en quelques clics <br>ou proposez votre propre <br>trajet dès maintenant!</h1>
        <!--<p>Des innovations technologiques pour stimuler<br> votre croissance et votre efficacité</p> -->
        <?php 
         if(!isset($_SESSION["UserID"])){ ?>
             <a href="signin.php" class="signin_btn" id="signInLink" onclick="signIn()">S'inscrire</a>
        <a href="login.php" class="login_btn" id="loginLink" onclick="login()">Se connecter</a>
        <?php }
        ?>
        <?php 
       
         if(isset($_SESSION["UserID"]) && isset($_SESSION["user_role"]) && $_SESSION["user_role"] == 'driver'){ ?>
             <a href="pages/liste_driver.php" class="proposer_btn" >proposer un trajet</a>  <?php  
             } 
        
         if(isset($_SESSION["UserID"]) && isset($_SESSION["user_role"]) && $_SESSION["user_role"] == 'passenger'){  
         ?>
        <a href="pages/clientlistes.php" class="reserver_btn"  >réserver un trajet</a>
        <?php }   ?>
       
      </div>
     
    </div>
  </div>
  <!-- end header-->
<!--
   //start search form 
  <div class="search-div">
    <h1>rechercher un trajet</h1>
  <form action="includes/search.inc.php" method="post">
      <div class="form-div">
        <label for="departure">Départ:</label>
        <div class="geolocation-container">
        <input type="text" name="depart" id="geolocalisation">
        <button type="button" onclick="obtenirGeolocalisation()">Mettre à jour</button>
      </div>
         </div>
        
      <div class="form-div">
        <label for="destination">Destination:</label>
        <input type="text" name="destination" id="destination">
      </div>

      <div class="form-div">
        <label for="departure_time">temps de départ:</label>
        <input type="datetime-local" name="departure_time" id="departure_time">
      </div>
      
      <button type="submit" class="search_btn" name="btn" value="rechercher">Rechercher</button>

     
    </form>
  
  </div>
         -->
  <!-- start about section-->

  <div class="container about animate-on-visit" data-aos="fadeInLeft" data-aos-once="true" id="about">
    <div class="about-sec">

      <h3>
        twsila a à cœur de <br>
        de contribuer au développement <br>numérique de l’Algérie et de l’Afrique
      </h3>
      <p>nous sommes passionnés par la technologie
        et nous souhaitons partager avec vous notre vision d'un avenir 
        où le covoiturage devient une solution incontournable pour des
         déplacements plus durables et économiques.</p>
    </div>
    <div class="about-sec">
      <img src="images/carp.jpg" class="about-img">
    </div>
  </div>

  <!--end about section-->
  
  

  <!--footer-->
  <footer id="contact">
    <div class="container">
      <div class="flex-box">
        <div class="img">
          <img style="width: 80%; height: 50%;" src="images/twsila.png">
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
          <p>twsila@gmail.com</p>
         
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