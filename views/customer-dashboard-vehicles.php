<?php
/**
 * @var array $vehicles
 */
?>

<div class="product-filters justify-between">
    <div class="product-search">
        <input type="text" placeholder="Search">
        <i class="fa-solid fa-magnifying-glass"></i>
    </div>
    <select name="type" id="product-type" class="product-filter--select">
        <option value="Tyres">Sort By</option>
    </select>
</div>

<div class="vehicles-container">
    <?php
    foreach ($vehicles as $vehicle) {
        $vehicleName = $vehicle['brand_name'] . " " . $vehicle['model_name'];
        $regNo = $vehicle['reg_no'];
    }
    ?>
    <div class="vehicle-card">
        <img src="/images/placeholders/car-placeholder.svg" alt="vehicle-image" class="vehicle-card__image">
        <div class="vehicle-card__info">
            <h2>
                Honda Civic EX
                <span>
                    Registration Number: QL-9904
                </span>
            </h2>
            <ul class="vehicle-card__info-more">
                <li><span>Brand:</span>Honda</li>
                <li><span>Model:</span>Civic</li>
                <li><span>Year of manufacture:</span>2019</li>
                <li><span>Engine Capacity:</span>1.8L</li>
                <li><span>Transmission:</span>Automatic</li>
            </ul>
        </div>
        <div class="vehicle-card__service-info">
            <div>
                <p><span>Last Service Mileage:</span> 268635 KM</p>
                <p><span>Last Service Date:</span> 12/12/2020</p>
            </div>
            <a class="btn btn--danger" href="/dashboard/records?vehicle_id=123">
                View service history
            </a>
        </div>
    </div>
    <div class="vehicle-card">
        <img src="/images/placeholders/car-placeholder.svg" alt="vehicle-image" class="vehicle-card__image">
        <div class="vehicle-card__info">
            <h2>
                Honda Civic EX
                <span>
                    Registration Number: QL-9904
                </span>
            </h2>
            <ul class="vehicle-card__info-more">
                <li><span>Brand:</span>Honda</li>
                <li><span>Model:</span>Civic</li>
                <li><span>Year of manufacture:</span>2019</li>
                <li><span>Engine Capacity:</span>1.8L</li>
                <li><span>Transmission:</span>Automatic</li>
            </ul>
        </div>
        <div class="vehicle-card__service-info">
            <div>
                <p><span>Last Service Mileage:</span> 268635 KM</p>
                <p><span>Last Service Date:</span> 12/12/2020</p>
            </div>
            <a class="btn btn--danger" href="/dashboard/records?vehicle_id=123">
                View service history
            </a>
        </div>
    </div>

</div>