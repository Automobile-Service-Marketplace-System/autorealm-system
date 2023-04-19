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
$hasAdmittingTimeError = $hasErrors && isset($errors['admiting_time']);
$hasDepartingTimeError = $hasErrors && isset($errors['departing_time']);
$hasWindshieldError = $hasErrors && isset($errors['windshield']);
// $hasLightsLFError = $hasErrors && isset($errors['lights_lf']);
// $hasLightsRFError = $hasErrors && isset($errors['lights_rf']);
// $hasLightsRRError = $hasErrors && isset($errors['lights_rr']);
// $hasToolkitError = $hasErrors && isset($errors['toolkit']);
// $hasSparewheelError = $hasErrors && isset($errors['sparewheele']);
// $hasRimLFError = $hasErrors && isset($errors['rim_lf']);
// $hasRimRFError = $hasErrors && isset($errors['rim_rf']);
// $hasRimLRError = $hasErrors && isset($errors['']);
// $hasSeatLFError = $hasErrors && isset($errors['seat_lf']);
// $hasSeatRFError = $hasErrors && isset($errors['seat_rf']);
// $hasSeatREARError = $hasErrors && isset($errors['seat_rear']);
// $hasCarpetLFError = $hasErrors && isset($errors['carpet_lf']);
// $hasCarpetRFError = $hasErrors && isset($errors['carpet_rf']);
// $hasCarpetREARError = $hasErrors && isset($errors['carpet_rear']);
$hasDashboardError = $hasErrors && isset($errors['dashboard']);
$hasCustomerBelongingsError = $hasErrors && isset($errors['customer_belongings']);
$hasAdditionalNoteError = $hasErrors && isset($errors['additional_note']);

