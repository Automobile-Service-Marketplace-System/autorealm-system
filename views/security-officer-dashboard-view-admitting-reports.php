<?php
/**
 * @var array $admittingReports
 * @var int $limit
 * @var int $page
 * @var int $total
 * @var string $searchTermRegNo
 * @var string $admi
 */

$noOfAdmittingReports = count($admittingReports);
$startNo = ($page - 1) * $limit + 1;
$endNo = $startNo + $noOfAdmittingReports - 1;

?>

<div class="flex items-center justify-end mb-4">
    <a class="btn" href="/security-officer-dashboard/admitting-reports/add">
        Create
        <i class="fa-solid fa-plus"></i>
    </a>
</div>

showing: <?= $startNo ?> - <?= $endNo ?> of <?= $total ?> admitting reports

<div class="filters" id="dashboard-product-filters">
    <div class="filters__actions">
        <div class="filters__dropdown-trigger" >
            Search & Filter
            <i class="fa-solid fa-chevron-right"></i>
        </div>
    </div>

    <form>
        <div class="filters__dropdown">
            <div class="form-item form-item--icon-right form-item--no-label filters__search">
                <input type="text" placeholder="Search Admitting Report by Register Number" id="dashboard-product-search" name="regNo" <?php if($searchTermRegNo) echo "value='$searchTermRegNo'"; ?>>
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <p>Filter employee by</p>
                <div class="filters__dropdown-content">
                    <div class="form-item form-item--no-label">
                        <select name="admitting_date" id="dashboard-order-date-filter">
                            <option value="all" <?php if($searchTermRegNo) echo "value='$searchTermRegNo'"; ?>>Date</option>
                            <option value="Today">Today</option>
                            <option value="Yesterday">Yesterday</option>
                            <option value="Last7">Last 7 Days</option>
                            <option value="Last30">Last 30 Days</option>
                            <option value="Last90">Last 90 Days</option>
                        </select>
                    </div>

                <div class="form-item form-item--no-label">
                    <select name="approve" id="dashboard-order-date-filter">
                        <option value="not_approved">Not Approved</option>
                        <option value="approved">Approved</option>
                        <option value="all">All</option>
                    </select>
                </div>

            <div class="filter-action-buttons">
                <button class="btn btn--text btn--danger btn--thin" id="clear-filters-btn" type="reset">Clear</button>
                <button class="btn btn--text btn--thin" id="apply-filters-btn">Submit</button>
            </div>
        </div>
    </form>
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

    <div class="pagination-container">
        <?php 
            foreach(range(1, ceil($total / $limit)) as $i){
                $activePage = $i === (float)$page ? "pagination-item--active" : "";
                echo "<a class='pagination-item $activePage' href='/security-officer-dashboard/view-admitting-reports?page=$i&limit=$limit'> $i </a>";
            }
        ?>
    </div>
</div>

