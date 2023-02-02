<?php

/**
 * @var array appointments
 */

use app\components\Table;

$columns=["Registration Number","Date and Time"];

$items=[];

foreach ($appointments as $appointment){
    $items[]=[
        "RegNo"=> $appointment["RegNo"],
        "DateandTime"=>$appointment["DateandTime"]
    ];
}
?>

<?php
Table::render(items: $items, columns: $columns, keyColumns: ["RegNo"]);
?>