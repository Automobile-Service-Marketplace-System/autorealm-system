 <?php

/**
 * @var array $errors
 */

use app\components\FormItem;
use app\components\FormTextareaItem;

$hasErrors = isset($errors) && !empty($errors);
$hasVehicleRegNoError = $hasErrors && isset($errors['vehicle_reg_no']);
$hasMilageError = $hasErrors && isset($errors['milage"']);
$hasCurrentFuelLevelError = $hasErrors && isset($errors['current_fuel_level']);
$hasCurrentFuelLevelDescriptionError = $hasErrors && isset($errors['current_fuel_level_description']);
$hasAdmittingTimeError = $hasErrors && isset($errors['admiting_time']);
$hasDepartingTimeError = $hasErrors && isset($errors['departing_time']);
$hasWindshieldError = $hasErrors && isset($errors['windshield']);
// $hasWindshieldDescriptionError = $hasErrors && isset($errors['windshield_description']);
// // $hasLightsLFError = $hasErrors && isset($errors['lights_lf']);
// $hasLightLFDescriptionError = $hasErrors && isset($errors['light_lf_description']);
// // $hasLightsRFError = $hasErrors && isset($errors['lights_rf']);
// $hasLightRFDescriptionError = $hasErrors && isset($errors['light_rf_description']);
// // $hasLightsLRError = $hasErrors && isset($errors['lights_lr']);
// $hasLightLRDescriptionError = $hasErrors && isset($errors['light_lr_description']);
// // $hasLightsRRError = $hasErrors && isset($errors['lights_rr']);
// $hasLightRRDescriptionError = $hasErrors && isset($errors['light_rr_description']);
// $hasToolkitError = $hasErrors && isset($errors['toolkit']);
// $hasSparewheelError = $hasErrors && isset($errors['sparewheele']);
// $hasRimLFError = $hasErrors && isset($errors['rim_lf']);
// $hasRimLFDescriptionError = $hasErrors && isset($errors['rim_lf_description']);
// // $hasRimRFError = $hasErrors && isset($errors['rim_rf']);
// $hasRimRFDescriptionError = $hasErrors && isset($errors['rim_rf_description']);
// // $hasRimLRError = $hasErrors && isset($errors['rim_lr']);
// $hasRimLRDescriptionError = $hasErrors && isset($errors['rim_lr_description']);
// // $hasRimRRError = $hasErrors && isset($errors['rim_rr']);
// $hasRimRRDescriptionError = $hasErrors && isset($errors['rim_rr_description']);
// // $hasSeatLFError = $hasErrors && isset($errors['seat_lf']);
// $hasSeatLFDescriptionError = $hasErrors && isset($errors['seat_lf_description']);
// // $hasSeatRFError = $hasErrors && isset($errors['seat_rf']);
// $hasSeatRFDescriptionError = $hasErrors && isset($errors['seat_rf_description']);
// // $hasSeatREARError = $hasErrors && isset($errors['seat_rear']);
// $hasSeatREARDescriptionError = $hasErrors && isset($errors['seat_rear_description']);
// // $hasCarpetLFError = $hasErrors && isset($errors['carpet_lf']);
// $hasCarpetLFDescriptionError = $hasErrors && isset($errors['carpet_lf_description']);
// // $hasCarpetRFError = $hasErrors && isset($errors['carpet_rf']);
// $hasCarpetRFDescriptionError = $hasErrors && isset($errors['carpet_rf_description']);
// // $hasCarpetREARError = $hasErrors && isset($errors['carpet_rear']);
// $hasCarpetREARDescriptionError = $hasErrors && isset($errors['carpet_rear_description']);
$hasDashboardError = $hasErrors && isset($errors['dashboard']);
// $hasDashboardDescriptionError = $hasErrors && isset($errors['dashboard_description']);
$hasCustomerBelongingsError = $hasErrors && isset($errors['customer_belongings']);
$hasAdditionalNoteError = $hasErrors && isset($errors['additional_note']);

