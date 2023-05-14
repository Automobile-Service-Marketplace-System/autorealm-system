<?php
/**
 * @var object $securityOfficer
 */

?>

<div class="employee-profile">
    <img src="<?php echo $securityOfficer->image ?>" alt="<?php echo $securityOfficer->f_name . ' ' . $securityOfficer->l_name . '\'s'; ?>">
    <div class="employee-profile__info">
        <p>
            <strong>
                First name
            </strong>
            <span>
                <?php echo $securityOfficer->f_name ?>
            </span>
        </p>
        <p>
            <strong>
                Last name
            </strong>
            <span>
                <?php echo $securityOfficer->l_name ?>
            </span>
        </p>
        <p>
            <strong>
                Email
            </strong>
            <span>
                <?php echo $securityOfficer->email ?>
            </span>

        </p>
        <p>
            <strong>
                Phone
            </strong>
            <span>
                <?php echo $securityOfficer->contact_no ?>
            </span>

        </p>
        <p>
            <strong>
                Address
            </strong>
            <span>
                <?php echo $securityOfficer->address ?>
            </span>

        </p>
    </div>
</div>