import {serviceTableBody, getNewServiceRow} from "./add-services-to-invoice"


const createInvoiceSection = document.querySelector('.create-invoice__section')

if (createInvoiceSection) {
    /**
     * @type {HTMLButtonElement}
     */
    const addNewServiceRowButton = document.querySelector('#new-service-row-button')

    addNewServiceRowButton.addEventListener('click', () => {
        serviceTableBody.appendChild(getNewServiceRow())
    })
}

