<?php

namespace app\components;

class NewJobCard
{
    public static function render(object $job): void
    {
        echo "
         <div class='job-card job-card--in-progress' id='job-card-{$job->id}'>
            <div class='job-card__header'>
                <div class='job-card__header-info'>
                    <h3 class='job-card__title'>Job #{$job->id}</h3>
                    <h4 class='job-card__subtitle'>Reg No: {$job->regNo}</h4>
                </div>
                <a href='/foreman-dashboard/jobs/view?id={$job->id}' class='btn btn--square'>
                    <i class='fa-solid fa-arrow-right'></i>
                </a>
            </div>
            <div class='job-card__info'>
                <p class='job-card-new-notice'>
                    Add an inspection report and
                    assign technicians to start this job.
                </p>
            </div>
        </div>
        ";
    }
}