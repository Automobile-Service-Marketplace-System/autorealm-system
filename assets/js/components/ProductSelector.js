import {Modal} from "./Modal"
import {htmlToElement} from "../utils";
import Notifier from "./Notifier";


// noinspection ExceptionCaughtLocallyJS
export class ProductSelector {

    /**
     * product selector element
     * @type {HTMLDivElement | null}
     */
    element = null

    /**
     *
     * @type {{name: string;category_id: number}[]}
     */
    categories = []
    /**
     * @type {{brand_name: string; brand_id: number; is_vehicle_model: number; is_product_model: number}[]}
     */
    brands = []

    /**
     * @type {{model_id: number; brand_id: number; model_name: string; is_vehicle_model: number; is_product_model: number}[]}
     */
    models = []


    url = "/products/for-selector"


    limit = 8;
    page = 1;
    total = 0;


    searchTimeout = null;


    /**
     * @type {{q: null| string, models: null | number, brands: null | number, categories: null| number, page:number, limit: number}}
     */
    selectedFiltersRaw = {
        q: null,
        categories: null,
        brands: null,
        models: null,
        page: 1,
        limit: 8
    }


    selectedFilters = new Proxy(this.selectedFiltersRaw, {
        set: async (target, key, value) => {
            target[key] = value
            await this.loadProducts();
            return true
        }
    })


    /**
     * @type {Product[]}
     */
    selectedProducts = []


    listeners = {
        onFinish: [],
    }

    constructor() {
        return (async () => {
            this.element = this.createElement();
            Modal.show({
                closable: false,
                content: this.element,
                key: "ProductSelector"
            });
            await this.initialLoad();
            this.registerFilterValidators();
            this.listenForFilterChanges();
            this.attachListeners();
            return this
        })();
    }

    /**
     * @returns {HTMLDivElement}
     */
    createElement() {
        return htmlToElement(
            `
    <div class="product-selector product-selector--loading">
        <i class="fa fa-spinner product-selector__spinner"></i>
        <div class="product-selector__body">
            <div class="product-selector__header">
                <h3>Select a product</h3>
                <div class="flex items-center gap-4">
                    <button class="btn btn--danger btn--thin modal-close-btn">
                        <i class="fa fa-xmark"></i>
                        Cancel
                    </button>
                    <button class="btn btn--thin product-selector__finish">
                        <i class="fa fa-check"></i>
                        Confirm
                    </button>
                </div> 
            </div>
            <div class="product-selector__filters">
                <div class='form-item '>
                    <input type='search' name='q' id='search' placeholder='Search with name'>
                </div>
                <div class="form-item form-item--datalist">
                    <input list="categoryList" name="categories" id="category" placeholder="Category">
                    <datalist id="categoryList">
                    </datalist>
                </div>
                <div class="form-item form-item--datalist">
                    <input list="brandList" name="brands" id="brand" placeholder="Brand">
                    <datalist id="brandList">
                    </datalist>
                </div>
                <div class="form-item form-item--datalist">
                    <input list="modelList" name="models" id="model" placeholder="Model">
                    <datalist id="modelList">
                    </datalist>
                </div>
            </div>
            <p class="product-selector__result-indicator">
                Showing <span id="product-selector__show-count"></span> of <span id="product-selector__total-count"></span> results
            </p>
            <div class="product-selector__gallery product-selector__gallery--loading">
                <i class="fa fa-spinner product-selector__spinner"></i>
                <p class="product-selector__empty-message">
                    <i class="fa fa-search"></i>
                    No products found
                </p>
            </div>
            <div class="pagination-container pagination-container--select">
            </div>
        </div>
    </div>`
        )
    }

    async initialLoad() {
        await this.loadCategoriesBrandsModels()
        const categoryDataList = this.element.querySelector("#categoryList")
        const brandDataList = this.element.querySelector("#brandList")
        const modelDataList = this.element.querySelector("#modelList")
        this.categories.forEach((category) => {
            categoryDataList.appendChild(htmlToElement(
                `
                        <option value="${category.name}">${category.name}</option>
                        `
            ))
        })

        this.brands.forEach((brand) => {
            brandDataList.appendChild(htmlToElement(
                `
                        <option value="${brand.brand_name}">${brand.brand_name}</option>
                        `
            ))
        })

        this.models.forEach((model) => {
            modelDataList.appendChild(htmlToElement(
                `
                        <option value="${model.model_name}">${model.model_name}</option>
                        `
            ))
        })
        await this.loadProducts();
        this.element.classList.remove("product-selector--loading")
    }

