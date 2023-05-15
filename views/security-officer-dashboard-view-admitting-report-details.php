<?php

/**
 * @var object $admittingReport
 * @var array $errors
 */
// var_dump($admittingReport->image);

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
        <div class="admitting-report-add-images">
            <p><b>Photos of vehicles: </b></p>
            <?php $images=json_decode($admittingReport->image); ?>
            <div class="admitting-report-add-images-container">
                <?php
                    foreach($images as $image){
                        echo "<img src=$image>";
                    }
                ?>
            </div>
        </div>

<div class="create-admitting-reports__section">
<br><p><b>Light</b></p>
    <div class="create-admitting-reports__topic">
    <p>LF</p>
        <?php
            FormSelectItem::render(
                id: "light_lf",
                label: "",
                name: "lights_lf",
                disabled: "disabled",
                value: $admittingReport->lights_lf,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "not working" => "Not Working",
                ],
            );

            FormItem::render(
                id: "light_lf_description",
                label: "",
                name: "light_lf_description",
                disabled: "disabled",
                value: $admittingReport->light_lf_description,
            );
        ?>
    </div>
    
    <div class="create-admitting-reports__topic">
    <p>RF</p>     
        <?php 
            FormSelectItem::render(
                id: "light_rf",
                label: "",
                name: "lights_rf",
                disabled: "disabled",
                value: $admittingReport->lights_rf,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "not working" => "Not Working",
                ],
            );

            FormItem::render(
                id: "light_rf_description",
                label: "",
                name: "light_rf_description",
                disabled: "disabled",
                value: $admittingReport->light_rf_description,
            );
        ?>
    </div>

    <div class="create-admitting-reports__topic">
    <p>LR</p>
        <?php 
            FormSelectItem::render(
                id: "light_lr",
                label: "",
                name: "lights_lr",
                disabled: "disabled",
                value: $admittingReport->lights_lr,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "not working" => "Not Working",
                ],
            );

            FormItem::render(
                id: "light_lr_description",
                label: "",
                name: "light_lr_description",
                disabled: "disabled",
                value: $admittingReport->light_lr_description,
            );
        ?>
    </div>

    <div class="create-admitting-reports__topic">
    <p>RR</p>
        <?php 
            FormSelectItem::render(
                id: "light_rr",
                label: "",
                name: "lights_rr",
                disabled: "disabled",
                value: $admittingReport->lights_rr,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "not working" => "Not Working",
                ],
            );

            FormItem::render(
                id: "light_rr_description",
                label: "",
                name: "light_rr_description",
                type: "text",
                disabled: "disabled",
                value: $admittingReport->light_rr_description,
            );
        ?>
    </div>
</div>

<div class="create-admitting-reports__section">
<p><b><br>Seat</b></p>
    <div class="create-admitting-reports__topic">
    <p>LF</p>
        <?php 
            FormSelectItem::render(
                id: "seat_lf",
                label: "",
                name: "seat_lf",
                disabled: "disabled",
                value: $admittingReport->seat_lf,
                options: [
                    "good" => "Good",
                    "worn" => "Worn",
                    "burnholes" => "Burnholes",
                    "torn" => "Torn",
                    "stained" => "Stained",
                ],
            );

            FormItem::render(
                id: "seat_lf_description",
                label: "",
                name: "seat_lf_description",
                disabled: "disabled",
                value: $admittingReport->seat_lf_description,
            );
        ?>
    </div>

    <div class="create-admitting-reports__topic">
    <p>RF</p>   
        <?php
            FormSelectItem::render(
                id: "seat_rf",
                label: "",
                name: "seat_rf",
                disabled: "disabled",
                value: $admittingReport->seat_rf,
                options: [
                    "good" => "Good",
                    "worn" => "Worn",
                    "burnholes" => "Burnholes",
                    "torn" => "Torn",
                    "stained" => "Stained",
                ],
            );

            FormItem::render(
                id: "seat_rf_description",
                label: "",
                name: "seat_rf_description",
                disabled: "disabled",
                value: $admittingReport->seat_rf_description,
            );
        ?>
    </div>

    <div class="create-admitting-reports__topic">
    <p>REAR</p>   
        <?php
            FormSelectItem::render(
                id: "seat_rear",
                label: "",
                name: "seat_rear",
                disabled: "disabled",
                value: $admittingReport->seat_rear,
                options: [
                    "good" => "Good",
                    "worn" => "Worn",
                    "burnholes" => "Burnholes",
                    "torn" => "Torn",
                    "stained" => "Stained",
                ],
            );

            FormItem::render(
                id: "seat_rear_description",
                label: "",
                name: "seat_rear_description",
                disabled: "disabled",
                value: $admittingReport->seat_rear_description,
            );
        ?>
    </div>
