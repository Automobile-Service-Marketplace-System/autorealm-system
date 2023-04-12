<?php
/**
 * @var object $orderDetails
 */


 //var_dump($orderDetails);
 ?>

<main class= "order-details-grid">
    <section class="order-details-card">
        <h2 class="item-summery-title">
            Item Summery
        </h2>
        <div class="item-summery-products-section">
            <div class="order-product-row item-summery-title order-details-title-under">
                <span class="order-product-row--column1 ">
                    Product
                </span>
                <span class="order-product-row--column2 ">
                    QTY
                </span>
                <span class="order-product-row--column3 ">
                    Unit Price
                </span>
                <span class="order-product-row--column4 ">
                    Total
                </span>
            </div>
<!--add items details from orderDetails under above categories-->
            <?php
            foreach ($orderDetails['Items'] as $item) {?>
                <div class="order-product-row">
                    <span class="order-product-row--column1">
                        <?=$item['Product Name']?>
                    </span>
                    <span class="order-product-row--column2">
                        x<?=$item['Quantity']?>
                    </span>
                    <span class="order-product-row--column3">
                        Rs. <?=$item['Price']?>
                    </span>
                    <span class="order-product-row--column4">
                        Rs. <?=$item['Product Total']?>
                    </span>
                </div>
                <?php
            }
                ?>
        </div>

    </section>

    <section class="cus-order-cards">

        <div class="order-details-card order-customer-details-card">

            <h2 class="item-summery-title order-details-title-under">
                Customer Details
            </h2>
            <div class="order-customer-details-section item-summery-products-section">
                <div class="order-customer-details-row">
                    <span class="order-customer-details-row--column1">
                        Name
                    </span>
                    <span class="order-customer-details-row--column2">
                        <?=$orderDetails['cusDetails']['customer_name']?>
                    </span>
                </div>

                <div class="order-customer-details-row">
                    <span class="order-customer-details-row--column1">
                        Email
                    </span>
                    <span class="order-customer-details-row--column2">
                        <?=$orderDetails['cusDetails']['email']?>
                    </span>
                </div>

                <div class="order-customer-details-row">
                    <span class="order-customer-details-row--column1">
                        Address
                    </span>
                    <span class="order-customer-details-row--column2">
                        <?=$orderDetails['cusDetails']['address']?>
                    </span>
                </div>
                <div class="order-customer-details-row">
                    <span class="order-customer-details-row--column1">
                        Mobile Number
                    </span>
                    <span class="order-customer-details-row--column2">
                        <?=$orderDetails['cusDetails']['contact_no']?>
                    </span>
                </div>

            </div>
        </div>
<?php
    list($orderDate, $orderTime) = explode(' ', $orderDetails['created_at']);
?>
        <div class="order-details-card order-summery-card">
            <h2 class="item-summery-title order-details-title-under">
                Order Summery
            </h2>
            <div class="order-customer-details-section item-summery-products-section">
                <div class="order-customer-details-row">
                    <span class="order-customer-details-row--column1">
                        Order Date
                    </span>
                    <span class="order-customer-details-row--column2">
                        <?=$orderDate ?>
                    </span>
                </div>

                <div class="order-customer-details-row">
                    <span class="order-customer-details-row--column1">
                        Order Time
                    </span>
                    <span class="order-customer-details-row--column2">
                        <?=$orderTime ?>
                    </span>
                </div>
<?php
//to get total quantity and total amount
    $totQuantity = 0;
    $totAmount = 0.0;
    foreach($orderDetails['Items'] as $Item){
        $totQuantity = $Item['Quantity'] + $totQuantity;
        $totAmount = $Item['Product Total'] + $totAmount;
    }

