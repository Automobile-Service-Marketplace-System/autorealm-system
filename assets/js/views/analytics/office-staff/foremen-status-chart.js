var ctx = document.getElementById("foremen-status-canvas").getContext("2d");

var chart = new Chart(ctx, {
  type: "bar",
  data: {
    labels: ["New", "In Progress", "Completed", "Finished"],
    datasets: [
      {
        label: "Foreman 1",
        backgroundColor: "rgba(255, 99, 132, 0.5)",
        data: [5, 2, 10, 3],
      },
      {
        label: "Foreman 2",
        backgroundColor: "rgba(54, 162, 235, 0.5)",
        data: [3, 8, 6, 4],
      },
      {
        label: "Foreman 3",
        backgroundColor: "rgba(255, 206, 86, 0.5)",
        data: [7, 4, 3, 9],
      },
    ],
  },
  options: {
    scales: {
      xAxes: [
        {
          stacked: true,
        },
      ],
      yAxes: [
        {
          stacked: true,
        },
      ],
    },
  },
});
