import {ProductSelector} from "../../components/ProductSelector"
import {htmlToElement} from "../../utils";

/**
 * @typedef {Object} Product
 * @property {number} ID
 * @property {string} Name
 * @property {string} Category
 * @property {string} Model
 * @property {string} Brand
 * @property {string} "Price (LKR)"
 * @property {number} Quantity
 * @property {string} Image
 */


/**
 * @type {HTMLButtonElement | null}
 */
const selectProductBtn = document.querySelector(".create-job__products-item--new")

/**
 * @type {HTMLDivElement | null}
 */
const createJobProductsContainer = document.querySelector(".create-job__products")


selectProductBtn?.addEventListener("click", async () => {
    const productSelector = await new ProductSelector()

    productSelector.addEventListener("onFinish", addProductsToJob)
})

/**
 * @param {Product[]} products
 * @return {Promise<void>}
 */
async function addProductsToJob(products) {
    products.forEach(product => {
        const productItem = htmlToElement(
            `
                    <div class="create-job__products-item">
                        <h4>${product.Name}</h4>
                        <img src="${product.Image}" alt="${product.Image}'s image">
                        <button class="py-2 btn btn--danger btn--block btn--text">
                            <i class='fa-solid fa-xmark'></i>
                            Remove
                        </button>
                        <input type="text" name="products[]" value="${product.ID}">
                    </div>
                    `
        )
        createJobProductsContainer.insertBefore(productItem, selectProductBtn)
    })
}