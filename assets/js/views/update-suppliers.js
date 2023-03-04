import {htmlToElement}  from "../utils";
import {Modal} from '../components/Modal'
import Notifier from "../components/Notifier";

const supplierUpdateButtons = document.querySelectorAll(".update-supplier-button")
//console.log(supplierUpdateButtons)

supplierUpdateButtons.forEach(function (btn){

    btn.addEventListener("click", function(){
        //console.log(btn.dataset)

        const supplierId = btn.dataset.supplierid
        const supplierName = btn.dataset.suppliername
        const address = btn.dataset.address
        const salesManager = btn.dataset.salesmanager
        const email = btn.dataset.email
        const regNo = btn.dataset.registrationno

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
            <form class="stock-manager-update-supplier-form" id="stock-manager-update-supplier-form">
                     <div class="top-part-form">  
                            <h1 class="">Update Supplier Details</h1>
                            <button class="modal-close-btn">
                                <i class="fas fa-times"></i>
                            </button>
                     </div>
                     
                     <div class="update-supplier-input-wrapper">
                        <div class="form-item">
                            <label for='name'>Supplier Name.<sup>*</sup></label>
                            <input type='text' name='name' id='name' placeholder='' required  value='${supplierInfo.supplierName}'   >
                         </div>
                
                        <div class="form-item">
                            <label for='company_reg_no'>Business Registration No.<sup>*</sup></label>
                            <input type='text' name='company_reg_no' id='company_reg_no' placeholder='' required  value='${supplierInfo.regNo}'   >
                        </div>
                        
                        <div class="form-item">
                            <label for='email'>Email.<sup>*</sup></label>
                            <input type='text' name='email' id='email' placeholder='' required  value='${supplierInfo.email}'   >
                        </div>
                  

                   
                        <div class="form-item">
                            <label for='address'>Address.<sup>*</sup></label>  
                            <input type='text' name='address' id='address' placeholder='' required  value='${supplierInfo.address}'   >
                        </div>
                        
                        <div class="form-item">
                            <label for='sales_manager'>Sales Manager Name.<sup>*</sup></label>
                            <input type='text' name='sales_manager' id='sales_manager' placeholder='' required  value='${supplierInfo.salesManager}'   >
                        </div>
                            <input style="display: none" type="number" value="${supplierInfo.supplierId}" name="supplierId">
                     </div> 
            </form>
            `
        )

        Modal.show({
            key: "update-supplier",
            content: updateSupplierForm ,
            closable: true,
        })

    })
})
