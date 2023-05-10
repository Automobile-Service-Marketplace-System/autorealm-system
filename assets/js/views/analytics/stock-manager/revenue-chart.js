import {
    Chart,
    PieController,
    LineController,
    ArcElement,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
    Tooltip, Legend, Filler,
} from 'chart.js';


import Zoom, {resetZoom} from 'chartjs-plugin-zoom';

import Notifier from "../../../components/Notifier";

Chart.register(
    PieController,
    LineController,
    ArcElement,
    PointElement,
    LineElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
    Filler,
    Zoom
)
/**
 * @type {HTMLCanvasElement | null}
 */
const orderRevenueCanvas = document.querySelector("#order-revenue-canvas");
/**
 * @type {HTMLButtonElement}
 */
const resetRevenueChartZoomBtn = document.querySelector("#reset-revenue-chart");


/**
 * @type {Chart | null}
 */
let revenueChart = null

if (orderRevenueCanvas) {

    async function showOrderRevenueChart() {
        try {
            const result = await fetch("/analytics/order-revenue")
            // console.log(result)
            switch (result.status){
                case 200:

                    /**
                     *
                     * @type {{data:{ordered_year_month:string, revenue:number}[]}}
                     */
                    const resData = await result.json()
                    // console.log(resData)

                    const yearMonthLabels = resData.data.map(
                        item => item.ordered_year_month
                    )

                    const revenues = resData.data.map(
                        item => item.revenue
                    )

                    // console.log(yearMonthLabels)
                    // console.log(revenues)

                    const revenueChart = new Chart(orderRevenueCanvas, {
                        type: 'line',
                        data: {
                            labels: yearMonthLabels,
                            datasets: [{
                                label: 'Revenue',
                                data: revenues,
                                fill: true,
                                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                                borderColor: 'rgba(0, 123, 255, 1)',
                                tension: 0.2,
                                borderWidth: 0.5,
                            }]
                        },
                        options: {
                            plugins: {
                                zoom: {
                                    zoom: {
                                        wheel: {
                                            enabled: true,
                                        },
                                        pinch: {
                                            enabled: true
                                        },
                                        mode: 'x',
                                    }
                                }
                            }
                        }
                    });

                    resetRevenueChartZoomBtn?.addEventListener("click", () => {
                        resetZoom(revenueChart);
                    })

                    break;

                case 500:
                    const error = await result.json()
                    throw new Error(error.message)
            }
        } catch (e) {
            console.log(e)
            Notifier.show({
                text: e.message,
                header: "Error",
                duration: 30000,
                closable: false,
                type: "danger"
            })
        }
    }

    window.addEventListener("load", showOrderRevenueChart)

}