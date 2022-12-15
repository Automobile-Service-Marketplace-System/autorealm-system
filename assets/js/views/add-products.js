import {Modal} from "../components/Modal"


const addProductForm = document.querySelector(".stock-manager-add-products-form")
const addProductButton = document.querySelector("#add-product-btn")


addProductButton?.addEventListener("click", () => {

    const modelContent = document.createElement("div")
    const para = document.createElement("p")
    para.innerHTML = "Are you sure you want to add this product?"
    modelContent.appendChild(para)
    const actions = document.createElement("div")
    const cancelBtn = document.createElement("button")
    cancelBtn.innerHTML = "Cancel"
    cancelBtn.classList.add("btn","btn--danger", "modal-close-btn")


    const confirmBtn = document.createElement("button")
    confirmBtn.innerHTML = "Confirm"
    confirmBtn.classList.add("btn", "btn--success")
    confirmBtn.addEventListener("click", () => {
        addProductForm.submit()
    })

    actions.appendChild(cancelBtn)
    actions.appendChild(confirmBtn)
    modelContent.appendChild(actions)

    Modal.show({
        key: "add-product",
        content: modelContent,
    })
})