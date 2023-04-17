<?php

use app\components\FormItem;

/**
 * @var array $conditions
 * @var array $vehicleDetails
 * @var int $jobId
 */

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
</ul>


<form class="maintenance-inspection-form mt-8" action="/inspection-reports/create?job_id=<?= $jobId ?>" method="post" data-jobid="<?= $jobId ?>">
    <?php
    foreach ($conditions as $condition_section => $condition_names) {
        if ($condition_section === "condition_less") {
            echo "<section class='maintenance-inspection-form__section'>";
            echo "<div class='maintenance-inspection-form__section-items'>";
            foreach ($condition_names as $condition_name) {
                echo "<div class='maintenance-inspection-form__section-item'>
                <p>$condition_name</p>
                <div class='maintenance-inspection-form__section-condition-check'>
                    <div class='form-item--radio'>
                        <input type='radio' name='$condition_section-$condition_name-status' value='Passed' id='$condition_section-$condition_name-status-passed'>
                        <label for='$condition_section-$condition_name-status-passed'>Passed</label>
                    </div>
                    <div class='form-item--radio'>
                        <input type='radio' name='$condition_section-$condition_name-status' value='Passed' id='$condition_section-$condition_name-status-not-passed' checked>
                        <label for='$condition_section-$condition_name-status-not-passed'>Not passed</label>
                    </div>
                </div>";
                FormItem::render(
                    id: "$condition_section-$condition_name-remark",
                    label: "Remark",
                    name: "$condition_section-$condition_name-remark",
                    value: "No remarks"
                );
                echo "</div>";
            }

        } else {
            echo "<section class='maintenance-inspection-form__section'>
        <h2>$condition_section</h2>";
            echo "<div class='maintenance-inspection-form__section-items'>";
            foreach ($condition_names as $condition_name) {
                echo "<div class='maintenance-inspection-form__section-item'>
                <p>$condition_name</p>
                <div class='maintenance-inspection-form__section-condition-check'>
                    <div class='form-item--radio'>
                        <input type='radio' name='$condition_section-$condition_name-status' value='Passed' id='$condition_section-$condition_name-status-passed'>
                        <label for='$condition_section-$condition_name-status-passed'>Passed</label>
                    </div>
                    <div class='form-item--radio'>
                        <input type='radio' name='$condition_section-$condition_name-status' value='Not passed' id='$condition_section-$condition_name-status-not-passed' checked>
                        <label for='$condition_section-$condition_name-status-not-passed'>Not passed</label>
                    </div>
                </div>";
                FormItem::render(
                    id: "$condition_section-$condition_name-remark",
                    label: "Remark",
                    name: "$condition_section-$condition_name-remark",
                    value: "No remarks"
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
    <button id="save-inspection-report-draft" type="button">
        <i class="fa-solid fa-floppy-disk"></i>
    </button>
</form>
