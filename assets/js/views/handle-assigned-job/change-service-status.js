import { setSpinner} from "../../utils";
import Notifier from "../../components/Notifier";
import { showJobProgressChart} from "./show-service-progress"

/**
 * @type {NodeListOf<HTMLInputElement>}
 */
const serviceCheckBoxes = document.querySelectorAll('.service-checkbox');


if (serviceCheckBoxes.length > 0) {

    /**
     * @type {HTMLDivElement}
     */
    const assignedJobOverview = document.querySelector(".assigned-job-overview")
    const jobId = Number(assignedJobOverview.dataset.jobid)


    serviceCheckBoxes.forEach(serviceCheckBox => {
        serviceCheckBox.addEventListener('change', async () => {
            await handleServiceStatusUpdate(serviceCheckBox)
        })
    })

    /**
     * @param {HTMLInputElement} serviceCheckbox
     * @return {Promise<void>}
     */
    async function handleServiceStatusUpdate(serviceCheckbox) {
        const serviceCode = Number(serviceCheckbox.dataset.servicecode)
        const serviceNewStatus = serviceCheckbox.checked

        setSpinner(serviceCheckbox, true, {
            color: 'rgba(0, 0,0,0.2)',
        })
        try {
            const result = await fetch("/assigned-job/services/set-status", {
                body: JSON.stringify({
                    serviceCode: serviceCode,
                    status: serviceNewStatus,
                    jobId: jobId
                }), headers: {
                    "Content-Type": "application/json"
                }, method: "POST"
            })


            switch (result.status) {
                case 200:
                    /**
                     * @type {JobProgress}
                     */
                    const data = (await result.json())["data"]
                    console.log(data)
                    showJobProgressChart(data)
                    Notifier.show({
                        text: serviceNewStatus ? "Marked as completed" : "Marked as not completed",
                        header: "Success",
                        duration: 2000,
                        closable: true,
                        type: "success"
                    })
                    break;

                case 400:
                    Notifier.show({
                        text: "Bad request",
                        header: "Error",
                        duration: 2000,
                        closable: true,
                        type: "error"
                    })
                    break;
            }
        } catch (e) {
            console.log(e)
            Notifier.show({
                text: "Something went wrong",
                header: "Error",
                duration: 2000,
                closable: true,
                type: "danger"
            })
        } finally {
            setSpinner(serviceCheckbox, false)
        }
    }
}