import {Modal} from '../components/Modal';
import Notifier from "../components/Notifier";
import {htmlToElement} from "../utils";

const productRestockButtons = document.querySelectorAll(".restock-product-btn")
//console.log(productRestockButtons)
productRestockButtons.forEach(function (btn) {
    btn.addEventListener("click", function () {
        const productId = Number(btn.parentElement.dataset.productid);

        const productRow = btn.parentElement.parentElement.parentElement
        const productNameElement = productRow.querySelector('td:nth-child(2)')
        const productName = productNameElement.textContent
        console.log(productId)
        console.log(productName)
        const restockProductForm = htmlToElement(`
                    <div>
                    <form class="restock-product-form" id="restock-product-form" method="post">
                        <div class="top-part-form">  
                            <h1 class="">Restock Product</h1>
                            <p class="restock-product-name">${productName}</p>
                            <button class="modal-close-btn" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        
                        <div class="restock-product-input-wrapper">
                            <div class="form-item">
                                <label for='stock_quantity'>Stock Quantity.<sup>*</sup></label>
                                <input type='number' name='stock_quantity' id='stock_quantity' placeholder='' required  value=''   >
                            </div>
                            
                            <div class="form-item">
                                <label for='unit_price'>Unit Price.<sup>*</sup></label>
                                <input type='number' name='unit_price' id='unit_price' placeholder='' required  value=''   >
                            </div>
                            
                            <div class="form-item">
                                <label for='sup_date'>Received Date.<sup>*</sup></label>
                                <input type='date' name='sup_date' id='sup_date' placeholder='' required  value=''   >
                            </div>
                        </div>
                   
                        <div class="restock-product-actions">
                            <button class="btn btn--danger btn--thin" type="reset">Reset</button>
                            <button class="btn btn--thin btn--info add-sup-button" type="button" id="add-supplier-modal-btn">Restock</button>
                            <button style="display: none" type="submit" id="add-supplier-final-btn"></button>

                        </div>
                        </form>
                    </div>
                    `)

        Modal.show({
            closable: false,
            key: "restock-product",
            content: restockProductForm
        })
    })
})