<?php
/**
 * @var string $title
 * @var string $pageMainHeading
 * @var string $securityOfficerId
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
            <a href="/security-officer-dashboard/check-appointment">
                <i class="fa-solid fa-chart-simple"></i>
                <span>
                    Home
                </span>
            </a>
            <a href="/employee-login">
                <i class="fa-solid fa-box"></i>
                <span>
                    Admitting Reports
                </span>
            </a>
            <a href="/employee-login">
                <i class="fa-solid fa-money-bill"></i>
                <span>
                    Appointments
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
            EmployeeProfileDropdown::render(employeeId: $securityOfficerId, employeeType:"security_officer", role: "Security Officer", id: 1);
            ?>
        </header>

        <div class="employee-dashboard-page">
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