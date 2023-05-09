<?php

/**
 * @var object $admittingReport
 * @var array $errors
 */

use app\components\FormItem;
use app\components\FormSelectItem;
use app\components\FormTextareaItem;

// $hasErrors = isset($errors) && !empty($errors);
// $hasDepartingTimeError = $hasErrors && isset($errors['departing_time']); 

?>

<!-- <form action="/security-officer-dashboard/admitting-reports/add" method="post" enctype="multipart/form-data"> -->
<?php
    FormItem::render(
        id:"vehicle_reg_no",
        label:"<b>Registration Number</b>",
        name:"vehicle_reg_no",
        type:"text",
        value:$admittingReport->vehicle_reg_no,
        additionalAttributes:"readonly"
    );
?>
            <!-- <div class="images">
                <br><img src="/images/placeholders/vehicle1.png">
                <img src="/images/placeholders/vehicle2.png">
                <div id="more-image">
                    <i class="fa-solid fa-camera"></i>
                    <input type="file" accept="image/*" capture="camera" id="image-input" style="display: none">
                </div>
            </div> -->

<br><p><b>Light</b></p>
        <?php
            FormSelectItem::render(
                id: "light_lf",
                label: "LF",
                name: "lights_lf",
                value: $admittingReport->lights_lf,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "not working" => "Not Working",
                ],
                disabled: "disabled",
            );

            FormItem::render(
                id: "light_lf_description",
                label: "",
                name: "light_lf_description",
                value: $admittingReport->light_lf_description,
                disabled: "disabled",
            );
        ?>
       
        <?php 
            FormSelectItem::render(
                id: "light_rf",
                label: "RF",
                name: "lights_rf",
                value: $admittingReport->lights_rf,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "not working" => "Not Working",
                ],
                disabled: "disabled",
            );

            FormItem::render(
                id: "light_rf_description",
                label: "",
                name: "light_rf_description",
                value: $admittingReport->light_rf_description,
                disabled: "disabled",
            );
        ?>

        <?php 
            FormSelectItem::render(
                id: "light_lr",
                label: "LR",
                name: "lights_lr",
                value: $admittingReport->lights_lr,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "not working" => "Not Working",
                ],
                disabled: "disabled",
            );

            FormItem::render(
                id: "light_lr_description",
                label: "",
                name: "light_lr_description",
                value: $admittingReport->light_lr_description,
                disabled: "disabled",
            );
        ?>

        <?php 
            FormSelectItem::render(
                id: "light_rr",
                label: "RR",
                name: "lights_rr",
                value: $admittingReport->lights_rr,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "not working" => "Not Working",
                ],
                disabled: "disabled",
            );

            FormItem::render(
                id: "light_rr_description",
                label: "",
                name: "light_rr_description",
                type: "text",
                value: $admittingReport->light_rr_description,
                disabled: "disabled",
            );
        ?>

<p><b><br>Seat</b></p>
        <?php 
            FormSelectItem::render(
                id: "seat_lf",
                label: "LF",
                name: "seat_lf",
                value: $admittingReport->seat_lf,
                options: [
                    "good" => "Good",
                    "worn" => "Worn",
                    "burnholes" => "Burnholes",
                    "torn" => "Torn",
                    "stained" => "Stained",
                ],
                disabled: "disabled",
            );

            FormItem::render(
                id: "seat_lf_description",
                label: "",
                name: "seat_lf_description",
                value: $admittingReport->seat_lf_description,
                disabled: "disabled",
            );
        ?>

        <?php
            FormSelectItem::render(
                id: "seat_rf",
                label: "RF",
                name: "seat_rf",
                value: $admittingReport->seat_rf,
                options: [
                    "good" => "Good",
                    "worn" => "Worn",
                    "burnholes" => "Burnholes",
                    "torn" => "Torn",
                    "stained" => "Stained",
                ],
                disabled: "disabled",
            );

            FormItem::render(
                id: "seat_rf_description",
                label: "",
                name: "seat_rf_description",
                value: $admittingReport->seat_rf_description,
                disabled: "disabled",
            );
        ?>

        <?php
            FormSelectItem::render(
                id: "seat_rear",
                label: "REAR",
                name: "seat_rear",
                value: $admittingReport->seat_rear,
                options: [
                    "good" => "Good",
                    "worn" => "Worn",
                    "burnholes" => "Burnholes",
                    "torn" => "Torn",
                    "stained" => "Stained",
                ],
                disabled: "disabled",
            );

            FormItem::render(
                id: "seat_rear_description",
                label: "",
                name: "seat_rear_description",
                value: $admittingReport->seat_rear_description,
                disabled: "disabled",
            );
        ?>

