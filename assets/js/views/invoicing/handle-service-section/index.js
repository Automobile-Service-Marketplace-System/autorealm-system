import {serviceTableBody, getNewServiceRow} from "./add-services-to-invoice"


const createInvoiceSection = document.querySelector('.create-invoice__section')
/**
 * @type {HTMLButtonElement}
 */
export const addNewServiceRowButton = document.querySelector('#new-service-row-button')


if (createInvoiceSection) {

    addNewServiceRowButton.addEventListener('click', () => {
        serviceTableBody.appendChild(getNewServiceRow())
    })
}

export * from "./add-services-to-invoice"