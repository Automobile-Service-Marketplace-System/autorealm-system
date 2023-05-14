 <?php

/**
 * @var array $errors
 * @var array $body
 * @var string $reg_no
 * 
 */

//  var_dump($reg_no)
use app\components\FormItem;
use app\components\FormSelectItem;
use app\components\FormTextareaItem;

$hasErrors = isset($errors) && !empty($errors);
$hasVehicleRegNoError = $hasErrors && isset($errors['vehicle_reg_no']);
$hasMileageError = $hasErrors && isset($errors['mileage"']);
$hasCurrentFuelLevelError = $hasErrors && isset($errors['current_fuel_level']);
$hasCurrentFuelLevelDescriptionError = $hasErrors && isset($errors['current_fuel_level_description']);
$hasAdmittingTimeError = $hasErrors && isset($errors['admitting_time']);
// $hasDepartingTimeError = $hasErrors && isset($errors['departing_time']);
$hasWindshieldError = $hasErrors && isset($errors['windshield']);
$hasWindshieldDescriptionError = $hasErrors && isset($errors['windshield_description']);
$hasLightsLFError = $hasErrors && isset($errors['lights_lf']);
$hasLightLFDescriptionError = $hasErrors && isset($errors['light_lf_description']);
$hasLightsRFError = $hasErrors && isset($errors['lights_rf']);
$hasLightRFDescriptionError = $hasErrors && isset($errors['light_rf_description']);
$hasLightsLRError = $hasErrors && isset($errors['lights_lr']);
$hasLightLRDescriptionError = $hasErrors && isset($errors['light_lr_description']);
$hasLightsRRError = $hasErrors && isset($errors['lights_rr']);
$hasLightRRDescriptionError = $hasErrors && isset($errors['light_rr_description']);
$hasToolkitError = $hasErrors && isset($errors['toolkit']);
$hasSparewheelError = $hasErrors && isset($errors['sparewheele']);
$hasMilageError = $hasErrors && isset($errors['mileage']);
$hasRimLFError = $hasErrors && isset($errors['rim_lf']);
$hasRimLFDescriptionError = $hasErrors && isset($errors['rim_lf_description']);
$hasRimRFError = $hasErrors && isset($errors['rim_rf']);
$hasRimRFDescriptionError = $hasErrors && isset($errors['rim_rf_description']);
$hasRimLRError = $hasErrors && isset($errors['rim_lr']);
$hasRimLRDescriptionError = $hasErrors && isset($errors['rim_lr_description']);
$hasRimRRError = $hasErrors && isset($errors['rim_rr']);
$hasRimRRDescriptionError = $hasErrors && isset($errors['rim_rr_description']);
$hasSeatLFError = $hasErrors && isset($errors['seat_lf']);
$hasSeatLFDescriptionError = $hasErrors && isset($errors['seat_lf_description']);
$hasSeatRFError = $hasErrors && isset($errors['seat_rf']);
$hasSeatRFDescriptionError = $hasErrors && isset($errors['seat_rf_description']);
$hasSeatREARError = $hasErrors && isset($errors['seat_rear']);
$hasSeatREARDescriptionError = $hasErrors && isset($errors['seat_rear_description']);
$hasCarpetLFError = $hasErrors && isset($errors['carpet_lf']);
$hasCarpetLFDescriptionError = $hasErrors && isset($errors['carpet_lf_description']);
$hasCarpetRFError = $hasErrors && isset($errors['carpet_rf']);
$hasCarpetRFDescriptionError = $hasErrors && isset($errors['carpet_rf_description']);
$hasCarpetREARError = $hasErrors && isset($errors['carpet_rear']);
$hasCarpetREARDescriptionError = $hasErrors && isset($errors['carpet_rear_description']);
$hasDashboardError = $hasErrors && isset($errors['dashboard']);
$hasDashboardDescriptionError = $hasErrors && isset($errors['dashboard_description']);
$hasCustomerBelongingsError = $hasErrors && isset($errors['customer_belongings']);
$hasAdditionalNoteError = $hasErrors && isset($errors['additional_note']);

?>

