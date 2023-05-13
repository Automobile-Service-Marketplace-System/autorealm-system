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
    loadFromJobBtn,
    manuallyAddCustomerDetailsBtn
} from "./customer-detail-elements";
import {htmlToElement} from "../../utils";
import {Modal} from "../../components/Modal";


if (manuallyAddCustomerDetailsBtn) {
    manuallyAddCustomerDetailsBtn.addEventListener('click', async () => {

        if(loadFromJobBtn.classList.contains("load-from-job-btn--selected")) {
            Notifier.show({
                closable: true,
                duration: 5000,
                header: 'Warning',
                text: 'Please remove the connected job from the invoice',
                type: 'warning'
            })
            return
        }

        if (manuallyAddCustomerDetailsBtn.classList.contains("manually-add-customer-details--selected")) {
            resetCustomerInfo()
        } else {
            const customerInfo = await getCustomerInfoFromForm()

            if (customerInfo) {
                manuallyAddCustomerDetailsBtn.classList.add('manually-add-customer-details--selected')

                customerName.textContent = customerInfo.customerName
                customerNameInput.value = customerInfo.customerName

                customerAddress.textContent = customerInfo.address
                customerAddressInput.value = customerInfo.address

                customerPhone.textContent = customerInfo.contactNo
                customerPhoneInput.value = customerInfo.contactNo

                customerEmail.textContent = customerInfo.email
                customerEmailInput.value = customerInfo.email
            }

        }
    })


    /**
     * @return {Promise<CustomerInformation|null>}
     */
    function getCustomerInfoFromForm() {
        return new Promise((resolve, reject) => {

            /**
             * @type {HTMLFormElement}
             */
            const customerInfoModal = htmlToElement(
                `
            <form class="invoice-customer-info">
                <div class="invoice-customer-info__header">
                    <h2>Enter customer's details</h2>
                    <button class="modal-close-btn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="invoice-customer-info__body">
                    <div class="form-item">
                        <label for="customer_name">Name</label>
                        <input type="text" id="customer_name" required>
                    </div>
                    <div class="form-item">
                        <label for="customer_address">Address</label>
                        <input type="text" id="customer_address" required>
                    </div>
                    <div class="form-item">
                        <label for="customer_phone">Phone</label>
                        <input type="text" id="customer_phone" required>
                    </div>
                    <div class="form-item">
                        <label for="customer_email">Email</label>
                        <input type="email" id="customer_email" required>
                    </div>  
                </div>
                <div class="invoice-customer-info__footer">
                    <button class="btn btn--danger btn--text btn--thin modal-close-btn">Cancel</button>
                    <button class="btn btn--primary btn--thin" type="submit">Save</button>
                </div>
            </form>`)

            customerInfoModal.addEventListener('submit', (e) => {
                e.preventDefault()
                Modal.close('customerInfoModal')
                resolve({
                    customerName: customerInfoModal.querySelector('#customer_name').value,
                    address: customerInfoModal.querySelector('#customer_address').value,
                    contactNo: customerInfoModal.querySelector('#customer_phone').value,
                    email: customerInfoModal.querySelector('#customer_email').value,
                })
            })

            customerInfoModal.querySelectorAll('.modal-close-btn')
                .forEach(btn => btn.addEventListener('click', () => {
                    Modal.close('customerInfoModal')
                    resolve(null)
                }))

            Modal.show({
                content: customerInfoModal,
                key: "customerInfoModal",
                closable: false,
            })

        })
    }

    function resetCustomerInfo() {

        manuallyAddCustomerDetailsBtn.classList.remove('manually-add-customer-details--selected')

        customerName.textContent = 'N/A'
        customerNameInput.value = ''

        customerAddress.textContent = 'N/A'
        customerAddressInput.value = ''

        customerPhone.textContent = 'N/A'
        customerPhoneInput.value = ''

        customerEmail.textContent = 'N/A'
        customerEmailInput.value = ''
    }
}


