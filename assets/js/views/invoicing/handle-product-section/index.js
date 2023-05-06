import {getNewItemRow, itemTableBody} from "./add-products-to-invoice"


const createInvoiceSection = document.querySelector('.create-invoice__section')

if (createInvoiceSection) {
    /**
     * @type {HTMLButtonElement}
     */
    const addNewItemRowButton = document.querySelector('#new-item-row-button')

    addNewItemRowButton.addEventListener('click', () => {
        itemTableBody.appendChild(getNewItemRow())
    })
}