<div class="create-admitting-reports">  
    <form action="/security-officer-dashboard/admitting-reports/add?reg_no=<?= $reg_no ?>" method="post" enctype="multipart/form-data">
        <?php
            FormItem::render(
                id: "vehicle_reg_no",
                label: "<b>Registration Number</b>",
                name: "vehicle_reg_no",
                type: "text",
                hasError: $hasVehicleRegNoError,
                error: $hasVehicleRegNoError ? $errors['vehicle_reg_no'] : "",
                value: $reg_no ?? ($body['vehicle_reg_no'] ?? null),
                additionalAttributes: $reg_no ? "readonly":""
            );
        ?>

        <div class="admitting-report-add-images">
            <p><b>Photos of vehicles: </b></p>
            <input type="file" id="admitting-report-add-images__input" class='mt-4' accept="image/*" name="image[]" multiple required>
            <div class="admitting-report-add-images-container  mt-4">
            </div>
        </div>

        <div class="create-admitting-reports__section">
        <br><p><b>Light</b></p>
            <div class="create-admitting-reports__topic">
                <p>LF</p>
            </div>
                <?php 
                    FormSelectItem::render(
                        id: "light_lf",
                        label: "",
                        name: "lights_lf",
                        hasError: $hasLightsLFError,
                        error: $hasLightsLFError ? $errors['lights_lf'] : "",
                        value: $body['lights_lf'] ?? null,
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
                        type: "text",
                        required: false,
                        placeholder: "Remarks",
                        hasError: $hasLightLFDescriptionError,
                        error: $hasLightLFDescriptionError ? $errors['light_lf_description'] : "",
                        value: $body['light_lf_description'] ?? null,
                    );
                ?>
        </div>

            <p>RF</p>         
                <?php 
                    FormSelectItem::render(
                        id: "light_rf",
                        label: "",
                        name: "lights_rf",
                        hasError: $hasLightsRFError,
                        error: $hasLightsRFError ? $errors['lights_rf'] : "",
                        value: $body['lights_rf'] ?? null,
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
                        type: "text",
                        required: false,
                        placeholder: "Remarks",
                        hasError: $hasLightRFDescriptionError,
                        error: $hasLightRFDescriptionError ? $errors['light_rf_description'] : "",
                        value: $body['light_rf_description'] ?? null,
                    );
                ?>

            <p>LR</p>
                <?php 
                    FormSelectItem::render(
                        id: "light_lr",
                        label: "",
                        name: "lights_lr",
                        hasError: $hasLightsLRError,
                        error: $hasLightsLRError ? $errors['lights_lr'] : "",
                        value: $body['lights_lr'] ?? null,
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
                        type: "text",
                        required: false,
                        placeholder: "Remarks",
                        hasError: $hasLightLRDescriptionError,
                        error: $hasLightLRDescriptionError ? $errors['light_lr_description'] : "",
                        value: $body['light_lr_description'] ?? null,
                    );
                ?>

            <p>RR</p>
                <?php 
                    FormSelectItem::render(
                        id: "light_rr",
                        label: "",
                        name: "lights_rr",
                        hasError: $hasLightsRRError,
                        error: $hasLightsRRError ? $errors['lights_rr'] : "",
                        value: $body['lights_rr'] ?? null,
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
                        required: false,
                        placeholder: "Remarks",
                        hasError: $hasLightRRDescriptionError,
                        error: $hasLightRRDescriptionError ? $errors['light_rr_description'] : "",
                        value: $body['light_rr_description'] ?? null,
                    );
                ?>

        <p><b><br>Seat</b></p>
            <p>LF</p>
                <?php 
                    FormSelectItem::render(
                        id: "seat_lf",
                        label: "",
                        name: "seat_lf",
                        hasError: $hasSeatLFError,
                        error: $hasSeatLFError ? $errors['seat_lf'] : "",
                        value: $body['seat_lf'] ?? null,
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
                        type: "text",
                        required: false,
                        placeholder: "Remarks",
                        hasError: $hasSeatLFDescriptionError,
                        error: $hasSeatLFDescriptionError ? $errors['seat_lf_description'] : "",
                        value: $body['seat_lf_description'] ?? null,
                    );
                ?>

            <p>RF</p>
                <?php
                    FormSelectItem::render(
                        id: "seat_rf",
                        label: "",
                        name: "seat_rf",
                        hasError: $hasSeatRFError,
                        error: $hasSeatRFError ? $errors['seat_rf'] : "",
                        value: $body['seat_rf'] ?? null,
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
                        type: "text",
                        required: false,
                        placeholder: "Remarks",
                        hasError: $hasSeatRFDescriptionError,
                        error: $hasSeatRFDescriptionError ? $errors['seat_rf_description'] : "",
                        value: $body['seat_rf_description'] ?? null,
                    );
                ?>

            <p>REAR</p>
                <?php
                    FormSelectItem::render(
                        id: "seat_rear",
                        label: "",
                        name: "seat_rear",
                        hasError: $hasSeatREARError,
                        error: $hasSeatREARError ? $errors['seat_rear'] : "",
                        value: $body['seat_rear'] ?? null,
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
                        type: "text",
                        required: false,
                        placeholder: "Remarks",
                        hasError: $hasSeatREARDescriptionError,
                        error: $hasSeatREARDescriptionError ? $errors['seat_rear_description'] : "",
                        value: $body['seat_rear_description'] ?? null,
                    );
                ?>

         <p><b><br>Carpet</b></p>
            <p>LF</p>
                <?php
                    FormSelectItem::render(
                        id: "carpet_lf",
                        label: "",
                        name: "carpet_lf",
                        hasError: $hasCarpetLFError,
                        error: $hasCarpetLFError ? $errors['carpet_lf'] : "",
                        value: $body['carpet_lf'] ?? null,
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
                        type: "text",
                        required: false,
                        placeholder: "Remarks",
                        hasError: $hasCarpetLFDescriptionError,
                        error: $hasCarpetLFDescriptionError ? $errors['carpet_lf_description'] : "",
                        value: $body['carpet_lf_description'] ?? null,
                    );
                ?>
            
            <p>RF</p>
                <?php
                    FormSelectItem::render(
                        id: "carpet_rf",
                        label: "",
                        name: "carpet_rf",
                        hasError: $hasCarpetRFError,
                        error: $hasCarpetRFError ? $errors['carpet_rf'] : "",
                        value: $body['carpet_rf'] ?? null,
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
                        type: "text",
                        required: false,
                        placeholder: "Remarks",
                        hasError: $hasCarpetRFDescriptionError,
                        error: $hasCarpetRFDescriptionError ? $errors['carpet_rf_description'] : "",
                        value: $body['carpet_rf_description'] ?? null,
                    );
                ?>

            <p>REAR</p>
                <?php
                    FormSelectItem::render(
                        id: "carpet_rear",
                        label: "",
                        name: "carpet_rear",
                        hasError: $hasCarpetREARError,
                        error: $hasCarpetREARError ? $errors['carpet_rear'] : "",
                        value: $body['carpet_rear'] ?? null,
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
                        type: "text",
                        required: false,
                        placeholder: "Remarks",
                        hasError: $hasCarpetREARDescriptionError,
                        error: $hasCarpetREARDescriptionError ? $errors['carpet_rear_description'] : "",
                        value: $body['carpet_rear_description'] ?? null,
                    );
                ?>
            </div>


        <p><b><br>Rim</b></p>
            <p>LF</p>
                <?php
                    FormSelectItem::render(
                        id: "rim_lf",
                        label: "",
                        name: "rim_lf",
                        hasError: $hasRimLFError,
                        error: $hasRimLFError ? $errors['rim_lf'] : "",
                        value: $body['rim_lf'] ?? null,
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
                        type: "text",
                        required: false,
                        placeholder: "Remarks",
                        hasError: $hasRimLFDescriptionError,
                        error: $hasRimLFDescriptionError ? $errors['rim_lf_description'] : "",
                        value: $body['rim_lf_description'] ?? null,
                    );
                ?>

            <p>RF</p>
                <?php
                    FormSelectItem::render(
                        id: "rim_rf",
                        label: "",
                        name: "rim_rf",
                        hasError: $hasRimRFError,
                        error: $hasRimRFError ? $errors['rim_rf'] : "",
                        value: $body['rim_rf'] ?? null,
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
                        type: "text",
                        required: false,
                        placeholder: "Remarks",
                        hasError: $hasRimRFDescriptionError,
                        error: $hasRimRFDescriptionError ? $errors['rim_rf_description'] : "",
                        value: $body['rim_rf_description'] ?? null,
                    );
                ?>

            <p>LR</p>
                <?php
                    FormSelectItem::render(
                        id: "rim_lr",
                        label: "",
                        name: "rim_lr",
                        hasError: $hasRimLRError,
                        error: $hasRimLRError ? $errors['rim_lr'] : "",
                        value: $body['rim_lr'] ?? null,
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
                        type: "text",
                        required: false,
                        placeholder: "Remarks",
                        hasError: $hasRimLRDescriptionError,
                        error: $hasRimLRDescriptionError ? $errors['rim_lr_description'] : "",
                        value: $body['rim_lr_description'] ?? null,
                    );
                ?>

            <p>RR</p>
                <?php
                    FormSelectItem::render(
                        id: "rim_rr",
                        label: "",
                        name: "rim_rr",
                        hasError: $hasRimRRError,
                        error: $hasRimRRError ? $errors['rim_rr'] : "",
                        value: $body['rim_rr'] ?? null,
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
                        type: "text",
                        required: false,
                        placeholder: "Remarks",
                        hasError: $hasRimRRDescriptionError,
                        error: $hasRimRRDescriptionError ? $errors['rim_rr_description'] : "",
                        value: $body['rim_rr_description'] ?? null,
                    );
                ?>


        <p><b>Current Fuel Level</b></p>
            <?php
                FormSelectItem::render(
                    id: "current_fuel_level",
                    label: "",
                    name: "current_fuel_level",
                    hasError: $hasCurrentFuelLevelError,
                    error: $hasCurrentFuelLevelError ? $errors['current_fuel_level'] : "",
                    value: $body['current_fuel_level'] ?? null,
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
                    type: "text",
                    required: false,
                    placeholder: "Remarks",
                    hasError: $hasCurrentFuelLevelDescriptionError,
                    error: $hasCurrentFuelLevelDescriptionError ? $errors['current_fuel_level_description'] : "",
                    value: $body['current_fuel_level_description'] ?? null,
                );


            FormItem::render(
                id: "mileage",
                label: "Mileage",
                name: "mileage",
                type: "number",
                hasError:$hasMilageError,
                error:$hasMilageError ? $errors['mileage'] : "",
                value: $body['mileage'] ?? null,
            );

            FormItem::render(
                id: "admitting_time",
                label: "<b><br>Admitting Time</b>",
                name: "admitting_time",
                type: "time",
                hasError:$hasAdmittingTimeError,
                error:$hasAdmittingTimeError ? $errors['admitting_time'] : "",
                value: $body['admitting_time'] ?? null,
            );

            FormTextareaItem::render(
                id: "customer_belongings",
                label: "<b>Customer Belongins</b>",
                name: "customer_belongings",
                type: "text",
                required: false,
                hasError:$hasCustomerBelongingsError,
                error:$hasCustomerBelongingsError ? $errors['customer_belongings'] : "",
                value: $body['customer_belongings'] ?? null,
            );

            FormTextareaItem::render(
                id: "additional_note",
                label: "<b>Additional Note</b>",
                name: "additional_note",
                type: "text",
                required: false,
                hasError:$hasAdditionalNoteError,
                error:$hasAdditionalNoteError ? $errors['additional_note'] : "",
                value: $body['additional_note'] ?? null,
            );
        ?>

        <p><b>Dashboard</b></p>
            <?php
                FormSelectItem::render(
                    id: "dashboard",
                    label: "",
                    name: "dashboard",
                    hasError: $hasDashboardError,
                    error: $hasDashboardError ? $errors['dashboard'] : "",
                    value: $body['dashboard'] ?? null,
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
                    type: "text",
                    required: false,
                    placeholder: "Remarks",
                    hasError: $hasDashboardDescriptionError,
                    error: $hasDashboardDescriptionError ? $errors['dashboard_description'] : "",
                    value: $body['dashboard_description'] ?? null,
                );
            ?>

        <b>Windshield</b>
            <?php
                FormSelectItem::render(
                    id: "windshield",
                    label: "",
                    name: "windshield",
                    hasError: $hasWindshieldError,
                    error: $hasWindshieldError ? $errors['windshield'] : "",
                    value: $body['windshield'] ?? null,
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
                    type: "text",
                    required: false,
                    placeholder: "Remarks",
                    hasError: $hasWindshieldDescriptionError,
                    error: $hasWindshieldDescriptionError ? $errors['windshield_description'] : "",
                    value: $body['windshield_description'] ?? null,
                );
            ?>

        <br><div class="form-radio">
            <p><b>Toolkit</b></p>
                <div class="form-item--radio">
                    <input type="radio" id="toolkit_have" name="toolkit" value="have" checked>
                    <label for="toolkit_have">Have</label>
                </div>
                <div class="form-item--radio">
                    <input type="radio" id="toolkit_missing" name="toolkit" value="missing">
                    <label for="toolkit_missing">Missing</label>
                </div>
        </div>

        <br><div class="form-radio">
            <p><b>Sparewheel</b></p>
                <div class="form-item--radio">
                    <input type="radio" id="sparewheel_have" name="sparewheel" value="have" checked>
                    <label for="sparewheel_have">Have</label>
                </div>
                <div class="form-item--radio">
                    <input type="radio" id="sparewheel_missing" name="sparewheel" value="missing">
                    <label for="sparewheel_missing">Missing</label>
                </div>
        </div>
            

        <div class="flex items-center justify-between mt-4 mb-8">
            <!-- <button class="btn btn--danger" onclick=window.location.href="/security-officer-dashboard/view-admitting-reports">Cancel</button> -->
            <button class='btn btn--danger'type="reset" class="btn">Reset</button>
            <button type="submit" class="btn">Create</button>
        </div>
    </form>
</div>