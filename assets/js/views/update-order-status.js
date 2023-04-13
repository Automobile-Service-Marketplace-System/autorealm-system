import {htmlToElement} from "../utils";

/**
 * @type {HTMLInputElement | null}
 */
const isPreparedInput = document.querySelector("#is_prepared");
/**
 * @type {HTMLInputElement | null}
 */
const isInDeliveryInput = document.querySelector("#is_delivery");
/**
 * @type {HTMLInputElement | null}
 */
const isCurConfirmedInput = document.querySelector("#is_cur_confirmed");




isPreparedInput?.addEventListener("change", function () {
    console.log(`isPreparedInput? status: ${isPreparedInput.checked}`)
})

isInDeliveryInput?.addEventListener("change", function () {
    console.log(`isInDeliveryInput status: ${isInDeliveryInput.checked}`)
})

isCurConfirmedInput?.addEventListener("change", function () {
    console.log(`isCurConfirmedInput status: ${isCurConfirmedInput.checked}`)
})

const rotatingIcon = htmlToElement(`<i class="fa-solid fa-spinner rotating-icon"></i>`)
isPreparedInput?.addEventListener("click", markOrderAsPrepared)

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

/**
 * @param {InputEvent} e
 */
async function markOrderAsPrepared(e) {
    setSpinner(isPreparedInput, true)
    await sleep(500)
    setSpinner(isPreparedInput, false)
}
/**
 * @param {HTMLInputElement} element
 * @param {boolean} status
 */
function setSpinner(element, status) {
    const parent = element.parentElement
    if(status) {
        element.style.display = "none"
        parent.append(rotatingIcon)
    } else {
        element.style.display = "initial"
        parent.querySelector(
            ".rotating-icon"
        ).remove()
    }
}





