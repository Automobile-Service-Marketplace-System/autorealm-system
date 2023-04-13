import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

/**
 *
 * @type {NodeListOf<HTMLButtonElement>}
 */
const deleteServiceButtons = document.querySelectorAll(".delete-service-btn")

deleteServiceButtons.forEach(deleteServiceButton => {
    console.log('Tharushi');
    deleteServiceButton?.addEventListener("click", () => {

        const serviceRow = deleteServiceButton.parentElement.parentElement.parentElement
        const serviceNameElement = serviceRow.querySelector('td:nth-child(2)')
        const serviceName = serviceNameElement.textContent

        const modalContent = htmlToElement(`
            <div>
                <p>Are you sure you want to delete "${serviceName}"?</p>
                <div class="button-area">
                    <button class="btn btn--danger btn--thin modal-close-btn">Cancel</button>
                    <button class="btn btn--thin modal-close-btn">Confirm</button>
                </div>
            </div>
        `);

        const confirmBtn = modalContent.querySelector("button:last-child");
        confirmBtn.addEventListener("click", async () => {
            console.log(`confirm for service ${deleteServiceButton.parentElement.dataset.serviceid}`)
            try {
                const result = await fetch("/services/delete", {
                    method: "POST",
                    body: JSON.stringify({
                        servicecode: deleteServiceButton.parentElement.dataset.serviceid
                    }),
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })

                console.log(await result.text())

                // const

                switch (result.status) {
                    case 204:
                        Notifier.show({
                            text: "Service deleted successfully",
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

                        break

                }
            } catch (e) {
                console.log(e)
                Notifier.show({
                    text: "Something went wrong",
                    type: "error",
                    header: "Error",
                })
            }
        })

        Modal.show({
            key: "delete-service",
            content: modalContent,
        })
    })
})