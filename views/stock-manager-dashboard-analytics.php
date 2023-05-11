<div class="order-revenue-quantity-chart">


    <div class="order-revenue-quantity-chart__container" id="order-revenue-quantity-chart__container">
        <!--header for order revenue-->
        <div class="order-revenue-quantity-chart__header">
            <h2 class="order-revenue-quantity-chart-wrapper__header__title">Order Revenue</h2>

        </div>

        <!--chart for order revenue-->
        <div class="analytic-revenue-details">
            <div class="revenue-chart">
                <canvas id="order-revenue-canvas"></canvas>
            </div>

            <div class="analytic-card order-details-card" id="analytic-revenue-card">
                <h2 class="item-summery-title order-details-title-under">
                    Revenue Details Summery
                </h2>

                <div class="analytic-card-details">
                    <div class="analytic-card__item">
                        <div class="analytic-card__item__title">
                            Total Revenue
                        </div>
                        <span class="analytic-card__item__value" id="total-revenue">
                            0
                        </span>
                    </div>
                    <div class="analytic-card__item">
                        <div class="analytic-card__item__title">
                            Highest Revenue
                        </div>

                        <div class="analytic-card__item__row">
                            <div class="analytic-card__item__subtitle">
                                Value :
                            </div>
                            <span class="analytic-card__item__value" id="highest-rev-value">
                                0
                            </span>
                        </div>

                        <div class="analytic-card__item__row">
                            <div class="analytic-card__item__subtitle">
                                Date :
                            </div>
                            <span class="analytic-card__item__value" id="highest-rev-date">
                                0
                            </span>
                        </div>

                    </div>
                    <div class="analytic-card__item">
                        <div class="analytic-card__item__title">
                            Lowest Revenue
                        </div>
                        <div class="analytic-card__item__row">
                            <div class="analytic-card__item__subtitle">
                                Value :
                            </div>
                            <span class="analytic-card__item__value" id="lowest-rev-value">
                                0
                            </span>
                        </div>

                        <div class="analytic-card__item__row">
                            <div class="analytic-card__item__subtitle">
                                Date :
                            </div>
                            <span class="analytic-card__item__value" id="lowest-rev-date">
                                0
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--header for order quantity-->
        <div class="order-revenue-quantity-chart__header">
            <h2 class="order-revenue-quantity-chart-wrapper__header__title">Order Quantity</h2>

        </div>

        <!--chart for order quantity-->

        <div class="analytic-quantity-details">
            <div class="quantity-chart">
                <canvas id="order-quantity-canvas">=</canvas>
            </div>

            <div class="analytic-card order-details-card" id="analytic-quantity-card">
                <h2 class="item-summery-title order-details-title-under">
                    Quantity Details Summery
                </h2>

                <div class="analytic-card-details">
                    <div class="analytic-card__item">
                        <div class="analytic-card__item__title">
                            Total Products Sold
                        </div>
                        <span class="analytic-card__item__value" id="total-sales-quantity">
                            0
                        </span>
                    </div>

                    <div class="analytic-card__item">
                        <div class="analytic-card__item__title">
                            Highest Order Per Day
                        </div>

                        <div class="analytic-card__item__row">
                            <div class="analytic-card__item__subtitle">
                                Value :
                            </div>
                            <span class="analytic-card__item__value" id="highest-orders-per-day">
                                0
                            </span>
                        </div>

                        <div class="analytic-card__item__row">
                            <div class="analytic-card__item__subtitle">
                                Date :
                            </div>
                            <span class="analytic-card__item__value" id="highest-order-date">
                                0
                            </span>
                        </div>

                    </div>

                    <div class="analytic-card__item">
                        <div class="analytic-card__item__title">
                            Highest Quantity Per Order
                        </div>
                        <div class="analytic-card__item__row">
                            <div class="analytic-card__item__subtitle">
                                Value :
                            </div>
                            <span class="analytic-card__item__value" id="highest-order-per-day">
                                0
                            </span>
                        </div>

                        <div class="analytic-card__item__row">
                            <div class="analytic-card__item__subtitle">
                                Date :
                            </div>
                            <span class="analytic-card__item__value" id="lowest-order-date">
                                0
                            </span>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>


</div>


<button class="btn btn--thin" id="reset-revenue-quantity-chart">Reset zoom</button>


<div class="ordered-products-details">

    <div class="product-quantity-analytic-container">
        <div class="product-quantity-analytic-details-container">
            <div class="order-revenue-quantity-chart__header">
                <h2 class="order-revenue-quantity-chart-wrapper__header__title">Order Revenue</h2>

            </div>
            <div class="order-details-card" id="product-quantity-analytic-details">
                <h2 class="item-summery-title order-details-title-under">
                    Revenue Details Summery
                </h2>

                <div class="analytic-card-details">
                    <div class="analytic-card__item">
                        <div class="analytic-card__item__title">
                            Total Revenue
                        </div>
                        <span class="analytic-card__item__value" id="total-revenue">
                            0
                        </span>
                    </div>
                    <div class="analytic-card__item">
                        <div class="analytic-card__item__title">
                            Highest Revenue
                        </div>

                        <div class="analytic-card__item__row">
                            <div class="analytic-card__item__subtitle">
                                Value :
                            </div>
                            <span class="analytic-card__item__value" id="highest-rev-value">
                                0
                            </span>
                        </div>

                        <div class="analytic-card__item__row">
                            <div class="analytic-card__item__subtitle">
                                Date :
                            </div>
                            <span class="analytic-card__item__value" id="highest-rev-date">
                                0
                            </span>
                        </div>

                    </div>


                    <div class="analytic-card__item">
                        <div class="analytic-card__item__title">
                            Lowest Revenue
                        </div>
                        <div class="analytic-card__item__row">
                            <div class="analytic-card__item__subtitle">
                                Value :
                            </div>
                            <span class="analytic-card__item__value" id="lowest-rev-value">
                                0
                            </span>
                        </div>

                        <div class="analytic-card__item__row">
                            <div class="analytic-card__item__subtitle">
                                Date :
                            </div>
                            <span class="analytic-card__item__value" id="lowest-rev-date">
                                0
                            </span>
                        </div>
                    </div>

                    <div class="analytic-card__item">
                        <div class="analytic-card__item__title">
                            Products with no sales
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--       product quantity chart-->
        <div class="ordered-product-quantity-chart">
            <canvas id="ordered-products-quantity-canvas"></canvas>
        </div>
    </div>


    <button class="btn btn--thin" id="reset-product-quantity-chart">Reset zoom</button>


</div>