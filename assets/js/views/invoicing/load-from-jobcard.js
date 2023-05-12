import {JobSelector} from "../../components/JobSelector"
import Notifier from "../../components/Notifier";

/**
 * @type {HTMLButtonElement}
 */
const loadFromJobBtn = document.querySelector("#load-from-job-btn")

if (loadFromJobBtn) {


    /**
     * @type {HTMLParagraphElement}
     */
    const customerName = document.querySelector("#customer-name")
    /**
     * @type {HTMLInputElement}
     */
    const customerNameInput = document.querySelector("#customer_name")
    /**
     * @type {HTMLParagraphElement}
     */
    const customerAddress = document.querySelector("#customer-address")
    /**
     * @type {HTMLInputElement}
     */
    const customerAddressInput = document.querySelector("#customer_address")
    /**
     * @type {HTMLParagraphElement}
     */
    const customerPhone = document.querySelector("#customer-phone")
    /**
     * @type {HTMLInputElement}
     * @type {Element}
     */
    const customerPhoneInput = document.querySelector("#customer_phone")
    /**
     * @type {HTMLParagraphElement}
     */
    const customerEmail = document.querySelector("#customer-email")
    /**
     * @type {Element}
     */
    const customerEmailInput = document.querySelector("#customer_email")

    loadFromJobBtn.addEventListener('click', async () => {

        if (loadFromJobBtn.classList.contains("load-from-job-btn--selected")) {

            loadFromJobBtn.classList.remove('load-from-job-btn--selected')

            customerName.textContent = ''
            customerNameInput.value = ''

            customerAddress.textContent = ''
            customerAddressInput.value = ''

            customerPhone.textContent = ''
            customerPhoneInput.value = ''

            customerEmail.textContent = ''
            customerEmailInput.value = ''
        } else {

            const jobSelector = await new JobSelector();

            jobSelector.addEventListener('onFinish', async (jobId) => {
                const customerInfo = await getCustomerInfo(jobId)
                if (customerInfo) {

                    loadFromJobBtn.classList.add('load-from-job-btn--selected')

                    customerName.textContent = customerInfo.customerName
                    customerNameInput.value = customerInfo.customerName

                    customerAddress.textContent = customerInfo.address
                    customerAddressInput.value = customerInfo.address

                    customerPhone.textContent = customerInfo.contactNo
                    customerPhoneInput.value = customerInfo.contactNo

                    customerEmail.textContent = customerInfo.email
                    customerEmailInput.value = customerInfo.email
                }
            })
        }
    })


    /**
     * @param jobId
     * @return {Promise<CustomerInformation|null>}
     */
    async function getCustomerInfo(jobId) {
        try {

            const response = await fetch(`/jobs/customer-info?job_id=${jobId}`)
            switch (response.status) {
                case 200:
                    const data = await response.json()
                    console.log(data)
                    return data.data

                case 400:
                    const error = await response.json()
                    console.log(error)
                    Notifier.show({
                        text: error.message,
                        type: 'danger',
                        header: 'Error',
                        duration: 3000,
                        closable: true
                    })
                    break

            }
        } catch (e) {
            Notifier.show({
                text: e.message,
                type: 'danger',
                header: 'Error',
                duration: 3000,
                closable: true
            })
            return null
        }
    }
}

/**
 * @typedef {Object} CustomerInformation
 * @property {string} address
 * @property {string} contactNo
 * @property {string} customerName
 * @property {string} email
 */
