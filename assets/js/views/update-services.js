import{Modal} from '../components/Modal'
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

const updateServiceButton=document.querySelectorAll(".update-service-btn");

const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());

updateServiceButton.forEach(function (btn){
    btn.addEventListener("click",function(){

        const serviceId= btn.dataset.serviceid
        const serviceRow=(btn.parentElement.parentElement.parentElement)

        const serviceENameElement=serviceRow.querySelector('td:nth-child(2)')
        const serviceName=serviceENameElement.textContent;

        const serviceDescriptionElement=serviceRow.querySelector('td:nth-child(3)')
        const serviceDescription=serviceDescriptionElement.textContent;
        console.log(serviceDescription)

        const servicePriceElement=serviceRow.querySelector('td:nth-child(4)')
        const servicePrice=servicePriceElement.textContent;

        const updateServiceForm = htmlToElement(`<form id="update-service-form" style="width: 400px">
            <button class="modal-close-btn">
                <i class="fas fa-times"></i>
            </button>
            <div class="update-service-form__items">
                <div class='form-item '>
                        <label for='name'>Service name<sup>*</sup></label>
                        <input type='text' name='service_name' id='service_name' placeholder='' required  value="${serviceName}">
                </div>
                <div class='form-item '>
                        <label for='price'>Price<sup>*</sup></label>
                        <input type='number' name='price' id='price' placeholder=''  min="0.01" step="0.01" required  value="${servicePrice}">        
                </div>
                <div class='form-item '>
                        <label for='description'>Description<sup>*</sup></label>
                        <textarea name='description' id='description' placeholder=''>${serviceDescription}</textarea>
                </div>       
            </div>
            <div class="update-service-actions">
                <button class="btn btn--danger" type="reset">
                    Reset
                </button>

                <button class="btn" id="update-service-modal-btn" type="button">
                    Update service
                </button>
                <button style="display: none" type="submit" id="update-service-final-btn"></button>
            </div>
            </form>`
        )
        

        updateServiceForm?.querySelector("#update-service-modal-btn")?.addEventListener("click", (e) => {
            const template =  `<div style="width: 350px">
                                <h3>Are you sure you want to update this service?</h3>
                                <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem">
                                    <button class="btn btn--danger modal-close-btn">Cancel</button>                        
                                    <button class="btn modal-close-btn" id="update-service-confirm-btn">Confirm</button>                        
                                </div>
                                </div>`
            const element = htmlToElement(template);
            // console.log(element)
            element.querySelector("#update-service-confirm-btn").addEventListener('click', () => {
                const submitBtn = updateServiceForm?.querySelector("#update-service-final-btn");
                submitBtn?.click();
            })
        
            Modal.show({
                content: element,
                key: "Update service confirmation",
                closable: true,
            })
        })
        

        updateServiceForm?.addEventListener('submit', async (e) => {
            
            e.preventDefault();
            const formData = new FormData(e.target);
            try {
                const result = await fetch("/services/update", {
                    body: formData,
                    method: 'POST'
                })
                if(result.status === 400) {
                    const resultBody = await result.json()
                    for (const inputName in resultBody.errors) {
                        const inputWrapper = updateServiceForm.querySelector(`#${inputName}`).parentElement
                        inputWrapper.classList.add('form-item--error')
                        const errorElement = htmlToElement(`<small>${resultBody.errors[inputName]}</small>`)
                        inputWrapper.appendChild(errorElement)
                    }
                }
                else if (result.status === 201) {
        
                    // add success message to url search params
                    window.location.search = new URLSearchParams({
                        ...params,
                        success: 'Service updated successfully'
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
        
        updateServiceForm?.addEventListener('reset', (e) => {
            const formItems = updateServiceForm.querySelectorAll('.form-item')
            formItems.forEach(item => {
                item.classList.remove('form-item--error')
                const errorElement = item.querySelector('small')
                if (errorElement) {
                    item.removeChild(errorElement)
                }
            })
        })

        Modal.show({
                content: updateServiceForm,
                closable: false,
                key: "updateServiceForm"
        })
    })
})
