<?php

/**
 * @var array $appointments

 */

//\app\utils\DevOnly::prettyEcho($appointments);

if(isset($error)) {
    echo "<p class='error'>$error</p>";
    return;
}

?>


<div class="product-filters justify-between">
    <div class="flex gap-4 items-center">
        <div class="product-search">
            <input type="text" placeholder="Search">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <select name="type" id="product-type" class="product-filter--select">
            <option value="Tyres">Coming Soon</option>
            <option value="Tyres">Shipped</option>
            <option value="Tyres">Completed</option>
            <option value="Tyres">All</option>
        </select>
    </div>
    <select name="type" id="product-type" class="product-filter--select">
        <option value="Tyres">Sort By</option>
    </select>
    <button id="create-appointment-btn" class="btn">
        <i class="fa-regular fa-calendar-check"></i>
        Get an Appointment
    </button>
</div>

<div class="appointments-container">
    <?php

    if(is_string($appointments)){
        echo "<p class='no-data'>Sorry! <br> there are no Appointments for you</p>";
    }
    else{
        foreach ($appointments as $appointment){
            echo "
            <div class='appointment-card'>
                <div class='appointment-card__header'>
                    <p>Appointment Date: {$appointment['appointment_date']}</p>
                    <p>Appointment Time: {$appointment['appointment_time']}</p>
                    <p class='due'>Coming Soon</p>
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
                            <h3>Service Type</h3>
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
                        <button>
                            Get QR Code
                        </button>
                        <button>
                            Cancel
                        </button>
                    </div>
                </div>
             </div>
            ";
        }
    }

 ?>


</div>

<div class="pagination-container">
    <a class='pagination-item pagination-item--active' href='/dashboard/records?vehicle_id=123&page=1&limit=2'>1</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=2&limit=2'>2</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=3&limit=2'>3</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=4&limit=2'>4</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=5&limit=2'>5</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=6&limit=2'>6</a>
</div>