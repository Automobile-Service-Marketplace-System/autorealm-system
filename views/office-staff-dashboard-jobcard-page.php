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
            <?php
            foreach ($foremanAvailability as $foremans) {
                echo "<div class='foreman-card'>
                        $foremans[Name]
                        Availability = ($foremans[Availability])
                        <img src='$foremans[Image]' alt='$foremans[Name]' width='100' height='100'
                    </div>";
            }
            ?>
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