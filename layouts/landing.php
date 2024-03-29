<?php
/**
 * @var string $title
 * @var int $customerId
 * @var string $current_url
 */

use app\utils\DocumentHead;
use app\components\CustomerProfileDropdown;
use app\components\CustomerHeader;

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
<header class="main-header main-header--home">
    <div class="brand">
        <a href="/">
            <img src="/images/logo.webp" alt="AutoRealm Logo" class="brand__image">
            <p class="brand__name">AutoRealm</p>
        </a>
    </div>
    <?php
    CustomerHeader::render(customerId: $customerId, current_url: $current_url);
    ?>

    <button class="menu-btn no_highlights">
        <span class="menu-btn__bar"></span>
    </button>
</header>
<nav class="dropdown-nav">
    <ul>
        <li><a href="/services">Services</a></li>
        <li><a href="/products">Products</a></li>
        <li><a href="/about-us">About Us</a></li>
        <li><a href="/contact-us">Contact Us</a></li>
        <?php
        if (!isset($customer)) {
            echo "<li><a href='/login' class='btn btn--dark-blue'>Login</a></li>";
        } else {
            CustomerProfileDropdown::render($customer, 2);
        }
        ?>
    </ul>
</nav>
{{content}}
<footer class="main-footer">
    <div>
        <div class="brand-and-address">
            <div>
                <img src="/images/logo-mini.webp" alt="AutoRealm Logo" class="brand__image" width="48" height="48">
                <p class="brand__name">AutoRealm</p>
            </div>
            <p>
                &copy; 2022 AutoRealm. All rights reserved.
            </p>
        </div>
        <div class="brand-and-address">
            <div>
                <p class="brand__name">Address</p>
            </div>
            <p>
                40, <br>
                Sir Mohamed Macon Marker Mawatha,<br>
                P.O.Box 338, <br>
                Colombo 03.
            </p>
        </div>
        <div class="brand-and-address">
            <div>
                <p class="brand__name">Contact</p>
            </div>
            <ul>
                <li><a href="tel:0112973973">+94 11 2 973 973</a> &nbsp; <a href="tel:0112973973">+94 11 2 973
                        973</a>
                </li>
                <li><a href="mailto:contact@autorealm.tk"> <i class="fas fa-envelope"></i> &nbsp;
                        contact@autorealm.tk
                    </a></li>
                <li class="icon-link"><a href="https://www.facebook.com">
                        <i class="fa-brands fa-facebook"></i>

                    </a>
                    <a href="https://www.twitter.com">
                        <i class="fa-brands fa-twitter">

                        </i>

                    </a>
                </li>
            </ul>
        </div>
        <div class="brand-and-address">
            <div>
                <p class="brand__name">About</p>
            </div>
            <ul>
                <li><a href="/about-us">About Us</a></li>
                <li><a href="/user-agreement">User agreement</a></li>
                <li><a href="/privacy-policy">Privacy Policy</a></li>
            </ul>
        </div>
    </div>

</footer>
<script type="module" src="/js/index.js"></script>
</body>

</html>