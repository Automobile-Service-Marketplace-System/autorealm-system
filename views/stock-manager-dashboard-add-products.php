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

$body = $body ?? [];
$hasErrors = isset($errors) && !empty($errors);
$hasNameError = $hasErrors && isset($errors['name']);
$hasCategoryError = $hasErrors && isset($errors['category']);
$hasProductTypeError = $hasErrors && isset($errors['product_type']);
$hasBrandIdError = $hasErrors && isset($errors['brand_id']);
$hasModelIdError = $hasErrors && isset($errors['model_id']);
$hasDescriptionError = $hasErrors && isset($errors['description']);
$hasSellingPriceError = $hasErrors && isset($errors['selling_price']);
$hasPriceError = $hasErrors && isset($errors['unit_price']);
$hasQuantityError = $hasErrors && isset($errors['quantity']);
$hasSupplierIdError = $hasErrors && isset($errors['supplier_id']);
$hasDateTimeError = $hasErrors && isset($errors['date_time']);
$hasPriceError = $hasErrors && isset($errors['price']);
$hasImageError = $hasErrors && isset($errors['image']);
$hasUnitPriceError = $hasErrors && isset($errors['unit_price']);
$hasLowQuantityError = $hasErrors && isset($errors['low_quantity']);
$hasMediumQuantityError = $hasErrors && isset($errors['medium_quantity']);

?>

<div class="stock-manager-add-product-form">
    <form action="/products/add" method="post" class="stock-manager-add-products-form"
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
                value: $body['name'] ?? "",
            );

            FormSelectItem::render(
                id: "category_id",
                label: "Category",
                name: "category_id",
                hasError: $hasCategoryError,
                error: $hasCategoryError ? $errors['category'] : "",
                value: $body['category_id'] ?? "",
                options: $categories

            );

            FormSelectItem::render(
                id: "product_type",
                label: "Product Type",
                name: "product_type",
                hasError: $hasProductTypeError,
                error: $hasProductTypeError ? $errors['product_type'] : "",
                value: $body['product_type'] ?? "",
                options: [
                    "spare part" => "Spare Part",
                    "accessory" => "Accessory"
                ],
            );

            FormSelectItem::render(
                id: "brand_id",
                label: "Brand",
                name: "brand_id",
                hasError: $hasBrandIdError,
                error: $hasBrandIdError ? $errors['brand'] : "",
                value: $body['brand_id'] ?? "",
                options: $brands

            );
            FormSelectItem::render(
                id: "model_id",
                label: "Model",
                name: "model_id",
                hasError: $hasModelIdError,
                error: $hasModelIdError ? $errors['model'] : "",
                value: $body['model_id'] ?? "",
                options: $models
            );

            FormItem::render(
                id: "selling_price",
                label: "Selling Price",
                name: "selling_price",
                type: "number",
                hasError: $hasSellingPriceError,
                error: $hasSellingPriceError ? $errors['selling_price'] : "",
                value: $body['selling_price'] ?? "",
                additionalAttributes: "step='0.01' min='0.01'"
            );

            FormItem::render(
                id: "image",
                label: "Images",
                name: "image[]",
                type: "file",
                hasError: $hasImageError,
                error: $hasImageError ? $errors['image'] : "",
                value: $body['image'] ?? "",
                additionalAttributes: "accept='image/*' multiple")

            ?>
            <div id="description-input">
                <?php
                FormTextareaItem::render(
                    id: "description",
                    label: "Description",
                    name: "description",
                    hasError: $hasDescriptionError,
                    error: $hasDescriptionError ? $errors['description'] : "",
                    value: $body['description'] ?? "",
                    rows: 4,
                );
                ?>
            </div>
        </div>
        <br>
        <h2 class="product-form-subheading">Stock keeping Details</h2>
        <div class="stock-manager-add-products-form__product">
            <?php
            FormItem::render(
                id: "low_quantity",
                label: "Considered as low quantity when quantity is less than",
                name: "low_quantity",
                type: "number",
                hasError: $hasLowQuantityError,
                error: $hasLowQuantityError ? $errors['low_quantity'] : "",
                value: $body['low_quantity'] ?? "",
                additionalAttributes: "min='0'"
            );

            FormItem::render(
                id: "medium_quantity",
                label: "Considered as medium quantity when quantity is less than",
                name: "medium_quantity",
                type: "number",
                hasError: $hasMediumQuantityError,
                error: $hasMediumQuantityError ? $errors['medium_quantity'] : "",
                value: $body['medium_quantity'] ?? "",
                additionalAttributes: "min='0'"
            ); ?>
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
                hasError: $hasQuantityError,
                error: $hasQuantityError ? $errors['quantity'] : "",
                value: $body['quantity'] ?? "",
                additionalAttributes: "min='1' step='1'"
            );
            FormItem::render(
                id: "unit_price",
                label: "Unit Price",
                name: "unit_price",
                type: "number",
                hasError: $hasUnitPriceError,
                error: $hasUnitPriceError ? $errors['unit_price'] : "",
                value: $body['unit_price'] ?? "",
                additionalAttributes: "step='0.01' min='0.01'"

            );
            FormSelectItem::render(
                id: "supplier_id",
                label: "Supplier",
                name: "supplier_id",
                hasError: $hasSupplierIdError,
                error: $hasSupplierIdError ? $errors['supplier_id'] : "",
                value: $body['supplier_id'] ?? "",
                options: $suppliers
            );
            FormItem::render(
                id: "date_time",
                label: "Received Date",
                name: "date_time",
                type: "date",
                hasError: $hasDateTimeError,
                error: $hasDateTimeError ? $errors['date_time'] : "",
                value: $body['date_time'] ?? "",
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