</div>

<div class="create-admitting-reports__section">
<p><b><br>Carpet</b></p>
    <div class="create-admitting-reports__topic">
    <p>LF</p>
        <?php
            FormSelectItem::render(
                id: "carpet_lf",
                label: "",
                name: "carpet_lf",
                disabled: "disabled",
                value: $admittingReport->carpet_lf,
                options: [
                    "good" => "Good",
                    "worn" => "Worn",
                    "burnholes" => "Burnholes",
                    "torn" => "Torn",
                    "stained" => "Stained",
                    "missing" => " Missing",
                ],
            );

            FormItem::render(
                id: "carpet_lf_description",
                label: "",
                name: "carpet_lf_description",
                disabled: "disabled",
                value: $admittingReport->carpet_lf_description,
            );
        ?>
    </div>
    <div class="create-admitting-reports__topic">
    <p>RF</p>            
        <?php
            FormSelectItem::render(
                id: "carpet_rf",
                label: "",
                name: "carpet_rf",
                disabled: "disabled",
                value: $admittingReport->carpet_rf,
                options: [
                    "good" => "Good",
                    "worn" => "Worn",
                    "burnholes" => "Burnholes",
                    "torn" => "Torn",
                    "stained" => "Stained",
                    "missing" => " Missing",
                ],
            );

            FormItem::render(
                id: "carpet_rf_description",
                label: "",
                name: "carpet_rf_description",
                disabled: "disabled",
                value: $admittingReport->carpet_rf_description,
            );
        ?>
    <div class="create-admitting-reports__topic">
    <p>REAR</p>
        <?php
            FormSelectItem::render(
                id: "carpet_rear",
                label: "",
                name: "carpet_rear",
                disabled: "disabled",
                value: $admittingReport->carpet_rear,
                options: [
                    "good" => "Good",
                    "worn" => "Worn",
                    "burnholes" => "Burnholes",
                    "torn" => "Torn",
                    "stained" => "Stained",
                    "missing" => " Missing",
                ],
            );

            FormItem::render(
                id: "carpet_rear_description",
                label: "",
                name: "carpet_rear_description",
                disabled: "disabled",
                value: $admittingReport->carpet_rear_description,
            );
        ?>
    </div>
</div>


<div class="create-admitting-reports__section">
<p><b><br>Rim</b></p>
    <div class="create-admitting-reports__topic">
    <p>LF</p>
        <?php
            FormSelectItem::render(
                id: "rim_lf",
                label: "",
                name: "rim_lf",
                disabled: "disabled",
                value: $admittingReport->rim_lf,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "missing" => "Missing",
                ],
            );

            FormItem::render(
                id: "rim_lf_description",
                label: "",
                name: "rim_lf_description",
                disabled: "disabled",
                value: $admittingReport->rim_lf_description,
            );
        ?>
    </div>
    <div class="create-admitting-reports__topic">
    <p>RF</p>
        <?php
            FormSelectItem::render(
                id: "rim_rf",
                label: "",
                name: "rim_rf",
                disabled: "disabled",
                value: $admittingReport->rim_rf,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "missing" => "Missing",
                ],
            );

            FormItem::render(
                id: "rim_rf_description",
                label: "",
                name: "rim_rf_description",
                disabled: "disabled",
                value: $admittingReport->rim_rf_description,
            );
        ?>
    </div>
    <div class="create-admitting-reports__topic">
    <p>LR</p>
        <?php
            FormSelectItem::render(
                id: "rim_lr",
                label: "",
                name: "rim_lr",
                disabled: "disabled",
                value: $admittingReport->rim_lr,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "missing" => "Missing",
                ],
            );

            FormItem::render(
                id: "rim_lr_description",
                label: "",
                name: "rim_lr_description",
                disabled: "disabled",
                value: $admittingReport->rim_lr_description,
            );
        ?>

    <div class="create-admitting-reports__topic">
    <p>RR</p>    
        <?php
            FormSelectItem::render(
                id: "rim_rr",
                label: "",
                name: "rim_rr",
                disabled: "disabled",
                value: $admittingReport->rim_rr,
                options: [
                    "good" => "Good",
                    "scratched" => "Scratched",
                    "cracked" => "Cracked",
                    "damaged" => "Damaged",
                    "missing" => "Missing",
                ],
            );

            FormItem::render(
                id: "rim_rr_description",
                label: "",
                name: "rim_rr_description",
                disabled: "disabled",
                value: $admittingReport->rim_rr_description,
            );
        ?>
    </div>
