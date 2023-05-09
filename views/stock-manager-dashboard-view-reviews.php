<?php
/**
 * @var array $reviews
 * @var  int $limit
 * @var  int $page
 * @var  int $total
 *
 * @var string $searchTermProduct
 * @var string $reviewRating
 * @var string $reviewDate
 */

use app\utils\DevOnly;

//DevOnly::prettyEcho($reviews);

$noOfReviews = count($reviews);
$startNo = ($page - 1) * $limit + 1;
$endNo = $startNo + $noOfReviews - 1;
?>

<div class="product-table-count" style="text-align: left; margin-bottom: 1rem;">
    <p>
        Showing <?= $startNo ?> - <?= $endNo ?> of <?php echo $total; ?> reviews
        <!--            Showing 25 out of 100 products-->
    </p>
</div>

<div class="filters" id="dashboard-review-filter">
    <div class="filters__actions">
        <div class="filters__dropdown-trigger">
            Search & Filter
            <i class="fa-solid fa-chevron-right"></i>
        </div>
    </div>

    <form>
        <div class="filters__dropdown">
            <div class="review-filter-search-items">
                <div class="form-item form-item--icon-right form-item--no-label filters__search">
                    <input type="text" placeholder="Search Review by Product Name"
                           id="dashboard-review-product-name-search" name="product" <?php if($searchTermProduct) echo "value='$searchTermProduct'"?>>
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>

            <p>Filter reviews by</p>

            <div class="filters__dropdown-content">

                <div class="form-item form-item--no-label">
                    <select name="rating" id="dashboard-review-rating-filter">
                        <option value="all" <?= ($reviewRating=='all') ? 'selected' : ""?>>Rating</option>
                        <option value="1star" <?= ($reviewRating=='1star') ? 'selected' : ""?>>1 Star ⭐</option>
                        <option value="2star" <?= ($reviewRating=='2star') ? 'selected' : ""?>>2 Star ⭐⭐</option>
                        <option value="3star" <?= ($reviewRating=='3star') ? 'selected' : ""?>>3 Star ⭐⭐⭐</option>
                        <option value="4star" <?= ($reviewRating=='4star') ? 'selected' : ""?>>4 Star ⭐⭐⭐⭐</option>
                        <option value="5star" <?= ($reviewRating=='5star') ? 'selected' : ""?>>5 Star ⭐⭐⭐⭐⭐</option>
                    </select>
                </div>

                <div class="form-item form-item--no-label">
                    <select name="date" id="dashboard-review-date-posted-filter">
                        <option value="all" <?= ($reviewDate=='all') ? 'selected' : ""?>>Date Posted</option>
                        <option value="Today" <?= ($reviewDate=='Today') ? 'selected' : ""?>>Today</option>
                        <option value="Yesterday" <?= ($reviewDate=='Yesterday') ? 'selected' : ""?>>Yesterday</option>
                        <option value="Last7" <?= ($reviewDate=='Last7') ? 'selected' : ""?>>Last 7 Days</option>
                        <option value="Last30" <?= ($reviewDate=='Last30') ? 'selected' : ""?>>Last 30 Days</option>
                        <option value="Last90" <?= ($reviewDate=='Last90') ? 'selected' : ""?>>Last 90 Days</option>
                    </select>
                </div>

            </div>

            <div class="filter-action-buttons">
                <button class="btn btn--text btn--danger btn--thin" id="clear-filters-btn" type="reset">Clear
                </button>
                <button class="btn btn--text btn--thin" id="apply-filters-btn">Submit</button>
            </div>
        </div>
    </form>


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

        foreach (range(1, ceil($total / $limit)) as $i) {
            $isActive = $i === (float)$page ? "dashboard-pagination-item--active" : "";
            echo "<a class='dashboard-pagination-item $isActive' href='/reviews?product=$searchTermProduct&rating=$reviewRating&date=$reviewDate&page=$i&limit=$limit'>$i</a>";
        }
        ?>
        <a class="dashboard-pagination-item <?= $hasNextPageClass ?>" href="<?= $hasNextPageHref ?>">
            <i class="fa-solid fa-chevron-right"></i>
        </a>
    </div>

</main>


