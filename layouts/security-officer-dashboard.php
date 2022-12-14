<?php
/**
 * @var string $title
 * @var string $pageMainHeading
 * @var object $admin
 */

use app\components\EmployeeProfileDropdown;
use app\utils\DocumentHead;


//class Admin {
//    public string $f_name = "John";
//    public string $l_name = "Doe";
//    public string $image = "/images/placeholders/profile.webp";
//
//}
//
//$admin = new Admin();

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
                <i class="fa-solid fa-box"></i>
                <span>
                    Products
                </span>
            </a>
            <a href="/stock-manager-dashboard/orders">
                <i class="fa-solid fa-money-bill"></i>
                <span>
                    Orders
                </span>
            </a>
            <a href="/stock-manager-dashboard/suppliers">
                <i class="fa-solid fa-users"></i>
                <span>
                    Suppliers
                </span>
            </a>
            <a href="/stock-manager-dashboard/reviews">
                <i class="fa-solid fa-comment-dots"></i>
                <span>
                    Reviews
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
            EmployeeProfileDropdown::render(employee: $admin, role: "Administrator", id: 1);
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