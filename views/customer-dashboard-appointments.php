<?php

/**
 * @var array $appointments
 */

//\app\utils\DevOnly::prettyEcho($appointments);

if (isset($error)) {
    echo "<p class='error'>$error</p>";
    return;
}

?>

<div class="flex items-center justify-end">
    <button class="btn" id="customer-create-appointment-btn">
        <i class="fa fa-calendar"></i>
        Get an appointment
    </button>
</div>

<div class="appointments-container">
    <?php

    if (is_string($appointments)) {
        echo "<p class='no-data'>Sorry! <br> there are no Appointments for you</p>";
    } else {
        foreach ($appointments as $appointment) {

            $appointmentDate = $appointment['appointment_date'];
            $today = date("Y-m-d");
            $diff = date_diff(date_create($today), date_create($appointmentDate));
            $days = intval($diff->format("%a"));
            if ($days > 7) {
                $reminder = "<p class='due'>$days days to go</p>";
            } else if ($days == 1) {
                $reminder = "<p class='due'>Tomorrow</p>";
            } else if ($days > 1) {
                $reminder = "<p class='due'>Coming soon</p>";
            } else if ($days == 0) {
                $reminder = "<p class='due due--warning'>Today</p>";
            } else {
                $reminder = "<p class='due due--danger'>Overdue</p>";
            }

            $appointmentCancelBtn = $days > 0
                ?
                "<button class='customer-appointment-delete-btn' data-id='{$appointment['appointment_id']}'>
                    Cancel
                </button>" :
                "";

            echo "
            <div class='appointment-card'>
                <div class='appointment-card__header'>
                    <p>Appointment Date: {$appointment['appointment_date']}</p>
                    <p>Appointment Time: {$appointment['appointment_time']}</p>
                    $reminder
                </div>
                <div class='appointment-card__info'>
                    <div class='appointment-card__info-date'>
                        <div>
                            <h3>Made on</h3>
                            <p>
                                {$appointment['created_date']}
                            </p>
                        </div>
                        <div>
                            <h3>Your remarks</h3>
                            <p>
                                {$appointment['remarks']}
                            </p>
                        </div>
                    </div>
                </div>
                <div class='appointment-card__footer'>
                    <div><strong>
                            For:
                        </strong>
                        {$appointment['vehicle_reg_no']}
                    </div>
                    <div class='flex items-center gap-4'>
                        <button class='appointment-get-qrcode' data-qrcode='{$appointment['qrcode_url']}'>
                            Get QR Code
                        </button>
                        $appointmentCancelBtn
                    </div>
                </div>
             </div>
            ";
        }
    }

    ?>


</div>
