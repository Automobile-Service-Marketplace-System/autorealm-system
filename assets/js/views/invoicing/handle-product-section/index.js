import {htmlToElement} from "../../../utils";
import {handleFocusOfProductInput, getNewRow} from "./add-products-to-invoice"


const createInvoiceSection = document.querySelector('.create-invoice__section')

if (createInvoiceSection) {
    /**
     * @type {HTMLButtonElement}
     */
    const addNewItemRowButton = document.querySelector('#new-item-row-button')
    /**
     * @type {HTMLTableSectionElement}
     */
    const tableBody = document.querySelector('.create-invoice__table.create-invoice__table--items > tbody')

    /**
     * @type{HTMLInputElement}
     */
    const firstRowInput = tableBody.querySelector('tr')?.querySelector('input')

    firstRowInput.addEventListener('focus', handleFocusOfProductInput)

    addNewItemRowButton.addEventListener('click', () => {
        tableBody.appendChild(getNewRow())
    })

}

