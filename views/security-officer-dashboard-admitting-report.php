<?php

/**
 * @var array $errors
 */

use app\components\FormItem;

?>


<?php
FormItem::render(
    id: "regNo",
    label: "Registration Number",
    name: "regNo"
); ?>

<div class="admitting-images">
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
    ); ?>
</div>

<div class="form-input">
    <?php
    FormItem::render(
        id: "RF",
        label: "RF",
        name: "RF"
    ); ?>
</div>


<br><br><input type="checkbox" id="spare_wheel" name="spare_wheel" value="spare_wheel">
<label for="spre_wheel"> Spare Wheel</label><br>

<div class="flex items-center justify-between mt-4 mb-8">
    <button type="submit" id="create-button" class="btn">Create</button>
    <button type="submit" id="cancel-button" class="btn btn--danger">Cancel</button>
</div>