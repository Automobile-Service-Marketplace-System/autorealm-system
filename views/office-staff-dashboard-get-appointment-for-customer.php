<?php

// echo "<pre>";
// var_dump($appointment) ;
// echo "</pre>";

use app\components\FormItem;
use app\components\FormSelectItem;
use app\components\FormTextareaItem;

?>

<div class="office-staff-add-appointment">
    <div class="appoitment-owner-info">
        <div class="customer_info">
            <p>
                <strong>
                    Customer Name:
                </strong>
                    <?php echo $appointment[0]['full_name'] ?>
            </p>

            <p>
                <strong>
                    Contact No:
                </strong>
                    <?php echo $appointment[0]['contact_no'] ?>
            </p>

            <p>
                <strong>
                    Email:
                </strong>
                    <?php echo $appointment[0]['email'] ?>
            </p>
        </div>
        <div class="vehicle_info">
            <p>
                <strong>
                    Reg No:
                </strong>
                    <?php echo $appointment[0]['reg_no'] ?>
            </p>

            <p>
                <strong>
                    Engine No:
                </strong>
                    <?php echo $appointment[0]['engine_no'] ?>
            </p>

            <p>
                <strong>
                    Model Name:
                </strong>
                    <?php echo $appointment[0]['model_name'] ?>
            </p>
        </div>
    </div>

    <form action="/appointments/for-vin" method="post" class="office-staff-add-appointment-form" enctype="multipart/form-data">
        <div class="office-staff-appointment-form">
            <?php
            FormItem::render(
                id: "milage",
                label: "Milage",
                name: "milage",
                // hasError: $hasFNameError,
                // error: $hasFNameError ? $errors['milage'] : "",
                // value: $body['milage'] ?? null,
                // additionalAttributes: "pattern='^[\p{L} ]+$'"
            );

            FormSelectItem::render(
                id: "service_type",
                label: "Service Type",
                name: "service_type",
                // hasError: $hasFNameError,
                // error: $hasFNameError ? $errors['model'] : "",
                value: "1",
                options: $service
            );

            FormTextareaItem::render(
                id: "remark",
                label: "Remark",
                name: "remark",
                // hasError: $hasDescriptionError,
                // error: $hasDescriptionError ? $errors['description'] : "",
                // value: $hasDescriptionError ? $body['description'] : "",
                rows: 2,
            );

            ?>

            <div class="appointment-time-slot">
                <strong>
                    Choose a Time Slot
                </strong>
            </div>


            <div class="office-staff-btn">
                <button class="btn btn--danger" type="reset">
                    Reset
                </button>

                <button class="btn" type="button" id="add-product-btn">
                    Create an Appointment
                </button>
            </div>

        </div>
    </form>
</div>