<?php

use app\components\FormItem;

/**
 * @var array $conditionsOfCategories
 * @var array $vehicleDetails
 * @var int $jobId
 */


//\app\utils\DevOnly::prettyEcho($conditionsOfCategories);
//exit();

?>


<ul class="job-vehicle-details">
    <li>
        <strong>Vehicle:</strong>
        <?php echo $vehicleDetails['vehicle_name'] ?>
    </li>
    <li>
        <strong>Reg No:</strong>
        <?php echo $vehicleDetails['reg_no'] ?>
    </li>
    <li>
        <strong>Customer:</strong>
        <?php echo $vehicleDetails['customer_name'] ?>
    </li>
    <button id="save-inspection-report-draft" type="button">
        Save draft
        <i class="fa-solid fa-floppy-disk"></i>
    </button>
</ul>


<form class="maintenance-inspection-form mt-8" action="/inspection-reports/create?job_id=<?= $jobId ?>" method="post"
      data-jobid="<?= $jobId ?>">
    <?php
    foreach ($conditionsOfCategories as $conditionCategory => $conditions) {
        if ($conditionCategory === "category_less") {
            echo "<section class='maintenance-inspection-form__section'>";
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
                        <input type='radio' name='$conditionCategory-$condition_name-status' value='Passed' id='$conditionCategory-$condition_name-status-passed' $isPassedChecked>
                        <label for='$conditionCategory-$condition_name-status-passed'>Passed</label>
                    </div>
                    <div class='form-item--radio'>
                        <input type='radio' name='$conditionCategory-$condition_name-status' value='Not passed' id='$conditionCategory-$condition_name-status-not-passed' $isNotPassedChecked>
                        <label for='$conditionCategory-$condition_name-status-not-passed'>Not passed</label>
                    </div>
                </div>";
                FormItem::render(
                    id: "$conditionCategory-$condition_name-remark",
                    label: "Remark",
                    name: "$conditionCategory-$condition_name-remark",
                    value: $condition_remarks
                );
                echo "</div>";
            }

        } else {
            echo "<section class='maintenance-inspection-form__section'>
        <h2>$conditionCategory</h2>";
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
                        <input type='radio' name='$conditionCategory-$condition_name-status' value='Passed' id='$conditionCategory-$condition_name-status-passed' $isPassedChecked>
                        <label for='$conditionCategory-$condition_name-status-passed'>Passed</label>
                    </div>
                    <div class='form-item--radio'>
                        <input type='radio' name='$conditionCategory-$condition_name-status' value='Not passed' id='$conditionCategory-$condition_name-status-not-passed' $isNotPassedChecked>
                        <label for='$conditionCategory-$condition_name-status-not-passed'>Not passed</label>
                    </div>
                </div>";
                FormItem::render(
                    id: "$conditionCategory-$condition_name-remark",
                    label: "Remark",
                    name: "$conditionCategory-$condition_name-remark",
                    value: $condition_remarks
                );
                echo "</div>";
            }
        }
        echo "</div></section>";
    }
    ?>
    <div class="flex items-center justify-end mb-8">
        <button class="btn btn--primary" type="submit">Submit</button>
    </div>
</form>
