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