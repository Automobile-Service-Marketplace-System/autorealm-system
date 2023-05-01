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

<div class="admitting-report">
    <!-- <a class="appointment-card"> -->
    <?php 
        foreach($admittingReports as $admittingReport){
            if($admittingReport['Name']!=null){
                echo "
                <a class='admitting-report-wrapper' href='/security-officer-dashboard/admitting-reports/view?id={$admittingReport['ID']}' >
                <p class='admitting_card__name'><b>Name: </b>{$admittingReport['Name']}</p>
                <p class='admitting_card__regno'><b>Registration Number: </b>{$admittingReport['RegNo']}</p>
                <p class='admitting_card__date'><b>Date: </b>{$admittingReport['Date']}</p>
                </a>";
            }
            else{
                echo "
                <a class='admitting-report-wrapper' href='/security-officer-dashboard/admitting-reports/view?id={$admittingReport['ID']}' >
                <p class='admitting_card__name''><b>Name: </b><span style='color: gray;'>N/A</span></p>
                <p class='admitting_card__regno'><b>Registration Number: </b> {$admittingReport['RegNo']}</p>
                <p class='admitting_card__date'><b>Date: </b> {$admittingReport['Date']}</p>
                </a>";
            }
            
        }
    ?>
</div>


