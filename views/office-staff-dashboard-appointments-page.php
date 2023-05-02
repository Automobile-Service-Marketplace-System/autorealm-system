<?php

use app\components\Table;

$noOfJobs = $appointments['total'];
$startNo = ($page - 1) * $limit + 1;
$endNo = min($startNo + $limit - 1, $noOfJobs);

$columns = [];
if (empty($appointments['appointments'])) {
    echo "<p class='no-data'>No Appointments as of now </p>";
} else {
    $columns = array("Appointment ID","Reg No", "Customer Name", "Mileage (KM)", "Remarks", "Date", "From Time", "To Time", "Actions");

    $items = [];

    foreach ($appointments['appointments'] as $appointment) {
        $items[] = [
            "Appointment ID" => $appointment["Appointment ID"],
            "Vehicle Reg No" => $appointment["Vehicle Reg No"],
            "Customer Name" => $appointment["Customer Name"],
            "Mileage (KM)" => $appointment["Mileage"],
            "Remarks" => $appointment["Remarks"],
            "Date" => $appointment["Date"],
            "From Time" => $appointment["From Time"],
            "To Time" => $appointment["To Time"],
            "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                            <a href='/create-job-card?id={$appointment['Appointment ID']}' class='btn btn--rounded btn--info'>
                            <i class='fa-solid fa-wrench'></i>                            </a>
                            <button class='btn btn--rounded btn--danger office-update-appointment-btn' data-appointmentID='{$appointment['Appointment ID']}' data-timeSlotID='{$appointment["Time ID"]}' data-customerID='{$appointment["Customer ID"]}'>
                                <i class='fa-solid fa-pencil'></i>
                            </button>
                            <button class='btn btn--rounded btn--danger office-delete-appointment-btn' data-appointmentID='{$appointment['Appointment ID']}'>
                                <i class='fa-solid fa-trash'></i>
                            </button>
                        </div>"
        ];
    }
}
?>

<div class="product-count-and-actions">
    <div class="product-table-count">
        <p>
            Showing <?= $startNo ?> - <?= $endNo ?> of <?php echo $total; ?> appointments
            <!--            Showing 25 out of 100 products-->
        </p>
    </div>
</div>

<?php
    Table::render(items: $items, columns: $columns, keyColumns: ["appointment_id", "Actions"]);
?>

<div class="pagination-container">
    <?php 
        foreach(range(1,ceil($total / $limit)) as $i) {
            $isActive = $i === (float)$page ? "pagination-item--active" : "";
            echo "<a class='pagination-item $isActive' href='/appointments?page=$i&limit=$limit'>$i</a>";
        }
        ?>
</div>
