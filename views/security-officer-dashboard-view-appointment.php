<?php

/**
 * @var array $appointments
 */

    foreach($appointments as $appointment){ ?>
        <div class="appointment">
            <p><b>Name: </b><?php echo $appointment["Name"] ?>
            <br><b>Registrain Number: </b><?php echo $appointment["RegNo"]?>
            <br><b>Time Slot: </b><?php echo $appointment['FromTime']?> - <?php echo $appointment['ToTime']?> 
            <br><b>Date: </b><?php echo $appointment["Date"]?>
        </div>
    <?php    
    }
    ?>
</div>