?>

    <form action="/security-officer-dashboard/admitting-reports/add" method="post" enctype="multipart/form-data">
        <!-- <div class="form-input"> -->
            <?php
                FormItem::render(
                    id: "vehicle_reg_no",
                    label: "<b>Registration Number</b>",
                    name: "vehicle_reg_no",
                    type: "text",
                    hasError: $hasVehicleRegNoError,
                    error: $hasVehicleRegNoError ? $errors['vehicle_reg_no'] : "",
                    value: $body['vehicle_reg_no'] ?? null,
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
                    <div class="radio-type1">
                        <input type="radio" id="light_lf_good" name="lights_lf" value="good">
                        <label for="light_lf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_lf_scratched" name="lights_lf" value="scratched">
                        <label for="light_lf_scratched">Scratched</label>
                    </div>                
                    <div class="radio-type2">
                        <input type="radio" id="light_lf_cracked" name="lights_lf" value="cracked">
                        <label for="light_lf_scratched">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_lf_damaged" name="lights_lf" value="damaged">
                        <label for="light_lf_damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_lf_not_working" name="lights_lf" value="not working">
                        <label for="light_lf_not_working">Not Working</label>
                    </div>
                </div>   
                <?php
                    FormItem::render(
                        id: "light_lf_description",
                        label: "",
                        name: "light_lf_description",
                        type: "text",
                        // hasError: $hasLightLFDescriptionError,
                        // error: $hasLightLFDescriptionError ? $errors['light_lf_description'] : "",
                        value: $body['light_lf_description'] ?? null,
                    );
                ?>
            </div>
            <div class="form-item">
                <p>RF</p>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="light_rf_good" name="lights_rf" value="good">
                        <label for="light_rf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_rf_scratched" name="lights_rf" value="scratched">
                        <label for="light_rf_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_rf_cracked" name="lights_rf" value="cracked">
                        <label for="light_rf_cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_rf_damaged" name="lights_rf" value="damaged">
                        <label for="light_rf_damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_rf_not_working" name="lights_rf" value="not working">
                        <label for="light_rf_not_working">Not Working</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "light_rf_description",
                        label: "",
                        name: "light_rf_description",
                        type: "text",
                        // hasError: $hasLightRFDescriptionError,
                        // error: $hasLightRFDescriptionError ? $errors['light_rf_description'] : "",
                        value: $body['light_rf_description'] ?? null,
                    );
                ?>
            </div>
            <div class="form-item">
                <p>LR</p>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="light_lr_good" name="lights_lr" value="good">
                        <label for="light_lr_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_lr_scratched" name="lights_lr" value="scratched">
                        <label for="light_lr_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_lr_cracked" name="lights_lr" value="cracked">
                        <label for="light_lr_cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_lr_damaged" name="lights_lr" value="damaged">
                        <label for="light_lr_damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_lr_not_working" name="lights_lr" value="not working">
                        <label for="light_lr_not_working">Not Working</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "light_lr_description",
                        label: "",
                        name: "light_lr_description",
                        type: "text",
                        // hasError: $hasLightLRDescriptionError,
                        // error: $hasLightLRDescriptionError ? $errors['light_lr_description'] : "",
                        value: $body['light_lr_description'] ?? null,
                    );
                ?>
            </div>
            <div class="form-item">
                <p>RR</p>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="light_rr_good" name="lights_rr" value="good">
                        <label for="light_rr_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_rr_scratched" name="lights_rr" value="scratched">
                        <label for="light_rr_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_rr_cracked" name="lights_rr" value="cracked">
                        <label for="light_rr_cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_rr_damaged" name="lights_rr" value="damaged">
                        <label for="light_rr_damaged">Damaged</label>
                    </div>
                    <div class="radio-type4">
                        <input type="radio" id="light_rr_not_working" name="lights_rr" value="not working">
                        <label for="light_rr_not_working">Not Working</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "light_rr_description",
                        label: "",
                        name: "light_rr_description",
                        type: "text",
                        // hasError: $hasLightRRDescriptionError,
                        // error: $hasLightRRDescriptionError ? $errors['light_rr_description'] : "",
                        value: $body['light_rr_description'] ?? null,
                    );
                ?>
            </div>


            <p><b><br>Seat</b></p>
            <div class="form-item">
                <p>LF</p>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="seat_lf_good" name="seat_lf" value="good">
                        <label for="seat_lf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="seat_lf_worn" name="seat_lf" value="worn">
                        <label for="seat_lf_worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_lf_burnholes" name="seat_lf" value="burnholes">
                        <label for="seat_lf_burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_lf_torn" name="seat_lf" value="torn">
                        <label for="seat_lf_torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_lf_stained" name="seat_lf" value="stained">
                        <label for="seat_lf_stained">Stained</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "seat_lf_description",
                        label: "",
                        name: "seat_lf_description",
                        type: "text",
                        // hasError: $hasSeatLFDescriptionError,
                        // error: $hasSeatLFDescriptionError ? $errors['seat_lf_description'] : "",
                        value: $body['seat_lf_description'] ?? null,
                    );
                ?>
            </div>
            <div class="form-item">
                <p>RF</p>
                <div class="form-radio">
                <div class="radio-type1">
                        <input type="radio" id="seat_rf_good" name="seat_rf" value="good">
                        <label for="seat_rf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="seat_rf_worn" name="seat_rf" value="worn">
                        <label for="seat_rf_worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_rf_burnholes" name="seat_rf" value="burnholes">
                        <label for="seat_rf_burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_rf_torn" name="seat_rf" value="torn">
                        <label for="seat_rf_torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_rf_stained" name="seat_rf" value="stained">
                        <label for="seat_rf_stained">Stained</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "seat_rf_description",
                        label: "",
                        name: "seat_rf_description",
                        type: "text",
                        // hasError: $hasSeatRFDescriptionError,
                        // error: $hasSeatRFDescriptionError ? $errors['seat_rf_description'] : "",
                        value: $body['seat_rf_description'] ?? null,
                    );
                ?>
            </div>
            <div class="form-item">
                <p>REAR</p>
                <div class="form-radio">
                <div class="radio-type1">
                        <input type="radio" id="seat_rear_good" name="seat_rear" value="good">
                        <label for="seat_rear_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="seat_rear_worn" name="seat_rear" value="worn">
                        <label for="seat_rear_worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_rear_burnholes" name="seat_rear" value="burnholes">
                        <label for="seat_rear_burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_rear_torn" name="seat_rear" value="torn">
                        <label for="seat_rear_torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="seat_rear_stained" name="seat_rear" value="stained">
                        <label for="seat_rear_stained">Stained</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "seat_rear_description",
                        label: "",
                        name: "seat_rear_description",
                        type: "text",
                        // hasError: $hasSeatREARDescriptionError,
                        // error: $hasSeatREARDescriptionError ? $errors['seat_rear_description'] : "",
                        value: $body['seat_rear_description'] ?? null,
                    );
                ?>
            </div>



            <p><b><br>Carpet</b></p>
            <div class="form-item">
                <p>LF</p>
                <div class="form-radio">
                <div class="radio-type1">
                        <input type="radio" id="carpet_lf_good" name="carpet_lf" value="good">
                        <label for="carpet_lf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="carpet_lf_worn" name="carpet_lf_carpet_lf" value="worn">
                        <label for="carpet_lf_worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_lf_burnholes" name="carpet_lf" value="burnholes">
                        <label for="carpet_lf_burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_lf_torn" name="carpet_lf" value="torn">
                        <label for="carpet_lf_torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_lf_stained" name="carpet_lf" value="stained">
                        <label for="carpet_lf_stained">Stained</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_lf_missing" name="carpet_lf" value="missing">
                        <label for="carpet_lf_missing">Missing</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "carpet_lf_description",
                        label: "",
                        name: "carpet_lf_description",
                        type: "text",
                        // hasError: $hasCarpetLFDescriptionError,
                        // error: $hasCarpetLFDescriptionError ? $errors['carpet_lf_description'] : "",
                        value: $body['carpet_lf_description'] ?? null,
                    );
                ?>
            </div>
            <div class="form-item">
                <p>RF</p>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="carpet_rf_good" name="carpet_rf" value="good">
                        <label for="carpet_rf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="carpet_rf_worn" name="carpet_rf" value="worn">
                        <label for="carpet_rf_worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rf_burnholes" name="carpet_rf" value="burnholes">
                        <label for="carpet_rf_burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rf_torn" name="carpet_rf" value="torn">
                        <label for="carpet_rf_torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rf_stained" name="carpet_rf" value="stained">
                        <label for="carpet_rf_stained">Stained</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rf_missing" name="carpet_rf" value="missing">
                        <label for="carpet_rf_missing">Missing</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "carpet_rf_description",
                        label: "",
                        name: "carpet_rf_description",
                        type: "text",
                        // hasError: $hasCarpetRFDescriptionError,
                        // error: $hasCarpetRFDescriptionError ? $errors['carpet_rf_description'] : "",
                        value: $body['carpet_rf_description'] ?? null,
                    );
                ?>
            </div>
            <div class="form-item">
                <p>REAR</p>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="carpet_rear_good" name="carpet_rear" value="good">
                        <label for="carpet_rear_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="carpet_rear_worn" name="carpet_rear" value="worn">
                        <label for="carpet_rear_worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rear_burnholes" name="carpet_rear" value="burnholes">
                        <label for="carpet_rear_burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rear_torn" name="carpet_rear" value="torn">
                        <label for="carpet_rear_torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rear_stained" name="carpet_rear" value="stained">
                        <label for="carpet_rear_stained">Stained</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="carpet_rear_missing" name="carpet_rear" value="missing">
                        <label for="carpet_rear_missing">Missing</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "carpet_rear_description",
                        label: "",
                        name: "carpet_rear_description",
                        type: "text",
                        // hasError: $hasCarpetREARDescriptionError,
                        // error: $hasCarpetREARDescriptionError ? $errors['carpet_rear_description'] : "",
                        value: $body['carpet_rear_description'] ?? null,
                    );
                ?>
            </div>



            <p><b><br>Rim</b></p>
            <div class="form-item">
                <p>LF</p>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="rim_lf_good" name="rim_lf" value="good">
                        <label for="rim_lf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_lf_scratched" name="rim_lf" value="scratched">
                        <label for="rim_lf_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_lf_cracked" name="rim_lf" value="cracked">
                        <label for="rim_lf_cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_lf_dameged" name="rim_lf" value="damaged">
                        <label for="rim_lf_damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_lf_missing" name="rim_lf" value="missing">
                        <label for="rim_lf_missing">Missing</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "rim_lf_description",
                        label: "",
                        name: "rim_lf_description",
                        type: "text",
                        // hasError: $hasRimLFDescriptionError,
                        // error: $hasRimLFDescriptionError ? $errors['rim_lf_description'] : "",
                        value: $body['rim_lf_description'] ?? null,
                    );
                ?>
            </div>
            <div class="form-item">
                <p>RF</p>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="rim_rf_good" name="rim_rf" value="good">
                        <label for="rim_rf_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_rf_scratched" name="rim_rf" value="scratched">
                        <label for="rim_rf_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_rf_cracked" name="rim_rf" value="cracked">
                        <label for="rim_rf_cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_rf_damaged" name="rim_rf" value="damaged">
                        <label for="rim_rf_damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_rf_missing" name="rim_rf" value="missing">
                        <label for="rim_rf_missing">Missing</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "rim_rf_description",
                        label: "",
                        name: "rim_rf_description",
                        type: "text",
                        // hasError: $hasRimRFDescriptionError,
                        // error: $hasRimRFDescriptionError ? $errors['rim_rf_description'] : "",
                        value: $body['rim_rf_description'] ?? null,
                    );
                ?>
            </div>
            <div class="form-item">
                <p>LR</p>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="rim_lr_good" name="rim_lr" value="good">
                        <label for="rim_lr_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_lr_scratched" name="rim_lr" value="scratched">
                        <label for="rim_lr_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_lr_cracked" name="rim_lr" value="cracked">
                        <label for="rim_lr_scratched">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_lr_damaged" name="rim_lr" value="damaged">
                        <label for="rim_lr_damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_lr_missing" name="rim_lr" value="missing">
                        <label for="rim_lr_missing">Missing</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "rim_lr_description",
                        label: "",
                        name: "rim_lr_description",
                        type: "text",
                        // hasError: $hasRimLRDescriptionError,
                        // error: $hasRimLRDescriptionError ? $errors['rim_lr_description'] : "",
                        value: $body['rim_lr_description'] ?? null,
                    );
                ?>
            </div>
            <div class="form-item">
                <p>RR</p>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="rim_rr_good" name="rim_rr" value="good">
                        <label for="rim_rr_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_rr_scratched" name="rim_rr" value="scratched">
                        <label for="rim_rr_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="rim_rr_cracked" name="rim_rr" value="cracked">
                        <label for="rim_rr_cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_rr_damaged" name="rim_rr" value="damaged">
                        <label for="rim_rr_damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="rim_rr_missing" name="rim_rr" value="missing">
                        <label for="rim_rr_missing">Missing</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "rim_rr_description",
                        label: "",
                        name: "rim_rr_description",
                        type: "text",
                        // hasError: $hasRimRRDescriptionError,
                        // error: $hasRimRRDescriptionError ? $errors['rim_rr_description'] : "",
                        value: $body['rim_rr_description'] ?? null,
                    );
                ?>
            </div>

            <div class="form-item">
                <p><b>Current Fuel Level</b></p>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="current_fuel_level_full" name="current_fuel_level" value="full">
                        <label for="current_fuel_level_full">Full</label>
                    </div>
                    <div class="radio-type1">
                        <input type="radio" id="current_fuel_level_empty" name="current_fuel_level" value="empty">
                        <label for="current_fuel_level_empty">Empty</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="current_fuel_level_half" name="current_fuel_level" value="half">
                        <label for="current_fuel_level_half">Half</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="current_fuel_level_3/4" name="current_fuel_level" value="3/4">
                        <label for="current_fuel_level_3/4">3/4</label>
                    </div>
                    <div class="radio-type4">
                        <input type="radio" id="current_fuel_level_1/4" name="current_fuel_level" value="1/4">
                        <label for="current_fuel_level_1/4">1/4</label>
                    </div>
                </div>  
                <?php
                    FormItem::render(
                        id: "current_fuel_level_description",
                        label: "",
                        name: "current_fuel_level_description",
                        type: "text",
                        // hasError: $hasCurrentFuelLevelDescriptionError,
                        // error: $hasCurrentFuelLevelDescriptionError ? $errors['current_fuel_level_description'] : "",
                        value: $body['current_fuel_level_description'] ?? null,
                    );
                ?>
            </div>

        <div class="item-grid">
            <?php
                FormItem::render(
                    id: "milage",
                    label: "<b><br>Milage</b>",
                    name: "milage",
                    type: "number",
                    hasError:$hasMilageError,
                    error:$hasMilageError ? $errors['milage'] : "",
                    value: $body['milage'] ?? null,
                );

                FormItem::render(
                    id: "admiting_time",
                    label: "<b><br>Admitting Time</b>",
                    name: "admiting_time",
                    type: "time",
                    hasError:$hasAdmittingTimeError,
                    error:$hasAdmittingTimeError ? $errors['admiting_time'] : "",
                    value: $body['admiting_time'] ?? null,
                );

                FormItem::render(
                    id: "departing_time",
                    label: "<b><br>Departing Time</b>",
                    name: "departing_time",
                    type: "time",
                    hasError:$hasDepartingTimeError,
                    error:$hasDepartingTimeError ? $errors['departing_time'] : "",
                    value: $body['departing_time'] ?? null,
                );
                
            ?>
        </div>

        <div class="description-grid">
            <?php
                FormTextareaItem::render(
                    id: "customer_belongings",
                    label: "<b>Customer Belongins</b>",
                    name: "customer_belongings",
                    type: "text",
                    hasError:$hasCustomerBelongingsError,
                    error:$hasCustomerBelongingsError ? $errors['customer_belongings'] : "",
                    value: $body['customer_belongings'] ?? null,
                );

                FormTextareaItem::render(
                    id: "additional_note",
                    label: "<b>Additional Note</b>",
                    name: "additional_note",
                    type: "text",
                    hasError:$hasAdditionalNoteError,
                    error:$hasAdditionalNoteError ? $errors['additional_note'] : "",
                    value: $body['additional_note'] ?? null,
                );
            ?>
        </div>

            <div class="form-item">
                <p><b>Dashboard</b></p>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="dashbard_good" name="dashboard" value="good">
                        <label for="dashbard_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="dashbard_scratched" name="dashboard" value="scratched">
                        <label for="dashbard_scratched">Scratched</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="dashbard_damaged" name="dashboard" value="damaged">
                        <label for="dashbard_damaged">Damaged</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="dashbard_cracked" name="dashboard" value="burnt">
                        <label for="dashbard_burnt">Burnt</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="dashbard_stained" name="dashboard" value="stained">
                        <label for="dashbard_stained">Stained</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "dashboard_description",
                        label: "",
                        name: "dashboard_description",
                        type: "text",
                        // hasError: $hasDashboardDescriptionError,
                        // error: $hasDashboardDescriptionError ? $errors['dashboard_description'] : "",
                        value: $body['dashboard_description'] ?? null,
                    );
                ?>
            </div>

            <b>Windshield</b>
            <div class="form-item">
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="windshield_good" name="windshield" value="good">
                        <label for="windshield_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="windshield_scratched" name="windshield" value="scratched">
                        <label for="windshield_scratched">Scratched</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="windshield_cracked" name="windshield" value="cracked">
                        <label for="windshield_cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="windshield_damaged" name="windshield" value="damaged">
                        <label for="windshield_damaged">Damaged</label>
                    </div>
                </div>    
                <?php
                    FormItem::render(
                        id: "windshield_description",
                        label: "",
                        name: "windshield_description",
                        type: "text",
                        // hasError: $hasWindshieldDescriptionError,
                        // error: $hasWindshieldDescriptionError ? $errors['windshield_description'] : "",
                        value: $body['windshield_description'] ?? null,
                    );
                ?>
            </div>

        <br><div class="form-item">
            <div class="form-radio">
                <p><b>Toolkit</b></p>
                <div class="radio-type1">
                    <input type="radio" id="toolkit_have" name="toolkit" value="have">
                    <label for="toolkit_have">Have</label>
                </div>
                <div class="radio-type2">
                    <input type="radio" id="toolkit_missing" name="toolkit" value="missing">
                    <label for="toolkit_missing">Missing</label>
                </div>
            </div>
        </div>


        <br><div class="form-item">
            <div class="form-radio">
            <p><b>Sparewheel</b></p>
                <div class="radio-type1">
                    <input type="radio" id="sparewheel_have" name="sparewheel" value="have">
                    <label for="sparewheel_have">Have</label>
                </div>
                <div class="radio-type2">
                    <input type="radio" id="sparewheel_missing" name="sparewheel" value="missing">
                    <label for="sparewheel_missing">Missing</label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mt-4 mb-8">
            <button type="submit" id="create-button" class="btn">Create</button>
            <button type="reset" id="cancel-button" class="btn btn--danger">Cancel</button>
        </div>
    </form>