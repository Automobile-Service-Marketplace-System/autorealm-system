<?php
/**
 * @var string $title
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
<body style="display: initial">

<main class="employee-auth">
    <section class="employee-auth__right">
        <div class="employee-login__brand">
            <img src="/images/logo.webp" alt="Autorealm logo">
            <p>AutoRealm</p>
        </div>
        {{content}}
    </section>
    <aside class="employee-auth__left">
    </aside>
</main>


<script type="module" src="/js/index.js"></script>
</body>
</html>

