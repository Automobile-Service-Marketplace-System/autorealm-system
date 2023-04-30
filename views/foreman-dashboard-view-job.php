<?php
/**
 * @var string $jobId
 * @var array $suggestions
 * @var array $vehicleDetails
 * @var array $inspectionReport
 */

$isDraft = $inspectionReport ? ($inspectionReport['is_draft'] == 1 ? "Finish the drafted report" : "Update the inspection report") : "Create inspection report for this job";


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
            <?= $isDraft ?>
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

<?php

if (empty($suggestions)) {
    echo "<p class='new-job-notice'>
    Create an inspection report <br> in order to assign <br> services, products and technicians <br> to start this job
    </p>";
} else {
//    echo "<pre>";
//    var_dump($suggestions);
//    echo "</pre>";


    echo "<h2 class='suggestions-heading'><i class='fa-solid fa-wrench'></i> Service suggestions based on the inspection report</h2>";
    echo "<div class='service-suggestions'>";
    foreach ($suggestions['services'] as $service) {
        echo "<div class='service-suggestion'>";
        echo "<p>$service</p>";
        echo "<button><i class='fa-solid fa-xmark'></i></button>";
        echo "</div>";
    }
    echo "</div>";

    echo "<h2 class='suggestions-heading'><i class='fa-solid fa-box'></i>Product suggestions based on the inspection report</h2>";
    echo "<div class='product-suggestions'>";
    foreach ($suggestions['products'] as $product) {
        echo "<div class='product-suggestion'>";
        echo "<img src='https://ultimatestyling.co.uk/storage/category-images/headlights-2.jpg' alt='$product'>";
        echo "<p>$product</p>";
        echo "<button><i class='fa-solid fa-xmark'></i></button>";
        echo "</div>";
    }
    echo "</div>";
}
?>
<form action="/jobs/start?id=<?= $jobId ?>">
    <h2 class='suggestions-heading'><i class='fa-solid fa-box'></i>Selected products</h2>
    <section class="create-job__products">
        <div class="create-job__products-item">
            <h4>Mobil Super™ 1000 -10W-30</h4>
            <img src="/uploads/products//163a4927c71de59.30734595.jpg"
                 alt="/uploads/products//163a4927c71de59.30734595.jpg's image">
            <button class="py-2 btn btn--danger btn--block btn--text">
                <i class='fa-solid fa-xmark'></i>
                Remove
            </button>
            <input type="text">
        </div>
        <div class="create-job__products-item">
            <h4>Honda Air Filter 17220-5AA-A00</h4>
            <img src="/uploads/products//163a497755f8dd0.97511177.jpg"
                 alt="/uploads/products//163a497755f8dd0.97511177.jpg's image">
            <button class="py-2 btn btn--danger btn--block btn--text">
                <i class='fa-solid fa-xmark'></i>
                Remove
            </button>
            <input type="text">
        </div>
        <button class="create-job__products-item create-job__products-item--new">
            <i class="fa-solid fa-plus"></i>
            Manually add a product
        </button>
    </section>

    <h2 class='suggestions-heading'><i class='fa-solid fa-wrench'></i>Selected services</h2>
    <section class="create-job__services">
        <button class="create-job__services-item create-job__services-item--new">
            <i class="fa-solid fa-plus"></i>
            Manually add a product
        </button>
    </section>


    <h2 class='suggestions-heading'><i class="fa-solid fa-user"></i></i>Selected technicians</h2>
    <section class="create-job__employees">
    </section>
    <div class="flex items-center justify-end gap-4 my-8">
        <button class="btn">Start job</button>
    </div>
</form>
