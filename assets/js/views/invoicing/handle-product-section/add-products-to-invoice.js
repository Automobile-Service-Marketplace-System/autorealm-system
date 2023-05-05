import {ProductSelector} from "../../../components/ProductSelector";
import {htmlToElement} from "../../../utils";

export function getNewRow() {
    const element = htmlToElement(
        `<tr>
                <td>
                    <input type="text" placeholder="Product name">
                </td>
                <td>
                    <input type="number" placeholder="Quantity">
                </td>
                <td>
                    <input type="number" placeholder="Unit Price">
                </td>
                <td>
                    <input type="number" placeholder="%">
                </td>
                <td>
                    <input type="number" placeholder="Amount">
                </td>
            </tr>`
    )
    const productInput = element.querySelector('input')
    productInput.addEventListener('focus', handleFocusOfProductInput)
    return element
}


/**
 * @param {FocusEvent} e
 * @return {Promise<void>}
 */
export async function handleFocusOfProductInput(e) {
    const productSelector = await new ProductSelector();
    productSelector.addEventListener("onFinish", (products) => {
        return addProductsToRow(e, products)
    })
}


/**
 * @param {FocusEvent} e
 * @param {} products
 */
function addProductsToRow(e, products) {
    if (products.length === 0) return

    // console.log(e, products);

    /**
     * @type {HTMLTableRowElement}
     */
    let rowElement = e.target.parentElement.parentElement


    const allInputs = Array.from
    (rowElement.querySelectorAll('input'))


    /**
     * @type {HTMLInputElement}
     */
    const productNameInput = rowElement.querySelector('input[name=product_name]')
    productNameInput.value = products[0].Name

    const productPriceAmountInput = rowElement.querySelector('input[name=product_price]')
    productPriceAmountInput.value = products[0]["Price (LKR)"]

    console.log(`productPriceAmountInput.value: ${productPriceAmountInput.value}`)

    products.forEach(product => {
        console.log(product)
        // try to find sibling rows
        rowElement = rowElement.nextElementSibling
        if (!rowElement) {
            const tableBody = document.querySelector('.create-invoice__table.create-invoice__table--items > tbody')
            const newRow = getNewRow()
            const allInputs = Array.from(document.querySelectorAll('input'))

            const productNameInput = allInputs[0]
            productNameInput.value = products[0].Name

        } else {
            const allInputs = Array.from
            (rowElement.querySelectorAll('input'))


            const productNameInput = allInputs[0]
            productNameInput.value = products[0].Name
        }

    })

    console.log(allInputs);

}


/**
 * @typedef {Object} Product
 * @property {number} ID
 * @property {string} Name
 * @property {string} Category
 * @property {string} Model
 * @property {string} Brand
 * @property {string} "Price (LKR)"
 * @property {number} Quantity
 * @property {string} Image
 */