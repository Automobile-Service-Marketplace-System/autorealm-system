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
    <br><img src="/images/placeholders/vehicle1.png">
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


<br><br><input type="checkbox" id="spare_wheel" name="spare_wheel" value="spare_wheel">
<label for="spre_wheel"> Spare Wheel</label><br>

<div>
    <button type="submit" id="create-button" >Create</button>
</div>

<div>
    <button type="submit" id="cancel-button">Cancel</button>
</div>