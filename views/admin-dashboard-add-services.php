<?php

use app\components\FormItem;
use app\components\FormTextareaItem;

/**
 * @var array $errors
 * @var array $body
 */

$hasErrors = isset($errors) && !empty($errors);
$hasServiceNameError = $hasErrors && isset($errors['service_name']);
$hasPriceError = $hasErrors && isset($errors['price']);
$hasDescriptionError = $hasErrors && isset($errors['description']);


?>

<div class="admin-add-service-form">
    <form action="/admin-dashboard/services/add-services" method="post" class="admin-add-services-form"
          enctype="multipart/form-data">
        <h2 class="service-form-subheading">Service Details</h2>
        <div class="admin-add-services-form__service">
            <?php
            FormItem::render(
                id: "name", 
                label: "Service Name",
                name: "service_name",
                hasError: $hasServiceNameError,
                error: $hasServiceNameError ? $errors['service_name'] : "",

            );

            FormItem::render(
                id: "price",
                label: "Price",
                name: "price",
                hasError: $hasPriceError,
                error: $hasPriceError ? $errors['price'] : "",
                // options: [
                //     "spare part" => "Spare Part",
                //     "accessory" => "Accessory"
                // ]
            );

            ?>
            <div id="description-input">
                <?php
                FormTextareaItem::render(
                    id: "description",
                    label: "Description",
                    name: "description",
                    hasError: $hasDescriptionError,
                    error: $hasDescriptionError ? $errors['description'] : "",
                    rows: 4,
                );
                ?>
            </div>
        </div>

        <div class="admin-btn">
            <button class="btn btn--danger btn--block" type="reset">
                Reset
            </button>

            <button class="btn btn--block" type="submit" id="add-service-btn">
                Add Service
            </button>
        </div>

    </form>
</div>