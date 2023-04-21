<?php

/**
 * @var array $suppliers
 */

use app\components\Table;

// \app\utils\DevOnly::prettyEcho($suppliers);

$columns = ["ID", "Name", "Address", "Sales Manager", "Last Purchase Date", "Last Supply Amount", "Email", "Actions"];

$items = [];


foreach ($suppliers as $supplier) {
    $items[] = [
        "ID" => $supplier["ID"],
        "Name" => $supplier["Name"],
        "Address" => $supplier["Address"],
        "Sales Manager" => $supplier["Sales Manager"],
        "Last Purchase Date" => $supplier["Last Purchase Date"] ?? "N/A",
        "Last Supply Amount" => $supplier["Last Supply Amount"] ?? "N/A",
        "Email" => $supplier["Email"],
        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'
                                data-supplierId='{$supplier["ID"]}'
                                data-supplierName='{$supplier["Name"]}'
                                data-address='{$supplier["Address"]}'
                                data-salesManager='{$supplier["Sales Manager"]}'
                                data-email='{$supplier["Email"]}'
                                data-registrationNo='{$supplier["Registration No"]}'>
                            <button class='btn btn--rounded btn--warning update-supplier-button'>   
                                <i class='fa-solid fa-pencil'></i>
                            </button>
                            <button class='btn btn--rounded btn--danger delete-supplier-btn'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                      </div>"
    ];
}

?>

    <div class="stock-manager-add-button-set">
        <div class="add-button">
            <button class="btn" id="add-supplier-btn">
                <i class="fa-solid fa-plus"></i>
                Add Suppliers
            </button>
        </div>

    </div>

<?php

Table::render(items: $items, columns: $columns, keyColumns: ["ID", "Actions"]);

?>