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
} from 'chart.js'
import Zoom, {resetZoom} from 'chartjs-plugin-zoom'
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

// if (chart) {
//     new Chart(chart, {
//         type: 'pie',
//         data: {
//             labels: [
//                 'Red',
//                 'Blue',
//                 'Yellow'
//             ],
//             datasets: [{
//                 label: 'My First Dataset',
//                 data: [300, 50, 100],
//                 backgroundColor: [
//                     'rgb(255, 99, 132)',
//                     'rgb(54, 162, 235)',
//                     'rgb(255, 205, 86)'
//                 ],
//                 hoverOffset: 4
//             }, {
//                 label: 'My Second Dataset',
//                 data: [30, 500, 100],
//                 backgroundColor: [
//                     'rgb(255, 99, 132)',
//                     'rgb(54, 162, 235)',
//                     'rgb(255, 205, 86)'
//                 ],
//                 hoverOffset: 4
//             }]
//         }
//
//     });
// }

/**
 * @type {Chart | null}
 */
let revenueChart = null

if (orderRevenueCanvas) {

    async function showOrderRevenueChart() {
        try {
            const result = await fetch("/analytics/order-revenue")
            console.log(result)
            switch (result.status) {
                case 200:
                    /**
                     * @type {{data: {orderCountData: {ordered_year_month: string;order_count:string}[], revenueData: {ordered_year_month: string, revenue: string}[]}}}
                     */
                    const data = await result.json()
                    const {data: {revenueData, orderCountData}} = data

                    const yearMonthLabels = revenueData.map((item) => {
                        return item.ordered_year_month;
                    })

                    const revenues = revenueData.map((item) => {
                        return Number(item.revenue) / 100;
                    })

                    const orderCounts = orderCountData.map((item) => {
                        return Number(item.order_count);
                    })

                    console.log(orderCounts, revenues)


                    revenueChart = new Chart(orderRevenueCanvas, {
                        type: 'line',
                        data: {
                            labels: yearMonthLabels,
                            datasets: [{
                                label: 'Revenue per month',
                                data: revenues,
                                fill: true,
                                borderColor: 'rgb(75, 192, 192)',
                                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                                tension: 0.1
                            }, {
                                label: 'Order count per month',
                                data: orderCounts,
                                fill: true,
                                borderColor: 'rgb(255, 99, 132)',
                                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                tension: 0.1
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
                    })

                    resetRevenueChartZoomBtn?.addEventListener("click", () => {
                        resetZoom(revenueChart)
                    })

                    break
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