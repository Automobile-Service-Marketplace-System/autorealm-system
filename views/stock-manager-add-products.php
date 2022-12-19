<?php

use app\components\FormItem;
use app\components\FormTextareaItem;
use app\components\FormSelectItem;

/**
 * @var array $errors
 * @var array $body
 * @var array $models
 * @var array $brands
 * @var array $categories
 * @var array $suppliers
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
$hasPriceError = $hasErrors && isset($errors['price'])


?>

<div class="stock-manager-add-product-form">
    <form action="/stock-manager-dashboard/products/add-products" method="post" class="stock-manager-add-products-form"
          enctype="multipart/form-data">
        <h2 class="product-form-subheading">Product Details</h2>
        <div class="stock-manager-add-products-form__product">
            <?php
            FormItem::render(
                id: "name",
                label: "Product Name",
                name: "name",
                hasError: $hasNameError,
                error: $hasNameError ? $errors['name'] : "",

            );

            FormSelectItem::render(
                id: "category_id",
                label: "Category",
                name: "category_id",
                hasError: $hasCategoryError,
                error: $hasCategoryError ? $errors['category'] : "",
                value: "1",
                options: $categories

            );

            FormSelectItem::render(
                id: "product_type",
                label: "Product Type",
                name: "product_type",
                hasError: $hasProductTypeError,
                error: $hasProductTypeError ? $errors['product_type'] : "",
                options: [
                    "spare part" => "Spare Part",
                    "accessory" => "Accessory"
                ]
            );

            FormSelectItem::render(
                id: "brand_id",
                label: "Brand",
                name: "brand_id",
                hasError: $hasBrandIdError,
                error: $hasBrandIdError ? $errors['brand'] : "",
                value: "1",
                options: $brands

            );
            FormSelectItem::render(
                id: "model_id",
                label: "Model",
                name: "model_id",
                hasError: $hasModelIdError,
                error: $hasModelIdError ? $errors['model'] : "",
                value: "1",
                options: $models
            );

            FormItem::render(
                id: "selling_price",
                label: "Selling Price",
                name: "selling_price",
                type: "number",
                hasError: $hasNameError,
                error: $hasNameError ? $errors['name'] : "",
                additionalAttributes: "step='0.01' min='0.01'"
            );

            ?>
            <div id="description-input">
                <?php
                FormTextareaItem::render(
                    id: "description",
                    label: "Description",
                    name: "description",
                    hasError: $hasDescriptionError,
                    error: $hasDescriptionError ? $errors['description'] : "",
                    rows: 4,
                );
                ?>
            </div>
        </div>
        <br>
        <h2 class="order-details-heading product-form-subheading">Order Details</h2>
        <div class="stock-manager-add-products-form__order">

            <?php
            FormItem::render(
                id: "quantity",
                label: "Stock Quantity",
                name: "quantity",
                type: "number",
                hasError: $hasAmountError,
                error: $hasAmountError ? $errors['amount'] : "",
                additionalAttributes: "min='1' step='1'"
            );
            FormItem::render(
                id: "unit_price",
                label: "Unit Price",
                name: "unit_price",
                type: "number",
                hasError: $hasPriceError,
                error: $hasPriceError ? $errors['unit_price'] : "",
                additionalAttributes: "step='0.01' min='0.01'"

            );
            FormSelectItem::render(
                id: "supplier_id",
                label: "Supplier",
                name: "supplier_id",
                hasError: $hasSupplierIdError,
                error: $hasSupplierIdError ? $errors['supplier_id'] : "",
                value: "1",
                options: $suppliers
            );
            FormItem::render(
                id: "date_time",
                label: "Received Date",
                name: "date_time",
                type: "date",
                hasError: $hasDateTimeError,
                error: $hasDateTimeError ? $errors['date_time'] : "",
            );

            ?>
        </div>

        <div class="stock-manager-btn">
            <button class="btn btn--danger btn--block" type="reset">
                Reset
            </button>

            <button class="btn btn--block" type="button" id="add-product-btn">
                Add product
            </button>
        </div>

    </form>
</div>