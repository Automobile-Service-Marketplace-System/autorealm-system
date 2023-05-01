<?php

/**
 * @var array $suppliers
 * @var  int $limit
 * @var  int $page
 * @var  int $total
 */

use app\components\Table;

//\app\utils\DevOnly::prettyEcho($suppliers);

$columns = ["ID", "Name", "Address", "Registration No", "Sales Manager", "Contacts", "Last Purchase Date", "Last Supply Amount", "Email", "Actions"];

$items = [];

$noOfSuppliers = count($suppliers);
$startNo = ($page - 1) * $limit + 1;
$endNo = $startNo + $noOfSuppliers - 1;


foreach ($suppliers as $supplier) {
    $contacts = "";

    foreach ($supplier["Contact Numbers"] as $contact) {
        $contacts .= $contact . ", ";
    }

    $items[] = [
        "ID" => $supplier["ID"],
        "Name" => $supplier["Name"],
        "Address" => $supplier["Address"],
        "Registration No" => $supplier["Registration No"],
        "Sales Manager" => $supplier["Sales Manager"],
        "Contacts" => $contacts,
        "Last Purchase Date" => $supplier["Last Purchase Date"] ?? "N/A",
        "Last Supply Amount" => $supplier["Last Supply Amount"] ?? "N/A",
        "Email" => $supplier["Email"],
        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'
                                data-supplierId='{$supplier["ID"]}'
                                data-supplierName='{$supplier["Name"]}'
                                data-address='{$supplier["Address"]}'
                                data-salesManager='{$supplier["Sales Manager"]}'
                                data-email='{$supplier["Email"]}'
                                data-registrationNo='{$supplier["Registration No"]}'>
                            <button class='btn btn--rounded btn--warning update-supplier-button'>   
                                <i class='fa-solid fa-pencil'></i>
                            </button>
                            <button class='btn btn--rounded btn--danger delete-supplier-btn'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                      </div>"
    ];
}

?>
<div class="product-count-and-actions">
    <div class="product-table-count">
        <p>
            Showing <?= $startNo ?> - <?= $endNo ?> of <?php echo $total; ?> suppliers
        </p>
    </div>
    <div class="stock-manager-add-button-set">
        <div class="add-button">
            <button class="btn" id="add-supplier-btn">
                <i class="fa-solid fa-plus"></i>
                Add Suppliers
            </button>
        </div>

    </div>
</div>

<div class="filters" id="dashboard-supplier-filters">
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
                           id="dashboard-order-cus-name-search" name="cus">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>

                <div class="form-item form-item--icon-right form-item--no-label filters__search">
                    <input type="text" placeholder="Search Order by ID" id="dashboard-order-id-search" name="id">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>

            <p>Filter products by</p>
            <div class="filters__dropdown-content">
                <div class="form-item form-item--no-label">
                    <select name="status" id="dashboard-order-status-filter">
                        <option value="">Status</option>
                        <option value="Not Prepared">Not Prepared</option>
                        <option value="Prepared">Prepared</option>
                        <option value="Delivery">Delivery</option>
                        <option value="CourierConfirmed">Courier Confirmed</option>
                        <option value="CustomerConfirmed">Customer Confirmed</option>
                    </select>
                </div>
                <div class="form-item form-item--no-label">
                    <select name="payment" id="dashboard-order-payment-filter">
                        <option value="">Payment</option>
                        <option value="Paid">Paid</option>
                        <option value="Not Paid">Not Paid</option>
                    </select>
                </div>
                <div class="form-item form-item--no-label">
                    <select name="date" id="dashboard-order-date-filter">
                        <option value="">Date</option>
                        <option value="Today">Today</option>
                        <option value="Yesterday">Yesterday</option>
                        <option value="Last 7 Days">Last 7 Days</option>
                        <option value="Last 30 Days">Last 30 Days</option>
                        <option value="Last 90 Days">Last 90 Days</option>
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

<?php

Table::render(items: $items, columns: $columns, keyColumns: ["ID", "Actions"]);

?>

<div class="dashboard-pagination-container">
    <?php

    $hasNextPage = $page < ceil(num: $total / $limit);
    $hasNextPageClass = $hasNextPage ? "" : "dashboard-pagination-item--disabled";
    $hasNextPageHref = $hasNextPage ? "/products?page=" . ($page + 1) . "&limit=$limit" : "";
    $hasPreviousPage = $page > 1;
    $hasPreviousPageClass = $hasPreviousPage ? "" : "dashboard-pagination-item--disabled";
    $hasPreviousPageHref = $hasPreviousPage ? "/products?page=" . ($page - 1) . "&limit=$limit" : "";

    ?>
    <a class="dashboard-pagination-item <?= $hasPreviousPageClass ?>"
       href="<?= $hasPreviousPageHref ?>">
        <i class="fa-solid fa-chevron-left"></i>
    </a>
    <?php
    //    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
    foreach (range(1, ceil($total / $limit)) as $i) {
        $isActive = $i === (float)$page ? "dashboard-pagination-item--active" : "";
        echo "<a class='dashboard-pagination-item $isActive' href='/suppliers?page=$i&limit=$limit'>$i</a>";
    }
    ?>
    <a class="dashboard-pagination-item <?= $hasNextPageClass ?>" href="<?= $hasNextPageHref ?>">
        <i class="fa-solid fa-chevron-right"></i>
    </a>
</div>
