

<?php
use app\components\FormItem;

/**
 * @var array $errors
 * @var array $body
 */

$hasErrors = isset($errors) && !empty($errors);
$hasNameError = $hasErrors && isset($errors['name']);
$hasCategoryError = $hasErrors && isset($errors['category']);
$hasProductTypeError = $hasErrors && isset($errors['product_type']);
$hasBrandIdError = $hasErrors && isset($errors['brand_id']);
$hasModelIdError = $hasErrors && isset($errors['model_id']);
$hasDescriptionError = $hasErrors && isset($errors['description']);
$hasAmountError = $hasErrors && isset($errors['amount']);
$hasPriceError = $hasErrors && isset($errors['unit_price']);
$hasSupplierIdError = $hasErrors && isset($errors['supplier_id']);
$hasDateTimeError = $hasErrors && isset($errors['date_time']);


?>

<div class="stock-manager-add-customer">
    <form action="/stock-manager-dashboard/products/add-products" method="post" class="stock-manager-add-products-form" enctype="multipart/form-data">
        <h2>Product Details</h2>
	    <div class="stock-manager-add-products-form__product">
            <?php
            FormItem::render(
                id: "name",
                label: "Product Name",
                name: "name",
                hasError: $hasNameError,
                error: $hasNameError ? $errors['name'] : "",

            );

            FormItem::render(
                id: "category",
                label: "Category",
                name: "category",
                hasError: $hasCategoryError,
                error: $hasCategoryError ? $errors['category'] : "",

            );

            FormItem::render(
                id: "product_type",
                label: "Product Type",
                name: "product_type",
                hasError: $hasProductTypeError,
                error: $hasProductTypeError ? $errors['product_type'] : "",

            );
            FormItem::render(
                id: "brand_id",
                label: "Brand",
                name: "brand_id",
                hasError: $hasBrandIdError,
                error: $hasBrandIdError ? $errors['brand_id'] : "",

            );
            FormItem::render(
                id: "model_id",
                label: "Model",
                name: "model_id",
                hasError: $hasModelIdError,
                error: $hasModelIdError ? $errors['model_id'] : "",

            );
            FormItem::render(
                id: "description",
                label: "Description",
                name: "description",
                hasError: $hasDescriptionError,
                error: $hasDescriptionError ? $errors['description'] : "",

            );
            ?>
        </div>
		<br>
        <div class="stock-manager-add-products-form__order">
	        <h2>Order Details</h2>
			<?php
			FormItem::render(
				id: "amount",
				label: "Stock Quantity",
				name: "amount",
                hasError: $hasAmountError,
                error: $hasAmountError ? $errors['amount'] : "",

			);
			FormItem::render(
				id: "unit_price",
				label: "Unit Price",
				name: "unit_price",
                hasError: $hasPriceError,
                error: $hasPriceError ? $errors['unit_price'] : "",

			);
			FormItem::render(
				id: "supplier_id",
				label: "Supplier",
				name: "supplier_id",
                hasError: $hasSupplierIdError,
                error: $hasSupplierIdError ? $errors['supplier_id'] : "",

			);
			FormItem::render(
				id: "date_time",
				label: "Recieved Date",
				name: "date_time",
                hasError: $hasDateTimeError,
                error: $hasDateTimeError ? $errors['date_time'] : "",

			);

			?>
        </div>


        <button class="btn btn--danger btn--block">
            Reset
        </button>

        <button class="btn btn--success btn--block">
            Add product
        </button>

    </form>
</div>