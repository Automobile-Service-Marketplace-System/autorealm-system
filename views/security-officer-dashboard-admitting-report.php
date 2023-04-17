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
                <input type="radio" id="light_good" name="type1" value="light_good">
                <label for="light_good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="light_scratched" name="type1" value="light_scratched">
                <label for="light_scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type1" value="dameged">
                <label for="dameged">Dameged</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="not_working" name="type1" value="not_working">
                <label for="not_working">Not Working</label>
            </div>
        </div>    
        <input type="LF" id="LF" name="LF">
    </div>
    <div class="form-item">
        <label for="RF">RF</label>
        <div class="form-radio">
            <div class="radio-type1">
                <input type="radio" id="good" name="type2" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="scratched" name="type2" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type2" value="dameged">
                <label for="dameged">Dameged</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="not_working" name="type2" value="not_working">
                <label for="not_working">Not Working</label>
            </div>
        </div>    
        <input type="RF" id="RF" name="RF">
    </div>
    <div class="form-item">
        <label for="LR">LR</label>
        <div class="form-radio">
            <div class="radio-type1">
                <input type="radio" id="good" name="type3" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="scratched" name="type3" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type3" value="dameged">
                <label for="dameged">Dameged</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="not_working" name="type3" value="not_working">
                <label for="not_working">Not Working</label>
            </div>
        </div>    
        <input type="LR" id="LR" name="LR">
    </div>
    <div class="form-item">
        <label for="RR">RR</label>
        <div class="form-radio">
            <div class="radio-type1">
                <input type="radio" id="good" name="type4" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="scratched" name="type4" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type4" value="dameged">
                <label for="dameged">Dameged</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="not_working" name="type4" value="not_working">
                <label for="not_working">Not Working</label>
            </div>
        </div>    
        <input type="RR" id="RR" name="RR">
    </div>
 


    <p><b><br>Seat</b></p>
    <div class="form-item">
        <label for="LF">LF</label>
        <div class="form-radio">
            <div class="radio-type1">
                <input type="radio" id="good" name="type5" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="worn" name="type5" value="worn">
                <label for="worn">Worn</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="burnholes" name="type5" value="burnholes">
                <label for="burnholes">Burnholes</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="torn" name="type5" value="torn">
                <label for="torn">Torn</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="stained" name="type5" value="stained">
                <label for="stained">Stained</label>
            </div>
        </div>    
        <input type="LF" id="LF" name="LF">
    </div>
    <div class="form-item">
        <label for="RF">RF</label>
        <div class="form-radio">
        <div class="radio-type1">
                <input type="radio" id="good" name="type6" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="worn" name="type6" value="worn">
                <label for="worn">Worn</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="burnholes" name="type6" value="burnholes">
                <label for="burnholes">Burnholes</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="torn" name="type6" value="torn">
                <label for="torn">Torn</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="stained" name="type6" value="stained">
                <label for="stained">Stained</label>
            </div>
        </div>    
        <input type="RF" id="RF" name="RF">
    </div>
    <div class="form-item">
        <label for="REAR">REAR</label>
        <div class="form-radio">
           <div class="radio-type1">
                <input type="radio" id="good" name="type7" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="worn" name="type7" value="worn">
                <label for="worn">Worn</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="burnholes" name="type7" value="burnholes">
                <label for="burnholes">Burnholes</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="torn" name="type7" value="torn">
                <label for="torn">Torn</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="stained" name="type7" value="stained">
                <label for="stained">Stained</label>
            </div>
        </div>    
        <input type="REAR" id="REAR" name="REAR">
    </div>



    <p><b><br>Carpet</b></p>
    <div class="form-item">
        <label for="LF">LF</label>
        <div class="form-radio">
           <div class="radio-type1">
                <input type="radio" id="good" name="type8" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="worn" name="type8" value="worn">
                <label for="worn">Worn</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="burnholes" name="type8" value="burnholes">
                <label for="burnholes">Burnholes</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="torn" name="type8" value="torn">
                <label for="torn">Torn</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="stained" name="type8" value="stained">
                <label for="stained">Stained</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="missing" name="type8" value="missing">
                <label for="missing">Missing</label>
            </div>
        </div>    
        <input type="LF" id="LF" name="LF">
    </div>
    <div class="form-item">
        <label for="RF">RF</label>
        <div class="form-radio">
            <div class="radio-type1">
                <input type="radio" id="good" name="type9" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="worn" name="type9" value="worn">
                <label for="worn">Worn</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="burnholes" name="type9" value="burnholes">
                <label for="burnholes">Burnholes</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="torn" name="type9" value="torn">
                <label for="torn">Torn</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="stained" name="type9" value="stained">
                <label for="stained">Stained</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="missing" name="type9" value="missing">
                <label for="missing">Missing</label>
            </div>
        </div>    
        <input type="RF" id="RF" name="RF">
    </div>
    <div class="form-item">
        <label for="REAR">REAR</label>
        <div class="form-radio">
            <div class="radio-type1">
                <input type="radio" id="good" name="type10" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="worn" name="type10" value="worn">
                <label for="worn">Worn</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="burnholes" name="type10" value="burnholes">
                <label for="burnholes">Burnholes</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="torn" name="type10" value="torn">
                <label for="torn">Torn</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="stained" name="type10" value="stained">
                <label for="stained">Stained</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="missing" name="type10" value="missing">
                <label for="missing">Missing</label>
            </div>
        </div>    
        <input type="REAR" id="REAR" name="REAR">
    </div>



    <p><b><br>Rim</b></p>
    <div class="form-item">
        <label for="LF">LF</label>
        <div class="form-radio">
            <div class="radio-type1">
                <input type="radio" id="good" name="type11" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="scratched" name="type11" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type11" value="dameged">
                <label for="dameged">Dameged</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="missing" name="type11" value="missing">
                <label for="missing">Missing</label>
            </div>
        </div>    
        <input type="LF" id="LF" name="LF">
    </div>
    <div class="form-item">
        <label for="RF">RF</label>
        <div class="form-radio">
            <div class="radio-type1">
                <input type="radio" id="good" name="type12" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="scratched" name="type12" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type12" value="dameged">
                <label for="dameged">Dameged</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="missing" name="type12" value="missing">
                <label for="missing">Missing</label>
            </div>
        </div>    
        <input type="RF" id="RF" name="RF">
    </div>
    <div class="form-item">
        <label for="LR">LR</label>
        <div class="form-radio">
            <div class="radio-type1">
                <input type="radio" id="good" name="type13" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="scratched" name="type13" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type13" value="dameged">
                <label for="dameged">Dameged</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="missing" name="type13" value="missing">
                <label for="missing">Missing</label>
            </div>
        </div>    
        <input type="LR" id="LR" name="LR">
    </div>
    <div class="form-item">
        <label for="RR">RR</label>
        <div class="form-radio">
            <div class="radio-type1">
                <input type="radio" id="good" name="type14" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="scratched" name="type14" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type14" value="dameged">
                <label for="dameged">Dameged</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="missing" name="type14" value="missing">
                <label for="missing">Missing</label>
            </div>
        </div>    
        <input type="RR" id="RR" name="RR">
    </div>

    <div class="form-item">
    <label for="current_fuel_capacity"><b><br>Current Fuel Capacity</b></label>
        <div class="form-radio">
            <div class="radio-type1">
                <input type="radio" id="full" name="type15" value="full">
                <label for="full">Full</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="half" name="type15" value="half">
                <label for="half">Half</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="three_quarters" name="type15" value="three_quarters">
                <label for="three_quarters">3/4</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="quarters" name="type15" value="quarters">
                <label for="quarters">1/4</label>
            </div>
        </div>  
        <input type="current_fuel_capacity" id="current_fuel_capacity" name="current_fuel_capacity">  
    </div>
