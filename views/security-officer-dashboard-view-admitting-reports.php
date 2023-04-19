<!-- <div class="flex items-center justify-end mb-4">
    <a class="btn" href="/security-officer-dashboard/admitting-reports/add">
        Create
        <i class="fa-solid fa-plus"></i>
    </a>
</div>
<section class="appointment-card-wrapper">
    <a class="appointment-card" href="/security-officer-dashboard/admitting-reports/view">
        <div class="appointment-card__row">
            <span class="appointment-card-title">Name</span>
            <span>Nethsara Sandeepa</span>
        </div>
        <div class="appointment-card__row">
            <span class="appointment-card-title">Registration Number</span>
            <span>ACN 6534</span>
        </div>
        <div class="appointment-card__row">
            <span class="appointment-card-title">Date</span>
            <span>01/02/2022</span>
        </div>

    </a>

    <a class="appointment-card" href="/security-officer-dashboard/admitting-reports/view">
        <div class="appointment-card__row">
            <span class="appointment-card-title">Name</span>
            <span>Tharushi Chethana</span>
        </div>
        <div class="appointment-card__row">
            <span class="appointment-card-title">Registration Number</span>
            <span>BIJ 5434</span>
        </div>
        <div class="appointment-card__row">
            <span class="appointment-card-title">Date</span>
            <span>01/02/2022</span>
        </div>

    </a>

    <a class="appointment-card" href="/security-officer-dashboard/admitting-reports/view">
        <div class="appointment-card__row">
            <span class="appointment-card-title">Name</span>
            <span>Supun Dilshan</span>
        </div>
        <div class="appointment-card__row">
            <span class="appointment-card-title">Registration Number</span>
            <span>KW 8830</span>
        </div>
        <div class="appointment-card__row">
            <span class="appointment-card-title">Date</span>
            <span>01/02/2022</span>
        </div>

    </a>
</section> -->

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
    <a class="appointment-card" href="/security-officer-dashboard/admitting-reports/view">
    <?php 
        foreach($admittingReports as $admittingReport){
            echo "
            <p class='appointment-card__name'>{$admittingReport['Name']}</p>
            <p class='appointment-card__date'>{$admittingReport['RegNo']}</p>
            <p class='appointment-card__date'>{$admittingReport['Date']}</p>";
        }
    ?>
</div>


