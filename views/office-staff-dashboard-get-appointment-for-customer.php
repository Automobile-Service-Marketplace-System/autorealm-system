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
        <p>
            <strong>
                Customer Name:
            </strong>
            <span>
                <?php echo $appointment[0]['full_name'] ?>
            </span>
        </p>

        <p>
            <strong>
                Contact No:
            </strong>
            <span>
                <?php echo $appointment[0]['contact_no'] ?>
            </span>
        </p>

        <p>
            <strong>
                Email:
            </strong>
            <span>
                <?php echo $appointment[0]['email'] ?>
            </span>
        </p>

        <p>
            <strong>
                Reg No:
            </strong>
            <span>
                <?php echo $appointment[0]['reg_no'] ?>
            </span>
        </p>

        <p>
            <strong>
                Engine No:
            </strong>
            <span>
                <?php echo $appointment[0]['engine_no'] ?>
            </span>
        </p>

        <p>
            <strong>
                Model Name:
            </strong>
            <span>
                <?php echo $appointment[0]['model_name'] ?>
            </span>
        </p>
    </div>

    <form action="/appointments/for-vin" method="post" class="office-staff-add-appointment-form" enctype="multipart/form-data">
        <div class="appointment-form">
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
                rows: 4,
            );

            ?>

            <div class="appointment-time-slot">
                <strong>
                    Choose a Time Slot
                </strong>
            </div>


            <div class="office-staff-btn">
                <button class="btn btn--danger btn--block" type="reset">
                    Reset
                </button>

                <button class="btn btn--block" type="button" id="add-product-btn">
                    Create an Appointment
                </button>
            </div>

        </div>
    </form>
</div>