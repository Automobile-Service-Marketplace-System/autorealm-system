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

<div class="product-filters">
    <div class="product-search">
        <input type="text" placeholder="Search">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>
        <select name="type" id="product-type" class="product-filte      r--select">
            <option value="Tyres">Tyres</option>
            <option value="Tyres">Tyres</option>
            <option value="Tyres">Tyres</option>
            <option value="Tyres">Tyres</option>
            <option value="Tyres">Tyres</option>
            <option value="Tyres">Tyres</option>
        </select>
    <div class="product-price">
    <p>
        <i class="fa-solid fa-dollar-sign"></i>
        <span>Price</span>
    </p>
        <input type="number" placeholder="Min">
        <input type="number" placeholder="Max">
    </div>
    <select name="type" id="product-type" class="product-filter--select">
        <option value="Tyres">Tyres</option>
        <option value="Tyres">Tyres</option>
        <option value="Tyres">Tyres</option>
        <option value="Tyres">Tyres</option>
        <option value="Tyres">Tyres</option>
        <option value="Tyres">Tyres</option>
    </select>
</div>

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
//    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
    foreach (range(1, ceil($total / $limit)) as $i) {
        $isActive = $i === (float)$page ? "pagination-item--active" : "";
        echo "<a class='pagination-item $isActive' href='/products?page=$i&limit=$limit'>$i</a>";
    }
    ?>
</div>