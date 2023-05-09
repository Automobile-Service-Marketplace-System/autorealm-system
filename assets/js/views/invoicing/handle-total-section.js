import {serviceTotalInput} from "./handle-service-section"
import {itemTotalInput} from "./handle-product-section"

const inputs = [serviceTotalInput, itemTotalInput]

/**
 * @type {HTMLInputElement}
 */
const grandTotalInput = document.querySelector('#grand-total')

inputs.forEach(input => {
    input?.addEventListener('change', () => {
        console.log("change")
        let total = 0
        total += Number(serviceTotalInput.value)
        total += Number(itemTotalInput.value)
        grandTotalInput.value = total.toFixed(2)
    })
})