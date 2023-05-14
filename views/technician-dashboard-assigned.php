<?php

/**
 * @var array | null $jobDetails
 * @var array | null $vehicleDetails
 * @var int $jobId
 */


//$jobDetails = null;


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
                        <input type='checkbox' name='service-$code' id='service-$code' data-servicecode='$code' class='service-checkbox' $isCompleted>
                        <label for='service-$code'>$service_name</label>
                    </div>
                    ";
                }
            }
            ?>
        </div>
        <button class="btn btn--block">
            <a href="/all-jobs/view?jobId=<?= $jobId ?>">
                View Job Details
            </a>
        </button>
    </div>
<?php } else { ?>
    <div class="assigned-job-empty">
        <p>
            You're not currently assigned to work on any job.
            Come back later.
        </p>
    </div>
<?php } ?>
