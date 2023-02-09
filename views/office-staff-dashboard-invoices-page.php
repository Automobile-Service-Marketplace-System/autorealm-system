<div class="office-staff-button-set">
    <div class="add-button">
        <a class="btn" href="invoices/create">
            <i class="fa-solid fa-plus"></i>
            Create Invoice</a>
    </div>

</div>

<?php

use app\components\Table;

$columns = [];

foreach ($invoices[0] as $key => $value) {
    $columns[] = $key;
}
$columns[] = "Actions";

$items = [];

foreach ($invoices as $invoice) {
    $items[] = [
        "Invoice No" => $invoice["Invoice No"],
        "Customer Name" => $invoice["Customer Name"],
        "Total Cost" => $invoice["Total Cost"],
        "Type" => $invoice["Type"],
        "Employee ID" => $invoice["Employee ID"],
        "JobCard ID" => $invoice["JobCard ID"],
        "Actions" =>   "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                                        <a href='/vehicles/by-customer?id={$invoice['Invoice No']}' class='btn btn--rounded btn--info'>
                                            <i class='fa-solid fa-car-side'></i>
                                         </a>
                                         <button class='btn btn--rounded btn--warning'>
                                            <i class='fa-solid fa-pencil'></i>
                                         </button>
                        </div>"
    ];
}

Table::render(items: $items, columns: $columns, keyColumns: ["Invoice No", "Actions"]);
