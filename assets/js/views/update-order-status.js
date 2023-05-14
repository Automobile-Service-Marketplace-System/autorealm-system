import {Modal} from "../components/Modal"
import {htmlToElement, setSpinner} from "../utils";
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
let status

isPreparedInput?.addEventListener("change", async () => {
    await updateOrderStatus(isPreparedInput, 'Prepared');
})

isInDeliveryInput?.addEventListener("change", async () => {
    await updateOrderStatus(isInDeliveryInput, 'Delivery');
})

isCurConfirmedInput?.addEventListener("change", async function () {
    await updateOrderStatus(isCurConfirmedInput, 'CourierConfirmed');
})


// const rotatingIcon = htmlToElement(`<i class="fa-solid fa-spinner rotating-icon"></i>`)
//
// /**
//  * @param {HTMLInputElement} element
//  * @param {boolean} status
//  */
// function setSpinner(element, status) {
//     const parent = element.parentElement
//     if (status) {
//         element.style.display = "none"
//         parent.append(rotatingIcon)
//     } else {
//         element.style.display = "initial"
//         parent.querySelector(
//             ".rotating-icon"
//         ).remove()
//     }
// }


/**
 * @param {HTMLInputElement} inputElement
 * @param {"Prepared" | "Delivery" | "CourierConfirmed"} mode
 * @returns {Promise<void>}
 */
async function updateOrderStatus(inputElement, mode) {

    try {
        setSpinner(inputElement, true)
        const result = await fetch("/orders/set-status", {
            method: "POST",
            body: JSON.stringify({
                mode: mode,
                order_no: inputElement.dataset.orderno,
                status: inputElement.checked
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
                setTimeout(() => {
                    location.reload()
                }, 2000);
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
    } catch (e) {
        console.log(e)
        Notifier.show({
            text: "Something went wrong",
            type: "error",
            header: "Error",
        })
    } finally {
        setSpinner(inputElement, false)
    }
}