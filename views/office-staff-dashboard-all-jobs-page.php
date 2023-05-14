<?php

use app\components\Table;

$columns = [];

$noOfJobs = $jobCards['total'];
$startNo = ($page - 1) * $limit + 1;
$endNo = min($startNo + $limit - 1, $noOfJobs);

foreach($jobCards['jobCards'][0] as $key=>$value){
    $columns[] = $key;
}
$items = [];

foreach($jobCards['jobCards'] as $jobCard) {

    $status = match ($jobCard["Status"]) {
        'in-progress' => "In progress",
        'completed' => "Completed",
        'finished' => "Finished",
        default => "New"
    };

    $items[] = [
        "JobCard ID" => $jobCard["JobCard ID"],
        "Customer Name" => $jobCard["Customer Name"],
        "Employee Name" => $jobCard["Employee Name"],
        "Vehicle Reg No" => $jobCard["Vehicle Reg No"],
        "Start Date Time" => $jobCard["Start Date Time"],
        "End Date Time" => $jobCard["End Date Time"],
        "Status" => $status,
    ];
}
?>

<!-- pagination details -->
<p class="order-count" style="margin-bottom: 1rem">
    Showing <?= $startNo ?> - <?= $endNo ?> of <?php echo $total; ?> jobs
</p>

<!-- for searching -->
<div class="order-filtering-and-sort">
    <div class="filters" id="dashboard-order-filters">
        <div class="filters__actions">
            <div class="filters__dropdown-trigger">
                Search
                <i class="fa-solid fa-chevron-right"></i>
            </div>
        </div>

        <form>
            <div class="filters__dropdown">
                <div class="order-filter-search-items">
                    <div class="form-item form-item--icon-right form-item--no-label filters__search">
                        <input type="text" placeholder="Search jobs by customer name"
                               id="dashboard-order-cus-name-search" name="cus" <?php if($searchTermCustomer) echo "value='$searchTermCustomer'" ?> >
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="form-item form-item--icon-right form-item--no-label filters__search">
                        <input type="text" placeholder="Search jobs by employee name" id="dashboard-order-id-search" name="emp" <?php if($searchTermEmployee) echo "value='$searchTermEmployee'" ?>>
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="form-item form-item--icon-right form-item--no-label filters__search">
                        <input type="text" placeholder="Search jobs by vehicle registration number" id="dashboard-order-id-search" name="reg" <?php if($searchTermRegNo) echo "value='$searchTermRegNo'" ?>>
                        <i class="fa-solid fa-magnifying-glass"></i>
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

<?php
Table::render(items: $items, columns: $columns, keyColumns: ["JobCard ID","Status"]);
?>



<<!-- pagination page details -->
<div class="dashboard-pagination-container">
    <?php

    $hasNextPage = $page < ceil(num: $total / $limit);
    $hasNextPageClass = $hasNextPage ? "" : "dashboard-pagination-item--disabled";
    $hasNextPageHref = $hasNextPage ? "/job-cards?cus=$searchTermCustomer&emp=$searchTermEmployee&reg=$searchTermRegNo&page=" . ($page + 1) . "&limit=$limit" : "";
    $hasPreviousPage = $page > 1;
    $hasPreviousPageClass = $hasPreviousPage ? "" : "dashboard-pagination-item--disabled";
    $hasPreviousPageHref = $hasPreviousPage ? "/job-cards?cus=$searchTermCustomer&emp=$searchTermEmployee&reg=$searchTermRegNo&page=" . ($page - 1) . "&limit=$limit" : "";

    ?>
    <a class="dashboard-pagination-item <?= $hasPreviousPageClass ?>"
       href="<?= $hasPreviousPageHref ?>">
        <i class="fa-solid fa-chevron-left"></i>
    </a>
    <?php
    //    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
    foreach (range(1, ceil($total / $limit)) as $i) {
        $isActive = $i === (float)$page ? "dashboard-pagination-item--active" : "";
        echo "<a class='dashboard-pagination-item $isActive' href='/job-cards?cus=$searchTermCustomer&emp=$searchTermEmployee&reg=$searchTermRegNo&page=$i&limit=$limit'>$i</a>";
    }
    ?>
    <a class="dashboard-pagination-item <?= $hasNextPageClass ?>" href="<?= $hasNextPageHref ?>">
        <i class="fa-solid fa-chevron-right"></i>
    </a>
</div>