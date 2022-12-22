import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";

const addSupplierBtn = document.querySelector('#add-supplier-btn');

addSupplierBtn?.addEventListener('click', () => {

    const addSupplier = `<div>
            <button class="modal-close-btn">
                <i class="fas fa-times"></i>
            </button>
            <form action="/stock-manager-dashboard/suppliers" method="post" class="stock-manager-add-supplier-form" enctype="multipart/form-data">
            <h1>Supplier Details</h1>
            
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
            <div>
       
            <div class="form-item">
                <label for='address'>Address.<sup>*</sup></label>  
                <input type='text' name='address' id='address' placeholder='' required  value=''   >
            </div>
            
            <div class="form-item">
                <label for='sales_manager'>Sales Manager Name.<sup>*</sup></label>
                <input type='text' name='sales_manager' id='sales_manager' placeholder='' required  value=''   >
            
            <div class="add-supplier-actions">
                <div>
                    <button class="btn btn--danger" type="reset">Reset</button>
                </div>
                <div>
<!--                <button class="btn" id="open-another">Open another modal</button>-->
                    <button class="btn add-sup-button" >Submit</button>
                </div>
            </div>
           </div>`
    //console.log(template)
    const element = htmlToElement(addSupplier);
    //console.log(element)
    //const openAnotherBtn = element.querySelector('#open-another');
   // openAnotherBtn?.addEventListener('click', () => {
       Modal.show({
           key: "add-supplier",
           closable: true,
           content: element
       })
    } )
// import {Modal} from "../components/Modal"

//     Modal.show({
//         key: "add-supplier",
//         closable: false,
//         content: element
//     })
// })
// const addSupplierButton = document.querySelector("#add-supplier")