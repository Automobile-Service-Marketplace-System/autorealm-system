import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

const addModelBtn = document.querySelector('#add-model-btn');


const addModelForm = htmlToElement(`<div>
                     <form class="stock-manager-add-model-form" id="stock-manager-add-model-form">
                     <div class="top-part-form">
                         <div>
                            <h1>Add Model</h1>
                        </div>
                        <div>
                            <button class="modal-close-btn">
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
                                        <input type="radio" name="model_type" value="product">
                                    </div>
                                
                                </div>
                                
                            </div> 
                            
                            <div class="form-item">
                                <label for="brand_name">Brand Name<sup>*</sup></label>
                                <select name="brand_id" id="brand_id">
                                    
                                </select>
                                    
                            </div>  
                            <div class="add-model-actions">
                                <button class="btn btn--danger btn--thin" type="reset">Reset</button>
                                <button class="btn btn--thin add-model-modal-btn" type="button" id="add-model-modal-btn">Submit</button>
                                <button style="display: none" type="submit" id="add-model-final-btn"></button>
    
                            </div>
                     
                     `);

addModelBtn?.addEventListener('click', () => {

    console.log('add model button clicked');
    Modal.show({
        closable: false,
        key: 'add-model',
        content: addModelForm,
    })
});

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