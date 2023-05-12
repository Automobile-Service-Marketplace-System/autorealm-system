<?php
/**
 * @var array $errors
 * @var array $body
 * @var array $models
 * @var array $brands
 */

use app\components\FormItem;
use app\components\FormSelectItem;

$hasErrors = isset($errors) && !empty($errors);
$hasEmailError = $hasErrors && isset($errors['email']);
$hasFNameError = $hasErrors && isset($errors['f_name']);
$hasLNameError = $hasErrors && isset($errors['l_name']);
$hasImageError = $hasErrors && isset($errors['image']);
$hasContactNoError = $hasErrors && isset($errors['contact_no']);
$hasAddressError = $hasErrors && isset($errors['address']);
$hasPasswordError = $hasErrors && isset($errors['password']);

//for vehicle
$hasVINError = $hasErrors && isset($errors['vin']);
$hasRegNoError = $hasErrors && isset($errors['reg_no']);
$hasEngineNoError = $hasErrors && isset($errors['engine_no']);

$years = [];
for ($i=date('Y'); $i >= 1900 ; $i--) { 
    $years[] = $i;
};

?>


<div class="office-staff-add-customer">
    <form action="/customers/add" method="post" class="office-staff-add-customer-form"
          enctype="multipart/form-data">
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
                additionalAttributes: "accept='image/*'",

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
        <h3 class="office-staff-header">Also add a vehicle for this customer</h3>

        <div class="office-staff-add-customer-form__vehicle">

            <?php
            FormItem::render(
                id: "vin",
                label: "VIN",
                name: "vin",
                hasError: $hasVINError,
                error: $hasVINError ? $errors['vin'] : "",
                value: $body['vin'] ?? null,
                // additionalAttributes: "pattern='^[\p{L} ]+$'"
            );

            FormItem::render(
                id: "engine_no",
                label: "Engine No",
                name: "engine_no",
                hasError: $hasEngineNoError,
                error: $hasEngineNoError ? $errors['engine_no'] : "",
                value: $body['engine_no'] ?? null,
                // additionalAttributes: "pattern='^[\p{L} ]+$'"
            );

            FormItem::render(
                id: "reg_no",
                label: "Registration No",
                name: "reg_no",
                hasError: $hasRegNoError,
                error: $hasRegNoError ? $errors['reg_no'] : "",
                value: $body['reg_no'] ?? null,
                // additionalAttributes: "pattern='^[\p{L} ]+$'"
            );

            // FormItem::render(
            //     id: "manufactured_year",
            //     label: "Manufactured Year",
            //     name: "manufactured_year",
            //     type: "date",
            //     // hasError: $hasFNameError,
            //     // error: $hasFNameError ? $errors['manufactured_year'] : "",
            //     value: $body['manufactured_year'] ?? null,
            //     // additionalAttributes: "pattern='^[\p{L} ]+$'"
            // );

            FormSelectItem::render(
                id: "manufactured_year",
                label: "Manufactured Year",
                name: "manufactured_year",
                // hasError: $hasFNameError,
                // error: $hasFNameError ? $errors['brand'] : "",
                value: "1",
                options: $years
            );

            FormSelectItem::render(
                id: "brand",
                label: "Brand",
                name: "brand",
                // hasError: $hasFNameError,
                // error: $hasFNameError ? $errors['brand'] : "",
                value: "1",
                options: $brands
            );


            FormSelectItem::render(
                id: "vehicle_type",
                label: "Vehicle Type",
                name: "vehicle_type",
                // hasError: $hasFNameError,
                // error: $hasFNameError ? $errors['vehicle_type'] : "",
                value: "1",
                options: [
                    "1" => "Bike",
                    "2" => "Car",
                    "3" => "Jeep",
                    "4" => "Van",
                    "5" => "Lorry",
                    "6" => "Bus",
                    "7" => "Other"
                ]
            );

            FormItem::render(
                id: "engine_capacity",
                label: "Engine Capacity",
                name: "engine_capacity",
                // hasError: $hasFNameError,
                // error: $hasFNameError ? $errors['engine_capacity'] : "",
                value: $body['engine_capacity'] ?? null,
                // additionalAttributes: "pattern='^[\p{L} ]+$'"
            );
//
            FormSelectItem::render(
                id: "model",
                label: "Model",
                name: "model",
                // hasError: $hasFNameError,
                // error: $hasFNameError ? $errors['model'] : "",
                value: "1",
                options: $models
            );

            FormSelectItem::render(
                id: "transmission_type",
                label: "Transmission Type",
                name: "transmission_type",
                // hasError: $hasFNameError,
                // error: $hasFNameError ? $errors['transmission_type'] : "",
                value: "1",
                options: [
                    "1" => "Manual",
                    "2" => "Automatic",
                    "3" => "Triptonic",
                    "4" => "CVT"
                ]
            );

            FormSelectItem::render(
                id: "fuel_type",
                label: "Fuel Type",
                name: "fuel_type",
                // hasError: $hasFNameError,
                // error: $hasFNameError ? $errors['fuel_type'] : "",
                value: "1",
                options: [
                    "1" => "Petrol",
                    "2" => "Diesel",
                    "3" => "Hybrid",
                    "4" => "Electric",
                ]
            );

            ?>
        </div>

        <div class="office-staff-btn">
            <button class="btn btn--danger">
                Reset
            </button>

            <button class="btn btn--blue">
                Add New Customer
            </button>
        </div>
    </form>
</div>
