
<?php

/**
 * @var array $products
 */

use app\components\Table;


$columns = ["ID", "Name", "Category", "Model", "Brand", "Price", "Quantity", "Actions" ];

$items = [];
foreach ($products as $product) {
    $quantityColor= $product["Quantity"]>20?"success":($product["Quantity"]>10?"warning":"danger");
    $quantityElement= "<p class='product-quantity'>  <span class='status status--$quantityColor'></span>{$product["Quantity"]}</p>";
    $items[] = [
        "ID" => $product["ID"],
        "Name" => $product["Name"],
        "Category" => $product["Category"],
        "Model" => $product["Model"],
        "Brand" => $product["Brand"],
        "Price" => $product["Price (LKR)"],
        "Quantity" => $quantityElement,
        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                            <a href='' class='btn btn--rounded btn--info'>
                                <i class='fa-solid fa-cart-shopping'></i>
                            
                            <a href='' class='btn btn--rounded btn--warning'>
                                <i class='fa-solid fa-pencil'></i>
                            </a>
                            <button class='btn btn--rounded btn--danger'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                      </div>"


    ];
}


Table::render(items: $items, columns: $columns, keyColumns: ["ID","Actions"]);

