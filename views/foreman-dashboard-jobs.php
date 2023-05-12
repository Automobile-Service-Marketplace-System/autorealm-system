<?php
/**
 * @var  array $jobs
 */

use app\components\CompletedJobCard;
use app\components\InProgressJobCard;
use app\components\NewJobCard;

?>

<main class="jobs-grid">
    <section class="jobs-col">
        <h2 class="jobs-col__heading">
            <span class="job-status-indicator job-status-indicator--todo">

            </span>
            New Jobs
            <span><?php echo count($jobs['new']) ?></span>
        </h2>
        <div class="jobs-col__container">
            <?php
            foreach ($jobs['new'] as $job) {
                NewJobCard::render($job);
            }
            ?>
        </div>

    </section>
    <section class="jobs-col">
        <h2 class="jobs-col__heading">
            <span class="job-status-indicator job-status-indicator--in-progress">

            </span>
            In Progress
            <span><?php echo count($jobs['in-progress']) ?></span>
        </h2>
        <div class="jobs-col__container">
            <?php
            foreach ($jobs['in-progress'] as $job) {
                InProgressJobCard::render($job);
            }
            ?>
        </div>
    </section>
    <section class="jobs-col">
        <h2 class="jobs-col__heading">
            <span class="job-status-indicator job-status-indicator--completed">

            </span>
            Completed
            <span><?php echo count($jobs['completed']) ?></span>
        </h2>
        <?php
        foreach ($jobs['completed'] as $job) {
            CompletedJobCard::render($job);
        }
        ?>
    </section>
</main>