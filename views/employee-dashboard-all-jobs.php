<?php
/**
 * @var array $jobs
 * @var int $limit
 * @var int $page
 * @var int $total
 * @var string | null $searchTermCustomer
 * @var string | null $searchTermForemanName
 * @var string | null $searchTermVehicleRegNo
 * @var string | null $jobDate
 */


$jobsEmpty = count($jobs) === 0;
$jobsEmptyClass = $jobsEmpty ? "appointments-container--empty" : "";

?>

<div class="job-filtering-and-sort">
    <div class="filters" id="dashboard-job-filters">
        <div class="filters__actions">
            <div class="filters__dropdown-trigger">
                Search & Filter
                <i class="fa-solid fa-chevron-right"></i>
            </div>
        </div>

        <form>
            <div class="filters__dropdown">
                <div class="job-filter-search-items">
                    <div class="form-item form-item--icon-right form-item--no-label filters__search">
                        <input type="text" placeholder="Search jobs by customer name"
                               id="dashboard-job-customer-name-search" name="customer_name"
                               value="<?= $searchTermCustomer ?>">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="form-item form-item--icon-right form-item--no-label filters__search">
                        <input type="text" placeholder="Search jobs by vehicle register no"
                               id="dashboard-job-vehicle-reg-no--search" name="vehicle_reg_no"
                               value="<?= $searchTermVehicleRegNo ?>">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="form-item form-item--icon-right form-item--no-label filters__search">
                        <input type="text" placeholder="Search jobs by foreman" id="dashboard-job-foreman--search"
                               name="foreman_name" value="<?= $searchTermForemanName ?>">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>

                <p>Filter jobs by</p>
                <div class="filters__dropdown-content">
                    <div class="form-item form-item--no-label">
                        <input type="date" name="date" id="date" value="<?= $jobDate ?>">
                    </div>

                </div>
                <div class="filter-action-buttons">
                    <button class="btn btn--text btn--danger btn--thin" id="clear-filters-btn" type="reset">Clear
                    </button>
                    <button class="btn btn--text btn--thin" id="apply-filters-btn">Submit</button>
                </div>
            </div>
        </form>


    </div>

</div>

<div class="appointments-container <?= $jobsEmptyClass ?>">

    <?php

    if (!$jobsEmpty) {

        foreach ($jobs as $job) {
            $jobId = $job['job_card_id'];
            $vehicleName = $job['vehicle_name'];
            $regNo = $job['reg_no'];
            $startDate = $job['start_date_time'];
            $duration = $job['duration'];
            $foremanName = $job['employee_name'];
            $customerName = $job['customer_name'];


            echo "
    <div class='job-info-card'>
        <div class='job-info-card__header'>
            <p>Reg No: $regNo</p>
            <p class='job-date'>Started Date: $startDate</p>
        </div>
        <div class='job-info-card__info'>
            <div class='job-info-card__info-date'>
                <div>
                    <h3>Inspected By</h3>
                    <p>
                        $foremanName
                    </p>
                </div>
                <div>
                    <h3>Duration</h3>
                    <p>
                        $duration
                    </p>
                </div>
                <div>
                    <h3>Customer</h3>
                    <p>
                        $customerName
                    </p>
                </div>
            </div>
        </div>
        <div class='job-info-card__footer'>
            <div><strong>
                    For:
                </strong>
                $vehicleName
            </div>
            <div class='flex items-center gap-4'>
                <a href='/all-jobs/view?jobId=$jobId'>
                    View
                </a>
            </div>
        </div>
    </div>
    ";
        }
    } else {
        echo "<p>No results</p>";
    }
    ?>


</div>
<?php
if (!$jobsEmpty) { ?>
    <div class="dashboard-pagination-container">
        <?php

        $hasNextPage = $page < ceil(num: $total / $limit);
        $hasNextPageClass = $hasNextPage ? "" : "dashboard-pagination-item--disabled";
        $hasNextPageHref = $hasNextPage ? "/all-jobs?page=" . ($page + 1) . "&limit=$limit" : "";
        $hasPreviousPage = $page > 1;
        $hasPreviousPageClass = $hasPreviousPage ? "" : "dashboard-pagination-item--disabled";
        $hasPreviousPageHref = $hasPreviousPage ? "/all-jobs?page=" . ($page - 1) . "&limit=$limit" : "";

        ?>
        <a class="dashboard-pagination-item <?= $hasPreviousPageClass ?>"
           href="<?= $hasPreviousPageHref ?>">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <?php
        //    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
        foreach (range(1, ceil($total / $limit)) as $i) {
            $isActive = $i === (float)$page ? "dashboard-pagination-item--active" : "";
            echo "<a class='dashboard-pagination-item $isActive' href='/all-jobs?page=$i&limit=$limit'>$i</a>";
        }
        ?>
        <a class="dashboard-pagination-item <?= $hasNextPageClass ?>" href="<?= $hasNextPageHref ?>">
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>
<?php } ?>
