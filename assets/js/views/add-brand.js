import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

const addBrandBtn = document.querySelector('#add-brand-btn');


const addBrandForm = htmlToElement(`<div>
                     <form class="stock-manager-add-brand-form" id="stock-manager-add-brand-form">
                     <div class="top-part-form">
                         <div>
                            <h1>Add Brand</h1>
                        </div>
                        <div>
                            <button class="modal-close-btn">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                     </div>
                     
                     <div class="add-brand-input-wrapper">
                            <div class="form-item">
                                <label for="brand_name">Brand Name<sup>*</sup></label>
                                <input type="text" name="brand_name" id="brand_name" placeholder="" required value="" >
                            </div>
                            
                            <div class="form-item">
                            <p>Brand Type</p>
                                <div class="brand-type-radio-group">
                                    <div class="form-item--radio">
                                        <label for="brand_type">Vehicle</label>
                                        <input type="radio" name="brand_type" value="vehicle">
                                    </div>
                                      <div class="form-item--radio">
                                        <label for="brand_type">Product</label>
                                        <input type="radio" name="brand_type" value="product">
                                    </div>
                                
                                </div>
                                
                            </div> 
                            
   
                            <div class="add-brand-actions">
                                <button class="btn btn--danger btn--thin" type="reset">Reset</button>
                                <button class="btn btn--thin add-Brand-modal-btn" type="button" id="add-brand-modal-btn">Submit</button>
                                <button style="display: none" type="submit" id="add-brand-final-btn"></button>
    
                            </div>
                     
                     `);

addBrandBtn?.addEventListener('click', () => {

    console.log('add brand button clicked');
    Modal.show({
        closable: false,
        key: 'add-Brand',
        content: addBrandForm,
    })
});

addBrandForm?.querySelector("#add-brand-modal-btn")?.addEventListener("click", (e) => {

    const template =  `<div>
                        <h3>Are you sure you want to add this brand?</h3>
                        <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem;margin-top: 1rem">
                            <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
                            <button class="btn btn--thin modal-close-btn" id="add-brand-confirm-btn">Confirm</button>                        
                        </div>
                        </div>`


    const element = htmlToElement(template);

    element.querySelector("#add-brand-confirm-btn").addEventListener('click', () => {
        const submitBtn = addBrandForm?.querySelector("#add-brand-final-btn");
        console.log("clicked")
        submitBtn?.click();
    })

    Modal.show({
        content: element,
        key: "Add Brand confirmation",
        closable: true,
    })
})