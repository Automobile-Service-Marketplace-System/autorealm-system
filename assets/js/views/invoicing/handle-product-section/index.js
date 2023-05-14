import {getNewItemRow, itemTableBody} from "./add-products-to-invoice"


const createInvoiceSection = document.querySelector('.create-invoice__section')
/**
 * @type {HTMLButtonElement}
 */
export const addNewItemRowButton = document.querySelector('#new-item-row-button')


if (createInvoiceSection) {

    addNewItemRowButton.addEventListener('click', () => {
        itemTableBody.appendChild(getNewItemRow())
    })
}


export * from "./add-products-to-invoice"
