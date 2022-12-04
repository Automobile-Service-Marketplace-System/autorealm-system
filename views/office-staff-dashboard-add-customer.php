<!-- <div class="container">
    <div class="item">
        <label for="">First Name</label>
        <input type="text">
    </div>

    <div class="item">
        <label for="">Last Name</label>
        <input type="text">
    </div>

    <div class="item">
        <label for="">Contact No</label>
        <input type="text">
    </div>

    <div class="item">
        <label for="">Address</label>
        <input type="text">
    </div>

    <div class="item">
        <label for="">Email</label>
        <input type="text">
    </div>

    <div class="item">
        <label for="">NIC</label>
        <input type="text">
    </div>
    <div class="item">
        <label for="">Password</label>
        <input type="text">
    </div>
    <div class="item">
        <label for="">Confirm Passsword</label>
        <input type="text">
    </div>
</div> -->

<?php
/**
 * @var array $errors
 * @var array $body
 */

use app\components\FormItem;

$hasErrors = isset($errors) && !empty($errors);
$hasEmailError = $hasErrors && isset($errors['email']);
$hasFNameError = $hasErrors && isset($errors['f_name']);
$hasLNameError = $hasErrors && isset($errors['l_name']);
$hasImageError = $hasErrors && isset($errors['image']);
$hasContactNoError = $hasErrors && isset($errors['contact_no']);
$hasAddressError = $hasErrors && isset($errors['address']);
$hasPasswordError = $hasErrors && isset($errors['password']);


?>


<div class="office-staff-add-customer">
    <form action="/office-staff-dashboard/customers/add" method="post" class="office-staff-add-customer-form" enctype="multipart/form-data">
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
            name: "image",
            type: "file",
            hasError: $hasImageError,
            error: $hasImageError ? $errors['image'] : "",
            additionalAttributes: "accept='image/*'"

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

        <button class="btn btn--danger btn--block">
            Create an account
        </button>

    </form>
</div>
