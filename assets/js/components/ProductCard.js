import Notifier from "./Notifier";
import {getItemChangeConfirmationModal} from "../services/cart";
import {setSpinner} from "../utils";

const addToCartButtons = document.querySelectorAll('.add-to-cart');


addToCartButtons.forEach((addToCartButton) => {
    addToCartButton.addEventListener('click', async () => {
        try {
            setSpinner(addToCartButton.querySelector(".cart-icon"), true)
            const productId = Number(addToCartButton.dataset.productid)
            const price = Number(addToCartButton.dataset.price)
            await getItemChangeConfirmationModal(productId, price, 1, 1, "add")
            setSpinner(addToCartButton.querySelector(".cart-icon"), false)
        } catch (e) {
            console.log(e.message)
            Notifier.show({
                type: 'danger',
                header: 'Error',
                text: "Something went wrong<br>Please try again later",
                closable: true,
                duration: 5000
            })
        }
    })
})