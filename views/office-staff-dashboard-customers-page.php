<?php
/**
 * @var array $customers
 * @var int $page
 * @var int $limit
 * @var int $total
 */
use app\components\Table;

$columns = [];

//for pagination
$noOfJobs = $customers['total'];
$startNo = ($page - 1) * $limit + 1;
$endNo = min($startNo + $limit - 1, $noOfJobs);

//table headings
$columns = array("ID", "Full Name", "Contact No", "Address", "Email", "Actions");

//for table data
$items = [];

//filling data from array
foreach($customers['customers'] as $customer) {
    $items[] = [
        "ID" => $customer["ID"],
        "Full Name" => $customer["Full Name"],
        "Contact No" => $customer["Contact No"],
        "Address" => $customer["Address"],
        "Email" => $customer["Email"],
        "Actions" =>   "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                                        <a href='/vehicles/by-customer?id={$customer['ID']}' class='btn btn--rounded btn--info'>
                                            <i class='fa-solid fa-car-side'></i>
                                         </a>
                                         <button class='btn btn--rounded btn--warning update-customer-btn' data-customerID='{$customer['ID']}'>
                                            <i class='fa-solid fa-pencil'></i>
                                         </button>
                                         <button id='create-appointment-btn-{$customer['ID']}' class='btn btn--rounded btn--success create-appointment-btn data-name='{$customer["Full Name"]}' data-id='{$customer["ID"]}'>
                                            <i class='fa-solid fa-wrench'></i>
                                         </button>
                        </div>"
    ];
}
?>

<!-- button for add new customer -->
<div class="office-staff-button-set">
    <div class="add-button">
        <a class="btn" href="customers/add">
            <i class="fa-solid fa-plus"></i>
         New Customer</a>
    </div>
    
</div>

<!-- pagination details -->
<div class="product-count-and-actions">
    <div class="product-table-count">
        <p>
            Showing <?= $startNo ?> - <?= $endNo ?> of <?php echo $total; ?> customers
            <!--            Showing 25 out of 100 products-->
        </p>
    </div>
</div>

<!-- call table component -->
<?php
    Table::render(items: $items, columns: $columns, keyColumns: ["ID", "Actions"]);
?>

<!-- pagination page details -->
<div class="pagination-container">
    <?php 
        foreach(range(1,ceil($total / $limit)) as $i) {
            $isActive = $i === (float)$page ? "pagination-item--active" : "";
            echo "<a class='pagination-item $isActive' href='/customers?page=$i&limit=$limit'>$i</a>";
        }
        ?>
</div>

