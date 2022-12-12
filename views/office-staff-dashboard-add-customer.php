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
        <div class="office-staff-add-customer-form__customer">
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
                label: "Profile Photo",
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
        </div>
        <h3>Also add a vehicle for this customer</h3>

        <div class="office-staff-add-customer-form__vehicle">

        <?php 
        FormItem::render(
            id: "engine_no",
            label: "Engine No",
            name: "engine_no",
            hasError: $hasFNameError,
            error: $hasFNameError ? $errors['engine_no'] : "",
            value: $body['engine_no'] ?? null,
            additionalAttributes: "pattern='^[\p{L} ]+$'"
        );

        FormItem::render(
            id: "registration_no",
            label: "Registration No",
            name: "registration_no",
            hasError: $hasFNameError,
            error: $hasFNameError ? $errors['registration_no'] : "",
            value: $body['registration_no'] ?? null,
            additionalAttributes: "pattern='^[\p{L} ]+$'"
        );

        FormItem::render(
            id: "model_name",
            label: "Model Name",
            name: "model_name",
            hasError: $hasFNameError,
            error: $hasFNameError ? $errors['model_name'] : "",
            value: $body['model_name'] ?? null,
            additionalAttributes: "pattern='^[\p{L} ]+$'"
        );

        FormItem::render(
            id: "manufactured_year",
            label: "Manufactured Year",
            name: "manufactured_year",
            hasError: $hasFNameError,
            error: $hasFNameError ? $errors['manufactured_year'] : "",
            value: $body['manufactured_year'] ?? null,
            additionalAttributes: "pattern='^[\p{L} ]+$'"
        );

        ?>
            
        <!-- <?php 
            //vehicle details
            FormItem::render(
                id: "engine_no",
                label: "Engine No",
                name: "engine_no",
                hasError: $hasFNameError,
                error: $hasFNameError ? $errors['engine_no'] : "",
                value: $body['engine_no'] ?? null,
                additionalAttributes: "pattern='^[\p{L} ]+$'"
            );

            FormItem::render(
                id: "registration_no",
                label: "Registration No",
                name: "registration_no",
                hasError: $hasFNameError,
                error: $hasFNameError ? $errors['registration_no'] : "",
                value: $body['registration_no'] ?? null,
                additionalAttributes: "pattern='^[\p{L} ]+$'"
            );

            FormItem::render(
                id: "model_name",
                label: "Model Name",
                name: "model_name",
                hasError: $hasFNameError,
                error: $hasFNameError ? $errors['model_name'] : "",
                value: $body['model_name'] ?? null,
                additionalAttributes: "pattern='^[\p{L} ]+$'"
            );

            FormItem::render(
                id: "manufactured_year",
                label: "Manufactured Year",
                name: "manufactured_year",
                hasError: $hasFNameError,
                error: $hasFNameError ? $errors['manufactured_year'] : "",
                value: $body['manufactured_year'] ?? null,
                additionalAttributes: "pattern='^[\p{L} ]+$'"
            );
            

            FormItem::render(
                id: "vehicle_type",
                label: "Vehicle Type",
                name: "vehicle_type",
                hasError: $hasFNameError,
                error: $hasFNameError ? $errors['vehicle_type'] : "",
                value: $body['vehicle_type'] ?? null,
                additionalAttributes: "pattern='^[\p{L} ]+$'"
            );

            FormItem::render(
                id: "model_year",
                label: "Model Year",
                name: "model_year",
                hasError: $hasFNameError,
                error: $hasFNameError ? $errors['model_year'] : "",
                value: $body['model_year'] ?? null,
                additionalAttributes: "pattern='^[\p{L} ]+$'"
            );

            FormItem::render(
                id: "engine_type",
                label: "Engine Type",
                name: "engine_type",
                hasError: $hasFNameError,
                error: $hasFNameError ? $errors['engine_type'] : "",
                value: $body['engine_type'] ?? null,
                additionalAttributes: "pattern='^[\p{L} ]+$'"
            );

            FormItem::render(
                id: "engine_capacity",
                label: "Engine Capacity",
                name: "engine_capacity",
                hasError: $hasFNameError,
                error: $hasFNameError ? $errors['engine_capacity'] : "",
                value: $body['engine_capacity'] ?? null,
                additionalAttributes: "pattern='^[\p{L} ]+$'"
            );

            FormItem::render(
                id: "brand_name",
                label: "Brand Name",
                name: "brand_name",
                hasError: $hasFNameError,
                error: $hasFNameError ? $errors['brand_name'] : "",
                value: $body['brand_name'] ?? null,
                additionalAttributes: "pattern='^[\p{L} ]+$'"
            );

            FormItem::render(
                id: "transmission_type",
                label: "Transmission Type",
                name: "transmission_type",
                hasError: $hasFNameError,
                error: $hasFNameError ? $errors['transmission_type'] : "",
                value: $body['transmission_type'] ?? null,
                additionalAttributes: "pattern='^[\p{L} ]+$'"
            );

            FormItem::render(
                id: "fuel_type",
                label: "Fuel Type",
                name: "fuel_type",
                hasError: $hasFNameError,
                error: $hasFNameError ? $errors['fuel_type'] : "",
                value: $body['fuel_type'] ?? null,
                additionalAttributes: "pattern='^[\p{L} ]+$'"
            );
            ?> -->
        </div>
        
        <div class="office-staff-btn">
            <button class="btn btn--danger btn--block">
                Reset
            </button>

            <button class="btn btn--success btn--block">
                Create an account
            </button>
        </div>
    </form>
</div>
