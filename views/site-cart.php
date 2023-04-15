<?php
/**
 * @var  array $cartItems
 * @var  int $limit
 * @var  int $page
 * @var  int $total
 */


if (empty($cartItems)) {
    echo "<div class='cart-error'>
                    <i class='fas fa-exclamation-triangle'></i> 
                    <p>
                    Your cart is empty. <br> <a href='/products'>Add some products</a>
                    </p>
               </div>";
} else {
    echo "
    <h2 class='cart-heading'>Your cart</h2>
    <div class='cart'>";

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
    echo "</div>";
    echo "<div class='flex items-center justify-end mt-4'>
            <a href='/cart/checkout' class='btn btn--danger'>Checkout</a>
         </div>
    ";
}

?>