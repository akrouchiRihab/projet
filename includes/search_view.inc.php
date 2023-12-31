<?php



    
function output_ride(bool|array $result)
{
     if(isset($result)){
     ?>
        <li>
            Departure: <?php echo isset ($result['DepartureLocation']); ?><br>
            Destination: <?php echo isset($result['Destination']) ; ?><br>
            Departure Time: <?php echo isset($result['DepartureTime']) ; ?><br>
            Available Seats: <?php echo isset($result['AvailableSeats']) ; ?><br>
        </li>
    <?php
            } 
        }
        
    ?>