</div>


<div class="create-admitting-reports__section">
    <?php
        FormSelectItem::render(
            id: "current_fuel_level",
            label: "<b><br>Current Fuel Level</b>",
            name: "current_fuel_level",
            disabled: "disabled",
            value: $admittingReport->current_fuel_level,
            options: [
                "full" => "Full",
                "empty" => "Empty",
                "half" => "Half",
                "3/4" => "3/4",
                "1/4" => "1/4",
            ],
        );  

        FormItem::render(
            id: "current_fuel_level_description",
            label: "",
            name: "current_fuel_level_description",
            disabled: "disabled",
            value: $admittingReport->current_fuel_level_description,
        );
    ?>
</div>

<div class="create-admitting-reports__section">
    <?php
        FormItem::render(
            id: "mileage",
            label: "<b><br>Mileage</b>",
            name: "mileage",
            disabled: "disabled",
            value: $admittingReport->mileage,
        );
    ?>
</div>

<div class="create-admitting-reports__section">
    <?php
        FormItem::render(
            id: "admitting_time",
            label: "<b><br>Admitting Time</b>",
            name: "admitting_time",
            disabled: "disabled",
            value: $admittingReport->admitting_time,
        );

    ?>
</div>

  
<div class="create-admitting-reports__section">
    <?php
        FormTextareaItem::render(
            id: "customer_belongings",
            label: "<b>Customer Belongins</b>",
            name: "customer_belongings",
            disabled: "disabled",
            value: $admittingReport->customer_belongings,
        );
    ?>
</div>

<div class="create-admitting-reports__section">
    <?php
        FormTextareaItem::render(
            id: "additional_note",
            label: "<b>Additional Note</b>",
            name: "additional_note",
            disabled: "disabled",
            value: $admittingReport->additional_note,
        );
    ?>
</div>

<div class="create-admitting-reports__section">
    <?php 
        FormSelectItem::render(
            id: "dashboard",
            label: "<b><br>Dashboard</b>",
            name: "dashboard",
            disabled: "disabled",
            value: $admittingReport->dashboard,
            options: [
                "good" => "Good",
                "scratched" => "Scratched",
                "damaged" => "Damaged",
                "burnt" => "Burnt",
                "stained" => "Stained",
            ],
        );

        FormItem::render(
            id: "dashboard_description",
            label: "",
            name: "dashboard_description",
            disabled: "disabled",
            value: $admittingReport->dashboard_description,
        );
    ?>
</div>

<div class="create-admitting-reports__section">
    <?php
        FormSelectItem::render(
            id: "windshield",
            label: "<b><br>Windshield</b>",
            name: "windshield",
            disabled: "disabled",
            value: $admittingReport->windshield,
            options: [
                "good" => "Good",
                "scratched" => "Scratched",
                "cracked" => "Cracked",
                "damaged" => "Damaged",
            ],
        );

        FormItem::render(
            id: "windshield_description",
            label: "",
            name: "windshield_description",
            disabled: "disabled",
            value: $admittingReport->windshield_description,
        );
    ?>
</div>

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
    <?php 
        if($admittingReport->is_approved === 0){ 
            echo '<button type="button" class="btn btn--success" id="admitting-report-approve" data-reportno="'.$admittingReport->report_no.'" >Approve</button>';
        }
    ?>
        
</div>

</form>
