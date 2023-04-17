<?php

use app\components\Table;

// var_dump($appointments);
$columns = [];
if (empty($appointments)) {
    echo "<p class='no-data'>No Appointments as of now </p>";
} else {

    foreach ($appointments[0] as $key => $value) {
        $columns[] = $key;
    }
    $columns[] = "Actions";

    $items = [];

    foreach ($appointments as $appointment) {
        $items[] = [
            "Appointment ID" => $appointment["Appointment ID"],
            "Vehicle Reg No" => $appointment["Vehicle Reg No"],
            "Customer Name" => $appointment["Customer Name"],
            "Milage" => $appointment["Milage"],
            "Remarks" => $appointment["Remarks"],
            "Service Type" => $appointment["Service Type"],
            "Date and Time" => $appointment["Date & Time"],
            "Time ID" => $appointment["Time ID"],
            "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                            <a href='/create-job-card?id={$appointment['Appointment ID']}' class='btn btn--rounded btn--info'>
                            <i class='fa-solid fa-wrench'></i>                            </a>
                            <button class='btn btn--rounded btn--danger'>
                                <i class='fa-solid fa-pencil'></i>
                            </button>
                            <button class='btn btn--rounded btn--danger'>
                                <i class='fa-solid fa-trash'></i>
                            </button>

                        </div>"
        ];
    }

    Table::render(items: $items, columns: $columns, keyColumns: ["appointment_id", "Actions"]);
}
