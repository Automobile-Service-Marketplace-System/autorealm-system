<?php
/**
 * @var array $errors
 * @var array $body
 * @var string $redirect_url
 */

use app\components\FormItem;

$hasErrors = isset($errors) && !empty($errors);
$hasEmailError = $hasErrors && isset($errors['email']);
$hasPasswordError = $hasErrors && isset($errors['password']);

?>

<div class="customer-auth">
    <form action="/login?redirect_url=<?php echo $redirect_url ?>" method="post" class="customer-auth-form">
        <h1>Welcome back !</h1>
        <?php
        FormItem::render(
            id: "email",
            label: "Email",
            name: "email",
            type: "email",
            hasError: $hasEmailError,
            error: $hasEmailError ? $errors['email'] : "",
            value: $body['email'] ?? null
        );
        FormItem::render(
            id: "password",
            label: "Password",
            name: "password",
            type: "password",
            hasError: $hasPasswordError,
            error: $hasPasswordError ? $errors['password'] : "",
            value: $body['password'] ?? null,
            additionalAttributes: "minlength='6' pattern='.{6,}'"
        ); ?>
        <div class="form-item form-item--checkbox">
            <input type="checkbox" name="remember" id="remember" value="1">
            <label for="remember">Remember me</label>
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

