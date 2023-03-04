 <?php

/**
 * @var array $errors
 */

use app\components\FormItem;
use app\components\FormTextareaItem;

?>


<div class="form-input">
    <?php
        FormItem::render(
            id: "regNo",
            label: "<b>Registration Number</b>",
            name: "regNo"
        );
    ?>

    <div class="images">
        <br><img src="/images/placeholders/vehicle1.png">
        <img src="/images/placeholders/vehicle2.png">
        <div id="reader">
            <i class="fa-solid fa-camera"></i>
            <input type="file" accept="image/*" capture="camera" id="image-input" style="display: none">
        </div>
    </div>

    <p><b><br>Light</b></p>
    <?php 
        FormItem::render(
            id: "LF",
            label: "LF",
            name: "LF"
        );

        FormItem::render(
            id: "RF",
            label: "RF",
            name: "RF"
        );
        
        FormItem::render(
            id: "LF",
            label: "LF",
            name: "LF"
        );
    ?>

    <p><b><br>Seat</b></p>
    <?php
        FormItem::render(
            id: "RF",
            label: "RF",
            name: "RF"
        );

        FormItem::render(
            id: "REAR",
            label: "REAR",
            name: "REAR"
        );
    ?>

    <p><b><br>Carpet</b></p>
    <?php
        FormItem::render(
            id: "LF",
            label: "LF",
            name: "LF"
        );

        FormItem::render(
            id: "RF",
            label: "RF",
            name: "RF"
        );

        FormItem::render(
            id: "REAR",
            label: "REAR",
            name: "REAR"
        );
    ?>

    <p><b><br>Rim</b></p>
    <?php
        FormItem::render(
            id: "LF",
            label: "LF",
            name: "LF"
        );

        FormItem::render(
            id: "RF",
            label: "RF",
            name: "RF",
        );

        FormItem::render(
            id: "LR",
            label: "LR",
            name: "LR",
        );

        FormItem::render(
            id: "LR",
            label: "LR",
            name: "LR",
        );
    ?>
</div>


<div class="Fix-Grid">
    <?php
        FormItem::render(
            id: "milage",
            label: "<b><br>Milage</b>",
            name: "milage",
            type: "number",
        );

        FormItem::render(
            id: "current_fuel_capacity",
            label: "<b><br>Current Fuel Capasity</b>",
            name: "current_fuel_capacity",
            type: "number",
        );

        FormItem::render(
            id: "admitting_time",
            label: "<b>Admitting Time</b>",
            name: "admitting_time",
            type: "time",
        );

        FormItem::render(
            id: "departing_time",
            label: "<b>Departing Time</b>",
            name: "departing_time",
            type: "time",
        );

        FormTextareaItem::render(
            id: "customer_belongings",
            label: "<b>Customer Belongins</b>",
            name: "customer_belongings",
        );

        FormTextareaItem::render(
            id: "additional_note",
            label: "<b>Additional Note</b>",
            name: "additional_note",
        );
    ?>
=======
    FormItem::render(
        id: "LF",
        label: "LF",
        name: "LF"
    ); ?>
</div>

<div class="form-input">
    <?php
        FormItem::render(
            id: "dashboard",
            label: "<b>Dashboard</b>",
            name: "dashboard",
        );

        FormItem::render(
            id: "validate",
            label: "<b>Validate By</b>",
            name: "validate",
            type: "text",
        );
    ?>
</div>

<div class="form-item form-item--checkbox">
    <br><br><label for="spare_wheel"><b>Spare Wheel</b></label>
    <input type="checkbox" name="spare_wheel" id="spare_wheel" value="spare_wheel">
</div>  


<div class="flex items-center justify-between mt-4 mb-8">
    <button type="submit" id="create-button" class="btn">Create</button>
    <button type="submit" id="cancel-button" class="btn btn--danger">Cancel</button>
</div>