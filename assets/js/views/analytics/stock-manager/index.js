import {Chart, PieController, ArcElement} from 'chart.js'

Chart.register(PieController, ArcElement)

/**
 * @type {HTMLCanvasElement | null}
 */
const chart = document.querySelector("canvas#chart");

if (chart) {
    new Chart(chart, {
        type: 'pie',
        data: {
            labels: [
                'Red',
                'Blue',
                'Yellow'
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }, {
                label: 'My Second Dataset',
                data: [30, 500, 100],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ],
                hoverOffset: 4
            }]
        }

    });
}