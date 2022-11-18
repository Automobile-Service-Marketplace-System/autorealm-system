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

<main class="container container-fh">
    {{content}}
</main>

<script type="module" src="/js/index.js"></script>
</body>
</html>

