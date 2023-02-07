<?php

namespace app\components;

class CompletedJobCard
{
    public static function render(array $job): void
    {
        $collapsedTimeInMinutes = $job['time_collapsed'];
        $hours = floor($collapsedTimeInMinutes / 60);
        $minutes = $collapsedTimeInMinutes % 60;
        echo "
         <div class='job-card job-card--in-progress' id='job-card-{$job['id']}'>
            <div class='job-card__header'>
                <div class='job-card__header-info'>
                    <h3 class='job-card__title'>Job #{$job['id']}</h3>
                    <h4 class='job-card__subtitle'>Reg No: {$job['regNo']}</h4>
                </div>
                <a href='/jobs/view?id={$job['id']}' class='btn btn--square'>
                    <i class='fa-solid fa-arrow-right'></i>
                </a>
            </div>
            <div class='job-card__info'>
                <p class='job-card-new-notice'>
                    Took $hours hr $minutes minutes to complete.
                </p>
            </div>
        </div>
        ";
    }
}