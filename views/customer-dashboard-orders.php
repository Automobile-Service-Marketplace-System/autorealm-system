<?php
/**
 * @var array $orders
 * @var int $total
 * @var int $page
 * @var int $limit
 */

use app\components\CustomerOrderCard;

?>


<div class="product-filters justify-between">
    <div class="flex gap-4 items-center">
        <div class="product-search">
            <input type="text" placeholder="Search">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <select name="type" id="product-type" class="product-filter--select">
            <option value="Tyres">Due Orders</option>
            <option value="Tyres">Shipped Orders</option>
            <option value="Tyres">Completed Orders</option>
            <option value="Tyres">All Orders</option>
        </select>
    </div>
    <select name="type" id="product-type" class="product-filter--select">
        <option value="Tyres">Sort By</option>
    </select>
</div>

<div class="orders-container">
    <?php
    foreach ($orders as $order) {
        CustomerOrderCard::render($order);
    } ?>
</div>

<div class="pagination-container">
    <?php
    foreach (range(1, ceil($total / $limit)) as $i) {
        $isActive = $i === (float)$page ? "pagination-item--active" : "";
        echo "<a class='pagination-item $isActive' href='/dashboard/orders?page=$i&limit=$limit'>$i</a>";
    }
    ?>
</div>