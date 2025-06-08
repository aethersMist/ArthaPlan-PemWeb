import "./bootstrap";
import Chart from "chart.js/auto";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Bar Chart - Dash
document.addEventListener("DOMContentLoaded", function () {
    let barChart;

    function initChart(labels, dataOut, dataIn) {
        const ctx = document.getElementById("barChartCanvas").getContext("2d");

        if (barChart) {
            barChart.destroy();
        }

        barChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Pemasukan",
                        data: dataIn,
                        backgroundColor: "#285539",
                        borderRadius: 8,
                        barThickness: 20,
                    },
                    {
                        label: "Pengeluaran",
                        data: dataOut,
                        backgroundColor: "#f87171",
                        borderRadius: 8,
                        barThickness: 20,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return "Rp" + value.toLocaleString("id-ID");
                            },
                        },
                    },
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return (
                                    context.dataset.label +
                                    ": Rp" +
                                    context.raw.toLocaleString("id-ID")
                                );
                            },
                        },
                    },
                    legend: {
                        position: "top",
                        labels: {
                            usePointStyle: true,
                            pointStyle: "rectRounded",
                        },
                    },
                },
            },
        });
    }

    // Ambil data dari atribut data-canvas
    const canvas = document.getElementById("barChartCanvas");
    const labels = JSON.parse(canvas.getAttribute("data-labels"));
    const dataOut = JSON.parse(canvas.getAttribute("data-data-out"));
    const dataIn = JSON.parse(canvas.getAttribute("data-data-in"));

    // Inisialisasi chart pertama kali
    if (labels.length > 0) {
        initChart(labels, dataOut, dataIn);
    }
    // Handle filter change
    document.querySelectorAll("[data-filter]").forEach((button) => {
        button.addEventListener("click", function () {
            const filter = this.getAttribute("data-filter");

            // Update URL dengan parameter filter
            const url = new URL(window.location.href);
            url.searchParams.set("filter", filter);
            window.location.href = url.toString();
        });
    });

    // Inisialisasi chart pertama kali
    if (initialLabels.length > 0) {
        initChart(initialLabels, initialDataOut, initialDataIn);
    }

    // Fungsi untuk mengambil data terbaru dari server
    async function fetchChartData() {
        const urlParams = new URLSearchParams(window.location.search);
        const filter = urlParams.get("filter") || "monthly";
        const date =
            urlParams.get("date") || new Date().toISOString().split("T")[0];

        try {
            const response = await fetch(
                `/dashboard/chart-data?filter=${filter}&date=${date}`
            );
            const data = await response.json();

            if (data.labels && data.labels.length > 0) {
                initChart(data.labels, data.dataOut, data.dataIn);
            }
        } catch (error) {
            console.error("Error fetching chart data:", error);
        }
    }

    // Setup polling untuk update realtime (setiap 5 detik)
    setInterval(fetchChartData, 5000);

    // Handle filter change
    document.querySelectorAll("[data-filter]").forEach((button) => {
        button.addEventListener("click", function () {
            const filter = this.getAttribute("data-filter");
            const url = new URL(window.location.href);
            url.searchParams.set("filter", filter);
            window.location.href = url.toString();
        });
    });

    // Handle perubahan tanggal
    const dateFilter = document.getElementById("dateFilter");
    dateFilter.addEventListener("change", function () {
        const url = new URL(window.location.href);
        url.searchParams.set("date", this.value);
        window.location.href = url.toString();
    });

    document.addEventListener("DOMContentLoaded", function () {
        function updateWaktu() {
            const sekarang = new Date();
            const options = {
                weekday: "long",
                day: "numeric",
                month: "long",
                year: "numeric",
                timeZone: "Asia/Jakarta",
            };

            document.getElementById("tanggal-terpilih").textContent =
                sekarang.toLocaleDateString("id-ID", options);
        }

        // Update setiap detik
        updateWaktu();
        setInterval(updateWaktu, 1000);
    });
});