<p><b><br>Carpet</b></p>
        <?php
            FormSelectItem::render(
                id: "carpet_lf",
                label: "LF",
                name: "carpet_lf",
                value: $admittingReport->carpet_lf,
                options: [
                    "good" => "Good",
                    "worn" => "Worn",
                    "burnholes" => "Burnholes",
                    "torn" => "Torn",
                    "stained" => "Stained",
                    "missing" => " Missing",
                ],
                disabled: "disabled",
            );

            FormItem::render(
                id: "carpet_lf_description",
                label: "",
                name: "carpet_lf_description",
                value: $admittingReport->carpet_lf_description,
                disabled: "disabled",
            );
        ?>
            
        <?php
            FormSelectItem::render(
                id: "carpet_rf",
                label: "RF",
                name: "carpet_rf",
                value: $admittingReport->carpet_rf,
                options: [
                    "good" => "Good",
                    "worn" => "Worn",
                    "burnholes" => "Burnholes",
                    "torn" => "Torn",
                    "stained" => "Stained",
                    "missing" => " Missing",
                ],
                disabled: "disabled",
            );

            FormItem::render(
                id: "carpet_rf_description",
                label: "",
                name: "carpet_rf_description",
                value: $admittingReport->carpet_rf_description,
                disabled: "disabled",
            );
        ?>

        <?php
            FormSelectItem::render(
                id: "carpet_rear",
                label: "REAR",
                name: "carpet_rear",
                value: $admittingReport->carpet_rear,
                options: [
                    "good" => "Good",
                    "worn" => "Worn",
                    "burnholes" => "Burnholes",
                    "torn" => "Torn",
                    "stained" => "Stained",
                    "missing" => " Missing",
                ],
                disabled: "disabled",
            );

            FormItem::render(
                id: "carpet_rear_description",
                label: "",
                name: "carpet_rear_description",
                value: $admittingReport->carpet_rear_description,
                disabled: "disabled",
            );
        ?>


<p><b><br>Rim</b></p>
        <?php
            FormSelectItem::render(
                id: "rim_lf",
                label: "LF",
                name: "rim_lf",
                value: $admittingReport->rim_lf,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "missing" => "Missing",
                ],
                disabled: "disabled",
            );

            FormItem::render(
                id: "rim_lf_description",
                label: "",
                name: "rim_lf_description",
                value: $admittingReport->rim_lf_description,
                disabled: "disabled",
            );
        ?>

        <?php
            FormSelectItem::render(
                id: "rim_rf",
                label: "RF",
                name: "rim_rf",
                value: $admittingReport->rim_rf,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "missing" => "Missing",
                ],
                disabled: "disabled",
            );

            FormItem::render(
                id: "rim_rf_description",
                label: "",
                name: "rim_rf_description",
                value: $admittingReport->rim_rf_description,
                disabled: "disabled",
            );
        ?>

        <?php
            FormSelectItem::render(
                id: "rim_lr",
                label: "LR",
                name: "rim_lr",
                value: $admittingReport->rim_lr,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "missing" => "Missing",
                ],
                disabled: "disabled",
            );

            FormItem::render(
                id: "rim_lr_description",
                label: "",
                name: "rim_lr_description",
                value: $admittingReport->rim_lr_description,
                disabled: "disabled",
            );
        ?>

        <?php
            FormSelectItem::render(
                id: "rim_rr",
                label: "RR",
                name: "rim_rr",
                value: $admittingReport->rim_rr,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "missing" => "Missing",
                ],
                disabled: "disabled",
            );
        ?>
  
        <?php
            FormItem::render(
                id: "rim_rr_description",
                label: "",
                name: "rim_rr_description",
                value: $admittingReport->rim_rr_description,
                disabled: "disabled",
            );
        ?>

    <?php
        FormSelectItem::render(
            id: "current_fuel_level",
            label: "<b><br>Current Fuel Level</b>",
            name: "current_fuel_level",
            value: $admittingReport->current_fuel_level,
            options: [
                "full" => "Full",
                "empty" => "Empty",
                "half" => "Half",
                "3/4" => "3/4",
                "1/4" => "1/4",
            ],
            disabled: "disabled",
        );  

        FormItem::render(
            id: "current_fuel_level_description",
            label: "",
            name: "current_fuel_level_description",
            value: $admittingReport->current_fuel_level_description,
            disabled: "disabled",
        );
    ?>

