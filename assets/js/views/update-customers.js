import{Modal} from '../components/Modal'
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

const updateCustomerButton=document.querySelectorAll(".update-customer-btn");

const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());

updateCustomerButton.forEach(function (btn){
    btn.addEventListener("click",function(){

      const customerId = btn.dataset.customerid;
      const customerRow = btn.parentElement.parentElement.parentElement;
  
      const customerNameElement = customerRow.querySelector("td:nth-child(2)");
      const customerFullName = customerNameElement.textContent;
      const nameParts = customerFullName.split(" ");
      const customerFirstName = nameParts[0];
      const customerLastName = nameParts[1];
  
      const customerContactNoElement = customerRow.querySelector("td:nth-child(3)");
      const customerContactNo = customerContactNoElement.textContent;
  
      const customerAddressElement = customerRow.querySelector("td:nth-child(4)");
      const customerAddress = customerAddressElement.textContent;
  
        const updatecustomerForm = htmlToElement(`<form id="update-customer-details" method="POST">
        <div class="modal-header">
            <h3>
            Update customer info
            </h3>
        <button class="modal-close-btn">
            <i class="fas fa-times"></i>
        </button>
        </div>

        <div class="grid gap-4">

          <div class='form-item'>
                  <label for='f_name'>First Name<sup>*</sup></label>
                  <input type='text' name='f_name' id='f_name' placeholder='' required  value='${customerFirstName}'>
          </div>

          <div class='form-item'>
                  <label for='l_name'>Last Name<sup>*</sup></label>
                  <input type='text' name='l_name' id='l_name' placeholder='' required  value='${customerLastName}'>
          </div>

          <div class='form-item'>
                  <label for='address'>Contact No<sup>*</sup></label>
                  <input type='text' name='contact_no' id='contact_no' placeholder='' required  value='${customerContactNo}'>
          </div>

          <div class='form-item'>
                  <label for='address'>Address<sup>*</sup></label>
                  <input type='text' name='address' id='address' placeholder='' required  value='${customerAddress}'>
          </div>

        </div>
        <input style="display:none;" name="customer_id" value="${customerId}" readonly>

        <div class="flex-centered-y justify-between mt-4">
            <button class="btn btn--thin btn--danger" type="reset">
                Reset
            </button>
            <button class="btn btn--thin" id="update-customer-modal-btn" type="button">
                Submit
            </button>
            <button style="display: none" type="submit" id="update-customer-final-btn">
            </button>
        </div>
    </form>`
        )
        

        updatecustomerForm?.querySelector("#update-customer-modal-btn")?.addEventListener("click", (e) => {
            const template =  `<div style="width: 350px">
                                <h3>Are you sure you want to update this customer?</h3>
                                <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem" class="mt-4">
                                    <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
                                    <button class="btn btn--thin modal-close-btn" id="update-customer-confirm-btn">Confirm</button>                        
                                </div>
                                </div>`
            const element = htmlToElement(template);
            // console.log(element)
            element.querySelector("#update-customer-confirm-btn").addEventListener('click', () => {
                const submitBtn = updatecustomerForm?.querySelector("#update-customer-final-btn");
                submitBtn?.click();
            })
        
            Modal.show({
                content: element,
                key: "Update customer confirmation",
                closable: true,
            })
        })
        

        updatecustomerForm?.addEventListener('submit', async (e) => {
            
            e.preventDefault();
            const formData = new FormData(e.target);
            try {
                const result = await fetch("/customers/update", {
                    body: formData,
                    method: 'POST'
                })
                if(result.status === 400) {
                    const resultBody = await result.json()
                    for (const inputName in resultBody.errors) {
                        const inputWrapper = updatecustomerForm.querySelector(`#${inputName}`).parentElement
                        inputWrapper.classList.add('form-item--error')
                        const errorElement = htmlToElement(`<small>${resultBody.errors[inputName]}</small>`)
                        inputWrapper.appendChild(errorElement)
                    }
                }
                else if (result.status === 201) {
        
                    // add success message to url search params
                    window.location.search = new URLSearchParams({
                        ...params,
                        success: 'customer updated successfully'
                    }).toString()
                    location.reload()
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
        
        updatecustomerForm?.addEventListener('reset', (e) => {
            const formItems = updatecustomerForm.querySelectorAll('.form-item')
            formItems.forEach(item => {
                item.classList.remove('form-item--error')
                const errorElement = item.querySelector('small')
                if (errorElement) {
                    item.removeChild(errorElement)
                }
            })
        })

        Modal.show({
                content: updatecustomerForm,
                closable: false,
                key: "updatecustomerForm"
        })
    })
})
