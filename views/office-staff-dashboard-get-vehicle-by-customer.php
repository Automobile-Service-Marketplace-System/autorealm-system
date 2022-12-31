<?php

/**
 * @var array $vehicles
 * @var object $customer
 */

// var_dump($vehicles);
?>


<div class="add-vehicle-for-customer">
    <div class="customer-details">
        <strong class='customer-title'>
            Customer Name:
        </strong>
        <?php echo "{$customer->f_name} $customer->l_name" ?>
    </div>
    <button id="add-vehicle-for-customer" class="btn">Add vehicle</button>
</div>
<div class='vehicle-card-container'>
    <?php
    foreach ($vehicles as $vehicle) {
        echo "

            <div class='vehicle-card'>
                <p>
                    <strong>
                        VIN
                    </strong>
                        {$vehicle['vin']}
                </p>

                <p>
                    <strong>
                        Registration No
                 </strong>
                        {$vehicle['reg_no']}
                </p>

                <p>
                    <strong>
                        Engine No
                    </strong>
                        {$vehicle['engine_no']}

                </p>

                <p>
                    <strong>
                        Manufactured Year
                    </strong>
                        {$vehicle['manufactured_year']}

                </p>

                <p>
                    <strong>
                        Engine Capacity
                    </strong>
                        {$vehicle['engine_capacity']}

                </p>

                <p>
                    <strong>
                        Vehicle Type 
                    </strong>
                        {$vehicle['vehicle_type']}
                </p>

                <p>
                    <strong>
                        Fuel Type
                    </strong>
                        {$vehicle['fuel_type']}
                </p>

                <p>
                    <strong>
                        Trasmission Type
                    </strong>
                        {$vehicle['transmission_type']}
                </p>

                <p>
                    <strong>
                        Model Name
                    </strong>
                        {$vehicle['model_name']}
                </p>

                <p>
                    <strong>
                        Brand Name
                    </strong>
                        {$vehicle['brand_name']}
                </p>
                
            </div>
        ";
    }

    ?>
</div>