    async loadCategoriesBrandsModels() {
        try {
            const result = await fetch("/products/categories-brands-models");
            switch (result.status) {
                case 200:
                    const response = await result.json();
                    this.categories = response.categories || []
                    this.brands = response.brands || []
                    this.models = response.models || []
                    break;
                default:
                    const error = await result.json();
                    throw new Error(error.message);
            }
        } catch (e) {
            console.log(e)
            Notifier.show({
                text: "Something went wrong",
                type: "danger",
                header: "Error",
                closable: true,
                duration: 2000
            })
        }

    }

    registerFilterValidators() {
        this.element.querySelectorAll(".form-item--datalist").forEach((item) => {
            const input = item.querySelector("input")
            input.addEventListener("input", () => {

                const inputName = input.name;
                const isValueAnEmptyString = input.value === ""
                /**
                 * @type {[]}
                 */
                if (inputName === "categories") {
                    const category = this.categories.find((c) => c.name === input.value)
                    if (!isValueAnEmptyString && !category) {
                        input.setCustomValidity("Invalid category, please select from the list")
                        input.reportValidity()
                    } else {
                        input.setCustomValidity("")
                        input.reportValidity()
                    }
                } else if (inputName === "brands") {
                    const brand = this.brands.find((b) => b.brand_name === input.value)
                    if (!isValueAnEmptyString && !brand) {
                        input.setCustomValidity("Invalid brand, please select from the list")
                        input.reportValidity()
                    } else {
                        input.setCustomValidity("")
                        input.reportValidity()
                    }
                } else if (inputName === "models") {
                    const model = this.models.find((m) => m.model_name === input.value)
                    if (!isValueAnEmptyString && !model) {
                        input.setCustomValidity("Invalid model, please select from the list")
                        input.reportValidity()
                    } else {
                        input.setCustomValidity("")
                        input.reportValidity()
                    }
                }
            })

            input.addEventListener('blur', () => {
                input.reportValidity()
            })
        })
    }

