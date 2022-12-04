<?php

/**
 * @var array $errors
 */
$has_errors = isset($errors);
$has_email_errors = $has_errors && isset($errors["email"]);
$has_password_errors = $has_errors && isset($errors["password"]);

?>

<div class="office-staff-login">
    <form class="office-staff-login-form" action="/office-staff-login" method="post">

        <h2 class="office-staff-login-heading">Login to your account</h2>

        <lable class="form-lable">Email</lable>
        <input class="office-staff-login-input" type="text" name="email" required="" autofocus="" />
        <?php if ($has_email_errors) {
            echo "<p>" . $errors['email'] . "</p>";
        } ?>
        
        <lable class="form-lable">Password</lable>
        <input class="office-staff-login-input" type="password" name="password" required="" />
        <?php if ($has_password_errors) {
            echo "<p>" . $errors['password'] . "</p>";
        } ?>

        <button class="office-staff-login-btn" type="submit">LOGIN</button>

    </form>
</div>
