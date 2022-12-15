<?php
/**
 * @var string $title
 * @var string $pageMainHeading
<<<<<<< HEAD
 * @var int $foremanId
=======
 * @var string $securityOfficerId
>>>>>>> 8fda316fa66e03140b32c52bfedf73d9b5e07981
 */

use app\components\EmployeeProfileDropdown;
use app\utils\DocumentHead;

<<<<<<< HEAD
=======

//class Admin {
//    public string $f_name = "John";
//    public string $l_name = "Doe";
//    public string $image = "/images/placeholders/profile.webp";
//
//}
//
//$admin = new Admin();

>>>>>>> 8fda316fa66e03140b32c52bfedf73d9b5e07981
?>
<!doctype html>
<html lang="en">
<?php
DocumentHead::createHead(
    css: ["/css/style.css"],
<<<<<<< HEAD
    title: isset($title) ? "$title - AutoRealm" : "Home - AutoRealm",
=======
    title: isset($title) ? "$title - AutoRealm" : "Home - AutoRealm"
>>>>>>> 8fda316fa66e03140b32c52bfedf73d9b5e07981
);
?>

<body style="overflow: hidden">
<<<<<<< HEAD
=======
<div class="pixel"></div>
>>>>>>> 8fda316fa66e03140b32c52bfedf73d9b5e07981
<main class="employee-dashboard-container">
    <aside class="employee-dashboard-container__sidebar">
        <div class="sidebar-brand">
            <img src="/images/logo.webp" alt="Autorealm logo">
            <p>AutoRealm</p>
        </div>
        <nav class="employee-dashboard-container__nav">
<<<<<<< HEAD
            <a href="/foreman-dashboard/overview">
=======
            <a href="/stock-manager-dashboard/overview">
>>>>>>> 8fda316fa66e03140b32c52bfedf73d9b5e07981
                <i class="fa-solid fa-chart-simple"></i>
                <span>
                    Overview
                </span>
            </a>
<<<<<<< HEAD
            <a href="/foreman-dashboard/jobs">
                <i class="fa-solid fa-box"></i>
                <span>
                    Jobs
                </span>
            </a>
            <a href="/foreman-dashboard/orders">
=======
            <a href="/stock-manager-dashboard/products">
                <i class="fa-solid fa-box"></i>
                <span>
                    Products
                </span>
            </a>
            <a href="/stock-manager-dashboard/orders">
>>>>>>> 8fda316fa66e03140b32c52bfedf73d9b5e07981
                <i class="fa-solid fa-money-bill"></i>
                <span>
                    Orders
                </span>
            </a>
<<<<<<< HEAD
            <a href="/foreman-dashboard/suppliers">
=======
            <a href="/stock-manager-dashboard/suppliers">
>>>>>>> 8fda316fa66e03140b32c52bfedf73d9b5e07981
                <i class="fa-solid fa-users"></i>
                <span>
                    Suppliers
                </span>
            </a>
<<<<<<< HEAD
            <a href="/foreman-dashboard/reviews">
=======
            <a href="/stock-manager-dashboard/reviews">
>>>>>>> 8fda316fa66e03140b32c52bfedf73d9b5e07981
                <i class="fa-solid fa-comment-dots"></i>
                <span>
                    Reviews
                </span>
            </a>

        </nav>
    </aside>
    <div class="employee-dashboard-container__content">
<<<<<<< HEAD
=======

>>>>>>> 8fda316fa66e03140b32c52bfedf73d9b5e07981
        <header class="employee-dashboard-container__content-header">
            <button class="employee-menu-btn  no_highlights">
                <i class="fa-solid fa-bars"></i>
            </button>
            <?php
<<<<<<< HEAD
            EmployeeProfileDropdown::render(employeeId: $foremanId, employeeType: "foreman", role: "Foreman", id: 1);
            ?>
        </header>

        <div class="employee-dashboard-page" style="position: relative">
            <div class="employee-pixel"
                 style="height: 1px; width: 1px; position: absolute;top: 0.5rem;background-color: transparent;"></div>
=======
            EmployeeProfileDropdown::render(employeeId: $securityOfficerId, employeeType:"security_officer", role: "Security Officer", id: 1);
            ?>
        </header>

        <div class="employee-dashboard-page">
>>>>>>> 8fda316fa66e03140b32c52bfedf73d9b5e07981
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