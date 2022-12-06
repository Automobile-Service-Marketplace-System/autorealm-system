
<?php

/**
 * @var array $products
 */

use app\components\Table;


$columns = [];
foreach ($products[0] as $key => $value) {
    $columns[] = $key;
}

$columns[] = "Actions";


$items = [];
foreach ($products as $product) {
    $items[] = [
        "ID" => $product["ID"],
        "Name" => $product["Name"],
        "Category" => $product["Category"],
        "Model" => $product["Model"],
        "Brand" => $product["Brand"],
        "Price" => $product["Price (LKR)"],
        "Quantity" => $product["Quantity"],
        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                            <button class='btn btn--rounded btn--warning'>
                                <i class='fa-solid fa-pencil'></i>
                            </button>
                            <button class='btn btn--rounded btn--danger'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                      </div>"


    ];
}


Table::render(items: $items, columns: $columns, keyColumns: ["ID","Actions"]);

