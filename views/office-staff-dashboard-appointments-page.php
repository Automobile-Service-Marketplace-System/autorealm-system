<?php

use app\components\Table;

// var_dump($appointments);
$columns = [];
if (empty($appointments)) {
    echo "<p class='no-data'>No Appointments as of now </p>";
} else {
    $columns = array("Appointment ID","Reg No", "Customer Name", "Mileage (KM)", "Remarks", "Date", "From Time", "To Time", "Actions");

    $items = [];

    foreach ($appointments as $appointment) {
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
                            <button class='btn btn--rounded btn--danger office--appointment-btn' data-appointmentID='{$appointment['Appointment ID']}'>
                                <i class='fa-solid fa-trash'></i>
                            </button>

                        </div>"
        ];
    }

    Table::render(items: $items, columns: $columns, keyColumns: ["appointment_id", "Actions"]);
}
