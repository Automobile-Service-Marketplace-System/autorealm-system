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

    </section>
    <section class="reviews-row review-card">
        <div class="review-productName">
            <p>Caltex Havoline Formula SAE 15W- 40</p>
        </div>
        <div class="review-cusName">
            <p>Avishka Sathyanjana</p>
        </div>
        <div class="review-rating">
            <p>4.5</p>
        </div>
        <div class="review-text">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum tellus elit sed risus. Maecenas eget condimentum </p>
        </div>
    </section>

    <section class="reviews-row review-card">
        <div class="review-productName">
            <p>Caltex Havoline Formula SAE 15W- 40</p>
        </div>
        <div class="review-cusName">
            <p>Avishka Sathyanjana</p>
        </div>
        <div class="review-rating">
            <p>4.5</p>
        </div>
        <div class="review-text">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum tellus elit sed risus. Maecenas eget condimentum </p>
        </div>
    </section>

    <section class="reviews-row review-card">
        <div class="review-productName">
            <p>Caltex Havoline Formula SAE 15W- 40</p>
        </div>
        <div class="review-cusName">
            <p>Avishka Sathyanjana</p>
        </div>
        <div class="review-rating">
            <p>4.5</p>
        </div>
        <div class="review-text">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum tellus elit sed risus. Maecenas eget condimentum </p>
        </div>
    </section>


</main>


<style>
    .review-card {
        background-color: white;
        padding: 0.75rem;
        border-radius: 0.5rem;
        box-shadow: 0 0.25rem 2rem rgba(var(--dark), 0.1);
        width: 100%;
    }

    .reviews-grid{
        display: flex;
        flex-direction: column;
        gap: .5rem;
    }

    .reviews-row {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 1.5rem;
        margin-top: .5rem;
    }

    .review-productName {
        grid-column: 1 / 3;
        /*background-color: red;*/
    }

    .review-cusName {
        grid-column:3 / 4;
        /*background-color: orange;*/
    }

    .review-rating {
        grid-column: 4 / 5;
        text-align: center;
        /*background-color: yellow;*/
    }

    .review-text {
        grid-column: 5 / 7;
        /*background-color: #3df58e;*/
    }

    .review-titles {
        font-weight: bold;
    }

</style>