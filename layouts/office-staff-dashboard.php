<?php
/**
 * @var string $title
 * @var string $pageMainHeading
 * @var object $stockManager
 */

use app\components\EmployeeProfileDropdown;
use app\utils\DocumentHead;


//for now, a dummy StockManger class
class StockManager
{
    public string $f_name = "John";
    public string $l_name = "Doe";
    public string $image = "/images/placeholders/profile.webp";

}

$stockManager = new StockManager();

?>
<!doctype html>
<html lang="en">
<?php
DocumentHead::createHead(
    css: ["/css/style.css"],
    title: isset($title) ? "$title - AutoRealm" : "Home - AutoRealm"
);
?>

<body>
<div class="pixel"></div>
<main class="employee-dashboard-container">
    <aside class="employee-dashboard-container__sidebar">
        <div class="sidebar-brand">
            <img src="/images/logo.webp" alt="Autorealm logo">
            <p>AutoRealm</p>
        </div>
        <nav class="employee-dashboard-container__nav">
            <a href="/dashboard/overview">
                <i class="fa-solid fa-chart-simple"></i>
                <span>
                    Overview
                </span>
            </a>
            <a href="/dashboard/overview">
                <i class="fa-solid fa-calendar-check"></i>
                <span>
                    My appointments
                </span>
            </a>
            <a href="/dashboard/overview">
                <i class="fa-solid fa-stopwatch"></i>
                <span>
                    Ongoing services/Repairs
                </span>
            </a>
            <a href="/dashboard/overview">
                <i class="fa-solid fa-car"></i>
                <span>
                    My vehicles
                </span>
            </a>
            <a href="/dashboard/overview">
                <i class="fa-solid fa-money-bill"></i>
                <span>
                    My orders
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
            EmployeeProfileDropdown::render(employee: $stockManager, role: "Stock manager", id: 1);
            ?>
        </header>
        <h1>
            <?php echo $pageMainHeading; ?>
        </h1>
        <div class="employee-dashboard-page">
            {{content}}
        </div>
    </div>
</main>
<script type="module" src="/js/index.js"></script>
</body>

</html>