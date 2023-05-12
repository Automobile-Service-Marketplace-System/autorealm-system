<?php
/**
 * @var array | null $product
 * @var array | null $relatedProducts
 * @var bool $is_authenticated
 * @var bool $alreadyReviewed
 * @var int $customerId
 */

use app\components\ProductCard;

if ($product) {
    try {
        $image = $product['Image'] === 'null' ? "/images/placeholders/product-image-placeholder.jpg" : json_decode($product['Image'], false, 512, JSON_THROW_ON_ERROR)[0];
    } catch (JsonException $e) {
        $image = "/images/placeholders/product-image-placeholder.jpg";
    }

    $price = number_format($product['Price'], 2, '.', ',');
    $stockInfo = $product['Quantity'] == 0 ? "<span class='danger'>Out of stock</span>" : "<span class='success'>In stock</span>";
}

$reviews = [[
    "Name" => "John Doe",
    "Rating" => 4,
    "Review" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.",
    "Date" => "9 months ago",
    "Image" => "/images/placeholders/profile.webp"
], [
    "Name" => "John Doe",
    "Rating" => 4,
    "Review" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.",
    "Date" => "9 months ago",
    "Image" => "/images/placeholders/profile.webp"
], [
    "Name" => "John Doe",
    "Rating" => 4,
    "Review" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.",
    "Date" => "9 months ago",
    "Image" => "/images/placeholders/profile.webp"
], [
    "Name" => "John Doe",
    "Rating" => 4,
    "Review" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.",
    "Date" => "9 months ago",
    "Image" => "/images/placeholders/profile.webp"
], [
    "Name" => "John Doe",
    "Rating" => 4,
    "Review" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.",
    "Date" => "9 months ago",
    "Image" => "/images/placeholders/profile.webp"
], [
    "Name" => "John Doe",
    "Rating" => 4,
    "Review" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.",
    "Date" => "9 months ago",
    "Image" => "/images/placeholders/profile.webp"
]];

?>

<?php if ($product) { ?>
    <section class="product-container container">
        <div class="product-container__image">
            <img src="<?= $image ?>" alt="<?= $product['Name'] ?>">
        </div>
        <div class="product-container__info">
            <h1 id="product-name"><?= $product['Name'] ?></h1>
            <img src="<?= $image ?>" alt="<?= $product['Name'] ?>" class="my-4">
            <p class="product-container__price">
                Rs. <?= $price ?>
            </p>
            <p><?= $product['Description'] ?></p>
            <p class="mt-2"><?= $stockInfo ?></p>
            <div class="flex  items-center gap-8 mt-2">
                <button class="btn btn--danger">Buy now</button>
                <button class="btn btn--dark-blue">
                    <i class="fa-solid fa-cart-plus"></i>
                    Add to cart
                </button>
            </div>
        </div>
    </section>
    <section class="container" id="reviews-parent">
        <h2 style="text-align: left;font-size: 1.5rem;font-weight: bold" class="mt-8 mb-4">Reviews</h2>
        <?php if ($is_authenticated && !$alreadyReviewed) { ?>
            <button class="btn btn--dark-blue mb-8" id="write-review-button">
                <i class="fa-solid fa-pen"></i>
                Write a review
            </button>
        <?php } ?>
        <div class="reviews reviews--loading" data-customerid="<?= $customerId ?>">
            <i class="fa-solid fa-spinner"></i>
        </div>
        <div class="dashboard-pagination-container">
        </div>
    </section>
<?php } ?>

<?php if ($relatedProducts) { ?>
    <section class="container">
        <h2 style="text-align: left;font-size: 1.5rem;font-weight: bold">Related to this</h2>
        <div class="products-gallery">
            <?php
            foreach ($relatedProducts as $relatedProduct) {
                ProductCard::render(product: $relatedProduct, is_authenticated: $is_authenticated);
            }
            ?>
        </div>
    </section>
<?php } ?>