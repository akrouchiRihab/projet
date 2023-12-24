<?php


if($_SERVER["REQUEST_METHOD"]==="POST"){
    $depart = $_POST["depart"];
    $destination = $_POST["destination"];
    $departure_time = $_POST["departure_time"];
    
    echo "Reached the beginning of search.inc.php";
    echo "Form data received:";
    var_dump($_POST);
    try{
         require_once 'dbh.inc.php';
         
         require_once 'search_model.inc.php';
        
         
         
        
        $result=get_ride( $pdo, $depart, $destination,  $_POST["departure_time"]);
         
       


        
            include 'search_view.inc.php';
        
         
    }catch(PDOException $e){
        die("Query failed: " .$e->getMessage());
     }
}
