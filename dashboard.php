<?php
   require_once './includes/db_connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta content="width=device-width, initial-scale=1.0" name="viewport">
   <title>Dashboard - Admin</title>
   <meta name="robots" content="noindex, nofollow">
   <meta content="" name="description">
   <meta content="" name="keywords">
   <style>
         html, body {
               scroll-behavior: auto !important;
         }
   </style>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

   <script src="./js/delete_user.js"></script>
   <script src="./js/dashboard.js" defer></script>

   <link href="./styles/navbar.css" rel="stylesheet" type="text/css">
   <link href="./styles/footer.css" rel="stylesheet" type="text/css">

   <link href="./bootstrap/css/all.min.css" rel="stylesheet">
   <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
   <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="./bootstrap/js/all.min.js"></script>
   <link href="./assets/img/favicon.png" rel="icon">
   <link href="./assets/img/apple-touch-icon.png" rel="apple-touch-icon">
   <link href="https://fonts.gstatic.com" rel="preconnect">
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

   <link href="./assets/css/bootstrap-icons.css" rel="stylesheet">
   <link href="./assets/css/boxicons.min.css" rel="stylesheet">
   <link href="./assets/css/quill.snow.css" rel="stylesheet">
   <link href="./assets/css/quill.bubble.css" rel="stylesheet">
   <link href="./assets/css/remixicon.css" rel="stylesheet">
   <link href="./assets/css/simple-datatables.css" rel="stylesheet">
   <link href="./assets/css/style.css" rel="stylesheet">
   <link href="./assets/fonts/bootstrap-icons.woff2" rel="stylesheet">
   <link rel="stylesheet" href="css/style.css">
</head>
<style>
   .canvas {
      max-width: 100%;
      height: 500px;
   }
</style>

<body style="background: #f3f3f3;">
   <header>
      <div class="container">
         <a href="index.php"><img class="logo" src="images/twsila.png"></a>
      </div>
   </header>

   <section class="section dashboard container mt-5">
      <div class="row">
         <div class="col-xl-4 col-md-4">
            <div class="card info-card sales-card">
               <div class="filter">
                
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                     <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                     </li>
                     <li><a class="dropdown-item" href="#">Today</a></li>
                     <li><a class="dropdown-item" href="#">This Month</a></li>
                     <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
               </div>
               <div class="card-body">
                  <h5 class="card-title">Nombre de trajets</span></h5>
                  <div class="d-flex align-items-center">
                     <div class="card-icon rounded-circle d-flex align-items-center justify-content-center p-2"> <img src="./assets/img/car-icon.svg" ></img> </div>
                     <div class="ps-3">
                        <h6>
                           <?php
                              $sql = "SELECT COUNT(*) as rides_count FROM rides";
                              $result = $conn->query($sql);
            
                              if ($result === false) {
                                 die("Error in SQL query: " . $conn->error);
                              }
                              $row = $result->fetch_assoc();
                              $ridesCount = $row['rides_count'];

                              echo $ridesCount;
                           ?>
                        </h6>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-xl-4 col-md-4">
            <div class="card info-card revenue-card">
               <div class="filter">
                 
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                     <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                     </li>
                     <li><a class="dropdown-item" href="#">Today</a></li>
                     <li><a class="dropdown-item" href="#">This Month</a></li>
                     <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
               </div>

               <div class="card-body">
                  <h5 class="card-title">Nombre de clients</span></h5>
                  <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-people"></i></div>
                     <!--<div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-map"></i></div>-->
                     <div class="ps-3">
                        <h6>
                           <?php
                              $sql = "SELECT COUNT(*) as proposal_count FROM users where Role='passenger'";
                              $result = $conn->query($sql);
            
                              if ($result === false) {
                                 die("Error in SQL query: " . $conn->error);
                              }
                              $row = $result->fetch_assoc();
                              $proposalCount = $row['proposal_count'];

                              echo $proposalCount;
                           ?>
                        </h6>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="col-xl-4 col-md-4">
            <div class="card info-card customers-card">
               <div class="filter">
                  
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                     <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                     </li>
                     <li><a class="dropdown-item" href="#">Today</a></li>
                     <li><a class="dropdown-item" href="#">This Month</a></li>
                     <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
               </div>
               <div class="card-body">
                  <h5 class="card-title">Nombre de conducteurs </span></h5>
                  <div class="d-flex align-items-center">
                     <div class="card-icon rounded-circle d-flex align-items-center justify-content-center"> <i class="bi bi-people"></i></div>
                     <div class="ps-3">
                        <h6> 
                           <?php
                              $sql = "SELECT COUNT(*) as user_count FROM users where Role='driver' ";
                              $result = $conn->query($sql);
            
                              if ($result === false) {
                                 die("Error in SQL query: " . $conn->error);
                              }
                              $row = $result->fetch_assoc();
                              $userCount = $row['user_count'];

                              echo $userCount;
                           ?> 
                        </h6>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>


      <div class="card-body mt-5 shadow rounded" style="background-color:#fff">
         <h5 class="card-title">Tableau des utilisateurs<span></span></h5>

         <div class="dataTable-search " style="display:flex;justify-content:space-between">
            <div>
               <form id="role-form" method="post">
                  <select name="role" id="role-select" class="form-select">
                     <option value="all">All</option>
                     <option value="passenger">Clients</option>
                     <option value="driver">Drivers</option>
                  </select>
               </form>     
            </div>
            <div style="display:flex">
               <div class="dataTable-search" style="display: flex;">
                  <form>
                     <select name="search_option" id="search-select" class="form-select">
                        <option value="name">Name</option>
                        <option value="id">ID</option>
                     </select>
                  </form>
               </div>
               <div id="search-input-container">
                  <label class="form-label" style="display:none">Search:</label>
                  <input name="name" id="name_input" class="form-control" placeholder="Search..." type="text">

               </div>
            </div>
         </div>
         <div class="contaainer px-5" id="itemList">
            <table id="announceTable" class="table ">
               <thead style="border-bottom: 1px solid #cdbff1">
                  <tr>
                     <th>ID</th>
                     <th>Full Name</th>
                     <th>Email</th>
                     <th>Role</th>
                     <th class="text-center align-middle">Delete</th>
                  </tr>
               </thead>
               <tbody id="showdata">
                  <?php
                     require 'change_query.php';
                  ?>
               </tbody>
            </table>
         </div>
      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/js/bootstrap.min.js"></script>

      </div>
   
   </section>
   <!--FOOTER-->
   <footer id="contact" class="border-top" style="margin-top: 96px;" >
    <div class="container ">
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


   <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
   <script src="../assets/js/apexcharts.min.js"></script>
   <script src="../assets/js/bootstrap.bundle.min.js"></script>
   <script src="../assets/js/chart.min.js"></script>
   <script src="../assets/js/echarts.min.js"></script>
   <script src="../assets/js/quill.min.js"></script>
   <script src="../assets/js/simple-datatables.js"></script>
   <script src="../assets/js/tinymce.min.js"></script>
   <script src="../assets/js/validate.js"></script>
   <script src="../assets/js/main.js"></script>
   
</body>
</html>