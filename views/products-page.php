<?php

use app\components\Table;

$items = [
    [
        "Item Code" => 1,
        "Name" => "Tyre",
        "Brand" => "\$ 23",
        "Category" => "",
        "Unit price" => "",
        "Quantity" => "",
        "Description" => "",
    ],
    [
        "id" => 2,
        "name" => "Engine",
        "price" => "\$ 400"
    ],
    [
        "id" => 3,
        "name" => "Breaks",
        "price" => "\$ 150"
    ],
    [
        "id" => 4,
        "name" => "Hood",
        "price" => "\$ 300"
    ],
];

$columns = ["id", "name", "price"];

Table::render(items: $items, columns: $columns);

