<?php
// var_dump($appointmentInfo) 
?>

<div class="appointment-info">
    <p>
        <strong>
            Customer Name:
        </strong>
        <span>
            <?php echo ($appointmentInfo[0]['Customer Name']) ?>
        </span>
    </p>

    <p>
        <strong>
            Vehicle Reg No.:
        </strong>
        <span>
            <?php echo ($appointmentInfo[0]['vehicle_reg_no']) ?>
        </span>
    </p>
</div>

<div class="office-staff-dashboard-create-jobCard-other-info">
    <form action="office-staff-dashboard/create-jobCard" method="post" class="office-staff-dashboard/create-jobCard-form" enctype="multipart/form-data">
        <div class="assign-a-foreman">
            <p>Customer Observation:</p>
            <textarea name="" id="" cols="90" rows="3"></textarea>

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