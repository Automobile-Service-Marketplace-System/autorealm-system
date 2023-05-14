<?php

/**
 * @var array | null $jobDetails
 * @var array | null $vehicleDetails
 * @var int $jobId
 */

?>

<?php if ($jobId) { ?>
    <?php
    $vehicleRegNo = $vehicleDetails['reg_no'] ?? null;
    $services = $jobDetails['services'] ?? null;
    $all = (int)$jobDetails['service_status']['all'];
    $done = (int)$jobDetails['service_status']['done'];
    $not_done = $all - $done;
    ?>
    <div class="assigned-job-overview" data-jobid="<?= $jobId ?>">
        <div class="assigned-job-overview__header">
            <p><strong>Vehicle</strong>: <?= $vehicleRegNo ?></p>
        </div>
        <div class="assigned-job-progress-container assigned-job-progress-container--loading"
             data-completed="<?= $done ?>" data-notcompleted="<?= $not_done ?>">
            <canvas id="assigned-job-progress"></canvas>
            <i class="fa fa-spinner spin-icon"></i>
        </div>
        <h3 class="mb-4">Mark completed services</h3>
        <div class="flex flex-col w-full gap-4 mb-8">
            <?php
            if ($services) {
                foreach ($services as $service) {
                    $service_name = $service['Name'];
                    $code = $service['Code'];
                    $isCompleted = $service['IsCompleted'] === 1 ? 'checked' : '';
                    echo "
                    <div class='form-item form-item--checkbox'>
                        <input type='checkbox' name='service-$code' id='service-$code' data-servicecode='$code' $isCompleted disabled readonly>
                        <label for='service-$code'>$service_name</label>
                    </div>
                    ";
                }
            }
            ?>
        </div>
    </div>
<?php } else { ?>
    <div class="assigned-job-empty">
        <p>
            None of your vehicles are currently under service in our service center.
            If you are new to our website, go ahead and get an appointment.
        </p>
    </div>
<?php } ?>
