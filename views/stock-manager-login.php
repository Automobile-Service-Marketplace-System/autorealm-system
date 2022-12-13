<?php

/**
 * @var array $errors
 */
	$has_errors=isset($errors);
	$has_email_errors=$has_errors && isset($errors["email"]);
	$has_password_errors=$has_errors && isset($errors["password"])
?>

<style>

    .form-container{
        /*margin: 0 auto;*/
        /*display: flex;*/
        /*flex-direction: column;*/
        /*!* background-color: red; *!*/
        /*vertical-align: middle;*/
        /*align-items: center;*/
        /*justify-content: center;*/
        /*min-height: 100vh;*/
        display: flex;
        align-items: center;
    justify-content: center;
        width: 100vw;
        height: 100vh;
       // background-color: red;
    }

    .stockmanager-login{
        /* background-color:turquoise; */
        border: 1px solid;
        width: 30%;
        padding: 2rem;
        box-shadow: 0 0.2rem 1.5rem rgba(var(--black), 0.1);
        gap: 1rem;
        padding: 1rem;
        border-radius: 1rem;
    }

    .input-container{
        display: flex;
        flex-direction: column;
        /* background-color: tan; */

    }

    .input-container > input{
        padding-inline: 1rem;
        height: 2.5rem;
        border-radius: 0.5rem;
        border: 1px solid rgba(0, 0, 0, 0.339);
    }

    .btn-login{
        background-color:rgb(229 48 48);
        color: white;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        height: 2.5rem;
        border: none;
        cursor: pointer;
    }

</style>


<div class="form-container" >
    <form class="stockmanager-login" action="/stock-manager-login" method="post">
        <h1>Signup</h1>
        <div class="input-container">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address">
	        <?php if($has_errors && $has_email_errors){
				echo "<span style='color: red'>"."*".$errors["email"]."</span>";
	        }
	        ?>
			<br>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password">
            <?php if($has_errors && $has_password_errors){
                echo "<span style='color: red'>"."*".$errors["password"]."</span>";
            }
            ?>
	        <br>

            <button type="submit" class="btn-login">Login</button>
        </div>



    </form>
</div>
