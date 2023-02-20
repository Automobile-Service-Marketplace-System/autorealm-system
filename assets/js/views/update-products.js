const productUpdateButtons = document.querySelectorAll(".update-product-btn")
import {Modal} from '../components/Modal'

productUpdateButtons.forEach(function (btn) {
    btn.addEventListener("click", function () {
        const productId = btn.dataset.productid
        const categoryId = btn.dataset.categoryid
        const modelId = btn.dataset.modelid
        const brandId = btn.dataset.brandid
        const image = btn.dataset.image
        const description = btn.dataset.description
        const productRow = btn.parentElement.parentElement.parentElement
        const productNameElement = productRow.querySelector('td:nth-child(2)')
        const productName = productNameElement.textContent
        const priceElement = productRow.querySelector('td:nth-child(6)')
        const price = priceElement.textContent

        const productInfo = {
            productId,
            categoryId,
            modelId,
            brandId,
            image,
            description,
            productName,
            price
        }

        console.log(productInfo)


        const  form = document.createElement("form")
        form.action = "/products/update"


        const models = JSON.parse(localStorage.getItem("models") || "[]")
        const categories = JSON.parse(localStorage.getItem("categories") || "[]")
        const brands = JSON.parse(localStorage.getItem("brands") || "[]")

        const nameInput = document.createElement("input")
        nameInput.value = productInfo.productName

        form.appendChild(nameInput)

        const modelSelect = document.createElement("select")
        models.forEach(function (model) {
            const option = document.createElement("option")
            option.value = model.model_id
            option.textContent = model.model_name
            modelSelect.appendChild(option)
        })

        form.appendChild(modelSelect)

        const submiBtn = document.createElement("button")

        form.appendChild(submiBtn)


        Modal.show({
            key: "update-product",
            content: form ,
            closable: false
        })
    })
})

