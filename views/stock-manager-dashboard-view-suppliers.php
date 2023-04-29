<?php

/**
 * @var array $suppliers
 * @var  int $limit
 * @var  int $page
 * @var  int $total
 */

use app\components\Table;

//\app\utils\DevOnly::prettyEcho($suppliers);

$columns = ["ID", "Name", "Address","Registration No", "Sales Manager","Contacts","Last Purchase Date", "Last Supply Amount", "Email", "Actions"];

$items = [];






foreach ($suppliers as $supplier) {
    $contacts = "";

    foreach ($supplier["Contact Numbers"] as $contact) {
        $contacts .= $contact . ", ";
    }

    $items[] = [
        "ID" => $supplier["ID"],
        "Name" => $supplier["Name"],
        "Address" => $supplier["Address"],
        "Registration No" => $supplier["Registration No"],
        "Sales Manager" => $supplier["Sales Manager"],
        "Contacts" => $contacts,
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
<div class="product-count-and-actions">
    <div class="product-table-count">
        <p >
            Showing <?php echo $limit; ?> of <?php echo $total; ?> products
            <!--            Showing 25 out of 100 products-->
        </p>
    </div>
    <div class="stock-manager-add-button-set">
        <div class="add-button">
            <button class="btn" id="add-supplier-btn">
                <i class="fa-solid fa-plus"></i>
                Add Suppliers
            </button>
        </div>

    </div>
</div>

<?php

Table::render(items: $items, columns: $columns, keyColumns: ["ID", "Actions"]);

?>

<div class="pagination-container">
    <?php

    foreach (range(1, ceil($total / $limit)) as $i) {
        $isActive = $i === (float)$page ? "pagination-item--active" : "";
        echo "<a class='pagination-item $isActive' href='/suppliers?page=$i&limit=$limit'>$i</a>";
    }
    ?>
</div>