?>

    <form action="/security-officer-dashboard/admitting-reports/add" method="post" enctype="multipart/form-data">
        <div class="form-input">
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
        </div>

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
                <label for="LF">LF</label>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="light_good" name="lights_lf" value="good">
                        <label for="light_good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_scratched" name="lights_lf" value="scratched">
                        <label for="light_scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_cracked" name="lights_lf" value="cracked">
                        <label for="light_scratched">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="light_damaged" name="lights_lf" value="damaged">
                        <label for="damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="not_working" name="lights_lf" value="not working">
                        <label for="not_working">Not Working</label>
                    </div>
                </div>    
                <!-- <input type="text" id="LF" name="description_lights_lf"> -->
            </div>
            <div class="form-item">
                <label for="RF">RF</label>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="good" name="lights_rf" value="good">
                        <label for="good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="scratched" name="lights_rf" value="scratched">
                        <label for="scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="light_cracked" name="lights_rf" value="cracked">
                        <label for="cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="damaged" name="lights_rf" value="damaged">
                        <label for="damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="not_working" name="lights_rf" value="not working">
                        <label for="not_working">Not Working</label>
                    </div>
                </div>    
                <!-- <input type="text" id="RF" name="descriptiom_lights_rf"> -->
            </div>
            <div class="form-item">
                <label for="LR">LR</label>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="good" name="lights_lr" value="good">
                        <label for="good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="scratched" name="lights_lr" value="scratched">
                        <label for="scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="cracked" name="lights_lr" value="cracked">
                        <label for="cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="damaged" name="lights_lr" value="damaged">
                        <label for="damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="not_working" name="lights_lr" value="not working">
                        <label for="not_working">Not Working</label>
                    </div>
                </div>    
                <!-- <input type="text" id="LR" name="descriptiom_lights_lr"> -->
            </div>
            <div class="form-item">
                <label for="RR">RR</label>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="good" name="lights_rr" value="good">
                        <label for="good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="scratched" name="lights_rr" value="scratched">
                        <label for="scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="cracked" name="lights_rr" value="cracked">
                        <label for="cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="damaged" name="lights_rr" value="damaged">
                        <label for="damaged">Damaged</label>
                    </div>
                    <div class="radio-type4">
                        <input type="radio" id="not_working" name="lights_rr" value="not working">
                        <label for="not_working">Not Working</label>
                    </div>
                </div>    
                <!-- <input type="text" id="RR" name="descriptiom_lights_rr"> -->
            </div>
        


            <p><b><br>Seat</b></p>
            <div class="form-item">
                <label for="LF">LF</label>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="good" name="seat_lf" value="good">
                        <label for="good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="worn" name="seat_lf" value="worn">
                        <label for="worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="burnholes" name="seat_lf" value="burnholes">
                        <label for="burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="torn" name="seat_lf" value="torn">
                        <label for="torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="stained" name="seat_lf" value="stained">
                        <label for="stained">Stained</label>
                    </div>
                </div>    
                <!-- <input type="text" id="LF" name="descriptiom_seat_lf"> -->
            </div>
            <div class="form-item">
                <label for="RF">RF</label>
                <div class="form-radio">
                <div class="radio-type1">
                        <input type="radio" id="good" name="seat_rf" value="good">
                        <label for="good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="worn" name="seat_rf" value="worn">
                        <label for="worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="burnholes" name="seat_rf" value="burnholes">
                        <label for="burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="torn" name="seat_rf" value="torn">
                        <label for="torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="stained" name="seat_rf" value="stained">
                        <label for="stained">Stained</label>
                    </div>
                </div>    
                <!-- <input type="text" id="RF" name="descriptiom_seat_rf"> -->
            </div>
            <div class="form-item">
                <label for="REAR">REAR</label>
                <div class="form-radio">
                <div class="radio-type1">
                        <input type="radio" id="good" name="seat_rear" value="good">
                        <label for="good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="worn" name="seat_rear" value="worn">
                        <label for="worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="burnholes" name="seat_rear" value="burnholes">
                        <label for="burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="torn" name="seat_rear" value="torn">
                        <label for="torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="stained" name="seat_rear" value="stained">
                        <label for="stained">Stained</label>
                    </div>
                </div>    
                <!-- <input type="text" id="REAR" name="descriptiom_seat_rear"> -->
            </div>



            <p><b><br>Carpet</b></p>
            <div class="form-item">
                <label for="LF">LF</label>
                <div class="form-radio">
                <div class="radio-type1">
                        <input type="radio" id="good" name="carpet_lf" value="good">
                        <label for="good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="worn" name="carpet_lf" value="worn">
                        <label for="worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="burnholes" name="carpet_lf" value="burnholes">
                        <label for="burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="torn" name="carpet_lf" value="torn">
                        <label for="torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="stained" name="carpet_lf" value="stained">
                        <label for="stained">Stained</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="missing" name="carpet_lf" value="missing">
                        <label for="missing">Missing</label>
                    </div>
                </div>    
                <!-- <input type="text" id="LF" name="descriptiom_carpet_lf"> -->
            </div>
            <div class="form-item">
                <label for="RF">RF</label>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="good" name="carpet_rf" value="good">
                        <label for="good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="worn" name="carpet_rf" value="worn">
                        <label for="worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="burnholes" name="carpet_rf" value="burnholes">
                        <label for="burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="torn" name="carpet_rf" value="torn">
                        <label for="torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="stained" name="carpet_rf" value="stained">
                        <label for="stained">Stained</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="missing" name="carpet_rf" value="missing">
                        <label for="missing">Missing</label>
                    </div>
                </div>    
                <!-- <input type="text" id="RF" name="descriptiom_carpet_rf"> -->
            </div>
            <div class="form-item">
                <label for="REAR">REAR</label>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="good" name="carpet_rear" value="good">
                        <label for="good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="worn" name="carpet_rear" value="worn">
                        <label for="worn">Worn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="burnholes" name="carpet_rear" value="burnholes">
                        <label for="burnholes">Burnholes</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="torn" name="carpet_rear" value="torn">
                        <label for="torn">Torn</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="stained" name="carpet_rear" value="stained">
                        <label for="stained">Stained</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="missing" name="carpet_rear" value="missing">
                        <label for="missing">Missing</label>
                    </div>
                </div>    
                <!-- <input type="text" id="REAR" name="descriptiom_carpet_rear"> -->
            </div>



            <p><b><br>Rim</b></p>
            <div class="form-item">
                <label for="LF">LF</label>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="good" name="rim_lf" value="good">
                        <label for="good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="scratched" name="rim_lf" value="scratched">
                        <label for="scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="cracked" name="rim_lf" value="cracked">
                        <label for="cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="dameged" name="rim_lf" value="damaged">
                        <label for="damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="missing" name="rim_lf" value="missing">
                        <label for="missing">Missing</label>
                    </div>
                </div>    
                <!-- /<input type="text" id="LF" name="descriptiom_rim_lf"> -->
            </div>
            <div class="form-item">
                <label for="RF">RF</label>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="good" name="rim_rf" value="good">
                        <label for="good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="scratched" name="rim_rf" value="scratched">
                        <label for="scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="cracked" name="rim_rf" value="cracked">
                        <label for="cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="damaged" name="rim_rf" value="damaged">
                        <label for="damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="missing" name="rim_rf" value="missing">
                        <label for="missing">Missing</label>
                    </div>
                </div>    
                <!-- <input type="text" id="RF" name="descriptiom_rim_rf"> -->
            </div>
            <div class="form-item">
                <label for="LR">LR</label>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="good" name="rim_lr" value="good">
                        <label for="good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="scratched" name="rim_lr" value="scratched">
                        <label for="scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="cracked" name="rim_lr" value="cracked">
                        <label for="light_scratched">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="damaged" name="rim_lr" value="damaged">
                        <label for="damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="missing" name="rim_lr" value="missing">
                        <label for="missing">Missing</label>
                    </div>
                </div>    
                <!-- <input type="text" id="LR" name="descriptiom_rim_lr"> -->
            </div>
            <div class="form-item">
                <label for="RR">RR</label>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="good" name="rim_rr" value="good">
                        <label for="good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="scratched" name="rim_rr" value="scratched">
                        <label for="scratched">Scratched</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="cracked" name="rim_rr" value="cracked">
                        <label for="cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="damaged" name="rim_rr" value="damaged">
                        <label for="damaged">Damaged</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="missing" name="rim_rr" value="missing">
                        <label for="missing">Missing</label>
                    </div>
                </div>    
                <!-- <input type="text" id="RR" name="descriptiom_rim_rr"> -->
            </div>

            <div class="form-item">
            <label for="current_fuel_level"><b><br>Current Fuel Capacity</b></label>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="full" name="current_fuel_level" value="full">
                        <label for="full">Full</label>
                    </div>
                    <div class="radio-type1">
                        <input type="radio" id="empty" name="current_fuel_level" value="empty">
                        <label for="empty">Empty</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="half" name="current_fuel_level" value="half">
                        <label for="half">Half</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="three_quarters" name="current_fuel_level" value="3/4">
                        <label for="3/4">3/4</label>
                    </div>
                    <div class="radio-type4">
                        <input type="radio" id="quarters" name="current_fuel_level" value="1/4">
                        <label for="1/4">1/4</label>
                    </div>
                </div>  
                <!-- <input type="text" id="current_fuel_level" name="description_current_fuel_level">   -->
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

        <div class="form-input">
            <?php
                FormItem::render(
                    id: "dashboard",
                    label: "<b><br>Dashboard</b>",
                    name: "dashboard",
                    type: "text",
                    hasError:$hasDashboardError,
                    error:$hasDashboardError ? $errors['dashboard'] : "",
                    value: $body['dashboard'] ?? null,
                );

                // FormItem::render(
                //     id: "validate",
                //     label: "<b><br>Validate By</b>",
                //     name: "validated_by",
                //     type: "text",
                // );
            ?>
        </div>

        <!-- <br><p><b>Windshield</b></p> -->
            <div class="form-item">
                <label for="windshield"><b><br>Windshield</b></label>
                <div class="form-radio">
                    <div class="radio-type1">
                        <input type="radio" id="good" name="windshield" value="good">
                        <label for="good">Good</label>
                    </div>
                    <div class="radio-type2">
                        <input type="radio" id="scratched" name="windshield" value="scratched">
                        <label for="scratched">Scratched</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="cracked" name="windshield" value="cracked">
                        <label for="cracked">Cracked</label>
                    </div>
                    <div class="radio-type3">
                        <input type="radio" id="damaged" name="windshield" value="damaged">
                        <label for="damaged">Damaged</label>
                    </div>
                </div>    
                <!-- <input type="text" id="windshield" name="windshield"> -->
            </div>

        <!-- <div class="form-item form-item--checkbox">
            <br><br><label for="spare_wheel"><b>Spare Wheel</b></label>
            <input type="checkbox" name="spare_wheel" id="spare_wheel" value="spare_wheel">
        </div>   -->


        <br><div class="form-item">
            <div class="form-radio">
                <p><b>Toolkit</b></p>
                <div class="radio-type1">
                    <input type="radio" id="having" name="toolkit" value="have">
                    <label for="have">Have</label>
                </div>
                <div class="radio-type2">
                    <input type="radio" id="missing" name="toolkit" value="missing">
                    <label for="missing">Missing</label>
                </div>
            </div>
        </div>


        <br><div class="form-item">
            <div class="form-radio">
            <p><b>Sparewheel</b></p>
                <div class="radio-type1">
                    <input type="radio" id="having" name="sparewheel" value="have">
                    <label for="have">Have</label>
                </div>
                <div class="radio-type2">
                    <input type="radio" id="missing" name="sparewheel" value="missing">
                    <label for="missing">Missing</label>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between mt-4 mb-8">
            <button type="submit" id="create-button" class="btn">Create</button>
            <button type="reset" id="cancel-button" class="btn btn--danger">Cancel</button>
        </div>
    </form>