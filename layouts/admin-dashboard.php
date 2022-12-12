<?php
/**
 * @var string $title
 * @var string $pageMainHeading
 * @var string $adminId
 */
use app\components\EmployeeProfileDropdown;
use app\utils\DocumentHead;


//for now, a dummy StockManger class
class Admin
{
    public string $f_name = "Elvitigala";
    public string $l_name = "N.S";
    public string $image = "/images/placeholders/profile.webp";

} 

$admin = new Admin();

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
            <a href="/employee-dashboard/overview">
                <i class="fa-solid fa-chart-simple"></i>
                <span>
                    Overview
                </span>
            </a>
            <a href="/employee-dashboard/employee">
                <i class="fa-solid fa-box"></i>
                <span>
                    Employee
                </span>
            </a>
            <a href="/employee-dashboard/products">
                <i class="fa-solid fa-money-bill"></i>
                <span>
                    Products
                </span>
            </a>
            <a href="/employee-dashboard/orders">
                <i class="fa-solid fa-money-bill"></i>
                <span>
                    Orders
                </span>
            </a>
            <a href="/employee-dashboard/suppliers">
                <i class="fa-solid fa-users"></i>
                <span>
                    Suppliers
                </span>
            </a>
            <a href="/employee-dashboard/reviews">
                <i class="fa-solid fa-comment-dots"></i>
                <span>
                    Reviews
                </span>
            </a>
            <a href="/employee-dashboard/services">
                <i class="fa-solid fa-money-bill"></i>
                <span>
                    Services
                </span>
            </a>
            <a href="/employee-dashboard/services/jobs">
                <i class="fa-solid fa-money-bill"></i>
                <span>
                    Service/Repair Jobs
                </span>
            </a>
            <a href="/employee-dashboard/vehicle-maintenance-reports">
                <i class="fa-solid fa-money-bill"></i>
                <span>
                    Vehicle Maintenance Reports
                </span>
            </a>
            <a href="/employee-dashboard/customers">
                <i class="fa-solid fa-money-bill"></i>
                <span>
                    Customers
                </span>
            </a>            
            <a href="/employee-dashboard/vehicles">
                <i class="fa-solid fa-money-bill"></i>
                <span>
                    Vehicles
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
            EmployeeProfileDropdown::render(employeeId: $adminId, employeeType:"admin",  role: "admin", id: 1);
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