import {JobSelector} from "../../components/JobSelector"
import Notifier from "../../components/Notifier";
import {
    customerName,
    customerNameInput,
    customerEmailInput,
    customerAddressInput,
    customerPhoneInput,
    customerAddress,
    customerEmail,
    customerPhone,
    loadFromJobBtn
} from "./customer-detail-elements";
import {addProductsFromJob, addNewItemRowButton, removeAllItems} from "./handle-product-section";


let prevAddNewRowItemButtonInnerHTML = addNewItemRowButton.innerHTML

if (loadFromJobBtn) {
    loadFromJobBtn.addEventListener('click', async () => {

        if (loadFromJobBtn.classList.contains("load-from-job-btn--selected")) {
            resetCustomerInfo()
        } else {

            const jobSelector = await new JobSelector();

            jobSelector.addEventListener('onFinish', async (jobId) => {
                const customerInfo = await getCustomerInfo(jobId)
                if (customerInfo) {

                    await loadJobProducts(jobId)
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

    function resetCustomerInfo() {

        removeAllItems()
        loadFromJobBtn.classList.remove('load-from-job-btn--selected')
        addNewItemRowButton.disabled = false
        addNewItemRowButton.innerHTML = prevAddNewRowItemButtonInnerHTML

        customerName.textContent = 'N/A'
        customerNameInput.value = ''

        customerAddress.textContent = 'N/A'
        customerAddressInput.value = ''

        customerPhone.textContent = 'N/A'
        customerPhoneInput.value = ''

        customerEmail.textContent = 'N/A'
        customerEmailInput.value = ''
    }


    /**
     * @param {number} jobId
     * @return {Promise<void>}
     */
    async function loadJobProducts(jobId) {
        try {
            const result = await fetch(`/jobs/product-info?job_id=${jobId}`)
            switch (result.status) {
                case 200:
                    /**
                     * @type {{products: Array<Product>|false}}
                     */
                    const data = await result.json()

                    const {products} = data
                    console.log(products)
                    if (products) {
                        addProductsFromJob(products)
                        addNewItemRowButton.disabled = true
                        addNewItemRowButton.innerHTML = '<i class="fas fa-lock"></i> Locked when loading from job card, create a separate invoice to add more items'
                    }
                    break
                case 400:
                    const error = await result.json()
                    console.log(error)
                    break
                case 500:
                    const error500 = await result.json()
                    console.log(error500)
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
