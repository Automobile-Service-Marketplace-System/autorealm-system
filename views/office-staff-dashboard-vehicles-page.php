<?php

use app\components\Table;
use app\models\Brand;

$columns = ["VIN", "Reg no", "Engine no", "Manufactured Year", "Engine Capacity", "Vehicle Type", "Fuel Type", "Transmission Type", "Model Name", "Brand Name", "Customer ID"];

$columns[] = "Actions";

$items = [];

foreach ($vehicles as $vehicle) {
    $items[] = [

        "VIN" => $vehicle["VIN"],
        "Reg no" => $vehicle["Registration No"],
        "Engine no" => $vehicle["Engine No"],
        "Manufactured Year" => $vehicle["Manufactured Year"],
        "Engine Capacity" => $vehicle["Engine Capacity"],
        "Vehicle Type" => $vehicle["Vehicle Type"],
        "Fuel Type" => $vehicle["Fuel Type"],
        "Transmission Type" => $vehicle["Transmission Type"],
        "Model Name" => $vehicle["Model Name"],
        "Brand Name" => $vehicle["Brand Name"],
        "Customer ID" => $vehicle["Customer ID"],

        "Actions" =>   "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                            <button class='btn btn--rounded btn--warning update-vehicle-btn' data-vin='{$vehicle["VIN"]}' data-reg_no='{$vehicle["Registration No"]}' data-engine_no='{$vehicle["Engine No"]}' data-modelId='{$vehicle["Model ID"]}' data-brandId='{$vehicle["Brand ID"]}' data-customerId='{$vehicle["Customer ID"]}' >
                                <i class='fa-solid fa-pencil'></i>
                            </button>
                        </div>"
    ];
}

Table::render(items: $items, columns: $columns, keyColumns: ["VIN", "Actions"]);
?>

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