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

    foreach ($appointments as $appointments) {
        $items[] = [
            "Appointment ID" => $appointments["Appointment ID"],
            "Vehicle Reg No" => $appointments["Vehicle Reg No"],
            "Customer Name" => $appointments["Customer Name"],
            "Milage" => $appointments["Milage"],
            "Remarks" => $appointments["Remarks"],
            "Service Type" => $appointments["Service Type"],
            "Date and Time" => $appointments["Date & Time"],
            "Time ID" => $appointments["Time ID"],
            "Actions" => "<div style='display: flex;align-items: center;justify-content: center;gap: 1rem;padding-inline: 0.25rem'>
                            <a href='/office-staff-dashboard/create-jobCard?id={$appointments['Appointment ID']}' class='btn btn--rounded btn--info'>
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