</div>

<div class="item-grid">
    <?php
        FormItem::render(
            id: "milage",
            label: "<b><br>Milage</b>",
            name: "milage",
            type: "number",
        );

        FormItem::render(
            id: "admitting_time",
            label: "<b><br>Admitting Time</b>",
            name: "admitting_time",
            type: "time",
        );

        FormItem::render(
            id: "departing_time",
            label: "<b><br>Departing Time</b>",
            name: "departing_time",
            type: "time",
        );
        
    ?>
</div>

<div class="description-grid">
    <?php
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
</div>

<div class="form-input">
    <?php
        FormItem::render(
            id: "dashboard",
            label: "<b><br>Dashboard</b>",
            name: "dashboard",
        );

        FormItem::render(
            id: "validate",
            label: "<b><br>Validate By</b>",
            name: "validate",
            type: "text",
        );
    ?>
</div>

<!-- <br><p><b>Windshield</b></p> -->
    <div class="form-item">
        <label for="windshield"><b><br>Windshield</b></label>
        <div class="form-radio">
            <div class="radio-type1">
                <input type="radio" id="good" name="type16" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="scratched" name="type16" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="cracked" name="type16" value="cracked">
                <label for="cracked">Cracked</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type16" value="dameged">
                <label for="dameged">Dameged</label>
            </div>
        </div>    
        <input type="windshield" id="windshield" name="windshield">
    </div>

<!-- <div class="form-item form-item--checkbox">
    <br><br><label for="spare_wheel"><b>Spare Wheel</b></label>
    <input type="checkbox" name="spare_wheel" id="spare_wheel" value="spare_wheel">
</div>   -->


<br><div class="form-item">
    <div class="form-radio">
        <p><b>Toolkit</b></p>
        <div class="radio-type1">
            <input type="radio" id="having" name="type17" value="having">
            <label for="having">Having</label>
        </div>
        <div class="radio-type2">
            <input type="radio" id="missing" name="type17" value="missing">
            <label for="missing">Missing</label>
        </div>
    </div>
</div>


<br><div class="form-item">
    <div class="form-radio">
    <p><b>Sparewheel</b></p>
        <div class="radio-type1">
            <input type="radio" id="having" name="type18" value="having">
            <label for="having">Having</label>
        </div>
        <div class="radio-type2">
            <input type="radio" id="missing" name="type18" value="missing">
            <label for="missing">Missing</label>
        </div>
    </div>
</div>

<div class="flex items-center justify-between mt-4 mb-8">
    <button type="submit" id="create-button" class="btn">Create</button>
    <button type="submit" id="cancel-button" class="btn btn--danger">Cancel</button>
</div>