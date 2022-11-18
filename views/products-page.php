<?php

use app\components\Table;

$items = [
    [
        "Item Code" => 1,
        "Name" => "Tyre",
        "Brand" => "\$ 23",
        "Category" => "Spare part",
        "Unit price" => "3000",
        "Quantity" => "100",
        "Description" => "A device used for car transportation",
    ],
    [
        "Item Code" => 2,
        "Name" => "Tyre",
        "Brand" => "\$ 23",
        "Category" => "Spare part",
        "Unit price" => "3000",
        "Quantity" => "100",
        "Description" => "A device used for car transportation",
    ],
    [
        "Item Code" => 3,
        "Name" => "Tyre",
        "Brand" => "\$ 23",
        "Category" => "Spare part",
        "Unit price" => "3000",
        "Quantity" => "100",
        "Description" => "A device used for car transportation",
    ],
    [
        "Item Code" => 4,
        "Name" => "Tyre",
        "Brand" => "\$ 23",
        "Category" => "Spare part",
        "Unit price" => "3000",
        "Quantity" => "100",
        "Description" => "A device used for car transportation",
    ],
    [
        "Item Code" => 5,
        "Name" => "Tyre",
        "Brand" => "\$ 23",
        "Category" => "Spare part",
        "Unit price" => "3000",
        "Quantity" => "100",
        "Description" => "A device used for car transportation",
    ],
];

$columns = ["Item code", "Name", "Brand", "Category", "Unit price", "Quantity", "Description"];

Table::render(items: $items, columns: $columns);

