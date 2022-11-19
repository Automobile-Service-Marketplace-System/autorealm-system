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

<form action="/foreman-login" method="post">
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

    <a href="/forgot-password" class="link">Forgot password?</a>
    <button class="btn btn--danger btn--block">
        Sign In
    </button>
</form>