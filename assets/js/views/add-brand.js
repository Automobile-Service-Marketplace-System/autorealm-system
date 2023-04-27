import { Modal } from "../components/Modal"
import { htmlToElement } from "../utils";
import Notifier from "../components/Notifier";

const addBrandBtn = document.querySelector('#add-brand-btn');


const addBrandForm = htmlToElement(`
                <div>
                     <form class="stock-manager-add-brand-form" id="stock-manager-add-brand-form" method="post">
                     <div class="top-part-form">
                         <div>
                            <h1>Add Brand</h1>
                        </div>
                        <div>
                            <button class="modal-close-btn" type="button"">
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
                                    <div class="form-item--checkbox">
                                        <label for="is_vehicle_brand">Vehicle</label>
                                        <input type="checkbox" name="is_vehicle_brand" id="is_vehicle_brand"value="1">
                                    </div>
                                      <div class="form-item--checkbox">
                                        <label for="is_product_brand">Product</label>
                                        <input type="checkbox" name="is_product_brand" value="1"  id="is_product_brand" checked>
                                    </div>
                                
                                </div>
                                
                            </div> 
                            
   
                            <div class="add-brand-actions">
                                <button class="btn btn--danger btn--thin" type="reset">Reset</button>
                                <button class="btn btn--thin add-Brand-modal-btn" type="button" id="add-brand-modal-btn">Submit</button>
                                <button style="display: none" type="submit" id="add-brand-final-btn"></button>
    
                            </div>
                        </form>
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

    const template = `<div>
                        <h3>Are you sure you want to add this brand?</h3>
                        <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem;margin-top: 1rem">
                            <button class="btn btn--thin btn--danger modal-close-btn" >Cancel</button>                        
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

addBrandForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    try {
        console.log('inside try')
        const result = await fetch('/products/add-brands', {
            method: 'POST',
            body: formData,
        })


        if (result.status === 400) {
            const resultBody = await result.json()
            for (const inputName in resultBody.errors) {
                const inputWrapper = addBrandForm.querySelector(`#${inputName}`).parentElement
                inputWrapper.classList.add('form-item--error')
                const errorElement = htmlToElement(`<small>${resultBody.errors[inputName]}</small>`)
                inputWrapper.appendChild(errorElement)
            }
        }
        else if (result.status === 201) {

            // add success message to url search params
            // window.location.search = new URLSearchParams({
            //     ...params,
            //     success: 'Supplier added successfully'
            // }).toString()
            Modal.close("add-Brand")
            Notifier.show({
                text: "Supplier added successfully",
                type: "success",
                header: "Success",
            })
            setTimeout(() => {
                location.reload()
            }, 4000)

        } else {
            const resData = await result.json()
            console.log(resData.errors.error)
            Modal.close("add-Brand")
            Notifier.show({
                text: "Something went wrong",
                type: "danger",
                header: "Error",
            })
        }
    }
    catch (e) {
        console.log(e);
        Notifier.show({
            closable: true,
            header: 'Error',
            type: 'danger',
            text: e.message
        })
    }
})