<?php

/**
 * @var array $vehicles
 * @var object $customer
 * @var string | null $error
 * @var array $models
 * @var array $brands
 */


?>

<!-- add new vehicle button -->
<div class="add-vehicle-for-customer">
    <div class="customer-details">
        <strong class='customer-title'>
            Customer Name:
        </strong>
        <?php echo "{$customer->f_name} {$customer->l_name}" ?>
    </div>
    <button id="add-vehicle-for-customer" class="btn">Add vehicle</button>
</div>

<!-- vehicle card for each vehicle -->
<div class='vehicle-card-container'>
    <?php
    if (empty($vehicles)) {
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
            </div>
        ";
        }
    }
    ?>
</div>

<!-- set local storage for brands and models -->
<script>
    <?php
    try {
        $brandsString = json_encode($brands, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        $brandsString = "[]";
    }

    try {
        $modelsString = json_encode($models, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        $modelsString = "[]";
    }
    ?>
    const brands = <?= $brandsString ?>;
    const models = <?= $modelsString ?>;
</script>
