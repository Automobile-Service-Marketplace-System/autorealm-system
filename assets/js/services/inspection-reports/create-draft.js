import {setSpinner} from "../../utils"

/**
 * @type {HTMLButtonElement | null}
 */
const saveInspectionReportDraftButton = document.querySelector("#save-inspection-report-draft");
/**
 * @type {HTMLFormElement}
 */
const maintenanceInspectionForm = document.querySelector(".maintenance-inspection-form");

const isDraftBeingCreated = {
    value: false,
    color: "var(--color-white)"
};

async function createDraft() {
    if (isDraftBeingCreated.value) {
        return
    }
    setSpinner(saveInspectionReportDraftButton.querySelector("svg"), true, isDraftBeingCreated)
    try {
        isDraftBeingCreated.value = true;
        // get all the input tags in the form
        /**
         * @type {NodeListOf<HTMLInputElement>}
         */
        const inputs = maintenanceInspectionForm.querySelectorAll("input");
        const formData = new FormData();
        inputs.forEach(input => {
            formData.append(input.name, input.value);
        })

        const jobId = maintenanceInspectionForm.dataset.jobid;

        const result = await fetch(`/inspection-reports/create-draft?job_id=${jobId}`, {
            method: "POST",
            body: formData
        })

        const data = await result.text();
        console.log(data)
    } catch (e) {
        console.log(e)
    } finally {
        isDraftBeingCreated.value = false;
        setSpinner(saveInspectionReportDraftButton.querySelector("svg"), false, isDraftBeingCreated)
    }
}

saveInspectionReportDraftButton?.addEventListener("click", createDraft)


function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
