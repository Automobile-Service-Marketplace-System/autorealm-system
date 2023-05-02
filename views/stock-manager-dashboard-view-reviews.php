<?php
/**
 * @var array $reviews
 * @var  int $limit
 * @var  int $page
 * @var  int $total
 */

use app\utils\DevOnly;

//DevOnly::prettyEcho($reviews);

$noOfReviews = count($reviews);
$startNo = ($page - 1) * $limit + 1;
$endNo = $startNo + $noOfReviews - 1;
?>

<div class="product-table-count" style="text-align: left">
    <p>
        Showing <?= $startNo ?> - <?= $endNo ?> of <?php echo $total; ?> reviews
        <!--            Showing 25 out of 100 products-->
    </p>
</div>

<main class="reviews-grid">
    <section class="review-titles reviews-row">
        <div class="review-productName">
            <h2>Product Name</h2>
        </div>
        <div class="review-cusName">
            <h2>Customer Name</h2>
        </div>
        <div class="review-rating">
            <h2>Rating</h2>
        </div>
        <div class="review-text">
            <h2>Review</h2>
        </div>
        <div class="created-date-text">
            <h2>Date Posted</h2>
        </div>

    </section>

    <?php
    foreach ($reviews as $review) {

        $review['Date Posted'] = date("d-m-Y", strtotime($review['Date Posted']));
        ?>

        <section class="reviews-row review-card">
            <div class="review-productName">
                <p><?= $review['Product'] ?></p>
            </div>
            <div class="review-cusName">
                <p><?= $review['Customer Name'] ?></p>
            </div>
            <div class="review-rating">
                <p><?= $review['Rating'] ?></p>
            </div>
            <div class="review-text">
                <p><?= $review['Review'] ?></p>
            </div>
            <div class="created-date-text">
                <p><?= $review['Date Posted'] ?></p>
        </section>
    <?php } ?>


    <div class="dashboard-pagination-container">
        <?php

        $hasNextPage = $page < ceil(num: $total / $limit);
        $hasNextPageClass = $hasNextPage ? "" : "dashboard-pagination-item--disabled";
        $hasNextPageHref = $hasNextPage ? "/products?page=" . ($page + 1) . "&limit=$limit" : "";
        $hasPreviousPage = $page > 1;
        $hasPreviousPageClass = $hasPreviousPage ? "" : "dashboard-pagination-item--disabled";
        $hasPreviousPageHref = $hasPreviousPage ? "/products?page=" . ($page - 1) . "&limit=$limit" : "";

        ?>
        <a class="dashboard-pagination-item <?= $hasPreviousPageClass ?>"
           href="<?= $hasPreviousPageHref ?>">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <?php
        //    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
        foreach (range(1, ceil($total / $limit)) as $i) {
            $isActive = $i === (float)$page ? "dashboard-pagination-item--active" : "";
            echo "<a class='dashboard-pagination-item $isActive' href='/reviews?page=$i&limit=$limit'>$i</a>";
        }
        ?>
        <a class="dashboard-pagination-item <?= $hasNextPageClass ?>" href="<?= $hasNextPageHref ?>">
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>

</main>


