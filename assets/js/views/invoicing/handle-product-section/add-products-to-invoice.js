import {ProductSelector} from "../../../components/ProductSelector";
import {htmlToElement} from "../../../utils";

/**
 * @type {HTMLTableSectionElement}
 */
export const itemTableBody = document.querySelector('.create-invoice__table.create-invoice__table--items > tbody')
/**
 * @type {HTMLInputElement}
 */
export const itemTotalInput = document.querySelector('.create-invoice__table.create-invoice__table--items tfoot input')

let currentItemRow = 0

/**
 * @type {number[]}
 */
let alreadySelectedProducts = []

/**
 * @return {HTMLTableRowElement}
 */
export function getNewItemRow() {
    currentItemRow++
    const element = htmlToElement(
        `<tr data-index="${currentItemRow}">
                <td>
                    <input type="text" placeholder="Product name" name="product_names[]">
                </td>
                <td>
                    <input type="number" placeholder="Qty" name="product_quantities[]" min="1">
                </td>
                <td>
                    <input type="number" placeholder="Unit Price" name="product_unit_prices[]">
                </td>
                <td>
                    <input type="number" placeholder="%" name="product_percentages[]" min="0" max="100">
                </td>
                <td>
                    <input type="number" placeholder="Amount" name="product_amounts[]">
                </td>
            </tr>`
    )
    const productInput = element.querySelector('input[name="product_names[]"]')
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
 * @param {Product[]} products
 */
function addProductsToRow(e, products) {
    if (products.length === 0) return

    /**
     * @type {HTMLTableRowElement}
     */
    let rowElement = e.target.parentElement.parentElement
    console.log(rowElement)

    // setRowValues(rowElement, products[0]);
    decideNewItemOrExistingItem(products[0], false, rowElement)


    let restOfProducts = products.slice(1)
    if (restOfProducts.length === 0) {
        return
    }

    restOfProducts.forEach(product => {
        console.log(product)
        if (rowElement.nextElementSibling) {
            rowElement = rowElement.nextElementSibling
            // setRowValues(rowElement, product);
            decideNewItemOrExistingItem(product, false, rowElement)
        } else {
            console.log("creating new row")
            rowElement = getNewItemRow()
            // setRowValues(rowElement, product, true);
            decideNewItemOrExistingItem(product, true, rowElement)
        }
    })

}


/**
 * @param {Product} product
 * @param {boolean = false} add
 * @param {HTMLTableRowElement | undefined = undefined} rowElement
 */
function decideNewItemOrExistingItem(product, add = false, rowElement = undefined) {
    if (alreadySelectedProducts.includes(product.ID)) {
        console.log("already in")
        rowElement = document.querySelector(`tr[data-productid="${product.ID}"]`)
        setRowValues(rowElement, product, add, true)
    } else {
        setRowValues(rowElement, product, add, false)
    }
}


/**
 * @param {HTMLTableRowElement} rowElement
 * @param {Product} product
 * @param {boolean = false} add
 * @param {boolean = false} alreadyIn
 */
function setRowValues(rowElement, product, add = false, alreadyIn = false) {

    console.log(alreadySelectedProducts)
    if (!alreadyIn) {

        rowElement.dataset.productid = product.ID.toString()
        rowElement.appendChild(
            htmlToElement(
                `<input name="item_codes[]" value="${product.ID}" style="display: none">`
            )
        )

        // for the first product, we don't need to create a new row or traverse to the next row
        let productNameInput = rowElement.querySelector(`input[name="product_names[]"]`)
        productNameInput.value = product.Name


        let productQuantityInput = rowElement.querySelector(`input[name="product_quantities[]"]`)
        productQuantityInput.value = 1

        let productUnitPriceInput = rowElement.querySelector(`input[name="product_unit_prices[]"]`)
        productUnitPriceInput.value = product["Price (LKR)"]

        let productPercentageInput = rowElement.querySelector(`input[name="product_percentages[]"]`)
        productPercentageInput.value = 0

        let productAmountInput = rowElement.querySelector(`input[name="product_amounts[]"]`)
        productAmountInput.value = product["Price (LKR)"]

        // if the product quantity is increased, the amount should be increased accordingly
        productQuantityInput.addEventListener('change', () => {
            // let newAmount = product["Price (LKR)"] * Number(productQuantityInput.value)
            //
            // // check if discount is applied
            // const discount = Number(productPercentageInput.value)
            // if (discount === 0) {
            //     newAmount = (newAmount / 100) * (100 - discount)
            // }
            //
            // // show it with two decimal places
            // productAmountInput.value = newAmount.toFixed(2)
            listenForQuantityAndPercentageChanges(product, {
                quantityElement: productQuantityInput,
                percentageElement: productPercentageInput,
                amountElement: productAmountInput
            })
        })

        productPercentageInput.addEventListener('change', () => {
            // let newAmount = product["Price (LKR)"] * Number(productQuantityInput.value)
            //
            // // check if discount is applied
            // const discount = Number(productPercentageInput.value)
            // if (discount === 0) {
            //     newAmount = (newAmount / 100) * (100 - discount)
            // }
            //
            // // show it with two decimal places
            // productAmountInput.value = newAmount.toFixed(2)
            console.log("percentage changed")
            listenForQuantityAndPercentageChanges(product, {
                quantityElement: productQuantityInput,
                percentageElement: productPercentageInput,
                amountElement: productAmountInput
            })
        })

        if (add) {
            itemTableBody.appendChild(rowElement)
        }

        calculateItemTotal()
        alreadySelectedProducts.push(product.ID)

    } else {
        // get the quantity input
        let productQuantityInput = rowElement.querySelector(`input[name="product_quantities[]"]`)
        // increase the quantity by 1
        productQuantityInput.value = Number(productQuantityInput.value) + 1
        // trigger the change event to update the amount
        productQuantityInput.dispatchEvent(new InputEvent('change'))
    }
}


/**
 * @param {Product} product
 * @param { {quantityElement: HTMLInputElement; percentageElement : HTMLInputElement; amountElement : HTMLInputElement} } elements
 */
function listenForQuantityAndPercentageChanges(product, {quantityElement, percentageElement,amountElement }) {

    let newAmount = product["Price (LKR)"] * Number(quantityElement.value)

    // check if discount is applied
    const discount = Number(percentageElement.value)
    if (discount !== 0) {
        newAmount = (newAmount / 100) * (100 - discount)
    }

    // show it with two decimal places
    amountElement.value = newAmount.toFixed(2)
    calculateItemTotal()
}


function calculateItemTotal() {
    let total = 0
    /**
     * @type {NodeListOf<HTMLInputElement>}
     */
    let itemAmountElements = document.querySelectorAll(`input[name="product_amounts[]"]`)
    itemAmountElements.forEach(element => {
        total += Number(element.value)
    })
    itemTotalInput.value = total.toFixed(2)


    // trigger the change event to update the grand total
    itemTotalInput.dispatchEvent(new InputEvent('change'))
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