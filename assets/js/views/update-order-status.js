import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

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


let prepTime
let deliverTime
let curConfTime

isPreparedInput?.addEventListener("change",async() => {
    prepTime = new Date().toISOString().slice(0, 19).replace('T', ' ');
    console.log(`isPreparedInput? status: ${isPreparedInput.checked}`);
    console.log(`for order ${isPreparedInput.dataset.orderno}`)
    if(!isPreparedInput.checked){
        prepTime = '0000-00-00 00:00:00'
    }


    console.log(prepTime);
    try{
        const result = await fetch("/orders/view",{
            method: "POST",
            body: JSON.stringify({
                prepared_date_time: prepTime,
                order_no: isPreparedInput.dataset.orderno,
                status: "Prepared"
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        })

        console.log(await result.text())
        switch (result.status) {
            case 204:
                Notifier.show({
                    text: "Status Updated successfully",
                    type: "success",
                    header: "Success",
                })
                break;

            case 500:
                Notifier.show({
                    text: "Something went wrong",
                    type: "danger",
                    header: "Error",
                })
                break;
            default:

                break;

        }
    }catch (e) {
        console.log(e)
        Notifier.show({
            text: "Something went wrong",
            type: "error",
            header: "Error",
        })
    }


})

isInDeliveryInput?.addEventListener("change", function () {
    deliverTime = new Date().toISOString().slice(0, 19).replace('T', ' ');
    console.log(`isInDeliveryInput status: ${isInDeliveryInput.checked}`)
    if(!isInDeliveryInput.checked){
        deliverTime = '0000-00-00 00:00:00'
    }
})

isCurConfirmedInput?.addEventListener("change", function () {
    curConfTime = new Date().toISOString().slice(0, 19).replace('T', ' ');
    console.log(`isCurConfirmedInput status: ${isCurConfirmedInput.checked}`)
    if(!isCurConfirmedInput.checked){
        curConfTime = '0000-00-00 00:00:00'
    }
})

const rotatingIcon = htmlToElement(`<i class="fa-solid fa-spinner rotating-icon"></i>`)
// adding loading effects to all buttons

isPreparedInput?.addEventListener("click", markOrderAsPrepared)
isInDeliveryInput?.addEventListener("click", markOrderAsDelivery)
isCurConfirmedInput?.addEventListener("click", markOrderAsCurConfirmed)

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

async function markOrderAsDelivery(e){
    setSpinner(isInDeliveryInput, true)
    await sleep(500)
    setSpinner(isInDeliveryInput,false)
}

async function markOrderAsCurConfirmed(e){
    setSpinner(isCurConfirmedInput, true)
    await sleep(500)
    setSpinner(isCurConfirmedInput, false);
}


/**
 * @param {HTMLInputElement} element
 * @param {boolean} status
 */
function setSpinner(element, status) {
    const parent = element.parentElement
    if (status) {
        element.style.display = "none"
        parent.append(rotatingIcon)
    } else {
        element.style.display = "initial"
        parent.querySelector(
            ".rotating-icon"
        ).remove()
    }
}

