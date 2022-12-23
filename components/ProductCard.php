<?php

namespace app\components;

use JsonException;

class ProductCard
{

    /**
     * @param array $product
     * @param bool $is_authenticated
     * @return void
     */
    public static function render(array $product, bool $is_authenticated) :void {


        $isButtonDisabled = !$is_authenticated ? "disabled" : "";
        $buttonTitle = !$is_authenticated ? "Login to add to cart" : "Add to cart";
        try {
            $image = $product['Image'] === 'null' ? "/images/placeholders/product-image-placeholder.jpg" : json_decode($product['Image'], false, 512, JSON_THROW_ON_ERROR)[0];
        } catch (JsonException $e) {
            $image = "/images/placeholders/product-image-placeholder.jpg";
        }
        echo "<div class='product-card' id='product-{$product['ID']}'>
            <div class='product-card__header'>{$product['Name']}</div>
            <div class='product-card__body'>
                <img src='$image' alt='Product Image for {$product['Name']}'>
                <p>Rs. {$product["Price (LKR)"]}/=</p>
            </div>
            <div class='product-card__footer'>
                <a class='btn btn--danger btn--block' href='/products/view?id={$product['ID']}'>More info</a>
                <button class='btn btn--light-blue btn--square add-to-cart' title='$buttonTitle'  $isButtonDisabled data-productId='{$product['ID']}'>
                    <i class='fa-solid fa-cart-plus'></i>
                </button>
            </div>
        </div>";

    }

}