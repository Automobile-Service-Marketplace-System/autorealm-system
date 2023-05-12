import {JobSelector} from "../../components/JobSelector"
import Notifier from "../../components/Notifier";

/**
 * @type {HTMLButtonElement}
 */
const loadFromJobBtn = document.querySelector("#load-from-job-btn")

if (loadFromJobBtn) {
    loadFromJobBtn.addEventListener('click', async () => {
        const jobSelector = await new JobSelector();

        jobSelector.addEventListener('onFinish', async (jobId) => {
            const customerInfo = await getCustomerInfo(jobId)

            console.log(customerInfo)
        })
    })


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