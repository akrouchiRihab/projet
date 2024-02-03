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
</head>
<style>
   .canvas {
      max-width: 100%;
      height: 500px;
   }
</style>

<body style="background: #676B6E;">
   <section class="section dashboard container mt-5">
      <div class="row">
         <div class="col-xl-4 col-md-4">
            <div class="card info-card sales-card">
               <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
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
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
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
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
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


      <div class="card-body mt-5" style="background-color:#fff">
         <h5 class="card-title">Panneau des utilisateurs<span></span></h5>

         <div class="dataTable-search" style="display:flex;justify-content:space-between">
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
         <div class="container" id="itemList">
            <table id="announceTable" class="table table-striped">
               <thead>
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
   <div class="container-fluid mt-5">
      <div class="card mx-5" style="    background-color: #184530;">
         <div class="row mb-4 ">
            <div class=" col-12  col-md-4    col-sm-11 " style="display:flex;justify-content:center;align-items:end">
               <div class="footer-text pull-left">
                  <div class="d-flex">
                     <h1 class="font-weight-bold mr-2 px-3" style="color:#ffc107; background-color:#16a085ff"> D </h1>
                     <h1 style="color: #ffc107">CAR</h1>
                  </div>
                  <p class="card-text">is the best destination if u're looking for a car in a simple way </p>
               </div>
            </div>
            <div class="col-md-2 col-sm-1 col-xs-1 mb-2"></div>
            <div id="col-sm-4" class=" text-center col-md-6 col-sm-4 col-xs-4" style="margin-top:5%">
               <h5 class="heading" style="color:blanchedalmond">Services</h5>
               <ul style="display:flex; justify-content:center;align-items:end">
                  <li class="margin: 100px">
                     <a class="nav-link  " aria-current="page" href="#">Home</a>
                  </li>
                  <li>
                     <a class="nav-link " href="../announces/announces.html">Anounces</a>
                  </li>
                  <li>
                     <a class="nav-link " href="#">About Us</a>
                  </li>
                  <li>
                     <a class="nav-link " href="#">Contact Us</a>
                  </li>
               </ul>
               <div class="d-flex align-items-center icons" style="justify-content:center ;     margin-left: 12%;">
                  <a href="#" class="fs-5 d-flex align-items-center justify-content-center">
                     <span class="fab fa-facebook-f"></span>
                  </a>
                  <a href="#" class="fs-5 d-flex align-items-center justify-content-center">
                     <span class="fab fa-twitter"></span>
                  </a>
                  <a href="#" class="fs-5 d-flex align-items-center justify-content-center">
                     <span class="fab fa-instagram"></span>
                  </a>
                  <a href="#" class="fs-5 d-flex align-items-center justify-content-center">
                     <span class="fab fa-whatsapp"></span>
                  </a>
                  <a href="#" class="fs-5 d-flex align-items-center justify-content-center">
                     <span class="fab fa-telegram-plane"></span>
                  </a>
               </div>
            </div>
         </div>
         <div class="divider mb-4"></div>
         <div class="row" style="font-size:10px;">
            <div class="col-md-6 col-sm-6 col-xs-6">
               <div class="pull-left">
                  <p style="    color: #e5dec3;"><i class="fa fa-copyright"></i> 2022-2023 Dream-car</p>
               </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
               <div class="pull-right mr-4 d-flex policy" style="color: #e5dec3;">
                  <div>Terms of Use</div>
                  <div>Privacy Policy</div>
                  <div>Cookie Policy</div>
               </div>
            </div>
         </div>
      </div>
   </div>

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