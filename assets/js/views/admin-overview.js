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

import Notifier from "../components/Notifier";
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

const employeeCountCanvas = document.querySelector("#employee-count-canvas");
console.log(employeeCountCanvas)

const orderStatusCanvas = document.querySelector('#orderstatus-revenue-canvas')
console.log(orderStatusCanvas);

if(employeeCountCanvas){
    async function showEmployeeCountChart() {
        try {

            const result = await fetch("/overview/employee-count")
            // console.log(await result.text())
            // return

            switch (result.status) {
                case 200:
                    /**
                     * @type {{data:{product_name:string, tot_quantity:number}[]}}
                     */
                    const resData = await result.json()
                    console.log(resData)

                    const jobRolles = resData.data.map(
                        item => item.JobRole
                    )

                    const counts = resData.data.map(
                        item => item.count
                    )

                    

                    const employeeCountChart = new Chart(employeeCountCanvas, {
                        type: "doughnut",
                        data: {
                            labels: jobRolles,
                            datasets: [{
                                label: "Employee Count",
                                data: counts,

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
                    // const totalCount = counts.reduce((acc, curr) => acc + curr, 0);
                    // console.log(totalCount);
                    // updateTotalCount(totalCount);

                    // function updateTotalCount(totalCount) {
                    //     const totalCountContainer = document.getElementById("totalCountContainer");
                    //     totalCountContainer.innerHTML = `Total count: ${totalCount}`;
                    // }
            }

        } 
        catch (e) {
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
    window.addEventListener("load", showEmployeeCountChart)
}


if(orderStatusCanvas){
    async function showOrderStatus(){
        try{
            const result = await fetch("/overview/order-status")
            console.log(result)
            switch(result.status){
                case 200:
                    const resData = await result.json()
                    console.log(resData)

                    const Status = resData.data.map(
                        item => item.status
                    )

                    const Count = resData.data.map(
                        item => item.COUNT
                    )

                    // console.log(Status)
                    // console.log(Count)

                    const orderstatusChart = new Chart(orderStatusCanvas, {
                        type: "doughnut", data: {
                            labels: Status, datasets: [{
                                label: "Order Status", 
                                data: Count,
                                backgroundColor:[
                                    'rgb(0, 255, 0)',
                                    'rgb(255, 0, 0)',
                                    'rgb(255, 255, 0)'

                                ],
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
    window.addEventListener("load", showOrderStatus)
}