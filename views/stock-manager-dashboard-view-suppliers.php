<?php

/**
 * @var array $suppliers
 */

use app\components\Table;

//var_dump($suppliers);

$columns = ["ID", "Name", "Address","Sales Manager","Contact No", "Email", "Actions" ];

$items =[];


foreach($suppliers as $supplier){
    $items[] = [
        "ID" => $supplier["ID"],
        "Name" => $supplier["Name"],
        "Address" => $supplier["Address"],
        "Sales Manager" => $supplier["Sales Manager"],
        "Contact No" => $supplier["Contact No"],
        "Email" => $supplier["Email"],
        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                            <a href='' class='btn btn--rounded btn--warning'>
                                <i class='fa-solid fa-pencil'></i>
                            </a>
                            <button class='btn btn--rounded btn--danger'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                      </div>"
    ];
}


Table::render(items: $items, columns: $columns, keyColumns: ["ID", "Actions"]);

?>