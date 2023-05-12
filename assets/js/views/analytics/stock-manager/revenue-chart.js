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

Chart.register(PieController, LineController, DoughnutController, ArcElement, PointElement, LineElement, CategoryScale, LinearScale, Tooltip, Legend, Filler, Zoom, Colors,)

//containers
const analyticFilterContainer = document.querySelector("#analytic-filter-wrapper");

// canvases
/**
 * @type {HTMLCanvasElement | null}
 */
const orderRevenueCanvas = document.querySelector("#order-revenue-canvas");

/**
 * @type {HTMLCanvasElement | null}
 */
const orderQuantityCanvas = document.querySelector("#order-quantity-canvas");

/**
 * @type {HTMLCanvasElement | null}
 */
const productQuantityChartCanvas = document.querySelector("#ordered-products-quantity-canvas");


// buttons
/**
 * @type {HTMLButtonElement}
 */
const resetRevenueChartZoomBtn = document.querySelector("#reset-revenue-value-chart");

/**
 * @type {HTMLButtonElement}
 */
const resetRevenueQuantityZoomBtn = document.querySelector("#reset-revenue-quantity-chart");

/**
 * @type {HTMLButtonElement}
 */
const applyDateFilterBtn = document.querySelector("#analytic-filter-apply");

/**
 * @type {HTMLButtonElement}
 */
const resetDateFilterBtn = document.querySelector("#analytic-filter-reset");


// charts
/**
 * @type {Chart | null}
 */
let revenueChart = null

/**
 * @type {Chart | null}
 */
let quantityChart = null

/**
 * @type {Chart | null}
 */
let productQuantityChart = null


let fromDateFinal = null;
let toDateFinal = null;

