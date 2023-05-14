<?php

use app\components\Table;

$columns = [];

// var_dump($jobCards['total']);
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

<div class="product-count-and-actions">
    <div class="product-table-count">
        <p>
            Showing <?= $startNo ?> - <?= $endNo ?> of <?php echo $total; ?> jobs
            <!--            Showing 25 out of 100 products-->
        </p>
    </div>
</div>

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
                               id="dashboard-order-cus-name-search" name="cus" >
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="form-item form-item--icon-right form-item--no-label filters__search">
                        <input type="text" placeholder="Search jobs by employee name" id="dashboard-order-id-search" name="emp">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="form-item form-item--icon-right form-item--no-label filters__search">
                        <input type="text" placeholder="Search jobs by vehicle registration no" id="dashboard-order-id-search" name="reg">
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



<div class="pagination-container">
    <?php 
        foreach(range(1,ceil($total / $limit)) as $i) {
            $isActive = $i === (float)$page ? "pagination-item--active" : "";
            echo "<a class='pagination-item $isActive' href='/job-cards?page=$i&limit=$limit'>$i</a>";
        }
        ?>
</div>