?>
                <div class="order-customer-details-row">
                    <span class="order-customer-details-row--column1">
                        Total Products
                    </span>
                    <span class="order-customer-details-row--column2">
                        <?=$totQuantity ?>
                    </span>
                </div>
                <div class="order-customer-details-row item-summery-title">
                    <span class="order-customer-details-row--column1">
                        Total Amount
                    </span>
                    <span class="order-customer-details-row--column2">
                        <?=$totAmount?>
                    </span>
                </div>

            </div>
        </div>
    </section>

    <section class="cus-order-cards">
        <div class="order-details-card order-customer-details-card">
            <h2 class="item-summery-title order-details-title-under">
                Deliver Details
            </h2>
            <div class="order-customer-details-section item-summery-products-section">
                <div class="order-deliver-details-row ">
                    <span class="order-deliver-details-row--column1">
                        <div class='form-item--radio'>
                            <input type='radio' name='Prepared' value='Passed' id='Prepared'>
                            <label for='Prepared'>Prepared</label>
                        </div>
                    </span>
                    <span class="order-deliver-details-row--column2">
                        Prepared Date and Time
                    </span>
                    <span class="order-deliver-details-row--column3">
                        <?php
                        if($orderDetails['status'] == 'Not Prepared'){
                            echo "N/A";
                        }else{
                            echo $orderDetails['prepared_date_time'];
                        }
                        ?>
                    </span>
                </div>

                <div class="order-deliver-details-row">
                    <span class="order-deliver-details-row--column1">
                        <div class='form-item--radio'>
                            <input type='radio' name='Delivery' value='Delivery' id='Delivery'>
                            <label for='Delivery'>Hand over to<br>Delivery</label>
                        </div>
                    </span>
                    <span class="order-deliver-details-row--column2">
                        Dispatched Date and Time
                    </span>
                    <span class="order-deliver-details-row--column3">
                        <?php
                        if($orderDetails['status'] == 'Not Prepared' || $orderDetails['status'] == 'Prepared'){
                            echo "N/A";
                            }
                        else{
                            echo $orderDetails['dispatched_date_time'];
                        }
                        ?>
                    </span>
                </div>

                <div class="order-deliver-details-row">
                    <span class="order-deliver-details-row--column1">

                    </span>
                    <span class="order-deliver-details-row--column2">
                        Handle by
                    </span>
                    <span class="order-deliver-details-row--column3">
                        <?=$orderDetails['empDetails']['employee_name']?>
                    </span>
                </div>

                <div class="order-deliver-details-row">
                    <span class="order-deliver-details-row--column1">

                    </span>
                    <span class="order-deliver-details-row--column2">
                        Courier Name
                    </span>
                    <span class="order-deliver-details-row--column3">
<!--                        --><?//=$orderDetails['empDetails']['employee_name']?>
                        N/A
                    </span>
                </div>
                <div class="order-deliver-details-row">
                    <span class="order-deliver-details-row--column1">

                    </span>
                    <span class="order-deliver-details-row--column2">
                        Courier Mobile Number
                    </span>
                    <span class="order-deliver-details-row--column3">
<!--                        --><?//=$orderDetails['empDetails']['employee_name']?>
                        N/A
                    </span>
                </div>


            </div>
        </div>
        <div class="order-details-card order-summery-card">
            <h2 class="item-summery-title order-details-title-under">
                Status
            </h2>
            <div class="order-customer-details-section item-summery-products-section">
                <div class="order-status-details-row">
                    <span class="order-status-details-row--column1 ">
                        <label class="form-item--checkbox--status">
                             <input type="checkbox" name="isNotprepared" >
                        </label>
                    </span>
                    <span class="order-status-details-row--column2 status-btn-shape ntprep-st-col">
                        Not Prepared
                    </span>
                </div>

                <div class="order-status-details-row">
                    <span class="order-status-details-row--column1 form-item--checkbox">
                        <label>
                             <input type="checkbox" name="isNotprepared">
                        </label>
                    </span>
                    <span class="order-status-details-row--column2 status-btn-shape prep-st-col">
                        Prepared
                    </span>
                </div>
                <div class="order-status-details-row">
                    <span class="order-status-details-row--column1 form-item--checkbox">
                        <label>
                             <input type="checkbox" name="isDelivery">
                        </label>
                    </span>
                    <span class="order-status-details-row--column2 status-btn-shape del-st-col">
                        Delivery
                    </span>
                </div>
                <div class="order-status-details-row">
                    <span class="order-status-details-row--column1 form-item form-item--checkbox">

                             <input type="checkbox" name="isCurConfirmed">

                    </span>
                    <span class="order-status-details-row--column2 status-btn-shape cur-st-col">
                        Confirmed by Courier
                    </span>
                </div>
                <div class="order-status-details-row">
                    <span class="order-status-details-row--column1 form-item--checkbox">
                        <label>
                             <input type="checkbox" name="isCusConfirm">
                        </label>
                    </span>
                    <span class="order-status-details-row--column2 status-btn-shape cus-st-col">
                        Confirmed by Customer
                    </span>
                </div>

            </div>
        </div>
    </section>

</main>