// Donat Chart Anggaran(Dash)
document.addEventListener("DOMContentLoaded", function () {
    const ctxContainer = document.getElementById("donutChartPersen");

    if (!ctxContainer) return;

    // Ambil data dari atribut data-sisa dan data-pakai (string -> number)
    const persenSisa = Number(ctxContainer.getAttribute("data-sisa")) || 100;
    const persenPakai = Number(ctxContainer.getAttribute("data-pakai")) || 0;

    // Buat canvas dan atur ukuran kecil
    const canvas = document.createElement("canvas");
    canvas.width = 200;
    canvas.height = 200;
    ctxContainer.appendChild(canvas);

    const ctx = canvas.getContext("2d");

    const data = {
        labels: ["Sisa", "Terpakai"],
        datasets: [
            {
                label: "Persentase Anggaran",
                data: [persenSisa, persenPakai],
                backgroundColor: ["#88cf0f", "#285539"],
                borderColor: ["#ffffff", "#ffffff"],
                borderWidth: 2,
            },
        ],
    };

    const config = {
        type: "doughnut",
        data: data,
        options: {
            responsive: false,
            maintainAspectRatio: false,
            cutout: "70%",
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return `${tooltipItem.label}: ${tooltipItem.raw}%`;
                        },
                    },
                },
            },
        },
    };

    new Chart(ctx, config);
});

// Laporan - Dash - Income
document.addEventListener("DOMContentLoaded", function () {
    const pieContainer = document.getElementById("pie-chart-Income");
    if (!pieContainer) return;

    // Ambil data dari data-attributes
    const rawCategories = pieContainer.dataset.categories;
    const rawValues = pieContainer.dataset.values;

    let categories = [];
    let values = [];

    if (!rawCategories || !rawValues) {
        categories = ["Belum Ada Data"];
        values = [1];
    } else {
        try {
            categories = JSON.parse(rawCategories);
            values = JSON.parse(rawValues);

            // Cek apakah array kosong atau semua nilainya 0
            if (values.length === 0 || values.every((v) => v === 0)) {
                categories = ["Belum Ada Data"];
                values = [1];
            }
        } catch (e) {
            console.error("JSON parse error:", e);
            categories = ["Belum Ada Data"];
            values = [1];
        }
    }

    // Buat canvas
    const canvas = document.createElement("canvas");
    canvas.width = 200;
    canvas.height = 200;
    pieContainer.appendChild(canvas);
    const ctx = canvas.getContext("2d");

    // Warna background
    const colors = [
        "#285539",
        "#88cf0f",
        "#00bfa6",
        "#ff9f1c",
        "#2979ff",
        "#ff4081",
    ];
    const backgroundColors = categories.map(
        (_, index) => colors[index % colors.length]
    );

    // Pie Chart Config
    new Chart(ctx, {
        type: "pie",
        data: {
            labels: categories,
            datasets: [
                {
                    label: "Pemasukan per Kategori",
                    data: values,
                    backgroundColor: backgroundColors,
                    borderColor: "#fff",
                    borderWidth: 2,
                },
            ],
        },
        options: {
            responsive: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const label = context.label || "";
                            const value = context.parsed || 0;
                            return `${label}: Rp ${value.toLocaleString(
                                "id-ID"
                            )}`;
                        },
                    },
                },
            },
        },
    });

    // LEGEND DASHBOARD
    const legendContainer = document.getElementById("legend-Dashboard");
    if (legendContainer) {
        legendContainer.innerHTML = "";

        categories.forEach((category, i) => {
            const color = backgroundColors[i];

            const legendItem = document.createElement("li");
            legendItem.className =
                "flex items-center transition hover:scale-105 mb-1";

            const colorBox = document.createElement("span");
            colorBox.className = "w-3 h-3 rounded-full mr-2";
            colorBox.style.backgroundColor = color;

            const label = document.createTextNode(category);

            legendItem.appendChild(colorBox);
            legendItem.appendChild(label);
            legendContainer.appendChild(legendItem);
        });
    }

    // LEGEND REPORT
    const legendContainerReport = document.getElementById("legend-Report");

    if (legendContainerReport) {
        legendContainerReport.innerHTML = "";

        const totalValue = values.reduce((a, b) => a + b, 0) || 1;

        categories.forEach((category, i) => {
            const value = values[i];
            const percentage = ((value / totalValue) * 100).toFixed(2);
            const color = backgroundColors[i];

            const li = document.createElement("li");

            const topWrapper = document.createElement("div");
            topWrapper.className =
                "flex justify-between items-center w-full text-sm font-semibold text-dark mb-1";

            const left = document.createElement("div");
            left.className = "flex items-center gap-2";

            const label = document.createElement("span");
            label.textContent = category;

            left.appendChild(label);

            const nominal = document.createElement("p");
            nominal.textContent = "Rp " + value.toLocaleString("id-ID");

            topWrapper.appendChild(left);
            topWrapper.appendChild(nominal);

            // Progress bar
            const progressBg = document.createElement("div");
            progressBg.className = "w-full bg-gray-300 rounded-full h-2";

            const progressFill = document.createElement("div");
            progressFill.className = "h-2 rounded-full";
            progressFill.style.backgroundColor = color;
            progressFill.style.width = percentage + "%";

            progressBg.appendChild(progressFill);

            li.appendChild(topWrapper);
            li.appendChild(progressBg);

            legendContainerReport.appendChild(li);
        });
    }
});

