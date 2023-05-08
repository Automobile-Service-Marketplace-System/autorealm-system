<?php

use app\components\FormItem;

/**
 * @var array $conditionsOfCategories
 * @var int $jobId
 */


//\app\utils\DevOnly::prettyEcho($conditionsOfCategories);
//exit();

?>


<form class="maintenance-inspection-form mt-8">
    <?php
    foreach ($conditionsOfCategories as $conditionCategory => $conditions) {
        if ($conditionCategory === "category_less") {
            echo "<section class='maintenance-inspection-form__section'>";

        } else {
            echo "<section class='maintenance-inspection-form__section'>
        <h2>$conditionCategory</h2>";
        }
        echo "<div class='maintenance-inspection-form__section-items'>";
        foreach ($conditions as $condition) {
            $condition_name = $condition["condition_name"];
            $condition_remarks = $condition["condition_remarks"];
            $isPassedChecked = $condition["condition_status"] === "passed" ? "checked" : "";
            $isNotPassedChecked = $condition["condition_status"] === "not-passed" ? "checked" : "";

            echo "<div class='maintenance-inspection-form__section-item'>
            <p>$condition_name</p>
            <div class='maintenance-inspection-form__section-condition-check'>
                <div class='form-item--radio'>
                    <input type='radio' name='$conditionCategory-$condition_name-status' value='Passed' id='$conditionCategory-$condition_name-status-passed' $isPassedChecked readonly disabled>
                    <label for='$conditionCategory-$condition_name-status-passed'>Passed</label>
                </div>
                <div class='form-item--radio'>
                    <input type='radio' name='$conditionCategory-$condition_name-status' value='Not passed' id='$conditionCategory-$condition_name-status-not-passed' $isNotPassedChecked readonly disabled>
                    <label for='$conditionCategory-$condition_name-status-not-passed'>Not passed</label>
                </div>
            </div>";
            FormItem::render(
                id: "$conditionCategory-$condition_name-remark",
                label: "Remark",
                name: "$conditionCategory-$condition_name-remark",
                value: $condition_remarks,
                additionalAttributes: "readonly disabled"
            );
            echo "</div>";
        }
        echo "</div></section>";
    }
    ?>
</form>
