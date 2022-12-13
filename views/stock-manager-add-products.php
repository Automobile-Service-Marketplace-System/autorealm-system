

<?php
use app\components\FormItem;

/**
 * @var array $errors
 * @var array $body
 */

//$hasErrors = isset($errors) && !empty($errors);
//$hasEmailError = $hasErrors && isset($errors['email']);
//$hasNameError = $hasErrors && isset($errors['name']);
//$hasImageError = $hasErrors && isset($errors['image']);
//$hasContactNoError = $hasErrors && isset($errors['contact_no']);
//$hasAddressError = $hasErrors && isset($errors['address']);
//$hasPasswordError = $hasErrors && isset($errors['password']);


?>

<div class="stock-manager-add-customer">
    <form action="/stock-manager-dashboard/products/add-products" method="post" class="stock-manager-add-products-form" enctype="multipart/form-data">
        <h2>Product Details</h2>
	    <div class="stock-manager-add-products-form__product">
            <?php
            FormItem::render(
                id: "name",
                label: "Product Name",
                name: "name"

            );

            FormItem::render(
                id: "category",
                label: "Category",
                name: "category"

            );

            FormItem::render(
                id: "product_type",
                label: "Product Type",
                name: "product_type"

            );
            FormItem::render(
                id: "brand_id",
                label: "Brand",
                name: "brand_id"

            );
            FormItem::render(
                id: "model_id",
                label: "Model",
                name: "model_id"

            );
            FormItem::render(
                id: "description",
                label: "Description",
                name: "description"

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
				name: "amount"

			);
			FormItem::render(
				id: "unit_price",
				label: "Unit Price",
				name: "unit_price"

			);
			FormItem::render(
				id: "supplier_id",
				label: "Supplier",
				name: "supplier_id"

			);
			FormItem::render(
				id: "date_time",
				label: "Recieved Date",
				name: "date_time"

			);

			?>
        </div>


        <button class="btn btn--danger btn--block">
            Reset
        </button>

        <button class="btn btn--success btn--block">
            Create an account
        </button>

    </form>
</div>