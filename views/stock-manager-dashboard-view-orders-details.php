<main class= "order-details-grid">
    <section class="item-summery-card">
        <h2 class="item-summery-title">
            Item Summery
        </h2>
        <div class="item-summery-products-section">
            <div class="order-product-row">
                <span class="order-product-row--column1 item-summery-title">
                    Product
                </span>
                <span class="order-product-row--column2 item-summery-title">
                    QTY
                </span>
                <span class="order-product-row--column3 item-summery-title">
                    Unit Price
                </span>
                <span class="order-product-row--column4 item-summery-title">
                    Total
                </span>


            </div>

            <div class="order-product-row">
                <span class="order-product-row--column1">
                    Mobil Super™ 2000 X1 10W-40
                </span>
                <span class="order-product-row--column2">
                    X1
                </span>
                <span class="order-product-row--column3">
                    Rs. 17,558
                </span>
                <span class="order-product-row--column4">
                    Rs. 17,558
                </span>


            </div>

            <div class="order-product-row">
                <span class="order-product-row--column1">
                    Mobil Super™ 2000 X1 10W-40
                </span>
                <span class="order-product-row--column2">
                    X1
                </span>
                <span class="order-product-row--column3">
                    Rs. 17,558
                </span>
                <span class="order-product-row--column4">
                    Rs. 17,558
                </span>


            </div>

            <div class="order-product-row">
                <span class="order-product-row--column1">
                    Mobil Super™ 2000 X1 10W-40
                </span>
                <span class="order-product-row--column2">
                    X1
                </span>
                <span class="order-product-row--column3">
                    Rs. 17,558
                </span>
                <span class="order-product-row--column4">
                    Rs. 17,558
                </span>


            </div>

        </div>

    </section>
</main>


<style>

    .item-summery-card{
        background-color: white;
        padding: 0.75rem;
        border-radius: 0.5rem;
        box-shadow: 0 0.25rem 2rem rgba(var(--dark), 0.1);
        width: 100%;
    }

    .order-product-row{
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        grid-template-rows: repeat(1, min-content);
        gap: 1.5rem;
    }

    .order-product-row--column1{
        grid-column: 1 / 3;
    }
    /*.order-product-row--column2{*/
    /*    grid-column: 3 / 4;*/
    /*}*/
    /*.order-product-row--column3{*/
    /*    grid-column: 1 / 3;*/
    /*}*/
    /*.order-product-row--column4{*/
    /*    grid-column: 1 / 3;*/
    /*}*/

    .item-summery-title{
        font-weight: bold;
    }

    .item-summery-products-section{
        display: flex;
        flex-direction: column;
        margin-left: 1.5rem;
        margin-right: 1.5rem;
        margin-top: 1rem;
        gap: 1rem;
    }

</style>