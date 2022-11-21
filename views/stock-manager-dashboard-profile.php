<?php
/**
 * @var object $customer
 */

?>

<div class="customer-profile">
    <img src="<?php echo $customer->image ?>" alt="<?php echo $customer->f_name . ' ' . $customer->l_name . '\'s'; ?>">
    <div class="customer-profile__info">
        <p>
            <strong>
                First name
            </strong>
            <span>
                <?php echo $customer->f_name ?>
            </span>
        </p>
        <p>
            <strong>
                Last name
            </strong>
            <span>
                <?php echo $customer->l_name ?>
            </span>
        </p>
        <p>
            <strong>
                Email
            </strong>
            <span>
                <?php echo $customer->email ?>
            </span>

        </p>
        <p>
            <strong>
                Phone
            </strong>
            <span>
                <?php echo $customer->contact_no ?>
            </span>

        </p>
        <p>
            <strong>
                Address
            </strong>
            <span>
                <?php echo $customer->address ?>
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