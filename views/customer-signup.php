<?php
/**
 * @var array $errors
 * @var array $body
 */

use app\components\FormItem;

$hasErrors = isset($errors) && !empty($errors);
$hasEmailError = $hasErrors && isset($errors['email']);
$hasNICError = $hasErrors && isset($errors['NIC']);
$hasFNameError = $hasErrors && isset($errors['f_name']);
$hasLNameError = $hasErrors && isset($errors['l_name']);
$hasImageError = $hasErrors && isset($errors['image']);
$hasContactNoError = $hasErrors && isset($errors['contact_no']);
$hasAddressError = $hasErrors && isset($errors['address']);
$hasPasswordError = $hasErrors && isset($errors['password']);


?>

<div class="customer-auth">
    <form action="/register" method="post" class="customer-auth-form" enctype="multipart/form-data">
        <h1>Register with us</h1>
        <?php
        FormItem::render(
            id: "f_name",
            label: "First Name",
            name: "f_name",
            hasError: $hasFNameError,
            error: $hasFNameError ? $errors['f_name'] : "",
            value: $body['f_name'] ?? null,
            additionalAttributes: "pattern='^[\p{L} ]+$'"
        );
        FormItem::render(
            id: "l_name",
            label: "Last Name",
            name: "l_name",
            hasError: $hasLNameError,
            error: $hasLNameError ? $errors['l_name'] : "",
            value: $body['l_name'] ?? null,
            additionalAttributes: "pattern='^[\p{L} ]+$'"

        );
        FormItem::render(
            id: "image",
            label: "Profile photo",
            name: "image[]",
            type: "file",
            hasError: $hasImageError,
            error: $hasImageError ? $errors['image'] : "",
            additionalAttributes: "accept='image/*' multiple"

        );

        FormItem::render(
            id: "contact_no",
            label: "Contact No",
            name: "contact_no",
            type: "tel",
            placeholder: "Example: +94712345678",
            hasError: $hasContactNoError,
            error: $hasContactNoError ? $errors['contact_no'] : "",
            value: $body['contact_no'] ?? null,
            additionalAttributes: "pattern='^\+947\d{8}$'"
        );
        FormItem::render(
            id: "address",
            label: "Address",
            name: "address",
            hasError: $hasAddressError,
            error: $hasAddressError ? $errors['address'] : "",
            value: $body['address'] ?? null
        );
        FormItem::render(
            id: "nic",
            label: "NIC",
            name: "nic",
            placeholder: "Example: 123456789V or 200012345678",
            hasError: $hasNICError,
            error: $hasNICError ? $errors['NIC'] : "",
            value: $body['NIC'] ?? null,
            additionalAttributes: "pattern='^(?:19|20)?\d{2}[0-9]{10}|[0-9]{9}[vVxX]$'"
        );
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
            placeholder: "Password must be at least 6 characters",
            hasError: $hasPasswordError,
            error: $hasPasswordError ? $errors['password'] : "",
            value: $body['password'] ?? null,
            additionalAttributes: "minlength='6' pattern='.{6,}'"
        );
        FormItem::render(
            id: "confirm_password",
            label: "Confirm Password",
            name: "confirm_password",
            type: "password",
            placeholder: "Same as password",
            hasError: $hasPasswordError,
            error: $hasPasswordError ? $errors['password'] : "",
            value: $body['confirm_password'] ?? null,
            additionalAttributes: "minlength='6' pattern='.{6,}'"
        );
        ?>

        <div class="form-item form-item--checkbox">
            <input type="checkbox" name="tc" id="tc" required>
            <label for="tc">I've read the <a href="/terms-and-conditions" class="link" target="_blank">Terms &
                    Conditions</a> </label>
        </div>
        <div class="form-item form-item--checkbox">
            <input type="checkbox" name="pp" id="pp" required>
            <label for="pp">I agree to the <a href="/privacy-policy" class="link" target="_blank">Privacy Policy</a>
            </label>
        </div>
        <button class="btn btn--danger btn--block">
            Create an account
        </button>
        <p class="text-center">
            Already have an account? <a href="/login" class="link">Sign in</a>
        </p>
    </form>
</div>
