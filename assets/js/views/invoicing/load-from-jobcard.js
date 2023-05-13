import {JobSelector} from "../../components/JobSelector"

/**
 * @type {HTMLButtonElement}
 */
const loadFromJobBtn = document.querySelector("#load-from-job-btn")

if(loadFromJobBtn) {
    loadFromJobBtn.addEventListener('click', async () => {
        const jobSelector = await new JobSelector();

        jobSelector.addEventListener('onFinish', (jobId) => {
            console.log(jobId)
        })
    })
}