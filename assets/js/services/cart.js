import Notifier from "../components/Notifier";
import {htmlToElement} from "../utils";
import {Modal} from "../components/Modal";

/**
 * @type {NodeListOf<HTMLButtonElement>}
 */
const cartItemIncreaseButtons = document.querySelectorAll('.cart-action.cart-action--increase');
/**
 * @type {NodeListOf<HTMLButtonElement>}
 */
const cartItemDecreaseButtons = document.querySelectorAll('.cart-action.cart-action--decrease');
/**
 * @type {NodeListOf<HTMLButtonElement>}
 */
const cartItemDeleteButtons = document.querySelectorAll('.cart-item-delete');

const cartCountElement = document.querySelector('#cart-count')

/**
 * @type {HTMLDivElement}
 */
const cartContainer = document.querySelector('.cart');

/**
 * @type {HTMLDivElement}
 */
const cartActionsRow = document.querySelector('#cart-actions-row');

/**
 * @type {HTMLHeadingElement}
 */
const cartHeading = document.querySelector('.cart-heading');

/**
 *
 * @param {number} productId
 * @param {number} by
 * @param {number} price
 * @param {"update" | "add"} mode
 * @returns {Promise<void>}
 */
async function updateCart({productId, by, price}, mode = "update") {
    try {
        const formData = new FormData();
        formData.append('item_code', productId.toString());
        formData.append('by', by.toString());
        if (mode === "add") {
            formData.append('amount', Math.abs(by).toString());
        }
        const result = await fetch(mode === "update" ? `/cart/update` : `/cart/add`, {
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
            if (mode === "add" && amount === 1) {
                cartCountElement.innerHTML = `${parseInt(cartCountElement.innerHTML.trim()) + 1}`
            }

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
        const result = await fetch(`/cart/delete`, {
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

            const cartItems = document.querySelectorAll('.cart-item')
            if (cartItems.length === 0) {
                cartContainer?.remove();
                cartActionsRow?.remove();
                cartHeading?.remove();
                const cartErrorEl = document.querySelector('.cart-error--none');
                cartErrorEl.classList?.remove('cart-error--none');
                cartErrorEl.classList?.add('cart-error');
            }

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

/**
 * @param productId
 * @returns {Promise<number>}
 */
async function getItemQuantity(productId) {
    try {
        const result = await fetch(`/cart/item-quantity?item_code=${productId}`, {
            method: 'get'
        })
        switch (result.status) {
            case 200:
                /**
                 * @type {{amount: number}}
                 */
                const amountData = await result.json()
                return amountData.amount || 0
            case 401:
                Notifier.show(
                    {
                        type: 'danger',
                        header: 'Error',
                        text: 'Unauthorized Action',
                        closable: true,
                        duration: 5000
                    })
                return 0
            case 400:
                return 0
            case 404:
                return 0
            case 500:
                Notifier.show(
                    {
                        type: 'danger',
                        header: 'Error',
                        text: 'Something went wrong<br>Please try again later',
                        closable: true,
                        duration: 5000

                    })
                throw new Error(await result.text())
            default:
                return 0;
        }
    } catch (e) {
        console.log(e.message)
        return 0;
    }
}

/**
 * @param {number} productId
 * @param {number} price
 * @param {-1 | 1} factor
 * @param {number} amount
 * @param {"update" | "add"} mode
 * @returns {Promise<void>}
 */
export async function getItemChangeConfirmationModal(productId, price, factor, amount = 1, mode = "update") {
    const itemQuantity = factor === 1 ? await getItemQuantity(productId) : amount
    console.log(`Server says ${itemQuantity} items are available`)
    if (itemQuantity === 0) {
        Notifier.show(
            {
                type: 'danger',
                header: 'Error',
                text: 'Sorry, No items available',
                closable: true,
                duration: 5000
            })
        return
    }

    const getAmountToAddModal = htmlToElement(`
            <div style="width: 350px">  
                 <h3 style="font-size: 1.1rem;font-weight: bold;text-align: center;">
                      How many? (Maximum ${itemQuantity})
                 </h3>
                 <form class="mt-4">
                    <div class='form-item '>
                        <label for='amount'>Amount<sup>*</sup></label>
                        <input type='number' name='amount' id='amount' required  value='1' min="0" max="${itemQuantity}">
                    </div>
                    <div class="flex items-center justify-evenly mt-4">
                      <button class="btn btn--thin btn--danger modal-close-btn" type="reset">
                        Cancel
                      </button>   
                      <button class="btn btn--thin modal-close-btn" type="submit">
                        Confirm
                      </button> 
                    </div>
                 </form> 
            </div>
            `)

    getAmountToAddModal.querySelector("input")?.addEventListener('change', (e) => {
        const value = Number(e.target.value)
        if (value > itemQuantity) {
            e.target.value = itemQuantity
        }
    })

    getAmountToAddModal.querySelector("form")?.addEventListener('submit', async (e) => {
        e.preventDefault()
        const by = Number(getAmountToAddModal.querySelector("input")?.value) * factor
        if (by > 0) {
            await updateCart({productId, by, price}, mode)
        } else if (by < 0) {
            const amountToBeRemoved = Math.abs(by)
            if (amountToBeRemoved === itemQuantity) {
                await getItemDeleteConfirmation(productId, price)
            } else {
                await updateCart({productId, by, price})
            }
        }
    })

    Modal.show({
        content: getAmountToAddModal,
        closable: true,
        key: `add-item-${productId}`,
    })
}


cartItemIncreaseButtons.forEach(button => {
    button.addEventListener('click', async () => {
        try {
            const productId = Number(button.dataset.productid)
            const price = Number(button.dataset.price)
            await getItemChangeConfirmationModal(productId, price, 1)
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
});


cartItemDecreaseButtons.forEach(button => {
    button.addEventListener('click', async () => {
        try {
            const productId = Number(button.dataset.productid)
            const price = Number(button.dataset.price)
            const amountText = document.querySelector(`#cart-amount-${productId}`)?.innerHTML
            const amount = Number(amountText.trim())

            if (amount === 1) {
                return getItemDeleteConfirmation(productId, price)
            }
            await getItemChangeConfirmationModal(productId, price, -1, amount);
            // await updateCart({productId, by: -1, price})
        } catch (e) {
            Notifier.show({
                type: 'danger',
                header: 'Error',
                text: e.message,
                closable: true,
                duration: 5000
            })
        }


    })
});


cartItemDeleteButtons.forEach(button => {
    button.addEventListener('click', async () => {
        try {
            const productId = Number(button.dataset.productid)
            const price = Number(button.dataset.price)
            getItemDeleteConfirmation(productId, price)
        } catch (e) {
            Notifier.show({
                type: 'danger',
                header: 'Error',
                text: e.message,
                closable: true,
                duration: 5000
            })
        }
    })
})


/**
 * @param {number} productId
 * @param {number} price
 */
function getItemDeleteConfirmation(productId, price) {
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
            productId,
            price,
        })
    })

    Modal.show({
        closable: true,
        content: deleteConfirmationModalContent,
        key: "delete-item-from-cart-modal",
    })
}