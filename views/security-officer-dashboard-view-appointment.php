<?php
/**
 * @var array $appointments
 * @var int $limit
 * @var int $page
 * @var int $total
 * @var string $searchTermRegNo
 * @var string $searchTermDate
 */

//  var_dump($total);
$noOfAppointments = count($appointments);
$startNo = ($page - 1) * $limit + 1;
$endNo = $startNo + $noOfAppointments - 1;

?>

showing: <?= $startNo ?> - <?= $endNo ?> of <?= $total ?> appointments

<div class="filters" id="dashboard-product-filters">
    <div class="filters__actions">
        <div class="filters__dropdown-trigger" >
            Search
            <i class="fa-solid fa-chevron-right"></i>
        </div>
    </div>
    <form>
        <div class="filters__dropdown">
            <div class="form-item form-item--icon-right form-item--no-label filters__search">
                <input type="text" placeholder="Search Appointment by Registration Number" id="dashboard-product-search" name="regno" <?php if($searchTermRegNo) echo "value='$searchTermRegNo'"; ?>>
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="form-item form-item--icon-right form-item--no-label filters__search">
                <input type="date" placeholder="Search Appointment by date" id="dashboard-product-search" name="date" <?php if($searchTermDate) echo "value='$searchTermDate'" ;?>>
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <div class="filter-action-buttons">
                <button class="btn btn--text btn--danger btn--thin" id="clear-filters-btn" type="reset">Clear</button>
                <button class="btn btn--text btn--thin" id="apply-filters-btn">Submit</button>
            </div>
        </div>
    </form>
</div>

<div class="appointment">
    <?php 
        foreach($appointments as $appointment){            
            echo " <div class='appointment-card-wrapper '>
                <p class='appointment-card__name'><b>Name: </b>{$appointment['Name']}</p>
                <p class='appointment-card__regno'><b>Registration Number: </b>{$appointment['RegNo']}</p>
                <p class='appointment-card__from_time'><b>From Time: </b>{$appointment['FromTime']}</p>
                <p class='appointment-card__to_time'><b>To Time: </b>{$appointment['ToTime']}</p>
                <p class='appointment-card__date'><b>Date: </b>{$appointment['Date']}</p>
                <a class='btn' style='width: 10rem; align:center; margin: 0 auto' href='/security-officer-dashboard/check-appointment'>Scan QR code</a>
            </div>";
        }
    ?>
    
    <div class="pagination-container">
        <?php 
            foreach(range(1, ceil($total / $limit)) as $i){
                $activePage = $i === (float)$page ? "pagination-item--active" : "";
                echo "<a class='pagination-item $activePage' href='/security-officer-dashboard/view-appointment?regno=$searchTermRegNo&date=$searchTermDate&page=$i&limit=$limit'> $i </a>";
            }
        ?>
    </div>
</div>