import {htmlToElement} from "../utils";

const productUpdateButtons = document.querySelectorAll(".update-product-btn")
//console.log(productUpdateButtons)
import {Modal} from '../components/Modal'

productUpdateButtons.forEach(function (btn) {
    //to add event listeners to every button
    btn.addEventListener("click", function () {
        //assigning dataset values to variables
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


        const updateProductForm = htmlToElement(
            `<div>

                    <form class="stock-manager-update-product-form" id="stock-manager-update-product-form">
                          <div class="top-part-form">  
                            <h1 class="">Update Product Details</h1>
                            <button class="modal-close-btn">
                                <i class="fas fa-times"></i>
                            </button>
                           </div>
                           
                          <div class="update-product-input-wrapper">
                            <div class="form-item">
                                <label for='name'>Product Name<sup>*</sup></label>
                                <input type='text' name='name' id='name' placeholder='' required  value='${productInfo.productName}'   >
                            </div>
                            <div class="form-item">
                                <label for='category'>Category<sup>*</sup></label>
                                <select name="category" id="category"></select>  
                            </div>  
                            <div class="form-item">
                                 <label for='product-type'>Product Type<sup>*</sup></label>
                                 <select name="product-type" id="product-type"></select>
                            </div>
                            <div class="form-item">
                                <label for='brand'>Brand<sup>*</sup></label>
                                <select name="brand" id="brand"></select>
                            </div>
                            <div class="form-item">
                                <label for='model'>Model<sup>*</sup></label>
                                <select name="model" id="model"></select>
                            </div>
                            <div class="form-item">
                                <label for='price'>Selling Price<sup>*</sup></label>
                                <input type='number' name='price' id='price' placeholder='' required  value='${productInfo.price}'   >
                            </div>
                            
                            <div class="form-item update-product-description">
                                <label for='description'>Description<sup>*</sup></label>
                                <textarea name="description" id="description" cols="30" rows="10" placeholder="Enter product description" required>${productInfo.description}</textarea>
                            </div>
                            
                            <div class="form-item ">
                                <label for='image'>Image<sup>*</sup></label>
                                <input type='file' name='image' id='image' placeholder='' required  value='${productInfo.image}'   >
                            </div>
                          
                        </div>`
        )


        Modal.show({
            key: "update-product",
            content: updateProductForm ,
            closable: true
        })
    })
})

