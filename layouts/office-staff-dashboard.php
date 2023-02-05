<?php
/**
 * @var string $title
 * @var string $pageMainHeading
 * @var string $officeStaffId
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
            <a href="/stock-manager-dashboard/overview">
                <i class="fa-solid fa-chart-simple"></i>
                <span>
                    Overview
                </span>
            </a>
            <a href="/stock-manager-dashboard/products">
                <i class="fa-solid fa-file-invoice"></i>
                <span>
                    Invoices
                </span>
            </a>
            <a href="/customers">
                <i class="fa-solid fa-user"></i>
                <span>
                    Customers
                </span>
            </a>
            <a href="/vehicles">
                <i class="fa-solid fa-car"></i>
                <span>
                    Vehicles
                </span>
            </a>
            <a href="/appointments">
                <i class="fa-solid fa-calendar-check"></i>
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
            EmployeeProfileDropdown::render(employeeId: $officeStaffId,employeeType: 'office_staff', id: 1);
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