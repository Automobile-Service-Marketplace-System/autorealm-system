<?php
/**
 * @var array $customers
 * @var int $page
 * @var int $limit
 * @var int $total
 */
use app\components\Table;

$columns = [];

//for pagination
$noOfCustomers = $customers['total'];
$startNo = ($page - 1) * $limit + 1;
$endNo = min($startNo + $limit - 1, $noOfCustomers);


//table headings
$columns = array("ID", "Full Name", "Contact No", "Address", "Email", "Actions");

//for table data
$items = [];

//filling data from array
foreach($customers['customers'] as $customer) {
    $items[] = [
        "ID" => $customer["ID"],
        "Full Name" => $customer["Full Name"],
        "Contact No" => $customer["Contact No"],
        "Address" => $customer["Address"],
        "Email" => $customer["Email"],
        "Actions" =>   "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                                        <a href='/vehicles/by-customer?id={$customer['ID']}' class='btn btn--rounded btn--info'>
                                            <i class='fa-solid fa-car-side'></i>
                                         </a>
                                         <button class='btn btn--rounded btn--warning update-customer-btn' data-customerID='{$customer['ID']}'>
                                            <i class='fa-solid fa-pencil'></i>
                                         </button>
                                         <button id='create-appointment-btn-{$customer['ID']}' class='btn btn--rounded btn--success create-appointment-btn data-name='{$customer["Full Name"]}' data-id='{$customer["ID"]}'>
                                            <i class='fa-solid fa-calendar-check'></i>
                                         </button>
                        </div>"
    ];
}
?>

<!-- button for add new customer -->
<div class="office-staff-button-set">
    <div class="add-button">
        <a class="btn" href="customers/add">
            <i class="fa-solid fa-plus"></i>
         New Customer</a>
    </div>
    
</div>

<!-- pagination details -->
<p class="order-count" style="margin-bottom: 1rem">
    Showing <?= $startNo ?> - <?= $endNo ?> of <?php echo $total; ?> orders
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
                        <input type="text" placeholder="Search customer by name"
                               id="dashboard-order-cus-name-search" name="cus" <?php if($searchTermCustomer) echo "value='$searchTermCustomer'" ?> >
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="form-item form-item--icon-right form-item--no-label filters__search">
                        <input type="text" placeholder="Search customer by email" id="dashboard-order-id-search" name="email" <?php if($searchTermEmail) echo "value='$searchTermEmail'" ?>>
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

<!-- call table component -->
<?php
    Table::render(items: $items, columns: $columns, keyColumns: ["ID", "Actions"]);
?>

<!-- pagination page details -->
<div class="dashboard-pagination-container">
    <?php

    $hasNextPage = $page < ceil(num: $total / $limit);
    $hasNextPageClass = $hasNextPage ? "" : "dashboard-pagination-item--disabled";
    $hasNextPageHref = $hasNextPage ? "/customers?cus=$searchTermCustomer&email=$searchTermEmail&page=" . ($page + 1) . "&limit=$limit" : "";
    $hasPreviousPage = $page > 1;
    $hasPreviousPageClass = $hasPreviousPage ? "" : "dashboard-pagination-item--disabled";
    $hasPreviousPageHref = $hasPreviousPage ? "/customers?cus=$searchTermCustomer&email=$searchTermEmail&page=" . ($page - 1) . "&limit=$limit" : "";

    ?>
    <a class="dashboard-pagination-item <?= $hasPreviousPageClass ?>"
       href="<?= $hasPreviousPageHref ?>">
        <i class="fa-solid fa-chevron-left"></i>
    </a>
    <?php
    //    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
    foreach (range(1, ceil($total / $limit)) as $i) {
        $isActive = $i === (float)$page ? "dashboard-pagination-item--active" : "";
        echo "<a class='dashboard-pagination-item $isActive' href='/customers?cus=$searchTermCustomer&email=$searchTermEmail&page=$i&limit=$limit'>$i</a>";
    }
    ?>
    <a class="dashboard-pagination-item <?= $hasNextPageClass ?>" href="<?= $hasNextPageHref ?>">
        <i class="fa-solid fa-chevron-right"></i>
    </a>
</div>

