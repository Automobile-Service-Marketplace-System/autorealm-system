<?php

/**
 * @var array $orders
 */
//\app\utils\DevOnly::prettyEcho($orders);

use app\components\Table;

$columns = ["ID", "Customer Name", "Shipping Address", "Order Date","Payment Amount (Rs)","Status", " "];
$items = [];

foreach ($orders as $order){
    $paymentAmount = $order["Payment Amount"] / 100;
    if($order["Status"] === "Paid"){
        $order["Status"] = "Not Prepared";
    }
    $statusElements = "";
        switch ($order["Status"]) {
            case "Not Prepared":
                $statusElements = "<span class='status-btn-shape ntprep-st-col'>{$order["Status"]}</span>";
                break;
            case "Prepared":
                $statusElements = "<span class='status-btn-shape prep-st-col'>{$order["Status"]}</span>";
                break;
            case "Delivery":
                $statusElements = "<span class='status-btn-shape del-st-col'>{$order["Status"]}</span>";
                break;
            case "CourierConfirmed":
                $statusElements = "<span class='status-btn-shape cur-st-col'>{$order["Status"]}</span>";
                break;
            case "CustomerConfirmed":
                $statusElements = "<span class='status-btn-shape cus-st-col'>{$order["Status"]}</span>";
                break;
        }
    $items[]=[
        "ID" => $order["ID"],
        "Customer Name" => $order["Customer Name"],
        "Shipping Address" => $order["Shipping Address"],
        "Order Date" => $order["Order Date"],
        "Payment Amount" => number_format($paymentAmount,2, '.', ','),
        "Status" => $statusElements,

        " " => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                            <a href='/orders/view?id={$order["ID"]}' class='btn btn--info btn--rounded'>
                                <i class='fa-solid fa-arrow-up-right-from-square'></i>
                            </a>
                      </div>"
    ];
}
?>
<div class="order-filtering-and-sort">
    <div class="product-filters">
        <div class="product-search">
            <input type="text" placeholder="Search Order by ID">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>

        <div>
            <select name="status-type" id="status-type" class="product-filter--select">
                <option value="all">All Orders</option>
                <option value="not-prepared">Not Prepared</option>
                <option value="prepared">Prepared</option>
                <option value="delivery">Delivery</option>
                <option value="courier-confirmed">Courier Confirmed</option>
                <option value="customer-confirmed">Customer Confirmed</option>
            </select>
        </div>
    </div>
    <div class="order-sort">

        <select name="sort-type" id="sort-type" class="product-filter--select">
            <option value="newest">Newest</option>
            <option value="oldest">Oldest</option>
        </select>
    </div>
</div>

<?php
Table::render(items: $items, columns: $columns, keyColumns: ["ID", " "]);
?>
