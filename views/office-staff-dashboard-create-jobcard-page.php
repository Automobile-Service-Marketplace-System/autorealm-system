<?php
/**
 * @var array $appointmentInfo
 * @var array $foremanAvailability
 */

$start_date_time = date('Y-m-d H:i:s');
?>

<form action="/create-job-card" method="post" class="office-staff-create-jobCard" enctype="multipart/form-data">
    <div class="appointment-info">
        <p>
            <strong>
                Customer Name:
            </strong>
            <span>
                <?php echo($appointmentInfo[0]['Customer Name']) ?>
            </span>
        </p>

        <p>
            <strong>
                Vehicle Reg No.:
            </strong>
            <span>
                <?php echo($appointmentInfo[0]['vehicle_reg_no']) ?>
            </span>
        </p>
    </div>

    <div class="office-staff-dashboard-create-jobCard-other-info">
        <form action="office-staff-dashboard/create-job-card" method="post"
            class="office-staff-dashboard-create-job-card-form" enctype="multipart/form-data">
            <div class="assign-a-foreman">
                <p>Assign a Foreman</p>
                <div class="select-foreman-cards">
                    <?php
                    foreach ($foremanAvailability as $foreman) {
                        $availabilityClass = $foreman['Availability'] === 1 ? "indicator indicator--success" : "indicator";
                        $availabilityPhrase = $foreman['Availability'] === 1 ? "Available" : "Busy";
                        echo "<div class='foreman-card foreman-card--active'>
                        <div class='foreman-card__header'>
                        <p>
                        $availabilityPhrase
                        </p>
                        <div class='$availabilityClass'></div>
                        </div>
                            <img class ='foreman-card-img' src='{$foreman['Image']}' alt='{$foreman['Name']}' width='100' height='100'>
                            <p>{$foreman['Name']}</p>
                        </div>";
                    }
                    ?>
                </div>
            </div>
                
            <input style="display: none" name='start_date_time' id='start_date_time' value='<?php echo $start_date_time ?>'>
            <input style="display: none" name='mileage' id='mileage' value='<?php echo($appointmentInfo[0]['mileage']) ?>'>
            <input style="display: none" name='vin' id='vin' value='<?php echo($appointmentInfo[0]['vehicle_reg_no']) ?>'>
            <input style="display: none" name='customer_id' id='customer_id' value='<?php echo($appointmentInfo[0]['customer_id']) ?>'> 
            <input style="display: none" name='employee_id' id='employee_id'>
            
            <div class="office-staff-btn">
                <button class="btn btn--danger">
                    Reset
                </button>

                <button class="btn btn--blue">
                    Create a JobCard
                </button>
            </div>

        </form>

    </div>
</form>