<style>
    .appointment{
        background-color: var(--color-white);
        box-shadow: 1px 2px 5px rgba(0, 0, 0, 0.2);
        padding: 1rem;
        border-radius: 0.5rem;
        width: 100%;
        max-width: 400px;
        margin: 1cm auto;
        align-items: center;
    }
</style>

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
