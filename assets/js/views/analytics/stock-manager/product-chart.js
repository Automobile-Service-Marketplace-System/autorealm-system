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

/**
 * @type {HTMLCanvasElement | null}
 */
const productQuantityChartCanvas = document.querySelector("#ordered-products-quantity-canvas");

/**
 * @type {HTMLButtonElement | null}
 */
const resetProductQuantityZoomBtn = document.querySelector("#reset-product-quantity-chart");

/**
 * @type {Chart | null}
 */
let productQuantityChart = null

if (productQuantityChartCanvas) {

    async function showProductQuantityChart() {
        try {

            const result = await fetch("/analytics/product-quantity")

            switch (result.status) {
                case 200:
                    /**
                     * @type {{data:{product_name:string, tot_quantity:number}[]}}
                     */
                    const resData = await result.json()
                    // console.log(resData)

                    const productNames = resData.data.map(
                        item => item.product_name
                    )

                    const quantities = resData.data.map(
                        item => item.tot_quantity
                    )

                    const productQuantityChart = new Chart(productQuantityChartCanvas, {
                        type: "doughnut",
                        data: {
                            labels: productNames,
                            datasets: [{
                                label: "Product Quantity",
                                data: quantities,

                                hoverOffset: 5
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
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
                text: e.message,
                header: "Error",
                duration: 30000,
                closable: false,
                type: "danger"
            })
        }
    }


    window.addEventListener("load", showProductQuantityChart)
}