<div class="item-grid">
    <?php
        FormItem::render(
            id: "mileage",
            label: "<b><br>Mileage</b>",
            name: "mileage",
            value: $admittingReport->mileage,
            disabled: "disabled",
        );

        FormItem::render(
            id: "admitting_time",
            label: "<b><br>Admitting Time</b>",
            name: "admitting_time",
            value: $admittingReport->admitting_time,
            disabled: "disabled",
        );

    ?>
</div>
  

    <?php
        FormTextareaItem::render(
            id: "customer_belongings",
            label: "<b>Customer Belongins</b>",
            name: "customer_belongings",
            value: $admittingReport->customer_belongings,
            disabled: "disabled",
        );

        FormTextareaItem::render(
            id: "additional_note",
            label: "<b>Additional Note</b>",
            name: "additional_note",
            value: $admittingReport->additional_note,
            disabled: "disabled",
        );

        FormSelectItem::render(
            id: "dashboard",
            label: "<b><br>Dashboard</b>",
            name: "dashboard",
            value: $admittingReport->dashboard,
            options: [
                "good" => "Good",
                "scratched" => "Scratched",
                "damaged" => "Damaged",
                "burnt" => "Burnt",
                "stained" => "Stained",
            ],
            disabled: "disabled",
        );

        FormItem::render(
            id: "dashboard_description",
            label: "",
            name: "dashboard_description",
            value: $admittingReport->dashboard_description,
            disabled: "disabled",
        );

        FormSelectItem::render(
            id: "windshield",
            label: "<b><br>Windshield</b>",
            name: "windshield",
            value: $admittingReport->windshield,
            options: [
                "good" => "Good",
                "scratched" => "Scratched",
                "cracked" => "Cracked",
                "damaged" => "Damaged",
            ],
            disabled: "disabled",
        );

        FormItem::render(
            id: "windshield_description",
            label: "",
            name: "windshield_description",
            value: $admittingReport->windshield_description,
            disabled: "disabled",
        );
    ?>

<br><div class="form-radio">
    <p><b>Toolkit</b></p>
        <?php 
            $is_have = $admittingReport->toolkit === "have" ? "checked" : "";
            $is_missing = $admittingReport->toolkit === "missing" ? "checked" : "";
        ?>
        <div class="form-item--radio">
            <input type="radio" id="toolkit_have" name="toolkit" value="have" <?= $is_have?> disabled>
            <label for="toolkit_have">Have</label>
        </div>
        <div class="form-item--radio">
            <input type="radio" id="toolkit_missing" name="toolkit" value="missing" <?= $is_missing?> disabled>
            <label for="toolkit_missing">Missing</label>
        </div>
</div>



<br><div class="form-radio">
    <p><b>Sparewheel</b></p>
        <?php
            $is_have = $admittingReport->sparewheel=== "have" ? "checked" : "";
            $is_missing = $admittingReport->sparewheel=== "missing" ? "checked" : "";
        ?>
        <div class="form-item--radio">
            <input type="radio" id="sparewheel_have" name="sparewheel" value="have" <?= $is_have ?> disabled>
            <label for="sparewheel_have">Have</label>
        </div>
        <div class="form-item--radio">
            <input type="radio" id="sparewheel_missing" name="sparewheel" value="missing" <?= $is_missing ?> disabled>
            <label for="sparewheel_missing">Missing</label>
        </div>
</div>

<div class="flex items-center justify-between mt-4 mb-8">
    <button type="reset" class="btn btn--danger">Cancel</button>
    <button type="button" class="btn btn--success" id='admitting-report-approve' data-reportno="<?= $admittingReport->report_no ?>">Approve</button>
</div>

</form>
