<?php
/**
 * @var array $errors
 */

$hasErrors = isset($errors) && !empty($errors);
$isEmailError = $hasErrors && isset($errors['email']);
$isPasswordError = $hasErrors && isset($errors['password']);



?>

<div class="customer-auth">
    <form action="/login" method="post" class="customer-auth-form">
        <h1>Welcome back !</h1>
        <div class="form-item">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div class="form-item">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <a href="/forgot-password" class="link">Forgot password?</a>
        <button class="btn btn--danger btn--block">
            Sign In
        </button>
        <p class="text-center">
            Haven't got an account? <a href="/register" class="link">Sign up</a>
        </p>
    </form>
</div>

