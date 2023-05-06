import Notifier from "./Notifier";
import {getItemChangeConfirmationModal} from "../services/cart";

const addToCartButtons = document.querySelectorAll('.add-to-cart');


addToCartButtons.forEach((addToCartButton) => {
    addToCartButton.addEventListener('click', async () => {
        try {
            const productId = Number(addToCartButton.dataset.productid)
            const price = Number(addToCartButton.dataset.price)
            await getItemChangeConfirmationModal(productId, price, 1, 1, "add")
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
        // const formData = new FormData();
        // formData.append('item_code', addToCartButton.getAttribute('data-productId'));
        // try {
        //     const result = await fetch("/cart/add", {
        //         method: "POST",
        //         body: formData,
        //     })
        //     if (result.status === 201) {
        //         Notifier.show({
        //             closable: true,
        //             duration: 5000,
        //             header: "Success",
        //             text: "Item added to cart successfully",
        //             type: "success",
        //         })
        //         const currentCount = parseInt(cartCountElement.innerHTML.trim())
        //         cartCountElement.innerHTML = `${currentCount + 1}`
        //     } else if (result.status === 200) {
        //         Notifier.show({
        //             closable: true,
        //             duration: 5000,
        //             header: "Info",
        //             text: "Item already in cart",
        //             type: "info",
        //         })
        //     } else if (result.status === 401) {
        //         Notifier.show({
        //             closable: true,
        //             header: "Error",
        //             text: "You must login to add to cart",
        //             type: "danger",
        //         })
        //     } else {
        //         Notifier.show({
        //             closable: true,
        //             header: "Error",
        //             text: await result.text(),
        //             type: "danger",
        //         })
        //     }
        // } catch (e) {
        //     Notifier.show({
        //         closable: true,
        //         header: "Error",
        //         text: e.message,
        //         type: "danger",
        //     })
        // }
    })
})