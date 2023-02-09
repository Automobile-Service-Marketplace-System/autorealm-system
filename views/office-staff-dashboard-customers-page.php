<?php

use app\components\Table;

$columns = [];

foreach($customers[0] as $key=>$value){
    $columns[] = $key;
}
$columns[] = "Actions";

$items = [];

foreach($customers as $customer) {
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
                                         <button class='btn btn--rounded btn--warning'>
                                            <i class='fa-solid fa-pencil'></i>
                                         </button>
                                         <button id='create-appointment-btn-{$customer['ID']}' class='btn btn--rounded btn--success create-appointment-btn'>
                                            <i class='fa-regular fa-calendar-check'></i>
                                         </button>
                        </div>"
    ];
}
?>

<div class="office-staff-button-set">
    <div class="add-button">
        <a class="btn" href="customers/add">
            <i class="fa-solid fa-plus"></i>
         New Customer</a>
    </div>
    
</div>
    
<?php
    Table::render(items: $items, columns: $columns, keyColumns: ["ID", "Actions"]);
?>
