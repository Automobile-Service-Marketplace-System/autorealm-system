<?php

namespace app\components;

class CustomerOrderCard
{
    public static function render(array $order): void
    {
        $orderId = $order['Order ID'];
        $status = $order['Status'] === "Paid" ? "Due" : $order['Status'];
        $orderDate = $order['Order Date'];
        $items = $order['Items'];

        $totalPrice = 0;

        $itemsList = '';
        foreach ($items as $item) {
            $productName = $item['Product Name'];
            $productQuantity = $item['Quantity'];
            $itemCode = $item['Item Code'];
            $price = number_format($item['Price'], 2, '.', ',');
            $priceForAll = $item['Total'];
            $totalPrice += $priceForAll;
            $itemsList .= "
            <div>
                <img src='/images/placeholders/product-image-placeholder.jpg' alt='Product img 1'>
                <p>$productName</p>
                <p>$productQuantity.x</p>
                <p>Rs. $price</p>
            </div>
            ";
        }


        $totalPrice = number_format($totalPrice, 2, '.', ',');

        echo "
    <div class='order-card'>
        <div class='order-card__header'>
            <p>Ordered Date: $orderDate</p>
            <p class='due'>$status</p>
        </div>
        <div class='order-card__info'>
            <div class='order-card__info-section'>
                <p id='item-toggle-$itemCode' class='item-toggle'>Items
                    <i class='fa-solid fa-angle-right'></i>
                </p>
                <div id='item-list-$itemCode' class='order-items'>
                    $itemsList
                </div>
            </div>
        </div>
        <p class='order-card__cost'>
            <strong>
                Order Amount:
            </strong>
            Rs. $totalPrice
        </p>
    </div>
        
        ";
    }
}