<?php

/**
 * @var array $orders
 */

use app\components\Table;

$columns = ["ID", "Customer Name", "Shipping Address", "Order Date","Payment Amount","Status", " "];
$items = [];

foreach ($orders as $order){
    $items[]=[
        "ID" => $order["ID"],
        "Customer Name" => $order["Customer Name"],
        "Shipping Address" => $order["Shipping Address"],
        "Order Date" => $order["Order Date"],
        "Payment Amount" => $order["Payment Amount"],
        "Status" => $order["Status"],
        " " => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                            <a href='' class='btn btn--rounded'>
                                <i class='fa-solid fa-arrow-up-right-from-square'></i>
                            </a>
                            
   
                      </div>"
    ];
}

Table::render(items: $items, columns: $columns, keyColumns: ["ID", "Status"]);

