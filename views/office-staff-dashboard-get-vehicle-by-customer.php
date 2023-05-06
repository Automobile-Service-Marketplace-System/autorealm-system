<?php

/**
 * @var array $vehicles
 * @var object $customer
 * @var string | null $error
 */

// var_dump($vehicles);

if(isset($error)) {
    echo "<p class='error'>$error</p>";
    return;
}

?>

<div class="add-vehicle-for-customer">
    <div class="customer-details">
        <strong class='customer-title'>
            Customer Name:
        </strong>
        <?php echo "{$customer->f_name} {$customer->l_name}" ?>
    </div>
    <button id="add-vehicle-for-customer" class="btn">Add vehicle</button>
</div>

<div class='vehicle-card-container'>
    <?php
    if(empty($vehicles)) {
        echo "<p class='no-data'>No vehicles for this customer</p>";
    } else {
    foreach ($vehicles as $vehicle) {
        $manufacturedYear = explode('-', $vehicle['manufactured_year'])[0];
        echo "
            <div class='vehicle-card'>
                <img src='/images/placeholders/car-placeholder.svg' alt='vehicle-image' class='vehicle-card__image'>
                <div class='vehicle-card__info'>
                    <h2>
                        {$vehicle['brand_name']} {$vehicle['model_name']} {$manufacturedYear}
                        <span>
                            Registration Number: {$vehicle['reg_no']}
                        </span>
                    </h2>
                    <ul class='vehicle-card__info-more'>
                        <li><span>Brand: </span>{$vehicle['brand_name']}</li>
                        <li><span>Model: </span>{$vehicle['model_name']}</li>
                        <li><span>Year of manufacture: </span>{$manufacturedYear}</li>
                        <li><span>Engine Capacity: </span>{$vehicle['engine_capacity']}</li>
                        <li><span>Transmission: </span>{$vehicle['transmission_type']}</li>
                    </ul>
                </div>
                <div class='vehicle-card__service-info'>
                    <div>
                        <p><span>Last Service Mileage:</span> 268635 KM</p>
                        <p><span>Last Service Date:</span> 12/12/2020</p>
                    </div>
                    <a class='btn btn--danger' href='/dashboard/services?vehicle_id=123'>
                        View service history
                    </a>
                </div>
            </div>
        ";
        }
    }
    ?>
</div>