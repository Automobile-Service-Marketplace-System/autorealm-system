<?php
/**
 * @var string $jobId
 * @var array $suggestions
 */
?>

<ul class="job-vehicle-details">
    <li>
        <strong>Vehicle:</strong>
        Toyota GR Supra A91 CF Edition
    </li>
    <li>
        <strong>Reg No:</strong>
        QL 9904
    </li>
</ul>

<ul class="job-actions">
    <li>
        <a href="/foreman-dashboard/inspection-reports/create?job_id=<?php echo $jobId; ?>">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            Create Inspection report for this job
        </a>
    </li>
    <li>
        <a href="/foreman-dashboard/job-reports?vehicle=QL 9904">
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

