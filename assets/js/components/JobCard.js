import {Chart, PieController, ArcElement} from 'chart.js'

Chart.register(PieController, ArcElement)

const jobCardStatProgresses = document.querySelectorAll('.job-card__stat--progress');

jobCardStatProgresses.forEach((jobCardStatProgress) => {
    const doneAmount = Number.parseInt(jobCardStatProgress.dataset.done);
    const totalAmount = Number.parseInt(jobCardStatProgress.dataset.all);
    const chartCanvas = jobCardStatProgress.querySelector('canvas');
    chartCanvas.getContext("2d").canvas.width = 50;
    chartCanvas.getContext("2d").canvas.height = 50;

    const ratio = doneAmount / totalAmount;
    let mainColor = '';
    if (ratio > 0.75) {
        mainColor = getComputedStyle(document.documentElement).getPropertyValue('--color-success');
    } else if (ratio > 0.375) {
        mainColor = getComputedStyle(document.documentElement).getPropertyValue('--color-warning');
    } else {
        mainColor = getComputedStyle(document.documentElement).getPropertyValue('--color-danger');
    }
    const chart = new Chart(chartCanvas, {
        type: 'pie',
        data: {
            datasets: [{
                data: [doneAmount, totalAmount - doneAmount],
                backgroundColor: [
                    mainColor,
                    'transparent'
                ]
            }]
        },
        options: {
            responsive: false,
        }
    })
})
