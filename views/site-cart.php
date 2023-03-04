<?php
/**
 * @var  array $cartItems
 * @var  int $limit
 * @var  int $page
 * @var  int $total
 */


?>

<h2 class="cart-heading">Your cart</h2>

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
        try {
            $image = $cartItem['image'] === 'null' ? "/images/placeholders/product-image-placeholder.jpg" : json_decode($cartItem['image'], false, 512, JSON_THROW_ON_ERROR)[0];
        } catch (JsonException $e) {
            $image = "/images/placeholders/product-image-placeholder.jpg";
        }
        $price = "Rs. " . ($cartItem['price'] / 100) . ".00";
        $priceAmount = $cartItem['price'] / 100;
        $stockNotice = $cartItem['availableAmount'] > 0 ? "<span class='success'>In stock</span>" : "<span class='danger'>Out of stock</span>";

        $totalPrice = "Rs. " . (($cartItem['price'] * $cartItem['amount']) / 100) . ".00";
        echo "<div class='cart-item' id='cart-item-{$cartItem['item_code']}' data-name='{$cartItem['name']}'>
                <img src='$image' alt='{$cartItem['name']}'>
                <div class='cart-item__info'>
                    <h3>
                        {$cartItem['name']}            
                    </h3>
                    <div>
                     <p>$price</p>
                     $stockNotice                     
                    </div>
                </div>
                <div class='cart-item__actions'>
                    <button class='cart-action cart-action--decrease' data-productId='{$cartItem['item_code']}' data-price='$priceAmount'>
                        <i class='fas fa-minus'></i>
                    </button>
                    <p id='cart-amount-{$cartItem['item_code']}'>
                        {$cartItem['amount']}
                    </p>
                    <button class='cart-action cart-action--increase'  data-productId='{$cartItem['item_code']}' data-price='$priceAmount'>
                        <i class='fas fa-plus'></i>
                    </button>
                </div>
                <div class='cart-item__total'>
                    <p id='cart-amount-{$cartItem['item_code']}-total'>
                    Total: $totalPrice
                    </p>
                    <button class='cart-item-delete'  data-productId='{$cartItem['item_code']}' data-price='$priceAmount'>
                        <i class='fas fa-trash'></i>
                    </button>
                </div>
            </div>";
    }
    ?>


</div>
<div class="flex items-center justify-end mt-4">
    <a href="/cart/checkout" class="btn btn--danger">Checkout</a>
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
