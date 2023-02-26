const cutomerUpdateButtons = document.querySelectorAll(".update-customer-btn");
import { Modal } from "../components/Modal";
import { htmlToElement } from "../utils";

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

    const updateCustomerProfileForm = htmlToElement(
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

    const firstNameInput = updateCustomerProfileForm.querySelector("#f_name");
    firstNameInput.value = customerInfo.customerFirstName;

    const lastNameInput = updateCustomerProfileForm.querySelector("#l_name");
    lastNameInput.value = customerInfo.customerLastName;

    const ContactNoInput =updateCustomerProfileForm.querySelector("#contact_no");
    ContactNoInput.value = customerInfo.customerContactNo;

    const addressInput = updateCustomerProfileForm.querySelector("#address");
    addressInput.value = customerInfo.customerAddress;

    const emailInput = updateCustomerProfileForm.querySelector("#email");
    emailInput.value = customerInfo.customerEmail;

    Modal.show({
      key: "Update-customer",
      content: updateCustomerProfileForm,
      closable: false,
    });

  });
});
