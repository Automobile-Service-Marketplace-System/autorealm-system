<?php
/**
 * @var array $orders
 * @var int $total
 * @var int $page
 * @var int $limit
 * @var string $status
 */

use app\components\CustomerOrderCard;

?>


    <div class="product-filters justify-between">
        <div class="flex gap-4 items-center">
            <select name="type" id="customer-order-status" class="product-filter--select">
                <?php
                $options = [
                    "Not Prepared" => "Due Orders",
                    "Prepared" => "Shipped Orders",
                    "Completed" => "Completed Orders",
                    "All" => "All Orders"
                ];

                foreach ($options as $value => $label) {
                    $selected = $value === $status ? "selected" : "";
                    echo "<option value='$value' $selected>$label</option>";
                }
                ?>
                <!--            <option value="Not Prepared">Due Orders</option>-->
                <!--            <option value="Prepared">Shipped Orders</option>-->
                <!--            <option value="Completed">Completed Orders</option>-->
                <!--            <option value="All">All Orders</option>-->
            </select>
        </div>
    </div>


    <div class="orders-container">
        <?php
        if (count($orders) > 0) {

            foreach ($orders as $order) {
                CustomerOrderCard::render($order);
            }
        } else {
            echo "<p style='margin: 4rem auto;font-size: 3rem;color: rgba(0,0,0,0.3)'>No results</p>";
        }
        ?>
    </div>
<?php if (count($orders) > 0) { ?>
    <div class="pagination-container">
        <?php
        foreach (range(1, ceil($total / $limit)) as $i) {
            $isActive = $i === (float)$page ? "pagination-item--active" : "";
            echo "<a class='pagination-item $isActive' href='/dashboard/orders?page=$i&limit=$limit'>$i</a>";
        }
        ?>
    </div>
<?php } ?>