import Notifier from "./Notifier";

const addToCartButtons = document.querySelectorAll('.add-to-cart');



addToCartButtons.forEach((addToCartButton) => {
    addToCartButton.addEventListener('click', async () => {
        const formData = new FormData();
        formData.append('item_code', addToCartButton.getAttribute('data-productId'));
        try {
            const result = await fetch("/shopping-cart/add", {
                method: "POST",
                body: formData,
            })
            if(result.status === 201) {
                Notifier.show({
                    closable: true,
                    duration: 5000,
                    header: "Success",
                    text: "Item added to cart successfully",
                    type: "success",
                })
            }
            else if(result.status === 200) {
                Notifier.show({
                    closable: true,
                    duration: 5000,
                    header: "Info",
                    text: "Item already in cart",
                    type: "info",
                })
            }
            else if(result.status === 401) {
                Notifier.show({
                    closable: true,
                    header: "Error",
                    text: "You must login to add to cart",
                    type: "danger",
                })
            } else  {
                Notifier.show({
                    closable: true,
                    header: "Error",
                    text: await result.text(),
                    type: "danger",
                })
            }
        } catch(e) {
            Notifier.show({
                closable: true,
                header: "Error",
                text: e.message,
                type: "danger",
            })
        }
    })
})