<?php

/**
 *  @var array $errors
 */

use app\components\FormItem;

?>

<div class="form-input">
    <?php
    FormItem::render(
        id: "regNo",
        label: "Registration Number",
        name: "regNo"
    );?>
</div>

<div class="images">
    <img src="/images/placeholders/vehicle1.png">
    <img src="/images/placeholders/vehicle2.png">
</div>

<p><b><br>Light</b></p>

<div class="form-input">
    <?php
    FormItem::render(
        id: "LF",
        label: "LF",
        name: "LF"
    );?>
</div>

<div class="form-input">
    <?php
    FormItem::render(
        id: "RF",
        label: "RF",
        name: "RF"
    );?>
</div>

<div class="form-input">
<?php
    FormItem::render(
        id: "spare_wheel",
        // type: "checkbox",
        label: "Spare Wheel",
        name: "spare_wheel"
    );?>  
</div>

<div class="create-button">
    <button type="submit">Create</button>
</div>

<div class="cancel-button">
    <button type="submit">Cancel</button>
</div>