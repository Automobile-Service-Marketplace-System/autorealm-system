<section class="create-invoice__header">
    <button class="flex gap-8">
        <i class="fa-solid fa-plus"></i>
        Load details from job card
    </button>
    <button class="flex gap-8">
        <i class="fa-solid fa-plus"></i>
        Manually enter customer details
    </button>
</section>

<section class="create-invoice__section">
    <h2>Items</h2>
    <table class="create-invoice__table create-invoice__table--items">
        <colgroup>
            <col span="1" style="width: 50%;">
            <col span="1" style="width: 10.5%;">
            <col span="1" style="width: 15.5%;">
            <col span="1" style="width: 8%;">
            <col span="1" style="width: 16%;">
        </colgroup>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Discount</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="text" placeholder="Product name" name="product_name">
                </td>
                <td>
                    <input type="number" placeholder="Quantity">
                </td>
                <td>
                    <input type="number" placeholder="Unit Price" name="product_price">
                </td>
                <td>
                    <input type="number" placeholder="%">
                </td>
                <td>
                    <input type="number" placeholder="Amount">
                </td>
            </tr>
        </tbody>
    </table>
    <button class="create-invoice__new-row-button" id="new-item-row-button">
        <i class="fa-solid fa-plus"></i>
        Add Item
    </button>
    <h2>Services / Labor</h2>
    <table class="create-invoice__table create-invoice__table--services">
        <colgroup>
            <col span="1" style="width: 60.5%;">
<!--            <col span="1" style="width: 10.5%;">-->
            <col span="1" style="width: 15.5%;">
            <col span="1" style="width: 8%;">
            <col span="1" style="width: 16%;">
        </colgroup>
        <thead>
            <tr>
                <th>Service / Labor</th>
                <th>Cost</th>
                <th>Discount</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="text" placeholder="Service / Labor">
                </td>
                <td>
                    <input type="number" placeholder="Cost">
                </td>
                <td>
                    <input type="number" placeholder="Discount">
                </td>
                <td>
                    <input type="number" placeholder="Amount">
                </td>
            </tr>
        </tbody>
</section>
<!---->
<!--<div class="invoice-button-set">-->
<!--    <button class="btn btn--success btn--square" e>-->
<!--        <i class="fa-solid fa-print"></i>-->
<!--    </button>-->
<!--    <button class="btn btn--warning btn--square">-->
<!--        <i class="fa-solid fa-file-pdf"></i>-->
<!--    </button>-->
<!--    <button class="btn">Print Invoice</button>-->
<!--</div>-->