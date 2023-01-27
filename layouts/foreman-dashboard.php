<?php
/**
 * @var string $title
 * @var string $pageMainHeading
 * @var int $foremanId
 */

use app\components\EmployeeProfileDropdown;
use app\utils\DocumentHead;

?>
<!doctype html>
<html lang="en">
<?php
DocumentHead::createHead(
    css: ["/css/style.css"],
    title: isset($title) ? "$title - AutoRealm" : "Home - AutoRealm",
);
?>

<body style="overflow: hidden">
<main class="employee-dashboard-container">
    <aside class="employee-dashboard-container__sidebar">
        <div class="sidebar-brand">
            <img src="/images/logo.webp" alt="Autorealm logo">
            <p>AutoRealm</p>
        </div>
        <nav class="employee-dashboard-container__nav">
            <a href="/foreman-dashboard/overview">
                <i class="fa-solid fa-chart-simple"></i>
                <span>
                    Overview
                </span>
            </a>
            <a href="/jobs">
                <i class="fa-solid fa-clock"></i>
                <span>
                    Jobs
                </span>
            </a>
            <a href="/inspection-reports">
                <i class="fa-solid fa-file"></i>
                <span>
                    Inspection reports
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
            EmployeeProfileDropdown::render(employeeId: $foremanId, employeeType: "foreman", role: "Foreman", id: 1);
            ?>
        </header>

        <div class="employee-dashboard-page" style="position: relative">
            <div class="employee-pixel"
                 style="height: 1px; width: 1px; position: absolute;top: 0.5rem;background-color: transparent;"></div>
            <h1>
                <?php echo $pageMainHeading; ?>
            </h1>
            {{content}}
        </div>
    </div>
</main>
<script type="module" src="/js/index.js"></script>
</body>

</html>