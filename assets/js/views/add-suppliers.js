import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

const addSupplierBtn = document.querySelector('#add-supplier-btn');


const addSupplierForm = htmlToElement(`<div>

            <form action="/stock-manager-dashboard/suppliers" method="post" class="stock-manager-add-supplier-form" enctype="multipart/form-data" id="stock-manager-add-supplier-form">
      
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
                    <button class="btn add-sup-button" >Submit</button>
                
            </div>
            </form>
           </div>`)

addSupplierBtn?.addEventListener('click', () => {

    //const addSupplier =
    //console.log(template)
    //const element = htmlToElement(addSupplier);
    //console.log(element)
    //const openAnotherBtn = element.querySelector('#open-another');
   // openAnotherBtn?.addEventListener('click', () => {
       Modal.show({
           closable: true,
           key: "add-supplier",
           content: addSupplierForm
       })
    } )

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
// import {Modal} from "../components/Modal"

//     Modal.show({
//         key: "add-supplier",
//         closable: false,
//         content: element
//     })
// })
// const addSupplierButton = document.querySelector("#add-supplier")