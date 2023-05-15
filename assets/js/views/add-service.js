import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

const addServiceButton = document.querySelector("#add-service")

const urlSearchParams = new URLSearchParams(window.location.search);
//query string parameters in the current URL.
const params = Object.fromEntries(urlSearchParams.entries())
//get the query string parameters from the current URL in a web browser using JavaScript.


//takes an HTML string and converts it into a DOM element
const addServiceForm = htmlToElement(`<form id="add-service-form" style="width: 400px">
<button class="modal-close-btn">
    <i class="fas fa-times"></i>
</button>
<div class="add-service-form__items">
    <div class='form-item '>
            <label for='name'>Service name<sup>*</sup></label>
            <input type='text' name='service_name' id='service_name' placeholder='' required  value=''>
    </div>
    <div class='form-item '>
            <label for='price'>Price<sup>*</sup></label>
            <input type='number' name='price' id='price' placeholder=''  min="0.01" step="0.01" required  value=''>        
    </div>
    <div class='form-item '>
            <label for='description'>Description<sup>*</sup></label>
            <textarea name='description' id='description' placeholder='' required ></textarea>
      </div>       
</div>
<div class="add-vehicle-actions">
    <button class="btn btn--danger" type="reset">
        Reset
    </button>

    <button class="btn" id="add-service-modal-btn" type="button">
        Add service
    </button>
    <button style="display: none" type="submit" id="add-service-final-btn"></button>
</div>
</form>`)


addServiceForm?.querySelector("#add-service-modal-btn")?.addEventListener("click", (e) => {

    const template =  `<div style="width: 350px">
                        <h3>Are you sure you want to add this vehicle?</h3>
                        <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem;margin-top: 1.5rem">
                            <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
                            <button class="btn btn--thin modal-close-btn" id="add-vehicle-confirm-btn">Confirm</button>                        
                        </div>
                        </div>`
    //takes an element and converts it into a DOM element
    const element = htmlToElement(template);
    //When the "Confirm" button is clicked, the function specified addEventListener() is executed
    element.querySelector("#add-vehicle-confirm-btn").addEventListener('click', () => {
        const submitBtn = addServiceForm?.querySelector("#add-service-final-btn");
        submitBtn?.click();
    })

    Modal.show({
        content: element,
        key: "Add service confirmation",
        //modal can be closed by clicking outside of it or pressing the escape key. If true
        closable: true,
    })
})


addServiceForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    try {
        //The await keyword is used to wait for the response from the server
        const result = await fetch("/services/add", {
            body: formData,
            method: 'POST'
        })
        if(result.status === 400) {
            //he result.json() method is used to extract the JSON-encoded data
            const resultBody = await result.json()
            for (const inputName in resultBody.errors) {
                const inputWrapper = addServiceForm.querySelector(`#${inputName}`).parentElement
                inputWrapper.classList.add('form-item--error')
                const errorElement = htmlToElement(`<small>${resultBody.errors[inputName]}</small>`)
                inputWrapper.appendChild(errorElement)
            }
        }
        else if (result.status === 201) {

            // add success message to url search params
            window.location.search = new URLSearchParams({
                ...params,
                success: 'Service added successfully'
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

addServiceForm?.addEventListener('reset', (e) => {
    const formItems = addServiceForm.querySelectorAll('.form-item')
    formItems.forEach(item => {
        item.classList.remove('form-item--error')
        const errorElement = item.querySelector('small')
        if (errorElement) {
            item.removeChild(errorElement)
        }
    })
})

addServiceButton?.addEventListener("click", () => {
    Modal.show({
        content: addServiceForm,
        closable: false,
        key: "addServiceForm"
    })
})

