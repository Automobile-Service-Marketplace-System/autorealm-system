import {
    Chart,
    PieController,
    LineController,
    DoughnutController,
    ArcElement,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
    Tooltip,
    Legend,
    Filler,
    Colors
} from 'chart.js';


import Zoom, {resetZoom} from 'chartjs-plugin-zoom';

import Notifier from "../../../components/Notifier";
// import {colorSchemes} from "chartjs-plugin-colorschemes";

Chart.register(
    PieController,
    LineController,
    DoughnutController,
    ArcElement,
    PointElement,
    LineElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
    Filler,
    Zoom,
    Colors,
)

const revenueQuantityContainer = document.querySelector("#order-revenue-quantity-chart__container");
/**
 * @type {HTMLCanvasElement | null}
 */

const invoiceRevenueCanvas = document.querySelector("#invoice-revenue-canvas");

/**
 * @type {HTMLCanvasElement | null}
 */


/**
 * @type {HTMLButtonElement}
 */
const resetRevenueChartZoomBtn = document.querySelector("#reset-revenue-quantity-chart");

/**
 * @type {Chart | null}
 */
let revenueChart = null
/**
 * @type {Chart | null}
 */
let quantityChart = null

if (invoiceRevenueCanvas) {
    // console.log(invoiceRevenueCanvas);
    async function showInvoiceRevenueChart() {
        try {
            const result = await fetch("/analytics/invoice-revenue")
            console.log(result)
            switch (result.status) {
                case 200:
                    /**
                     * @type {{data:{Date:string, Revenue:number}[]}}
                     */
                    const resData = await result.json()
                    console.log(resData)

                    const DateLabels = resData.data.map(
                        item => item.Date
                    )

                    const InvoiceRevenues = resData.data.map(
                        item => item.InvoiceRevenue
                    )
      

                    console.log(DateLabels)
                    console.log(InvoiceRevenues)
                

                    const revenueChart = new Chart(invoiceRevenueCanvas, {
                        type: 'line',
                        data: {
                            labels: DateLabels,
                            datasets: [{
                                label: 'Invoice-Revenue',
                                data: InvoiceRevenues,
                                fill: true,
                                radius: 2,
                                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                                borderColor: 'rgba(0, 123, 255, 1)',
                                tension: 0.1,
                                borderWidth: 0.5,
                            }

                            ]                            
                        },
                        options: {
                            responsive: true,
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
                            },
                            scales: {
                                x: {
                                    ticks: {
                                        maxTicksLimit: 10, // Set the maximum number of x-axis labels to display
                                    }
                                },


                            }
                        }
                    });

                    resetRevenueChartZoomBtn?.addEventListener("click", () => {
                        resetZoom(revenueChart);
                    })

                    break;

                case 500:
                    const error = await result.json()
                    // console.log("Tharushi")
                    console.log(error);
                    throw new Error(error.message)
            }
        }
        catch(e){
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
    window.addEventListener("load", showInvoiceRevenueChart)
}