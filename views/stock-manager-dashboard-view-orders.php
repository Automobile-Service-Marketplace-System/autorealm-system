<?php

/**
 * @var array $orders
 * @var  int $limit
 * @var  int $page
 * @var  int $total
 *
 * @var string $searchTermCustomer
 * @var string $searchTermOrder
 * @var string $orderStatus
 * @var string $orderDate
 */
//\app\utils\DevOnly::prettyEcho($orders);
//var_dump($total);
use app\components\Table;

$columns = ["ID", "Customer", "Shipping Address", "Order Date", "Payment (Rs)", "Status", " "];
$items = [];

$noOfOrders = count($orders);
$startNo = ($page - 1) * $limit + 1;
$endNo = $startNo + $noOfOrders - 1;

foreach ($orders as $order) {
    $paymentAmount = $order["Payment Amount"] / 100;
    if ($order["Status"] === "Paid") {
        $order["Status"] = "Not Prepared";
    }
    $statusElements = "";
    switch ($order["Status"]) {
        case "Not Prepared":
            $statusElements = "<span class='status-btn-shape ntprep-st-col'>{$order["Status"]}</span>";
            break;
        case "Prepared":
            $statusElements = "<span class='status-btn-shape prep-st-col'>{$order["Status"]}</span>";
            break;
        case "Delivery":
            $statusElements = "<span class='status-btn-shape del-st-col'>{$order["Status"]}</span>";
            break;
        case "CourierConfirmed":
            $statusElements = "<span class='status-btn-shape cur-st-col'>{$order["Status"]}</span>";
            break;
        case "CustomerConfirmed":
            $statusElements = "<span class='status-btn-shape cus-st-col'>{$order["Status"]}</span>";
            break;
    }
    $items[] = [
        "ID" => $order["ID"],
        "Customer Name" => $order["Customer Name"],
        "Shipping Address" => $order["Shipping Address"],
        "Order Date" => $order["Order Date"],
        "Payment Amount" => number_format($paymentAmount, 2, '.', ','),
        "Status" => $statusElements,

        " " => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                            <a href='/orders/view?id={$order["ID"]}' class='btn btn--info btn--rounded'>
                                <i class='fa-solid fa-arrow-up-right-from-square'></i>
                            </a>
                      </div>"
    ];
}
?>

<p class="order-count" style="margin-bottom: 1rem">
    Showing <?= $startNo ?> - <?= $endNo ?> of <?php echo $total; ?> orders
</p>

<div class="order-filtering-and-sort">
    <div class="filters" id="dashboard-order-filters">
        <div class="filters__actions">
            <div class="filters__dropdown-trigger">
                Search & Filter
                <i class="fa-solid fa-chevron-right"></i>
            </div>
        </div>

        <form>
            <div class="filters__dropdown">
                <div class="order-filter-search-items">
                    <div class="form-item form-item--icon-right form-item--no-label filters__search">
                        <input type="text" placeholder="Search Order by Customer Name"
                               id="dashboard-order-cus-name-search" name="cus" <?php if($searchTermCustomer) echo "value='$searchTermCustomer'" ?>>
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="form-item form-item--icon-right form-item--no-label filters__search">
                        <input type="text" placeholder="Search Order by ID" id="dashboard-order-id-search" name="id" <?php if($searchTermOrder) echo "value='$searchTermOrder'"?>>
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>

                <p>Filter orders by</p>
                <div class="filters__dropdown-content">
                    <div class="form-item form-item--no-label">
                        <select name="status" id="dashboard-order-status-filter">
                            <option value="all" <?= ($orderStatus=='all')? 'selected': ""?>>Status</option>
                            <option value="Not Prepared" <?= ($orderStatus=='Not Prepared')? 'selected': ""?>>Not Prepared</option>
                            <option value="Prepared" <?= ($orderStatus=='Not Prepared')? 'selected': ""?>>Prepared</option>
                            <option value="Delivery" <?= ($orderStatus=='Delivery')? 'selected': ""?>>Delivery</option>
                            <option value="CourierConfirmed" <?= ($orderStatus=='CourierConfirmed')? 'selected': ""?>>Courier Confirmed</option>
                            <option value="CustomerConfirmed" <?= ($orderStatus=='CustomerConfirmed')? 'selected': ""?>>Customer Confirmed</option>
                        </select>
                    </div>

                    <div class="form-item form-item--no-label">
                        <select name="date" id="dashboard-order-date-filter">
                            <option value="all" <?= ($orderDate=='all') ? 'selected': ""?>>Date</option>
                            <option value="Today" <?= ($orderDate=='Today') ? 'selected': ""?>>Today</option>
                            <option value="Yesterday" <?= ($orderDate=='Yesterday') ? 'selected': ""?>>Yesterday</option>
                            <option value="Last7" <?= ($orderDate=='Last7') ? 'selected': ""?>>Last 7 Days</option>
                            <option value="Last30" <?= ($orderDate=='Last30') ? 'selected': ""?>>Last 30 Days</option>
                            <option value="Last90" <?= ($orderDate=='Last90') ? 'selected': ""?>>Last 90 Days</option>
                        </select>
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
if ($orders){
    Table::render(items: $items, columns: $columns, keyColumns: ["ID", " "]);
    ?>

    <div class="dashboard-pagination-container">
    <?php

    $hasNextPage = $page < ceil(num: $total / $limit);
    $hasNextPageClass = $hasNextPage ? "" : "dashboard-pagination-item--disabled";
    $hasNextPageHref = $hasNextPage ? "/orders?cus=$searchTermCustomer&id=$searchTermOrder&status=$orderStatus&date=$orderDate&page=" . ($page + 1) . "&limit=$limit" : "";
    $hasPreviousPage = $page > 1;
    $hasPreviousPageClass = $hasPreviousPage ? "" : "dashboard-pagination-item--disabled";
    $hasPreviousPageHref = $hasPreviousPage ? "/orders?cus=$searchTermCustomer&id=$searchTermOrder&status=$orderStatus&date=$orderDate&page=" . ($page - 1) . "&limit=$limit" : "";

    ?>
    <a class="dashboard-pagination-item <?= $hasPreviousPageClass ?>"
       href="<?= $hasPreviousPageHref ?>">
        <i class="fa-solid fa-chevron-left"></i>
    </a>
    <?php
    //    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
    foreach (range(1, ceil($total / $limit)) as $i) {
        $isActive = $i === (float)$page ? "dashboard-pagination-item--active" : "";
        echo "<a class='dashboard-pagination-item $isActive' href='/orders?cus=$searchTermCustomer&id=$searchTermOrder&status=$orderStatus&date=$orderDate&page=$i&limit=$limit'>$i</a>";
    }
    ?>
    <a class="dashboard-pagination-item <?= $hasNextPageClass ?>" href="<?= $hasNextPageHref ?>">
        <i class="fa-solid fa-chevron-right"></i>
    </a>
</div>
<?php } else { ?>
    <div class="stock-manager-no-items">
        <p>
            There are no Orders matching your search criteria.
        </p>
    </div>
<?php   } ?>

