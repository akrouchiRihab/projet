<?php

function get_ride(object $pdo, string $depart, string $destination, string $departure_time)
{
    echo "Calling get_ride function in search_model.inc.php";

    $formattedDepartureTime = new DateTime($departure_time);
    $formattedDepartureTime = $formattedDepartureTime->format('Y-m-d H:i:00');;

    $query = "SELECT *FROM rides WHERE DepartureLocation= :DepartureLocation and Destination = :Destination and DepartureTime =:DepartureTime;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":DepartureLocation", $depart);
    $stmt->bindParam(":Destination", $destination);
    $stmt->bindParam(":DepartureTime",  $formattedDepartureTime);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($result);

    return $result;
}
