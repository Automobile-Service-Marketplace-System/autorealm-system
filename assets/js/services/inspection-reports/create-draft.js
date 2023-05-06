import {setSpinner} from "../../utils"
import Notifier from "../../components/Notifier";

/**
 * @type {HTMLButtonElement | null}
 */
const saveInspectionReportDraftButton = document.querySelector("#save-inspection-report-draft button");
/**
 * @type {HTMLFormElement}
 */
const maintenanceInspectionForm = document.querySelector(".maintenance-inspection-form");

/**
 * @type {HTMLInputElement}
 */
const autoSaveCheckbox = document.querySelector("#save-inspection-report-draft input[type=checkbox]")
/**
 * @type {HTMLLabelElement}
 */
const autoSaveCheckboxLabel = document.querySelector("#save-inspection-report-draft label")

/**
 * @type {{color: string, value: boolean}}
 */
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
            // check if input is a radio button
            if (input.type === "radio") {
                // check if the radio button is checked
                if (input.checked) {
                    // append the radio button to the form data
                    formData.append(input.name, input.value);
                }
                return
            }
            formData.append(input.name, input.value);
        })

        const jobId = maintenanceInspectionForm.dataset.jobid;

        const result = await fetch(`/inspection-reports/create-draft?job_id=${jobId}`, {
            method: "POST",
            body: formData
        })

        switch (result.status) {
            case 201:
                const response = await result.json();
                console.log(response)
                Notifier.show({
                    text: response.message,
                    type: "success",
                    header: "Success",
                    closable: true,
                    duration: 5000
                })
                break;
            case 400:
                const data = await result.json();
                console.log(data)
                Notifier.show({
                    text: data.message,
                    type: "success",
                    header: "Success",
                    closable: true,
                    duration: 5000
                })
                break;
            default:
                Notifier.show({
                        text: "An error occurred while creating draft",
                        type: "error",
                        header: "Error",
                        closable: true,
                        duration: 5000
                    }
                )

        }

    } catch (e) {
        console.log(e)
        Notifier.show({
            text: "An error occurred while creating draft",
            type: "error",
            header: "Error",
            closable: true,
            duration: 5000
        })
    } finally {
        isDraftBeingCreated.value = false;
        setSpinner(saveInspectionReportDraftButton.querySelector("svg"), false, isDraftBeingCreated)
    }
}

saveInspectionReportDraftButton?.addEventListener("click", createDraft)


let autoSaveInterval = null;
autoSaveCheckbox?.addEventListener("change", async (e) => {

    if (autoSaveCheckbox.checked) {
        autoSaveInterval = setInterval(async () => {
            await createDraft()
        }, 30000)
        autoSaveCheckboxLabel.textContent = "Auto save is on"
        return await createDraft()
    }
    clearInterval(autoSaveInterval)
    autoSaveCheckboxLabel.textContent = "Auto save is off"
})
