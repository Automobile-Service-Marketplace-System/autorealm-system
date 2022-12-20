<?php 

/**
 * @var array $vehicles
 */

// var_dump($vehicles);
?>

<div class="add-vehicle-for-customerj">
    <button id="add-vehicle-for-customer" class="btn">Add vehicle</button>
</div>

<strong class='customer-title'>
        Customer Name: 
</strong>
<span class='customer-title'>
       <?php echo " {$vehicles[0]['full_name']} " ?>
</span>


<?php
foreach ($vehicles as $vehicle) {
    echo "
        <div class='vehicle-card-container'>
            <div class='vehicle-card'>
                <p>
                    <strong>
                        VIN
                    </strong>
                    <span>
                        {$vehicle['vin']}
                    </span>
                </p>

                <p>
                    <strong>
                        Registration No
                    </strong>
                    <span>
                        {$vehicle['reg_no']}
                    </span>
                </p>

                <p>
                    <strong>
                        Engine No
                    </strong>
                    <span>
                        {$vehicle['engine_no']}
                    </span>

                </p>

                <p>
                    <strong>
                        Manufactured Year
                    </strong>
                    <span>
                        {$vehicle['manufactured_year']}
                    </span>

                </p>

                <p>
                    <strong>
                        Engine Capacity
                    </strong>
                    <span>
                        {$vehicle['engine_capacity']}
                    </span>

                </p>

                <p>
                    <strong>
                        Vehicle Type 
                    </strong>
                    <span>
                        {$vehicle['vehicle_type']}
                    </span>
                </p>

                <p>
                    <strong>
                        Fuel Type
                    </strong>
                    <span>
                        {$vehicle['fuel_type']}
                    </span>
                </p>

                <p>
                    <strong>
                        Trasmission Type
                    </strong>
                    <span>
                        {$vehicle['transmission_type']}
                    </span>
                </p>

                <p>
                <strong>
                    Model Name
                </strong>
                <span>
                    {$vehicle['model_name']}
                </span>
                </p>

                <p>
                <strong>
                    Brand Name
                </strong>
                <span>
                    {$vehicle['brand_name']}
                </span>
                </p>
                
            </div>
        </div>
        ";
}

?>
</div>

