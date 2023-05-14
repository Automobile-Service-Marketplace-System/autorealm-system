import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

/**
 *
 * @type {NodeListOf<HTMLButtonElement>}
 */

const deleteEmployeeButton = document.querySelector('#delete-employee-btn');
console.log(deleteEmployeeButton);
deleteEmployeeButton?.addEventListener("click", () => {
 
    const modalContent = htmlToElement(`
        <div>
            <p>Are you sure you want to delete?</p>
            <div class="button-area">
                <button class="btn btn--danger btn--thin modal-close-btn">Cancel</button>
                <button class="btn btn--thin modal-close-btn">Confirm</button>
            </div>
        </div>
    `);

    const confirmBtn = modalContent.querySelector("button:last-child");
    confirmBtn.addEventListener("click", async () => {
      console.log("Tharushi");
        // console.log(`confirm for product ${deleteProductButton.parentElement.dataset.productid}`)
        try {
            const result = await fetch("/employees/delete", {
                method: "POST",
                body: JSON.stringify({
                    employee_id: deleteEmployeeButton.dataset.employeeid

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
                        text: "Employee deleted successfully",
                        type: "success",
                        header: "Success",
                    })
                    setTimeout(() => {
                        location.reload()
                    }, 800)

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
        key: "delete-employee",
        content: modalContent,
    })

  })