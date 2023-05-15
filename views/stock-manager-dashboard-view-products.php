<?php

/**
 * @var array $products
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
 *
 */
//\app\utils\DevOnly::prettyEcho($products);
//var_dump("total => ".$total);
use app\components\Table;

//for the table
$columns = ["ID", "Name", "Category", "Model", "Brand", "Price", "Quantity", "Type", "Actions"];

$items = [];

//to get the total count of products
$noOfProducts = count($products);
$startNo = ($page - 1) * $limit + 1;
$endNo = $startNo + $noOfProducts - 1;

//to insert the rows to the table
foreach ($products as $product) {

    //setting indicator colors for quantity
    $quantityColor = $product["Quantity"] > $product["medium_quantity"] ? "success" : ($product["Quantity"] > $product["low_quantity"] ? "warning" : "danger");
    $quantityElement = "<p class='product-quantity'>  <span class='status status--$quantityColor'></span>{$product["Quantity"]}</p>";

    $items[] = [
        "ID" => $product["ID"],
        "Name" => $product["Name"],
        "Category" => $product["Category"],
        "Model" => $product["Model"],
        "Brand" => $product["Brand"],
        "Price" => $product["Price (LKR)"],
        "Quantity" => $quantityElement,
        "Type" => $product["Type"],
        //dataset values are used to pass data to the modal
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


<div class="product-count-and-actions">
<!--    show the total and current count of products-->
    <div class="product-table-count">
        <p>
            Showing <?= $startNo ?> - <?= $endNo ?> of <?php echo $total; ?> products

            <!--            Showing 25 out of 100 products-->
        </p>
    </div>


    <div class="stock-manager-add-button-set-product-page">

        <button class="btn btn--rounded pagination-item btn--white" id="add-model-btn" style="margin-right: 1rem">
            <i class="fa-solid fa-m"></i>
        </button>

        <button class="btn btn--rounded pagination-item btn--white" id="add-brand-btn" style="margin-right: 1rem">
            <i class="fa-solid fa-b"></i>
        </button>

<!--        add button-->
        <div class="add-button">
            <a class="btn" href="products/add">
                <i class="fa-solid fa-plus"></i>
                Add Products</a>
        </div>


    </div>

</div>

<div class="filters" id="dashboard-product-filters">
    <div class="filters__actions">
        <div class="filters__dropdown-trigger">
            Search & Filter
            <i class="fa-solid fa-chevron-right"></i>
        </div>
    </div>

    <form>

        <div class="filters__dropdown">

<!--            product search input-->
            <div class="form-item form-item--icon-right form-item--no-label filters__search">
                <input type="text" placeholder="Search Product by Name" id="dashboard-product-search"
                       name="q" <?php if ($searchTerm) echo "value='$searchTerm'" ?>>
                <i class="fa-solid fa-magnifying-glass"></i>
            </div>

<!--            product filters-->
            <p>Filter products by</p>
            <div class="filters__dropdown-content">
                <div class="form-item">
                    <input list="categories" name="category_name" id="category-filter"
                           placeholder="Category">
                    <datalist id="categories">
                        <option data-value="all" value="all" selected>All Categories</option>
<!--                        inserting options for categories-->
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category["name"] ?>"
                                    data-value="<?= $category["category_id"] ?>">
                                <?= $category["name"] ?>
                            </option>
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="form-item">
                    <input list="brands" name="brand_name" id="brand-filter"
                           placeholder="Brand">
                    <datalist id="brands">
                        <option data-value="all" value="all" selected>All Brands</option>
<!--                        inserting options for brands-->
                        <?php foreach ($brands as $brand) : ?>
                            <option value="<?= $brand["brand_name"] ?>"
                                    data-value="<?= $brand["brand_id"] ?>"><?= $brand["brand_name"] ?></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="form-item">
                    <select name="product_type" id="type-filter" class="product-filter--select">
                        <option value="all">All Types</option>
                        <option value="spare part" <?php if ($productType == 'spare part') echo 'selected'; ?>>Spare
                            Part
                        </option>
                        <option value="accessory" <?php if ($productType == 'accessory') echo 'selected'; ?>>Accessory
                        </option>
                    </select>
                </div>


                <div class="form-item">
                    <select name="quantity" id="quantity-filter" class="product-filter--select ">
                        <option value="all" <?php if ($quantityLevel == 'all') echo 'selected'; ?>>All Quantities
                        </option>
                        <option value="low" <?php if ($quantityLevel == 'low') echo 'selected'; ?>>🔴 Low Quantity
                        </option>
                        <option value="medium" <?php if ($quantityLevel == 'medium') echo 'selected'; ?>>🟡 Medium
                            Quantity
                        </option>
                        <option value="high" <?php if ($quantityLevel == 'high') echo 'selected'; ?>>🟢 High Quantity
                        </option>
                    </select>
                </div>

                <div class="form-item">
                    <select name="status" id="status-filter" class="product-filter--select ">
                        <option value="active" <?php if ($status == 'active') echo 'selected'; ?>>Currently active
                            products
                        </option>
                        <option value="discontinued" <?php if ($status == 'discontinued') echo 'selected'; ?>>
                            Discontinued products
                        </option>
                    </select>
                </div>

            </div>
            <div class="filter-action-buttons">
                <button class="btn btn--text btn--danger btn--thin" id="clear-filters-btn" type="reset">Clear</button>
                <button class="btn btn--text btn--thin" id="apply-filters-btn">Submit</button>
            </div>
        </div>
    </form>

</div>

<!--show the table-->

<?php

//only then there are products
if ($products){
    Table::render(items: $items, columns: $columns, keyColumns: ["ID", "Actions"]);
?>

    <div class="dashboard-pagination-container">
        <?php

//        setting next and previous page buttons
        $hasNextPage = $page < ceil(num: $total / $limit);
        $hasNextPageClass = $hasNextPage ? "" : "dashboard-pagination-item--disabled";
        $hasNextPageHref = $hasNextPage ? "/products?q=$searchTerm&category_name=$categoryName&brand_name=$brandName&product_type=$productType&quantity=$quantityLevel&status=$status&page=" . ($page + 1) . "&limit=$limit" : "";
        $hasPreviousPage = $page > 1;
        $hasPreviousPageClass = $hasPreviousPage ? "" : "dashboard-pagination-item--disabled";
        $hasPreviousPageHref = $hasPreviousPage ? "/products?q=$searchTerm&category_name=$categoryName&brand_name=$brandName&product_type=$productType&quantity=$quantityLevel&status=$status&page=" . ($page - 1) . "&limit=$limit" : "";

        ?>
        <a class="dashboard-pagination-item <?= $hasPreviousPageClass ?>"
           href="<?= $hasPreviousPageHref ?>">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <?php
        //    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
        foreach (range(1, ceil($total / $limit)) as $i) {
            $isActive = $i === (float)$page ? "dashboard-pagination-item--active" : "";
            echo "<a class='dashboard-pagination-item $isActive' href='/products?q=$searchTerm&category_name=$categoryName&brand_name=$brandName&product_type=$productType&quantity=$quantityLevel&status=$status&page=$i&limit=$limit'>$i</a>";
        }
        ?>
        <a class="dashboard-pagination-item <?= $hasNextPageClass ?>" href="<?= $hasNextPageHref ?>">
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>


<?php   }else{ ?>
    <div class="stock-manager-no-items">
        <p>
            There are no products matching your search criteria.
        </p>
    </div>
<?php   } ?>



<!--to store the category and product -->
<script>
    <?php

//        getting the categories, brands and models and encode them to json
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

//    storing the categories, brands and models in local storage
    const categories = <?= $categoriesString ?>;
    const brands = <?= $brandsString ?>;
    const models = <?= $modelsString ?>;
    localStorage.setItem("categories", JSON.stringify(categories));
    localStorage.setItem("brands", JSON.stringify(brands));
    localStorage.setItem("models", JSON.stringify(models));


</script>