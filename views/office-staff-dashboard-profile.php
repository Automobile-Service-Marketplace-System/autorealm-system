<?php
/**
 * @var object $officestaff
 */

?>

<div class="customer-profile">
    <img src="<?php echo $officestaff->image ?>" alt="<?php echo $officestaff->f_name . ' ' . $officestaff->l_name . '\'s'; ?>">
    <div class="officestaff-profile__info">
        <p>
            <strong>
                First name
            </strong>
            <span>
                <?php echo $officestaff->f_name ?>
            </span>
        </p>
        <p>
            <strong>
                Last name
            </strong>
            <span>
                <?php echo $officestaff->l_name ?>
            </span>
        </p>
        <p>
            <strong>
                Email
            </strong>
            <span>
                <?php echo $officestaff->email ?>
            </span>

        </p>
        <p>
            <strong>
                Phone
            </strong>
            <span>
                <?php echo $officestaff->contact_no ?>
            </span>

        </p>
        <p>
            <strong>
                NIC
            </strong>
            <span>
                <?php echo $officestaff->NIC ?>
            </span>

        </p>
        <p>
             <strong>
                  Birthday
             </strong>
             <span>
                <?php echo $officestaff->dob ?>
            </span>

        </p>
        <p>
            <strong>
                Date of appointed
            </strong>
            <span>
                <?php echo $officestaff->date_of_appointed ?>
            </span>

        </p>
        <p>
            <strong>
                Address
            </strong>
            <span>
                <?php echo $officestaff->address ?>
            </span>

        </p>
        <p>
             <strong>
                  Job role
             </strong>
             <span>
                <?php echo $officestaff->job_role ?>
            </span>

        </p>


    </div>
    <div class="customer-profile__actions">
        <button class="btn btn--danger" id="edit-customer-password">
            <i class="fa-solid fa-lock"></i>
            Edit password</button>
        <button class="btn btn--warning" id="edit-customer-profile">
            <i class="fa-solid fa-pencil"></i>

            Edit profile</button>
    </div>
</div>