//get today's date and get the date from and to from the analytic filter
if (analyticFilterContainer) {
    window.addEventListener("load", async function () {
        const today = new Date().toISOString().split('T')[0];

        const yesterday = new Date(Date.now() - 86400000).toISOString().split('T')[0];

        const now = new Date();
        const threeMonthsBeforeRaw = new Date(now.getFullYear(), now.getMonth() - 3, now.getDate());
        const threeMonthsBefore = threeMonthsBeforeRaw.toISOString().split('T')[0];

        // console.log(today)
        const fromDate = document.getElementById("analytic-from-date");
        fromDate.setAttribute('max', yesterday);
        fromDate.value = threeMonthsBefore;

        const toDate = document.getElementById("analytic-to-date");
        toDate.setAttribute('max', today);
        toDate.value = today;

        // console.log(applyDateFilterBtn)

        fromDateFinal = fromDate.value
        toDateFinal = toDate.value

        // console.log(fromDateFinal)
        // console.log(toDateFinal)

        await showOrderRevenueChart(fromDateFinal, toDateFinal);
        await showOrderQuantityChart(fromDateFinal, toDateFinal);
        await showProductQuantityChart(fromDateFinal, toDateFinal);


    })


    applyDateFilterBtn.addEventListener("click", () => {
        fromDateFinal = document.getElementById("analytic-from-date").value;
        toDateFinal = document.getElementById("analytic-to-date").value;

        console.log(fromDateFinal)
        console.log(toDateFinal)

        showOrderRevenueChart(fromDateFinal, toDateFinal);
        showOrderQuantityChart(fromDateFinal, toDateFinal);
        showProductQuantityChart(fromDateFinal, toDateFinal);


    })

    resetDateFilterBtn.addEventListener("click", () => {
        const today = new Date().toISOString().split('T')[0];

        const yesterday = new Date(Date.now() - 86400000).toISOString().split('T')[0];

        const now = new Date();
        const threeMonthsBeforeRaw = new Date(now.getFullYear(), now.getMonth() - 3, now.getDate());
        const threeMonthsBefore = threeMonthsBeforeRaw.toISOString().split('T')[0];

        // console.log(today)
        const fromDate = document.getElementById("analytic-from-date");
        fromDate.setAttribute('max', yesterday);
        fromDate.value = threeMonthsBefore;

        const toDate = document.getElementById("analytic-to-date");
        toDate.setAttribute('max', today);
        toDate.value = today;

        showOrderRevenueChart(threeMonthsBefore, today);
        showOrderQuantityChart(threeMonthsBefore, today);
        showProductQuantityChart(threeMonthsBefore, today);


    })


// generating order revenue chart



    async function showOrderRevenueChart(fromDateFinal, toDateFinal) {
        try {
            // console.log(fromDateFinal)
            // console.log(toDateFinal)
            const result = await fetch(`/analytics/order-revenue?from=${fromDateFinal}&to=${toDateFinal}`)
            // console.log(result)
            switch (result.status) {
                case 200:

                    /**
                     *
                     * @type {{data:{ordered_year_month:string, revenue:number}[]}}
                     */
                    const resData = await result.json()
                    // console.log(resData)

                    const yearMonthLabels = resData.data.map(item => item.ordered_year_month)

                    const revenues = resData.data.map(item => item.revenue)

                    // console.log(resData.data)
                    // console.log(yearMonthLabels)
                    // console.log(revenues)

                    //to get the total sum
                    let revSum = 0;
                    revenues.forEach(function(value){
                        //convert the string into number
                        value = Number(value)
                        revSum += value
                    })
                    const totRevElement = document.getElementById("total-revenue")
                    totRevElement.innerHTML = "Rs " + revSum.toLocaleString()


                    //to get the maximum order revenue and the month
                    let maxRevenue = -Infinity; // Start with a very low value
                    let maxOrderedYearMonth;

                    // Iterate over the data array
                    resData.data.forEach(function(item) {
                        // Convert the revenue to a number
                        const revenue = parseFloat(item.revenue);

                        // Check if the current revenue is higher than the maximum
                        if (revenue > maxRevenue) {
                            maxRevenue = revenue;
                            maxOrderedYearMonth = item.ordered_year_month;
                        }
                    });

                    const maxRevValue = document.getElementById("highest-rev-value");
                    maxRevValue.innerHTML = "Rs " + maxRevenue.toLocaleString();
                    const maxRevMonth = document.getElementById("highest-rev-month");
                    maxRevMonth.innerHTML = maxOrderedYearMonth

                    // to get the minimum order revenue and month
                    let minRevenue = Infinity; // Start with a very high value
                    let minOrderedYearMonth;

                    resData.data.forEach(function(item) {
                        // Convert the revenue to a number
                        const revenue = parseFloat(item.revenue);

                        // Check if the current revenue is lower than the minimum
                        if (revenue < minRevenue) {
                            minRevenue = revenue;
                            minOrderedYearMonth = item.ordered_year_month;
                        }
                    })

                    const minRevValue = document.getElementById("lowest-rev-value");
                    minRevValue.innerHTML = "Rs " + minRevenue.toLocaleString();
                    const minRevMonth = document.getElementById("lowest-rev-date");
                    minRevMonth.innerHTML = minOrderedYearMonth;


                    if(revenueChart){
                        revenueChart.destroy()
                    }
                    revenueChart = new Chart(orderRevenueCanvas, {
                        type: 'line', data: {
                            labels: yearMonthLabels, datasets: [{
                                label: 'Revenue',
                                data: revenues,
                                fill: true,
                                radius: 2,
                                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                                borderColor: 'rgba(0, 123, 255, 1)',
                                tension: 0.1,
                                borderWidth: 0.5,
                            }]
                        }, options: {
                            responsive: true, plugins: {
                                zoom: {
                                    zoom: {
                                        wheel: {
                                            enabled: true,
                                        }, pinch: {
                                            enabled: true
                                        }, mode: 'x',
                                    }
                                }
                            }, scales: {
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
                text: e.message, header: "Error", duration: 30000, closable: false, type: "danger"
            })
        }


        // window.addEventListener("load", showOrderRevenueChart(fromDateFinal, toDateFinal));


    }


    async function showOrderQuantityChart(fromDateFinal, toDateFinal) {
        try {
            const result = await fetch(`/analytics/order-quantity?from=${fromDateFinal}&to=${toDateFinal}`);

            switch (result.status) {
                case 200:
                    /**
                     *
                     * @type {{data:{ordered_year_month:string, revenue:number}[]}}
                     */
                    const resData = await result.json()
                    // console.log(resData)

                    const yearMonthsLabels = resData.data.map(item => item.ordered_year_month)
                    const orderCount = resData.data.map(item => item.order_count)
                    const quantityCount = resData.data.map(item => item.tot_quantity)

                    // console.log(yearMonthsLabels)
                    // console.log(orderCount)
                    // console.log(quantityCount)
                    if(quantityChart){
                        quantityChart.destroy()
                    }
                    quantityChart = new Chart(orderQuantityCanvas, {
                        type: 'line', data: {
                            labels: yearMonthsLabels, datasets: [{
                                label: 'Order Count',
                                data: orderCount,
                                fill: true,
                                radius: 2,
                                backgroundColor: 'rgba(255,0,0, 0.5)',
                                borderColor: 'rgb(255,0,0)',
                                tension: 0.2,
                                borderWidth: 0.5,
                            }, {
                                label: 'Quantity Count',
                                data: quantityCount,
                                fill: true,
                                radius: 2,
                                backgroundColor: 'rgba(255, 193, 7, 0.5)',
                                borderColor: 'rgba(255, 193, 7, 1)',
                                tension: 0.1,
                                borderWidth: 0.5,
                            }]
                        }, options: {
                            responsive: true, plugins: {
                                zoom: {
                                    zoom: {
                                        wheel: {
                                            enabled: true,
                                        }, pinch: {
                                            enabled: true
                                        }, mode: 'x',
                                    }
                                }
                            }, scales: {
                                x: {
                                    ticks: {
                                        maxTicksLimit: 10, // Set the maximum number of x-axis labels to display
                                    }
                                },


                            }

                        }
                    });

                    resetRevenueQuantityZoomBtn?.addEventListener("click", () => {
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
                text: e.message, header: "Error", duration: 30000, closable: false, type: "danger"
            });
        }
    }

// window.addEventListener("load", showOrderQuantityChart(fromDateFinal, toDateFinal)  );


// to get the product quantity chart


    async function showProductQuantityChart(fromDateFinal, toDateFinal) {
        try {

            const result = await fetch(`/analytics/product-quantity?from=${fromDateFinal}&to=${toDateFinal}`)

            switch (result.status) {
                case 200:
                    /**
                     * @type {{data:{product_name:string, tot_quantity:number}[]}}
                     */
                    const resData = await result.json()
                    // console.log(resData)

                    const productNames = resData.data.map(item => item.product_name)

                    const quantities = resData.data.map(item => item.tot_quantity)

                    if(productQuantityChart){
                        productQuantityChart.destroy()
                    }
                    productQuantityChart = new Chart(productQuantityChartCanvas, {
                        type: "doughnut", data: {
                            labels: productNames, datasets: [{
                                label: "Product Quantity", data: quantities,

                                hoverOffset: 5
                            }]
                        }, options: {
                            responsive: true, plugins: {
                                legend: {
                                    position: 'top',
                                },
                            },
                        },

                    });

            }

        } catch (e) {
            console.log(e)
            Notifier.show({
                text: e.message, header: "Error", duration: 30000, closable: false, type: "danger"
            })
        }
    }


}
// window.addEventListener("load", showProductQuantityChart(fromDateFinal, toDateFinal));



