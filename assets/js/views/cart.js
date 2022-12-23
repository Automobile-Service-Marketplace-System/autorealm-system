import Notifier from "../components/Notifier";
import {htmlToElement} from "../utils";
import {Modal} from "../components/Modal";

const cartItemIncreaseButtons = document.querySelectorAll('.cart-action.cart-action--increase');
const cartItemDecreaseButtons = document.querySelectorAll('.cart-action.cart-action--decrease');
const cartItemDeleteButtons = document.querySelectorAll('.cart-item-delete');

const cartCountElement = document.querySelector('#cart-count')

/**
 *
 * @param {number} productId
 * @param {number} by
 * @param {number} price
 * @returns {Promise<void>}
 */
async function updateCart({productId, by, price}) {
    try {
        const formData = new FormData();
        formData.append('item_code', productId.toString());
        formData.append('by', by.toString());
        const result = await fetch(`/shopping-cart/update`, {
            body: formData,
            method: 'post'
        })
        if (result.status === 200) {

            Notifier.show(
                {
                    type: 'success',
                    header: 'Success',
                    text: 'Cart updated successfully',
                    closable: true,
                    duration: 5000
                }
            )

            const {amount} = await result.json()
            const amountP = document.querySelector(`#cart-amount-${productId}`)
            if (amountP) amountP.innerHTML = amount

            const totalPrice = `Total: Rs. ${price * amount}.00`
            const totalP = document.querySelector(`#cart-amount-${productId}-total`)
            if (totalP) totalP.innerHTML = totalPrice

            // if(by < 0) {
            //     const currentCount = parseInt(cartCountElement.innerHTML.trim())
            //     cartCountElement.innerHTML = `${currentCount + by}`
            // } else {
            //     const currentCount = parseInt(cartCountElement.innerHTML.trim())
            //     cartCountElement.innerHTML = `${currentCount + by}`
            // }

        } else if (result.status === 401) {
            Notifier.show(
                {
                    type: 'danger',
                    header: 'Error',
                    text: 'You must be logged in to update the cart',
                    closable: true,
                    duration: 5000
                }
            )
        } else if (result.status === 500) {
            Notifier.show(
                {
                    type: 'danger',
                    header: 'Error',
                    text: 'Something went wrong<br>Please try again later',
                    closable: true,
                    duration: 5000
                }
            )
        } else if (result.status === 400) {
            Notifier.show(
                {
                    type: 'danger',
                    header: 'Error',
                    text: 'Invalid request',
                    closable: true,
                    duration: 5000
                }
            )
        }
    } catch (e) {
        Notifier.show(
            {
                type: 'danger',
                header: 'Error',
                text: e.message,
                closable: true,
                duration: 5000
            }
        )
    }
}


/**
 *
 * @param {number} productId
 * @param {number} price
 * @returns {Promise<void>}
 */
async function deleteItemFromCart({productId, price}) {
    try {
        const formData = new FormData();
        formData.append('item_code', productId.toString());
        const result = await fetch(`/shopping-cart/delete`, {
            body: formData,
            method: 'post'
        })
        if (result.status === 200) {
            Notifier.show(
                {
                    type: 'success',
                    header: 'Success',
                    text: 'Item removed from cart successfully',
                    closable: true,
                    duration: 5000
                }
            )

            const cartItem = document.querySelector(`#cart-item-${productId}`)
            if (cartItem) cartItem.remove()
            const currentCount = parseInt(cartCountElement.innerHTML.trim())
            cartCountElement.innerHTML = `${currentCount - 1}`

        } else if (result.status === 401) {
            Notifier.show(
                {
                    type: 'danger',
                    header: 'Error',
                    text: 'You must be logged in to delete an item from the cart',
                    closable: true,
                    duration: 5000
                }
            )
        } else if (result.status === 500) {
            Notifier.show(
                {
                    type: 'danger',
                    header: 'Error',
                    text: 'Something went wrong<br>Please try again later',
                    closable: true,
                    duration: 5000
                }
            )
        } else if (result.status === 400) {
            Notifier.show(
                {
                    type: 'danger',
                    header: 'Error',
                    text: 'Invalid request',
                    closable: true,
                    duration: 5000
                }
            )
        }
    } catch (e) {
        Notifier.show(
            {
                type: 'danger',
                header: 'Error',
                text: e.message,
                closable: true,
                duration: 5000
            }
        )
    }
}


cartItemIncreaseButtons.forEach(button => {
    button.addEventListener('click', async () => {
        const productId = button.dataset.productid
        const price = button.dataset.price
        await updateCart({productId: Number(productId), by: 1, price: Number(price)})
    })
});


cartItemDecreaseButtons.forEach(button => {
    button.addEventListener('click', async () => {
        const productId = button.dataset.productid
        const price = button.dataset.price

        const amountText = document.querySelector(`#cart-amount-${productId}`)?.innerHTML
        const amount = Number(amountText.trim())

        if (amount === 1) {
            const cartItem = document.querySelector(`#cart-item-${productId}`)
            const productName = cartItem.dataset.name

            const deleteConfirmationModalContent = htmlToElement(
                `<div style="width: 350px">  
                            <h3 style="font-size: 1.1rem;font-weight: bold;text-align: center;margin-bottom: 2rem">
                             Do you really want to remove <br>"${productName}" <br>from the cart? 
                            </h3>
                            <div style="display: flex;align-items: center;justify-content: space-evenly;">
                                <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>   
                                <button class="btn btn--thin modal-close-btn" id="delete-item-from-cart-btn">Delete</button> 
                            </div> 
                          </div>`
            )

            deleteConfirmationModalContent.querySelector('#delete-item-from-cart-btn')?.addEventListener('click', async () => {
                await deleteItemFromCart({
                    productId: Number(productId),
                    price: Number(price),
                })
            })

            Modal.show({
                closable: true,
                content: deleteConfirmationModalContent,
                key: "delete-item-from-cart-modal",
            })

            return
        }

        await updateCart({productId: Number(productId), by: -1, price: Number(price)})
    })
});


cartItemDeleteButtons.forEach(button => {

    button.addEventListener('click', async () => {
        const productId = button.dataset.productid
        const price = button.dataset.price

        const cartItem = document.querySelector(`#cart-item-${productId}`)
        const productName = cartItem.dataset.name

        const deleteConfirmationModalContent = htmlToElement(
            `<div style="width: 350px">  
                            <h3 style="font-size: 1.1rem;font-weight: bold;text-align: center;margin-bottom: 2rem">
                             Do you really want to remove <br>"${productName}" <br>from the cart? 
                            </h3>
                            <div style="display: flex;align-items: center;justify-content: space-evenly;">
                                <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>   
                                <button class="btn btn--thin modal-close-btn" id="delete-item-from-cart-btn">Delete</button> 
                            </div> 
                          </div>`
        )

        deleteConfirmationModalContent.querySelector('#delete-item-from-cart-btn')?.addEventListener('click', async () => {
            await deleteItemFromCart({
                productId: Number(productId),
                price: Number(price),
            })
        })

        Modal.show({
            closable: true,
            content: deleteConfirmationModalContent,
            key: "delete-item-from-cart-modal",
        })

    })


})