// Laporan - Outcome
document.addEventListener("DOMContentLoaded", function () {
    const pieContainerOut = document.getElementById("pie-chart-Outcome");
    if (!pieContainerOut) return;

    // Ambil data dari data-attributes (pastikan pakai tanda - di HTML!)
    const rawCategories = pieContainerOut.getAttribute("data-categories-out");
    const rawValues = pieContainerOut.getAttribute("data-values-out");

    let categoriesOut = [];
    let valuesOut = [];

    if (!rawCategories || !rawValues) {
        categoriesOut = ["Belum Ada Data"];
        valuesOut = [1];
    } else {
        try {
            categoriesOut = JSON.parse(rawCategories);
            valuesOut = JSON.parse(rawValues);

            if (valuesOut.length === 0 || valuesOut.every((v) => v === 0)) {
                categoriesOut = ["Belum Ada Data"];
                valuesOut = [1];
            }
        } catch (e) {
            console.error("JSON parse error:", e);
            categoriesOut = ["Belum Ada Data"];
            valuesOut = [1];
        }
    }

    // Buat canvas
    const canvas = document.createElement("canvas");
    canvas.width = 200;
    canvas.height = 200;
    pieContainerOut.appendChild(canvas);
    const ctx = canvas.getContext("2d");

    // Warna background
    const colors = [
        "#f87171",
        "#ff9f1c",
        "#ff4081",
        "#2979ff",
        "#ef4444",
        "#991b1b",
    ];
    const backgroundColors = categoriesOut.map(
        (_, index) => colors[index % colors.length]
    );

    // Pie Chart Config
    new Chart(ctx, {
        type: "pie",
        data: {
            labels: categoriesOut,
            datasets: [
                {
                    label: "Pengeluaran per Kategori",
                    data: valuesOut,
                    backgroundColor: backgroundColors,
                    borderColor: "#fff",
                    borderWidth: 2,
                },
            ],
        },
        options: {
            responsive: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const label = context.label || "";
                            const value = context.parsed || 0;
                            return `${label}: Rp ${value.toLocaleString(
                                "id-ID"
                            )}`;
                        },
                    },
                },
            },
        },
    });

    // LEGEND REPORT
    const legendContainerReport = document.getElementById(
        "legend-Report-Outcome"
    );

    if (legendContainerReport) {
        legendContainerReport.innerHTML = "";

        const totalValue = valuesOut.reduce((a, b) => a + b, 0) || 1;

        categoriesOut.forEach((category, i) => {
            const value = valuesOut[i];
            const percentage = ((value / totalValue) * 100).toFixed(2);
            const color = backgroundColors[i];

            const li = document.createElement("li");

            const topWrapper = document.createElement("div");
            topWrapper.className =
                "flex justify-between items-center w-full text-sm font-semibold text-dark mb-1";

            const left = document.createElement("div");
            left.className = "flex items-center gap-2";

            const label = document.createElement("span");
            label.textContent = category;

            left.appendChild(label);

            const nominal = document.createElement("p");
            nominal.textContent = "Rp " + value.toLocaleString("id-ID");

            topWrapper.appendChild(left);
            topWrapper.appendChild(nominal);

            const progressBg = document.createElement("div");
            progressBg.className = "w-full bg-gray-300 rounded-full h-2";

            const progressFill = document.createElement("div");
            progressFill.className = "h-2 rounded-full";
            progressFill.style.backgroundColor = color;
            progressFill.style.width = percentage + "%";

            progressBg.appendChild(progressFill);

            li.appendChild(topWrapper);
            li.appendChild(progressBg);

            legendContainerReport.appendChild(li);
        });
    }
});

// Line Chart - Outcome
