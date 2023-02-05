<?php

namespace app\components;

use app\models\ShoppingCart;

class CustomerHeader
{

    public static function render(int|null $customerId, string $current_url): void
    {
        $cartModel = new ShoppingCart();
        if (isset($customerId)) {
            $result = $cartModel->getCartItemCount(customerId: $customerId);
            if (is_array($result)) {
                $cart_count = 0;
            } else {
                $cart_count = $result;
            }
        }

        echo "
            <nav class='main-nav'>
        <ul>
            <li><a href='/services'>Services</a></li>
            <li><a href='/products'>Products</a></li>
            <li><a href='/about-us'>About Us</a></li>
            <li><a href='/contact-us'>Contact Us</a></li>";
        if (isset($customerId)) {
            echo "<li> <a href='/cart' id='cart-link'> 
                            <i class='fa-solid fa-cart-shopping'></i>
                            <div class='cart-count' id='cart-count' style='position: absolute;top: 0;right: 0'>
                                $cart_count
                            </div>
                          </a> </li>";
            CustomerProfileDropdown::render(customerId: $customerId, id: 1);
        } else {
            echo "<li><a href='/login?redirect_url=$current_url' class='btn btn--thin btn--white login-btn'>Login</a></li>";
        }

        echo "</ul>
    </nav>";
    }
}