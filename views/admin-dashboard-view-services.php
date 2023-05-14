
<?php

/**
 * @var array $services
 * @var int $limit
 * @var int $page
 * @var int $total
 * @var string $searchTermName
 * @var string $searchTermCode
 * @var string $serviceStatus
 */

use app\components\Table;

$noOfEmplyees = count($services);
$startNo = ($page - 1) * $limit + 1;
$endNo = $startNo + $noOfEmplyees - 1;

$columns = ["Service Code", "Service Name", "Description", "Price","Action" ];
$items = [];
foreach ($services as $service) {
    $items[] = [
        "ID" => $service["ID"],
        "Name" => $service["Name"],
        "Description" => $service["Description"],
        "Price" => $service["Price"],
        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem;' data-serviceid='{$service['ID']}'>
                        
                            <button class='btn btn--rounded btn--warning update-service-btn'>
                                <i class='fa-solid fa-pencil'></i>
                            </button>
                            <button class='btn btn--rounded btn--danger delete-service-btn'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                      </div>"

 
    ];
}
?>

<div class="admin-add-button-set">
    <div class="add-button">
        <button class="btn" id="add-service">
            <i class="fa-solid fa-plus"></i>
            Add Service
        </button>
    </div>

</div>

<div class="product-table-count">
    <p> Showing: <?= $startNo ?> - <?= $endNo ?> of <?= $total ?> services</p>
</div>

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
                <input type="text" placeholder="Search Service by Name" id="dashboard-product-search" name="name" <?php if($searchTermName) echo "value='$searchTermName'"; ?>>
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <div class="form-item form-item--icon-right form-item--no-label filters__search">
                <input type="text" placeholder="Search Product by Code" id="dashboard-product-search" name="code" <?php if($searchTermCode) echo "value='$searchTermCode'"; ?>>
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <p>Filter service by</p>
                <div class="filters__dropdown-content">
                    <div class="form-item form-item--no-label">
                        <select name="status" id="dashboard-order-status-filter">
                            <option value="active" <?php if($serviceStatus=='active') echo 'selected';?>>Currently Active</option>
                            <option value="discontinued" <?php if($serviceStatus=='discontinued') echo 'selected';?>>Discontinued</option>

                        </select>
                    </div>
                </div>

            <div class="filter-action-buttons">
                <button class="btn btn--text btn--danger btn--thin" id="clear-filters-btn" type="reset">Clear</button>
                <button class="btn btn--text btn--thin" id="apply-filters-btn">Submit</button>
            </div>
        </div>
    </form>

</div>

<?php
Table::render(items: $items, columns: $columns, keyColumns: ["ID","Actions"]);
?>

<div class="dashboard-pagination-container">
    <?php

    $hasNextPage = $page < ceil(num: $total / $limit);
    $hasNextPageClass = $hasNextPage ? "" : "dashboard-pagination-item--disabled";
    $hasNextPageHref = $hasNextPage ? "/services?page=" . ($page + 1) . "&limit=$limit" : "";
    $hasPreviousPage = $page > 1;
    $hasPreviousPageClass = $hasPreviousPage ? "" : "dashboard-pagination-item--disabled";
    $hasPreviousPageHref = $hasPreviousPage ? "/services?page=" . ($page - 1) . "&limit=$limit" : "";

    ?>
    <a class="dashboard-pagination-item <?= $hasPreviousPageClass ?>"
       href="<?= $hasPreviousPageHref ?>">
        <i class="fa-solid fa-chevron-left"></i>
    </a>
    <?php

    foreach (range(1, ceil($total / $limit)) as $i) {
        $isActive = $i === (float)$page ? "dashboard-pagination-item--active" : "";
        echo "<a class='dashboard-pagination-item $isActive' href='/services?name=$searchTermName&code=$searchTermCode&status=$serviceStatus&page=$i&limit=$limit'>$i</a>";
    }
    ?>
    <a class="dashboard-pagination-item <?= $hasNextPageClass ?>" href="<?= $hasNextPageHref ?>">
        <i class="fa-solid fa-chevron-right"></i>
    </a>
</div>