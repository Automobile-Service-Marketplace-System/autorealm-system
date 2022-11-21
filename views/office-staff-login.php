<?php
/**
 * @var array $errors
 */
    $has_errors = isset($errors);
    $has_email_errors = $has_errors && isset($errors["email"]);
    $has_password_errors = $has_errors && isset($errors["password"]);

?>

<style>
    body{
        background-color: lightgray;
    }

    .container{

    }

    .form-signin-heading{
        font-weight: bold;
        font-size: 62px;
        margin-bottom: 10px;
    }

    .form-input{
        background-color: white;
        display: block;
        width: 300px;
    }

    .form-lable{
        text-align: left;
        margin-top: 20px;
    }

    .btn{
        background-color: red;
        position: center;
        display: block;
        width: 300px;
        margin-top: 20px;
    }

</style>


<div>
    <div class="container">
        <form class="form-signin" action="/office-staff-login" method="post">
            <h2 class="form-signin-heading">Login to your account</h2>

            <lable class="form-lable">Email</lable>
<!--            <br>-->
            <input class="form-input" type="text" name="email" required="" autofocus="" />
            <?php if($has_email_errors) {
                echo "<p>" . $errors['email'] . "</p>"; } ?>
<!--            <br>-->
            <lable class="form-lable">Password</lable>
<!--            <br>-->
            <input class="form-input" type="password" name="password" required="" />
            <?php if($has_password_errors) {
                echo "<p>" . $errors['password'] . "</p>"; } ?>
<!--            <br>-->
            <button class="btn" type="submit">Sign in</button>

        </form>
    </div>


</div>

