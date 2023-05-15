import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";
import {Modal} from "../components/Modal";

/**
 * @type {HTMLButtonElement | null}
 */
const finishJobButton = document.querySelector('#finish-job-btn');

if (finishJobButton) {
    finishJobButton.addEventListener('click', async () => {
        const jobId = finishJobButton.dataset.jobid;

        const jobFinishConfirmationDialog = htmlToElement(
            `
        <div>
            <div class="flex items-center justify-between">
                <h3>
                    Are you sure you want to mark this job as finished?                
                </h3>
                <button class="modal-close-btn rotate-on-hover-btn">
                    <i class="fa fa-xmark"></i>    
                </button>
            </div>
            <div class="mt-4">
                <p>
                Once you mark this job as finished, you will not be able to undo this action.
                </p>
            </div>
            <div class="flex items-center justify-between mt-4">
                <button class="btn btn--danger btn--thin btn--text">Cancel</button>
                <button class="btn btn--thin" id="job-finish-confirm-btn">
                    <i class="fa fa-spinner"></i>
                    Confirm
                </button>
            </div>
        </div>`
        )

        const confirmBtn = jobFinishConfirmationDialog.querySelector('#job-finish-confirm-btn');

        confirmBtn.addEventListener('click', async () => {
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = `<i class="fa fa-spinner"></i> Confirming...`;
            confirmBtn.classList.add('btn--loading');
            try {
                const response = await fetch(`/jobs/mark-as-finished?job_id=${jobId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    window.location.href = "/jobs";
                } else {
                    Notifier.show({
                        header: "Error",
                        type: "danger",
                        text: "An error occurred while marking this job as finished. Please try again later.",
                        duration: 5000,
                        closable: true
                    })
                    confirmBtn.disabled = false;
                    confirmBtn.innerHTML = `<i class="fa fa-spinner"></i> Confirm`;
                }
            } catch (e) {
                console.error(e);
                Notifier.show({
                    header: "Error",
                    type: "danger",
                    text: "An error occurred while marking this job as finished. Please try again later.",
                    duration: 5000,
                    closable: true
                })

            } finally {
                confirmBtn.disabled = false;
                confirmBtn.innerHTML = `<i class="fa fa-spinner"></i> Confirm`;
                confirmBtn.classList.remove('btn--loading');
            }

        })

        Modal.show({
            content: jobFinishConfirmationDialog,
            key: "job-finish-confirmation-dialog",
            closable: true
        })

    })
}