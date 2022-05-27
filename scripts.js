function toggleShowPassword() {
    const checkbox = document.getElementById("password");
    checkbox.type = checkbox.type === "password" ? "text" : "password";
}

function createChart(id, data, labels, group, type = "bar") {
    const ctx = document.getElementById(id);
    new Chart(ctx, {
        type,
        data: {
            labels,
            datasets: [
                {
                    label: "Crash Casualties",
                    data,
                    fill: false,
                    borderColor: "#017EF1", // for line chart
                    backgroundColor: "#017EF1", // for bar chart
                    tension: 0.1,
                },
            ],
        },
        options: {
            plugins: {
                legend: {
                    // TODO: Change to true
                    display: false,
                },
            },
            scales: {
                x: { title: { display: true, text: group } },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Road Casualties",
                    },
                },
            },
        },
    });
}
