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
                <th>Unit Price (LKR)</th>
                <th>Discount</th>
                <th>Amount (LKR)</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Item Total</td>
                <td>
                    <input type="number" id="item-total" value="0.00" disabled>
                </td>
            </tr>
        </tfoot>
    </table>
<!--    <div class="total-row" id="item-total-row"></div>-->
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
        </tbody>
    </table>
    <button class="create-invoice__new-row-button" id="new-service-row-button">
        <i class="fa-solid fa-plus"></i>
        Add Item
    </button>
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