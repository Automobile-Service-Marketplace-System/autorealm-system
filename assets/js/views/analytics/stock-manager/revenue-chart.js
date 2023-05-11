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
const orderRevenueCanvas = document.querySelector("#order-revenue-canvas");

/**
 * @type {HTMLCanvasElement | null}
 */
const orderQuantityCanvas = document.querySelector("#order-quantity-canvas");


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


if (orderRevenueCanvas) {

    async function showOrderRevenueChart() {
        try {
            const result = await fetch("/analytics/order-revenue")
            // console.log(result)
            switch (result.status) {
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
                                radius: 2,
                                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                                borderColor: 'rgba(0, 123, 255, 1)',
                                tension: 0.1,
                                borderWidth: 0.5,
                            }]
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

if (orderQuantityCanvas) {

    async function showOrderQuantityChart() {
        try {
            const result = await fetch("/analytics/order-quantity");

            switch (result.status) {
                case 200:
                    /**
                     *
                     * @type {{data:{ordered_year_month:string, revenue:number}[]}}
                     */
                    const resData = await result.json()
                    // console.log(resData)

                    const yearMonthsLabels = resData.data.map(
                        item => item.ordered_year_month
                    )
                    const orderCount = resData.data.map(
                        item => item.order_count
                    )
                    const quantityCount = resData.data.map(
                        item => item.tot_quantity
                    )

                    // console.log(yearMonthsLabels)
                    // console.log(orderCount)
                    // console.log(quantityCount)

                    const quantityChart = new Chart(orderQuantityCanvas, {
                        type: 'line',
                        data: {
                            labels: yearMonthsLabels,
                            datasets: [{
                                label: 'Order Count',
                                data: orderCount,
                                fill: true,
                                radius: 2,
                                backgroundColor: 'rgba(255,0,0, 0.5)',
                                borderColor: 'rgb(255,0,0)',
                                tension: 0.2,
                                borderWidth: 0.5,
                            },
                                {
                                    label: 'Quantity Count',
                                    data: quantityCount,
                                    fill: true,
                                    radius: 2,
                                    backgroundColor: 'rgba(255, 193, 7, 0.5)',
                                    borderColor: 'rgba(255, 193, 7, 1)',
                                    tension: 0.1,
                                    borderWidth: 0.5,
                                }]
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
                        resetZoom(quantityChart);
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
            });
        }
    }

    window.addEventListener("load", showOrderQuantityChart)

}