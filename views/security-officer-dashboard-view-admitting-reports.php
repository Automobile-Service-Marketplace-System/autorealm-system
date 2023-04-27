<?php
/**
 * @var array $admittingReports
 */
?>

<div class="flex items-center justify-end mb-4">
    <a class="btn" href="/security-officer-dashboard/admitting-reports/add">
        Create
        <i class="fa-solid fa-plus"></i>
    </a>
</div>

<!-- <div class="appointment-card-wrapper"> -->
    <!-- <a class="appointment-card"> -->
    <?php 
        foreach($admittingReports as $admittingReport){
            
            echo "
            <a class='appointment-card' href='/security-officer-dashboard/admitting-reports/view?id={$admittingReport['ID']}' >
            <p class='appointment-card__name'>{$admittingReport['Name']}</p>
            <p class='appointment-card__date'>{$admittingReport['RegNo']}</p>
            <p class='appointment-card__date'>{$admittingReport['Date']}</p>
            </a>";
        }
    ?>
</div>


