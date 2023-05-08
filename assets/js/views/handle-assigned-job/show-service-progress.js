import {Chart, PieController, ArcElement, Tooltip, Legend} from 'chart.js'


/**
 * @type {Chart | null}
 */
let chart = null


/**
 * @type {HTMLDivElement | null}
 */
const assignedJobOverview = document.querySelector('.assigned-job-overview')

/**
 * @type {HTMLDivElement | null}
 */
const assignedJobProgressContainer = assignedJobOverview?.querySelector('.assigned-job-progress-container')


if (assignedJobOverview) {

    Chart.register(PieController, ArcElement, Tooltip, Legend)

    /**
     * @return {Promise<JobProgress>}
     */
    async function getJobProgress() {
        const completed = Number(assignedJobProgressContainer.dataset.completed)
        const notCompleted = Number(assignedJobProgressContainer.dataset.notcompleted)

        return new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve({
                    completed: completed,
                    inProgress: notCompleted,
                })
            }, 100)
        })
    }


    window.addEventListener('load', async () => {
        const jobProgress = await getJobProgress()
        showJobProgressChart(jobProgress)
    })
}

/**
 * @param {JobProgress} jobProgress
 */
export function showJobProgressChart(jobProgress) {

    assignedJobProgressContainer.classList.remove('assigned-job-progress-container--loading')

    const successColor = getComputedStyle(document.documentElement).getPropertyValue('--color-success')
    const warningColor = getComputedStyle(document.documentElement).getPropertyValue('--color-warning')

    console.log(chart)
    if (chart) {
        chart.data.datasets[0].data = [jobProgress.completed, jobProgress.inProgress]
        chart.update()
    } else {
        chart = new Chart(assignedJobOverview.querySelector('canvas'), {
            type: 'pie',
            data: {
                labels: ['Completed', 'In Progress'],
                datasets: [{
                    data: [jobProgress.completed, jobProgress.inProgress],
                    backgroundColor: [
                        successColor,
                        warningColor,
                    ],
                }]
            }
        })
    }
}


/**
 * @typedef {Object} JobProgress
 * @property {number} completed
 * @property {number} inProgress
 */