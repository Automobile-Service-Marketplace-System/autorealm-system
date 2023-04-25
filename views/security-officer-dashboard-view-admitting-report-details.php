<?php

/**
 * @var object $admittingReport
 */

use app\components\FormItem;
use app\components\FormTextareaItem;

?>

    <form>
        <!-- <div class="form-input"> -->
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
        <!-- </div> -->

            <!-- <div class="images">
                <br><img src="/images/placeholders/vehicle1.png">
                <img src="/images/placeholders/vehicle2.png">
                <div id="more-image">
                    <i class="fa-solid fa-camera"></i>
                    <input type="file" accept="image/*" capture="camera" id="image-input" style="display: none">
                </div>
            </div> -->

            <br><p><b>Light</b></p>
            <div class="form-item">
                <!-- <label for="LF">LF</label> -->
                <p>LF</p>
                <div class="form-radio">
                    <?php
                        $is_good = $admittingReport->lights_lf === "good" ? "checked" : "";
                        $is_scratched = $admittingReport->lights_lf === "scratched" ? "checked" : "";
                        $is_cracked = $admittingReport->lights_lf === "cracked" ? "checked" : "";
                        $is_damaged = $admittingReport->lights_lf === "damaged" ? "checked" : "";
                        $is_notworking = $admittingReport->lights_lf === "not working" ? "checked" : "";
                    ?>
                    <div class="radio-type1">
                        <input type="radio" id="light_lf_good" name="lights_lf" value="good" <?= $is_good ?> disabled>
                        <label for="light_lf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_lf_scratched" name="lights_lf" value="scratched" <?= $is_scratched ?> disabled>
                        <label for="light_lf_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_lf_cracked" name="lights_lf" value="cracked" <?= $is_cracked ?> disabled>
                        <label for="light_lf_scratched">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_lf_damaged" name="lights_lf" value="damaged" <?= $is_damaged ?> disabled>
                        <label for="light_lf_damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_lf_not_working" name="lights_lf" value="not working" <?= $is_notworking ?> disabled>
                        <label for="light_lf_not_working">Not Working</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"light_lf_description",
                        label:"",
                        name:"light_lf_description",
                        type:"text",
                        value:$admittingReport->light_lf_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>
            <div class="form-item">
                <p>RF</p>
                <div class="form-radio">
                    <?php
                        $is_good = $admittingReport->lights_rf === "good" ? "checked" : "";
                        $is_scratched = $admittingReport->lights_rf === "scratched" ? "checked" : "";
                        $is_cracked = $admittingReport->lights_rf === "cracked" ? "checked" : "";
                        $is_damaged = $admittingReport->lights_rf === "damaged" ? "checked" : "";
                        $is_notworking = $admittingReport->lights_rf === "not working" ? "checked" : "";
                    ?>
                    <div class="radio-type1">
                        <input type="radio" id="light_rf_good" name="lights_rf" value="good" <?= $is_good ?> disabled>
                        <label for="light_rf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_rf_scratched" name="lights_rf" value="scratched" <?= $is_scratched ?> disabled>
                        <label for="light_rf_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_rf_cracked" name="lights_rf" value="cracked" <?= $is_cracked ?> disabled>
                        <label for="light_rf_cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_rf_damaged" name="lights_rf" value="damaged" <?= $is_damaged ?> disabled>
                        <label for="light_rf_damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_rf_not_working" name="lights_rf" value="not working" <?= $is_notworking ?> disabled>
                        <label for="light_rf_not_working">Not Working</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"light_rf_description",
                        label:"",
                        name:"light_rf_description",
                        type:"text",
                        value:$admittingReport->light_rf_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>
            <div class="form-item">
                <p>LR</p>
                <div class="form-radio">
                    <?php
                        $is_good = $admittingReport->lights_lr === "good" ? "checked" : "";
                        $is_scratched = $admittingReport->lights_lr === "scratched" ? "checked" : "";
                        $is_cracked = $admittingReport->lights_lr === "cracked" ? "checked" : "";
                        $is_damaged = $admittingReport->lights_lr === "damaged" ? "checked" : "";
                        $is_notworking = $admittingReport->lights_lr === "not working" ? "checked" : "";
                    ?>
                    <div class="radio-type1">
                        <input type="radio" id="light_lr_good" name="lights_lr" value="good" <?= $is_good ?> disabled >
                        <label for="light_lr_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_lr_scratched" name="lights_lr" value="scratched" <?= $is_scratched ?> disabled>
                        <label for="light_lr_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_lr_cracked" name="lights_lr" value="cracked" <?= $is_cracked ?> disabled>
                        <label for="light_lr_cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_lr_damaged" name="lights_lr" value="damaged" <?= $is_damaged ?> disabled>
                        <label for="light_lr_damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_lr_not_working" name="lights_lr" value="not working" <?= $is_notworking ?> disabled>
                        <label for="light_lr_not_working">Not Working</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"light_lr_description",
                        label:"",
                        name:"light_lr_description",
                        type:"text",
                        value:$admittingReport->light_lr_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>
            <div class="form-item">
                <p>RR</p>
                <div class="form-radio">
                    <?php
                        $is_good = $admittingReport->lights_rr === "good" ? "checked" : "";
                        $is_scratched = $admittingReport->lights_rr === "scratched" ? "checked" : "";
                        $is_cracked = $admittingReport->lights_rr === "cracked" ? "checked" : "";
                        $is_damaged = $admittingReport->lights_rr === "damaged" ? "checked" : "";
                        $is_notworking = $admittingReport->lights_rr === "not working" ? "checked" : "";
                    ?>
                     <div class="radio-type2">
                        <input type="radio" id="light_rr_good" name="lights_rr" value="good" <?= $is_good ?> disabled>
                        <label for="light_rr_good">Good</label>
                    </div>                   
                    <div class="radio-type2">
                        <input type="radio" id="light_rr_scratched" name="lights_rr" value="scratched" <?= $is_scratched ?> disabled>
                        <label for="light_rr_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_rr_cracked" name="lights_rr" value="cracked" <?= $is_cracked ?> disabled>
                        <label for="light_rr_cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_rr_damaged" name="lights_rr" value="damaged" <?= $is_damaged ?> disabled>
                        <label for="light_rr_damaged">Damaged</label>
                    </div>
                    <div class="radio-type4">
                        <input type="radio" id="light_rr_not_working" name="lights_rr" value="not working" <?= $is_notworking ?> disabled>
                        <label for="light_rr_not_working">Not Working</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"light_rr_description",
                        label:"",
                        name:"light_rr_description",
                        type:"text",
                        value:$admittingReport->light_rr_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>
            <p><b><br>Seat</b></p>
            <div class="form-item">
                <p>LF</p>
                <div class="form-radio">
                    <?php
                        $is_good = $admittingReport->seat_lf === "good" ? "checked" : "";
                        $is_worn = $admittingReport->seat_lf === "worn" ? "checked" : "";
                        $is_burnholes = $admittingReport->seat_lf === "burnholes" ? "checked" : "";
                        $is_torn = $admittingReport->seat_lf === "torn" ? "checked" : "";
                        $is_stained = $admittingReport->seat_lf === "stained" ? "checked" : "";
                    ?>
                    <div class="radio-type1">
                        <input type="radio" id="seat_lf_good" name="seat_lf" value="good" <?= $is_good ?> disabled>
                        <label for="seat_lf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="seat_lf_worn" name="seat_lf" value="worn" <?= $is_worn ?> disabled>
                        <label for="seat_lf_worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_lf_burnholes" name="seat_lf" value="burnholes" <?= $is_burnholes ?> disabled>
                        <label for="seat_lf_burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_lf_torn" name="seat_lf" value="torn" <?= $is_torn ?> disabled>
                        <label for="seat_lf_torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_lf_stained" name="seat_lf" value="stained"<?= $is_stained ?> disabled>
                        <label for="seat_lf_stained">Stained</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"seat_lf_description",
                        label:"",
                        name:"seat_lf_description",
                        type:"text",
                        value:$admittingReport->seat_lf_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>
            <div class="form-item">
                <p>RF</p>
                <div class="form-radio">
                <?php
                    $is_good = $admittingReport->seat_rf === "good" ? "checked" : "";
                    $is_worn = $admittingReport->seat_rf === "worn" ? "checked" : "";
                    $is_burnholes = $admittingReport->seat_rf === "burnholes" ? "checked" : "";
                    $is_torn = $admittingReport->seat_rf === "torn" ? "checked" : "";
                    $is_stained = $admittingReport->seat_rf === "stained" ? "checked" : "";
                ?>               
                <div class="radio-type1">
                        <input type="radio" id="seat_rf_good" name="seat_rf" value="good" <?= $is_good ?> disabled>
                        <label for="seat_rf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="seat_rf_worn" name="seat_rf" value="worn" <?= $is_worn ?> disabled>
                        <label for="seat_rf_worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_rf_burnholes" name="seat_rf" value="burnholes" <?= $is_burnholes ?> disabled>
                        <label for="seat_rf_burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_rf_torn" name="seat_rf" value="torn" <?= $is_torn ?> disabled>
                        <label for="seat_rf_torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_rf_stained" name="seat_rf" value="stained" <?= $is_stained ?> disabled>
                        <label for="seat_rf_stained">Stained</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"seat_rf_description",
                        label:"",
                        name:"seat_rf_description",
                        type:"text",
                        value:$admittingReport->seat_rf_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>
            <div class="form-item">
                <p>REAR</p>
                <div class="form-radio">
                <?php
                    $is_good = $admittingReport->seat_rear === "good" ? "checked" : "";
                    $is_worn = $admittingReport->seat_rear === "worn" ? "checked" : "";
                    $is_burnholes = $admittingReport->seat_rear === "burnholes" ? "checked" : "";
                    $is_torn = $admittingReport->seat_rear === "torn" ? "checked" : "";
                    $is_stained = $admittingReport->seat_rear === "stained" ? "checked" : "";
                ?>
                <div class="radio-type1">
                        <input type="radio" id="seat_rear_good" name="seat_rear" value="good" <?= $is_good ?> disabled>
                        <label for="seat_rear_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="seat_rear_worn" name="seat_rear" value="worn" <?= $is_worn ?> disabled>
                        <label for="seat_rear_worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_rear_burnholes" name="seat_rear" value="burnholes" <?= $is_burnholes ?> disabled>
                        <label for="seat_rear_burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_rear_torn" name="seat_rear" value="torn" <?= $is_torn ?> disabled>
                        <label for="seat_rear_torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_rear_stained" name="seat_rear" value="stained" <?= $is_stained ?> disabled>
                        <label for="seat_rear_stained">Stained</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"seat_rear_description",
                        label:"",
                        name:"seat_rear_description",
                        type:"text",
                        value:$admittingReport->seat_rear_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>
            <p><b><br>Carpet</b></p>
            <div class="form-item">
                <p>LF</p>
                <div class="form-radio">
                <?php
                    $is_good = $admittingReport->carpet_lf === "good" ? "checked" : "";
                    $is_worn = $admittingReport->carpet_lf === "worn" ? "checked" : "";
                    $is_burnholes = $admittingReport->carpet_lf === "burnholes" ? "checked" : "";
                    $is_torn = $admittingReport->carpet_lf === "torn" ? "checked" : "";
                    $is_stained = $admittingReport->carpet_lf === "stained" ? "checked" : "";
                    $is_missing = $admittingReport->carpet_lf === "missing" ? "checked" : "";
                ?>
                <div class="radio-type1">
                        <input type="radio" id="carpet_lf_good" name="carpet_lf" value="good" <?= $is_good ?> disabled>
                        <label for="carpet_lf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="carpet_lf_worn" name="carpet_lf_carpet_lf" value="worn" <?= $is_worn ?> disabled>
                        <label for="carpet_lf_worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_lf_burnholes" name="carpet_lf" value="burnholes" <?= $is_burnholes ?> disabled>
                        <label for="carpet_lf_burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_lf_torn" name="carpet_lf" value="torn" <?= $is_torn ?> disabled>
                        <label for="carpet_lf_torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_lf_stained" name="carpet_lf" value="stained" <?= $is_stained ?> disabled>
                        <label for="carpet_lf_stained">Stained</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_lf_missing" name="carpet_lf" value="missing" <?= $is_missing ?> disabled>
                        <label for="carpet_lf_missing">Missing</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"carpet_lf_description",
                        label:"",
                        name:"carpet_lf_description",
                        type:"text",
                        value:$admittingReport->carpet_lf_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>
            <div class="form-item">
                <p>RF</p>
                <div class="form-radio">
                <?php
                    $is_good = $admittingReport->carpet_rf === "good" ? "checked" : "";
                    $is_worn = $admittingReport->carpet_rf === "worn" ? "checked" : "";
                    $is_burnholes = $admittingReport->carpet_rf === "burnholes" ? "checked" : "";
                    $is_torn = $admittingReport->carpet_rf === "torn" ? "checked" : "";
                    $is_stained = $admittingReport->carpet_rf === "stained" ? "checked" : "";
                    $is_missing = $admittingReport->carpet_rf === "missing" ? "checked" : "";
                ?>
                    <div class="radio-type1">
                        <input type="radio" id="carpet_rf_good" name="carpet_rf" value="good" <?= $is_good ?> disabled>
                        <label for="carpet_rf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="carpet_rf_worn" name="carpet_rf" value="worn" <?= $is_worn?> disabled>
                        <label for="carpet_rf_worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rf_burnholes" name="carpet_rf" value="burnholes" <?= $is_burnholes ?> disabled>
                        <label for="carpet_rf_burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rf_torn" name="carpet_rf" value="torn" <?= $is_torn ?> disabled>
                        <label for="carpet_rf_torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rf_stained" name="carpet_rf" value="stained" <?= $is_stained?> disabled>
                        <label for="carpet_rf_stained">Stained</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rf_missing" name="carpet_rf" value="missing" <?= $is_missing ?> disabled>
                        <label for="carpet_rf_missing">Missing</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"carpet_rf_description",
                        label:"",
                        name:"carpet_rf_description",
                        type:"text",
                        value:$admittingReport->carpet_rf_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>
            <div class="form-item">
                <p>REAR</p>
                <div class="form-radio">
                <?php
                    $is_good = $admittingReport->carpet_rear === "good" ? "checked" : "";
                    $is_worn = $admittingReport->carpet_rear === "worn" ? "checked" : "";
                    $is_burnholes = $admittingReport->carpet_rear === "burnholes" ? "checked" : "";
                    $is_torn = $admittingReport->carpet_rear === "torn" ? "checked" : "";
                    $is_stained = $admittingReport->carpet_rear === "stained" ? "checked" : "";
                    $is_missing = $admittingReport->carpet_rear === "missing" ? "checked" : "";
                ?>
                    <div class="radio-type1">
                        <input type="radio" id="carpet_rear_good" name="carpet_rear" value="good" <?= $is_good ?> disabled>
                        <label for="carpet_rear_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="carpet_rear_worn" name="carpet_rear" value="worn" <?= $is_worn ?> disabled>
                        <label for="carpet_rear_worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rear_burnholes" name="carpet_rear" value="burnholes" <?= $is_burnholes ?> disabled>
                        <label for="carpet_rear_burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rear_torn" name="carpet_rear" value="torn" <?= $is_torn ?> disabled>
                        <label for="carpet_rear_torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rear_stained" name="carpet_rear" value="stained" <?= $is_stained ?> disabled>
                        <label for="carpet_rear_stained">Stained</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rear_missing" name="carpet_rear" value="missing" <?= $is_missing ?> disabled>
                        <label for="carpet_rear_missing">Missing</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"carpet_rear_description",
                        label:"",
                        name:"carpet_rear_description",
                        type:"text",
                        value:$admittingReport->carpet_rear_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>



            <p><b><br>Rim</b></p>
            <div class="form-item">
                <p>LF</p>
                <div class="form-radio">
                <?php
                    $is_good = $admittingReport->rim_lf === "good" ? "checked" : "";
                    $is_scratched = $admittingReport->rim_lf === "scratched" ? "checked" : "";
                    $is_cracked = $admittingReport->rim_lf === "cracked" ? "checked" : "";
                    $is_damaged = $admittingReport->rim_lf === "damaged" ? "checked" : "";
                ?>
                    <div class="radio-type1">
                        <input type="radio" id="rim_lf_good" name="rim_lf" value="good" <?= $is_good ?> disabled>
                        <label for="rim_lf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_lf_scratched" name="rim_lf" value="scratched" <?= $is_scratched ?> disabled>
                        <label for="rim_lf_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_lf_cracked" name="rim_lf" value="cracked" <?= $is_cracked ?> disabled>
                        <label for="rim_lf_cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_lf_dameged" name="rim_lf" value="damaged" <?= $is_damaged?> disabled>
                        <label for="rim_lf_damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_lf_missing" name="rim_lf" value="missing" <?= $is_missing ?> disabled>
                        <label for="rim_lf_missing">Missing</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"rim_lf_description",
                        label:"",
                        name:"rim_lf_description",
                        type:"text",
                        value:$admittingReport->rim_lf_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>
            <div class="form-item">
                <p>RF</p>
                <div class="form-radio">
                <?php
                    $is_good = $admittingReport->rim_rf === "good" ? "checked" : "";
                    $is_scratched = $admittingReport->rim_rf === "scratched" ? "checked" : "";
                    $is_cracked = $admittingReport->rim_rf === "cracked" ? "checked" : "";
                    $is_damaged = $admittingReport->rim_rf === "damaged" ? "checked" : "";
                ?>
                    <div class="radio-type1">
                        <input type="radio" id="rim_rf_good" name="rim_rf" value="good" <?= $is_good ?> disabled>
                        <label for="rim_rf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_rf_scratched" name="rim_rf" value="scratched" <?= $is_scratched ?> disabled>
                        <label for="rim_rf_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_rf_cracked" name="rim_rf" value="cracked" <?= $is_cracked ?> disabled>
                        <label for="rim_rf_cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_rf_damaged" name="rim_rf" value="damaged" <?= $is_damaged ?> disabled>
                        <label for="rim_rf_damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_rf_missing" name="rim_rf" value="missing" <?= $is_missing ?>  disabled>
                        <label for="rim_rf_missing">Missing</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"rim_rf_description",
                        label:"",
                        name:"rim_rf_description",
                        type:"text",
                        value:$admittingReport->rim_rf_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>
            <div class="form-item">
                <p>LR</p>
                <div class="form-radio">
                <?php
                    $is_good = $admittingReport->rim_lr === "good" ? "checked" : "";
                    $is_scratched = $admittingReport->rim_lr === "scratched" ? "checked" : "";
                    $is_cracked = $admittingReport->rim_lr === "cracked" ? "checked" : "";
                    $is_damaged = $admittingReport->rim_lr === "damaged" ? "checked" : "";
                ?>
                    <div class="radio-type1">
                        <input type="radio" id="rim_lr_good" name="rim_lr" value="good" <?= $is_good ?> disabled>
                        <label for="rim_lr_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_lr_scratched" name="rim_lr" value="scratched" <?= $is_scratched?> disabled>
                        <label for="rim_lr_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_lr_cracked" name="rim_lr" value="cracked" <?= $is_cracked ?> disabled>
                        <label for="rim_lr_scratched">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_lr_damaged" name="rim_lr" value="damaged" <?= $is_damaged?> disabled>
                        <label for="rim_lr_damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_lr_missing" name="rim_lr" value="missing" <?= $is_missing ?> disabled>
                        <label for="rim_lr_missing">Missing</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"rim_lr_description",
                        label:"",
                        name:"rim_lr_description",
                        type:"text",
                        value:$admittingReport->rim_lr_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>
            <div class="form-item">
                <p>RR</p>
                <div class="form-radio">
                <?php
                    $is_good = $admittingReport->rim_rr === "good" ? "checked" : "";
                    $is_scratched = $admittingReport->rim_rr === "scratched" ? "checked" : "";
                    $is_cracked = $admittingReport->rim_rr === "cracked" ? "checked" : "";
                    $is_damaged = $admittingReport->rim_rr === "damaged" ? "checked" : "";
                ?>
                    <div class="radio-type1">
                        <input type="radio" id="rim_rr_good" name="rim_rr" value="good" <?= $is_good ?> disabled>
                        <label for="rim_rr_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_rr_scratched" name="rim_rr" value="scratched" <?= $is_scratched ?> disabled>
                        <label for="rim_rr_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_rr_cracked" name="rim_rr" value="cracked" <?= $is_cracked ?> disabled>
                        <label for="rim_rr_cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_rr_damaged" name="rim_rr" value="damaged" <?= $is_damaged ?> disabled>
                        <label for="rim_rr_damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_rr_missing" name="rim_rr" value="missing" <?= $is_missing ?> disabled>
                        <label for="rim_rr_missing">Missing</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"rim_rr_description",
                        label:"",
                        name:"rim_rr_description",
                        type:"text",
                        value:$admittingReport->rim_rr_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>

            <div class="form-item">
                <p><b>Current Fuel Level</b></p>
                <div class="form-radio">
                <?php
                    $is_full = $admittingReport->current_fuel_level === "full" ? "checked" : "";
                    $is_empty = $admittingReport->current_fuel_level === "empty" ? "checked" : "";
                    $is_half = $admittingReport->current_fuel_level === "half" ? "checked" : "";
                    $is_3_4 = $admittingReport->current_fuel_level === "3/4" ? "checked" : "";
                    $is_1_4 = $admittingReport->current_fuel_level === "1/4" ? "checked" : "";
                ?>
                    <div class="radio-type1">
                        <input type="radio" id="current_fuel_level_full" name="current_fuel_level" value="full" <?= $is_full ?> disabled>
                        <label for="current_fuel_level_full">Full</label>
                    </div>
                    <div class="radio-type1">
                        <input type="radio" id="current_fuel_level_empty" name="current_fuel_level" value="empty" <?= $is_empty ?> disabled>
                        <label for="current_fuel_level_empty">Empty</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="current_fuel_level_half" name="current_fuel_level" value="half" <?= $is_half ?> disabled>
                        <label for="current_fuel_level_half">Half</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="current_fuel_level_3/4" name="current_fuel_level" value="3/4" <?= $is_3_4 ?> disabled>
                        <label for="current_fuel_level_3/4">3/4</label>
                    </div>
                    <div class="radio-type4">
                        <input type="radio" id="current_fuel_level_1/4" name="current_fuel_level" value="1/4" <?= $is_1_4 ?> disabled>
                        <label for="current_fuel_level_1/4">1/4</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"current_fuel_level_description",
                        label:"",
                        name:"current_fuel_level_description",
                        type:"text",
                        value:$admittingReport->current_fuel_level_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>


        <div class="item-grid">
            <?php
                FormItem::render(
                    id:"milage",
                    label:"<b><br>Milage</b>",
                    name:"milage",
                    type:"number",
                    value:$admittingReport->milage,
                    additionalAttributes:"readonly"
                );

                FormItem::render(
                    id:"admiting_time",
                    label:"<b><br>Admitting Time</b>",
                    name:"admiting_time",
                    type:"time",
                    value:$admittingReport->admiting_time,
                    additionalAttributes:"readonly"
                );

                FormItem::render(
                    id:"departing_time",
                    label:"<b><br>Departing Time</b>",
                    name:"departing_time",
                    type:"time",
                    value:$admittingReport->departing_time,
                    additionalAttributes:"readonly"
                );

            ?>
        </div>

        <div class="description-grid">
            <?php
                FormTextareaItem::render(
                    id:"customer_belongings",
                    label:"<b>Customer Belongins</b>",
                    name:"customer_belongings",
                    type:"text",
                    value:$admittingReport->customer_belongings,
                    additionalAttributes:"readonly"
                );

                FormTextareaItem::render(
                    id:"additional_note",
                    label:"<b>Additional Note</b>",
                    name:"additional_note",
                    type:"text",
                    value:$admittingReport->additional_note,
                    additionalAttributes:"readonly"
                );
            ?>
        </div>

            <div class="form-item">
                <p><b>Dashboard</b></p>
                <div class="form-radio">
                <?php
                    $is_good = $admittingReport->dashboard === "good" ? "checked" : "";
                    $is_scratched = $admittingReport->dashboard === "scratched" ? "checked" : "";
                    $is_damaged = $admittingReport->dashboard === "damaged" ? "checked" : "";
                    $is_burnt = $admittingReport->dashboard === "burnt" ? "checked" : "";
                ?>
                    <div class="radio-type1">
                        <input type="radio" id="dashbard_good" name="dashboard" value="good" <?= $is_good ?> disabled>
                        <label for="dashbard_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="dashbard_scratched" name="dashboard" value="scratched" <?= $is_scratched ?> disabled>
                        <label for="dashbard_scratched">Scratched</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="dashbard_damaged" name="dashboard" value="damaged" <?= $is_damaged ?> disabled>
                        <label for="dashbard_damaged">Damaged</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="dashbard_cracked" name="dashboard" value="burnt" <?= $is_burnt?> disabled>
                        <label for="dashbard_burnt">Burnt</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="dashbard_stained" name="dashboard" value="stained" <?= $is_stained ?> disabled>
                        <label for="dashbard_stained">Stained</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"dashboard_description",
                        label:"",
                        name:"dashboard_description",
                        type:"text",
                        value:$admittingReport->dashboard_description,
                    );
                ?>
            </div>

            <b>Windshield</b>
            <div class="form-item">
                <div class="form-radio">
                    <?php 
                        $is_good = $admittingReport->windshield === "good" ? "checked" : "";
                        $is_scratched = $admittingReport->windshield === "scratched" ? "checked" : "";
                        $is_cracked = $admittingReport->windshield === "cracked" ? "checked" : "";
                        $is_damaged = $admittingReport->windshield === "damaged" ? "checked" : "";
                    ?>
                    <div class="radio-type1">
                        <input type="radio" id="windshield_good" name="windshield" value="good" <?= $is_good ?> disabled>
                        <label for="windshield_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="windshield_scratched" name="windshield" value="scratched" <?= $is_scratched ?> disabled>
                        <label for="windshield_scratched">Scratched</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="windshield_cracked" name="windshield" value="cracked" <?= $is_cracked ?> disabled>
                        <label for="windshield_cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="windshield_damaged" name="windshield" value="damaged" <?= $is_damaged ?> disabled>
                        <label for="windshield_damaged">Damaged</label>
                    </div>
                </div>
                <?php
                    FormItem::render(
                        id:"windshield_description",
                        label:"",
                        name:"windshield_description",
                        type:"text",
                        value:$admittingReport->windshield_description,
                        additionalAttributes:"readonly"
                    );
                ?>
            </div>

        <br><div class="form-item">
            <div class="form-radio">
                <?php 
                    $is_have = $admittingReport->toolkit === "have" ? "checked" : "";
                    $is_missing = $admittingReport->toolkit === "missing" ? "checked" : "";
                ?>
                <p><b>Toolkit</b></p>
                <div class="radio-type1">
                    <input type="radio" id="toolkit_have" name="toolkit" value="have" <?= $is_have?> disabled>
                    <label for="toolkit_have">Have</label>
                </div>
                <div class="radio-type2">
                    <input type="radio" id="toolkit_missing" name="toolkit" value="missing" <?= $is_missing ?> disabled>
                    <label for="toolkit_missing">Missing</label>
                </div>
            </div>
        </div>


        <br><div class="form-item">
            <div class="form-radio">
            <?php
                $is_have = $admittingReport->sparewheel=== "have" ? "checked" : "";
                $is_missing = $admittingReport->sparewheel=== "missing" ? "checked" : "";
            ?>
            <p><b>Sparewheel</b></p>
                <div class="radio-type1">
                    <input type="radio" id="sparewheel_have" name="sparewheel" value="have" <?= $is_have ?> disabled>
                    <label for="sparewheel_have">Have</label>
                </div>
                <div class="radio-type2">
                    <input type="radio" id="sparewheel_missing" name="sparewheel" value="missing" <?= $is_missing ?> disabled>
                    <label for="sparewheel_missing">Missing</label>
                </div>
            </div>
        </div>
    </form>