
<?php

/**
 * @var array $services
 */

use app\components\Table;


$columns = ["Service Code", "Service Name", "Description", "Price","Action" ];

$items = [];
foreach ($services as $service) {
    // $quantityColor= $product["Quantity"]>20?"success":($product["Quantity"]>10?"warning":"danger");
    // $quantityElement= "<p class='product-quantity'>  <span class='status status--$quantityColor'></span>{$product["Quantity"]}</p>";
    $items[] = [
        "ID" => $service["ID"],
        "Name" => $service["Name"],
        "Description" => $service["Description"],
        "Price" => $service["Price"],
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

<div class="admin-add-button-set">
    <div class="add-button">
        <a class="btn" href="services/add-services">
            <i class="fa-solid fa-plus"></i>
            Add Services</a>
    </div>

</div>

<?php
Table::render(items: $items, columns: $columns, keyColumns: ["ID","Actions"]);
?>
