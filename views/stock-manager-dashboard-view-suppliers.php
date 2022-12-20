<?php

/**
 * @var array $suppliers
 */

use app\components\Table;

//var_dump($suppliers);

$columns = ["ID", "Name", "Address","Sales Manager","Last Purchase Date", "Last Supply Amount", "Email", "Actions" ];

$items =[];


foreach($suppliers as $supplier){
    $items[] = [
        "ID" => $supplier["ID"],
        "Name" => $supplier["Name"],
        "Address" => $supplier["Address"],
        "Sales Manager" => $supplier["Sales Manager"],
        "Last Purchase Date" => $supplier["Last Purchase Date"],
        "Last Supply Amount" => $supplier["Last Supply Amount"],
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

?>

    <div class="stock-manager-add-button-set">
        <div class="add-button">
            <a class="btn" href="products/add-suppliers">
                <i class="fa-solid fa-plus"></i>
                Add Suppliers</a>
        </div>

    </div>

<?php

Table::render(items: $items, columns: $columns, keyColumns: ["ID", "Actions"]);

?>