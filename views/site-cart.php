<?php
/**
 * @var  array $cartItems
 * @var  int $limit
 * @var  int $page
 * @var  int $total
 */


echo "<pre>";
var_dump($cartItems);
echo "<pre>";

?>

<h2>Your cart</h2>

<div class="cart">

    <?php
    // get keys of the array
//    $keys = array_keys($cartItems[0]);
//    $newKeys = [];
//    foreach ($keys as $key) {
//        $newKeys[] = ucwords(str_replace("_", " ", $key));
//    }
//    echo "<tr>";
//    foreach ($newKeys as $key) {
//        echo "<th>" . $key . "</th>";
//    }
//    echo  "</tr>"

foreach ($cartItems as $cartItem) {
    echo "<div class='cart-item'></div>";
}
    ?>



</div>


<!---->
<!--<p class="product-count">-->
<!--    Showing --><?php //echo $limit; ?><!-- of --><?php //echo $total; ?><!-- products-->
<!--</p>-->

<!--<div class="products-gallery">-->
<!--    --><?php
//    foreach ($products as $product) {
//        ProductCard::render(product: $product, is_authenticated: $is_authenticated);
//    }
//    ?>
<!--</div>-->

<!--<div class="pagination-container">-->
<!--    --><?php
//    foreach (range(1, ceil($total / $limit)) as $i) {
//        $isActive = $i === (float)$page ? "pagination-item--active" : "";
//        echo "<a class='pagination-item $isActive' href='/products?page=$i&limit=$limit'>$i</a>";
//    }
//    ?>
<!--</div>-->
