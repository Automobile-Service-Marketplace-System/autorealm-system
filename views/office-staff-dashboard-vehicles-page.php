<?php

/**
 * @var array $vehicles
 * @var int $page
 * @var int $limit
 * @var int $total
 * @var array $models
 * @var array $brands
 */

use app\components\Table;

$noOfJobs = $vehicles['total'];
$startNo = ($page - 1) * $limit + 1;
$endNo = min($startNo + $limit - 1, $noOfJobs);

$columns = ["VIN", "Reg no", "Engine no", "Customer Name", "Manufactured Year", "Engine Capacity", "Vehicle Type", "Fuel Type", "Transmission Type", "Model Name", "Brand Name", "Actions"];

$items = [];

foreach ($vehicles['vehicles'] as $vehicle) {
    $items[] = [

        "VIN" => $vehicle["VIN"],
        "Reg no" => $vehicle["Registration No"],
        "Engine no" => $vehicle["Engine No"],
        "Customer Name" => $vehicle["Customer Name"],
        "Manufactured Year" => $vehicle["Manufactured Year"],
        "Engine Capacity" => $vehicle["Engine Capacity"],
        "Vehicle Type" => $vehicle["Vehicle Type"],
        "Fuel Type" => $vehicle["Fuel Type"],
        "Transmission Type" => $vehicle["Transmission Type"],
        "Model Name" => $vehicle["Model Name"],
        "Brand Name" => $vehicle["Brand Name"],
        "Actions" =>   "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                            <button class='btn btn--rounded btn--warning update-vehicle-btn' data-vin='{$vehicle["VIN"]}' data-reg_no='{$vehicle["Registration No"]}' data-engine_no='{$vehicle["Engine No"]}' data-modelId='{$vehicle["Model ID"]}' data-brandId='{$vehicle["Brand ID"]}' data-customerid='{$vehicle["Customer ID"]}' >
                                <i class='fa-solid fa-pencil'></i>
                            </button>
                        </div>"
    ];
}
?>

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
                        <input type="text" placeholder="Search vehicle by Reg No"
                               id="dashboard-order-cus-name-search" name="reg" >
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="form-item form-item--icon-right form-item--no-label filters__search">
                        <input type="text" placeholder="Search vehicle by customer name" id="dashboard-order-id-search" name="cus">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                </div>

                <p>Filter vehicle by</p>
                <div class="filters__dropdown-content">
                    <div class="form-item form-item--no-label">
                        <select name="type" id="dashboard-order-status-filter">
                            <option value="all">Type</option>
                            <option value="Bike">Bike</option>
                            <option value="Car">Car</option>
                            <option value="Jeep">Jeep</option>
                            <option value="Van">Van</option>
                            <option value="Lorry">Lorry</option>
                            <option value="Bus">Bus</option>
                            <option value="Other">Other</option>
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

<div class="product-count-and-actions">
    <div class="product-table-count">
        <p>
            Showing <?= $startNo ?> - <?= $endNo ?> of <?php echo $total; ?> vehicles
            <!--            Showing 25 out of 100 products-->
        </p>
    </div>
</div>

<?php
Table::render(items: $items, columns: $columns, keyColumns: ["VIN", "Actions"]);
?>

<div class="pagination-container">
    <?php 
        foreach(range(1,ceil($total / $limit)) as $i) {
            $isActive = $i === (float)$page ? "pagination-item--active" : "";
            echo "<a class='pagination-item $isActive' href='/vehicles?page=$i&limit=$limit'>$i</a>";
        }
        ?>
</div>

<script>
    <?php
    try {
        $modelsString = json_encode($models, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        $modelsString = "[]";
    }

    try {
        $brandsString = json_encode($brands, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        $brandsString = "[]";
    }
    ?>

    const models = <?= $modelsString ?>;
    const brands = <?= $brandsString ?>;

    localStorage.setItem("models", JSON.stringify(models));
    localStorage.setItem("brands", JSON.stringify(brands));
</script>