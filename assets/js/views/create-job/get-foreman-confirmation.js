import {Modal} from "../../components/Modal"
import {createJobTechniciansContainer} from "./select-technicians"
import {createJobProductsContainer} from "./select-product"
import {createJobServicesContainer} from "./select-services"
import {htmlToElement} from "../../utils";
import Notifier from "../../components/Notifier";


if (createJobTechniciansContainer) {
    /**
     * @type {HTMLButtonElement}
     */
    const startJobFormSubmitButton = document.querySelector("form#start-job-form #start-job-btn")
    /**
     * @type {HTMLButtonElement}
     */
    const startJobFinalButton = document.querySelector("button#start-job-final-btn")
    /**
     * @type {HTMLFormElement}
     */
    const startJobForm = document.querySelector("form#start-job-form")

    console.log(startJobFormSubmitButton, startJobForm)
    startJobForm.addEventListener('submit', async (e) => {
        e.preventDefault()
        try {
            const url = startJobForm.getAttribute("action")
            const formData = new FormData(startJobForm)
            const response = await fetch(url, {
                method: "POST",
                body: formData
            })

            switch (response.status) {
                case 204:
                    Modal.close("start-job-confirmation-modal")
                    Notifier.show({
                        header: "Success",
                        text: "Job started successfully",
                        closable: true,
                        duration: 5000,
                        type: "success"
                    })
                    // retrieve id from query string
                    const jobId = new URLSearchParams(window.location.search).get("id")
                    location.href = `/jobs/in-progress/view?id=${jobId}`
                    break;
                case 400:
                    const data = await response.json()
                    Notifier.show({
                        header: "Error",
                        text: data.message,
                        closable: true,
                        duration: 5000,
                        type: "danger"
                    })
                    break;
            }
        } catch (e) {
            Notifier.show({
                header: "Error",
                text: "Something went wrong",
                closable: true,
                duration: 5000,
                type: "danger"
            })
        } finally {

        }
    })

    startJobFormSubmitButton.addEventListener('click', () => {

        const selectedProductsCount = createJobProductsContainer.querySelectorAll("div.create-job__products-item").length
        const selectedServicesCount = createJobServicesContainer.querySelectorAll("div.create-job__services-item").length

        console.log(selectedProductsCount, selectedServicesCount)
        if (selectedProductsCount === 0 && selectedServicesCount === 0) {
            Notifier.show(
                {
                    header: "Error",
                    text: "Please select at least one product or service",
                    closable: true,
                    duration: 5000,
                    type: "danger"
                }
            )
            return
        }

        const selectedTechnicianCount = createJobTechniciansContainer.querySelectorAll(".create-job__technicians-item--selected").length
        if (selectedTechnicianCount === 0) {
            Notifier.show(
                {
                    header: "Error",
                    text: "Please select at least one technician",
                    closable: true,
                    duration: 5000,
                    type: "danger"
                }
            )
            return
        }

        const modalContent = htmlToElement(
            `
            <div class="flex flex-col gap-4">
                <h3 class="text-center flex items-center justify-between gap-8">
                Are you sure you want to start this job?
                <button class="modal-close-btn">
                    <i class="fa-solid fa-xmark"></i>
                </button>
                </h3>
                <div class="flex gap-4 mt-4">
                    <button class="btn btn--danger btn--block btn--thin modal-close-btn" type="button" id="start-job-confirmation-modal-no-btn">
                        <i class="fa-solid fa-xmark"></i>
                        No
                    </button>
                    <button class="btn btn--block btn--thin" type="button" id="start-job-confirmation-modal-yes-btn">
                        <i class="fa-solid fa-check"></i>
                        Yes
                    </button>
                </div>
            </div>
            `
        )


        modalContent.querySelector("#start-job-confirmation-modal-yes-btn")?.addEventListener("click", () => {
            startJobFinalButton.click()
        })

        Modal.show({
            closable: true,
            content: modalContent,
            key: "start-job-confirmation-modal"
        })

    })

}