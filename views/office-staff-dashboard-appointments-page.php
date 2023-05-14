<?php

/**
 * @var array $appointments
 * @var int $page
 * @var int $limit
 * @var int $total
 */

use app\components\Table;

$noOfAppointments = $appointments['total'];
$startNo = ($page - 1) * $limit + 1;
$endNo = min($startNo + $limit - 1, $noOfAppointments);

$columns = [];
$items = [];

if (empty($appointments['appointments'])) {
    echo "<p class='no-data'>No Appointments <br> as of now </p>";
} else {
    $columns = array("Appointment ID", "Reg No", "Customer Name", "Mileage (KM)", "Remarks", "Date", "From Time", "To Time", "Actions");


    foreach ($appointments['appointments'] as $appointment) {
        $items[] = [
            "Appointment ID" => $appointment["Appointment ID"],
            "Vehicle Reg No" => $appointment["Vehicle Reg No"],
            "Customer Name" => $appointment["Customer Name"],
            "Mileage (KM)" => $appointment["Mileage"],
            "Remarks" => $appointment["Remarks"],
            "Date" => $appointment["Date"],
            "From Time" => $appointment["From Time"],
            "To Time" => $appointment["To Time"],
            "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                            <button class='btn btn--rounded btn--info office-create-jobcard' data-customerID='{$appointment["Customer ID"]}'>
                            <i class='fa-solid fa-wrench'></i>
                            </button>                     
                            <button class='btn btn--rounded btn--danger office-delete-appointment-btn' data-appointmentID='{$appointment['Appointment ID']}'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                        </div>"
        ];
    }
}
?>
<?php if (!empty($appointments['appointments'])) { ?>
    <div class="product-count-and-actions">
        <div class="product-table-count">
            <!-- pagination details -->
            <p class="order-count" style="margin-bottom: 1rem">
                Showing <?= $startNo ?> - <?= $endNo ?> of <?php echo $total; ?> orders
            </p>
        </div>
    </div>
<?php } ?>

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
                        <input type="text" placeholder="Search appointment by customer name" id="dashboard-order-cus-name-search" name="cus" <?php if ($searchTermCustomer) echo "value='$searchTermCustomer'" ?>>
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="form-item form-item--icon-right form-item--no-label filters__search">
                        <input type="text" placeholder="Search appointment by vehicle registration number" id="dashboard-order-id-search" name="reg" <?php if ($searchTermRegNo) echo "value='$searchTermRegNo'" ?>>
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
if (!empty($appointments['appointments'])) {
    Table::render(items: $items, columns: $columns, keyColumns: ["Appointment ID", "Actions"]);
}
?>

<?php if (!empty($appointments['appointments'])) { ?>
    <!-- pagination page details -->
    <div class="dashboard-pagination-container">
        <?php

        $hasNextPage = $page < ceil(num: $total / $limit);
        $hasNextPageClass = $hasNextPage ? "" : "dashboard-pagination-item--disabled";
        $hasNextPageHref = $hasNextPage ? "/appointments?cus=$searchTermCustomer&reg=$searchTermRegNo&page=" . ($page + 1) . "&limit=$limit" : "";
        $hasPreviousPage = $page > 1;
        $hasPreviousPageClass = $hasPreviousPage ? "" : "dashboard-pagination-item--disabled";
        $hasPreviousPageHref = $hasPreviousPage ? "/appointments?cus=$searchTermCustomer&reg=$searchTermRegNo&page=" . ($page - 1) . "&limit=$limit" : "";

        ?>
        <a class="dashboard-pagination-item <?= $hasPreviousPageClass ?>" href="<?= $hasPreviousPageHref ?>">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <?php
        //    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
        foreach (range(1, ceil($total / $limit)) as $i) {
            $isActive = $i === (float)$page ? "dashboard-pagination-item--active" : "";
            echo "<a class='dashboard-pagination-item $isActive' href='/appointments?cus=$searchTermCustomer&reg=$searchTermRegNo&page=$i&limit=$limit'>$i</a>";
        }
        ?>
        <a class="dashboard-pagination-item <?= $hasNextPageClass ?>" href="<?= $hasNextPageHref ?>">
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>


<?php } ?>