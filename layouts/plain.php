<?php
/**
 * @var string $title
 * @var object $customer
 */

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
<body>

<main class="container container-fh">
    {{content}}
</main>
<footer class="main-footer">
    <div>
        <div class="brand-and-address">
            <div>
                <img src="/images/logo.webp" alt="AutoRealm Logo" class="brand__image" width="48px" height="48px">
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
                Sir Mohamed Macan Markar Mawatha,<br>
                P.O.Box 338, <br>
                Colombo 03.
            </p>
        </div>
        <div class="brand-and-address">
            <div>
                <p class="brand__name">Contact</p>
            </div>
            <ul>
                <li><a href="tel:0112973973">+94 11 2 973 973</a> &nbsp; <a href="tel:0112973973">+94 11 2 973 973</a>
                </li>
                <li><a href="mailto:contact@autorealm.tk"> <i class="fas fa-envelope"></i> &nbsp; contact@autorealm.tk
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
