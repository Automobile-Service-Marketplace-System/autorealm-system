
<?php
/**
 * @var array $errors;
 */
    $has_errors=isset($errors);
    $has_email_errors=$has_errors && isset($errors["email"]);
    $has_password_errors=$has_errors && isset($errors['password']);

?>

<style>
    .btn{
        background-color: blue;
        color: white;
        width: auto;
        height: auto;
        border-radius: .2cm;
    }

    .start{
        margin-top: 2cm;
    }

    .fa {
        padding: 6px;
        background-color:blue;
        height: 15px;
        width: 15px;
        border-radius: 50%;
        text-decoration: none;
    }

    .fa-facebook{
        color: white;
    }

    .fa-twitter{
        color: white;
    }

    .fa-linkedin {
        color: white;
    }

    .aaa{
        width: 7cm;
        height: .5cm;
    }

    h5{
        display: flex;
        flex-direction: row;
        width: 7.3cm;
    }

    h5:before,
    h5:after {
        content: "";
        flex: 1 1;
        border-bottom: 1px solid #000;
        margin: auto;
    }
</style>

<h5 class="line">Or</h5>

<form action="/admin-login" method="post">
    <div>
        <input class="aaa" type="text" id="email" name="email" placeholder="Email address" width="7px">
        <?php
            if ($has_email_errors) {
                echo "<p>". $errors['email'] ."</p>";
            }
        ?>
        <br><br><input class="aaa" type="password" id="pw" name="password" placeholder="password" >
        <?php
            if($has_password_errors){
                echo "<p>". $errors['password']."</p>";
            }
        ?>
    </div>
    <div><br>
        <input type="checkbox" name="rm">Remember me.&nbsp;&nbsp;&nbsp;&nbsp;Forget password?</p>
    </div>
    <div><br>
        <input type="submit" id="btn" value="LOGIN" class="btn">
    </div>
</form>

<p>Don't have an account? <span style="color:red">Register</span></p>

