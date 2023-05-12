<section class="create-invoice__header">
    <button class="flex gap-8" id="load-from-job-btn">
        <i class="fa-solid fa-plus"></i>
        <span id="load-from-job-btn__cancel">
        <i class="fa-solid fa-xmark cancel-icon"></i>
        </span>
        Load details from job card
    </button>
    <button class="flex gap-8" id="manually-add-customer-details-btn">
        <i class="fa-solid fa-plus"></i>
        Manually enter customer details
    </button>
</section>

<section class="create-invoice__customer-info">
    <h2>Client / Customer</h2>
    <div class="mt-4">
        <div class="flex items-center">
            <label style="width: 20%" for="customer_name">Name</label>
            <p id="customer-name">N/A</p>
            <input name="customer_name" id="customer_name">
        </div>
        <div class="flex items-center">
            <label style="width: 20%" for="customer_address">Address</label>
            <p id="customer-address">N/A</p>
            <input name="customer_address" id="customer_address">
        </div>
        <div class="flex items-center">
            <label style="width: 20%" for="customer_phone">Phone</label>
            <p id="customer-phone">N/A</p>
            <input name="customer_phone" id="customer_phone">
        </div>
        <div class="flex items-center">
            <label style="width: 20%" for="customer_email">Email</label>
            <p id="customer-email">N/A</p>
            <input name="customer_email" id="customer_email">
        </div>
    </div>
</section>

<section class="create-invoice__section">
    <h2 class="mt-4">Items</h2>
    <table class="create-invoice__table create-invoice__table--items">
        <colgroup>
            <col span="1" style="width: 48%;">
            <col span="1" style="width: 7%;">
            <col span="1" style="width: 14%;">
            <col span="1" style="width: 9%;">
            <col span="1" style="width: 22%;">
        </colgroup>
        <thead>
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Unit Price</th>
            <th>%</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="4">
                <label for="item-total">
                    Item Total (LKR)
                </label>
            </td>
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
    <h2 class="mt-4">Services / Labor</h2>
    <table class="create-invoice__table create-invoice__table--services">
        <colgroup>
            <col span="1" style="width: 48%;">
            <col span="1" style="width: 21%;">
            <col span="1" style="width: 9%;">
            <col span="1" style="width: 22%;">
        </colgroup>
        <thead>
        <tr>
            <th>Service / Labor</th>
            <th>Cost</th>
            <th>%</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="3">
                <label for="service-total">Service Total (LKR)</label>
            </td>
            <td>
                <input type="number" id="service-total" value="0.00" disabled>
            </td>
        </tr>
        </tfoot>
    </table>
    <button class="create-invoice__new-row-button" id="new-service-row-button">
        <i class="fa-solid fa-plus"></i>
        Add Service
    </button>
</section>
<section class="create-invoice__section">
    <table class="create-invoice__table">
        <colgroup>
            <col span="1" style="width: 78%;">
            <col span="1" style="width: 22%;">
        </colgroup>
        <tfoot>
        <tr>
            <td>
                <label for="grand-total">Grand Total</label>
            </td>
            <td>
                <input type="number" id="grand-total" value="0.00" disabled>
            </td>
        </tr>
        </tfoot>
    </table>
</section>

<div class="invoice-button-set">
    <button class="btn btn--success btn--square" e>
        <i class="fa-solid fa-print"></i>
    </button>
    <button class="btn btn--warning btn--square">
        <i class="fa-solid fa-file-pdf"></i>
    </button>
    <button class="btn" id="print-invoice">Print Invoice</button>
</div>