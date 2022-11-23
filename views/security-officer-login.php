<?php
/**
 * @var array $errors;
 */
    $has_errors=isset($errors);
    $has_email_errors=$has_errors && isset($errors["email"]);
    $has_password_errors=$has_errors && isset($errors['password']);

?>

<style>
    .label{
        display: flex;
        flex-direction: column;
        padding-bottom: .75cm;
    }

    .form-container{
        display: flex; 
        align-items: center;  
        justify-content: center;
        /* min-height: 100vh; */
        margin: 4cm;
    }

    .label > input{
        padding-inline: 0.5rem;
        border-radius: 0.5rem;
        height: 2rem;
        border:1px solid  black;
    }

    .security-officer-login{
        width: 30%;
        border: 2px solid;
        box-shadow: 0 0.2rem 1.5rem rgba(var(--black), 0.1);
        border-radius: 1rem;  
        gap: 1rem;
        padding: 1rem;
    }

    .btn{
            background-color:rgb(229 48 48);
            color: white;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            height: 2.5rem;
            border: none;
            cursor: pointer;   
    }
</style>

<!-- <head>
    <link rel="stylesheet" href="\assets\css\views\admin-login.css">
</head> -->

<div class="form-container">
    <form class="security-officer-login" action="/security-officer-login" method="post">
        <h1 style="text-align:center"><b>Security Login</b></h1>
        <div class="label">
            <label for="email">Email<sup>*</sup></label>
            <input type="email", id="email" name="email">           
	        <?php 
                if($has_errors && $has_email_errors){
                    echo "<span style='color: red'>"."*".$errors["email"]."</span>";
                }
	        ?>            
        </div>
        <div class="label">
            <label for="password">Password<sup>*</sup></label>
            <input type="password", id="password" name="password">
            <?php 
                if($has_errors && $has_password_errors){
                    echo "<span style='color: red'>"."*".$errors["password"]."</span>";
                }
            ?>                  
        </div> 
        <div class="label">
            <button type="submit" class="btn">Login</button>       
        </div>   
    </form>
</div>

