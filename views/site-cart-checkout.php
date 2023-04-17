<?php
/**
 * @var array $cartItems
 */

$totalCost = 0;

?>

<h2 class="cart-heading">Cart Checkout</h2>

<section class="cart-grid">
    <div class="cart-elevated-card" style="width: 60%">
        <?php
        if (empty($cartItems)) {
            echo '<h2 class="cart-heading">Cart is empty</h2>';
        } else {
            foreach ($cartItems as $cartItem) {
                $name = $cartItem['name'];
                $amount = $cartItem['amount'];
                $price = number_format($cartItem['price'] / 100, 2, '.', ',');
                $totalPrice = number_format($cartItem['price'] / 100 * $amount, 2, '.', ',');
                $totalCost += $cartItem['price'] / 100 * $amount;
                try {
                    $images = json_decode($cartItem['image'], false, 512, JSON_THROW_ON_ERROR);
                } catch (JsonException $e) {
                    $images = [];
                }
                $image = empty($images) ? '/images/placeholders/product-image-placeholder.jpg' : $images[0];
                echo "<div class='cart-item'>
                <img src='$image' alt='$name'>
                <div class='cart-item__info'>
                    <h3>
                        $name            
                    </h3>
                    <div>
                     <p>Rs. $price</p>
                    </div>
                </div>
                <div class='cart-item__actions'>
                    <p>
                       x $amount
                    </p>
                </div>
                <div class='cart-item__total'>
                    <p>
                    Rs. $totalPrice
                    </p>
                </div>
            </div>";
            }
        }

        ?>
    </div>

    <div class="cart-elevated-card checkout-order-summery" style="width: 40%">

        <div class="card-checkout-card-title mb-4">
            <span>Total Amount</span>
            <span>Rs.
                <?= number_format($totalCost, 2, ".", ",") ?>
            </span>
        </div>

        <form id="payment-form">
            <div id="link-authentication-element">
                <!--Stripe.js injects the Link Authentication Element-->
            </div>
            <div id="payment-element">
                <!--Stripe.js injects the Payment Element-->
            </div>
            <button id="submit" class="btn btn--block mt-4">
                <i class="fa-solid fa-spinner hidden" id="payment-spinner"></i>
                <span id="button-text">Pay now</span>
            </button>
            <div id="payment-message" class="hidden"></div>
        </form>

    </div>
</section>