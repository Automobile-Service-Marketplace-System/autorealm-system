<?php
/**
 * @var array $errors
 * @var array $body
 */

$hasErrors = isset($errors) && !empty($errors);
$hasEmailError = $hasErrors && isset($errors["email"]);
$hasPasswordError = $hasErrors && isset($errors["password"]);

use app\components\FormItem;

?>

<form action="/employee-login" method="post" class="employee-login__form">
   <h1>Welcome back !</h1>
    <?php
    FormItem::render(
        id: "foreman-email",
        label: "Email",
        name: "email",
        type: "email",
        hasError: $hasEmailError,
        error: $hasEmailError ? $errors['email'] : "",
        value: $body['email'] ?? null
    );

    FormItem::render(
        id: "foreman-password",
        label: "Password",
        name: "password",
        type: "password",
        hasError: $hasPasswordError,
        error: $hasPasswordError ? $errors['password'] : "",
        value: $body['password'] ?? null,
        additionalAttributes: "minlength='6' pattern='.{6,}'"
    );
    ?>

    <a href="tel:+94703614315" class="link">Forgot password? contact admin to reset</a>
    <button class="btn btn--danger btn--block">
        Sign In
    </button>
</form>