<?php
// var_dump($appointmentInfo) ?>

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

<div class="additional-info">
    <form action="office-staff-dashboard/create-jobCard" method="post" class="office-staff-dashboard/create-jobCard-form" enctype="multipart/form-data">

        <p>Customer Observation:</p>
        <textarea name="" id="" cols="90" rows="5"></textarea>

        <p>Assign a Foreman</p>

        <div class="office-staff-btn">
            <button class="btn btn--danger btn--block">
                Reset
            </button>

            <button class="btn btn--blue btn--block">
                Create an account
            </button>
        </div>

    </form>

</div>