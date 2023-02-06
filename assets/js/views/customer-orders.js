/**
 *
 * @type {NodeListOf<HTMLParagraphElement>}
 */
const itemListToggles = document.querySelectorAll('.item-toggle');

itemListToggles.forEach((itemListToggle) => {
    itemListToggle.addEventListener("click", () => {
        itemListToggle.classList.toggle("item-toggle--active");
        const orderItems = itemListToggle.nextElementSibling
        orderItems.classList.toggle("order-items--active");
        if(orderItems.classList.contains("order-items--active")){
            setTimeout(() => {
                orderItems.style.overflowY = "auto"
            }, 200)
        }
    })
})
