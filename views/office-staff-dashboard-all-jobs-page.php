<?php

use app\components\Table;

$columns = [];

foreach($jobCards[0] as $key=>$value){
    $columns[] = $key;
}

$items = [];

foreach($jobCards as $jobCard) {
    $items[] = [
        "JobCard ID" => $jobCard["JobCard ID"],
        "Customer Name" => $jobCard["Customer Name"],
        "Employee Name" => $jobCard["Employee Name"],
        "VIN" => $jobCard["VIN"],
        "Start Date Time" => $jobCard["Start Date Time"],
        "End Date Time" => $jobCard["End Date Time"],
        "Status" => $jobCard["Status"],
        "Mileage" => $jobCard["Mileage"],
        "Customer Observation" => $jobCard["Customer Observation"]
    ];
}

Table::render(items: $items, columns: $columns, keyColumns: ["JobCard ID","Customer Observation"]);
?>

