import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

/**
 *
 * @type {NodeListOf<HTMLButtonElement>}
 */
const deleteProductButtons = document.querySelectorAll(".delete-product-btn")

deleteProductButtons.forEach(deleteProductButton => {

    deleteProductButton?.addEventListener("click", () => {

        const productRow = deleteProductButton.parentElement.parentElement.parentElement
        const productNameElement = productRow.querySelector('td:nth-child(2)')
        const productName = productNameElement.textContent

        const modalContent = htmlToElement(`
            <div>
                <p>Are you sure you want to delete "${productName}"?</p>
                <div class="button-area">
                    <button class="btn btn--danger btn--thin modal-close-btn">Cancel</button>
                    <button class="btn btn--thin modal-close-btn">Confirm</button>
                </div>
            </div>
        `);

        const confirmBtn = modalContent.querySelector("button:last-child");
        confirmBtn.addEventListener("click", async () => {
            console.log(`confirm for product ${deleteProductButton.parentElement.dataset.productid}`)
            try {
                const result = await fetch("/products/delete", {
                    method: "POST",
                    body: JSON.stringify({
                        product_id: deleteProductButton.parentElement.dataset.productid
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
                            text: "Product deleted successfully",
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
            key: "delete-product",
            content: modalContent,
        })
    })
})