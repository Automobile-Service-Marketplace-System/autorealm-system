import {htmlToElement} from "../utils";

const productUpdateButtons = document.querySelectorAll(".update-product-btn")
//console.log(productUpdateButtons)
import {Modal} from '../components/Modal'
import Notifier from "../components/Notifier";

const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());

productUpdateButtons.forEach(function (btn) {
    //to add event listeners to every button
    btn.addEventListener("click", function () {
        //assigning dataset values to variables
        const productId = Number(btn.dataset.productid)
        const categoryId = Number(btn.dataset.categoryid)
        const modelId = Number(btn.dataset.modelid)
        const brandId = Number(btn.dataset.brandid)
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

        // console.log(productInfo)


        const  form = document.createElement("form")
        form.action = "/products/update"

        /**
         * @type {Array<{model_id:number, brand_id:number, model_name:string}>}
         */
        const models = JSON.parse(localStorage.getItem("models") || "[]")
        const modelOptions = models.map( function(mod){
            return `<option value="${mod.model_id}" ${mod.model_id === productInfo.modelId ? "selected" : "" }>${mod.model_name}</option>`
        }).join("")

        /**
         * @type {Array<{category_id:number, name:string}>}
         */
        const categories = JSON.parse(localStorage.getItem("categories") || "[]")
        const categoryOptions = categories.map( function(cat){
            return `<option value="${cat.category_id}" ${cat.category_id === productInfo.categoryId ? "selected" : "" }>${cat.name}</option>`
        }).join("")
        //"" is to convert it into a string


        /**
         * @type {Array<{brand_id:number, brand_name:string}>}
         */
        const brands = JSON.parse(localStorage.getItem("brands") || "[]")
        const brandOptions =  brands.map( function(brand){
            return `<option value = "${brand.brand_id}" ${brand.brand_id === productInfo.brandId ? "selected" : ""}>${brand.brand_name}</option> `
        }).join("")

        // console.log(models)
        // console.log(categories)
        // console.log(brands)

        // const nameInput = document.createElement("input")
        // nameInput.value = productInfo.productName
        //
        // form.appendChild(nameInput)

        // const modelSelect = document.createElement("select")
        // models.forEach(function (model) {
        //     const option = document.createElement("option")
        //     option.value = model.model_id
        //     option.textContent = model.model_name
        //     modelSelect.appendChild(option)
        // })

        // form.appendChild(modelSelect)
        //
        // const submiBtn = document.createElement("button")
        //
        // form.appendChild(submiBtn)

        //form modal
        const updateProductForm = htmlToElement(
            `
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
                                <select name="category" id="category" >
                                    ${categoryOptions}
                                </select>  
                                
                            </div>  
                            <div class="form-item">
                                 <label for='product-type'>Product Type<sup>*</sup></label>
                                 <select name="product-type" id="product-type">
                                     <option value="spare part">Spare Part</option>
                                     <option value="accessory">Accessory</option> 
                                </select>
                            </div>
                            <div class="form-item">
                                <label for='brand'>Brand<sup>*</sup></label>
                                <select name="brand" id="brand">
                                    ${brandOptions}
                                </select>
                            </div>
                            <div class="form-item">
                                <label for='model'>Model<sup>*</sup></label>
                                <select name="model" id="model">
                                    ${modelOptions}
                                </select>
                            </div>
                            <div class="form-item">
                                <label for='price'>Selling Price<sup>*</sup></label>
                                <input type='number' name='price' id='price' placeholder='' required  value='${productInfo.price}'   >
                            </div>
                            
                            <div class="form-item update-product-description">
                                <label for='description'>Description<sup>*</sup></label>
                                <textarea name="description" id="description" cols="30" rows="10" placeholder="Enter product description" required>${productInfo.description}</textarea>
                            </div>
                            
 
                          </div>  
                          
                          <div class="update-product-actions">
                
                            <button class="btn btn--danger" type="reset">Reset</button><!--                <button class="btn" id="open-another">Open another modal</button>-->
                            <button class="btn update-product-modal-btn" type="button" id="update-product-modal-btn">Submit</button>
                            
                            <button style="display: none" type="submit" id="update-product-final-btn"></button>
            
                          </div>
                    </form>`
        )


        Modal.show({
            key: "update-product",
            content: updateProductForm ,
            closable: true,
        })


        //Confirmation modal
        updateProductForm?.querySelector("#update-product-modal-btn")?.addEventListener("click",(e)=>{
            const UpdateConfModal = htmlToElement(`<div>
                                       <h3>Are you sure you want to update this details</h3>
                                       <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem;margin-top: 1rem">
                                            <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
                                            <button class="btn btn--thin modal-close-btn" id="update-product-confirm-btn">Confirm</button>                        
                                       </div>
                                    </div>`)

            Modal.show({
                closable: true,
                content: UpdateConfModal,
                key: "Update Product Confirmation",
            })

            UpdateConfModal.querySelector("#update-product-confirm-btn").addEventListener('click', () => {
                const submitBtn = updateProductForm?.querySelector("#update-product-final-btn");
                submitBtn?.click();
            })
        })

        updateProductForm?.addEventListener('submit', async (e) =>{
            e.preventDefault();
            const formData = new FormData(e.target);
            try{
                const result = await fetch("/stock-manager-dashboard/products/update", {
                    body: formData,
                    method: 'POST'
                })
                if(result.status === 400) {
                    const resultBody = await result.json()
                    for (const inputName in resultBody.errors) {
                        const inputWrapper = updateProductForm.querySelector(`#${inputName}`).parentElement
                        inputWrapper.classList.add('form-item--error')
                        const errorElement = htmlToElement(`<small>${resultBody.errors[inputName]}</small>`)
                        inputWrapper.appendChild(errorElement)
                    }
                }
                else if (result.status === 201) {

                    // add success message to url search params
                    window.location.search = new URLSearchParams({
                        ...params,
                        success: 'Product updated successfully'
                    }).toString()
                    location.reload()
                }
            }
            catch (e) {
                Notifier.show({
                    closable: true,
                    header: 'Error',
                    type: 'danger',
                    text: e.message
                })
            }
        })





    })
})

//took the images form out
// < div
// className = "form-item " >
//     < label
// htmlFor = 'image' > Image < sup > *
// </sup></label>
// <input type='file' name='image' id='image' placeholder='' required value='${productInfo.image}'>
// </div>