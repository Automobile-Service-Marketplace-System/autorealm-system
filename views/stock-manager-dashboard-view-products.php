<?php

/**
 * @var array $products
 * @var array $brands
 * @var array $categories
 * @var array $models
 */
\app\utils\DevOnly::prettyEcho($products);
use app\components\Table;


$columns = ["ID", "Name", "Category", "Model", "Brand", "Price", "Quantity", "Actions"];

$items = [];
foreach ($products as $product) {
    $quantityColor = $product["Quantity"] > 20 ? "success" : ($product["Quantity"] > 10 ? "warning" : "danger");
    $quantityElement = "<p class='product-quantity'>  <span class='status status--$quantityColor'></span>{$product["Quantity"]}</p>";
    $items[] = [
        "ID" => $product["ID"],
        "Name" => $product["Name"],
        "Category" => $product["Category"],
        "Model" => $product["Model"],
        "Brand" => $product["Brand"],
        "Price" => $product["Price (LKR)"],
        "Quantity" => $quantityElement,
        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'
                                data-productId='{$product["ID"]}'              
                                data-categoryId='{$product["CategoryID"]}' 
                                data-brandId='{$product["BrandID"]}' 
                                data-modelId='{$product["ModelID"]}' 
                                data-image='{$product["Image"]}' 
                                data-description='{$product["Description"]}'>
                            <button class='btn btn--rounded btn--info restock-product-btn'>
                                <i class='fa-solid fa-cart-shopping'></i>
                            </button>
                            <button class='btn btn--rounded btn--warning update-product-btn'>
                                        <i class='fa-solid fa-pencil'></i>
                            </button>
                            <button class='btn btn--rounded btn--danger delete-product-btn'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                      </div>"
    ];
}
?>

<div class="stock-manager-add-button-set-product-page">


        <button class="btn btn--rounded pagination-item btn--white" id="add-model-btn" style="margin-right: 1rem">
            <i class="fa-solid fa-m"></i>
        </button>

        <button class="btn btn--rounded pagination-item btn--white" id="add-brand-btn" style="margin-right: 1rem">
            <i class="fa-solid fa-b"></i>
        </button>

    <div class="add-button">
        <a class="btn" href="products/add">
            <i class="fa-solid fa-plus"></i>
            Add Products</a>
    </div>


</div>

<div class="product-filters">
    <div class="product-search">
        <input type="text" placeholder="Search Product by Name">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>

    <div class="product-filter--select ">
        <select name="category" id="category-filter">
            <option value="0">All Categories</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?= $category["category_id"] ?>"><?= $category["name"] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<?php
Table::render(items: $items, columns: $columns, keyColumns: ["ID", "Actions"]);
?>
 <script>
    <?php
    try {
        $categoriesString = json_encode($categories, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        $categoriesString = "[]";
    }

    try {
        $brandsString = json_encode($brands, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        $brandsString = "[]";
    }

    try {
        $modelsString = json_encode($models, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        $modelsString = "[]";
    }
    ?>
    const categories = <?= $categoriesString ?>;
    const brands = <?= $brandsString ?>;
    const models = <?= $modelsString ?>;
    localStorage.setItem("categories", JSON.stringify(categories));
    localStorage.setItem("brands", JSON.stringify(brands));
    localStorage.setItem("models", JSON.stringify(models));
</script>