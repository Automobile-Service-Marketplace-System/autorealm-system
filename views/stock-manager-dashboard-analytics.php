<form>
    <div class="analytic-filter-wrapper" id="analytic-filter-wrapper">
        <!--    add date range from date and to date-->

        <div class="analytic-filter-date-container">
            <div class="analytic-filter-date form-item">
                <label for="from-date">From</label>
                <input type="date" id="analytic-from-date" class="analytic-filter-date-range__item__input" value="">
            </div>
            <div class="analytic-filter-date form-item">
                <label for="to-date">To</label>
                <input type="date" id="analytic-to-date" class="analytic-filter-date-range__item__input" value="">
            </div>
        </div>

        <div class="analytic-filter-actions">
            <button class="btn btn--thin btn--danger" id="analytic-filter-reset" type="button">Reset</button>
            <button class="btn btn--thin" id="analytic-filter-apply" type="button">Apply</button>
        </div>

    </div>
</form>


<div class="order-revenue-quantity-chart">

    <div class="order-revenue-quantity-chart__container" id="order-revenue-quantity-chart__container">

        <div class="revenue-chart-wrapper card">
            <!--header for order revenue-->
            <div class="order-revenue-quantity-chart__header">
                <h2 class="order-revenue-quantity-chart-wrapper__header__title">
                    Order Revenue
                </h2>

            </div>

            <!--chart for order revenue-->
            <div class="analytic-revenue-details">
                <div class="revenue-chart">
                    <canvas id="order-revenue-canvas"></canvas>
                </div>

                <div class="analytic-card" id="analytic-revenue-card">
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
                                <span class="analytic-card__item__value" id="highest-rev-month">
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

            <div class="order-revenue-reset-btn">
                <button class="btn btn--thin btn--text" id="reset-revenue-value-chart">Reset zoom</button>
            </div>

        </div>

        <div class="quantity-chart-wrapper card">
            <!--header for order quantity-->
            <div class="order-revenue-quantity-chart__header">
                <h2 class="order-revenue-quantity-chart-wrapper__header__title">
                    Order Quantity
                </h2>

            </div>

            <!--chart for order quantity-->

            <div class="analytic-quantity-details ">
                <div class="quantity-chart">
                    <canvas id="order-quantity-canvas">=</canvas>
                </div>

                <div class="analytic-card" id="analytic-quantity-card">
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

            <!--            order revenue quantity reset button-->
            <div class="order-revenue-reset-btn">
                <button class="btn btn--thin btn--text" id="reset-revenue-quantity-chart">Reset zoom</button>
            </div>

        </div>

    </div>


</div>


<div class="ordered-products-details card">

    <div class="product-quantity-analytic-container">
        <div class="product-quantity-analytic-details-container">
            <div class="order-quantity-chart__header">
                <h2 class="order-revenue-quantity-chart-wrapper__header__title">
                    Product Quantity Analytic
                </h2>

            </div>
            <div id="product-quantity-analytic-details">
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


</div>