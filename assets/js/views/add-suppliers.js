import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

const addSupplierBtn = document.querySelector('#add-supplier-btn');

const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());

const addSupplierForm = htmlToElement(`<div>

            <form class="stock-manager-add-supplier-form" id="stock-manager-add-supplier-form">
      
            <div class="top-part-form">
                <div>
                    <h1>Supplier Details</h1>
                </div>
                <div>
                    <button class="modal-close-btn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

            </div>
           
            <div class="add-supplier-input-wrapper">
                <div class="form-item">
                    <label for='name'>Supplier Name.<sup>*</sup></label>
                    <input type='text' name='name' id='name' placeholder='' required  value=''   >
                </div>
                
                <div class="form-item">
                    <label for='company_reg_no'>Business Registration No.<sup>*</sup></label>
                    <input type='text' name='company_reg_no' id='company_reg_no' placeholder='' required  value=''   >
                </div>
                
                <div class="form-item">
                    <label for='email'>Email.<sup>*</sup></label>
                    <input type='text' name='email' id='email' placeholder='' required  value=''   >
                </div>
          
                <div class="form-item">
                    <label for='contact_no'>Mobile Number<sup>*</sup></label>
                    <input type='text' name='contact_no' id="contact_no" placeholder='' required  value=''   >
                
                </div>
           
                <div class="form-item">
                    <label for='address'>Address.<sup>*</sup></label>  
                    <input type='text' name='address' id='address' placeholder='' required  value=''   >
                </div>
                
                <div class="form-item">
                    <label for='sales_manager'>Sales Manager Name.<sup>*</sup></label>
                    <input type='text' name='sales_manager' id='sales_manager' placeholder='' required  value=''   >
                </div>
            </div>
            
            <div class="add-supplier-actions">
                
                    <button class="btn btn--danger" type="reset">Reset</button><!--                <button class="btn" id="open-another">Open another modal</button>-->
                    <button class="btn add-sup-button" type="button" id="add-supplier-modal-btn">Submit</button>
                    <button style="display: none" type="submit" id="add-supplier-final-btn"></button>

            </div>
            </form>
           </div>`)

addSupplierForm?.querySelector("#add-supplier-modal-btn")?.addEventListener("click", (e) => {

    const template =  `<div>
                        <h3>Are you sure you want to add this supplier?</h3>
                        <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem;margin-top: 1rem">
                            <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
                            <button class="btn btn--thin modal-close-btn" id="add-supplier-confirm-btn">Confirm</button>                        
                        </div>
                        </div>`


    const element = htmlToElement(template);

    element.querySelector("#add-supplier-confirm-btn").addEventListener('click', () => {
        const submitBtn = addSupplierForm?.querySelector("#add-supplier-final-btn");
        console.log("clicked")
        submitBtn?.click();
    })

    Modal.show({
        content: element,
        key: "Add Supplier confirmation",
        closable: true,
    })
})


addSupplierBtn?.addEventListener('click', () => {

       Modal.show({
           closable: false,
           key: "add-supplier",
           content: addSupplierForm
       })
    } )



addSupplierForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    try {
        const result = await fetch(`/suppliers/add`, {
            body: formData,
            method: 'POST'
        })

        if(result.status === 400) {
            const resultBody = await result.json()
            for (const inputName in resultBody.errors) {
                const inputWrapper = addSupplierForm.querySelector(`#${inputName}`).parentElement
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
            Modal.close("add-supplier")
            Notifier.show({
                text: "Supplier added successfully",
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

addSupplierForm.addEventListener('reset', (e) => {
    const formItems = addSupplierForm.querySelectorAll('.form-item')
    formItems.forEach(item => {
        item.classList.remove('form-item--error')
        const errorElement = item.querySelector('small')
        if (errorElement) {
            item.removeChild(errorElement)
        }
    })
})



