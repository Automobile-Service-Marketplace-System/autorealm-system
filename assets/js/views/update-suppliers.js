import {htmlToElement}  from "../utils";
import {Modal} from '../components/Modal'
import Notifier from "../components/Notifier";

const supplierUpdateButtons = document.querySelectorAll(".update-supplier-button")
//console.log(supplierUpdateButtons)
const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());

supplierUpdateButtons.forEach(function (btn){

    btn.addEventListener("click", function(){
        //console.log(btn.dataset)

        const supplierId = btn.parentElement.dataset.supplierid
        const supplierName = btn.parentElement.dataset.suppliername
        const address = btn.parentElement.dataset.address
        const salesManager = btn.parentElement.dataset.salesmanager
        const email = btn.parentElement.dataset.email
        const regNo = btn.parentElement.dataset.registrationno

        const supplierRow = btn.parentElement.parentElement.parentElement

        //console.log(supplierRow)

        const supplierInfo= {
            supplierId,
            supplierName,
            address,
            salesManager,
            email,
            regNo
        }
        // console.log("Supplier Info")
         //console.log(supplierInfo)

        const updateSupplierForm = htmlToElement(
            `
            <form class="stock-manager-update-supplier-form" id="stock-manager-update-supplier-form" method="post">
                     <div class="top-part-form">  
                            <h1 class="">Update Supplier Details</h1>
                            <button class="modal-close-btn" type="button">
                                <i class="fas fa-times"></i>
                            </button>
                     </div>
                     
                     <div class="update-supplier-input-wrapper">
                        <div class="form-item">
                            <label for='name'>Supplier Name.<sup>*</sup></label>
                            <input type='text' name='name' id='name' placeholder='' required  value='${supplierInfo.supplierName}'   >
                            <input style='display:none' type='text' name='old_name' id='old_name' value='${supplierInfo.supplierName}'   >
                         </div>
                
                        <div class="form-item">
                            <label for='company_reg_no'>Business Registration No.<sup>*</sup></label>
                            <input type='text' name='company_reg_no' id='company_reg_no' placeholder='' required  value='${supplierInfo.regNo}'   >
                            <input style='display:none' type='text' name='old_company_reg_no' id='old_company_reg_no' value='${supplierInfo.regNo}'   >
                        </div>
                        
                        <div class="form-item">
                            <label for='email'>Email.<sup>*</sup></label>
                            <input type='text' name='email' id='email' placeholder='' required  value='${supplierInfo.email}'   >
                            <input style='display:none' type='text' name='old_email' id='old_email' value='${supplierInfo.email}'   >
                        </div>
                  

                   
                        <div class="form-item">
                            <label for='address'>Address.<sup>*</sup></label>  
                            <input type='text' name='address' id='address' placeholder='' required  value='${supplierInfo.address}'   >
                        </div>
                        
                        <div class="form-item">
                            <label for='sales_manager'>Sales Manager Name.<sup>*</sup></label>
                            <input type='text' name='sales_manager' id='sales_manager' placeholder='' required  value='${supplierInfo.salesManager}'   >
                        </div>
                            <input style="display: none" type="number" value="${supplierInfo.supplierId}" name="supplier_id">
                     </div> 
                     
                     <div class="update-supplier-actions">
                
                            <button class="btn btn--danger" type="reset">Reset</button>
                            <button class="btn update-supplier-modal-btn" type="button" id="update-supplier-modal-btn">Update</button>
                            
                            <button style="display: none" type="submit" id="update-supplier-final-btn"></button>
            
                     </div>
            </form>
            `
        )

        Modal.show({
            key: "update-supplier",
            content: updateSupplierForm ,
            closable: true,
        })

        //Confirmation modal
        updateSupplierForm?.querySelector("#update-supplier-modal-btn")?.addEventListener("click",(e)=>{
            const UpdateSupConfModal = htmlToElement(`<div>
                                       <h3>Are you sure you want to update this details</h3>
                                       <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem;margin-top: 1rem">
                                            <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
                                            <button class="btn btn--thin modal-close-btn" id="update-supplier-confirm-btn">Confirm</button>                        
                                       </div>
                                    </div>`)

            Modal.show({
                closable: true,
                content: UpdateSupConfModal,
                key: "Update Supplier Confirmation",
            })

            UpdateSupConfModal.querySelector("#update-supplier-confirm-btn").addEventListener('click', () => {
                const submitBtn = updateSupplierForm?.querySelector("#update-supplier-final-btn");
                //console.log(submitBtn)
                submitBtn?.click();
                //console.log("Final Button oky")
            })
        })

        updateSupplierForm?.addEventListener('submit', async (e) =>{
            e.preventDefault();
            if(updateSupplierForm.classList.contains("update-supplier-form--error")){
                updateSupplierForm.querySelectorAll(".form-item").forEach((inputWrapper)=>{
                    inputWrapper.classList.remove("form-item--error")
                    inputWrapper.querySelector("small")?.remove()
                })
            }
            //console.log("Inside submit event listener")
            const formData = new FormData(e.target);
            try{
                console.log("Inside try block")
                const result = await fetch("/supplier/update", {
                    body: formData,
                    method: 'POST'

                })
                if(result.status === 400) {
                    updateSupplierForm?.classList.add("update-supplier-form--error");
                    const resultBody = await result.json()
                    for (const inputName in resultBody.errors) {
                        const inputWrapper = updateSupplierForm.querySelector(`#${inputName}`).parentElement
                        inputWrapper.classList.add('form-item--error')
                        const errorElement = htmlToElement(`<small>${resultBody.errors[inputName]}</small>`)
                        inputWrapper.appendChild(errorElement)
                    }
                }
                else if (result.status === 201) {

                    // add success message to url search params
                    window.location.search = new URLSearchParams({
                        ...params,
                        success: 'Supplier updated successfully'
                    }).toString()
                    location.reload()
                }

                else if(result.status === 500){

                    const data = await result.text()
                    console.log(data);
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
        updateSupplierForm?.addEventListener("reset", (e) => {
            const formItems = updateSupplierForm.querySelectorAll(".form-item");
            formItems.forEach((item) => {
                item.classList.remove("form-item--error");
                const errorElement = item.querySelector("small");
                if (errorElement) {
                    item.removeChild(errorElement);
                }
            });
        });

    })
})
