<?php

use app\components\FormItem;

?>


<ul class="job-vehicle-details">
    <li>
        <strong>Vehicle:</strong>
        Toyota GR Supra A91 CF Edition
    </li>
    <li>
        <strong>Reg No:</strong>
        QL 9904
    </li>
</ul>


<form class="maintenance-inspection-form">
    <section class="maintenance-inspection-form__section">
        <h2>Section Title</h2>
        <div class="maintenance-inspection-form__section-items">
            <div class="maintenance-inspection-form__section-item">
                <p>Section condition</p>
                <div class="maintenance-inspection-form__section-condition-check">
                    <div class="form-item--radio">
                        <input type="radio" name="section1" value="Passed">
                        <label for=""></label>
                    </div>
                </div>
                
                <input type="radio" name="section1" value="Not passed">
            </div>
            <div class="maintenance-inspection-form__section-item">

            </div>
            <div class="maintenance-inspection-form__section-item">

            </div>
            <div class="maintenance-inspection-form__section-item">

            </div>
        </div>
    </section>
</form>
