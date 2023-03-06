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
                <input type="radio" id="good" name="type1" value="good">
                <label for="good">Good</label>
            </div>
            <div class="radio-type2">
                <input type="radio" id="scratched" name="type1" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type1" value="dameged">
                <label for="dameged">Dameged</label>
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
                <input type="radio" id="scratched" name="type5" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type5" value="dameged">
                <label for="dameged">Dameged</label>
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
                <input type="radio" id="scratched" name="type6" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type6" value="dameged">
                <label for="dameged">Dameged</label>
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
                <input type="radio" id="scratched" name="type7" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type7" value="dameged">
                <label for="dameged">Dameged</label>
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
                <input type="radio" id="scratched" name="type8" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type8" value="dameged">
                <label for="dameged">Dameged</label>
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
                <input type="radio" id="scratched" name="type9" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type9" value="dameged">
                <label for="dameged">Dameged</label>
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
                <input type="radio" id="scratched" name="type10" value="scratched">
                <label for="scratched">Scratched</label>
            </div>
            <div class="radio-type3">
                <input type="radio" id="dameged" name="type10" value="dameged">
                <label for="dameged">Dameged</label>
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
        </div>    
        <input type="RR" id="RR" name="RR">
    </div>
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