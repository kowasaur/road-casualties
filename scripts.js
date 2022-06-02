function toggleShowPassword() {
    const checkbox = document.getElementById("password");
    checkbox.type = checkbox.type === "password" ? "text" : "password";
}

const DATA_CONSTS = { fill: false, tension: 0.1 };

function createChart(id, data1, key1, labels, group, type, data2, key2) {
    const ctx = document.getElementById(id);
    const datasets = [
        {
            ...DATA_CONSTS,
            label: key1,
            data: data1,
            borderColor: "#017EF1", // for line chart
            backgroundColor: "#017EF1", // for bar chart
        },
    ];
    if (data2 !== undefined)
        datasets.push({
            ...DATA_CONSTS,
            label: key2,
            data: data2,
            borderColor: "#EB3734",
            backgroundColor: "#EB3734",
        });

    new Chart(ctx, {
        type,
        data: { labels, datasets },
        options: {
            scales: {
                x: { title: { display: true, text: group } },
                y: {
                    beginAtZero: true,
                    title: { display: true, text: "Road Casualties" },
                },
            },
        },
    });
}
