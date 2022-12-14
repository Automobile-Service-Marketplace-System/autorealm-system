<?php
/**
 * @var string $jobId
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

<p class="new-job-notice">
    Create an inspection report <br> in order to assign <br> services, products and technicians <br> to start this job
</p>