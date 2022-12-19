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
$hasVINError = $hasErrors && isset($errors['vin']);
$hasRegNoError = $hasErrors && isset($errors['reg_no']);
$hasEngineNoError = $hasErrors && isset($errors['engine_no']);

?>

<strong class='customer-title'>
        Customer Name: 
</strong>
<span class='customer-title'>
        { <?php $vehicle['full_name'] ?>}
</span>

<div class="office-staff-add-customer">
    <form action="/office-staff-dashboard/customers/add" method="post" class="office-staff-add-customer-form"
        enctype="multipart/form-data">

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

            FormItem::render(
                id: "manufactured_year",
                label: "Manufactured Year",
                name: "manufactured_year",
                type: "date",
                // hasError: $hasFNameError,
                // error: $hasFNameError ? $errors['manufactured_year'] : "",
                value: $body['manufactured_year'] ?? null,
                // additionalAttributes: "pattern='^[\p{L} ]+$'"
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

            FormItem::render(
                id: "model_year",
                label: "Model Year",
                name: "model_year",
                type: "date",
                // hasError: $hasFNameError,
                // error: $hasFNameError ? $errors['model_year'] : "",
                value: $body['model_year'] ?? null,
                // additionalAttributes: "pattern='^[\p{L} ]+$'"
            );


            FormSelectItem::render(
                id: "vehicle_type",
                label: "Vehicle Type",
                name: "vehicle_type",
                // hasError: $hasFNameError,
                // error: $hasFNameError ? $errors['vehicle_type'] : "",
                value: "1",
                options: [
                    "1" => "Motorcycle",
                    "2" => "Motor Tricycle",
                    "3" => "Motor Vehicle",
                    "4" => "Motor Lorry",
                    "5" => "Motor Coach",
                    "6" => "Special Purpose Vehicle"
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
            <button class="btn btn--danger btn--block">
                Reset
            </button>

            <button class="btn btn--blue btn--block">
                Create an account
            </button>
        </div>
    </form>
</div>