    listenForFilterChanges() {
        this.element.querySelectorAll("input").forEach((input) => {
            input.addEventListener("change", () => {
                if (input.checkValidity()) {
                    const inputName = input.name;
                    switch (inputName) {
                        // case "q":
                        //     this.selectedFilters.q = input.value;
                        //     break;
                        case "categories":
                            const selectedCategory = this.categories.find((c) => c.name === input.value)
                            this.selectedFilters.categories = selectedCategory ? selectedCategory.category_id : null;
                            break;
                        case "brands":
                            const selectedBrand = this.brands.find((b) => b.brand_name === input.value)
                            this.selectedFilters.brands = selectedBrand ? selectedBrand.brand_id : null;
                            break;
                        case "models":
                            const selectedModel = this.models.find((m) => m.model_name === input.value)
                            this.selectedFilters.models = selectedModel ? selectedModel.model_id : null;
                            break;
                    }
                }
            })
        })

        const searchInput = this.element.querySelector("input[type='search']")

        searchInput?.addEventListener("input", () => {
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout)
            }
            this.searchTimeout = setTimeout(() => {
                const value = searchInput.value;
                if (value === "") {
                    this.selectedFilters.q = null;
                } else {
                    this.selectedFilters.q = value;
                }

            }, 500)

        })
    }

    async loadProducts() {
        try {
            this.setLoading(true)
            const url = this.url;
            const filters = {}
            for (const selectedFiltersKey in this.selectedFilters) {
                if (this.selectedFilters.hasOwnProperty(selectedFiltersKey)) {
                    const selectedFilter = this.selectedFilters[selectedFiltersKey];
                    if (selectedFilter) {
                        filters[selectedFiltersKey] = selectedFilter
                    }
                }
            }
            const result = await fetch(`${url}?${new URLSearchParams(filters)}`);

            switch (result.status) {
                case 200:
                    /**
                     * @type {{ total:number;limit: number;page: number;products: Product[]}}
                     */
                    let response = await result.json();
                    this.limit = response.limit;
                    this.page = response.page;
                    this.total = response.total;
                    const products = this.extractProducts(response.products)
                    this.showProducts(products)
                    break;
                case 500:
                    const error = await result.json();
                    throw new Error(error.error);
            }
        } catch (e) {
            console.log(e)
            Notifier.show({
                text: "Something went wrong",
                type: "danger",
                header: "Error",
                closable: true,
                duration: 2000
            })
        } finally {
            this.setLoading(false)
        }
    }


    /**
     * @param {Product[]} products
     * @return {Product[]}
     */
    extractProducts(products) {
        return products.map(function (product) {
            /**
             * @type {Product}
             */
            const newProduct = {
                ...product,
            }
            newProduct.Image = JSON.parse(product.Image)[0]
            return newProduct
        })
    }


    /**
     * @param {Product[]} products
     */
    showProducts(products) {
        /**
         * @type {HTMLDivElement}
         */


        const productSelectorGallery = this.element.querySelector(".product-selector__gallery")
        while (productSelectorGallery.firstChild) {
            productSelectorGallery.removeChild(productSelectorGallery.firstChild)
        }

        productSelectorGallery.innerHTML = `
                <i class="fa fa-spinner product-selector__spinner"></i>
                <p class="product-selector__empty-message">
                    <i class="fa fa-search"></i>
                    No products found
                </p>
        `;
        products.forEach(product => {
            const isAlreadySelected = this.selectedProducts.find((p) => p.ID === product.ID)
            const productEl = htmlToElement(
                `
                    <div class="product-selector__gallery-item ${isAlreadySelected ? 'product-selector__gallery-item--selected' : ''}">
                        <h4>${product.Name}</h4>
                        <img src="${product.Image}" alt="${product.Image}'s image">
                        <p  style="font-size: 0.8rem;color: ${product.Quantity > 0 ? 'var(--color-info);' : 'var(--color-danger);'}">Available stock: ${product.Quantity}</p>
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    `
            )
            productEl.addEventListener('click', () => {
                if (productEl.classList.contains("product-selector__gallery-item--selected")) {
                    productEl.classList.remove("product-selector__gallery-item--selected")
                    this.selectedProducts.splice(this.selectedProducts.indexOf(product), 1)
                } else {
                    productEl.classList.add("product-selector__gallery-item--selected")
                    this.selectedProducts.push(product)
                }
            })
            productSelectorGallery.appendChild(productEl)
        })

        if(products.length > 0) {
            productSelectorGallery.classList.remove("product-selector__gallery--empty")
        } else {
            productSelectorGallery.classList.add("product-selector__gallery--empty")
        }

        const paginationContainer = this.element.querySelector(".pagination-container")
        paginationContainer.innerHTML = "";
        for (let i = 1; i <= Math.ceil(this.total / this.limit); i++) {
            let isActive = i === this.page ? "pagination-item--active" : "";
            let button = htmlToElement(`<button class="pagination-item ${isActive}">${i}</button>`);
            button.addEventListener("click", () => {
                this.selectedFilters.page = i;
            })
            paginationContainer.appendChild(button)
        }

        const productSelectorShowCount = this.element.querySelector("#product-selector__show-count")
        productSelectorShowCount.innerHTML = `${products.length}`
        const productSelectorTotalCount = this.element.querySelector("#product-selector__total-count")
        productSelectorTotalCount.innerHTML = `${this.total}`
    }


    /**
     * @param {boolean} status
     */
    setLoading(status) {
        const productSelectorGallery = this.element.querySelector(".product-selector__gallery")
        if (status) {
            productSelectorGallery.classList.add("product-selector__gallery--loading")
        } else {
            productSelectorGallery.classList.remove("product-selector__gallery--loading")
        }
    }


    attachListeners() {
        this.element.querySelector(".product-selector__finish").addEventListener("click", () => {
            this.finish()
        })
    }

    finish() {
        this.listeners.onFinish.forEach((callback) => {
            callback(this.selectedProducts)
        })

        this.destroy()
    }

    destroy() {
        Modal.close("ProductSelector")
    }


    addEventListener(event, callback) {
        switch (event) {
            case "onFinish":
                this.listeners.onFinish.push(callback)
        }
    }

}


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