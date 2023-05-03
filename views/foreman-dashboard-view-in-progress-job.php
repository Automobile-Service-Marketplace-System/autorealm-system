<?php
/**
 * @var string $jobId
 * @var array $vehicleDetails
 * @var array $products
 * @var array $services
 * @var array $technicians
 * @var int $all
 * @var int $done
 */
?>

<ul class="job-vehicle-details">
    <li>
        <strong>Vehicle:</strong>
        <?php echo $vehicleDetails['vehicle_name'] ?>
    </li>
    <li>
        <strong>Reg No:</strong>
        <?php echo $vehicleDetails['reg_no'] ?>
    </li>
    <li>
        <strong>Customer:</strong>
        <?php echo $vehicleDetails['customer_name'] ?>
    </li>
</ul>

<ul class="job-actions">
    <li>
        <a href="/inspection-reports/create?job_id=<?php echo $jobId; ?>">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            Update the inspection report
        </a>
    </li>
    <li>
        <a href="/all-jobs?vehicle=QL 9904">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            View previous jobs for this vehicle
        </a>
    </li>
    <li>
        <a href="tel:+94703614315">
            <i class="fa-solid fa-phone"></i>
            Contact customer
        </a>
    </li>
</ul>


<h2 class='suggestions-heading'><i class='fa-solid fa-box'></i>Selected products</h2>
<section class="view-job__products">
    <?php

    foreach ($products as $product) {
        $name = $product['Name'];
        $image = $product['Image'];
        $id = $product['ID'];
        echo "
          <div class='view-job__products-item'>
            <h4>$name</h4>
            <img src='$image' alt='$name'>
          </div>
    ";
    }
    ?>
</section>

<h2 class='suggestions-heading'><i class='fa-solid fa-wrench'></i>Selected services</h2>
<section class="view-job__services">
    <?php

    foreach ($services as $service) {
        $name = $service['Name'];
        $code = $service['Code'];
        echo "
                <div class='view-job__services-item'>
                        <h4>$name</h4>
                    </div>
    ";
    }

    ?>
</section>


<h2 class='suggestions-heading'><i class="fa-solid fa-user"></i>Selected technicians</h2>
<section class="view-job__employees">
    <?php

    foreach ($technicians as $technician) {

        $name = $technician['Name'];
        $image = $technician['Image'];

        echo "<div class='view-job__technicians-item'>
                    <img src='$image' alt='$name'>
                    <h4>$name</h4>
                    <i class='fa-solid fa-circle-check'></i>
               </div>";
    }
    ?>
</section>

<form>
    <div class="flex items-center justify-end gap-4 my-8">
        <button class="btn" type="button" id="start-job-btn">Mark this job as finished</button>
    </div>
</form>

