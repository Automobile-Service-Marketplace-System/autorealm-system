import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

/**
 *
 * @type {HTMLButtonElement}
 */
const editCustomerProfileButton = document.querySelector("#edit-customer-profile")


const updateCustomerProfileForm = htmlToElement(
    `<form action="/profile" method="post" enctype="multipart/form-data" id="update-customer-profile">
                <div class="modal-header">
                    <h3>
                    Update your profile 
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
                        <label for='address'>Address<sup>*</sup></label>
                        <input type='text' name='address' id='address' placeholder='' required  value=''>      
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
            </form>`)


updateCustomerProfileForm?.querySelector("#update-customer-profile-btn")?.addEventListener("click", (e) => {

    const template = `<div>
                        <h3>Are you sure you want to update?</h3>
                        <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem;margin-top: 1rem">
                            <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
                            <button class="btn btn--thin modal-close-btn" id="update-customer-confirm-btn">Confirm</button>                        
                        </div>
                        </div>`
    const element = htmlToElement(template);
    element.querySelector("#update-customer-confirm-btn").addEventListener('click', () => {
        const submitBtn = updateCustomerProfileForm?.querySelector("#update-customer-profile-final-btn");
        submitBtn?.click();
    })

    Modal.show({
        content: element,
        key: "Update customer profile confirmation",
        closable: true,
    })
})


updateCustomerProfileForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    try {
        const result = await fetch(`/profile`, {
            body: formData,
            method: 'POST'
        })
        if (result.status === 400) {
            const resultBody = await result.json()
            for (const inputName in resultBody.errors) {
                const inputWrapper = updateCustomerProfileForm.querySelector(`#${inputName}`).parentElement
                inputWrapper.classList.add('form-item--error')
                const errorElement = htmlToElement(`<small>${resultBody.errors[inputName]}</small>`)
                inputWrapper.appendChild(errorElement)
            }
        } else if (result.status === 201) {

            // add success message to url search params
            window.location.search = new URLSearchParams({
                ...params,
                success: 'Your profile has been updated successfully'
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

updateCustomerProfileForm?.addEventListener('reset', (e) => {
    const formItems = updateCustomerProfileForm.querySelectorAll('.form-item')
    formItems.forEach(item => {
        item.classList.remove('form-item--error')
        const errorElement = item.querySelector('small')
        if (errorElement) {
            item.removeChild(errorElement)
        }
    })
})

editCustomerProfileButton?.addEventListener("click", () => {
    Modal.show({
        content: updateCustomerProfileForm,
        closable: false,
        key: "updateCustomerProfileForm"
    })
})


