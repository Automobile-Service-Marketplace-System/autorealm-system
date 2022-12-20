import {Modal} from "../components/Modal"


const addProductForm = document.querySelector(".stock-manager-add-products-form")
const addProductButton = document.querySelector("#add-product-btn")


addProductButton?.addEventListener("click", () => {

    const modelContent = document.createElement("div")
    const para = document.createElement("p")
    para.innerHTML = "Are you sure you want to add this product?"
    modelContent.appendChild(para)

    const actions = document.createElement("div")
    actions.classList.add("button-area")
    const cancelBtn = document.createElement("button")
    actions.appendChild(cancelBtn)
    cancelBtn.innerHTML = "Cancel"
    cancelBtn.classList.add("btn","btn--danger", "btn--thin", "modal-close-btn")


    const confirmBtn = document.createElement("button")
    actions.appendChild(confirmBtn)
    confirmBtn.innerHTML = "Confirm"
    confirmBtn.classList.add("btn", "btn--thin", "btn--success")
    confirmBtn.addEventListener("click", () => {
        addProductForm.submit()
    })

    modelContent.appendChild(actions)

    Modal.show({
        key: "add-product",
        content: modelContent,
    })
})