<?php
/**
 * @var array $reviews
 */

use app\utils\DevOnly;

//DevOnly::prettyEcho($reviews);
?>

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
            <p><?= $review['Product']?></p>
        </div>
        <div class="review-cusName">
            <p><?= $review['Customer Name']?></p>
        </div>
        <div class="review-rating">
            <p><?= $review['Rating']?></p>
        </div>
        <div class="review-text">
            <p><?= $review['Review']?></p>
        </div>
        <div class="created-date-text">
            <p><?= $review['Date Posted']?></p>    </section>
    <?php } ?>

</main>


