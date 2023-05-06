/**
 *
 * @type {NodeListOf<HTMLParagraphElement>}
 */
const serviceListToggles = document.querySelectorAll('.service-toggle');
/**
 *
 * @type {NodeListOf<HTMLParagraphElement>}
 */
const productListToggles = document.querySelectorAll('.product-toggle');
console.log(productListToggles)

serviceListToggles.forEach((serviceListToggle) => {
    serviceListToggle.addEventListener("click", () => {
        serviceListToggle.classList.toggle("service-toggle--active");
        const recordItems = serviceListToggle.nextElementSibling
        recordItems.classList.toggle("record-items--active");
    })
})


productListToggles.forEach((productListToggle) => {
    productListToggle.addEventListener("click", () => {
        productListToggle.classList.toggle("product-toggle--active");
        const recordItems = productListToggle.nextElementSibling;
        recordItems.classList.toggle("record-items--active");
    })
})