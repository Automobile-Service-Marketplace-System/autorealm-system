<div class="product-filters justify-between">
    <div class="flex gap-4 items-center">
        <div class="product-search">
            <input type="text" placeholder="Search">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <select name="type" id="product-type" class="product-filter--select">
            <option value="Tyres">Due Orders</option>
            <option value="Tyres">Shipped Orders</option>
            <option value="Tyres">Completed Orders</option>
            <option value="Tyres">All Orders</option>
        </select>
    </div>
    <select name="type" id="product-type" class="product-filter--select">
        <option value="Tyres">Sort By</option>
    </select>
</div>

<div class="orders-container">
    <div class="order-card">
        <img src="/images/placeholders/car-placeholder.svg" alt="order-image" class="order-card__image">
        <div class="order-card__info">
            <h2>
                Honda Civic EX
                <span>
                    Registration Number: QL-9904
                </span>
            </h2>
            <ul class="order-card__info-more">
                <li><span>Brand:</span>Honda</li>
                <li><span>Model:</span>Civic</li>
                <li><span>Year of manufacture:</span>2019</li>
                <li><span>Engine Capacity:</span>1.8L</li>
                <li><span>Transmission:</span>Automatic</li>
            </ul>
        </div>
        <div class="order-card__service-info">
            <div>
                <p><span>Last Service Mileage:</span> 268635 KM</p>
                <p><span>Last Service Date:</span> 12/12/2020</p>
            </div>
            <a class="btn btn--danger" href="/dashboard/services?order_id=123">
                View service history
            </a>
        </div>
    </div>
    <div class="order-card">
        <img src="/images/placeholders/car-placeholder.svg" alt="order-image" class="order-card__image">
        <div class="order-card__info">
            <h2>
                Honda Civic EX
                <span>
                    Registration Number: QL-9904
                </span>
            </h2>
            <ul class="order-card__info-more">
                <li><span>Brand:</span>Honda</li>
                <li><span>Model:</span>Civic</li>
                <li><span>Year of manufacture:</span>2019</li>
                <li><span>Engine Capacity:</span>1.8L</li>
                <li><span>Transmission:</span>Automatic</li>
            </ul>
        </div>
        <div class="order-card__service-info">
            <div>
                <p><span>Last Service Mileage:</span> 268635 KM</p>
                <p><span>Last Service Date:</span> 12/12/2020</p>
            </div>
            <a class="btn btn--danger" href="/dashboard/services?order_id=123">
                View service history
            </a>
        </div>
    </div>

</div>