const cutomerUpdateButtons = document.querySelectorAll(".update-customer-btn");
import { Modal } from "../components/Modal";
import { htmlToElement } from "../utils";
import Notifier from "../components/Notifier";


cutomerUpdateButtons.forEach(function (btn) {
  btn.addEventListener("click", function () {
    const customerId = btn.dataset.customerid;
    const customerRow = btn.parentElement.parentElement.parentElement;

    const customerNameElement = customerRow.querySelector("td:nth-child(2)");
    const customerFullName = customerNameElement.textContent;
    const nameParts = customerFullName.split(" ")
    const customerFirstName = nameParts[0]
    const customerLastName = nameParts[1]

    const customerContactNoElement =customerRow.querySelector("td:nth-child(3)");
    const customerContactNo = customerContactNoElement.textContent;

    const customerAddressElement = customerRow.querySelector("td:nth-child(4)");
    const customerAddress = customerAddressElement.textContent;

    const customerEmailElement = customerRow.querySelector("td:nth-child(5)");
    const customerEmail = customerEmailElement.textContent;

    const customerInfo = {
      customerFirstName,
      customerLastName,
      customerContactNo,
      customerAddress,
      customerEmail,
    };

    const updateCustomerDetailsForm = htmlToElement(
      `<form action="/customers" method="post" enctype="multipart/form-data" id="update-customer-details">
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
                                <input type='text' name='f_name' id='f_name' placeholder='' required  value=''>
                        </div>

                        <div class='form-item'>
                                <label for='l_name'>Last Name<sup>*</sup></label>
                                <input type='text' name='l_name' id='l_name' placeholder='' required  value=''>
                        </div>

                        <div class='form-item'>
                                <label for='address'>Contact No<sup>*</sup></label>
                                <input type='text' name='address' id='contact_no' placeholder='' required  value=''>      
                        </div>

                        <div class='form-item'>
                                <label for='address'>Address<sup>*</sup></label>
                                <input type='text' name='address' id='address' placeholder='' required  value=''>      
                        </div>

                        <div class='form-item'>
                                <label for='address'>Email<sup>*</sup></label>
                                <input type='text' name='address' id='email' placeholder='' required  value=''>      
                        </div>
                        
                        </div>
        
                        <div class="flex-centered-y justify-between mt-4">
                            <button class="btn btn--thin btn--danger" type="reset">
                                Reset
                            </button>
                            <button class="btn btn--thin" id="update-customer-profile-btn" type="button">
                                Update
                            </button>
                            <button style="display: none" type="submit" id="update-customer-profile-final-btn">
                            </button>
                        </div>
                    </form>`
    );

    const firstNameInput = updateCustomerDetailsForm.querySelector("#f_name");
    firstNameInput.value = customerInfo.customerFirstName;

    const lastNameInput = updateCustomerDetailsForm.querySelector("#l_name");
    lastNameInput.value = customerInfo.customerLastName;

    const ContactNoInput = updateCustomerDetailsForm.querySelector("#contact_no");
    ContactNoInput.value = customerInfo.customerContactNo;

    const addressInput = updateCustomerDetailsForm.querySelector("#address");
    addressInput.value = customerInfo.customerAddress;

    const emailInput = updateCustomerDetailsForm.querySelector("#email");
    emailInput.value = customerInfo.customerEmail;

    Modal.show({
      key: "Update-customer",
      content: updateCustomerDetailsForm,
      closable: false,
    });

    // updateCustomerDetailsForm?.querySelector("#update-customer-profile-bt")?.addEventListener("click", (e) => {

    //     const template =  `<div>
    //                         <h3>Are you sure you want to update customer details?</h3>
    //                         <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem;margin-top: 1rem">
    //                             <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
    //                             <button class="btn btn--thin modal-close-btn" id="add-vehicle-confirm-btn">Confirm</button>                        
    //                         </div>
    //                         </div>`
    //     const element = htmlToElement(template);

    //     element.querySelector("#update-customer-profile-btn").addEventListener('click', () => {
    //         const submitBtn = updateCustomerDetailsForm?.querySelector("#update-customer-profile-btn");
    //         submitBtn?.click();
    //     })

    //     updateCustomerDetailsForm?.addEventListener('submit', async (e) => {
    //     e.preventDefault();
    //     const formData = new FormData(e.target);
    //     try {
    //         const result = await fetch(`/customers`, {
    //             body: formData,
    //             method: 'POST'
    //         })
    //         if(result.status === 400) {
    //             const resultBody = await result.json()
    //             for (const inputName in resultBody.errors) {
    //                 const inputWrapper = updateCustomerDetailsForm.querySelector(`#${inputName}`).parentElement
    //                 inputWrapper.classList.add('form-item--error')
    //                 const errorElement = htmlToElement(`<small>${resultBody.errors[inputName]}</small>`)
    //                 inputWrapper.appendChild(errorElement)
    //             }
    //         }
    //          else if (result.status === 201) {
    
    //             // add success message to url search params
    //             window.location.search = new URLSearchParams({
    //                 ...params,
    //                 success: 'Customer updated successfully'
    //             }).toString()
    //             location.reload()
    //         }
    //     } catch (e) {
    //         Notifier.show({
    //             closable: true,
    //             header: 'Error',
    //             type: 'danger',
    //             text: e.message
    //         })
    //     }
    // })

  });
});
