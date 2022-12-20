<?php
/**
 * @var  array $products
 * @var  bool $is_authenticated
 * @var  int $limit
 * @var  int $page
 * @var  int $total
 */

use app\components\ProductCard;


?>

<p class="product-count">
    Showing <?php echo $limit; ?> of <?php echo $total; ?> products
</p>

<div class="products-gallery">
    <?php
    foreach ($products as $product) {
        ProductCard::render(product: $product, is_authenticated: $is_authenticated);
    }
    ?>
</div>

<div class="pagination-container">
    <?php
    foreach (range(1, ceil($total / $limit)) as $i) {
        $isActive = $i === (float)$page ? "pagination-item--active" : "";
        echo "<a class='pagination-item $isActive' href='/products?page=$i&limit=$limit'>$i</a>";
    }
    ?>
</div>