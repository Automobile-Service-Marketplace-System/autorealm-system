<?php
/**
 * @var  array $products
 * @var  bool $is_authenticated
 *
 * @var array $brands
 * @var array $categories
 * @var array $models
 *
 * @var  int $limit
 * @var  int $page
 * @var  int $total
 *
 * @var string $searchTerm
 * @var string $categoryName
 * @var string $brandName
 * @var string $productType
 * @var string $quantityLevel
 * @var string $status
 */

use app\components\ProductCard;


?>

<div class="filters" id="site-product-filters">
    <div class="filters__actions">
        <div class="filters__dropdown-trigger">
            Search & Filter
            <i class="fa-solid fa-chevron-right"></i>
        </div>
    </div>

    <form>

        <div class="filters__dropdown">
            <div class="form-item form-item--icon-right form-item--no-label filters__search">
                <input type="text" placeholder="Search Product by Name" id="dashboard-product-search" name="q">
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

            <p>Filter products by</p>
            <div class="filters__dropdown-content">

                <div class="site-price-range form-item">
                    <div class="site-price-range-input  form-item">
                        <input type="number" placeholder="Min" name="min" min=0 >
                    </div>
                    <p>
                        <span>Price</span>
                    </p>

                    <div class="site-price-range-input  form-item">
                        <input type="number" placeholder="Max" name="max" min=0>
                    </div>
                </div>


                <!---->
                <!--                <div class="stock-radio-group">-->
                <!--                    <div class="form-item--radio">-->
                <!--                        <label for="stock_type">In Stock</label>-->
                <!--                        <input type="radio" name="model_type" value="vehicle">-->
                <!--                    </div>-->
                <!--                    <div class="form-item--radio">-->
                <!--                        <label for="stock_type">Out of Stock</label>-->
                <!--                        <input type="radio" name="model_type" value="product" checked>-->
                <!--                    </div>-->
                <!---->
                <!--                </div>-->

                <div class="product-availability">
<!--                    <p>Product Availability : </p>-->
                </div>

                <div class="form-item">
<!--                    <select name="availability" id="product-stock_availability-filter">-->
<!--                        <option value="instock" selected>In Stock</option>-->
<!--                        <option value="outstock">Out of Stock</option>-->
<!--                        <option value="both">Both</option>-->
<!--                    </select>-->

                </div>

                <div class="form-item">
                    <input list="categories" name="category" id="category-filter"
                           placeholder="Category">
                    <datalist id="categories">
                        <option data-value="all" value="all" selected>All Categories</option>
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category["name"] ?>"
                                    data-value="<?= $category["category_id"] ?>">
                                <?= $category["name"] ?>
                            </option>
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="form-item">
                    <input list="brands" name="brand" id="brand-filter"
                           placeholder="Brand">
                    <datalist id="brands">
                        <option data-value="all" value="all" selected>All Brands</option>
                        <?php foreach ($brands as $brand) : ?>
                            <option value="<?= $brand["brand_name"] ?>"
                                    data-value="<?= $brand["brand_id"] ?>"><?= $brand["brand_name"] ?></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="form-item">
                    <select name="type" id="type-filter" class="product-filter--select">
                        <option value="all">All Types</option>
                        <option value="spare part">Spare Part</option>
                        <option value="accessory">Accessory</option>
                    </select>
                </div>


            </div>
            <div class="filter-action-buttons">
                <button class="btn btn--text btn--danger btn--thin" id="clear-filters-btn" type="reset">Clear</button>
                <button class="btn btn--text btn--dark-blue btn--thin " id="apply-filters-btn">Submit</button>
            </div>
        </div>
    </form>

</div>


<p class="product-count">
    Showing <?php echo $limit; ?> of <?php echo $total; ?> orders
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