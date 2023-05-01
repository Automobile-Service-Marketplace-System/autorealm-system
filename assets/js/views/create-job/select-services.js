import {ServiceSelector} from "../../components/ServiceSelector"
import {htmlToElement} from "../../utils";

/**
 * @typedef {Object} Service
 * @property {number} Name
 * @property {string} Code
 * @property {string} Description
 */


/**
 * @type {HTMLButtonElement | null}
 */
const selectServiceBtn = document.querySelector(".create-job__services-item--new")

/**
 * @type {HTMLDivElement | null}
 */
const createJobServicesContainer = document.querySelector(".create-job__services")


selectServiceBtn?.addEventListener("click", async () => {
    const serviceSelector = await new ServiceSelector()

    serviceSelector.addEventListener("onFinish", addServicesToJob)
})

/**
 * @param {Service[]} services
 * @return {Promise<void>}
 */
async function addServicesToJob(services) {
    services.forEach(service => {
        const serviceItem = htmlToElement(
            `
                    <div class="create-job__services-item">
                        <h4>${service.Name}</h4>
                        <img src="${service.Image}" alt="${service.Image}'s image">
                        <button class="py-2 btn btn--danger btn--block btn--text create-job__roduct-remove-btn" type="button">
                            <i class='fa-solid fa-xmark'></i>
                            Remove
                        </button>
                        <input type="text" name="services[]" value="${service.ID}">
                    </div>
                    `
        )
        createJobServicesContainer.insertBefore(serviceItem, selectServiceBtn)
    })
}