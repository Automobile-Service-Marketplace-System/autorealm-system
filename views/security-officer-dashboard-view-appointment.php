<?php
/**
 * @var array $appointments
 */
?>

<div class="appointment">
    <?php 
        foreach($appointments as $appointment){            
            echo " <div class='appointment-card-wrapper '>
                <p class='appointment-card__name'><b>Name: </b>{$appointment['Name']}</p>
                <p class='appointment-card__regno'><b>Registration Number: </b>{$appointment['RegNo']}</p>
                <p class='appointment-card__from_time'><b>From Time: </b>{$appointment['FromTime']}</p>
                <p class='appointment-card__to_time'><b>To Time: </b>{$appointment['ToTime']}</p>
                <p class='appointment-card__date'><b>Date: </b>{$appointment['Date']}</p>
                <a class='btn' style='width: 10rem; align:center; margin: 0 auto' href='/security-officer-dashboard/check-appointment'>Scan QR code</a>
            </div>";
        }
    ?>
</div>