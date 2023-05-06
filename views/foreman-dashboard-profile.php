<?php
/**
 * @var object $foreman
 */

?>

<div class="employee-profile">
    <img src="<?php echo $foreman->image ?>" alt="<?php echo $foreman->f_name . ' ' . $foreman->l_name . '\'s'; ?>">
    <div class="employee-profile__info">
        <p>
            <strong>
                First name
            </strong>
            <span>
                <?php echo $foreman->f_name ?>
            </span>
        </p>
        <p>
            <strong>
                Last name
            </strong>
            <span>
                <?php echo $foreman->l_name ?>
            </span>
        </p>
        <p>
            <strong>
                Email
            </strong>
            <span>
                <?php echo $foreman->email ?>
            </span>

        </p>
        <p>
            <strong>
                Phone
            </strong>
            <span>
                <?php echo $foreman->contact_no ?>
            </span>

        </p>
        <p>
            <strong>
                Address
            </strong>
            <span>
                <?php echo $foreman->address ?>
            </span>

        </p>
    </div>
    <div class="employee-profile__actions">
        <button class="btn btn--danger" id="edit-customer-password">
            <i class="fa-solid fa-lock"></i>
            Edit password</button>
        <button class="btn btn--warning" id="edit-customer-profile">
            <i class="fa-solid fa-pencil"></i>

            Edit profile</button>
    </div>
</div>
