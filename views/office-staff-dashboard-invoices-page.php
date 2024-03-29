<div class="office-staff-button-set">
    <div class="add-button">
        <a class="btn" href="invoices/create">
            <i class="fa-solid fa-plus"></i>
            Create Invoice</a>
    </div>

</div>

<?php

use app\components\Table;

$columns = [];

$noOfJobs = $invoices['total'];
$startNo = ($page - 1) * $limit + 1;
$endNo = min($startNo + $limit - 1, $noOfJobs);

if (empty($invoices['invoices'])) {
    echo "<p class='no-data'>No Invoices as of now </p>";
} else {
    foreach ($invoices['invoices'][0] as $key => $value) {
        $columns[] = $key;
    }
    //$columns[] = "Actions";

    $items = [];

    foreach ($invoices['invoices'] as $invoice) {
        $items[] = [
            "Invoice No" => $invoice["Invoice No"],
            "Customer Name" => $invoice["Customer Name"],
            "Total Cost" => $invoice["Total Cost"],
            "Type" => $invoice["Type"],
            "Employee Name" => $invoice["Employee Name"],
            "JobCard ID" => $invoice["JobCard ID"],
    //        "Actions" =>   "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
    //                                        <a href='/vehicles/by-customer?id={$invoice['Invoice No']}' class='btn btn--rounded btn--info'>
    //                                            <i class='fa-solid fa-car-side'></i>
    //                                         </a>
    //                                         <button class='btn btn--rounded btn--warning'>
    //                                            <i class='fa-solid fa-pencil'></i>
    //                                         </button>
    //                        </div>"
        ];
    }
}
?>

<div class="product-count-and-actions">
    <div class="product-table-count">
        <p>
            Showing <?= $startNo ?> - <?= $endNo ?> of <?php echo $total; ?> invoices
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
                        <input type="text" placeholder="Search invoices by customer name"
                               id="dashboard-order-cus-name-search" name="cus" >
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="form-item form-item--icon-right form-item--no-label filters__search">
                        <input type="text" placeholder="Search invoices by employee name" id="dashboard-order-id-search" name="emp">
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
Table::render(items: $items, columns: $columns, keyColumns: ["Invoice No", "Actions"]);
?>

<div class="pagination-container">
    <?php 
        foreach(range(1,ceil($total / $limit)) as $i) {
            $isActive = $i === (float)$page ? "pagination-item--active" : "";
            echo "<a class='pagination-item $isActive' href='/invoices?page=$i&limit=$limit'>$i</a>";
        }
        ?>
</div>
