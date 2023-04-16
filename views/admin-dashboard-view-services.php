
<?php

/**
 * @var array $services
 */

use app\components\Table;


$columns = ["Service Code", "Service Name", "Description", "Price","Action" ];

$items = [];
foreach ($services as $service) {
    $items[] = [
        "ID" => $service["ID"],
        "Name" => $service["Name"],
        "Description" => $service["Description"],
        "Price" => $service["Price"],
        "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem;' data-serviceid='{$service['ID']}'>
                        
                            <button class='btn btn--rounded btn--warning update-service-btn'>
                                <i class='fa-solid fa-pencil'></i>
                            </button>
                            <button class='btn btn--rounded btn--danger delete-service-btn'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                      </div>"

 
    ];
}
?>

<div class="admin-add-button-set">
    <div class="add-button">
        <button class="btn" id="add-service">
            <i class="fa-solid fa-plus"></i>
            Add Service
        </button>
    </div>

</div>

<?php
Table::render(items: $items, columns: $columns, keyColumns: ["ID","Actions"]);
?>
