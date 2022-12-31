<?php
/**
 * @var object $officeStaff
 */

?>

<div class="employee-profile">
    <img src="<?php echo $officeStaff->image; ?>" alt="<?php echo $officeStaff->f_name . ' ' . $officeStaff->l_name . '\'s'; ?>">
    <div class="employee-profile__info">
        <p>
            <strong>
                First name
            </strong>
            <span>
                <?php echo $officeStaff->f_name ?>
            </span>
        </p>
        <p>
            <strong>
                Last name
            </strong>
            <span>
                <?php echo $officeStaff->l_name ?>
            </span>
        </p>
        <p>
            <strong>
                Email
            </strong>
            <span>
                <?php echo $officeStaff->email ?>
            </span>

        </p>
        <p>
            <strong>
                Phone
            </strong>
            <span>
                <?php echo $officeStaff->contact_no ?>
            </span>

        </p>
        <p>
            <strong>
                NIC
            </strong>
            <span>
                <?php echo $officeStaff->NIC ?>
            </span>

        </p>
        <p>
             <strong>
                  Birthday
             </strong>
             <span>
                <?php echo $officeStaff->dob ?>
            </span>

        </p>
        <p>
            <strong>
                Date of appointed
            </strong>
            <span>
                <?php echo $officeStaff->date_of_appointed ?>
            </span>

        </p>
        <p>
            <strong>
                Address
            </strong>
            <span>
                <?php echo $officeStaff->address ?>
            </span>

        </p>
        <p>
             <strong>
                  Job role
             </strong>
             <span>
                <?php echo $officeStaff->job_role ?>
            </span>

        </p>


    </div>
</div>