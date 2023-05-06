import {htmlToElement} from "../../../utils";
import {ServiceSelector} from "../../../components/ServiceSelector";

/**
 * @type {HTMLTableSectionElement}
 */
export const serviceTableBody = document.querySelector('.create-invoice__table.create-invoice__table--services tbody')
/**
 * @type {HTMLInputElement}
 */
const itemTotalInput = document.querySelector('.create-invoice__table.create-invoice__table--items tfoot input')

let currentItemRow = 0

/**
 * @type {number[]}
 */
let alreadySelectedServices = []

/**
 * @return {HTMLTableRowElement}
 */
export function getNewServiceRow() {
    currentItemRow++
    const element = htmlToElement(
        `<tr data-index="${currentItemRow}">
                <td>
                    <input type="text" placeholder="Service / Labor" name="service_names[]">
                </td>
                <td>
                    <input type="number" placeholder="Cost" name="service_costs[]" min="1">
                </td>
                <td>
                    <input type="number" placeholder="Discount" name="service_discounts[]" min="0" max="100">
                </td>
                <td>
                    <input type="number" placeholder="Amount" name="service_amounts[]">
                </td>
            </tr>`
    )
    const serviceInput = element.querySelector('input[name="service_names[]"]')
    serviceInput.addEventListener('focus', handleFocusOfServiceInput)
    return element
}


/**
 * @param {FocusEvent} e
 * @return {Promise<void>}
 */
export async function handleFocusOfServiceInput(e) {
    const serviceSelector = await new ServiceSelector();
    serviceSelector.addEventListener("onFinish", (services) => {
        console.log(services)
        // return addServicesToRow(e, services)
    })
}


/**
 * @param {FocusEvent} e
 * @param {Service[]} services
 */
function addServicesToRow(e, services) {
    if (services.length === 0) return

    /**
     * @type {HTMLTableRowElement}
     */
    let rowElement = e.target.parentElement.parentElement
    console.log(rowElement)

    // setRowValues(rowElement, services[0]);
    decideNewItemOrExistingItem(services[0], false, rowElement)


    let restOfServices = services.slice(1)
    if (restOfServices.length === 0) {
        return
    }

    restOfServices.forEach(service => {
        console.log(service)
        if (rowElement.nextElementSibling) {
            rowElement = rowElement.nextElementSibling
            // setRowValues(rowElement, service);
            decideNewItemOrExistingItem(service, false, rowElement)
        } else {
            console.log("creating new row")
            rowElement = getNewItemRow()
            // setRowValues(rowElement, service, true);
            decideNewItemOrExistingItem(service, true, rowElement)
        }
    })

}


/**
 * @param {Service} service
 * @param {boolean = false} add
 * @param {HTMLTableRowElement | undefined = undefined} rowElement
 */
function decideNewItemOrExistingItem(service, add = false, rowElement = undefined) {
    if (alreadySelectedServices.includes(service.ID)) {
        console.log("already in")
        rowElement = document.querySelector(`tr[data-serviceid="${service.ID}"]`)
        setRowValues(rowElement, service, add, true)
    } else {
        setRowValues(rowElement, service, add, false)
    }
}


/**
 * @param {HTMLTableRowElement} rowElement
 * @param {Service} service
 * @param {boolean = false} add
 * @param {boolean = false} alreadyIn
 */
function setRowValues(rowElement, service, add = false, alreadyIn = false) {

    console.log(alreadySelectedServices)
    if (!alreadyIn) {

        rowElement.dataset.serviceid = service.ID.toString()
        rowElement.appendChild(
            htmlToElement(
                `<input name="item_codes[]" value="${service.ID}" style="display: none">`
            )
        )

        // for the first service, we don't need to create a new row or traverse to the next row
        let serviceNameInput = rowElement.querySelector(`input[name="service_names[]"]`)
        serviceNameInput.value = service.Name


        let serviceQuantityInput = rowElement.querySelector(`input[name="service_quantities[]"]`)
        serviceQuantityInput.value = 1

        let serviceUnitPriceInput = rowElement.querySelector(`input[name="service_unit_prices[]"]`)
        serviceUnitPriceInput.value = service["Price (LKR)"]

        let servicePercentageInput = rowElement.querySelector(`input[name="service_percentages[]"]`)
        servicePercentageInput.value = 0

        let serviceAmountInput = rowElement.querySelector(`input[name="service_amounts[]"]`)
        serviceAmountInput.value = service["Price (LKR)"]

        // if the service quantity is increased, the amount should be increased accordingly
        serviceQuantityInput.addEventListener('change', () => {
            // let newAmount = service["Price (LKR)"] * Number(serviceQuantityInput.value)
            //
            // // check if discount is applied
            // const discount = Number(servicePercentageInput.value)
            // if (discount === 0) {
            //     newAmount = (newAmount / 100) * (100 - discount)
            // }
            //
            // // show it with two decimal places
            // serviceAmountInput.value = newAmount.toFixed(2)
            listenForQuantityAndPercentageChanges(service, {
                quantityElement: serviceQuantityInput,
                percentageElement: servicePercentageInput,
                amountElement: serviceAmountInput
            })
        })

        servicePercentageInput.addEventListener('change', () => {
            // let newAmount = service["Price (LKR)"] * Number(serviceQuantityInput.value)
            //
            // // check if discount is applied
            // const discount = Number(servicePercentageInput.value)
            // if (discount === 0) {
            //     newAmount = (newAmount / 100) * (100 - discount)
            // }
            //
            // // show it with two decimal places
            // serviceAmountInput.value = newAmount.toFixed(2)
            console.log("percentage changed")
            listenForQuantityAndPercentageChanges(service, {
                quantityElement: serviceQuantityInput,
                percentageElement: servicePercentageInput,
                amountElement: serviceAmountInput
            })
        })

        if (add) {
            itemTableBody.appendChild(rowElement)
        }

        calculateItemTotal()
        alreadySelectedServices.push(service.ID)

    } else {
        // get the quantity input
        let serviceQuantityInput = rowElement.querySelector(`input[name="service_quantities[]"]`)
        // increase the quantity by 1
        serviceQuantityInput.value = Number(serviceQuantityInput.value) + 1
        // trigger the change event to update the amount
        serviceQuantityInput.dispatchEvent(new InputEvent('change'))
    }
}


/**
 * @param {Service} service
 * @param { {quantityElement: HTMLInputElement; percentageElement : HTMLInputElement; amountElement : HTMLInputElement} } elements
 */
function listenForQuantityAndPercentageChanges(service, {quantityElement, percentageElement,amountElement }) {

    let newAmount = service["Price (LKR)"] * Number(quantityElement.value)

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
    let itemAmountElements = document.querySelectorAll(`input[name="service_amounts[]"]`)
    itemAmountElements.forEach(element => {
        total += Number(element.value)
    })
    itemTotalInput.value = total.toFixed(2)


    // trigger the change event to update the grand total
    itemTotalInput.dispatchEvent(new InputEvent('change'))
}

/**
 * @typedef {Object} Service
 * @property {string} Name
 * @property {string} Code
 * @property {string} Description
 * @property {number} Cost
 */