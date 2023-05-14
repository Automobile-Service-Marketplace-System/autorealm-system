<?php

namespace app\components;

class InProgressJobCard
{
    public static function render(array $job): void
    {
        echo "
         <div class='job-card job-card--in-progress' id='job-card-{$job['id']}'>
            <div class='job-card__header'>
                <div class='job-card__header-info'>
                    <h3 class='job-card__title'>Job #{$job['id']}</h3>
                    <h4 class='job-card__subtitle'>Reg No: {$job['regNo']}</h4>
                </div>
                <a href='/jobs/in-progress/view?id={$job['id']}' class='btn btn--square'>
                    <i class='fa-solid fa-arrow-right'></i>
                </a>
            </div>
            <div class='job-card__info'>
                <div class='job-card__stats'>
                    <div class='job-card__stat'>
                        <h4>Services</h4>
                        <p>{$job['serviceCount']}</p>
                    </div>
                    <div class='job-card__stat'>
                        <h4>Products</h4>
                        <p>{$job['productCount']}</p>
                    </div>
                    <div class='job-card__stat'>
                        <h4>Technicians</h4>
                        <p>{$job['technicianCount']}</p>
                    </div>
                    <div class='job-card__stat job-card__stat--progress' data-done='{$job['done']}' data-all='{$job['all']}'>
                        <canvas id='progress-{$job['id']}'></canvas>
                    </div>
                </div>
            </div>
        </div>
        ";
    }
}