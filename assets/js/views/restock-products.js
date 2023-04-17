import {Modal} from '../components/Modal';
import Notifier from "../components/Notifier";
import {htmlToElement} from "../utils";

const productRestockButtons = document.querySelectorAll(".restock-product-btn")
//console.log(productRestockButtons)
productRestockButtons.forEach(function (btn) {
    btn.addEventListener("click", async function () {
        try{
            const productId = Number(btn.parentElement.dataset.productid);

            const productRow = btn.parentElement.parentElement.parentElement
            const productNameElement = productRow.querySelector('td:nth-child(2)')
            const productName = productNameElement.textContent
            console.log(productId)
            console.log(productName)

            const results = await fetch(`/suppliers/options-json`,{
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            switch (results.status) {
                case 404:
                    Notifier.show({
                        text: "No suppliers found",
                        type: "danger",
                        header: "Error",
                    })
                    return;
                case 200:
                    const suppliers = await results.json();
                    console.log(suppliers)
            }

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
                                <label for='sup_date'>Supplier.<sup>*</sup></label>
                                <select name="supplier_id" id="supplier_id" required>
                                ${supplierOptions}
                                </select>
                            </div>
                            
                           <div class="form-item">
                                <label for='sup_date'>Received Date.<sup>*</sup></label>
                                <input type='date' name='sup_date' id='sup_date' placeholder='' required  value=''   >
                            </div>
                                 <input style="display: none" type="number" value="${productId}" name="product_id">
                        </div>
                   
                        <div class="restock-product-actions">
                            <button class="btn btn--danger btn--thin" type="reset">Reset</button>
                            <button class="btn btn--thin btn--info restock-product-modal-btn" type="button" id="restock-product-modal-btn">Restock</button>
                            <button style="display: none" type="submit" id="restock-product-final-btn"></button>

                        </div>
                        </form>
                    </div>
                    `)

            restockProductForm?.querySelector("#restock-product-modal-btn")?.addEventListener("click", (e) => {

                const confModal = htmlToElement(`<div>
                                    <h3>Are you sure you want to restock this product ?</h3>
                                    <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem;margin-top: 1rem">
                                        <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
                                        <button class="btn btn--thin modal-close-btn" id="restock-product-confirm-btn">Confirm</button>                        
                                    </div> 
                               </div>`)

                confModal.querySelector("#restock-product-confirm-btn").addEventListener('click', () => {
                    const submitBtn = restockProductForm?.querySelector("#restock-product-final-btn");
                    console.log("clicked confirm btn");
                    submitBtn?.click();
                })

                Modal.show({
                    closable: true,
                    content: confModal,
                    key: "Restock product confirmation"
                })


            });
            Modal.show({
                closable: false,
                content: restockProductForm,
                key: "restock-product"
            })

            //  send form data when submit triggered
            restockProductForm?.addEventListener('submit', async (e) => {
                e.preventDefault();

                const restockFormData = new FormData(e.target);
                console.log(restockFormData);
                try {
                    const result = await fetch(`/products/restock`, {
                        body: restockFormData,
                        method: 'POST'
                    })

                    if (result.status === 400) {
                        const resultBody = await result.json()
                        for (const inputName in resultBody.errors) {
                            const inputWrapper = restockProductForm.querySelector(`#${inputName}`).parentElement
                            inputWrapper.classList.add('form-item--error')
                            const errorElement = htmlToElement(`<small>${resultBody.errors[inputName]}</small>`)
                            inputWrapper.appendChild(errorElement)
                        }
                    } else if (result.status === 201) {

                        // add success message to url search params
                        // window.location.search = new URLSearchParams({
                        //     ...params,
                        //     success: 'Supplier added successfully'
                        // }).toString()
                        Modal.close("restock-product")
                        Notifier.show({
                            text: "Restocked successfully",
                            type: "success",
                            header: "Success",
                        })
                        setTimeout(() => {
                            location.reload()
                        }, 1000)
                    }
                } catch (e) {
                    Notifier.show({
                        closable: true,
                        header: 'Error',
                        type: 'danger',
                        text: e.message
                    })
                }
            })
        }
        catch (e) {
            Notifier.show({
                closable: true,
                header: 'Error',
                type: 'danger',
                text: "Something went wrong",
                duration:5000,
            })
        }
    })
})