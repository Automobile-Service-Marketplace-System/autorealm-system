<?php
/**
 * @var string $title
 * @var string $pageMainHeading
 * @var string $employeeId
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
            <a href="/overview">
                <i class="fa-solid fa-chart-simple"></i>
                <span>
                    Overview
                </span>
            </a>
            <a href="/employees">
                <i class="fa-solid fa-user-tie"></i>
                <span>
                    Employees
                </span>
            </a>
            <a href="/products">
                <i class="fa-solid fa-box"></i>
                <span>
                    Products
                </span>
            </a>
            <a href="/orders">
                <i class="fa-solid fa-money-bill"></i>
                <span>
                    Orders
                </span>
            </a>
            <a href="/suppliers">
                <i class="fa-solid fa-users"></i>
                <span>
                    Suppliers
                </span>
            </a>
            <a href="/reviews">
                <i class="fa-solid fa-comment-dots"></i>
                <span>
                    Reviews
                </span>
            </a>
            <a href="/services">
                <i class="fa-solid fa-screwdriver-wrench"></i>
                <span>
                    Services
                </span>
            </a>
            <a href="/all-jobs">
                <i class="fa-solid fa-clock"></i>
                <span>
                    Service/Repair Jobs
                </span>
            </a>
<!--            <a href="/employee-dashboard/vehicle-maintenance-reports">-->
<!--                <i class="fa-solid fa-file"></i>-->
<!--                <span>-->
<!--                    Vehicle Maintenance Reports-->
<!--                </span>-->
<!--            </a>-->
            <a href="/customers">
                <i class="fa-solid fa-users"></i>
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
                <a href="/analytics">
                <i class="fa-solid fa-chart-line"></i>
                <span>
                    Analytics
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
            EmployeeProfileDropdown::render(employeeId: $employeeId, employeeType:"admin",  id: 1);
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