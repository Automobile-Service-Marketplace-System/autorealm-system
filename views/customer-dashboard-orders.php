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
        <div class="order-card__header">
            <p>Ordered Date: 2023/2/3</p>
            <p class="due">Due</p>
        </div>
        <div class="order-card__info">
            <div class="order-card__info-billing">
                <div>
                    <h3>Billing Details</h3>
                    <p>
                        Avishka Sathyanjana <br>
                        +94712345678 <br>
                        276/6, Chandana Road, Parakandeniya <br>
                    </p>
                </div>
                <div>
                    <h3>Shipping Address</h3>
                    <p>
                        276/6,<br>
                        Chandana Uyana <br>
                        Parakandeniya <br>
                    </p>
                </div>
            </div>
            <div class="order-card__info-section">
                <p id="item-toggle-1" class="item-toggle">Items
                    <i class="fa-solid fa-angle-right"></i>
                </p>
                <div id="item-list-1" class="order-items">
                    <div>
                        <img src="/images/placeholders/product-image-placeholder.jpg" alt="Product img 1">
                        <p>Some Product Name</p>
                        <p>2x</p>
                        <p>Rs. 10400.00</p>
                    </div>
                    <div>
                        <img src="/images/placeholders/product-image-placeholder.jpg" alt="Product img 1">
                        <p>Some Product Name</p>
                        <p>2x</p>
                        <p>Rs. 10400.00</p>
                    </div>
                    <div>
                        <img src="/images/placeholders/product-image-placeholder.jpg" alt="Product img 1">
                        <p>Some Product Name</p>
                        <p>2x</p>
                        <p>Rs. 10400.00</p>
                    </div>
                    <div>
                        <img src="/images/placeholders/product-image-placeholder.jpg" alt="Product img 1">
                        <p>Some Product Name</p>
                        <p>2x</p>
                        <p>Rs. 10400.00</p>
                    </div>
                </div>
            </div>
        </div>
        <p class="order-card__cost">
            <strong>
                Order Amount:
            </strong>
            Rs. 50000.00
        </p>
    </div>
    <div class="order-card">
        <div class="order-card__header">
            <p>Ordered Date: 2023/2/3</p>
            <p class="due">Due</p>
        </div>
        <div class="order-card__info">
            <div class="order-card__info-billing">
                <div>
                    <h3>Billing Details</h3>
                    <p>
                        Avishka Sathyanjana <br>
                        +94712345678 <br>
                        276/6, Chandana Road, Parakandeniya <br>
                    </p>
                </div>
                <div>
                    <h3>Shipping Address</h3>
                    <p>
                        276/6,<br>
                        Chandana Uyana <br>
                        Parakandeniya <br>
                    </p>
                </div>
            </div>
            <div class="order-card__info-section">
                <p id="item-toggle-1" class="item-toggle">Items
                    <i class="fa-solid fa-angle-right"></i>
                </p>
                <div id="item-list-1" class="order-items">
                    <div>
                        <img src="/images/placeholders/product-image-placeholder.jpg" alt="Product img 1">
                        <p>Some Product Name</p>
                        <p>2x</p>
                        <p>Rs. 10400.00</p>
                    </div>
                    <div>
                        <img src="/images/placeholders/product-image-placeholder.jpg" alt="Product img 1">
                        <p>Some Product Name</p>
                        <p>2x</p>
                        <p>Rs. 10400.00</p>
                    </div>
                    <div>
                        <img src="/images/placeholders/product-image-placeholder.jpg" alt="Product img 1">
                        <p>Some Product Name</p>
                        <p>2x</p>
                        <p>Rs. 10400.00</p>
                    </div>
                    <div>
                        <img src="/images/placeholders/product-image-placeholder.jpg" alt="Product img 1">
                        <p>Some Product Name</p>
                        <p>2x</p>
                        <p>Rs. 10400.00</p>
                    </div>
                </div>
            </div>
        </div>
        <p class="order-card__cost">
            <strong>
                Order Amount:
            </strong>
            Rs. 50000.00
        </p>
    </div>

</div>

<div class="pagination-container">
    <a class='pagination-item pagination-item--active' href='/dashboard/records?vehicle_id=123&page=1&limit=2'>1</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=2&limit=2'>2</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=3&limit=2'>3</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=4&limit=2'>4</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=5&limit=2'>5</a>
    <a class='pagination-item' href='/dashboard/records?vehicle_id=123&page=6&limit=2'>6</a>
</div>