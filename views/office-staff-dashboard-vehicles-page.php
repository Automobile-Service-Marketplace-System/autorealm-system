<?php

use app\components\Table;

$columns = [];

foreach ($vehicles[0] as $key => $value) {
    $columns[] = $key;
}
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
        "ID" => $vehicle["Customer ID"],

        "Actions" =>   "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                            <button class='btn btn--rounded btn--danger'>
                                <i class='fa-solid fa-pencil'></i>
                            </button>
                            <a href='/office-staff-dashboard/appointments/for-vin?id={$vehicle['VIN']}' class='btn btn--rounded btn--info'>
                                <i class='fa-regular fa-calendar-check'></i>
                            </a>

                        </div>"
    ];
}

Table::render(items: $items, columns: $columns, keyColumns: ["VIN", "Actions"]);
