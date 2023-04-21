import {ProductSelector} from "../../components/ProductSelector"


console.log("Hellop")

/**
 * @type {HTMLButtonElement | null}
 */
const selectProductBtn = document.querySelector(".create-job__products-item--new")


selectProductBtn?.addEventListener("click", async () => {
    const productSelector = await new ProductSelector()
    productSelector.addEventListener("onFinish", (products) => {
        console.log(products)
    })
})

