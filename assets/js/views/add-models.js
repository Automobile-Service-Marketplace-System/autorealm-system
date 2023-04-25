import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";
import {supportsEventListenerOptions} from "chart.js/helpers";

const addModelBtn = document.querySelector('#add-model-btn');

addModelBtn?.addEventListener('click', async function (btn) {
    try {
        const result = await fetch('/product/brands-options-json', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        });

        switch (result.status) {
            case 404:
                Notifier.show({
                    text: "No brands found",
                    type: "error",
                    header: "Error"
                })
                return;

            case 200:
                /**
                 * @type {Array<{brand_id: number, brand_name: string}>}
                 */
                const brands = await result.json();
                console.log(brands);

                let brandOptions = brands.map(brand => {
                    return `<option value="${brand.brand_id}">${brand.brand_name}</option>`
                }).join("");

                const addModelForm = htmlToElement(`<div>
                     <form class="stock-manager-add-model-form" id="stock-manager-add-model-form">
                     <div class="top-part-form">
                         <div>
                            <h1>Add Model</h1>
                        </div>
                        <div>
                            <button class="modal-close-btn" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                     </div>
                     
                     <div class="add-model-input-wrapper">
                            <div class="form-item">
                                <label for="model_name">Model Name<sup>*</sup></label>
                                <input type="text" name="model_name" id="model_name" placeholder="" required value="" >
                            </div>
                            
                            <div class="form-item">
                            <p>Model Type</p>
                                <div class="model-type-radio-group">
                                    <div class="form-item--radio">
                                        <label for="model_type">Vehicle</label>
                                        <input type="radio" name="model_type" value="vehicle">
                                    </div>
                                      <div class="form-item--radio">
                                        <label for="model_type">Product</label>
                                        <input type="radio" name="model_type" value="product" checked>
                                    </div>
                                
                                </div>
                                
                            </div> 
                            
                            <div class="form-item">
                                <label for="brand_name">Brand Name<sup>*</sup></label>
                                <select name="brand_id" id="brand_id">
                                    ${brandOptions}
                                </select>
                                    
                            </div>  
                            <div class="add-model-actions">
                                <button class="btn btn--danger btn--thin" type="reset">Reset</button>
                                <button class="btn btn--thin add-model-modal-btn" type="button" id="add-model-modal-btn">Submit</button>
                                <button style="display: none" type="submit" id="add-model-final-btn"></button>
    
                            </div>
                     
                     `);

                console.log('add model button clicked');
                Modal.show({
                    closable: false,
                    key: 'add-model',
                    content: addModelForm,
                })


                addModelForm?.querySelector("#add-model-modal-btn")?.addEventListener("click", (e) => {

                    const template =  `<div>
                        <h3>Are you sure you want to add this model?</h3>
                        <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem;margin-top: 1rem">
                            <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
                            <button class="btn btn--thin modal-close-btn" id="add-model-confirm-btn">Confirm</button>                        
                        </div>
                        </div>`


                    const element = htmlToElement(template);

                    element.querySelector("#add-model-confirm-btn").addEventListener('click', () => {
                        const submitBtn = addModelForm?.querySelector("#add-model-final-btn");
                        console.log("clicked")
                        submitBtn?.click();
                    })

                    Modal.show({
                        content: element,
                        key: "Add model confirmation",
                        closable: true,
                    })
                })

                addModelForm?.addEventListener("submit", async (e) => {
                    e.preventDefault();
                    const addModelFormData = new FormData(e.target);
                    try{
                        const result = await fetch('/products/add-model', {
                            method: 'POST',
                            body: addModelFormData,
                        });

                        switch (result.status) {
                            case 201:
                                Modal.close('add-model');
                                Notifier.show({
                                    closable: true,
                                    header: 'Success',
                                    type: 'success',
                                    text: "Model added successfully",
                                    duration:5000,
                                })
                                break;
                            case 400:
                                const resultBody = await result.json();
                                for(const inputName in resultBody.errors) {
                                    const inputWrapper = addModelForm.querySelector(`#${inputName}`).parentElement
                                    inputWrapper.classList.add('form-item--error')
                                    const errorElement = htmlToElement(`<small>${resultBody.errors[inputName]}</small>`)
                                    inputWrapper.appendChild(errorElement)
                                }

                                Notifier.show({
                                    closable: true,
                                    header: 'Error',
                                    type: 'danger',
                                    text: resultBody.message,
                                    duration:5000,
                                })
                                break;
                            case 500:
                                Notifier.show({
                                    closable: true,
                                    header: 'Error',
                                    type: 'danger',
                                    text: "Something went wrong",
                                    duration:5000,
                                })
                                break;
                        }
                    }
                    catch (e) {
                        Notifier.show({
                            closable: true,
                            header: 'Error',
                            type: 'danger',
                            text: e.message
                        })
                    }
                })

        }
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





});
