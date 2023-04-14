<?php

/**
 * @var array $orders
 */

use app\components\Table;

$columns = ["ID", "Customer Name", "Shipping Address", "Order Date","Payment Amount (Rs)","Status", " "];
$items = [];

foreach ($orders as $order){
    $paymentAmount = $order["Payment Amount"] / 100;
    if($order["Status"] === "Paid"){
        $order["Status"] = "Not Prepared";
    }
    $items[]=[
        "ID" => $order["ID"],
        "Customer Name" => $order["Customer Name"],
        "Shipping Address" => $order["Shipping Address"],
        "Order Date" => $order["Order Date"],
        "Payment Amount" => number_format($paymentAmount,2, '.', ','),
        "Status" => $order["Status"],

        " " => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                            <a href='/orders/view?id={$order["ID"]}' class='btn btn--rounded'>
                                <i class='fa-solid fa-arrow-up-right-from-square'></i>
                            </a>
                      </div>"
    ];
}

Table::render(items: $items, columns: $columns, keyColumns: ["ID", "Status"]);

