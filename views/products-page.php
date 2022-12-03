<?php

/**
 * @var array $products
 */

use app\components\Table;

//$items = [
//    [
//        "ID" => 1,
//        "Name" => "Tyre",
//        "Brand" => "\$ 23",
//        "Category" => "Spare part",
//        "Unit price" => "3000",
//        "Quantity" => "100",
//        "Description" => "A device used for car transportation",
//        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
//                            <button class='btn btn--rounded btn--warning'>
//                                <i class='fa-solid fa-pencil'></i>
//                            </button>
//                            <button class='btn btn--rounded btn--danger'>
//                                <i class='fa-solid fa-trash'></i>
//                            </button>
//                      </div>"
//    ],
//    [
//        "ID" => 1,
//        "Name" => "Tyre",
//        "Brand" => "\$ 23",
//        "Category" => "Spare part",
//        "Unit price" => "3000",
//        "Quantity" => "100",
//        "Description" => "A device used for car transportation",
//        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
//                            <button class='btn btn--rounded btn--warning'>
//                                <i class='fa-solid fa-pencil'></i>
//                            </button>
//                            <button class='btn btn--rounded btn--danger'>
//                                <i class='fa-solid fa-trash'></i>
//                            </button>
//                      </div>"
//    ], [
//        "ID" => 1,
//        "Name" => "Tyre",
//        "Brand" => "\$ 23",
//        "Category" => "Spare part",
//        "Unit price" => "3000",
//        "Quantity" => "100",
//        "Description" => "A device used for car transportation",
//        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
//                            <button class='btn btn--rounded btn--warning'>
//                                <i class='fa-solid fa-pencil'></i>
//                            </button>
//                            <button class='btn btn--rounded btn--danger'>
//                                <i class='fa-solid fa-trash'></i>
//                            </button>
//                      </div>"
//    ], [
//        "ID" => 1000,
//        "Name" => "Tyre",
//        "Brand" => "\$ 23",
//        "Category" => "Spare part",
//        "Unit price" => "3000",
//        "Quantity" => "100",
//        "Description" => "A device used for car transportation",
//        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
//                            <button class='btn btn--rounded btn--warning'>
//                                <i class='fa-solid fa-pencil'></i>
//                            </button>
//                            <button class='btn btn--rounded btn--danger'>
//                                <i class='fa-solid fa-trash'></i>
//                            </button>
//                      </div>"
//    ], [
//        "ID" => 1000,
//        "Name" => "Tyre",
//        "Brand" => "\$ 23",
//        "Category" => "Spare part",
//        "Unit price" => "3000",
//        "Quantity" => "100",
//        "Description" => "A device used for car transportation",
//        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
//                            <button class='btn btn--rounded btn--warning'>
//                                <i class='fa-solid fa-pencil'></i>
//                            </button>
//                            <button class='btn btn--rounded btn--danger'>
//                                <i class='fa-solid fa-trash'></i>
//                            </button>
//                      </div>"
//    ], [
//        "ID" => 1000,
//        "Name" => "Tyre",
//        "Brand" => "\$ 23",
//        "Category" => "Spare part",
//        "Unit price" => "3000",
//        "Quantity" => "100",
//        "Description" => "A device used for car transportation",
//        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
//                            <button class='btn btn--rounded btn--warning'>
//                                <i class='fa-solid fa-pencil'></i>
//                            </button>
//                            <button class='btn btn--rounded btn--danger'>
//                                <i class='fa-solid fa-trash'></i>
//                            </button>
//                      </div>"
//    ], [
//        "ID" => 1000,
//        "Name" => "Tyre",
//        "Brand" => "\$ 23",
//        "Category" => "Spare part",
//        "Unit price" => "3000",
//        "Quantity" => "100",
//        "Description" => "A device used for car transportation",
//        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
//                            <button class='btn btn--rounded btn--warning'>
//                                <i class='fa-solid fa-pencil'></i>
//                            </button>
//                            <button class='btn btn--rounded btn--danger'>
//                                <i class='fa-solid fa-trash'></i>
//                            </button>
//                      </div>"
//    ], [
//        "ID" => 1000,
//        "Name" => "Tyre",
//        "Brand" => "\$ 23",
//        "Category" => "Spare part",
//        "Unit price" => "3000",
//        "Quantity" => "100",
//        "Description" => "A device used for car transportation",
//        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
//                            <button class='btn btn--rounded btn--warning'>
//                                <i class='fa-solid fa-pencil'></i>
//                            </button>
//                            <button class='btn btn--rounded btn--danger'>
//                                <i class='fa-solid fa-trash'></i>
//                            </button>
//                      </div>"
//    ],
//];

//$columns = ["ID", "Name", "Brand", "Category", "Unit price", "Quantity", "Description", ""];

//Table::render(items: $items, columns: $columns, keyColumns: ["ID", "Actions"]);

//echo "<pre>";
//print_r($products);
//echo "</pre>";

$columns = [];
foreach ($products[0] as $key => $value) {
    $columns[] = $key;
}

//echo "<pre>";
//print_r($columns);
//echo "</pre>";

Table::render(items: $products, columns: $columns, keyColumns: ["ID", "Actions"]);


