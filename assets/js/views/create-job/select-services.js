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
export const createJobServicesContainer = document.querySelector(".create-job__services")


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
                        <button class="py-2 btn btn--danger btn--block btn--text create-job__product-remove-btn" type="button">
                            <i class='fa-solid fa-xmark'></i>
                            Remove
                        </button>
                        <input type="text" name="services[]" value="${service.Code}" style="display: none">
                    </div>
                    `
        )
        serviceItem.querySelector(".create-job__product-remove-btn")?.addEventListener("click", () => {
            serviceItem.remove()
        })
        createJobServicesContainer.insertBefore(serviceItem, selectServiceBtn)
    })
}