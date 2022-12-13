<?php
/**
 * @var object $admin
 */

?>
    
<div class="customer-profile">
    <img src="<?php echo $admin->image ?>" alt="<?php echo $admin->f_name . ' ' . $admin->l_name . '\'s'; ?>">
    <div class="customer-profile__info">
        <p>
            <strong>
                First name
            </strong>
            <span>
                <?php echo $admin->f_name ?>
            </span>
        </p>
        <p>
            <strong>
                Last name
            </strong>
            <span>
                <?php echo $admin->l_name ?>
            </span>
        </p>
        <p>
            <strong>
                Email
            </strong>
            <span>
                <?php echo $admin->email ?>
            </span>

        </p>
        <p>
            <strong>
                Phone
            </strong>
            <span>
                <?php echo $admin->contact_no ?>
            </span>

        </p>
        <p>
            <strong>
                Address
            </strong>
            <span>
                <?php echo $admin->address ?>
            </span>

        </p>
    </div>
    <div class="admin-profile__actions">
        <button class="btn btn--danger" id="edit-admin-password">
            <i class="fa-solid fa-lock"></i>
            Edit password</button>
        <button class="btn btn--warning" id="edit-admin-profile">
            <i class="fa-solid fa-pencil"></i>

            Edit profile</button>
    </div>
</div>