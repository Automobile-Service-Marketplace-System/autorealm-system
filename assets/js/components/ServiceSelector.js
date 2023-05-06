import {Modal} from "./Modal"
import {htmlToElement} from "../utils";
import Notifier from "./Notifier";


// noinspection ExceptionCaughtLocallyJS
export class ServiceSelector {

    /**
     * service selector element
     * @type {HTMLDivElement | null}
     */
    element = null

    url = "/services/for-selector"


    limit = 8;
    page = 1;
    total = 0;


    searchTimeout = null;


    /**
     * @type {{q: null| string; page:number; limit: number}}
     */
    selectedFiltersRaw = {
        q: null,
        page: 1,
        limit: 8
    }


    selectedFilters = new Proxy(this.selectedFiltersRaw, {
        set: async (target, key, value) => {
            target[key] = value
            await this.loadServices();
            return true
        }
    })


    /**
     * @type {Service[]}
     */
    selectedServices = []


    listeners = {
        onFinish: [],
    }

    constructor() {
        return (async () => {
            this.element = this.createElement();
            Modal.show({
                closable: false,
                content: this.element,
                key: "ServiceSelector"
            });
            await this.initialLoad();
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
    <div class="service-selector service-selector--loading">
        <i class="fa fa-spinner service-selector__spinner"></i>
        <div class="service-selector__body">
            <div class="service-selector__header">
                <h3>Select a service</h3>
                <div class="flex items-center gap-4">
                    <button class="btn btn--danger btn--thin modal-close-btn">
                        <i class="fa fa-xmark"></i>
                        Cancel
                    </button>
                    <button class="btn btn--thin service-selector__finish">
                        <i class="fa fa-check"></i>
                        Confirm
                    </button>
                </div> 
            </div>
            <div class="service-selector__filters">
                <div class='form-item '>
                    <input type='search' name='q' id='search' placeholder='Search with name'>
                </div>
            </div>
            <p class="service-selector__result-indicator">
                Showing <span id="service-selector__show-count"></span> of <span id="service-selector__total-count"></span> results
            </p>
            <div class="service-selector__gallery service-selector__gallery--loading">
                <i class="fa fa-spinner service-selector__spinner"></i>
                <p class="service-selector__empty-message">
                    <i class="fa fa-search"></i>
                    No services found
                </p>
            </div>
            <div class="pagination-container pagination-container--select">
            </div>
        </div>
    </div>`
        )
    }

    async initialLoad() {
        await this.loadServices();
        this.element.classList.remove("service-selector--loading")
    }


    listenForFilterChanges() {
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

    async loadServices() {
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
                     * @type {{ total:number;limit: number;page: number;services: Service[]}}
                     */
                    let response = await result.json();
                    this.limit = response.limit;
                    this.page = response.page;
                    this.total = response.total;
                    const services = response.services
                    this.showServices(services)
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
     * @param {Service[]} services
     */
    showServices(services) {
        /**
         * @type {HTMLDivElement}
         */


        const serviceSelectorGallery = this.element.querySelector(".service-selector__gallery")
        while (serviceSelectorGallery.firstChild) {
            serviceSelectorGallery.removeChild(serviceSelectorGallery.firstChild)
        }

        serviceSelectorGallery.innerHTML = `
                <i class="fa fa-spinner service-selector__spinner"></i>
                <p class="service-selector__empty-message">
                    <i class="fa fa-search"></i>
                    No services found
                </p>
        `;
        services.forEach(service => {
            const isAlreadySelected = this.selectedServices.find((p) => p.Code === service.Code)
            const serviceEl = htmlToElement(
                `
                    <div class="service-selector__gallery-item ${isAlreadySelected ? 'service-selector__gallery-item--selected' : ''}">
                        <h4>${service.Name}</h4>
                        <p  style="font-size: 0.8rem;">${service.Description}</p>
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    `
            )
            serviceEl.addEventListener('click', () => {
                if (serviceEl.classList.contains("service-selector__gallery-item--selected")) {
                    serviceEl.classList.remove("service-selector__gallery-item--selected")
                    this.selectedServices.splice(this.selectedServices.indexOf(service), 1)
                } else {
                    serviceEl.classList.add("service-selector__gallery-item--selected")
                    this.selectedServices.push(service)
                }
            })
            serviceSelectorGallery.appendChild(serviceEl)
        })

        if(services.length > 0) {
            serviceSelectorGallery.classList.remove("service-selector__gallery--empty")
        } else {
            serviceSelectorGallery.classList.add("service-selector__gallery--empty")
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

        const serviceSelectorShowCount = this.element.querySelector("#service-selector__show-count")
        serviceSelectorShowCount.innerHTML = `${services.length}`
        const serviceSelectorTotalCount = this.element.querySelector("#service-selector__total-count")
        serviceSelectorTotalCount.innerHTML = `${this.total}`
    }


    /**
     * @param {boolean} status
     */
    setLoading(status) {
        const serviceSelectorGallery = this.element.querySelector(".service-selector__gallery")
        if (status) {
            serviceSelectorGallery.classList.add("service-selector__gallery--loading")
        } else {
            serviceSelectorGallery.classList.remove("service-selector__gallery--loading")
        }
    }


    attachListeners() {
        this.element.querySelector(".service-selector__finish").addEventListener("click", () => {
            this.finish()
        })
    }

    finish() {
        this.listeners.onFinish.forEach((callback) => {
            callback(this.selectedServices)
        })

        this.destroy()
    }

    destroy() {
        Modal.close("ServiceSelector")
    }


    addEventListener(event, callback) {
        switch (event) {
            case "onFinish":
                this.listeners.onFinish.push(callback)
        }
    }

}



/**
 * @typedef {Object} Service
 * @property {string} Name
 * @property {string} Code
 * @property {string} Description
 * @property {string} Cost
 */
