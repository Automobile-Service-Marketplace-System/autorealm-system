<?php
/**
 * @var string $title
 * @var string | null $pageMainHeading
 * @var int $technicianId
 */

use app\components\EmployeeProfileDropdown;
use app\utils\DocumentHead;


?>
<!doctype html>
<html lang="en">
<?php
DocumentHead::createHead(
    css: ["/css/style.css"],
    title: isset($title) ? "$title - AutoRealm" : "Home - AutoRealm"
);
?>

<body style="overflow: hidden">
<div class="pixel"></div>
<main class="employee-dashboard-container">
    <aside class="employee-dashboard-container__sidebar">
        <div class="sidebar-brand">
            <img src="/images/logo.webp" alt="Autorealm logo">
            <p>AutoRealm</p>
        </div>
        <nav class="employee-dashboard-container__nav">
            <a href="/technician-dashboard/overview">
                <i class="fa-solid fa-chart-simple"></i>
                <span>
                    Overview
                </span>
            </a>
            <a href="/assigned-job">
                <i class="fa-solid fa-clock"></i>
                <span>
                    Assigned job
                </span>
            </a>
            <a href="/all-jobs">
                <i class="fa-solid fa-file"></i>
                <span>
                    All Jobs
                </span>
            </a>

        </nav>
    </aside>
    <div class="employee-dashboard-container__content">

        <header class="employee-dashboard-container__content-header">
            <button class="employee-menu-btn  no_highlights">
                <i class="fa-solid fa-bars"></i>
            </button>
            <?php
            EmployeeProfileDropdown::render(employeeId: $technicianId, employeeType: "technician", id: 1);
            ?>
        </header>

        <div class="employee-dashboard-page">
            <?php if (isset($pageMainHeading) && $pageMainHeading) { ?>
                <h1>
                    <?= $pageMainHeading ?>
                </h1>
            <?php } ?>
            {{content}}
        </div>
    </div>
</main>
<script type="module" src="/js/index.js"></script>
</body>

</html>